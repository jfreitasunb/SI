<?php  // Inserir nova ou editar uma resolução
include("head_resolucoes.php");

$dados=$_POST['dados'];

if ($dados['data_reuniao']!="") $data_reuniao_ex=explode("/",$dados['data_reuniao']); else $data_reuniao_ex=array(date('d'),date('m'),date('Y'));

if($_POST['salva_tipo']=="rascunho") $submeter="FALSE"; 
if($_POST['salva_tipo']=="definitivo") $submeter="TRUE"; 


if ($dados['codigo']==0) $pg_linha="insert into admin_resolucoes_colegiado (codigo,data_reuniao,numero_reuniao,assunto_resolucao,texto_resolucao,submetido) values (default,'".$data_reuniao_ex[2]."-".$data_reuniao_ex[1]."-".$data_reuniao_ex[0]."','".$dados['numero_reuniao']."','".$dados['assunto_resolucao']."','".$dados['texto_resolucao']."','".$submeter."')";

if ($dados['codigo']!=0) $pg_linha="update admin_resolucoes_colegiado set data_reuniao='".$data_reuniao_ex[2]."-".$data_reuniao_ex[1]."-".$data_reuniao_ex[0]."', numero_reuniao='".$dados['numero_reuniao']."', assunto_resolucao='".$dados['assunto_resolucao']."',texto_resolucao='".$dados['texto_resolucao']."',submetido='".$submeter."' where codigo='".$dados['codigo']."'";

echo $pg_linha;

$query_resolucao=pg_query($pg_linha) or die("problema de conexao 3.0");

pg_close($idconn);
?>

