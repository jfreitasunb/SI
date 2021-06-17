<?php
include("head_listas.php");


//select * from listas_de_mails;
// id_lista | nome_lista | descricao | e_mails (lista de coduser) | status (ativada/desativada)
$query_contas=pg_query("select * from listas_de_mails order by nome_lista");


//print $num_submetido;

$hoje=getdate();
$data_de_hoje=$hoje['mon']."-".$hoje['mday']."-".$hoje['year'];

//print $data_de_hoje;

if (!isset($_POST['seleciona']))
{
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
        <td align=center colspan=1 class=header align=center><h1>Cria&ccedil;&atilde;o/Atualiza&ccedil;&atilde;o de Listas de mail</h1></td></t\
r>
  <form method="POST" name="formu" action="usuarios.php">
<tr>
        <td align=center>
          <table class=form>
   <tr>
        <table border class=form align=center>
        <tr><td colspan=4 class=header align=center>Editar uma lista j&aacute; existentes</td></tr>
        <tr><td><b>Ativar/Desativar</b></td><td> <b>Nome da lista</b></td><td><b>Descri&ccedil;&atilde;o</b></td><td><b>Status</b></td></b></tr>
                <?php
                 while($registro = pg_fetch_row($query_contas)) //enquanto houver                           
                        {
//			$descricao=mb_convert_encoding($registro[2],"UTF-8");
                        $valor_da_conta=$registro[0]."-".$registro[1]."-".$registro[3]."-".$registro[4];
		        echo "<tr><td><input type=radio name='eliminar' value=".$valor_da_conta."></td><td>".$registro[1]."</td><td>".$registro[2]."</td><td>".$registro[4]."</td></tr>";
                        }
                 ?>
         </table>
         </td>
         </tr>
	<tr></tr>
        <tr>  <td align=center>
               <table border class=form align=center> 
               <tr><td colspan=3 class=header align=center>Criar uma Nova Lista</td></tr>
               <tr><td><b>Criar</b></td><td> <b>Nome da lista</b></td><td><b>Descri&ccedil;&atilde;o/Finalidade</b></td></tr>
               <tr><td><input type=radio name='eliminar' value="criar"></td><td> <input type=text name='nome_conta' maxlength=10 size=12> </td><td><input type=text name='descricao' maxlength=200 size=50> </td></tr>
                  </table>
               </td> 
               </tr>
        <tr>
       <td align=center>
          <input type=submit name='seleciona' value="Confirme"> <input type=reset name='limpa' value="Limpar"></td></tr>
      </table>
      </form>
</table>
</body>
</html>
<?php
}

pg_close($idconn);
?>