<?php
  include("head_aliases.php");

$usuario=explode("-",$_POST['user']);

$coduser=$usuario[0];
$nome=$usuario[1];
$sobrenome=$usuario[2];

//$copias=$_POST['copias'];
//$file_base = 'impressao.txt';
//$file = 'quotas_impressao.txt';
//$linha=$usuario." ".$copias. "\n";


function retira_acentos($texto)
{
  $array1 = array("á","à","â","ã","ä","é","è","ê","ë","í","ì","î","ï","ó","ò","ô","õ","ö","ú","ù","û","ü","ç","Á","À","Â","Ã","Ä","É","È","Ê","Ë","Í","Ì","Î","Ï","Ó","Ò","Ô","Õ","Ö","Ú","Ù","Û","Ü","Ç");
  $array2 = array("a", "a", "a", "a", "a", "e", "e", "e", "e", "i", "i", "i", "i", "o", "o", "o", "o", "o", "u", "u", "u", "u", "c", "A", "A", "A", "A", "A", "E", "E", "E", "E", "I", "I", "I", "I", "O", "O", "O", "O", "O", "U", "U", "U", "U", "C" );

//  $table = array('á'=>'a','à'=>'a','â'=>'a','ã'=>'a','ä'=>'a','é'=>'e','è'=>'e','ê'=>'e','ë'=>'e','í'=>'i','ì'=>'i','î'=>'i','ï'=>'i','ó'=>'o','ò'=>'o','ô'=>'o','õ'=>'o','ö'=>'o','ú'=>'u','ù'=>'u','û'=>'u','ü'=>'u','ç'=>'c','Á'=>'A','À'=>'A','Â'=>'A','Ã'=>'A','Ä'=>'A','É'=>'E','È'=>'E','Ê'=>'E','Ë'=>'E','Í'=>'I','Ì'=>'I','Î'=>'I','Ï'=>'I','Ó'=>'O','Ò'=>'O','Ô'=>'O','Õ'=>'O','Ö'=>'O','Ú'=>'U','Ù'=>'U','Û'=>'U','Ü'=>'U','Ç'=>'C');
 $alias=str_replace($array1, $array2, $texto );
//  $alias=strtr( $texto, $table );
 return $alias;
} 

/*
function retira_acentos($var) {

	 $var = strtolower($var);
	 
	 $var = ereg_replace("[áàâãª]","a",$var);	
	 $var = ereg_replace("[éèê]","e",$var);		
	 $var = ereg_replace("[óòôõº]","o",$var);	
	 $var = ereg_replace("[úùû]","u",$var);		
	 $var = str_replace("ç","c",$var);
	 
	 return $var;
}
*/


/*
function retira_acentos ($string)
{
    $a = "ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿŔŕ";
    $b = "aaaaaaaceeeeiiiidnoooooouuuuybsaaaaaaaceeeeiiiidnoooooouuuyybyRr";
    $string = utf8_decode($string);    
    $string = strtr($string, utf8_decode($a), $b);
    $string = strtolower($string);
    return utf8_encode($string);
//    return $string;
} 
*/

function gera_alias($nome,$sobrenome)
{
$lista = array("DE","DA","DO","DOS","DAS"); 

$alias="";
$nome_0=explode(" ",trim(retira_acentos($nome)));
for ($i=0;$i<count($nome_0);$i++)
    {
    if (!(in_array(strtoupper($nome_0[$i]),$lista)))
       {
//       echo $nome_0[$i];
       $letras=chunk_split($nome_0[$i]);
//       $letras=explode($nome_0[$i]);
//    $inicial_nome[$i]=$letras[0];
	$alias=$alias.$letras[0].".";
	}
    }

$sobrenome_0=explode(" ",trim(retira_acentos($sobrenome)));
for ($i=0;$i<count($sobrenome_0);$i++)
    {
    if ($i==count($sobrenome_0)-1)
       {
       $alias=$alias.$sobrenome_0[$i];
	}
    else 
    	{
	if (!(in_array(strtoupper($sobrenome_0[$i]),$lista)))
	   {
	   $letras=chunk_split($sobrenome_0[$i]);
	   $alias=$alias.$letras[0].".";
	   }
	}
    }
return $alias;
}

function checa_alias($alias) 
{
$alias=retira_acentos($alias);
$alias_0=str_replace(" ",".",$alias);
$alias0=mb_convert_encoding($alias_0,"UTF-8");

$query_checa="select * from aliases where alias='".$alias0."' or alias2='".$alias0."'";
$res_query_checa=pg_query($query_checa);
$num_res_checa=pg_num_rows($res_query_checa);

if ($num_res_checa==0) $checa_alias="ok"; else $checa_alias="ja_existe_um";

return $checa_alias;
}


function grava_alias($coduser,$alias) 
{
$alias=retira_acentos($alias);
$alias_0=str_replace(" ",".",$alias);
$alias0=mb_convert_encoding($alias_0,"UTF-8");

$query_banco="select * from aliases where coduser='".$coduser."'";
$res_query=pg_query($query_banco);
$num_res=pg_num_rows($res_query);

if ($num_res!=0)
   {
   $query_grava="update aliases set alias2='".$alias0."' where coduser='".$coduser."'";
   $res=pg_query($query_grava);
   echo "Alias atualizado";
   }
   else 
   {
   $query_grava="insert into aliases values('".$coduser."','".$alias0."','')";
   $res=pg_query($query_grava);
   echo "Alias inserido";
   }
}



?>

<html>
  <header>
    <link type="text/css" rel="stylesheet" href="../../global/grafic.css">
    <script language="JavaScript" src="navig_js.js"></script>
    <script language=javascript src="formu.js"></script>
    <script language=javascript src="formu.js">
    </script>
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
  </header>  
<body >
  <table class=big>
 <tr><td>
  <table class=form align=center> </td></tr>
  <form method="POST" name="utilisateur" action="cria_alias.php">
	<tr><td class=header align=center>
<?php
if ((isset($_POST['confirma'])) and (checa_alias($_POST['alias2'])=="ok"))
	{
                grava_alias($usuario[0],$_POST['alias2']);
		?>
	        Alias do usu&aacute;rio <?php echo $nome; ?> atualizado</td></tr>
		<?php
	}
else
	{
		//$alias=gera_alias($nome,$sobrenome);
		if (isset($_POST['user']))
		   {
		   $pega_aliases="select alias,alias2 from aliases where coduser='".$usuario[0]."'";
		   $query_aliases=pg_query($pega_aliases);
		   $res_aliases=pg_fetch_array($query_aliases);
		   $alias=mb_convert_encoding($res_aliases['alias'],"ISO-8859-1","UTF-8");
		   if (isset($_POST['alias2'])) 
		      {
		      $alias2=$_POST['alias2'];
echo $alias2;
		      if (checa_alias($_POST['alias2'])!="ok") $mensagem="Este Alias j&aacute; existe. Escolha outro"; else $mensagem="";
		      } 
		   else $alias2=mb_convert_encoding($res_aliases['alias2'],"ISO-8859-1","UTF-8");
		   }
		?>
               <br>
                <tr><td><table align=center class=form><tr>
		<td><h1>Usu&aacute;rio: <?php echo $nome; ?> <?php echo $sobrenome; ?> </h1> </td></tr>
		<tr><td> <h1> Alias padr&atilde;o do usu&aacute;rio: </h1> </td><td><input type=text name='alias' size="10" maxlength="100" value="<?php echo $alias;?>" readonly></td></tr>
		<tr><td> <h1> Alias definido pelo usu&aacute;rio: </h1> <?php echo $mensagem;?> </td><td><input type=text name='alias2' size="10" maxlength="100" value="<?php echo retira_acentos($alias2);?>"></td></tr>
                </table>
                <br>
             <tr>
	     <input type=hidden name='user' value="<?php echo $_POST['user'];?>">
               <td align=center>
                 <input type=submit name='confirma' value=Confirmar>
               </td>
             </tr>
          </form>
	<?php
	}
?> 
</table>
</table>
</body>
</html>
