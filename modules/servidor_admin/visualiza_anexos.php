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
//if (!isset($_POST['continuar']) or isset($_POST['voltar']))
//{
//        echo $_FILES['userfile']['path'][0]."/".$_FILES['userfile']['name'][0];
//	echo $_FILES['userfile']['name'][1];
  //      echo $_FILES['userfile']['name'][2];
    //    echo $_FILES['userfile']['name'][3];


//	echo $_FILES['userfile']['name'][0];
//	echo $_FILES['userfile']['type'][0];
//	echo $_FILES['userfile']['size'][0];
//	echo $_FILES['userfile']['tmp_name'][0];


/*	if (isset($_POST['voltar']))
	{
	$documento=$_POST['documento'];
//	$arquivo=$_FILES['userfile']['path'][0]."/".$_FILES['userfile']['name'][0]."- ".$_FILES['userfile']['size'][0];	
	} 
*/	

	if ($docs_numero>1) $mensagem="SELECIONE APENAS UM DOCUMENTO!"; else $mensagem="";


/*        <tr>
        <td align=center>
               <title>Servidor Administrativo- Anexos de documentos</title>
        <table class=form>
*/
?>
<form action="visualiza_anexos.php" method="post" enctype="multipart/form-data" OnSubmit="return champsok()">

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
        if ($documento[$tipo[0]]!="nulo") {$id_documento=$documento[$tipo[0]]; $sigla=$tipo[2];}
        }

// Pasta onde o arquivo vai ser salvo
$_UP['pasta'] = 'http://www.mat.unb.br/si/modules/servidor_admin/anexos/';
 
// tabela admin_anexos: id_documento, numero_anexo, nome_arquivo

$query_anexos=pg_query("select nome_arquivo,numero_anexo from admin_anexos where id_documento='".$id_documento."' order by numero_anexo");
$query_documento=pg_query("select numerodocumento,SUBSTR(data,1,2) as dia,SUBSTR(data,4,2) as mes,SUBSTR(data,7,4) as ano from admin_documentador where id_documentador='".$id_documento."'");
$documento=pg_fetch_array($query_documento);

echo "<tr><td colspan=2><b>Lista de anexos ao documento :".$sigla." ".$documento['numerodocumento']." de ".$documento['dia']."/".$documento['mes']."/".$documento['ano']."</b></td></tr>";


while ($registro=pg_fetch_row($query_anexos))
	{
	echo "<br /><a href=\"" . $_UP['pasta'] . $registro[0] . "\"> ".$registro[0]. " Clique aqui para acessar o arquivo</a>";
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

