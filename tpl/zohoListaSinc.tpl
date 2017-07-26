<form method="post">
<div class="wrap">
	<div id="icon-users" class="icon32"><br></div>
<h2>Clientes que não estão sincronizados com o Zoho Invoice</h2>
{MSG}
<div class="tablenav">		
{NAV}
	<div class="alignleft actions">
		<select name="action1">
			<option value="" selected="selected">Ações em Massa</option>
			<option value="1">Sincronizar</option>
			<option value="2">Cancelar Sincronia</option>
		</select>
		<input type="submit" value="Aplicar" name="doaction1" id="doaction1" class="button-secondary action" />
	</div>
	<br class="clear" />
</div>
<table class="widefat fixed" cellspacing="0">
<thead>
<tr class="thead">
	<th scope="col" id="cb" class="manage-column column-cb check-column" style=""><input type="checkbox"></th>
	<th scope="col" id="username" class="manage-column column-username" style="">Nome de usuário</th>
	<th scope="col" id="name" class="manage-column column-name" style="">Nome</th>
	<th scope="col" id="email" class="manage-column column-email" style="">Email</th>
	<th scope="col" id="role" class="manage-column column-role" style="">Função</th>
	<th scope="col" id="posts" class="manage-column column-posts num" style="">Posts</th>
	<th scope="col" id="uam_access" class="manage-column column-uam_access" style="">Access</th>
</tr>
</thead>

<tfoot>
<tr class="thead">
	<th scope="col" class="manage-column column-cb check-column" style=""><input type="checkbox"></th>
	<th scope="col" class="manage-column column-username" style="">Nome de usuário</th>
	<th scope="col" class="manage-column column-name" style="">Nome</th>
	<th scope="col" class="manage-column column-email" style="">Email</th>

	<th scope="col" class="manage-column column-role" style="">Função</th>
	<th scope="col" class="manage-column column-posts num" style="">Posts</th>
	<th scope="col" class="manage-column column-uam_access" style="">Access</th>

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
			<option value="1">Sincronizar</option>
			<option value="2">Cancelar Sincronia</option>
		</select>
		<input type="submit" value="Aplicar" name="doaction2" id="doaction2" class="button-secondary action" />
	</div>
	<br class="clear" />
</div>
</div>
</form>
