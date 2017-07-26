
<div class="wrap">
	<div id="icon-users" class="icon32"><br></div>

<h2>Cliente do Zoho para importação</h2>
<p>Clique em importar o cliente ou selecione todos para importar.</p>
{MSG}


<form method="post">
<br /><input type="checkbox" name="notificar" value="1">Criar senha automaticamente e encaminhar ao cliente por email.
<div class="tablenav">		
{NAV}
	<div class="alignleft actions">
		<select name="action1">
			<option value="" selected="selected">Ações em Massa</option>
			<option value="1">Importar</option>
		</select>
		<input type="submit" value="Aplicar" name="doaction1" id="doaction1" class="button-secondary action" />
	</div>
	<br class="clear" />
</div>
<table class="widefat fixed" cellspacing="0">
<thead>
<tr class="thead">
	<th scope="col" id="cb" class="manage-column column-cb check-column" style=""><input type="checkbox"></th>
	<th scope="col" id="name" class="manage-column column-name" style="">Nome da Empresa/Pessoa</th>
</tr>
</thead>

<tfoot>
<tr class="thead">
	<th scope="col" class="manage-column column-cb check-column" style=""><input type="checkbox"></th>	
	<th scope="col" class="manage-column column-name" style="">Nome da Empresa/Pessoa</th>	
</tr>
</tfoot>


	<tbody id="users" class="list:user user-list">
		{LISTA}
	</tbody>
</table>
			
<div class="tablenav">		
{NAV}
	<div class="alignleft actions">
		<select name="action2">
			<option value="" selected="selected">Ações em Massa</option>
			<option value="1">Importar</option>
		</select>
		<input type="submit" value="Aplicar" name="doaction2" id="doaction2" class="button-secondary action" />
	</div>
	<br class="clear" />
</div>
</div>
</form>
