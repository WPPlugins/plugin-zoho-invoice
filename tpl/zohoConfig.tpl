<style type="text/css">

.stats{}
.stats DT{ font-weight: bold; }
.stats DD{ font-style:italic; border-bottom: 1px dashed #E1E1E1;}

</style>
{UPDATED}
<div class="wrap" id="bbuinfo_config">
  <h2>Configurações do Plugin Zoho Invoice</h2>
  <form name="mpp_config_form" method="post">
  <p>Para funcionar o Plugin Zoho Invoice cadastre sua APIKEY, Usuário e Senha:<br>
    </p>
  <table width="75%" border="0" cellpadding="0" cellspacing="0">
    <tr>
      	<td>
      		<strong>ApiKey:</strong>
      	</td>
      	<td>
      		<input dir="ltr" id="apikey" name="apikey" style="width: 50%;"  type="text" value="{APIKEY}"/>
      	</td>
    </tr>
    
    <tr>
    	<td>
    		<strong>Usuário:</strong>
    	</td>      
    	<td>
      		<input dir="ltr" id="usuario" name="usuario" style="width: 25%;"  type="text" value="{USUARIO}" />
      	</td>
    </tr>
    <tr>
    	<td>
    		<strong>Senha:</strong>
    	</td>      
    	<td>
      		<input dir="ltr" id="senha" name="senha" style="width: 25%;"  type="password" value="{SENHA}" />
      	</td>
    </tr>    
    <tr>
    	<td colspan="2">
    	<center>
    	<input value="Adicionar" name="submit" type="submit" />
    	</center>
    	</td>
    </tr>
  </table>
  <h3>Ticket fornecido pela zoho e data do vencimento e atualização automática:</h3>
  <ol>
    {TICKET} ---- {DATA}
  </ol>  
  </form>
  
</div>
