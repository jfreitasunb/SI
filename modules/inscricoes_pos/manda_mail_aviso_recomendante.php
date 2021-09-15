<?php

include("head_inscricao_pos.php");

//queremos selecionar os recomendantes que tem mais de uma carta para escrever e que já estão cadastrados:
function manda_mail_aviso_recomendante($dados)
{
$dados0=explode("_-_",$dados);
$mail=$dados0[0];
$nome=$dados0[1];

$nome_prof=explode(" ",strtolower($nome));
$nome_prof_novo="";
for ($k=0;$k<count($nome_prof);$k++)
	{
	$nome_prof_novo.=" ".ucfirst($nome_prof[$k]);
	} 

$query_alunos=pg_query("select dc.id_aluno, name||' '||firstname as nom_aluno from inscricao_pos_contatos_recomendante cr, inscricao_pos_dados_candidato dc where emailprofrecomendante1='".$mail."' and dc.id_aluno=cr.id_aluno union (select dc.id_aluno, name||' '||firstname as nom_aluno from inscricao_pos_contatos_recomendante cr, inscricao_pos_dados_candidato dc where emailprofrecomendante2='".$mail."' and dc.id_aluno=cr.id_aluno) union (select dc.id_aluno, name||' '||firstname as nom_aluno from inscricao_pos_contatos_recomendante cr, inscricao_pos_dados_candidato dc where emailprofrecomendante3='".$mail."' and dc.id_aluno=cr.id_aluno)");

$alunos="";
while($registro=pg_fetch_row($query_alunos))
{
$nome_aluno=explode(" ",strtolower($registro[1]));
$nome_novo="";
for ($i=0;$i<count($nome_aluno);$i++)
	{
	$nome_novo.=" ".ucfirst($nome_aluno[$i]);
	} 

if ($alunos=="") $alunos.=$nome_novo; else $alunos.=",".$nome_novo;
}


 $texto="Prezado(a) Prof(a).".$nome_prof_novo.",\n Os alunos seguintes solicitaram uma carta de recomendação: \n ".$alunos; 
        
        $texto=wordwrap($texto,70);

        // mensagem:
        
        $subject = "Programa de Pós-graduação do do MAT/UnB";
        $headers = "FROM: posgrad@mat.unb.br";

        echo "<BR><BR>".$mail."\r\n".  mb_convert_encoding($subject,'ISO-8859-1','UTF-8')."\r\n ". mb_convert_encoding($texto,'ISO-8859-1','UTF-8')."\r\n ".$headers."<br><br>";
        $res_mail=mail($mail,  mb_convert_encoding($subject,'ISO-8859-1','UTF-8'), mb_convert_encoding($texto,'ISO-8859-1','UTF-8'), $headers);
        if ($res_mail) $devolve="enviado"; else $devolve="problema no envio de mensagens";

return $devolve;
}


if (!isset($_POST['selecionar']))
{
$query_recomendantes=pg_query("select id_aluno,emailprofrecomendante1 as recomendante, nomeprofrecomendante1 as nome_prof from inscricao_pos_contatos_recomendante union (select id_aluno,emailprofrecomendante2 as recomendante,nomeprofrecomendante2 as nome_prof from inscricao_pos_contatos_recomendante) union (select id_aluno,emailprofrecomendante3 as recomendante,nomeprofrecomendante3 as nome_prof from inscricao_pos_contatos_recomendante) order by recomendante");

$recomendante=pg_fetch_all($query_recomendantes);

$j=0;
$array_varios=array();
$array_varios_teste=array();
for ($i=0;$i<count($recomendante)-1;$i++)
	{
	if (($recomendante[$i]['recomendante']==$recomendante[$i+1]['recomendante']) and !in_array($recomendante[$i]['recomendante'],$array_varios_teste)) 
		{
		$array_varios_teste[$j]=$recomendante[$i]['recomendante'];
		$array_varios[$j]=$recomendante[$i]['recomendante']."_-_".$recomendante[$i]['nome_prof'];
		$j=$j+1;
		}
	}


?>
<body>
<html>
  <header>
    <link type="text/css" rel="stylesheet" href="../../global/grafic.css">
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
  </header>
  <body>
      <table class=big>
  <form method="POST" name="formu" action="manda_mail_aviso_recomendante.php">
      <tr>
        <td class=header align=center>
          <h1>Inscrições nos programa de pós-graduação do MAT-UnB: criação/envio de nova senha para recomendantes</h1>
        </td>
      </tr>
      <tr>
        <td align=center>
        <table class=form>
        <tr>
        <td align=center><b>Selecionne</b></td><td align=center><b>Nome do Recomendante</b> (Mail recomendante)</td>
        </tr>

<?php
foreach ($array_varios as $key => $value)
	{
//echo $key;
	$dados0=explode("_-_",$value);
	$mail=$dados0[0];
	$nome=$dados0[1];
	echo "<tr><td><input type=checkbox name='manda[".$key."]' value=\"".$value."\"></td><td> ".$nome." (".$mail.")</td></tr>";
	}
 ?>
        </table>
          </td>
          </tr>
      <tr>
        <td align=center>
        <input type=submit name='selecionar' value="Confirmar">
        </td>
      </form>

<?php
}


if (isset($_POST['selecionar']))
{
$dados=$_POST['manda'];
foreach ($dados as $key => $value)
	{
	$res_manda=manda_mail_aviso_recomendante($value);
	if ($res_manda!="enviado") echo "Problema no envio de mail para o endereço ".$value;
	}
}

pg_close($idconn);
?>

