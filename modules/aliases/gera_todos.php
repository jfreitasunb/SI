<?php
  require("head_aliases.php");


function retira_acentos($texto)
{
  $array1 = array("á","à","â","ã","ä","é","è","ê","ë","í","ì","î","ï","ó","ò","ô","õ","ö","ú","ù","û","ü","ç","Á","À","Â","Ã","Ä","É","È","Ê","Ë","Í","Ì","Î","Ï","Ó","Ò","Ô","Õ","Ö","Ú","Ù","Û","Ü","Ç");
  $array2 = array("a", "a", "a", "a", "a", "e", "e", "e", "e", "i", "i", "i", "i", "o", "o", "o", "o", "o", "u", "u", "u", "u", "c", "A", "A", "A", "A", "A", "E", "E", "E", "E", "I", "I", "I", "I", "O", "O", "O", "O", "O", "U", "U", "U", "U", "C" );

 $alias=str_replace($array1, $array2, $texto );

 return $alias;
} 

function checa_alias($alias) 
{
//$alias=retira_acentos($alias);
$alias_0=str_replace(" ",".",$alias);
//$alias0=mb_convert_encoding($alias_0,"UTF-8");
$alias0=$alias_0;

$query_checa="select * from aliases where alias=? or alias2=?"; $query_checa__p = array($alias0, $alias0);
$res_query_checa=db_query($query_checa, $query_checa__p);
$num_res_checa=db_num_rows($res_query_checa);

if ($num_res_checa==0) $checa_alias="ok"; else $checa_alias="ja_existe_um";

return $checa_alias;
}


function gera_alias($nome,$sobrenome)
{
$lista = array("DE","DA","DO","DOS","DAS","");
$nome0=retira_acentos($nome);
$sobrenome0=retira_acentos($sobrenome);
$alias="";
$nome_0=explode(" ",trim($nome0));
for ($i=0;$i<count($nome_0);$i++)
    {
    if (!(in_array(strtoupper(trim($nome_0[$i])),$lista)))
       {
       $letras=chunk_split($nome_0[$i]);
       $alias=$alias.$letras[0].".";
       }
    }
$sobrenome_0=explode(" ",trim($sobrenome0));
for ($i=0;$i<count($sobrenome_0);$i++)
    {
    if ($i==count($sobrenome_0)-1)
    {
       $alias=$alias.$sobrenome_0[$i];
        }
    else
        {
        if (!(in_array(strtoupper(trim($sobrenome_0[$i])),$lista)))
           {
           $letras=chunk_split($sobrenome_0[$i]);
           $alias=$alias.$letras[0].".";
           }
        }
    }
echo h($alias);
   if (checa_alias($alias)!="ok") $alias=$alias."_0";
   while (checa_alias($alias)!="ok") 
              {
              $alias=$alias."0";
              }


return $alias;
}

function grava_alias($coduser,$alias)
{
$query_banco="select * from aliases where coduser=?"; $query_banco__p = array($coduser);
$res_query=db_query($query_banco, $query_banco__p);
$num_res=db_num_rows($res_query);

//$alias0=mb_convert_encoding($alias,"UTF-8");
$alias0=$alias;

if ($num_res!=0)
   {
   $query_grava="update aliases set alias=? where coduser=?"; $query_grava__p = array($alias0, $coduser);
   $res=db_query($query_grava, $query_grava__p);
   echo "Alias atualizado";
   }
   else
   {
   $query_grava="insert into aliases values(?,?)"; $query_grava__p = array($coduser, $alias0);
   $res=db_query($query_grava, $query_grava__p);
   echo "Alias inserido";
   }
}



//###########
$query="select coduser, name, firstname from users where coduser not in (select coduser from unix where login='root') order by name"; $query__p = array();
$result=db_query($query, $query__p);
$numero=db_num_rows($result);
$resultados=db_fetch_all($result);

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

for ($k=0;$k<$numero;$k++)
    {
    $coduser=$resultados[$k]['coduser'];
    $nome=$resultados[$k]['name'];
    $sobrenome=$resultados[$k]['firstname'];
    $alias=gera_alias($nome,$sobrenome);
    echo "<tr><td>".h($nome)." ".h($sobrenome)."</td><td>".h($coduser)."</td><td>".h($alias)."</td></tr>";
    grava_alias($coduser,$alias);
    }
?>
</table>
</table>
</body>
</html>
<?php
db_close($idconn);
?>
