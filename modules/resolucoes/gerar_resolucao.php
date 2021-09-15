<?php
include("head_resolucoes.php");

// funcao que pega e trata  numero da ata:
$array_reuniao=array();
$array_num_reuniao=array();

$query_atas=pg_query("select assunto from admin_documentador where id_tipo='5'") or die("problema de conexao 0");;
$j=0;
while($registro=pg_fetch_row($query_atas))
        {
        $x_registro=explode(" ",$registro[0]);
        for ($i=0;$i<count($x_registro);$i++)
                {
//              echo $x_registro[$i]."<br>";
                if(is_numeric($x_registro[$i])) $num_reuniao=$x_registro[$i];
                $acha_barra=explode("/",$x_registro[$i]);
                if(count($acha_barra)==3) $data_reuniao=$x_registro[$i];
                }
        if(substr_count($registro[0],"/")==0) $data_reuniao="";
        $array_reuniao[$num_reuniao]=$data_reuniao;
        $array_num_reuniao[$j]=$num_reuniao;
//      echo $num_reuniao."---".$data_reuniao."<br>";
        $j=$j+1;
        }
rsort($array_num_reuniao);
// fim funcao

if($_POST['resolucao']=="editar")  
  {
  $query_resolucao=pg_query("select codigo,to_char(data_reuniao,'dd/mm/yyyy') as data_reuniao,numero_reuniao,assunto_resolucao,texto_resolucao from admin_resolucoes_colegiado where codigo='".$_POST['pega_resolucao']."'") or die("problema de conexao 2.0");
  $dado=pg_fetch_array($query_resolucao,0);
  }
if($_POST['resolucao']=="criar")  
  {
  $dado['codigo']=0;
  if($_POST['pega_ata']=="nova") 
    {
    $dado['data_reuniao']="";
    $dado['numero_reuniao']="";
    }
  else 
    {
    $dado['data_reuniao']=$array_reuniao[$_POST['pega_ata']];
    $dado['numero_reuniao']=$_POST['pega_ata'];
    }
  $dado['assunto_resolucao']="";
  $dado['texto_resolucao']="";
  }
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
<form method="POST" name="formu" action="ati.php">


<h1>Gerar Resolu&ccedil;&atilde;o </h1>



		<table class=form align=center>
   	<tr><td width='20%'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'><p>Data da reunião do colegiado:</p></font></td>
           <td><input type='text' size=20 name='dado[data_reuniao]' value="<? echo date("d/m/Y", strtotime($dado['data_reuniao']));?>"></td></tr>
	<tr><td width='20%'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'><p>Reunião de colegiado número:</p></font></td>
	   <td><input type='text' size=20 name='dado[numero_reuniao]' value="<? echo $dado['numero_reuniao'];?>"></td></tr>

           <tr><td width='20%'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'><p>Assunto da resolução:</p></font></td>
           <td><TEXTAREA rows=10 cols=60 name='dado[assunto_resolucao]' <? echo $dado['assunto_resolucao'];?>>Insira o assunto da resolução.</TEXTAREA></td></tr>

	    <tr><td width='20%'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'><p>Conteúdo da resolução:</p></font></td>
           <td><TEXTAREA rows=10 cols=60 name='dado[texto_resolucao]' <? echo $dado['texto_resolucao']; ?>>Insira o conteúdo da resolução.</TEXTAREA></td></tr>

	              <tr><td width='130'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'><p>Assinatura:</p></font></td>
           <td><select name= 'dado[assinatura]' size='1'>
    <?php
                $res2=pg_query("SELECT id_assinatura,cargo,titulo FROM admin_assinatura") or die ("Nao foi possivel consultar o banco.");
    $i=0;
                while($registro2=pg_fetch_row($res2,$i))
                {
                        $cod2=$registro2[0];
                        $cargo2=$registro2[1];
//      $titulo2=$registro2[2];

                        echo"<option value='".$cod2."'>".$cargo2."(".$registro2[2].")</option>\n";
      $i=$i+1;
                }
          ?>
    </select></td></tr>

           <tr><td width='130'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'><p>Assinante:</p></font></td>
           <td><select name= 'dado[assinante]' size='1'>
    <?php
                $res3=pg_query("SELECT coduser,name, firstname FROM users where tipo_users='professor' or tipo_users='administrativo' order by name") or die ("Nao foi possivel consultar o banco.");
    $i=0;
                while($registro3=pg_fetch_row($res3,$i))
                {
                        $cod3=$registro3[0];
                        $nome3=$registro3[1];
      $sobrenome=$registro3[2];
                        echo"<option value='".$cod3."'>".$nome3." ".$sobrenome."</option>\n";
      $i=$i+1;
                }
          ?>
    </select></td></tr>
    </table>
	<input name='origem' type='hidden' value='gerar'>
  <input name='salva_tipo' type='hidden' value='rascunho'>
  <input type=hidden name='dado[codigo]' value="<? echo $dado['codigo'];?>">
	<table class=form align=center>
	<tr>
        <td><input name='acao' type='submit' value='Visualizar'>
        <input name='acao' type='submit' value='Salvar Rascunho'>
        <input type='reset' value='Limpar'></td>
	</tr>
	</table>
</table>
</form>
</div>
</body>
</html>
