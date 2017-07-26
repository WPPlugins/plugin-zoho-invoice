		<style type="text/css" media="screen">	
 	 			#zohotable {
 	 				background-color: #F7F7F7;
 	 				border-bottom: 1px solid #ECECEC;
 	 				border-top: 1px solid #ECECEC;
 	 			} 
 	 			#zohoenvio { 	 				
 	 				display:none;
 	 			}
 	 		   </style>
		<h3>Zoho Dados Cliente</h3>

		<table class="form-table" id="zohotable">
        <tr>
        	<th><label for="Salutation">Gostaria de ser chamado?</label></th>
        	<td>{Salutation}</td>
		</tr>				
		<tr>
        	<th><label for="Name">Nome ou Razão Social</label></th>
        	<td><input type="text" name="Name" id="Name" value="{Name}" /></td>
        </tr>
		<tr>
        	<th><label for="Phone">Telefone Contato</label></th>
        	<td><input type="text" name="Phone" id="Phone"  value="{Phone}" /></td>        	
        </tr>        
		<tr>
        	<th><label for="Mobile">Celular Contato</label></th>
        	<td><input type="text" name="Mobile" id="Mobile"  value="{Mobile}" /></td>        	
        </tr>    
        <tr>
        	<th><label for="PaymentsDue">Termos Pagamento</label></th>
        	<td>{PaymentsDue}</td>
		</tr>
        </table>
        <br />
        <h3>Zoho Endereço de Cobrança</h3>
        <table class="form-table" id="zohotable">
		<tr>
        	<th><label for="BillingAddress">Endereço de Cobrança</label></th>
        	<td><textarea style="height: 50px;" rows="3" name="BillingAddress" id="BillingAddress" isnullable="true" >{BillingAddress}</textarea></td> 
        </tr>  
		<tr>
        	<th><label for="BillingCity">Cidade</label></th>
        	<td><input type="text" name="BillingCity" id="BillingCity" value="{BillingCity}" /></td>
        </tr>
		<tr>
        	<th><label for="BillingState">Estado/Província</label></th>
        	<td><input type="text" name="BillingState" id="BillingState" value="{BillingState}" /></td>
        </tr>
		<tr>
        	<th><label for="BillingZip">CEP/Código Postal</label></th>
        	<td><input type="text" name="BillingZip" id="BillingZip" value="{BillingZip}" /></td>
        </tr>
		<tr>
        	<th><label for="BillingCountry">País</label></th>
        	<td><input type="text" name="BillingCountry" id="BillingCountry" value="{BillingCountry}" /></td>
        </tr> 
		<tr>
        	<th><label for="BillingFax">Fax</label></th>
        	<td><input type="text" name="BillingFax" id="BillingFax" value="{BillingFax}" /></td>
        </tr>
		<tr>
        	<th><label for="Envio">Endereço de Envio</label></th>
        	 
        	<td><input onclick="javascript:jQuery('#zohoenvio').toggle();" id="Envio" type="checkbox" {ENVIOCKECK}> <label>Eu gostaria de informar o endereço de envio separadamente.</label></td>
        </tr>        
        
        </table>
        
        <div id="zohoenvio">
        <br />
        <h3>Zoho Endereço de Envio</h3>
        <table class="form-table" id="zohotable">
		<tr>
        	<th><label for="ShippingAddress">Endereço de Cobrança</label></th>
        	<td><textarea style="height: 50px;" rows="3" name="ShippingAddress" id="ShippingAddress" isnullable="true" >{ShippingAddress}</textarea></td> 
        </tr>  
		<tr>
        	<th><label for="ShippingCity">Cidade</label></th>
        	<td><input type="text" name="ShippingCity" id="ShippingCity" value="{ShippingCity}" /></td>
        </tr>
		<tr>
        	<th><label for="ShippingState">Estado/Província</label></th>
        	<td><input type="text" name="ShippingState" id="ShippingState" value="{ShippingState}" /></td>
        </tr>
		<tr>
        	<th><label for="ShippingZip">CEP/Código Postal</label></th>
        	<td><input type="text" name="ShippingZip" id="ShippingZip" value="{ShippingZip}" /></td>
        </tr>
		<tr>
        	<th><label for="ShippingCountry">País</label></th>
        	<td><input type="text" name="ShippingCountry" id="ShippingCountry" value="{ShippingCountry}" /></td>
        </tr> 
		<tr>
        	<th><label for="ShippingFax">Fax</label></th>
        	<td><input type="text" name="ShippingFax" id="ShippingFax" value="{ShippingFax}" /></td>
        </tr>          
        </table>
        </div>
        {ENVIOSCRIPT}
