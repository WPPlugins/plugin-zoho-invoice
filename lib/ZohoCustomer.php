<?php
/**
 * Classe que insere, altera, delete um cliente do ZOHO
 * Estende ao ZohoAPI que captura a API e o Ticket
 *
 * @author      Anderson Loyola <andercrist@gmail.com>
 * @copyright   2010-2010 Anderson Loyola
 * @version     ZohoCustomer.php,v 0.1 28/05/2010
 * @link        http://www.andersonloyola.com.br/ 
 * @Deus é o Senhor
 */
require_once( ABSPATH . WPINC . '/registration.php' ); 
 
 class ZohoCustomer extends ZohoAPI {
 	 
 	 /**
 	  *
 	  * Variáveis baseados nos campos XML do Zoho
 	  *
 	  */
 	 
 	 var $CustomerID;
 	 
 	 var $Name;
 	 
 	 var $PaymentsDue;
 	 
 	 var $CurrencyCode;

 	 var $BillingAddress;
 	 
 	 var $BillingCity;
 	 
 	 var $BillingState;
 	 
 	 var $BillingZip;
 	 
 	 var $BillingCountry;
 	 
 	 var $BillingFax;
 	 
 	 var $ShippingAddress;
 	 
 	 var $ShippingCity;
 	 
 	 var $ShippingState;
 	 
 	 var $ShippingZip;
 	 
 	 var $ShippingCountry;
 	 
 	 var $ShippingFax;
 	 
 	 var $Notes; 	
 	 
 	 /**
 	  * Array dos contatos do Zoho
 	  */
 	 var $Contacts;
 	 
 	 /**
 	  * Array dos campos adicionais do Zoho
 	  */ 	 
 	 var $CustomFields;

 	 /**
 	  * Construtor
 	  */
 	 function ZohoCustomer() {
 	 	 	 parent::__construct();
 	 }
 	 
 	 /** 
 	  * Função que carrega os dados do zoho da base local
 	  * @param string $user_id Id do Usuário do WordPress
 	  */ 	                                                                                  
 	 public function loadLocal($user_id) {
 	 	 $user_info = get_userdata($user_id);
 	 	 
 	 	 $this->setCustomerID(get_usermeta($user_id, 'zoho_customer_CustomerID'));
 	 	 $this->setName(get_usermeta($user_id, 'zoho_customer_Name'));
 	 	 $this->setPaymentsDue(get_usermeta($user_id, 'zoho_customer_PaymentsDue'));
 	 	 $this->setCurrencyCode(get_usermeta($user_id, 'zoho_customer_CurrencyCode'));
 	 	 
 	 	 $this->setBillingAddress(get_usermeta($user_id, 'zoho_customer_BillingAddress'));
 	 	 $this->setBillingCity(get_usermeta($user_id, 'zoho_customer_BillingCity'));
 	 	 $this->setBillingState(get_usermeta($user_id, 'zoho_customer_BillingState'));
 	 	 $this->setBillingZip(get_usermeta($user_id, 'zoho_customer_BillingZip'));
 	 	 $this->setBillingCountry(get_usermeta($user_id, 'zoho_customer_BillingCountry'));
 	 	 $this->setBillingFax(get_usermeta($user_id, 'zoho_customer_BillingFax'));

 	 	 $this->setShippingAddress(get_usermeta($user_id, 'zoho_customer_ShippingAddress'));
 	 	 $this->setShippingCity(get_usermeta($user_id, 'zoho_customer_ShippingCity'));
 	 	 $this->setShippingState(get_usermeta($user_id, 'zoho_customer_ShippingState'));
 	 	 $this->setShippingZip(get_usermeta($user_id, 'zoho_customer_ShippingZip'));
 	 	 $this->setShippingCountry(get_usermeta($user_id, 'zoho_customer_ShippingCountry'));
 	 	 $this->setShippingFax(get_usermeta($user_id, 'zoho_customer_ShippingFax'));
 	 	 
 	 	 $this->setContacts(Array
 	 	 	 					( 
 	 	 	 					  'Contact1' => Array 
 	 	 	 									(
 	 	 	 										'ContactID' => get_usermeta($user_id, 'zoho_customer_ContactID'),
 	 	 	 										'Salutation' => get_usermeta($user_id, 'zoho_customer_Salutation'),
 	 	 	 										'FirstName' => get_usermeta($user_id, 'first_name'),
 	 	 	 										'LastName' => get_usermeta($user_id, 'last_name'),
 	 	 	 										'EMail' => $user_info->user_email,
 	 	 	 										'Phone' => get_usermeta($user_id, 'zoho_customer_Phone'),
 	 	 	 										'Mobile' => get_usermeta($user_id, 'zoho_customer_Mobile')
 	 	 	 									)
 	 	 	 					));
 	 	 
 	 	 
 	 	 $this->setNotes(get_usermeta($user_id, 'description'));
 	 	 
 	 }
 	 
 	 /** 
 	  * Função que Sincronina os dados do Zoho Local com o Zoho Online
 	  */ 	  	 
 	 public function updateWeb() { 	 	 
 	 	 $cxml = new array2xml(get_object_vars($this));
 	 	 $xml = $cxml->get_xml('Customer');
		 $retorno = ZohoCustomerDetails::updateCustomer($xml);
		 
		 $this->setErro(null);
 	 	 if (intval($retorno->attributes()->status) == 0) {
 	 	 	  $this->setErro(strval($retorno->Message));
 	 	 } 	 	  	 	 
 	 }
 	 
 	 /** 
 	 * Função para deixar um campo em maiusculo
 	 */ 	 
 	 function convertem($term, $tp) {
 	 	 if ($tp == "1") $palavra = strtr(strtoupper($term),"àáâãäåæçèéêëìíîïðñòóôõö÷øùüúþÿ","ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖ×ØÙÜÚÞß");
 	 	 elseif ($tp == "0") $palavra = strtr(strtolower($term),"ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖ×ØÙÜÚÞß","àáâãäåæçèéêëìíîïðñòóôõö÷øùüúþÿ");
 	 	 return $palavra;
 	 } 	 
 	 
  	 /** 
 	  * Função que trabalha frontend com o usuário e atualiza seus dados
 	  * @param string $user_id Id do Usuário do WordPress
 	  */ 	 
 	 public function action_meusdados($user_id) {	
 	 	$error = '';
 	 	$msg = '';
 	 	$template = ''; 	 	
		if ( 'POST' == $_SERVER['REQUEST_METHOD'] && !empty( $_POST['action'] ) && $_POST['action'] == 'Atualizar' ) {			
			if ( !empty($_POST['pass1'] ) && !empty( $_POST['pass2'] ) ) {
				if ( $_POST['pass1'] == $_POST['pass2'] )
					wp_update_user( array( 'ID' => $user_id, 'user_pass' => esc_attr( $_POST['pass1'] ) ) );
				else
					$tpl['{ERROR}'] = __('As senhas que você digitou não são iguais. Sua senha não foi atualizada.', 'frontendprofile');
			}		
			$this->setName(ZohoCustomer::convertem((isset($_POST['Name']) ? $_POST['Name'] : '') ,1));    		
			
			$this->setBillingAddress((isset($_POST['BillingAddress']) ? $_POST['BillingAddress'] : ''));
			$this->setBillingCity((isset($_POST['BillingCity']) ? $_POST['BillingCity'] : ''));
			$this->setBillingState((isset($_POST['BillingState']) ? $_POST['BillingState'] : ''));
			$this->setBillingZip((isset($_POST['BillingZip']) ? $_POST['BillingZip'] : ''));
			$this->setBillingCountry((isset($_POST['BillingCountry']) ? $_POST['BillingCountry'] : ''));
			$this->setBillingFax((isset($_POST['BillingFax']) ? $_POST['BillingFax'] : ''));
						
			$this->setShippingAddress((isset($_POST['ShippingAddress']) ? $_POST['ShippingAddress'] : ''));
			$this->setShippingCity((isset($_POST['ShippingCity']) ? $_POST['ShippingCity'] : ''));
			$this->setShippingState((isset($_POST['ShippingState']) ? $_POST['ShippingState'] : ''));
			$this->setShippingZip((isset($_POST['ShippingZip']) ? $_POST['ShippingZip'] : ''));
			$this->setShippingCountry((isset($_POST['ShippingCountry']) ? $_POST['ShippingCountry'] : ''));
			$this->setShippingFax((isset($_POST['ShippingFax']) ? $_POST['ShippingFax'] : ''));
			
			$this->setNotes((isset($_POST['description']) ? $_POST['description'] : ''));
			
			$contacts = $this->getContacts();
			$contacts['Contact1']['Salutation'] = (isset($_POST['Salutation']) ? $_POST['Salutation'] : '');
			$contacts['Contact1']['FirstName'] = (isset($_POST['first_name']) ? $_POST['first_name'] : '');
			$contacts['Contact1']['LastName'] = (isset($_POST['last_name']) ? $_POST['last_name'] : '');
			$contacts['Contact1']['EMail'] = (isset($_POST['email']) ? $_POST['email'] : '');
			$contacts['Contact1']['Phone'] = (isset($_POST['Phone']) ? $_POST['Phone'] : '');
			$contacts['Contact1']['Mobile'] = (isset($_POST['Mobile']) ? $_POST['Mobile'] : '');
						
			$this->setContacts($contacts);	
			
			update_usermeta( $user_id, 'first_name', $contacts['Contact1']['FirstName'] );
			update_usermeta( $user_id, 'last_name', $contacts['Contact1']['LastName'] );
			update_usermeta( $user_id, 'user_email', $contacts['Contact1']['EMail'] );
			update_usermeta( $user_id, 'description', $this->getNotes() );    	
			
			$this->updateLocal($user_id);
					
			$tpl['{MSG}'] = 'Atualização efetuada com sucesso!';
		}
		
		$tpl['{Pass1}'] = $_POST['pass1'];
		$tpl['{Pass2}'] = $_POST['pass2'];
		$tpl['{Description}'] = esc_attr(get_usermeta( $user_id, 'description' ) );
		$tpl['{first_name}'] = esc_attr(get_usermeta( $user_id, 'first_name' ) );
		$tpl['{last_name}'] = esc_attr(get_usermeta( $user_id, 'last_name' ) );
		$tpl['{user_email}'] = esc_attr(get_usermeta( $user_id, 'user_email' ) );
		
		$tpl['{Name}'] = esc_attr(get_usermeta( $user_id, 'zoho_customer_Name' ) );
		$tpl['{Phone}'] = esc_attr(get_usermeta( $user_id, 'zoho_customer_Phone' ) );
		$tpl['{Mobile}'] = esc_attr(get_usermeta( $user_id, 'zoho_customer_Mobile' ) );
		$tpl['{BillingAddress}'] = esc_attr(get_usermeta( $user_id, 'zoho_customer_BillingAddress' ) );
		$tpl['{BillingCity}'] = esc_attr(get_usermeta( $user_id, 'zoho_customer_BillingCity' ) );
		$tpl['{BillingState}'] = esc_attr(get_usermeta( $user_id, 'zoho_customer_BillingState' ) );
		$tpl['{BillingZip}'] = esc_attr(get_usermeta( $user_id, 'zoho_customer_BillingZip' ) );
		$tpl['{BillingCountry}'] = esc_attr(get_usermeta( $user_id, 'zoho_customer_BillingCountry' ) );
		$tpl['{BillingFax}'] = esc_attr(get_usermeta( $user_id, 'zoho_customer_BillingFax' ) );

		$tpl['{ShippingAddress}'] = esc_attr(get_usermeta( $user_id, 'zoho_customer_ShippingAddress' ) );
		$tpl['{ShippingCity}'] = esc_attr(get_usermeta( $user_id, 'zoho_customer_ShippingCity' ) );
		$tpl['{ShippingState}'] = esc_attr(get_usermeta( $user_id, 'zoho_customer_ShippingState' ) );
		$tpl['{ShippingZip}'] = esc_attr(get_usermeta( $user_id, 'zoho_customer_ShippingZip' ) );
		$tpl['{ShippingCountry}'] = esc_attr(get_usermeta( $user_id, 'zoho_customer_ShippingCountry' ) );
		$tpl['{ShippingFax}'] = esc_attr(get_usermeta( $user_id, 'zoho_customer_ShippingFax' ) );
		
		$tpl['{Salutation}'] = ZohoCustomer::getSalutationSelect(esc_attr(get_usermeta( $user_id, 'zoho_customer_Salutation' ) ), 1);
		$envio = get_usermeta( $user_id, 'zoho_customer_ShippingAddress' );
		if (!empty($envio)) {			
			$tpl['{CHECK}'] = 'CHECKED';
			$tpl['{SCRIPT}'] = "<script type='text/javascript'>jQuery('.zohoenvio').toggle();</script>";			
		} else {
			$tpl['{CHECK}'] = '';
			$tpl['{SCRIPT}'] = '';				
		}
	
		$tpl['{ACTION_FORM}'] = 'http://'. $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . '&setor=meusdados';
						
		
		
		if (get_usermeta( $user_id, 'zoho_customer_VSinc' )) {			
			$msgBox = Zoho::messageBox('Atualização dos dados','Algumas das alterações ainda não foram aprovadas pelo administrador. Após a verificação dos dados alterados esta mensagem não aparecerá.','OK');
		} else {
			$msgBox = '';
		}
				
		//Diretorio do Plugin
		$dir = ABSPATH . 'wp-content/plugins/Zoho';
		
		
		if (isset($tpl['{ERROR}'])) {
			//Carregar Template
			$tplObj = new FileReader($dir."/tpl/zohoError.tpl");
			$template = $tplObj->read($tplObj->_length);			
			//Substituir variáveis no template		
			$template = strtr($template,$tpl);		
		} else {
			if (isset($tpl['{MSG}'])) {
				//Carregar Template
				$tplObj = new FileReader($dir."/tpl/zohoMensagem.tpl");
				$template .= $tplObj->read($tplObj->_length);			
				//Substituir variáveis no template		
				$template = strtr($template,$tpl);
			}			
		}
		
		//Carregar Template
		$tplObj = new FileReader($dir."/tpl/zohoMeusDados.tpl");
		$template .= $tplObj->read($tplObj->_length);
		
		//Substituir variáveis no template		
		$template = strtr($template,$tpl);
		$template .= $msgBox;
		
		
		
		return $template;				
 
		
	
 	 }
 	 
 	 
 	 /**
 	 * Cria um cadastro no wordpress e no zoho invoice (Formulário de Cadastro do site)
 	 * @param int $user_id User Id 
 	 */
 	 public function save($user_id) {
 	 	 $cxml = new array2xml(get_object_vars($this));
 	 	 $xml = $cxml->get_xml('Customer');
 	 	 $retorno = ZohoCustomerDetails::createCustomer($xml);	 
		 $this->setErro(null);		 
		 
 	 	 if (intval($retorno->attributes()->status) == 0) {
 	 	 	  $this->setErro(strval($retorno->Message));
 	 	 } else {
 	 	 	 ZohoCustomerDetails::loadXML($retorno);
 	 	 	 $this->updateLocal($user_id);
 	 	 }
 	 }
 	 
 	 
 	 /**
 	 * Copiado do wordpress pluggable.php para enviar a notificação por email do usuário e senha
 	 *
 	 * @since 2.0
 	 *
 	 * @param int $user_id User ID
 	 * @param string $plaintext_pass Optional. The user's plaintext password
 	 */
 	 function wp_new_user_notification($user_id, $plaintext_pass = '') {
 	 	 $user = new WP_User($user_id);

 	 	 $user_login = stripslashes($user->user_login);
 	 	 $user_email = stripslashes($user->user_email);
	
 	 	 $blogname = wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);

 	 	 $message  = sprintf(__('Um novo usuário foi registrado no seu site %s:'), $blogname) . "\r\n\r\n";
 	 	 $message .= sprintf(__('Usuario: %s'), $user_login) . "\r\n\r\n";
 	 	 $message .= sprintf(__('E-mail: %s'), $user_email) . "\r\n";
 	 	 
 	 	 $headers = 'From: Atendimento <atendimento@cena7.com.br>' . "\r\n\\";
 	 	 
 	 	 @wp_mail(get_option('admin_email'), __('Atendimento Cena7 - Novo usuário registrado'), $message, $headers);

 	 	 if ( empty($plaintext_pass) )
 	 	 	 return;
 	 	 $message = sprintf(__('Olá, você se cadastrou no site %s e está recebendo seu usuário e senha para acessar nosso site.'), $blogname) . "\r\n";
 	 	 $message .= sprintf(__('Usuário: %s'), $user_login) . "\r\n";
 	 	 $message .= sprintf(__('Senha: %s'), $plaintext_pass) . "\r\n";
 	 	 $message .= sprintf(__('Guarde bem estes dados para futuramente acompanhar seus pedidos.')) . "\r\n";
 	 	 $message .= sprintf(__('Obrigado por se registrar.')) . "\r\n";
 	 	 
 	 	 $headers = 'From: Atendimento <atendimento@cena7.com.br>' . "\r\n\\";
 	 	 
 	 	 wp_mail($user_email, __('Atendimento Cena7 - Usuário e Senha'), $message,$headers);
 	 } 	 
 	 
 	 
 	 /**
 	  * Função que atualiza os dados do Zoho Localmente e Verifica a Sincronia
 	  * @param string $user_id Id do Usuário do WordPress
 	  */ 	 
 	 public function updateLocal($user_id) {
 	 	 
 	 	 $contact = $this->getContacts();
 	 	 
 	 	 if (isset($_POST['email'])) {
 	 	 	//Troca o Post que era para ser salvo para o post alterado conforme o OBJ Customer
 	 	 	$_POST['first_name'] = esc_attr( $contact['Contact1']['FirstName'] );
 	 	 	$_POST['last_name'] = esc_attr( $contact['Contact1']['LastName'] );
 	 	 	$_POST['email'] = esc_attr( $contact['Contact1']['EMail'] );
 	 	 	$_POST['description'] = esc_attr( $this->getNotes() );
 	 	 } else {
 	 	 	 update_usermeta( $user_id, 'first_name', $contact['Contact1']['FirstName'] );
 	 	 	 update_usermeta( $user_id, 'last_name', $contact['Contact1']['LastName'] );
 	 	 	 update_usermeta( $user_id, 'user_email', $contact['Contact1']['EMail'] );
 	 	 	 update_usermeta( $user_id, 'description', $this->getNotes() );
 	 	 } 	 	 
 	 	 
 	 	 //Atualiza todos os dados na base local	 	 	  	 	 
 	 	 update_usermeta( $user_id, 'zoho_customer_CustomerID', esc_attr( $this->getCustomerID() ) );
 	 	 update_usermeta( $user_id, 'zoho_customer_Name', ZohoCustomer::convertem(esc_attr( $this->getName() ),1) );
 	 	 update_usermeta( $user_id, 'zoho_customer_PaymentsDue', esc_attr( $this->getPaymentsDue() ) );
 	 	 update_usermeta( $user_id, 'zoho_customer_CurrencyCode', esc_attr( $this->getCurrencyCode() ) );	 	 
 	 	 
 	 	 
		 update_usermeta( $user_id, 'zoho_customer_ContactID', esc_attr( $contact['Contact1']['ContactID'] ) );
		 update_usermeta( $user_id, 'zoho_customer_Salutation', esc_attr( $contact['Contact1']['Salutation'] ) );
 	 	 update_usermeta( $user_id, 'zoho_customer_Phone', esc_attr( $contact['Contact1']['Phone'] ) );
 	 	 update_usermeta( $user_id, 'zoho_customer_Mobile', esc_attr( $contact['Contact1']['Mobile'] ) );
 	 	 	 	 	 
 	 	 update_usermeta( $user_id, 'zoho_customer_BillingAddress', esc_attr( $this->getBillingAddress() ) );
 	 	 update_usermeta( $user_id, 'zoho_customer_BillingCity', esc_attr( $this->getBillingCity() ) );
 	 	 update_usermeta( $user_id, 'zoho_customer_BillingState', esc_attr( $this->getBillingState() ) );
 	 	 update_usermeta( $user_id, 'zoho_customer_BillingZip', esc_attr( $this->getBillingZip() ) );
 	 	 
 	 	 update_usermeta( $user_id, 'zoho_customer_BillingCountry', esc_attr( $this->getBillingCountry() ) );
 	 	 update_usermeta( $user_id, 'zoho_customer_BillingFax', esc_attr( $this->getBillingFax() ) );
 	 	 	 	 	 
 	 	 update_usermeta( $user_id, 'zoho_customer_ShippingAddress', esc_attr( $this->getShippingAddress() ) );
 	 	 update_usermeta( $user_id, 'zoho_customer_ShippingCity', esc_attr( $this->getShippingCity() ) );
 	 	 update_usermeta( $user_id, 'zoho_customer_ShippingState', esc_attr( $this->getShippingState() ) );
 	 	 update_usermeta( $user_id, 'zoho_customer_ShippingZip', esc_attr( $this->getShippingZip() ) );
 	 	 update_usermeta( $user_id, 'zoho_customer_ShippingCountry', esc_attr( $this->getShippingCountry() ) );
 	 	 update_usermeta( $user_id, 'zoho_customer_ShippingFax', esc_attr( $this->getShippingFax() ) );
 	 	 
 	 	 //Verifica a sincronia dos dados
 	 	 if (!$this->verificarSinc()) {
 	 	 	 update_usermeta( $user_id, 'zoho_customer_VSinc', true );
 	 	 } else {
 	 	 	 update_usermeta( $user_id, 'zoho_customer_VSinc', false );
 	 	 }	 	 
 	 	 
 	 }
 	 
 	 /**
 	  * Função que verifica a Sincronia dos dados Online com Local
 	  */ 	 
 	 public function verificarSinc() {
 	 	 $clone1 = clone $this; 	 	 
 	 	 $clone2 =  ZohoCustomerDetails::load($clone1->getCustomerID()); 	 	 
 	 	 return ($clone1 == $clone2) ? true : false;
 	 }
 	 
 	 /** 
 	  *Função que atualiza os dados locais para usuarios que não estão associados a um cliente Zoho
 	  * @param string $CustomerID Id do Usuário do Zoho->Cliente
 	  * @param string $user_id Id do Usuário do WordPress
 	  */ 	  
 	 public function saveImportUpdate($CustomerID,$user_id) {    			
 	 	 ZohoCustomerDetails::load($CustomerID);
 	 	 $this->updateLocal($user_id); 	 	 
 	 }
 	 
 	 /**
 	  * Funcão que cria o usuário no WordPress importando os dados do Zono->Cliente
 	  */
 	 public function saveImport() { 	 	  	 	 
 	 	 if ($this->getContacts() > 0) {
 	 	 	 $contact = $this->getContacts(); 	 	 	 
 	 	 	 if (!empty($contact['Contact1']['EMail'])) {  
 	 	 	 	 
 	 	 	 	 $username = explode("@", $contact['Contact1']['EMail']); 	 	 	 	 
 	 	 	 	 $user_pass = wp_generate_password();
 	 	 	 	 $userdata = array(
 	 	 	 	 	 'user_pass' => $user_pass,
 	 	 	 	 	 'user_login' => esc_attr( $username[0] ),
 	 	 	 	 	 'first_name' => esc_attr( $contact['Contact1']['FirstName'] ),
 	 	 	 	 	 'last_name' => esc_attr( $contact['Contact1']['LastName'] ),
 	 	 	 	 	 'nickname' => esc_attr( $username[0] ),
 	 	 	 	 	 'user_email' => esc_attr( $contact['Contact1']['EMail'] ),
 	 	 	 	 	 'description' => esc_attr( $this->getNotes() ),
 	 	 	 	 	 'role' => get_option( 'default_role' ),
 	 	 	 	 	 );
	
 	 	 	 	 if ( !$userdata['user_login'] )
 	 	 	 	 	 $this->setErro(__('<strong style="color:red;">Erro:</strong> O Nome do Usuário é necessário. Cliente:' . $this->getName(), 'frontendprofile'));
 	 	 	 	 elseif ( username_exists($userdata['user_login']) )
 	 	 	 	 	 $this->setErro(__('<strong style="color:red;">Erro:</strong> O Nome do Usuário já existe! Cliente:' . $this->getName(), 'frontendprofile'));
 	 	 	 	 elseif ( !is_email($userdata['user_email'], true) )
 	 	 	 	 	 $this->setErro(__('<strong style="color:red;">Erro:</strong> Email Inválido. Cliente:' . $this->getName(), 'frontendprofile'));
 	 	 	 	 elseif ( email_exists($userdata['user_email']) )
 	 	 	 	 	 $this->setErro(__('<strong style="color:red;">Erro:</strong> O email já existe cadastrado em nosso sistema! Cliente:' . $this->getName(), 'frontendprofile'));	
 	 	 	 	 else 
 	 	 	 	 {
 	 	 	 	 	 $new_user = wp_insert_user( $userdata );
 	 	 	 	 	 if (( intval($_REQUEST['notificar'])) == 1) {
 	 	 	 	 	 	 $this->wp_new_user_notification($new_user, $user_pass);
 	 	 	 	 	 }
 	 	 	 	 	 update_usermeta( $new_user, 'zoho_customer_ContactID', esc_attr( $contact['Contact1']['ContactID'] ) );
 	 	 	 	 	 update_usermeta( $new_user, 'zoho_customer_CustomerID', esc_attr( $this->getCustomerID() ) );	 	 	 	 	 
 	 	 	 	 	 update_usermeta( $new_user, 'zoho_customer_Name', ZohoCustomer::convertem(esc_attr( $this->getName() ),1) );
 	 	 	 	 	 update_usermeta( $new_user, 'zoho_customer_PaymentsDue', esc_attr( $this->getPaymentsDue() ) );
 	 	 	 	 	 update_usermeta( $new_user, 'zoho_customer_CurrencyCode', esc_attr( $this->getCurrencyCode() ) );
 	 	 	 	 	 
 	 	 	 	 	 update_usermeta( $new_user, 'zoho_customer_Salutation', esc_attr( $contact['Contact1']['Salutation'] ) );
 	 	 	 	 	 update_usermeta( $new_user, 'zoho_customer_Phone', esc_attr( $contact['Contact1']['Phone'] ) );
 	 	 	 	 	 update_usermeta( $new_user, 'zoho_customer_Mobile', esc_attr( $contact['Contact1']['Mobile'] ) );
 	 	 	 	 	 
 	 	 	 	 	 update_usermeta( $new_user, 'zoho_customer_BillingAddress', esc_attr( $this->getBillingAddress() ) );
 	 	 	 	 	 update_usermeta( $new_user, 'zoho_customer_BillingCity', esc_attr( $this->getBillingCity() ) );
 	 	 	 	 	 update_usermeta( $new_user, 'zoho_customer_BillingState', esc_attr( $this->getBillingState() ) );
 	 	 	 	 	 update_usermeta( $new_user, 'zoho_customer_BillingZip', esc_attr( $this->getBillingZip() ) );
 	 	 	 	 	 update_usermeta( $new_user, 'zoho_customer_BillingCountry', esc_attr( $this->getBillingCountry() ) );
 	 	 	 	 	 update_usermeta( $new_user, 'zoho_customer_BillingFax', esc_attr( $this->getBillingFax() ) );
 	 	 	 	 	 
 	 	 	 	 	 update_usermeta( $new_user, 'zoho_customer_ShippingAddress', esc_attr( $this->getShippingAddress() ) );
 	 	 	 	 	 update_usermeta( $new_user, 'zoho_customer_ShippingCity', esc_attr( $this->getShippingCity() ) );
 	 	 	 	 	 update_usermeta( $new_user, 'zoho_customer_ShippingState', esc_attr( $this->getShippingState() ) );
 	 	 	 	 	 update_usermeta( $new_user, 'zoho_customer_ShippingZip', esc_attr( $this->getShippingZip() ) );
 	 	 	 	 	 update_usermeta( $new_user, 'zoho_customer_ShippingCountry', esc_attr( $this->getShippingCountry() ) );
 	 	 	 	 	 update_usermeta( $new_user, 'zoho_customer_ShippingFax', esc_attr( $this->getShippingFax() ) );
 	 	 
 	 	 	 	 	 
 	 	 	 	 	 $this->setErro(__('Usuário registrado com sucesso! Cliente:' . $this->getName(), 'frontendprofile'));
 	 	 	 	 } 
 	 	 	 	 
 	 	 	 	 
 	 	 	 } else {
 	 	 	 	 $this->setErro(__('<strong style="color:red;">Erro:</strong> Contato sem email! Cliente:' . $this->getName(), 'frontendprofile'));
 	 	 	 }
 	 	 } else {
 	 	 	 $this->setErro(__('<strong style="color:red;">Erro:</strong> Cliente sem "Contato" Cadastrado! Cliente:' . $this->getName(), 'frontendprofile'));
 	 	 }
 	 	 	 
 	 }
 	 
 	 /**
 	  * Função que importa os dados de todos os Clientes do Zoho e Salva no WordPress criando o usuário
 	  */
 	 public function getImportAllCustomers($wpdb,$pagina = 1) {	
		if (!$pagina) {
			 $pagina = 1;
		} 	 	 
 	 	 $lista = '';
 	 	 $paginacao = '';
 	 	 $xml = ZohoCustomerDetails::getCustomerPerPage($pagina);
 	 	 if (count($xml->Customers->Customer)) {
 	 	 	 //Loop nos campos de cada cliente
 	 	 	 foreach ($xml->Customers->Customer as $id => $customer) { 
 	 	 	 	 $resultados = $wpdb->get_results( "SELECT meta_value FROM ".$wpdb->prefix."usermeta WHERE meta_value = '$customer->Name'" );
 	 	 	 	 if (count($resultados) == 0) { 
					 $lista .= "<tr class='alternate'>";
					 $lista .= "<th scope='row' class='check-column'>";
					 $lista .= "<input type='checkbox' name='CustomerID[]' id='user_1' class='administrator' value='".strval($customer->CustomerID)."' />";
					 $lista .= "</th>";
					 $lista .= "<td class='name column-name'>" . strval($customer->Name); 	 	 	 	 	 
					 $lista .= "<br><div class='row-actions'><span class='edit'><a href='http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . "&CustomerID=" .strval($customer->CustomerID). "'>Importar</a></span></div>";
					 $lista .= "</td>";
					 $lista .= "</tr>"; 	 	 	 	 	  
				 }			  	 	 	 
			 }
			 $total_paginas = $xml->PageContext['Total_Pages'];

 	 	 
			 $prev = $pagina - 1;
			 $next = $pagina + 1;
			 // se página maior que 1 (um), então temos link para a página anterior
			 if ($pagina > 1) {
				 $prev_link = "<a href='" .get_permalink(). "admin.php?page=clientes_imp&pagina=$prev'>Anterior</a>";
			 } else { // senão não há link para a página anterior
				 $prev_link = "Anterior";
			 }
			 
			 // se número total de páginas for maior que a página corrente, então temos link para a próxima página
			 if ($total_paginas > $pagina) {
				 $next_link = "<a href='" .get_permalink(). "admin.php?page=clientes_imp&pagina=$next'>Próxima</a>";
			 } else { // senão não há link para a próxima página
				 $next_link = "Próxima";
			 } 	 	 
			 $painel = "";
			 for ($x=1; $x<=$total_paginas; $x++) {
				 if ($x==$pagina) { // se estivermos na página corrente, não exibir o link para visualização desta página
					 $painel .= " [$x] ";
				 } else {
					 $painel .= " <a href='" .get_permalink(). "admin.php?page=clientes_imp&pagina=$x'>[$x]</a>";
				 }
			 }
			 $paginacao = "$prev_link | $painel | $next_link";
 	 	 }
 	 	 
 	 	 
 	 	 return Array("lista" => $lista , "paginacao" => $paginacao); 	 	 
 	 } 	 
 	 
 	 /**
 	  * Função que cria um select dos Nomes dos Clientes Zoho que tenham Email
 	  * @param object $wpdb Objeto que conecta com o banco de dados do WordPress
 	  */
 	 public function getAllCustomerNameSelect($wpdb) { 
 	 	//Constroi o ZohoDetails Localmente
 	 	$zohoDetails = new ZohoCustomerDetails();
 	 	//Atualiza a página
		flush();	 	 
		//Busca o total de páginas
 	 	 $total_pagina = $zohoDetails->getCustomerPerPage(1)->PageContext['Total_Pages'];
 	 	 //Prepara o select		
 	 	 $select = '<select name="CustomerID" id="CustomerID">' ;											
 	 	 $select .= "<option id='CustomerID' value='' selected='selected'>Nenhum</option>";
 	 	 //Loop nas páginas
 	 	 for ($pagina=1 ; $pagina <= $total_pagina; $pagina++) { 	 	 	 
 	 	 	 $xml = $zohoDetails->getCustomerPerPage($pagina,200); 	
 	 	 	 // Loop nos campos do cliente
 	 	 	 foreach ($xml->Customers->Customer as $id => $customer) {
 	 	 	 	 //Seleciona somente clientes que não estão associado
 	 	 	 	 $resultados = $wpdb->get_results( "SELECT meta_value FROM ".$wpdb->prefix."usermeta WHERE meta_value = '$customer->CustomerID'" );
 	 	 	 	 if (count($resultados) == 0) {
 	 		 	 	 	 $select .= "<option id='customers' value='$customer->CustomerID'>$customer->Name</option>"; 	 	
 	 	 	 	 } 	 	 	 	 
 	 	 	 } 
 	 	 	 $total_pagina = $xml->PageContext['Total_Pages']; 	 	 	 
 	 	 }
 	 	 $select .= '</select>'; 	 	
 	 	 return $select;
 	 	 
 	 }
 	 
 	 /**
 	  * Função que cria um select do campo PaymentsDue do Zoho
 	  * @param string $PaymentsDue Value do campo Select
 	  * @param int $tipo Tipo do retorno 1 = Select com o Value selecionado 2 = Retorna somente o valor selecionado 3 = Retorna o array com todos os dados  
 	  */
	function getPaymentsDueSelect($PaymentsDue, $tipo = 0)
	{
		
		$payments[15] = 'Líquido 15';
		$payments[30] = 'Líquido 30';
		$payments[45] = 'Líquido 45';
		$payments[60] = 'Líquido 60';
		$payments[0] = 'Devido contra Recebimento';
		
		if ($tipo == 1)
		{
			$lista = '<select name="PaymentsDue">';
			foreach ($payments as $id => $payment)
			{
				$lista .= "<option value=\"".$id."\"";
				if ($id == $PaymentsDue)
				{
					$lista .= " selected";
				}
				$lista .= ">";
				$lista .= $payment;
				$lista .= "</option>\n";
			}
			$lista .= "</select>";
		}
		elseif ($tipo == 2)
		{
			$lista = isset($payments[$PaymentsDue]) ? $payments[$PaymentsDue] : 'Não definido';
		}
		else
		{
			$lista = $payments;
		}

		return $lista;
	} 
	
	/**
	 * Função que cria um select do campo Salutation do Zoho
 	 * @param string $salutation Value do campo Select
 	 * @param int $tipo Tipo do retorno 1 = Select com o Value selecionado 2 = Retorna somente o valor selecionado 3 = Retorna o array com todos os dados	 
	 */
	function getSalutationSelect($salutation_id, $tipo = 0)
	{
		
		$salutations[""] = 'Nenhum';
		$salutations["Dr."] = 'Dr..';
		$salutations["Mr."] = 'Sr..';
		$salutations["Mrs."] = 'Sra..';
		$salutations["Miss."] = 'Srta..';
		$salutations["Ms."] = 'Srta..';
		
		if ($tipo == 1)
		{
			$lista = '<select name="Salutation">';
			foreach ($salutations as $id => $salutation)
			{
				$lista .= "<option value=\"".$id."\"";
				if ($id == $salutation_id)
				{
					$lista .= " selected";
				}
				$lista .= ">";
				$lista .= $salutation;
				$lista .= "</option>\n";
			}
			$lista .= "</select>";
		}
		elseif ($tipo == 2)
		{
			$lista = isset($salutations[$salutation_id]) ? $salutations[$salutation_id] : 'Não definido';
		}
		else
		{
			$lista = $salutations;
		}

		return $lista;
	} 	

	
 	 /**
 	  *
 	  *
 	  * GETS E SETS DAS VARIAVEIS
 	  *
 	  *       *************
 	  *        *         *
 	  *           *   *
 	  *             *
 	  */
 	 public function setCustomerID($customer_id) {
 	 	 $this->CustomerID = $customer_id;
 	 }
 	 
 	 public function getCustomerID() {
 	 	 return $this->CustomerID;
 	 }
 	 
 	 public function setName($name) {
 	 	 $this->Name = $name;
 	 }
 	 
 	 public function getName() {
 	 	 return $this->Name;
 	 }

 	 public function setBillingAddress($BillingAddress) {
 	 	 $this->BillingAddress = $BillingAddress;
 	 }
 	 
 	 public function getBillingAddress() {
 	 	 return $this->BillingAddress;
 	 }
 	 
 	 public function setBillingCity($BillingCity) {
 	 	 $this->BillingCity = $BillingCity;
 	 }
 	 
 	 public function getBillingCity() {
 	 	 return $this->BillingCity;
 	 }
 	 
 	 public function setBillingState($BillingState) {
 	 	 $this->BillingState = $BillingState;
 	 }
 	 
 	 public function getBillingState() {
 	 	 return $this->BillingState;
 	 }
 	 
 	 public function setBillingZip($BillingZip) {
 	 	 $this->BillingZip = $BillingZip;
 	 }
 	 
 	 public function getBillingZip() {
 	 	 return $this->BillingZip;
 	 }
 	 
 	 public function setBillingCountry($BillingCountry) {
 	 	 $this->BillingCountry = $BillingCountry;
 	 }
 	 
 	 public function getBillingCountry() {
 	 	 return $this->BillingCountry;
 	 }
 	 
 	 public function setBillingFax($BillingFax) {
 	 	 $this->BillingFax = $BillingFax;
 	 }
 	 
 	 public function getBillingFax() {
 	 	 return $this->BillingFax;
 	 }
 	 
 	 public function setShippingAddress($ShippingAddress) {
 	 	 $this->ShippingAddress = $ShippingAddress;
 	 }
 	 
 	 public function getShippingAddress() {
 	 	 return $this->ShippingAddress;
 	 }
 	 
 	 public function setShippingCity($ShippingCity) {
 	 	 $this->ShippingCity = $ShippingCity;
 	 }
 	 
 	 public function getShippingCity() {
 	 	 return $this->ShippingCity;
 	 }
 	 
 	 public function setShippingState($ShippingState) {
 	 	 $this->ShippingState = $ShippingState;
 	 }
 	 
 	 public function getShippingState() {
 	 	 return $this->ShippingState;
 	 }
 	 
 	 public function setShippingZip($ShippingZip) {
 	 	 $this->ShippingZip = $ShippingZip;
 	 }
 	 
 	 public function getShippingZip() {
 	 	 return $this->ShippingZip;
 	 }
 	 
 	 public function setShippingCountry($ShippingCountry) {
 	 	 $this->ShippingCountry = $ShippingCountry;
 	 }
 	 
 	 public function getShippingCountry() {
 	 	 return $this->ShippingCountry;
 	 }
 	 
 	 public function setShippingFax($ShippingFax) {
 	 	 $this->ShippingFax = $ShippingFax;
 	 }
 	 
 	 public function getShippingFax() {
 	 	 return $this->ShippingFax;
 	 }
 	 
 	 public function setNotes($Notes) {
 	 	 $this->Notes = $Notes;
 	 }
 	 
 	 public function getNotes() {
 	 	 return $this->Notes;
 	 }
 	 
 	 public function setContacts($Contacts) {
 	 	 $this->Contacts = $Contacts;
 	 }
 	 
 	 public function getContacts() {
 	 	 return $this->Contacts;
 	 }

	 public function setCustomFields($CustomFields) {
	 	 $this->CustomFields = $CustomFields;
	 }
	 
	 public function getCustomFields() {
	 	 return $this->CustomFields;
	 }
	 
	 public function setPaymentsDue($PaymentsDue) {
	 	 $this->PaymentsDue = $PaymentsDue;
	 }
	 
	 public function getPaymentsDue() {
	 	 return $this->PaymentsDue;
	 }
	 
	 public function setCurrencyCode($CurrencyCode) {
	 	 $this->CurrencyCode = $CurrencyCode;
	 }
	 
	 public function getCurrencyCode() {
	 	 return $this->CurrencyCode;
	 }	 
	 
}
?>
