<?php
include("head_coordenacao.php");


function cadastra_ies_nova($nome_instituicao,$inep,$organizacao_academica,$categoria)
{
$organizacao_academica_2=$organizacao_academica."%";
if (!empty($inep)) 
	{
	$codigo=$inep;
	$pega_codigo_0=pg_query("select codigo from equiv_ies where codigo='".$codigo."'");
	$num_codigos=pg_num_rows($pega_codigo_0);
	if ($num_codigos!=0) 
		{
		echo "A institui&ccedil;&atilde;o j&aacute; est&aacute; cadastrada.";
		echo "<script type=\"text/javascript\">window.location=\"equivalencias.php\";</script>";
		exit;
		}
	}
	else 
	{

	if (($organizacao_academica!="Estrangeiras") and ($organizacao_academica!="Academia Militar")) 
$pega_codigo_1=pg_query("select codigo+1 from equiv_ies where organizacao_academica<>'Estrangeiras' and organizacao_academica<>'Academia Militar' order by codigo desc limit 1");
	else $pega_codigo_1=pg_query("select codigo+1 from equiv_ies where organizacao_academica like '".$organizacao_academica."' order by codigo desc limit 1");
	$codigo_0=pg_fetch_row($pega_codigo_1);
	$num_linhas=pg_num_rows($pega_codigo_1);
	$codigo=$codigo_0[0];
	if (($organizacao_academica=="Academia Militar") and ($num_linhas==0)) $codigo=10000000;
	if (($organizacao_academica=="Estrangeiras")  and ($num_linhas==0)) $codigo=20000000;
	if (($organizacao_academica!="Estrangeiras") and ($organizacao_academica!="Academia Militar") and ($codigo<5000000)) $codigo=5000000;
	}
if ($organizacao_academica=="Centro Federal de Educ") $organizacao_academica="Centro Federal de Educacao Tecnologica";
if ($organizacao_academica=="Centro Universit") $organizacao_academica="Centro Universitario";
if ($organizacao_academica=="Instituto Federal de Educ") $organizacao_academica="Instituto Federal de Educacao Ciencia e Tecnologia";
$nome_instituicao=mb_convert_encoding($nome_instituicao,"UTF-8");
$query_grava=pg_query("insert into equiv_ies values('".$codigo."','".$nome_instituicao."','".$organizacao_academica."','".$catgoria."','','','')") or die("Nao foi possivel acessar o banco de dados.");

return $codigo;
}



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
if (!isset($_POST['vincula_unbdoc']))
{
// -----------------------------------------------------------------escolha_IES
if (!isset($_POST['escolha_IES']) and !isset($_POST['nova_IES']) and !isset($_POST['buscar']))  
{
?>
  <body>
      <table class=big>
   <form method="POST" name="formu" action="equivalencias.php">
      <tr>
        <td class=header align=center colspan=2>
        <h1>Processos de equival&ecirc;ncia do MAT/UnB</h1>
        </td>
      </tr>
     <tr>    
	<td align=center><b> Selecione a IES de origem:</b> </td>
	</tr>
	<tr>
	<td><b>CEFET:</b><select name='cefet_origem' maxlength="50">
						<option value='vazio' selected>Escolha uma institui&ccedil;&atilde;o</option>
						<?php            // gera a lista de IES registradas
// equiv_IES(codigo ,nome_instituicao varchar(300),sigla varchar(20))
					$res = pg_query("SELECT * FROM equiv_ies where organizacao_academica like 'Centro Federal de Educa%' order by nome_instituicao");
					while($registro = pg_fetch_row($res)) //enquanto ouver registro escreva
						{
						echo "<option value='".$registro[0]."'>".$registro[1]." - ".$registro['2']."</option>";
						}
						?>
					</select>
	</td>
      </tr>
	<tr>
	<td><b>Centro Universit&aacute;rio:</b><select name='CU_origem' maxlength="50">
						<option value='vazio' selected>Escolha uma institui&ccedil;&atilde;o</option>
						<?php            // gera a lista de IES registradas
// equiv_IES(codigo ,nome_instituicao varchar(300),sigla varchar(20))
					$res = pg_query("SELECT * FROM equiv_ies where organizacao_academica like 'Centro Universit%' order by nome_instituicao");
					while($registro = pg_fetch_row($res)) //enquanto ouver registro escreva
						{
						echo "<option value='".$registro[0]."'>".$registro[1]." - ".$registro['2']."</option>";
						}
						?>
					</select>
	</td>
	</tr>
	<tr>
	<td><b>Faculdade:</b><select name='FAC_origem' maxlength="50">
						<option value='vazio' selected>Escolha uma institui&ccedil;&atilde;o</option>
						<?php            // gera a lista de IES registradas
// equiv_IES(codigo ,nome_instituicao varchar(300),sigla varchar(20))
					$res = pg_query("SELECT * FROM equiv_ies where organizacao_academica='Faculdade' order by nome_instituicao");
					while($registro = pg_fetch_row($res)) //enquanto ouver registro escreva
						{
						echo "<option value='".$registro[0]."'>".$registro[1]." - ".$registro['2']."</option>";
						}
						?>
					</select>
	</td>
	</tr>
	<tr>
	<td><b>Instituto Federal de Educa&ccedil;&atilde;o Ci&ecirc;ncia e Tecnologia:</b><select name='IFECT_origem' maxlength="50">
						<option value='vazio' selected>Escolha uma institui&ccedil;&atilde;o</option>
						<?php            // gera a lista de IES registradas
// equiv_IES(codigo ,nome_instituicao varchar(300),sigla varchar(20))
					$res = pg_query("SELECT * FROM equiv_ies where organizacao_academica like 'Instituto Federal de Educa%' order by nome_instituicao");
					while($registro = pg_fetch_row($res)) //enquanto ouver registro escreva
						{
						echo "<option value='".$registro[0]."'>".$registro[1]." - ".$registro['2']."</option>";
						}
						?>
					</select>
	</td>
	</tr>
	<tr>
	<td><b>Universidade:</b><select name='UNIV_origem' maxlength="50">
						<option value='vazio' selected>Escolha uma institui&ccedil;&atilde;o</option>
						<?php            // gera a lista de IES registradas
// equiv_IES(codigo ,nome_instituicao varchar(300),sigla varchar(20))
					$res = pg_query("SELECT * FROM equiv_ies where organizacao_academica='Universidade' order by nome_instituicao");
					while($registro = pg_fetch_row($res)) //enquanto ouver registro escreva
						{
						echo "<option value='".$registro[0]."'>".$registro[1]." - ".$registro['2']."</option>";
						}
						?>
					</select>
	</td>
	</tr>
    	<tr>
	<td><b>Academias Militares:</b><select name='AM_origem' maxlength="50">
						<option value='vazio' selected>Escolha uma institui&ccedil;&atilde;o</option>
						<?php            // gera a lista de IES registradas
// equiv_IES(codigo ,nome_instituicao varchar(300),sigla varchar(20))
					$res = pg_query("SELECT * FROM equiv_ies where organizacao_academica='Academia Militar' order by nome_instituicao");
					while($registro = pg_fetch_row($res)) //enquanto ouver registro escreva
						{
						echo "<option value='".$registro[0]."'>".$registro[1]." - ".$registro['2']."</option>";
						}
						?>
					</select>
	</td>
	</tr>
	<tr>
	<td><b>Institui&ccedil;&otilde;es Estrangeiras:</b><select name='ESTRANG_origem' maxlength="50">
						<option value='vazio' selected>Escolha uma institui&ccedil;&atilde;o</option>
						<?php            // gera a lista de IES registradas
// equiv_IES(codigo ,nome_instituicao varchar(300),sigla varchar(20))
					$res = pg_query("SELECT * FROM equiv_ies where organizacao_academica='Estrangeiras' order by nome_instituicao");
					while($registro = pg_fetch_row($res)) //enquanto ouver registro escreva
						{
						echo "<option value='".$registro[0]."'>".$registro[1]." - ".$registro['2']."</option>";
						}
						?>
					</select>
	</td>
	</tr>
 <tr>
	<td align=center colspan=2><input type="submit" name="escolha_IES" value="Selecionar" align=center>
	<input type="submit" name="nova_IES" value="Inserir nova IES" align=center>
	<input type="submit" name="buscar" value="Procurar uma Institui&ccedil;&atilde;o" align=center></td>
     </tr>
</form>
</table>
</body>


<?php
// ----------------------------------------------------termino  escolha_IES
}

//----------------------------------------------- inicia BUSCA
if (isset($_POST['buscar']))
{

if (!isset($_POST['buscar2']))
{
?>
  <body>
      <table class=big>
   <form method="POST" name="formu" action="equivalencias.php">
      <tr>
        <td class=header align=center colspan=2>
        <h1>Processos de equival&ecirc;ncia do MAT/UnB</h1>
        </td>
      </tr>
     <tr>    
	<td align=center><b> Digite o texto ou parte do texto desejado:</b><input type=text name='busca' size=10></td>
	</tr>
	<tr>
	
	</tr>
 	<tr>
	<td align=center><input type="submit" name="buscar2" value="Procurar IES"></td>
	<input type="hidden" name="buscar" value="sim">
     </tr>
</form>
</table>
</body>
<?php
}


if (isset($_POST['buscar2']))
{
$busca2=strtoupper($_POST['busca']);
$query_busca=pg_query("select codigo,nome_instituicao,organizacao_academica from equiv_ies where nome_instituicao like '%".$_POST['busca']."%' or nome_instituicao like '%".$busca2."%' order by nome_instituicao") or die("Nao foi possivel acessar o banco de dados.");

?>
  <body>
      <table class=big>
   <form method="POST" name="formu" action="equivalencias.php">
      <tr>
        <td class=header align=center colspan=2>
        <h1>Processos de equival&ecirc;ncia do MAT/UnB</h1>
        </td>
      </tr>
     <tr>    
	<td align=center><b> Resultado da Busca:</b><select name='codigo_ies'>
							<?php
                                        		while($registro = pg_fetch_row($query_busca)) //enquanto ouver registro escreva
                                                	{
                                                	echo "<option value='".$registro[0]."'>".$registro[1]."-".$registro[2]."</option>";
                                                	}
                                			?></select>
	</tr>
	<tr>
	</tr>
 	<tr>
	<td align=center><input type="submit" name="escolha_IES" value="Selecionar"></td>
	<td align=center><input type="hidden" name="vem_da_busca" value="sim"></td>
     </tr>
    </form>
     </table>
   </body>
<?php
}

}

//------------------------------------------------------ Termina BUSCA

// --------------------------------------------------------inicia nova IES
if (isset($_POST['nova_IES'])) 
{
?>
 <body>
      <table class=big>
   <form method="POST" name="formu" action="equivalencias.php">
      <tr>
        <td class=header align=center>
          <h1>Processos de equival&ecirc;ncia do MAT/UnB</h1>
        </td>
      </tr>
        <tr>
          <td align=center class=header><b>Inclus&atilde;o de IES</b></td>
        </tr>
	<tr><td><b>Nome da institui&ccedil;&atilde;o:</b><input type=text name='nome_instituicao' maxlength="300" size="50"></td></tr>
	<tr><td><b>N&uacute;mero INEP:</b><input type=text name='inep' maxlength="10" size="5"></td></tr>
	<tr>
	<td><b>Tipo de institui&ccedil;&atilde;o:</b> <select name='organizacao_academica'> 
								<option value="Centro Federal de Educ">CEFET</option>
								<option value="Centro Universit">Centro Universit&aacute;rio</option> 
								<option value="Faculdade">Faculdade</option> 
								<option value="Instituto Federal de Educ">Instituto Federal de Educa&ccedil;;&atilde;o Ci&ecirc;ncia e Tecnologia</option>
								<option value="Universidade">Universidade</option>
								<option value="Academia Militar">Academia Militar</option> 
								<option value="Estrangeiras">Institui&ccedil;&atilde;o Estrangeira</option>
								</select>
	</td>
	</tr>
	<tr><td><b>Categoria da institui&ccedil;&atilde;o:</b> <select name='categoria'> 
								<option value="Publica">P&uacute;blica</option>
								<option value="Privada">Privada</option>
								</select></td>
	</tr>
	<tr>
	<td align=center>
	<table border class=form>
        <tr>
          <td align=center colspan=3 class=header><b> Inclus&atilde;o das disciplinas </b>(tal como no processo) :</td>
        </tr>
        <tr>
        <td class=data align=center><b>N<sup>o</sup> de ordem</b> </td><td class=data align=center> <b>disciplina cursada </b> </td><td class=data align=center> <b>carga hor&aacute;ria</b> </td>
        </tr>
        <?php
          for ($i=0;$i<10;$i++)
                {
        ?>
                <tr>
                <td><?php echo $i;?></td>
                <td><INPUT TYPE=text NAME='disciplina[]'</td>
		<td><INPUT TYPE=text NAME='carga_horaria[]'</td>
                </tr>
        <?php
                }
        ?>
	</table>
	</td>
	</tr>
     <tr><td align=center> 
	<input type="hidden" name="nova_IES_2" value="sim">
	<input type="hidden" name="escolha_IES" value="sim">
	<input type="hidden" name="codigo_ies" value="sim">
	<input type="submit" name="continua_equivalencia2" value="Confirma e continua o processo de equival&ecirc;ncia"></td>
     </tr>
</form>
</table>
</body>



<?php
}	
// ------------------------------------------------termino insere nova IES

if (isset($_POST['escolha_IES']))  
{
//echo "estou em escolha_IES".$_POST['codigo_ies'];
// ------------------------------------------------continua equivalencia
if (isset($_POST['continua_equivalencia']) or isset($_POST['continua_equivalencia2'])) 
{
//echo "estou em continua equivalencia";

	
	if (isset($_POST['continua_equivalencia']))
	{
	$codigo_ies=$_POST['codigo_ies'];
	$aproveitamento=$_POST['aproveitamento'];
	$comentarios=$_POST['comentarios'];
	$disciplinas_MAT=$_POST['disciplinas_MAT'];
	$disciplinas_ies=$_POST['disciplinas_ies'];
	
	
	$mat="";
	for ($i=0;$i<count($disciplinas_MAT);$i++)
	{
		if($mat=="") $mat=$disciplinas_MAT[$i]; else $mat.="+".$disciplinas_MAT[$i];
	}
	$ies="";
	for ($i=0;$i<count($disciplinas_ies);$i++)
	{
		if ($ies=="") $ies.=$disciplinas_ies[$i]; else $ies.="+".$disciplinas_ies[$i];
	}

// TABLE equiv_resultado(codigo,codigo_ies integer,lista_disc_IES text,lista_disc_MAT text,tipo_equiv varchar(3)#(da equivalencia: ED, NE, EE, EC),comentarios text)
	if ($ies!="") $insere_equiv=pg_query("insert into equiv_resultado values(default,'".$codigo_ies."','".$ies."','".$mat."','".$aproveitamento."','".$comentarios."')") or die ("Nao foi possivel acessar o banco de dados.");
	}

	if (isset($_POST['continua_equivalencia2']))
	{
	if ($_POST['nova_IES_2']=="sim") 	$codigo_ies=cadastra_ies_nova($_POST['nome_instituicao'],$_POST['inep'],$_POST['organizacao_academica'],$_POST['categoria']);

	$disciplina=$_POST['disciplina'];
	$carga_horaria=$_POST['carga_horaria'];
	for ($j=0;$j<count($disciplina);$j++)
			{
			if (!empty($disciplina[$j])) $insere_disciplina=pg_query("insert into equiv_disc_ies values(default,'".$codigo_ies."','".$disciplina[$j]."','".$carga_horaria[$j]."')") or die ("Nao foi possivel acessar o banco de dados.");
			}
		
	}

	$recupera_ies=pg_query("select * from  equiv_ies where codigo='".$codigo_ies."'");
	$ies_0=pg_fetch_row($recupera_ies);
	//recupera os dados para continuar
	$recupera_disciplinas=pg_query("select * from  equiv_disc_ies where codigo_ies='".$codigo_ies."' order by disciplina");
	$disciplinas=pg_fetch_all($recupera_disciplinas);
	$num=pg_num_rows($recupera_disciplinas);

	$recupera_equivalencias=pg_query("select * from  equiv_resultado where codigo_ies='".$codigo_ies."' order by lista_disc_ies");
	$equivalencias=pg_fetch_all($recupera_equivalencias);
	$num_equiv=pg_num_rows($recupera_equivalencias);


	$recupera_disciplinas_MAT=pg_query("select * from  disciplinas_MAT order by nome");
	$disciplinas_MAT=pg_fetch_all($recupera_disciplinas_MAT);
	$num_MAT=pg_num_rows($recupera_disciplinas_MAT);
?>
 <body>
      <table class=big>
   <form method="POST" name="formu2" action="equivalencias.php">
      <tr>
        <td class=header align=center colspan=5>
          <h1>Processos de equival&ecirc;ncia do MAT/UnB</h1>
        </td>
      </tr>
       <tr>
          <td align=center colspan=5 class=header><b>Resultados para a IES de origem: <?php echo $ies_0[1];?> - <?php echo $ies_0[2];?>  </b></td>
	</tr>
	<tr>
	<td><b>Disciplinas da IES</b></td><td align=center><b> equivalentes &agrave;s</b></td><td align=center><b> Disciplinas do MAT</b></td><td align=center><b> tipo de equival&ecirc;ncia</b></td><td><b> coment&aacute;rios</b></td>
	</tr>
		<?php
		$cor_de_fundo=0;
		for ($k=0;$k<$num_equiv;$k++)
			{
			if ($cor_de_fundo!=0) {$bgcolor="bgcolor=#FFFFFF";$cor_de_fundo=0;} else {$bgcolor="bgcolor=#B6CDE5";$cor_de_fundo=1;}
			?>
				<tr <?php echo $bgcolor;?>><td align=left><?php echo $equivalencias[$k]['lista_disc_ies'];?> </td><td align=center><b>equivale a</b></td><td align=left> <?php echo $equivalencias[$k]['lista_disc_mat'];?> </td><td align=center><?php echo $equivalencias[$k]['tipo_equiv'];?></td><td align=left> <?php echo $equivalencias[$k]['comentarios'];?></td></tr> 
			<?php
			}?>
	</tr>
	<tr>
	<td align=center colspan=5 class=header><b>Equival&ecirc;ncias </b></td>
	</tr>
	<tr>
	<td colspan=2 valign=top><TABLE BORDER>
        	<tr>
	        <td class=data align=center><b>disciplinas da IES de origem</b> </td>
		</tr>
		<?php
        	  for ($i=0;$i<$num;$i++)
			{?>
			<tr><td><INPUT TYPE="checkbox" NAME="disciplinas_ies[]" VALUE="<?php echo $disciplinas[$i]['disciplina']."(".$disciplinas[$i]['carga_horaria'].")";?>"> <?php echo $disciplinas[$i]['disciplina'];?> - (<?php echo $disciplinas[$i]['carga_horaria'];?>)</td></tr>
        	        <?php }
	        ?>
		  </TABLE>
	</td>
	<td colspan=3 valign=top><TABLE BORDER>
		<tr><td class=data align=center> <b>disciplinas do MAT </b> </td>
		</tr>
	          <?php
        	  for ($j=0;$j<$num_MAT;$j++)
			{?>
			<tr><td><INPUT TYPE="checkbox" NAME="disciplinas_MAT[]" VALUE="<?php echo $disciplinas_MAT[$j]['codigo'];?>"> <a href="http://www.serverweb.unb.br/matriculaweb/graduacao/disciplina.aspx?cod=<?php echo $disciplinas_MAT[$j]['codigo'];?>"><?php echo $disciplinas_MAT[$j]['codigo'];?></a>-<?php echo $disciplinas_MAT[$j]['nome'];?> - (<?php echo $disciplinas_MAT[$j]['creditos'];?>)</td></tr>
        	        <?php }
	         ?>
	   </TABLE>
	</td>
	</tr>
	</tr>
	<tr>
	<td colspan=2><b>escolha o tipo:</b> <select name='aproveitamento'>
				<option value='CD'>Cr&eacute;ditos diretos</option>
				<option value='EE'>Exame especial</option>
				<option value='EC'>Estudos complementares</option>
				<option value='NE'>N&atilde;o h&aacute; equival&ecirc;ncia</option>
				</select>
	</td>
	<td colspan=3><b>Coment&aacute;rios:</b><textarea name='comentarios' rows="5" cols="20"></textarea>
	</tr>
	</tr>
     <tr><td>
	<input type="hidden" name="codigo_ies" value="<?php echo $codigo_ies;?>">
	<input type="hidden" name="escolha_IES" value="<?php echo $codigo_ies;?>">
	<input type="submit" name="continua_equivalencia" value="Confirma e continua o processo de equival&ecirc;ncia">
	<input type="submit" name="encerra_equivalencia" value="Confirma e selecione outra IES">
	<input type="submit" name='vincula_unbdoc' value="Emitir parecer"></td>
     </tr>
	</form>
	</table>
	</body>
<?php
}

// ------------------------------------------------termino continua equivalencia
//


// --------------------------------------------------encerra equivalencia
if (isset($_POST['encerra_equivalencia']) or isset($_POST['encerra_equivalencia2'])) 
{

	$codigo_ies=$_POST['codigo_ies'];
//echo "estou em encerra equivalencia";
	$disciplina=$_POST['disciplina'];
	$carga_horaria=$_POST['carga_horaria'];
	$num_disciplinas_novas=0;
	for ($i=0;$i<count($disciplina);$i++)
		{
		if (!empty($disciplina[$i])) $num_disciplinas_novas=$num_disciplinas_novas+1;
		}
	if($num_disciplinas_novas!=0) 
	{?>
	 <body>
	      <table class=big>
	   <form method="POST" name="formu" action="equivalencias.php">
		<tr><td><p> <b><i>H&aacute; disciplinas novas a serem inseridas; a equival&ecirc;ncia n&atilde;o pode ser encerrada!</i></b></p></td></tr> 
		<tr>
		<input type="hidden" name="ies_origem" value="<?php echo $codigo_ies;?>">
		<input type="hidden" name="escolha_IES" value="<?php echo $codigo_ies;?>">
		<input type="submit" name="voltar" value="Voltar &agrave; p&aacute;gina anterior">
	     </tr>
	  </form>
	  </table>
	</body>
	<?php
	}
	else 
	{

//	$codigo_ies=$_POST['codigo_ies'];
	$aproveitamento=$_POST['aproveitamento'];
	$comentarios=$_POST['comentarios'];
	$disciplinas_MAT=$_POST['disciplinas_MAT'];
	$disciplinas_ies=$_POST['disciplinas_ies'];
	
	if ((count($disciplinas_MAT)!=0) and (count($disciplinas_ies)!=0))
	{
	$mat="";
	for ($i=0;$i<count($disciplinas_MAT);$i++)
		{
		$mat.="+".$disciplinas_MAT[$i];
		}
	$ies="";
	for ($i=0;$i<count($disciplinas_ies);$i++)
		{
		$ies.="+".$disciplinas_ies[$i];
		}

// TABLE equiv_resultado(codigo,codigo_ies integer,lista_disc_IES text,lista_disc_MAT text,tipo_equiv varchar(3)#(da equivalencia: ED, NE, EE, EC),comentarios text)
	if ($ies!="") $insere_equiv=pg_query("insert into equiv_resultado values(default,'".$codigo_ies."','".$ies."','".$mat."','".$aproveitamento."','".$comentarios."')") or die ("Nao foi possivel acessar o banco de dados.");
	}
	//VOLTA PARA A PAGINA INICIAL
	echo "<script type=\"text/javascript\">window.location=\"equivalencias.php\";</script>";
	exit;
	}
}
//------------------------------------------------------- termino encerra equivalencia



// ----------------------------------------------------inicia IES

//if ( !isset($_POST['nova_IES'])) 
if (!isset($_POST['continua_equivalencia']) and !isset($_POST['continua_equivalencia2']) and !isset($_POST['encerra_equivalencia']) and !isset($_POST['encerra_equivalencia2'])) 
{
//echo "estou em inicia IES";
//	$codigo_ies=$_POST['ies_origem'];
	$num_ies=0;
	
	if (isset($_POST['vem_da_busca'])) 
		{if ($_POST['codigo_ies']!="vazio") {$num_ies=$num_ies+1;$codigo_ies=$_POST['codigo_ies'];}} 
		else 
		{
		if ($_POST['cefet_origem']!="vazio") {$num_ies=$num_ies+1; $codigo_ies=$_POST['cefet_origem'];}
		if ($_POST['CU_origem']!="vazio") {$num_ies=$num_ies+1; $codigo_ies=$_POST['CU_origem'];}
		if ($_POST['FAC_origem']!="vazio") {$num_ies=$num_ies+1; $codigo_ies=$_POST['FAC_origem'];}
		if ($_POST['IFECT_origem']!="vazio") {$num_ies=$num_ies+1;$codigo_ies=$_POST['IFECT_origem'];}
		if ($_POST['UNIV_origem']!="vazio") {$num_ies=$num_ies+1;$codigo_ies=$_POST['UNIV_origem'];}
		if ($_POST['AM_origem']!="vazio") {$num_ies=$num_ies+1;$codigo_ies=$_POST['AM_origem'];}
		if ($_POST['ESTRANG_origem']!="vazio") {$num_ies=$num_ies+1;$codigo_ies=$_POST['ESTRANG_origem'];}
		}
	if ($num_ies!=1) //voltar a pagina inicial com mensagem (vocêscolheu duas IES de origem - escolha apenas uma ies de origem)
		{
		echo "<script type=\"text/javascript\">window.location=\"equivalencias.php\";</script>";
		echo "Escolha apenas uma IES de origem.";
		exit;
		}

//echo $codigo_ies;
	$recupera_ies=pg_query("select * from  equiv_ies where codigo='".$codigo_ies."'");
	$ies=pg_fetch_row($recupera_ies);
	//recupera os dados para continuar
	$recupera_disciplinas=pg_query("select * from  equiv_disc_ies where codigo_ies='".$codigo_ies."' order by disciplina");
	$disciplinas=pg_fetch_all($recupera_disciplinas);
	$num=pg_num_rows($recupera_disciplinas);

	$recupera_equivalencias=pg_query("select * from  equiv_resultado where codigo_ies='".$codigo_ies."' order by lista_disc_ies");
	$equivalencias=pg_fetch_all($recupera_equivalencias);
	$num_equiv=pg_num_rows($recupera_equivalencias);


	$recupera_disciplinas_MAT=pg_query("select * from  disciplinas_MAT order by nome");
	$disciplinas_MAT=pg_fetch_all($recupera_disciplinas_MAT);
	$num_MAT=pg_num_rows($recupera_disciplinas_MAT);
?>
 <body>
      <table class=big>
   <form method="POST" name="formu" action="equivalencias.php">
      <tr>
        <td class=header align=center colspan=5>
          <h1>Processos de equival&ecirc;ncia do MAT/UnB</h1>
        </td>
	</tr>
       <tr>
	<td align=center colspan=5>
	<table border>
	<tr>
          <td class=header align=center colspan=5 class=header><b>Resultados para a IES de origem: <?php echo $ies[1];?>- <?php echo $ies[2];?></b></td>
	<tr>
		<td align=center><b>Disciplinas da IES </b></td><td class=data align=center><b>equivalentes a</b></td><td align=left><b> Disciplinas do MAT</b></td><td align=center><b> tipo de equival&ecirc;ncia</b></td><td><b> Coment&aacute;rios</b></td>
		<?php
		$cor_de_fundo=0;
		for ($k=0;$k<$num_equiv;$k++)
			{
			if ($cor_de_fundo!=0) {$bgcolor="bgcolor=#FFFFFF";$cor_de_fundo=0;} else {$bgcolor="bgcolor=#B6CDE5";$cor_de_fundo=1;}
			?>
				<tr <?php echo $bgcolor;?>><td  align=left><?php echo $equivalencias[$k]['lista_disc_ies'];?> </td><td align=center><b>equivale a</b></td><td> <?php echo $equivalencias[$k]['lista_disc_mat'];?> </td><td align=center><?php echo $equivalencias[$k]['tipo_equiv'];?></td><td> <?php echo $equivalencias[$k]['comentarios'];?></td></tr> 
			<?php
			}?>
	</table></td>
	</tr>
	<tr>
        <tr>
	<td colspan=2 valign=top><TABLE BORDER>
        	<tr>
	        <td class=data align=center><b>disciplinas da IES de origem</b> </td>
		</tr>
		<?php
        	  for ($i=0;$i<$num;$i++)
			{?>
			<tr><td><?php echo $disciplinas[$i]['disciplina'];?> - (<?php echo $disciplinas[$i]['carga_horaria'];?>)</td></tr>
        	        <?php }
	        ?>
		  </TABLE>
	
	</td>
	<td colspan=2 align=center valign=top>
	<table border class=form>
          <td align=center colspan=3 class=header><b> Inclus&atilde;o de novas disciplinas </b>(tal como no processo) :</td>
        </tr>
        <tr>
        <td class=data align=center><b>N<sup>o</sup> de ordem</b> </td><td class=data align=center> <b>disciplina cursada </b> </td><td class=data align=center> <b>carga hor&aacute;ria</b> </td>
        </tr>
        <?php
          for ($i=0;$i<10;$i++)
                {
        ?>
                <tr>
                <td><?php echo $i;?></td>
                <td><INPUT TYPE=text NAME='disciplina[]'</td>
		<td><INPUT TYPE=text NAME='carga_horaria[]'</td>
                </tr>
        <?php
                }
        ?>
	</table>
	</td>
	</tr>
     <tr>
	<td align=center>
	<input type="hidden" name="codigo_ies" value="<?php echo $codigo_ies;?>">
	<input type="hidden" name="escolha_IES" value="<?php echo $codigo_ies;?>">
	<input type="submit" name="continua_equivalencia2" value="Confirma e continua o processo de equival&ecirc;ncia"></td>
	<td><input type="submit" name="encerra_equivalencia2" value="Confirma e selecione outra IES"></td>
	<td><input type="submit" name='vincula_unbdoc' value="Emitir parecer">
	</td>
     </tr>
</form>
</table>
</body>

<?php
}
}
// ------------------------------------------------------------------termina IES
//
//
} // final de if (!isset($_POST['vincula_unbdoc']))

if (isset($_POST['vincula_unbdoc']))
{
$codigo_ies=$_POST['codigo_ies'];
$query_dados_ies=pg_query("select * from equiv_resultado where codigo_ies='".$codigo_ies."' and (tipo_equiv='EE' or tipo_equiv='EC')");
$num_equiv=pg_num_rows($query_dados_ies);
$equivalencias=pg_fetch_all($query_dados_ies);
//$num_equiv=pg_num_rows($query_dados_ies);
//echo $num_equiv;
$query_ies=pg_query("select codigo, nome_instituicao from equiv_ies where codigo='".$codigo_ies."'");
$ies=pg_fetch_row($query_ies);

$query_unbdoc=pg_query("select id_entrada,unbdoc,data_registro from aproveitamento_entrada order by data_registro desc");

?>
<body>
      <table class=big>
   <form method="POST" name="formu" action="emitir_parecer.php">
      <tr>
        <td class=header align=center colspan=6>
          <h1>Processos de equival&ecirc;ncia do MAT/UnB</h1>
        </td>
        </tr>
       <tr>
        <td align=center colspan=6>
        <table border>
        <tr>
          <td class=header align=center colspan=6 class=header><b>Resultados para a IES de origem: <?php echo $ies[1];?>- <?php echo $ies[2];?></b></td>
        <tr>
                <td align=center><b>Selecionar</b></td><td align=center><b>Disciplinas da IES </b></td><td class=data align=center><b>equivalentes a</b></td><td align=left><b> Disciplinas do MAT</b></td><td align=center><b> tipo de equival&ecirc;ncia</b></td><td><b> Coment&aacute;rios</b></td>
                <?php
                $cor_de_fundo=0;
                for ($k=0;$k<$num_equiv;$k++)
                        {
                        if ($cor_de_fundo!=0) {$bgcolor="bgcolor=#FFFFFF";$cor_de_fundo=0;} else {$bgcolor="bgcolor=#B6CDE5";$cor_de_fundo=1;}
                        ?>
                                <tr <?php echo $bgcolor;?>><td><input type=checkbox name='selecao[]' value="<?php echo $equivalencias[$k]['codigo'];?>"></td><td  align=left><?php echo $equivalencias[$k]['lista_disc_ies'];?> </td><td align=center><b>equivale a</b></td><td> <?php echo $equivalencias[$k]['lista_disc_mat'];?> </td><td align=center><?php echo $equivalencias[$k]['tipo_equiv'];?></td><td> <?php echo $equivalencias[$k]['comentarios'];?></td></tr>
                        <?php
                        }?>
        </table></td>
	</tr>
	<tr>
	<td><b>Sele&ccedil;&atilde;o de UnBDoc: </b><select name='unbdoc'>
		<?php
		while ($registro_unbdoc=pg_fetch_row($query_unbdoc))
			{
			echo "<option value=\"".$registro_unbdoc[0]."\">".$registro_unbdoc[1]."</option>";
			}
		?>
		</select>
        </tr>
	<tr>
	<td align=center><input type=submit name='avancar' value="Confirmar"></td>
	</tr>
	</form>
	</table>
	</body>
<?php
}

?>  
</html>
<?php
  pg_close($idconn);
?>
