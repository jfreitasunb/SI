<?php include("head_resolucoes.php"); ?>
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
          <h1>Departamento de Matematica</h1>
        </td>
      </tr>
      <tr>
        <td align=center>
               <title>Servidor Administrativo</title>
<?php
$codigo=$_GET["id_documentador"];
// if(isset($_POST['tipo_doc'])) $id_documentador=$_POST['tipo_doc'];
// if(isset($_GET['tipo_doc'])) $id_tipo=$_GET['tipo_doc'];



//busca pelo "documento" na tabela "admin_resolucoes_colegiado" ou "documentador".  
$resultado=pg_query("SELECT * FROM admin_resolucoes_colegiado WHERE codigo = '$codigo'") or die ("N? foi poss?el realizar a consulta ao banco de dados");
$col= pg_fetch_array($resultado,0);
//$col['id_tipo'] = "7";

////////////////////////////////////busca pelo "documento" na tabela "rascunho".//////////////////////////////////////



//$col=(id_documentador, id_tipo, id_departamento, vocativo, mensagem, desfecho, id_assinatura, assunto, anexo, data, via, assinante)


?>
<form action='ati.php' method='post'>
<table class=form>
		
<?php
    // print_r($col);
    // die();
    $formata_data_reuniao = explode("-", $col['data_reuniao']);
    $col['data_reuniao'] = $formata_data_reuniao[2]."/".$formata_data_reuniao[1]."/".$formata_data_reuniao[0];
    $codigo = $col['codigo'];
    $submetido = $col['submetido'];
    $data_reuniao = $col['data_reuniao'];
    $numero_reuniao = $col['numero_reuniao'];
    $assunto_resolucao = $col['assunto_resolucao'];
    $texto_resolucao = $col['texto_resolucao'];
?>

<tr><td width='20%'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'><p>Data da reunião do colegiado:</p></font></td>
           <td><input type='text' size=20 name='dado[]' value="<? echo $data_reuniao;?>"></td></tr>
    <tr><td width='20%'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'><p>Reunião de colegiado número:</p></font></td>
       <td><input type='text' size=20 name='dado[]' value="<? echo $numero_reuniao;?>"></td></tr>

        <tr><td width='20%'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'><p>Assunto da resolução:</p></font></td>
        <td><TEXTAREA name= 'dado[]' rows=10 cols=60><? echo $assunto_resolucao; ?></TEXTAREA></td></tr>

        <tr><td width='20%'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'><p>Conteúdo da resolução:</p></font></td>
        <td><TEXTAREA name= 'dado[]' rows=10 cols=60><? echo $texto_resolucao;?></TEXTAREA></td></tr>

  <tr><td width='20%'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'><p>Assinatura:</p></font></td>
                <td><select name= 'dado[]' size='1'>
                <?
                $res3=pg_query("SELECT id_assinatura,cargo,titulo FROM admin_assinatura") or die ("N?o foi poss?vel consultar o banco.");
                $i=0;
                while($registro3=pg_fetch_row($res3,$i))
                {
                        $cod3=$registro3[0];
                        $cargo3=$registro3[1];
                        echo"<option value=\"$cod3\"";
                        if($cod3==$col['assinatura'])
                                echo"selected";
                        echo">".$cargo3."(".$registro3[2].")</option>\n";
                        $i=$i+1;
                }
                ?>
  
                </select></td></tr>

            <tr><td width='20%'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'><p>Assinante:</p></font></td>
                <td><select name= 'dado[]' size='1'>
                <?
                $res4=pg_query("SELECT coduser,name, firstname FROM users where tipo_users='professor' or tipo_users='administrativo' order by name")
or die ("N&atilde;o foi poss&iacute;vel consultar o banco.");
                $i=0;
                while($registro4=pg_fetch_row($res4,$i))
                {
                        $cod4=$registro4[0];
                        $nome4=$registro4[1];
                        $sobrenome4=$registro4[2];
                        echo"<option value=\"$cod4\"";
                        if($cod4==$col['assinante'])
                                echo"selected";
                        echo">$nome4  $sobrenome4 </option>\n";
                        $i=$i+1;
                }
                ?>
               </select></td></tr>




</table>
<br>
	    <input name='origem' type='hidden' value='editar'>
        <input type='hidden' size=20 name='dado[]' value="<? echo $codigo;?>">
        <input type='hidden' size=20 name='dado[]' value="<? echo $submetido;?>">
        <input name='acao' type='submit' value='Visualizar'>
	    <input name='acao' type='submit' value='Rascunho'>
        <input name='acao' type='submit' value='Definitivo'>
</table>
</form>
</div>



