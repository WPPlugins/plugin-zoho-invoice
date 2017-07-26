<?php
/**
 * Classe que capitura a API e Ticket do Zoho
 * Para que ele funcione é necessário ativar a API
 * e gerar a APIKEY EX: fde31763c9a273e67dc53027df2c3b65 
 * É necessário também para o funcionamento o TICKET
 * EX: dd096a19b1d070ec8a589322b30bb3fd 
 * o ticket criado pelo zoho tem validade de 7 dias
 * faz necessário atualizar a cada 7 dias o ticket
 *
 * @author      Anderson Loyola <andercrist@gmail.com>
 * @copyright   2010-2010 Anderson Loyola
 * @version     ZohoAPI.php,v 0.1 28/05/2010
 * @link        http://www.andersonloyola.com.br/ 
 * @Deus é o Senhor
 */ 
 
 class ZohoAPI {
 	 
 	 protected $apikey;
 	 
 	 protected $ticket;
 	 
 	 protected $login;
 	 
 	 protected $senha;
 	 
 	 var $urlTicket = 'https://accounts.zoho.com/login';
 	 
 	 var $data;
 	 
 	 var $erro = null;
 	 
 	 
 	 
 	 public function ZohoAPI($cadlogin = false) { 
		 //Seta os valores no objeto	 	 
 	 	 $this->setData(get_option("zoho_texto_data"));
 	 	 $this->setLogin(get_option("zoho_texto_login"));
 	 	 $this->setSenha(get_option("zoho_texto_senha"));
 	 	 $this->setTicket(get_option("zoho_texto_ticket"));
 	 	 //Verifica a direfença entre as datas
 	 	 $dif = $this->dif_datas(date('d/m/Y'),ZohoAPI::Vencimento($this->getData()));
 	 	 //Verifica se a diferença entre as datas está vencida e se é atualização de login e senha. 
 	 	 if (($dif <= 0) || ($cadlogin)) {
 	 
 	 	 	 $r = new HTTP_Request($this->urlTicket);
 	 	 	 $r->setMethod("GET");
 	 	 	 $r->addQueryString('servicename','ZohoInvoice');
 	 	 	 $r->addQueryString('FROM_AGENT','true');
 	 	 	 $r->addQueryString('LOGIN_ID',$this->getLogin());
 	 	 	 $r->addQueryString('PASSWORD',$this->getSenha());
 	 	 	 $r->sendRequest();
 	 	 	 $retorno = $r->getResponseBody();
 	 	 	 $linhas = explode("\n", $retorno);

 	 	 	 foreach ($linhas as $linha)
 	 	 	 {
 	 	 	 	 if (strpos($linha, "=") !== false)
 	 	 	 	 {
 	 	 	 	 	 $valorItem = explode("=", $linha);
 	 	 	 	 	 
 	 	 	 	 	 if (count($valorItem) == 2)
 	 	 	 	 	 {
 	 	 	 	 	 	 $valor[$valorItem[0]] = $valorItem[1];
 	 	 	 	 	 } else {
 	 	 	 	 	 	 $this->setErro('Erro na hora de extrair!');
 	 	 	 	 	 }
 	 	 	 	 }
 	 	 	 	 elseif (strpos($linha, "#") !== false)
 	 	 	 	 {
 	 	 	 	 	 if (strlen($linha) > 5)
 	 	 	 	 	 {
 	 	 	 	 	 	 $data = date('d/m/Y', strtotime(substr($linha, 1)));
 	 	 	 	 	 }
 	 	 	 	 }
 	 	 	 }

 	 	 	 if ($valor['RESULT'] == 'FALSE') {
 	 	 	 	 $this->setErro('Erro Zoho: ' . $valor['CAUSE']); 
 	 	 	 } else {
 	 	 	 	 $this->setTicket($valor['TICKET']);
 	 	 	 	 $this->setData(ZohoAPI::Vencimento($data,6));

 	 	 	 	 update_option("zoho_texto_ticket",$this->getTicket());
 	 	 	 	 update_option("zoho_texto_data",$this->getData()); 	 	 	 	 
 	 	 	 }	
 	 	 }
 	 }
 	 
 	 function sha1crypt($password, $salt=null) {
 	 	 if ( (is_null($salt)) || (strlen($salt)<1) ) {
 	 	 	 $salt='';
 	 	 	 while(strlen($salt)<10) $salt.=chr(rand(64,126));
 	 	 	 $salt='$sha1$'.$salt.'$';
 	 	 }
 	 	 if ($salt{0}!='$') return crypt($password, $salt);
 	 	 $tmp=explode('$',$salt);
 	 	 if ($tmp[1]!='sha1') return crypt($password, $salt);
 	 	 $saltstr=$tmp[2];
 	 	 if (strlen($saltstr) != 10) return crypt($password, $salt);
 	 	 $encrypt=base64_encode(sha1($saltstr.$password,true));
 	 	 return '$sha1$'.$saltstr.'$'.$encrypt;
 	 }
 	 
 	 function Vencimento($data,$dias = 0)
 	 {
 	 	 if (empty($data)) $data = date('d/m/Y');
 	 	 $novadata = explode("/",$data);
 	 	 $dia = $novadata[0];
 	 	 $mes = $novadata[1];
 	 	 $ano = $novadata[2];
 	 	 if ($dias==0) {
 	 	 	return date('d/m/Y',mktime(0,0,0,$mes,$dia,$ano));
 	 	 } else {
 	 	 	return date('d/m/Y',mktime(0,0,0,$mes,$dia+$dias,$ano));
 	 	 }
 	 }
 	 
 	 function dif_datas($dt_inicial, $dt_final){

 	 	 list($dia_i, $mes_i, $ano_i) = explode("/", $dt_inicial); //Data inicial
 	 	 list($dia_f, $mes_f, $ano_f) = explode("/", $dt_final); //Data final
 	 	 $mk_i = mktime(0, 0, 0, $mes_i, $dia_i, $ano_i); // obtem tempo unix no formato timestamp
 	 	 $mk_f = mktime(0, 0, 0, $mes_f, $dia_f, $ano_f); // obtem tempo unix no formato timestamp

 	 	 $diferenca = $mk_f - $mk_i; //Acha a diferença entre as datas

 	 	 return $diferenca;
 	 } 

 	 
 	 public function getApiKey() {
 	 	 return $this->apikey;
 	 }
 	 
 	 public function setApiKey($apikey) {
 	 	 $this->apikey = $apikey;
 	 }
 	 
 	 public function getLogin() {
 	 	 return $this->login;
 	 }
 	 
 	 public function setLogin($login) {
 	 	 $this->login = $login;
 	 }
 	 
 	 public function getSenha() {
 	 	 return $this->senha;
 	 }
 	 
 	 public function setSenha($senha) {
 	 	 $this->senha = $senha;
 	 }
 	 
 	 public function getTicket() {
 	 	 return $this->ticket;
 	 }
 	 
 	 public function setTicket($ticket) {
 	 	 $this->ticket = $ticket;
 	 }
 	 
 	 public function getData() {
 	 	 return $this->data;
 	 }
 	 
 	 public function setData($data) {
 	 	 $this->data = $data;
 	 }
 	 
 	 public function getErro() {
 	 	 return $this->erro;
 	 }
 	 
 	 public function setErro($erro) {
 	 	 $this->erro = $erro;
 	 }

 }
?>
