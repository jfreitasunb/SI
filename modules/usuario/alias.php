<?php

function retira_acentos($texto)
{
  $array1 = array("á", "à", "â", "ã", "ä", "é", "è", "ê", "ë", "í", "ì", "î", "ï", "ó", "ò", "ô", "õ", "ö", "ú", "ù", "û", "ü", "ç", "Á", "À", "Â", "Ã", "Ä", "É", "È", "Ê", "Ë", "Í", "Ì", "Î", "Ï", "Ó", "Ò", "Ô", "Õ", "Ö", "Ú", "Ù", "Û", "Ü", "Ç" );
  $array2 = array("a", "a", "a", "a", "a", "e", "e", "e", "e", "i", "i", "i", "i", "o", "o", "o", "o", "o", "u", "u", "u", "u", "c", "A", "A", "A", "A", "A", "E", "E", "E", "E", "I", "I", "I", "I", "O", "O", "O", "O", "O", "U", "U", "U", "U", "C" );
  return str_replace( $array1, $array2, $texto );
} 

function gera_alias($coduser)
{
$lista = array("DE","DA","DO","DOS","DAS","");


$query="select name, firstname from users where coduser='".$coduser."'";
$result=pg_query($query);
$resultados=pg_fetch_array($result);
//$nome=mb_convert_encoding($resultados['name'],"ISO-8859-1","UTF-8");
//$sobrenome=mb_convert_encoding($resultados['firstname'],"ISO-8859-1","UTF-8");
$nome=$resultados['name'];
$sobrenome=$resultados['firstname'];


$alias="";

$nome0=retira_acentos($nome);
$sobrenome0=retira_acentos($sobrenome);
$nome_0=explode(" ",trim($nome0));
$sobrenome_0=explode(" ",trim($sobrenome0));


//$nome_0=explode(" ",trim(retira_acentos($nome)));
for ($i=0;$i<count($nome_0);$i++)
    {
    if (!(in_array(strtoupper(trim($nome_0[$i])),$lista)))
       {
       $letras=chunk_split($nome_0[$i]);
       $alias=$alias.$letras[0].".";
       }
    }
//$sobrenome_0=explode(" ",trim(retira_acentos($sobrenome)));
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
echo $alias;
return $alias;
}





function grava_alias($coduser,$alias)
{
$query_banco="select * from aliases where coduser='".$coduser."'";
$res_query=pg_query($query_banco);
$num_res=pg_num_rows($res_query);

//$alias0=mb_convert_encoding($alias,"UTF-8");
$alias0=$alias;

$query_grava="insert into aliases values('".$coduser."','".$alias0."','')";
$res=pg_query($query_grava);
echo "Alias inserido";
}

function checa_alias($alias)
{

//$alias0=mb_convert_encoding($alias,"UTF-8");
$alias0=$alias;

$query_checa="select * from aliases where alias='".$alias0."' or alias2='".$alias0."'";
$res_query_checa=pg_query($query_checa);
$num_res_checa=pg_num_rows($res_query_checa);

if ($num_res_checa==0) $checa_alias="ok"; else $checa_alias="ja_existe_um";

return $checa_alias;
}
?>
