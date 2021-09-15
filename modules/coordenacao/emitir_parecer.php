<?php
include("head_coordenacao.php");
include("imprime_parecer.php");

?>
<html>
  <header>
<script language=javascript>
function compte(nb)
      {
        count=1;
        if (nb>10)
          nb=10;
        cache_tout();
        for(i=0;i<nb;i++)
          montre();
	
var count=1;

function cache_tout()
      {
        document.getElementById("entete1").style.visibility="hidden";
	<?php
        for($i=1;$i<10;$i++)
          echo "document.getElementById(\"id".$i."\").style.visibility=\"hidden\";";
	?>
      }

function last_choice(selection) {
  return selection.selectedIndex==selection.length - 1; }
	  
function valid(menu,txt1,txt2,txt3,txt4) {
  if(menu.selectedIndex == 0) {
    alert('Por favor selecione uma op&ccedil;&atilde;o');
    return false;} 
  if((txt1.value == '') and (txt2.value == '') and (txt3.value == '') and (txt4.value == '')) {
    if(last_choice(menu)) {
      alert('Voc&ecirc; precisa inserir uma IES e a sua sigla');
      return false; }
    else {
      return true; }}
  else {
    if(!last_choice(menu)) {
      alert('Sele&ccedil;&atilde;o ncompat&iacute;vel');
      return false; }
    else {
      return true; }}}
</script>


    <link type="text/css" rel="stylesheet" href="../../global/grafic.css">
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
  </header>

<?php

if (!isset($_POST['avancar_2']))
{

$selecao=$_POST['selecao'];
$id_entrada=$_POST['unbdoc'];
//echo $id_entrada;
//print_r($selecao);

$num_equiv=count($selecao);
//echo $num_equiv;

$query_ies=pg_query("select nome_instituicao from equiv_ies where codigo in (select codigo_ies from equiv_resultado where codigo='".$selecao[0]."'");
$nome_ies=pg_fetch_row($query_ies);

$query_unbdoc=pg_query("select unbdoc from aproveitamento_entrada where id_entrada='".$id_entrada."'");
$unbdoc=pg_fetch_row($query_unbdoc);



?>
<body>
      <table class=big>
   <form method="POST" name="formu" action="emitir_parecer.php">
      <tr>
        <td class=header align=center colspan=3>
          <h1>Processos de equival&ecirc;ncia do MAT/UnB</h1>
        </td>
        </tr>
       <tr>
        <td align=center colspan=3>
        <table border>
        <tr>
          <td class=header align=center colspan=3 class=header><b>Vincula&ccedil;&atilde;o de Resultados de aproveitamento de estudos da IES de origem: <?php echo $nome_ies[0];?> ao processo UnBDoc <?php echo $unbdoc[0];?></b></td>
        <tr>
                <td align=center><b> Disciplinas do MAT</b></td><td align=center><b> Tipo de equival&ecirc;ncia</b></td><td><b> Coment&aacute;rios</b></td></tr>
                <?php
                $cor_de_fundo=0;
                for ($k=0;$k<$num_equiv;$k++)
                        {
			// no looping com o numero de elementos de $selecao:
			//lista_disc_mat | tipo_equiv | comentarios 
			$query_dados_aproveitamento=pg_query("select * from equiv_resultado where codigo='".$selecao[$k]."' and (tipo_equiv='EE' or tipo_equiv='EC')");
			$aproveitamento=pg_fetch_array($query_dados_aproveitamento);
                        if ($cor_de_fundo!=0) {$bgcolor="bgcolor=#FFFFFF";$cor_de_fundo=0;} else {$bgcolor="bgcolor=#B6CDE5";$cor_de_fundo=1;}
                        ?>
                         <tr <?php echo $bgcolor;?>><td  align=left><input type=text name='lista_disc_mat[]' value="<?php echo $aproveitamento['lista_disc_mat'];?>"> </td><td align=center><input type=text name='tipo_equiv[]' value="<?php echo $aproveitamento['tipo_equiv'];?>"> </td><td align=center><input type=text name='comentarios[]' value="<?php echo $aproveitamento['comentarios'];?>"></td></tr>
                        <?php
                        }?>
			<tr><td colspan=3><b>As linhas seguintes devem ser usadas para separar dados da tabela anterior  por disciplina do MAT</b></td></tr>
			<tr <?php echo $bgcolor;?>><td  align=left><input type=text name='lista_disc_mat[]' > </td><td align=center><input type=text name='tipo_equiv[]'> </td><td align=center><input type=text name='comentarios[]' ></td></tr>
			<tr <?php echo $bgcolor;?>><td  align=left><input type=text name='lista_disc_mat[]' > </td><td align=center><input type=text name='tipo_equiv[]'> </td><td align=center><input type=text name='comentarios[]' ></td>
			</tr>
        </table></td>
	</tr>
	<tr>
	<input type=hidden name='id_entrada' value="<?php echo $id_entrada;?>">
	<td align=center><input type=submit name='avancar_2' value="Confirmar"></td>
	</tr>
	</form>
	</table>
	</body>
<?php
}

if (isset($_POST['avancar_2']))
{

// redireciona para a tabela de aproveitamento_processos_resultados
// mostra os pareceres a serem impressos.

$id_entrada=$_POST['id_entrada'];

$lista_disc_mat=$_POST['lista_disc_mat'];
$tipo_equiv=$_POST['tipo_equiv'];
$comentarios=$_POST['comentarios'];

$num_equiv=count($lista_disc_mat);
//echo $num_equiv;
for ($i=0;$i<$num_equiv; $i++)
	{
	if (!empty($lista_disc_mat[$i]))
		{
		$codigo=$lista_disc_mat[$i];
		$codigo_0=explode("+",$codigo); 
		if (((count($codigo_0)==2) and ($codigo_0[0]=="")) or (count($codigo_0)==1))
			{
			$tipo=$tipo_equiv[$i];
			$parecer=$comentarios[$i];
//echo $codigo."-".$tipo."-".$parecer."-".$id_entrada;
			$query_insere="insert into aproveitamento_processos_resultados values('".$id_entrada."','".$tipo."','".$codigo."','".$parecer."','','')";
			$res_insere=pg_query($query_insere) or die ("problema de conexao com o banco de dados");
			if ($res_insere) 
				{
//		echo "<b>Disciplina:".$codigo."</b> <a href=\"http://www.mat.unb.br/si/modules/aproveitamento_estudos/pareceres/".$arquivo."\" target=\"_blank\">imprimir</a>";
				$arquivo=imprime_parecer($codigo,$tipo,$parecer,$id_entrada);
//		echo $arquivo;
				echo "<b>Disciplina:".$codigo."</b> <a href=\"../aproveitamento_estudos/pareceres/".$arquivo."\" target=\"_blank\">imprimir</a><br>";
//		echo "<b>Disciplina:".$codigo."</b> <a href=\"/var/www/si/modules/servidor_admin/Tex/".$arquivo."\" target=\"_blank\">imprimir</a>";
				}
			}
		}
	}

//echo "id_entrada=".$id_entrada."<br>";

//echo "lista_disc_mat=".print_r($lista_disc_mat)."<br>";

//echo "tipo_equiv=".print_r($tipo_equiv)."<br>";

//echo "comentarios=".print_r($comentarios)."<br>";

}
?>  
</html>
<?php
  pg_close($idconn);
?>
