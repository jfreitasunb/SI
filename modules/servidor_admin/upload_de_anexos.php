<?php
include("head_admin.php");



/*
1- mostrar a lista de documentos - dropdown de documentos por categoria: select - deixar as atas de lado (serão tratadas em outro formulário) escolhe o documento.
2- selciona um ou mais arquivos para upload. o documento esta mostrado na pagina com possibilidade de voltar e mudar o documento.
3- registra a seleção; só pode ser arquivo do tipo ... e de um certo tamanho
4- salva o(s) arquivo(s) no diretorio de anexos. Renomear o arquivo: id_documentador_X.extensao em que X é o numero do anexo
5- inscreve na tabela admin_anexos: id_documentador, nome_do_arquivo, nome_diretorio(anexos,audios)

------ para audios das atas
1) O usuário faz o upload para um diretório específico;
2) O usuário abre a tela do sistema, digita as informações de data e outras coisas. O SI apresenta os arquivos que estão no diretório do servidor para o usuário selecionar qual ele enviou.
3) Após confirmação do usuário, o SI renomeia o arquivo e muda ele para a pasta correta, onde o usuário não teria acesso nem via FTP.
-------

*/



?>
<html>
<header>

<script language="javascript">

      var count=1;

      function cache_tout()
      {
        document.getElementById("entete1").style.visibility="hidden";
        document.getElementById("entete2").style.visibility="hidden"; 
<?php
        for($i=1;$i<21;$i++)
          echo "document.getElementById(\"id".$i."\").style.visibility=\"hidden\";";
?>
      }

      function compte(nb)
      {
        count=1;
        if (nb>20)
          nb=20;
        cache_tout();
        for(i=0;i<nb;i++)
          montre();
      }
 function champsok()
      {
        if (document.forms["formu"].mod_name.value.length == 0)
        {
          alert("Le champs correpsondant au nom du module est obligatoire. Veuillez le renseigner, svp.");
          document.forms["formu"].mod_name.focus();
          return false;
        }
        if (document.forms["formu"].mod_url.value.length == 0)
        {
          alert("Le champs correpsondant a l'url du module est obligatoire. Veuillez le renseigner, svp.");
          document.forms["formu"].mod_url.focus();
          return false;
        }
        if (document.forms["formu"].descr.value.length == 0)
        {
          alert("Le champs correpsondant a la description du module est obligatoire. Veuillez le renseigner, svp.");
          document.forms["formu"].mod_name.focus();
          return false;
        }
        return true;
      }

    </script>
    <script language=javascript src="./scripts_uploads/function_js.js">
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
               <title>Servidor Administrativo- Anexos de documentos</title>
        <table class=form>
<?php

$query_tipos=pg_query("select id_tipo,nometipo,sigla from admin_tipo where nometipo<>'Ata' order by nometipo");

$documento=$_POST['documento'];
$docs_numero=0;
while ($tipo=pg_fetch_row($query_tipos))
        {
        if (isset($_POST['documento']) and $documento[$tipo[0]]!="nulo") $docs_numero=$docs_numero+1;
        }


//echo "a variavel docs é: ".$docs_numero;

if ($docs_numero!=1) 
{

	if ($docs_numero>1) $mensagem="SELECIONE APENAS UM DOCUMENTO!"; else $mensagem="";


?>
<form action="upload_de_anexos.php" method="post" enctype="multipart/form-data" OnSubmit="return champsok()">

	<tr><td colspan=2><b>Escolha o documento correspondente ao anexo:  <blink><?php echo $mensagem;?></blink></b></td></tr>
	
<?php
	$query_tipos=pg_query("select id_tipo,nometipo,sigla from admin_tipo where nometipo<>'Ata' order by nometipo");
	while($tipo=pg_fetch_row($query_tipos))
		{
		$query_documentos="select ad.id_documentador as id_documentador,ad.numerodocumento as numerodocumento,SUBSTR(ad.data,1,2) as dia,SUBSTR(ad.data,4,2) as mes,SUBSTR(ad.data,7,4) as ano ,add.nomedepartamento as destino,ad.assunto as assunto from admin_documentador ad,admin_departamento add where ad.id_tipo='".$tipo[0]."' and add.id_departamento=ad.id_departamento order by ano desc,mes desc,dia desc,numerodocumento desc"; 
		$query_tipo[$tipo[0]]=pg_query($query_documentos);
		echo "<tr><td><b>".strtoupper($tipo[1]).":</b></td><td> <select name='documento[".$tipo[0]."]' style=\"width: 500px\"><option value=\"nulo\" selected> --- </option>";
		$cor_de_fundo="#FFFFFF";
		while($registro=pg_fetch_row($query_tipo[$tipo[0]]))
			{
			if ($registro[0]==$documento[$tipo[0]]) $selected="selected"; else $selected="";

			if ($cor_de_fundo=="#FFFFFF") $cor_de_fundo="#E9967A"; else $cor_de_fundo="#FFFFFF";
			echo "<option value=\"".$registro[0]."\" style=\"COLOR: #000000; BACKGROUND-COLOR: ".$cor_de_fundo."\" ".$selected.">".$tipo[2]." ".$registro[1]." de ".$registro[2]."/".$registro[3]."/".$registro[4]."   DESTINO:".$registro[5]."</option>";
			}
		echo "</select> <br></td></tr>";
		}

?>
		<tr></tr><tr></tr><tr></tr><tr></tr><tr></tr>
		<tr><td colspan=2><b>Escolha o arquivo de anexo para upload:</b></td></tr>



	<tr><td>Arquivo 1:</td><td><input type=file name='arquivo[]'></td></tr>
	<tr><td>Arquivo 2:</td><td><input type=file name='arquivo[]'></td></tr>
	<tr><td>Arquivo 3:</td><td><input type=file name='arquivo[]'></td></tr>
	<tr><td>Arquivo 4:</td><td><input type=file name='arquivo[]'></td></tr>
	<tr><td>Arquivo 5:</td><td><input type=file name='arquivo[]'></td></tr>

<tr><td colspan=2 align=center><input type="submit" name='continuar' value="Confirmar" /></td></tr>
</form>
</table>
</td></tr>
</table>
</body>
</html>
<?php
//}
}

if ($docs_numero==1) //and !isset($_POST['confirmar']))
{
$query_tipos=pg_query("select id_tipo,nometipo,sigla from admin_tipo where nometipo<>'Ata' order by nometipo");

$documento=$_POST['documento'];

while ($tipo=pg_fetch_row($query_tipos))
        {
        if ($documento[$tipo[0]]!="nulo") $id_documento=$documento[$tipo[0]];
        }



// Pasta onde o arquivo vai ser salvo
$_UP['pasta'] = '/paginas/si/modules/servidor_admin/anexos/';
 
// Tamanho máximo do arquivo (em Bytes)
$_UP['tamanho'] = 1024 * 1024 * 2; // 2Mb
 
// Array com as extensões permitidas
$_UP['extensoes'] = array('jpg', 'png', 'gif','pdf');
	 
// Renomeia o arquivo? (Se true, o arquivo será salvo como .jpg e um nome único)
$_UP['renomeia'] = true;
 
// Array com os tipos de erros de upload do PHP
$_UP['erros'][0] = 'N&atilde;o houve erro';
$_UP['erros'][1] = 'O arquivo no upload &eacute; maior do que o limite do PHP';
$_UP['erros'][2] = 'O arquivo ultrapassa o limite de tamanho especifiado no HTML';
$_UP['erros'][3] = 'O upload do arquivo foi feito parcialmente';
$_UP['erros'][4] = 'N&atilde;o foi feito o upload do arquivo';


// tabela admin_anexos: id_documento, numero_anexo, nome_arquivo

$query_anexos=pg_query("select numero_anexo from admin_anexos where id_documento='".$id_documento."' order by numero_anexo desc limit 1");
$numero=pg_fetch_row($query_anexos);
if (!empty($numero)) $j=$numero[0]; else $j=0;


//echo "j=".$j;
//echo " | id_documento=".$id_documento;

for ($i=0;$i<5;$i++)
	{
	$numero_anexo=$j+$i+1;

//	echo " | numero_anexo=".$numero_anexo;
//	echo "| nome do arquivo: ".$_FILES['arquivo']['name'][$i];

	if ($_FILES['arquivo']['name'][$i]!="")
		{
		//############### CASO ESTEJA PRONTO PARA UPLOAD
		// Verifica se houve algum erro com o upload. Se sim, exibe a mensagem do erro
		if ($_FILES['arquivo']['error'][$i] != 0) 
			{
			die("N&atilde;o foi poss&iacute;vel fazer o upload, erro:<br />" . $_UP['erros'][$_FILES['arquivo']['error'][$i]]);
			exit; // Para a execução do script
			}
	 	// Caso script chegue a esse ponto, não houve erro com o upload e o PHP pode continuar
	 
		// Faz a verificação da extensão do arquivo
		$extensao = strtolower(end(explode('.', $_FILES['arquivo']['name'][$i])));
		if (array_search($extensao, $_UP['extensoes']) === false) 
			{
			echo "Por favor, envie arquivos com as seguintes extens&otilde;es: pdf, jpg, png ou gif";
			}
	 
		// Faz a verificação do tamanho do arquivo
			else if ($_UP['tamanho'] < $_FILES['arquivo']['size'][$i]) 
			{
			echo "O arquivo enviado &eacute; muito grande, envie arquivos de at&eacute; 2Mb.";
			}
	 
		// O arquivo passou em todas as verificações, hora de tentar movê-lo para a pasta
			else {
		// Primeiro verifica se deve trocar o nome do arquivo
				if ($_UP['renomeia'] == true) 
					{
		// Cria um nome baseado no UNIX TIMESTAMP atual e com extensão .jpg
					$nome_final = $id_documento."_".$numero_anexo.".".$extensao;
					} else 
					{
		// Mantém o nome original do arquivo
					$nome_final = $_FILES['arquivo']['name'][$i];
					}
	 
		// Depois verifica se é possível mover o arquivo para a pasta escolhida
				if (move_uploaded_file($_FILES['arquivo']['tmp_name'][$i], $_UP['pasta'] . $nome_final)) 
					{
		// Upload efetuado com sucesso, exibe uma mensagem e um link para o arquivo; insere ponteiro na tabela
					echo "Upload efetuado com sucesso!";
					echo '<br /><a href="http://www.mat.unb.br/si/modules/servidor_admin/anexos/'.$nome_final . '">Clique aqui para acessar o arquivo</a>';
					$query_insere="insert into admin_anexos values('".$id_documento."','".$numero_anexo."','".$nome_final."')";
//					echo $query_insere;
					$res_insere=pg_query($query_insere) or die ("problemas com a conexao ao banco de dados");
					} else 
					{
		// Não foi possível fazer o upload, provavelmente a pasta está incorreta
					echo "N&atilde;o foi poss&iacute;vel enviar o arquivo, tente novamente";
					}
	 
			     }
		
		}
	}
?>

</table>
</td></tr>
</table>
</body>
</html>

<?php

}
pg_close($idconn);
?>

