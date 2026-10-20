<?php
require("head_admin.php");



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

function verif_touche(e)
	{
        if(e.keyCode)touche = e.keyCode;
        else touche = e.which;
        if((touche>=48 && touche <= 57) || (touche==8) || (touche==9)) return true;
        else return false;
	}



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

$query_tipos=db_query("select id_tipo,nometipo,sigla from admin_tipo where nometipo<>'Ata' order by nometipo", array());

$documento=$_POST['documento'];
$docs_numero=0;
while ($tipo=db_fetch_row($query_tipos))
        {
        if (isset($_POST['documento']) and $documento[$tipo[0]]!="nulo") $docs_numero=$docs_numero+1;
        }


//echo "a variavel docs é: ".$docs_numero;

if (($docs_numero!=1) or (!isset($_POST['unbdoc'])) or !ctype_digit($_POST['unbdoc'])) 
{

	if ($docs_numero>1) $mensagem="SELECIONE APENAS UM DOCUMENTO!"; else $mensagem="";
	if (!isset($_POST['unbdoc']) and ($docs_numero==1)) $mensagem2="INCLUA UM N<SUP>o</SUP> DE UNBDOC!"; else $mensagem2="";
//	if (!is_int($_POST['unbdoc'])) $mensagem4="Deve ser um n&uacute;mero"; else $mensagem4="";
?>
<form action="vincula_unbdoc.php" method="post" enctype="multipart/form-data">

	<tr><td colspan=2><b>Escolha o documento:  <blink><?php echo $mensagem;?></blink></b></td></tr>
	
<?php
	$query_tipos=db_query("select id_tipo,nometipo,sigla from admin_tipo where nometipo<>'Ata' order by nometipo", array());
	while($tipo=db_fetch_row($query_tipos))
		{
		$query_documentos="select ad.id_documentador as id_documentador,ad.numerodocumento as numerodocumento,SUBSTR(ad.data,1,2) as dia,SUBSTR(ad.data,4,2) as mes,SUBSTR(ad.data,7,4) as ano ,add.nomedepartamento as destino,ad.assunto as assunto from admin_documentador ad,admin_departamento add where ad.id_tipo=? and add.id_departamento=ad.id_departamento order by ano desc,mes desc,dia desc,numerodocumento desc"; $query_documentos__p = array($tipo[0]); 
		$query_tipo[$tipo[0]]=db_query($query_documentos, $query_documentos__p);
		echo "<tr><td><b>".strtoupper($tipo[1]).":</b></td><td> <select name='documento[".$tipo[0]."]' style=\"width: 500px\"><option value=\"nulo\" selected> --- </option>";
		$cor_de_fundo="#FFFFFF";
		while($registro=db_fetch_row($query_tipo[$tipo[0]]))
			{
			$query_unbdoc=db_query("select unbdoc from admin_unbdoc where id_documentador=?", array($registro[0]));
			$unbdoc_registro=db_fetch_row($query_unbdoc);

			if ($registro[0]==$documento[$tipo[0]]) $selected="selected"; else $selected="";

			if ($cor_de_fundo=="#FFFFFF") $cor_de_fundo="#E9967A"; else $cor_de_fundo="#FFFFFF";
			echo "<option value=\"".$registro[0]."\" style=\"COLOR: #000000; BACKGROUND-COLOR: ".$cor_de_fundo."\" ".$selected.">".$tipo[2]." ".$registro[1]." de ".$registro[2]."/".$registro[3]."/".$registro[4]."   DESTINO:".$registro[5]."  ||  UnBDoc N<sup>o</sup>: ".$unbdoc_registro[0]."</option>";
			}
		echo "</select> <br></td></tr>";
		}

?>

<tr><td><b>INCLUIR/ATUALIZAR UnBDoc vinculado ao documento escolhido:</b><blink><?php echo $mensagem2;?><?php echo $mensagem4;?></blink></td><td> <input type="text" name='unbdoc' size=6 onkeypress="return verif_touche(event);"  />/
    	<select name='ano_unbdoc'>
<?php
//onkeypress="return verif_touche(event);"
	$ano_atual=date(Y);
	$ano_fim=$ano_atual-11;
	for ($indice_ano=$ano_atual;$indice_ano>$ano_fim;$indice_ano--)
		{
		if ($indice_ano==$ano_atual) $selected="selected"; else $selected="";
		echo "<option value='".$indice_ano."' ".$selected." >".$indice_ano."</option>";
		}
?>	
	</select></td>
</tr>
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

if (($docs_numero==1) and isset($_POST['unbdoc'])  and ctype_digit($_POST['unbdoc'])) //and !isset($_POST['confirmar']))
{

$documento=$_POST['documento'];
$unbdoc_dado=$_POST['unbdoc'];
$ano_unbdoc=$_POST['ano_unbdoc'];

$query_tipos=db_query("select id_tipo,nometipo,sigla from admin_tipo where nometipo<>'Ata' order by nometipo", array());
        while($tipo=db_fetch_row($query_tipos))
		{
		if ($documento[$tipo[0]]!="nulo") {$documento=$documento[$tipo[0]]; break;}
		}

$unbdoc=$unbdoc_dado."/".$ano_unbdoc;


if (is_int($unbdoc_dado)) echo "inteiro!"; else "nao e inteiro!";


$query_unbdoc=db_query("select * from admin_unbdoc where id_documentador=?", array($documento));
$num_query=db_num_rows($query_unbdoc);

if ($num_query==0) 
	{
	//incluir 
	$query_incluir="insert into admin_unbdoc values (?,?)"; $query_incluir__p = array($documento, $unbdoc);
	$res_query=db_query($query_incluir, $query_incluir__p) or die ("problema de conexao com o banco de dados");
//	echo $query_incluir;
	echo "UnBDoc inserido com sucesso";
	}
	else 
	{
	//atualizar
        $query_atauliza="update admin_unbdoc set unbdoc=? where id_documentador=?"; $query_atauliza__p = array($unbdoc, $documento);
      $res_query=db_query($query_atauliza, $query_atauliza__p) or die ("problema de conexao com o banco de dados");
//        echo $query_atauliza;
	echo "UnBDoc atualizado com sucesso";
	}
?>

</table>
</td></tr>
</table>
</body>
</html>

<?php
}
db_close($idconn);
?>

