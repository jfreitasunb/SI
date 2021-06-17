<?php
include("head_coordenacao.php");

?>
<html>
  <header>
    <link type="text/css" rel="stylesheet" href="../../global/grafic.css">
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
  </header>


<?php

//echo $_POST['escolha_IES'];

// -----------------------------------------------------------------escolha_IES
if (!isset($_POST['escolha_IES']))  
{
?>
  <body>
      <table class=big>
   <form method="POST" name="formu" action="corrige_equivalencias.php">
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
	</td>
     </tr>
</form>
</table>
</body>


<?php
// ----------------------------------------------------termino  escolha_IES
}

// ------------------------------------------------termino insere nova IES

if (isset($_POST['escolha_IES']))  
{
// ------------------------------------------------continua equivalencia
if (!isset($_POST['corrige'])) 
{
//echo "estou em continua equivalencia";

	if (isset($_POST['codigo_ies'])) $codigo_ies=$_POST['codigo_ies'];
	else 
		{
		$num_ies=0;
        	if ($_POST['cefet_origem']!="vazio") {$num_ies=$num_ies+1; $codigo_ies=$_POST['cefet_origem'];}
	        if ($_POST['CU_origem']!="vazio") {$num_ies=$num_ies+1; $codigo_ies=$_POST['CU_origem'];}
        	if ($_POST['FAC_origem']!="vazio") {$num_ies=$num_ies+1; $codigo_ies=$_POST['FAC_origem'];}
	        if ($_POST['IFECT_origem']!="vazio") {$num_ies=$num_ies+1;$codigo_ies=$_POST['IFECT_origem'];}
	        if ($_POST['UNIV_origem']!="vazio") {$num_ies=$num_ies+1;$codigo_ies=$_POST['UNIV_origem'];}
	        if ($_POST['AM_origem']!="vazio") {$num_ies=$num_ies+1;$codigo_ies=$_POST['AM_origem'];}
	        if ($_POST['ESTRANG_origem']!="vazio") {$num_ies=$num_ies+1;$codigo_ies=$_POST['ESTRANG_origem'];}
	
	        if ($num_ies>1) //voltar a pagina inicial com mensagem (voc<EA>scolheu duas IES de origem - escolha apenas uma ies de origem)
	                {
	                echo "<script type=\"text/javascript\">window.location=\"corrige_equivalencias.php\";</script>";
	                echo "Escolha apenas uma IES de origem.";
	                exit;
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
   <form method="POST" name="formu2" action="corrige_equivalencias.php">
      <tr>
        <td class=header align=center colspan=6>
          <h1>Processos de equival&ecirc;ncia do MAT/UnB</h1>
        </td>
      </tr>
       <tr>
          <td align=center colspan=6 class=header><b>Resultados para a IES de origem: <?php echo $ies_0[1];?> - <?php echo $ies_0[2];?>  </b></td>
	</tr>
	<tr>
	<td><b>Disciplinas da IES</b></td><td align=center><b> equivalentes &agrave;s</b></td><td align=center><b> Disciplinas do MAT</b></td><td align=center><b> tipo de equival&ecirc;ncia</b></td><td><b> coment&aacute;rios</b></td><td><b>Eliminar parecer</b></td>
	</tr>
		<?php
		$cor_de_fundo=0;
		for ($k=0;$k<$num_equiv;$k++)
			{
			if ($cor_de_fundo!=0) {$bgcolor="bgcolor=#FFFFFF";$cor_de_fundo=0;} else {$bgcolor="bgcolor=#B6CDE5";$cor_de_fundo=1;}
			?>
				<tr <?php echo $bgcolor;?>><td align=left><?php echo $equivalencias[$k]['lista_disc_ies'];?> </td><td align=center><b>equivale a</b></td><td align=left> <?php echo $equivalencias[$k]['lista_disc_mat'];?> </td><td align=center><?php echo $equivalencias[$k]['tipo_equiv'];?></td><td align=left> <?php echo $equivalencias[$k]['comentarios'];?></td><td><input type="checkbox" name='elimina[]' value='<?php echo $equivalencias[$k]['codigo'];?>'</td></tr> 
			<?php
			}?>
	</tr>
	<tr>
	<td align=center colspan=6 class=header><b>Equival&ecirc;ncias </b></td>
	</tr>
	<tr>
	<td colspan=2 valign=top><TABLE BORDER>
        	<tr>
	        <td class=data align=center><b>disciplinas da IES de origem</b> </td>
		</tr>
		<?php
        	  for ($i=0;$i<$num;$i++)
			{?>
			<tr><td><INPUT TYPE="checkbox" NAME="disciplinas_ies[]" VALUE="<?php echo $disciplinas[$i]['codigo'];?>"><input type="hidden" name='disciplinas_ies2[]' value="<?php echo $disciplinas[$i]['codigo'];?>"> <input type="text" name='nome_disciplina_ies[]' value="<?php echo $disciplinas[$i]['disciplina'];?>"> - (<input type="text" name='carga_horaria_disciplina_ies[]' value="<?php echo $disciplinas[$i]['carga_horaria'];?>">)</td></tr>
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
			<tr><td><INPUT TYPE="checkbox" NAME="disciplinas_MAT[]" VALUE="<?php echo $disciplinas_MAT[$j]['codigo'];?>"> <?php echo $disciplinas_MAT[$j]['codigo'];?>-<?php echo $disciplinas_MAT[$j]['nome'];?> - (<?php echo $disciplinas_MAT[$j]['creditos'];?>)</td></tr>
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
	<input type="submit" name="corrige" value="Confirma a corre&ccedil;&atilde;o">
	</td>
     </tr>
	</form>
	</table>
	</body>
<?php
}

// ------------------------------------------------termino continua equivalencia
//


// --------------------------------------------------encerra equivalencia
if (isset($_POST['corrige'])) 
{

	$codigo_ies=$_POST['codigo_ies'];
	$aproveitamento=$_POST['aproveitamento'];
	$comentarios=$_POST['comentarios'];
	$disciplinas_MAT=$_POST['disciplinas_MAT'];
	$disciplinas_ies=$_POST['disciplinas_ies'];  // codigo da disciplina a ser corrigida
	$disciplinas_ies2=$_POST['disciplinas_ies2'];  // codigo da disciplina a ser corrigida
	$nome_disciplina_ies=$_POST['nome_disciplina_ies']; //nome a ser corrigido
	$carga_horaria_disciplina_ies=$_POST['carga_horaria_disciplina_ies']; //carga horaria a ser corrigida
	$elimina=$_POST['elimina'];
	

	$mat="";
	for ($i=0;$i<count($disciplinas_MAT);$i++)
	{
		if($mat=="") $mat=$disciplinas_MAT[$i]; else $mat.="+".$disciplinas_MAT[$i];
	}
	

	for ($i=0;$i<count($disciplinas_ies2);$i++)
		{
		$query_corrige_discplinas=pg_query("update equiv_disc_ies set disciplina='".$nome_disciplina_ies[$i]."', carga_horaria='".$carga_horaria_disciplina_ies[$i]."' where codigo='".$disciplinas_ies2[$i]."'") or die ("Nao foi possivel acessar o banco de dados."); 
		//echo "update equiv_disc_ies set disciplina='".$nome_disciplina_ies[$i]."', carga_horaria='".$carga_horaria_disciplina_ies[$i]."' where codigo='".$disciplinas_ies2[$i]."') or die (Nao foi possivel acessar o banco de dados.)"; 
		}

	$ies="";
	for ($i=0;$i<count($disciplinas_ies);$i++)
	{
		$pega_nome_e_carga=pg_query("select disciplina,carga_horaria from equiv_disc_ies where codigo='".$disciplinas_ies[$i]."'") or die ("Nao foi possivel acessar o banco de dados.");
		$disciplina_carga=pg_fetch_array($pega_nome_e_carga);
		
		if ($ies=="") $ies=$disciplina_carga['disciplina']."(".$disciplina_carga['carga_horaria'].")"; else $ies.="+".$disciplina_carga['disciplina']."(".$disciplina_carga['carga_horaria'].")";
	}

// TABLE equiv_resultado(codigo,codigo_ies integer,lista_disc_IES text,lista_disc_MAT text,tipo_equiv varchar(3)#(da equivalencia: ED, NE, EE, EC),comentarios text)
	if ($ies!="") $insere_equiv=pg_query("insert into equiv_resultado values(default,'".$codigo_ies."','".$ies."','".$mat."','".$aproveitamento."','".$comentarios."')") or die ("Nao foi possivel acessar o banco de dados.");
	//echo "insert into equiv_resultado values(default,'".$codigo_ies."','".$ies."','".$mat."','".$aproveitamento."','".$comentarios."')) or die (Nao foi possivel acessar o banco de dados.)";
	for($j=0;$j<count($elimina);$j++)
		{
		if (!empty($elimina[$j])) $query_elimina=pg_query("delete from equiv_resultado where codigo='".$elimina[$j]."'") or die ("Nao foi possivel acessar o banco de dados.");
		//if (!empty($elimina[$j])) echo "delete from equiv_resultado where codigo='".$elimina[$j]."') or die (Nao foi possivel acessar o banco de dados.)";
		}
                //echo "<script type=\"text/javascript\">window.location=\"corrige_equivalencias.php\";</script>";
//		echo "<script type=\"text/javascript\">history.back()</script>";
?>

 <body>
      <table class=big>
   <form method="POST" name="formu2" action="corrige_equivalencias.php">
     <tr><td>
	<input type="hidden" name="codigo_ies" value="<?php echo $codigo_ies;?>">
	<input type="submit" name="escolha_IES" value="Continuar" >
	<input type="submit" name="outra" value="Escolha outra IES" >
	</td>
     </tr>
	</form>
	</table>
	</body>
<?php
}
//------------------------------------------------------- termino encerra equivalencia

}
// ------------------------------------------------------------------termina IES
//
//
?>  
</html>
<?php
  pg_close($idconn);
?>
