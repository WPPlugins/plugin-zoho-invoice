<?php
/**
 * Classe que insere, altera, delete os detalhes do cliente do ZOHO
 *
 * @author      Anderson Loyola <andercrist@gmail.com>
 * @copyright   2010-2010 Anderson Loyola
 * @version     ZohoCustomerDetails.php,v 0.1 28/05/2010
 * @link        http://www.andersonloyola.com.br/ 
 * @Deus é o Senhor
 */ 
 class ZohoCustomerDetails extends ZohoCustomer {
 	 
 	 
 	 
 	 public function ZohoCustomerDetails() {
 	 	 parent::__construct();
 	 	 
 	 }
 	 
 	 public function load($CustomerID) {
 	 	 $xml = ZohoCustomerDetails::getCustomer($CustomerID);
 	 	 
 	 	 foreach ($xml->Customer as $id => $customer) { 
 	 	 	 //Dados
 	 	 	 $this->setCustomerId(strval($customer->CustomerID));
 	 	 	 $this->setName(strval($customer->Name));
 	 	 	 $this->setPaymentsDue(intval($customer->PaymentsDue));
 	 	 	 $this->setCurrencyCode(strval($customer->CurrencyCode));
 	 	 	 $this->setNotes(strval($customer->Notes));
 	 	 	 //Endereço da Fatura
 	 	 	 $this->setBillingAddress(strval($customer->BillingAddress));
 	 	 	 $this->setBillingCity(strval($customer->BillingCity));
 	 	 	 $this->setBillingState(strval($customer->BillingState));
 	 	 	 $this->setBillingZip(strval($customer->BillingZip));
 	 	 	 $this->setBillingCountry(strval($customer->BillingCountry));
 	 	 	 $this->setBillingFax(strval($customer->BillingFax));
 	 	 	 //Endereço de Entrega
 	 	 	 $this->setShippingAddress(strval($customer->ShippingAddress));
 	 	 	 $this->setShippingCity(strval($customer->ShippingCity));
 	 	 	 $this->setShippingState(strval($customer->ShippingState));
 	 	 	 $this->setShippingZip(strval($customer->ShippingZip));
 	 	 	 $this->setShippingCountry(strval($customer->ShippingCountry));
 	 	 	 $this->setShippingFax(strval($customer->ShippingFax));
 	 	 	 //Observações
 	 	 	 $this->setNotes(strval($customer->Notes));
 	 	 	 //Contatos
 	 	 	 $contacts = get_object_vars($customer->Contacts);
 	 	 	 if (count($contacts) > 0) {
 	 	 	 	 foreach($contacts['Contact'] as $key=>$val){
 	 	 	 	 	 if (count($val) > 0) { 	 
 	 	 	 	 	 	 if ($key == 0) {
 	 	 	 	 	 	 	 $contact['Contact' . ($key + 1)]= get_object_vars($val);
 	 	 	 	 	 	 }
 	 	 	 	 	 } else {
 	 	 	 	 	 	 $contact['Contact1'][$key]= strval($val);
 	 	 	 	 	 }
 	 	 	 	 }
 	 	 	 	 $this->setContacts($contact);
             } else {
             	 $this->setContacts(null);
             }
             
             //Campos adicionais
           /*  foreach (get_object_vars($customer->CustomFields) as $key => $val) {
             	 $customfield[$key]= strval($val);
             }
             $this->setCustomFields($customfield);
             */
             //Retorno
 	 	 	 return $this;
 	 	 	
 	 	 }  	 	 
 	 	 
 	 }
 	 
 	 public function loadXML($xml) {
 	 	 foreach ($xml->Customer as $id => $customer) { 
 	 	 	 //Dados
 	 	 	 $this->setCustomerId(strval($customer->CustomerID));
 	 	 	 $this->setName(strval($customer->Name));
 	 	 	 $this->setPaymentsDue(intval($customer->PaymentsDue));
 	 	 	 $this->setCurrencyCode(strval($customer->CurrencyCode));
 	 	 	 $this->setNotes(strval($customer->Notes));
 	 	 	 //Endereço da Fatura
 	 	 	 $this->setBillingAddress(strval($customer->BillingAddress));
 	 	 	 $this->setBillingCity(strval($customer->BillingCity));
 	 	 	 $this->setBillingState(strval($customer->BillingState));
 	 	 	 $this->setBillingZip(strval($customer->BillingZip));
 	 	 	 $this->setBillingCountry(strval($customer->BillingCountry));
 	 	 	 $this->setBillingFax(strval($customer->BillingFax));
 	 	 	 //Endereço de Entrega
 	 	 	 $this->setShippingAddress(strval($customer->ShippingAddress));
 	 	 	 $this->setShippingCity(strval($customer->ShippingCity));
 	 	 	 $this->setShippingState(strval($customer->ShippingState));
 	 	 	 $this->setShippingZip(strval($customer->ShippingZip));
 	 	 	 $this->setShippingCountry(strval($customer->ShippingCountry));
 	 	 	 $this->setShippingFax(strval($customer->ShippingFax));
 	 	 	 //Observações
 	 	 	 $this->setNotes(strval($customer->Notes));
 	 	 	 //Contatos
 	 	 	 $contacts = get_object_vars($customer->Contacts);
 	 	 	 if (count($contacts) > 0) {
 	 	 	 	 foreach($contacts['Contact'] as $key=>$val){
 	 	 	 	 	 if (count($val) > 0) { 	 
 	 	 	 	 	 	 if ($key == 0) {
 	 	 	 	 	 	 	 $contact['Contact' . ($key + 1)]= get_object_vars($val);
 	 	 	 	 	 	 }
 	 	 	 	 	 } else {
 	 	 	 	 	 	 $contact['Contact1'][$key]= strval($val);
 	 	 	 	 	 }
 	 	 	 	 }
 	 	 	 	 $this->setContacts($contact);
             } else {
             	 $this->setContacts(null);
             }
             
             //Campos adicionais
           /*  foreach (get_object_vars($customer->CustomFields) as $key => $val) {
             	 $customfield[$key]= strval($val);
             }
             $this->setCustomFields($customfield);
             */
             //Retorno
 	 	 	 return $this;
 	 	 	
 	 	 } 	 	 
 	 }
 	 
 	 public function updateCustomer($xml) {
 	 	
 	 	 $r = new HTTP_Request('https://invoice.zoho.com/api/customers/update');
 	 	 $r->setMethod('POST');
 	 	 $r->addPostData('ticket',$this->getTicket());
 	 	 $r->addPostData('apikey',$this->getApiKey());
 	 	 $r->addPostData('XMLString',$xml);
 	 	 $r->sendRequest();   	 	
 	 	 return simplexml_load_string($r->getResponseBody()); 	 	  	 	 
 	 }
 	 
 	 public function getCustomerPerPage($page = 1, $per_page = 10) {
 	 	 $r = new HTTP_Request('https://invoice.zoho.com/api/customers/');
 	 	 $r->setMethod("GET");
 	 	 $r->addQueryString('ticket',$this->getTicket());
 	 	 $r->addQueryString('apikey',$this->getApiKey());
 	 	 $r->addQueryString('Page',strval($page));
 	 	 $r->addQueryString('Per_Page', strval($per_page));
 	 	 $r->sendRequest();
 	 	 return simplexml_load_string($r->getResponseBody()); 	 	 
 	 } 	 
 	 
 	 public function createCustomer($xml) {
 	 	 $r = new HTTP_Request('https://invoice.zoho.com/api/customers/create');
 	 	 print_r($xml);
 	 	 $r->setMethod('POST');
 	 	 $r->addPostData('ticket',$this->getTicket());
 	 	 $r->addPostData('apikey',$this->getApiKey());
 	 	 $r->addPostData('XMLString',$xml);
 	 	 $r->sendRequest();   	 	
 	 	 return simplexml_load_string($r->getResponseBody()); 	 	 
 	 }
 	 	 
 	 
 	 public function getCustomer($CustomerID) {
 	 	 $r = new HTTP_Request('https://invoice.zoho.com/api/customers/' . $CustomerID);
 	 	 $r->setMethod("GET");
 	 	 $r->addQueryString('ticket',$this->getTicket());
 	 	 $r->addQueryString('apikey',$this->getApiKey());
 	 	 $r->sendRequest();  	 	  	 	 
 	 	 return simplexml_load_string($r->getResponseBody());
 	 }
 	 
 }
 
?>
