<form method="post" id="updateuser" class="user-forms" action="{ACTION_FORM}#full_width">			
<table>
	<tr>
		<td class="user_title" colspan="4">
			<h5>Dados Empresariais/Pessoais</h5>
		</td>
	</tr>
	<tr>
		<td colspan="4">
			<label for="Name">Nome ou Razão Social<strong> *</strong></label>
			<div class="input_esquerda"></div>
			<div class="input_centro">
				<input style="width:563px" class="campo" name="Name" type="text" value="{Name}" />
			</div>
			<div class="input_direita"></div>					
		</td>
	</tr>
	<tr>
		<td colspan="2">
			<label for="user_pass">Nova Senha</label>
			<div class="input_esquerda"></div>
			<div class="input_centro">
				<input style="width:200px" class="campo" name="pass1" type="password" value="{Pass1}" />
			</div>
			<div class="input_direita"></div>							
		</td>
		<td colspan="2">
			<label for="user_pass">Repete Nova Senha</label>
			<div class="input_esquerda"></div>
			<div class="input_centro">
				<input style="width:200px" class="campo" name="pass2" type="password" value="{Pass2}" />
			</div>
			<div class="input_direita"></div>							
		</td>						
	</tr>
	<tr>
		<td colspan="4">
			<label for="description">Observações</label>
			<div class="textarea_topo"></div>
			<div class="textarea_centro">
				<textarea rows="3" name="description">{Description}</textarea>
			</div>
			<div class="textarea_rodape"></div>							
		</td>
	</tr>					
	<tr>
		<td class="user_title" colspan="4">
			<h5>Dados para Contato</h5>
		</td>
	</tr>					
	<tr>
		<td>
			<label for="Name">Trat.</label>
			<div class="input_esquerda"></div>
			<div class="input_centro">
				{Salutation}
			</div>					
			<div class="input_direita"></div>
	
		</td>					
		<td>
			<label for="first_name">Nome</label>
			<div class="input_esquerda"></div>
			<div class="input_centro">
				<input style="width:200px" class="campo" name="first_name" type="text" value="{first_name}" />
			</div>
			<div class="input_direita"></div>						
		</td>
		<td colspan="2">
			<label for="last_name">Sobrenome</label>
			<div class="input_esquerda"></div>
			<div class="input_centro">
				<input style="width:225px" class="campo" name="last_name" type="text" value="{last_name}" />
			</div>
			<div class="input_direita"></div>
		</td>
	</tr>
	<tr>
		<td colspan="2" >
			<label for="email">Email<strong> *</strong></label>							
			<div class="input_esquerda"></div>
			<div class="input_centro">
				<input style="width:303px" class="campo" name="email" type="text" value="{user_email}" />
			</div>
			<div class="input_direita"></div>						
		</td>
		
		<td >
			<label for="Phone">Telefone</label>							
			<div class="input_esquerda"></div>
			<div class="input_centro">
				<input style="width:95px" id="Phone" class="campo" name="Phone" type="text" value="{Phone}" />
			</div>
			<div class="input_direita"></div>							
		</td>
		<td >
			<label for="Mobile">Celular</label>
			<div class="input_esquerda"></div>
			<div class="input_centro">
				<input style="width:95px" id="Mobile" class="campo" name="Mobile" type="text" value="{Mobile}" />
			</div>
			<div class="input_direita"></div>													
		</td>	
	</tr>	
						
	<tr>
		<td class="user_title" colspan="4">
			<h5>Endereço de Cobrança</h5>
		</td>
	</tr>	
	<tr>
		<td colspan="4">
			<label for="BillingAddress">Endereço de Cobrança</label>
			<div class="textarea_topo"></div>
			<div class="textarea_centro">
				<textarea rows="3" name="BillingAddress">{BillingAddress}</textarea>
			</div>
			<div class="textarea_rodape"></div>							
		</td>
	</tr>
	<tr>
		<td colspan="2">
			<label for="BillingCity">Cidade</label>
			<div class="input_esquerda"></div>
			<div class="input_centro">
				<input style="width:250px" class="campo" name="BillingCity" type="text" value="{BillingCity}" />
			</div>
			<div class="input_direita"></div>													
		</td>
		<td colspan="2">
			<label for="BillingState">Estado</label>
			<div class="input_esquerda"></div>
			<div class="input_centro">
				<input style="width:225px" class="campo" name="BillingState" type="text" value="{BillingState}" />
			</div>
			<div class="input_direita"></div>													
		</td>						
	</tr>
	<tr>
		<td colspan="2">
			<label for="BillingZip">CEP</label>
			<div class="input_esquerda"></div>
			<div class="input_centro">
				<input style="width:250px" id="Cep1" class="campo" name="BillingZip" type="text" value="{BillingZip}" />
			</div>
			<div class="input_direita"></div>													
		</td>
		<td colspan="2">
			<label for="BillingCountry">País</label>
			<div class="input_esquerda"></div>
			<div class="input_centro">
				<input style="width:225px" class="campo" name="BillingCountry" type="text" value="{BillingCountry}" />
			</div>
			<div class="input_direita"></div>													
		</td>						
	</tr>	
	<tr>
		<td colspan="4">
			<label for="BillingFax">Fax</label>
			<div class="input_esquerda"></div>
			<div class="input_centro">
				<input style="width:250px" id="Fax1" class="campo" name="BillingFax" type="text" value="{BillingFax}" />
			</div>
			<div class="input_direita"></div>													
		</td>						
	</tr>
	 <tr>
		<td colspan="4">
			<input onclick="javascript:jQuery('.zohoenvio').toggle();" id="Envio" type="checkbox" {CHECK}>
			Eu gostaria de informar o endereço de envio separadamente.
		</td>					
	</tr> 	
	
	<tr class="zohoenvio">					
		<td class="user_title" colspan="4">						
			<h5>Endereço de Envio</h5>
		</td>
		
	</tr>	
	<tr class="zohoenvio">
		<td colspan="4">
			<label for="ShippingAddress">Endereço de Cobrança</label>
			<div class="textarea_topo"></div>
			<div class="textarea_centro">
				<textarea rows="3" name="ShippingAddress">{ShippingAddress}</textarea>
			</div>
			<div class="textarea_rodape"></div>							
		</td>
	</tr>
	<tr class="zohoenvio">
		<td colspan="2">
			<label for="ShippingCity">Cidade</label>
			<div class="input_esquerda"></div>
			<div class="input_centro">
				<input style="width:250px" class="campo" name="ShippingCity" type="text" value="{ShippingCity}" />
			</div>
			<div class="input_direita"></div>													
		</td>
		<td colspan="2">
			<label for="ShippingState">Estado</label>
			<div class="input_esquerda"></div>
			<div class="input_centro">
				<input style="width:225px" class="campo" name="ShippingState" type="text" value="{ShippingState}" />
			</div>
			<div class="input_direita"></div>													
		</td>						
	</tr>
	<tr class="zohoenvio">
		<td colspan="2">
			<label for="ShippingZip">CEP</label>
			<div class="input_esquerda"></div>
			<div class="input_centro">
				<input style="width:250px" id="Cep2" class="campo" name="ShippingZip" type="text" value="{ShippingZip}" />
			</div>
			<div class="input_direita"></div>													
		</td>
		<td colspan="2">
			<label for="ShippingCountry">País</label>
			<div class="input_esquerda"></div>
			<div class="input_centro">
				<input style="width:225px" class="campo" name="ShippingCountry" type="text" value="{ShippingCountry}" />
			</div>
			<div class="input_direita"></div>													
		</td>						
	</tr>	
	<tr class="zohoenvio">
		<td colspan="4">
			<label for="ShippingFax">Fax</label>
			<div class="input_esquerda"></div>
			<div class="input_centro">
				<input style="width:250px" id="Fax2" class="campo" name="ShippingFax" type="text" value="{ShippingFax}" />
			</div>
			<div class="input_direita"></div>													
		</td>						
	</tr>	
</table>					
<p>
	<input value="Atualizar" name="action" id="contactus" class="contactsubmit" type="submit">
</p>
</form>
{SCRIPT}
