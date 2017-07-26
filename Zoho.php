<?php
/*
Plugin Name: Zoho Invoice
Plugin URI: http://www.andersonloyola.com.br
Description: Plugin criado com a função de sincronizar os clientes do Zoho Invoice com os Usuários do WordPress.
Author: Anderson Loyola
Version: 0.1beta
Author URI: http://www.andersonloyola.com.br
*/

include('ZohoConf.php');

/**
 * Zoho Invoice
 * 
 * @author      Anderson Loyola <andercrist@gmail.com>
 * @copyright   2010-2010 Anderson Loyola
 * @version     Zoho.php,v 0.1 28/05/2010
 * @link        http://www.andersonloyola.com.br/ 
 * @Deus é o Senhor
 */ 
 
class Zoho {

	private static $wpdb;
	private static $info;
	var $msg = null;

	/**
	 * Função de inicialização, centraliza a definição de filtros/ações
	 *
	 */
	public static function inicializar(){
		global $wpdb, $user_ID;		 
		add_action('admin_menu', array('Zoho','zohoMenuAdmin'));
		add_action('show_user_profile', array('Zoho','action_show_user_profile'));
		add_action('edit_user_profile', array('Zoho','action_show_user_profile'));
		add_action('personal_options_update', array('Zoho','action_process_option_update'));
		add_action('edit_user_profile_update', array('Zoho','action_process_option_update'));
		add_action("admin_print_scripts", array('Zoho', 'js_libs'));
	  add_action("admin_print_styles", array('Zoho', 'style_libs'));     
	 
		
		//Mapear objetos WP
		Zoho::$wpdb = $wpdb;
		
		//Outros mapeamentos
		Zoho::$info['plugin_fpath'] = dirname(__FILE__); 		
	}
	
	
	
	
	function action_show_user_profile($user) {
		
		if ($user->roles[0] == 'subscriber') {
			$customerID = get_usermeta( $user->ID, 'zoho_customer_CustomerID' );
			//Se o usuário está associado a um cliente Zoho Mostra os dados
			if (!empty($customerID)) {
				$zoho = new ZohoCustomer();
				$zoho->loadLocal($user->ID);
				//Verifica a sincronia dos dados
				if (!$zoho->verificarSinc()) {
					update_usermeta( $user->ID, 'zoho_customer_VSinc', true );
				} else {
					update_usermeta( $user->ID, 'zoho_customer_VSinc', false );
				}					
				$envio = get_usermeta( $user->ID, 'zoho_customer_ShippingAddress' );
				if (!empty($envio)) {			
					$tpl['{ENVIOCKECK}'] = 'CHECKED';
					$tpl['{ENVIOSCRIPT}'] = "<script type='text/javascript'>jQuery('#zohoenvio').toggle();</script>";			
				} else {
					$tpl['{ENVIOCKECK}'] = '';
					$tpl['{ENVIOSCRIPT}'] = '';				
				}
				$tpl['{Name}'] = esc_attr(get_usermeta( $user->ID, 'zoho_customer_Name' ) );
				$tpl['{Phone}'] = esc_attr(get_usermeta( $user->ID, 'zoho_customer_Phone' ) );
				$tpl['{Mobile}'] = esc_attr(get_usermeta( $user->ID, 'zoho_customer_Mobile' ) );
				$tpl['{BillingAddress}'] = esc_attr(get_usermeta( $user->ID, 'zoho_customer_BillingAddress' ) );
				$tpl['{BillingCity}'] = esc_attr(get_usermeta( $user->ID, 'zoho_customer_BillingCity' ) );
				$tpl['{BillingState}'] = esc_attr(get_usermeta( $user->ID, 'zoho_customer_BillingState' ) );
				$tpl['{BillingZip}'] = esc_attr(get_usermeta( $user->ID, 'zoho_customer_BillingZip' ) );
				$tpl['{BillingCountry}'] = esc_attr(get_usermeta( $user->ID, 'zoho_customer_BillingCountry' ) );
				$tpl['{BillingFax}'] = esc_attr(get_usermeta( $user->ID, 'zoho_customer_BillingFax' ) );

				$tpl['{ShippingAddress}'] = esc_attr(get_usermeta( $user->ID, 'zoho_customer_ShippingAddress' ) );
				$tpl['{ShippingCity}'] = esc_attr(get_usermeta( $user->ID, 'zoho_customer_ShippingCity' ) );
				$tpl['{ShippingState}'] = esc_attr(get_usermeta( $user->ID, 'zoho_customer_ShippingState' ) );
				$tpl['{ShippingZip}'] = esc_attr(get_usermeta( $user->ID, 'zoho_customer_ShippingZip' ) );
				$tpl['{ShippingCountry}'] = esc_attr(get_usermeta( $user->ID, 'zoho_customer_ShippingCountry' ) );
				$tpl['{ShippingFax}'] = esc_attr(get_usermeta( $user->ID, 'zoho_customer_ShippingFax' ) );
				$tpl['{PaymentsDue}'] = ZohoCustomer::getPaymentsDueSelect(esc_attr(get_usermeta( $user->ID, 'zoho_customer_PaymentsDue' ) ), 1);
				$tpl['{Salutation}'] = ZohoCustomer::getSalutationSelect(esc_attr(get_usermeta( $user->ID, 'zoho_customer_Salutation' ) ), 1);
				
				$VSinc = get_usermeta( $user->ID, 'zoho_customer_VSinc' );
				
				if ($VSinc) {
					$formSinc = '';
					if (current_user_can('edit_users')) {
						$formSinc = '<br />
								
								<br />
								<input name="sinc" id="sinc" value="1" type="RADIO"> Deseja sincronizar agora? <br />
								<input name="sinc" id="sinc" value="2" type="RADIO"> Deseja cancelar agora?<br />
								<input class="button-primary" value="Sincronizar ou Cancelar" name="submit" type="submit">
								';
								$erros = get_usermeta( $user->ID, 'zoho_customer_Erros' );
								echo self::messageBox('Atualização Zoho','As alterações deste cliente ainda não foram aprovadas pelo administrador e não está sincronizado com os dados cadastrados no zoho.' . $formSinc . '<br /><center style="color:red;">' . $erros . '</center>' );
					} else {						
						echo self::messageBox('Atualização Zoho','As alterações deste cliente ainda não foram aprovadas pelo administrador e não está sincronizado com os dados cadastrados no zoho.','OK');
					}				
	
				}
				
				//Ler arquivo de template usando funções do WP
				$admTplObj = new FileReader(Zoho::$info['plugin_fpath']."/tpl/zohoProfile.tpl");

			} else {
				//Caso não esteja associado selecionar um cliente do zoho para associar ou não
				$zoho = new ZohoCustomer();
				$tpl['{SELECT}'] = $zoho->getAllCustomerNameSelect(Zoho::$wpdb);				
				//Ler arquivo de template usando funções do WP
				$admTplObj = new FileReader(Zoho::$info['plugin_fpath']."/tpl/zohoAssociacao.tpl");				
								
			}
				
				$admTpl = $admTplObj->read($admTplObj->_length);
		
				//Substituir variáveis no template		
				$admTpl = strtr($admTpl,$tpl);
		
				echo $admTpl;									
			
		}
		
    }
    
    
    function action_process_option_update($user_id) {
  
    	if (isset($_POST['CustomerID'])) {
    		if (!empty($_POST['CustomerID'])) {    				 	 	 
    			$zoho = new ZohoCustomerDetails();
    			$zoho = $zoho->load($_POST['CustomerID']);  			
				 if ($zoho->getContacts() > 0) {
					 //Pega o contato
					 $contact = $zoho->getContacts();
					 //Verifica se o contato possui email se possuir...
					 if (!empty($contact['Contact1']['EMail'])) {  
						 //Verifica se o email existe Cadastrado no WordPress caso não possua...
						 if (!email_exists($contact['Contact1']['EMail'])) {
							 $zoho->updateLocal($user_id);
						 }
					 }
				 }	     			  	 	 	 	     				
    				
    		}
    			
    		
    	} else {
    		$zoho = new ZohoCustomer;
		
    		$zoho->loadLocal($user_id);
    		$zoho->setName((isset($_POST['Name']) ? $_POST['Name'] : ''));
    		$zoho->setPaymentsDue((isset($_POST['PaymentsDue']) ? $_POST['PaymentsDue'] : ''));
    		
    		
    		$zoho->setBillingAddress((isset($_POST['BillingAddress']) ? $_POST['BillingAddress'] : ''));
    		$zoho->setBillingCity((isset($_POST['BillingCity']) ? $_POST['BillingCity'] : ''));
    		$zoho->setBillingState((isset($_POST['BillingState']) ? $_POST['BillingState'] : ''));
    		$zoho->setBillingZip((isset($_POST['BillingZip']) ? $_POST['BillingZip'] : ''));
    		$zoho->setBillingCountry((isset($_POST['BillingCountry']) ? $_POST['BillingCountry'] : ''));
    		$zoho->setBillingFax((isset($_POST['BillingFax']) ? $_POST['BillingFax'] : ''));
    		
		
    		$zoho->setShippingAddress((isset($_POST['ShippingAddress']) ? $_POST['ShippingAddress'] : ''));
    		$zoho->setShippingCity((isset($_POST['ShippingCity']) ? $_POST['ShippingCity'] : ''));
    		$zoho->setShippingState((isset($_POST['ShippingState']) ? $_POST['ShippingState'] : ''));
    		$zoho->setShippingZip((isset($_POST['ShippingZip']) ? $_POST['ShippingZip'] : ''));
    		$zoho->setShippingCountry((isset($_POST['ShippingCountry']) ? $_POST['ShippingCountry'] : ''));
    		$zoho->setShippingFax((isset($_POST['ShippingFax']) ? $_POST['ShippingFax'] : ''));
		
    		$zoho->setNotes((isset($_POST['description']) ? $_POST['description'] : ''));
		
    		$contacts = $zoho->getContacts();
    		$contacts['Contact1']['Salutation'] = (isset($_POST['Salutation']) ? $_POST['Salutation'] : '');
    		$contacts['Contact1']['FirstName'] = (isset($_POST['first_name']) ? $_POST['first_name'] : '');
    		$contacts['Contact1']['LastName'] = (isset($_POST['last_name']) ? $_POST['last_name'] : '');
    		$contacts['Contact1']['EMail'] = (isset($_POST['email']) ? $_POST['email'] : '');
    		$contacts['Contact1']['Phone'] = (isset($_POST['Phone']) ? $_POST['Phone'] : '');
    		$contacts['Contact1']['Mobile'] = (isset($_POST['Mobile']) ? $_POST['Mobile'] : '');
    		$sinc = (isset($_POST['sinc']) ? $_POST['sinc'] : 0);
    		
    		$zoho->setContacts($contacts);

    		if ($sinc == 1) {
    			//Envia os dados para o Zoho
    			$zoho->updateWeb();    			
    			$retorno = $zoho->getErro();
    			if (is_null($retorno)) {    
    				//Atualiza localmente
    				$zoho->updateLocal($user_id);
    				//Salva erros
    				update_usermeta( $user_id, 'zoho_customer_Erros', '' );
    			} else {
    				update_usermeta( $user_id, 'zoho_customer_Erros', esc_attr( $retorno ) );    					
    			}
    			
    		} else if ($sinc == 2) {   
    			//Restaura os dados do Zoho
    			$zoho = new ZohoCustomerDetails();
    			$zoho = $zoho->load(get_usermeta($user_id, 'zoho_customer_CustomerID'));
    			$zoho->updateLocal($user_id);
    		} else {
    			//Salva normalmente e verifica a Sincronizacao
    			$zoho->updateLocal($user_id);
    		}
    		

    		
    	}
    	
		

		
		
    	//update_usermeta($user_id, 'zoho_customer_Name', ( isset($_POST['Name']) ? $_POST['Name'] : '' ) );
    }


	
	/**
	 * Função para criar o Menu de Configurações no WordPress
	 *
	 */
	public static function zohoMenuAdmin() {
		add_menu_page( 'Zoho Invoice', 'Zoho Invoice', 6, __FILE__, array("Zoho","zohoInvoice") );
		add_submenu_page(__FILE__, 'Configurações', 'Configurações', 6, 'Configurações', array("Zoho","zohoConfig"));
		add_submenu_page(__FILE__, 'clientes_sin', 'Clientes para Sincronizar', 6, 'clientes_sin', array("Zoho","zohoCustomerSinc"));
		add_submenu_page(__FILE__, 'clientes_imp', 'Clientes para Importar', 6, 'clientes_imp', array("Zoho","zohoCustomerImport"));		
	}
	
	/** 
	 * Função para tratar o TPL zohoConfig.tpl e imprimir o HTML
	 */
	public static function zohoConfig() {
		
		?>
		<script type='text/javascript' src='<?php trailingslashit(get_option('siteurl'));?>wp-includes/js/jquery/jquery.js?ver=1.2.3'></script>
		<script type='text/javascript' src='<?php trailingslashit(get_option('siteurl'));?>wp-admin/js/common.js?ver=20080318'></script>
		<?php
		$templateVars['{UPDATED}'] = "";
		$erro = null;
		
		//Executar operações definidas
		if (count($_POST) > 0){
			if ($_POST['submit'] == 'Adicionar') {
				$erro = (strlen($_POST['apikey']) == 32) ? null : 'Insira uma APIKEY válida!';
				if (is_null($erro))
					$erro = (strlen($_POST['usuario']) > 0) ? null : 'Digite um usuário!';
				if (is_null($erro))
					$erro = (strlen($_POST['senha']) > 0) ? null : 'Digite uma senha!';
		
				if (is_null($erro)) {
					update_option("zoho_texto_apikey",$_POST['apikey']);
					update_option("zoho_texto_login",$_POST['usuario']);
					update_option("zoho_texto_senha",$_POST['senha']);								
					$zoho = new ZohoAPI(true);
					$erro = $zoho->getErro();
				}
			
			
				$templateVars['{UPDATED}'] = '<div id="message" class="updated fade"><p><strong>';
				if (is_null($erro)) {
					$templateVars['{UPDATED}'] .= "Dados atualizados!";				
				} else {
					$templateVars['{UPDATED}'] .= $erro;				
				}
				$templateVars['{UPDATED}'] .= "</strong></p></div>";
			}	

			
		}
		
		
		
		$templateVars['{APIKEY}'] = get_option("zoho_texto_apikey");
		$templateVars['{USUARIO}'] = get_option("zoho_texto_login");
		$templateVars['{SENHA}'] = get_option("zoho_texto_senha");
		$templateVars['{TICKET}'] = get_option("zoho_texto_ticket");
		$templateVars['{DATA}'] = get_option("zoho_texto_data");		
		
		
		//Ler arquivo de template usando funções do WP
		$admTplObj = new FileReader(Zoho::$info['plugin_fpath']."/tpl/zohoConfig.tpl");
		$admTpl = $admTplObj->read($admTplObj->_length);
		
		//Substituir vari�veis no template		
		$admTpl = strtr($admTpl,$templateVars);
		
		echo $admTpl;		
	}
	
	public static function zohoCustomerSinc() {
		
		if (isset($_POST['doaction1']) || isset($_POST['doaction2'])) {
			$users = $_POST['users'];
			if (count($users) > 0) {
					$action = (!empty($_POST['action1']) && empty($_POST['action2'])) ? $_POST['action1'] : null;
					$action = (empty($_POST['action1']) && !empty($_POST['action2']) && is_null($action)) ? $_POST['action2'] : $action;					
					if ($action == 1) {
						foreach ($users as $user_id) {
							$zoho = new ZohoCustomer;
							$zoho->loadLocal($user_id);
							//Envia os dados para o Zoho
							$zoho->updateWeb();    										
							$retorno = $zoho->getErro();
							if (is_null($retorno)) {    
								//Atualiza localmente
								$zoho->updateLocal($user_id);
								//Salva erros
								update_usermeta( $user_id, 'zoho_customer_Erros', '' );
							} else {
								update_usermeta( $user_id, 'zoho_customer_Erros', esc_attr( $retorno ) );    					
							}    		
							$erro .= $zoho->getErro() . '<br />';
						}
					} else if ($action == 2) {
						foreach ($users as $user_id) {
							//Restaura os dados do Zoho
							$zoho = new ZohoCustomerDetails();
							$zoho = $zoho->load(get_usermeta($user_id, 'zoho_customer_CustomerID'));
							$zoho->updateLocal($user_id);
							$erro = $zoho->getErro() . '<br />';
						}
						
					} 
			}
			
		}
		if ($erro) {
			$tpl['{MSG}'] = $erro;
		} else {
			$tpl['{MSG}'] = '';
		}

		// Lista de Usuários que nao estao sincronizados
		//Busca todos os usuarios 
		$wp_user_search = new WP_User_Search(null, null, 'subscriber');
		$count = 0;
		//Caso tenha retorno 
		if ( $wp_user_search->get_results() ) { 
			//$tpl['{VOLTAR}'] = ( $wp_user_search->is_search() )  ? '<p><a href="users.php">'._e('&larr; Back to All Users').'</a></p>' : ''; 			
			$style = '';
				foreach ( $wp_user_search->get_results() as $userid ) {
					$VSinc = get_usermeta( $userid, 'zoho_customer_VSinc' );
						if ($VSinc) {							
							$user_object = new WP_User($userid);
							$roles = $user_object->roles;
							$role = array_shift($roles);

							$style = ( ' class="alternate"' == $style ) ? '' : ' class="alternate"';
							$lista .= "\n\t" . user_row($user_object, $style, $role);
							$count++;
						}
				} 				
			$tpl['{LISTA}'] = $lista;			

			$tpl['{NAV}'] = ( $wp_user_search->results_are_paged() )  ? '<div class="tablenav-pages">' . $wp_user_search->page_links() . '</div>' : '';			
		}
		//Caso tenha algum cliente sem sincronismo imprime o template
		if ($count > 0) {
			//Ler arquivo de template usando funções do WP
			$admTplObj = new FileReader(Zoho::$info['plugin_fpath']."/tpl/zohoListaSinc.tpl");
			$admTpl = $admTplObj->read($admTplObj->_length);		
			//Substituir variáveis no template		
			$admTpl = strtr($admTpl,$tpl);				
			echo $admTpl;
		} else {
			$tpl['{LISTA}'] = '<tr><td colspan="6">Nenhum cliente necessita de sincronia.</td></tr>';
			$tpl['{NAV}'] = '';
			//Ler arquivo de template usando funções do WP
			$admTplObj = new FileReader(Zoho::$info['plugin_fpath']."/tpl/zohoListaSinc.tpl");
			$admTpl = $admTplObj->read($admTplObj->_length);		
			//Substituir variáveis no template		
			$admTpl = strtr($admTpl,$tpl);				
			echo $admTpl;			
		}

	}
	
	public static function zohoCustomerImport() {
		$erro = '';
		if (isset($_REQUEST['CustomerID'])) {
			$Customers = $_REQUEST['CustomerID'];
			if (is_array($Customers)) {
				foreach ($Customers as $CustomerID) {
					$zoho = new ZohoCustomerDetails();
					$zoho->load($CustomerID);
					$zoho->saveImport();
					$erro .= $zoho->getErro() . '<br />';					
				}
			} else if (!empty($Customers)){
					$zoho = new ZohoCustomerDetails();
					$zoho->load($Customers);	
					$zoho->saveImport();
					$erro = $zoho->getErro();
				
			}
		}
		
		$templateVars['{MSG}'] = $erro;			
		$customer = new ZohoCustomer();
		$lista = $customer->getImportAllCustomers(Zoho::$wpdb,$_GET['pagina']);
		$templateVars['{LISTA}'] = $lista['lista'];
		$templateVars['{NAV}'] = $lista['paginacao'];
		
		//Ler arquivo de template usando funções do WP
		$admTplObj = new FileReader(Zoho::$info['plugin_fpath']."/tpl/zohoListaImport.tpl");
		$admTpl = $admTplObj->read($admTplObj->_length);
		
		//Substituir variáveis no template		
		$admTpl = strtr($admTpl,$templateVars);

		echo $admTpl;		
	}
	
  public function js_libs() {
  	wp_enqueue_script('jquery');
    wp_enqueue_script('thickbox');
  }
	 
	public function style_libs() {
		wp_enqueue_style('thickbox');
	}

	
	
	/**
	 * Função para tratar o TPL e imprimir o HTML
	 */
	public static function zohoInvoice() {		
		//Ler arquivo de template usando funções do WP
		$admTplObj = new FileReader(Zoho::$info['plugin_fpath']."/tpl/zohoInvoice.tpl");
		$admTpl = $admTplObj->read($admTplObj->_length);		
		echo $admTpl;
		
	}
	
	/**
	 * Função para criação da tabela para armazenar a data, ticket, apikey, login, senha  
	 *
	 */
	public static function instalarConf() {
		//Adicionar Opções		
		add_option("zoho_texto_apikey","");
		add_option("zoho_texto_ticket","");
		add_option("zoho_texto_login","");
		add_option("zoho_texto_senha","");
		add_option("zoho_texto_data","");
		
		if ( is_null(Zoho::$wpdb) ) Zoho::inicializar();
		
		//Criar base de dados
		$sqlMedia = "CREATE  TABLE IF NOT EXISTS `".Zoho::$wpdb->prefix."zoho_media` (
							`id` INT NOT NULL AUTO_INCREMENT ,
  							`EstimateID` VARCHAR(100) ,
  							`post_id` INT NULL ,
  						PRIMARY KEY (`id`) )";
  		Zoho::$wpdb->query($sqlMedia); 
  	
	}
	
	
	/**
	 * Função de instalação, ao ativar o plugin esta função é chamada
	 *
	 */
	public static function instalar(){
		//Tabela de Configuração
		Zoho::instalarConf();
	}	
	
	/**
	 * Esta função remove tracos de uma instalação deste plugin, removendo
	 * as tabelas e dados da base de dados
	 *
	 */
	public static function desinstalar(){
		
		//Remover opções
		delete_option("zoho_texto_apikey");
		delete_option("zoho_texto_ticket");
		delete_option("zoho_texto_login");
		delete_option("zoho_texto_senha");
		delete_option("zoho_texto_data");
	}	
	
	/**
	* Esta função retorna um diálogo em javascript
	*/
	public static function messageBox($title,$message,$button = null) {
		if (!is_null($button)) {
			$button = "<button onclick='javascript:jQuery(\"#loading\").hide();' type='button'>$button</button>";
		}
 	 	$msg = '<style type="text/css" media="screen">#loading {width: 400px;font-size: 10px;margin-right: 10px;display:none;position: absolute;top: 30%;left: 30%;z-index:6000;border: 10px solid #c1c1c1;background: #fff;padding: 10px;}</style>'; 	 		   
 	 	$msg .= "<div id='loading'><center style='background-color:#dddddd;'>$title</center><br /><center id='loading-texto'>$message</center><br /><center>$button</center></div>";
 	 	$msg .= '<script type="text/javascript">';
 	 	$msg .= "jQuery('#loading').show();";
 	 	$msg .= '</script>';
		return $msg;		
	}
	
}

 
/**
 *  Adicionar HOOKs do WordPress
 */

$zohoPlugin = substr(strrchr(dirname(__FILE__),DIRECTORY_SEPARATOR),1).DIRECTORY_SEPARATOR.basename(__FILE__);
/** Funcao de instalacao */
register_activation_hook($zohoPlugin,array('Zoho','instalar'));
/** Funcao de inicializacao */
add_filter('init', array('Zoho','inicializar'));

?>
