<?php
  include("head_admin.php");
?>
<html>
<header>
    <script language=javascript src="function_js.js">
    </script>
    <script language=javascript src="formu.js">
    </script>
    <link type="text/css" rel="stylesheet" href="../../global/grafic.css">
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
  </header>
<body>
<table class=big>
      <tr>
        <td class=header align=center>
          <h1>Departamento de Matem&aacute;tica</h1>
        </td>
      </tr>
      <tr>
        <td align=center>
               <title>Servidor Administrativo</title>
<?php
if(!isset($_POST["model"]))
{
?>
	<table class=form>
	<p>Selecione abaixo <i>modelo</i> caso queira utilizar um modelo pr&eacute;-
	exixtente ou <i>novo</i> caso queira iniciar novo documento.</p>
	<form action='gerar1.php' method='post'>
	<table>
            <tr>
        	<td><select name= 'model' size='1'>
                      <option value=1>Modelo</option>
			<option value=2>Novo</option>
		</select></td></tr></table><br>
	<input  type='submit' value='Selecionar'>
	</form>
	</div>
<?php
	}
	else if($_POST["model"]=="1")
	{
?>
	<p>Selecione abaixo o tipo de modelo que deseja utilizar.</p>
        <form action='gerar_modelo.php' method='post'>
        <table>
            <tr>
                <td><select name= 'tipo_modelo' size='1'>
<?php
                	$r=pg_query("SELECT id_modelo,assunto FROM admin_modelo")or
			die("Nao foi possivel executar a operacao");
			while($re=pg_fetch_row($r))
				{
				$cod=$re[0];
				$nome=$re[1];
				echo "<option value='".$cod."'>".$nome."</option>\n";
				}
?>
		</select></td></tr></table><br>
        <input  type='submit' value='Selecionar'>
        </form>
        </div>
<?php
        }

	else if($_POST["model"]=="2")
	{
?>
	<p>Selecione abaixo o tipo de documento que deseja criar.</p>
        <form action='gerar_documento.php' method='post'>
        <table>
            <tr>
                <td><select name='tipo_documento' size='1'>
<?php
		$res=pg_query("SELECT id_tipo,nometipo FROM admin_tipo") or die ("Nao foi possivel consultar o banco.");
		$i=0;
                while($registro=pg_fetch_row($res,$i))
                {
                        $cod=$registro[0];
                        $nome=$registro[1];
                        echo "<option value='".$cod."' >".$nome."</option>\n ";
			$i=$i+1;
                }
?>
                </select></td></tr></table><br>
        	<input  type='submit' value='Selecionar'>
        	</form>
        	</div>
<?php
        	}
 ?>
</table>
