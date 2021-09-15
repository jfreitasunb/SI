<?php
require "verifica.php";
require "cabecalho.html";
?>

	<h1>Servidor Administrativo</h1>

<?php
 
	if(!isset($_POST["model"]))
	{
?>
	<p>Selecione abaixo <i>modelo</i> caso queira utilizar um modelo pré-
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
	echo"
	<p>Selecione abaixo o tipo de modelo que deseja utilizar.</p>
        <form action='gerar_modelo.php' method='post'>
        <table>
            <tr>
                <td><select name= 'tipo_modelo' size='1'>";
                	require "conexao.php";
			$r=pg_query("SELECT id_modelo,campo_1 FROM admin_modelo")or
			die("Não foi possível executar a operação");
			while($re=pg_fetch_row($r))
				{
				$cod=$re[0];
				$nome=$re[1];
				echo"<option value='$cod'>$nome</option>\n";
				}
	echo"
		</select></td></tr></table><br>
        <input  type='submit' value='Selecionar'>
        </form>
        </div>";
        }

	else if($_POST["model"]=="2")
	{
	echo"
	<p>Selecione abaixo o tipo de documento que deseja criar.</p> 
        <form action='gerar_documento.php' method='post'>
        <table> 
            <tr>
                <td><select name= 'tipo_documento' size='1'>";
			require "conexao.php";
			 $res=pg_query("SELECT id_tipo,nometipo FROM admin_tipo") or die ("Não foi possível consultar o banco.");
                while($registro=pg_fetch_row($res,$i))
                {
                        $cod=$registro[0];
                        $nome=$registro[1];
                        echo"<option value=$cod>$nome</option>\n";
                }
                
                echo"</select></td></tr></table><br>";
        	echo"<input  type='submit' value='Selecionar'> 
        	</form> 
        	</div>"; 
        	}



require "menu.php"; ?>
