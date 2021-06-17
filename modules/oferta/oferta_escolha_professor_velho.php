<?PHP
include("head_oferta.php");

?>
<html>
  <header>
    <link type="text/css" rel="stylesheet" href="../../global/grafic.css">
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
  </header>


<?
if(!isset($_POST['registra']))

{
$select_profs=pg_query("select coduser,name,firstname from users where coduser in (select coduser from profs where situacao='ativo') order by name");


$mes=date(n);
$semestre=$mes/12;
if ($semestre<=0.5) $semestre=2; else $semestre=1;

if ($semestre==1) $ano=date(Y)+1; else $ano=date(Y);

//$tabela="oferta_semestre_".$semestre;
$tabela="oferta_lista_de_ofertas_".$semestre."_".$ano;

// disciplinas distintas da lista
$select_disciplinas=pg_query("select distinct on (lo.codigo,lo.turno) lo.codigo,m.nome,lo.turno,lo.status from oferta_semestre_1 lo, disciplinas_mat m where m.codigo=lo.codigo order by lo.codigo,lo.turno");

//$select_disciplinas=pg_query("select dm.codigo, s.turno, dm.nome from disciplinas_mat dm, ".$tabela." s where s.codigo=dm.codigo order by dm.nome,s.turno"); 
$tab_disciplinas=pg_fetch_all($select_disciplinas);


//$select_disciplinas_distintas=pg_query("select codigo, nome, creditos,turno from disciplinas_mat where codigo in (select distinct on (codigo) codigo from ".$tabela." where status='fixa') order by nome");

//$select_disciplinas_distintas_opt=pg_query("select codigo, nome, creditos,turno from disciplinas_mat where codigo in (select distinct on (codigo) codigo from ".$tabela." where status='optativa') order by nome");


//$tab_disciplinas=pg_fetch_all($select_disciplinas);

?>
  <body>
      <table class=big>
   <form method="POST" name="formu" action="oferta_escolha_professor.php">
      <tr>
        <td class=header align=center colspan=2>
        <h1>Ficha de Prefer&ecirc;ncias &ndash; <? echo $semestre;?>&ordm;/ <? echo $ano;?></h1>
        </td>
      </tr>
      <tr>
	      <td>Professor:
			<select name='professor'>
				<?	
				while ($registro_0=pg_fetch_row($select_profs))
				{
				?>
				<option value="<? echo $registro_0[0];?>"> <? echo $registro_0[1]." ".$registro_0[2];?></option>
				<?
				}
				?>
				</select>  
			</td>
	</tr>
	<tr>
	<td>Quantos cr&eacute;ditos pretende lecionar na gradua&ccedil;&atilde;o? 
		<select name='creditos'>
			<option value='0'> 0 cr&eacute;ditos</option> 
			<option value='4'> 4 cr&eacute;ditos</option> 
			<option value='6'> 6 cr&eacute;ditos</option>
			<option value='8'> 8 cr&eacute;ditos</option>
			<option value='10'> 10 cr&eacute;ditos</option>
			<option value='12'> 12 cr&eacute;ditos</option>
			<option value='14'> 14 cr&eacute;ditos</option>
			<option value='16'> 16 cr&eacute;ditos</option>
			</select>
		</td>
	</tr>
	<tr>
		<td>Prefer&ecirc;ncia por 2 (duas) disciplinas de 6 cr&eacute;ditos iguais? 
		<select name='disciplinas_iguais_6'>  
			<option value="nao" selected> N&atilde;o</option>
			<option value="sim"> Sim</option>
		</select>
	</td>
	</tr>
	<tr>
	<td>Quais disciplinas pretende lecionar na p&oacute;s-gradua&ccedil;&atilde;o (exceto Est&aacute;gios em Pesquisa)?<BR>
	<?
	for ($cont_pos=0;$cont_pos<2;$cont_pos++)
		{
	?>
		<select name='disc_pos[]'>
			<option value="0-0" selected>Nenhuma</option>
		<?
		$select_disciplinas_pg[$cont_pos]=pg_query("select codigo, nome, creditos from disciplinas_mat where status='pgrad' order by nome"); 
		while ($registro[$cont_pos]=pg_fetch_row($select_disciplinas_pg[$cont_pos]))
			{
			?>
			<option value="<? echo $registro[$cont_pos][0]."-".$registro[$cont_pos][2];?>"> <? echo $registro[$cont_pos][0]."-".$registro[$cont_pos][1]." (".$registro[$cont_pos][2].")";?></option>
			<?
			}
			?>
			</select>  
			<BR>
		<?
		}
		?>
		</td>
	      </tr>
	<tr>
		<td>Cr&eacute;ditos em Est&aacute;gio de Pesquisa:<br>
		<?
		for ($cont_pesq=0;$cont_pesq<5;$cont_pesq++)
			{
		?>
		<select name='credito_estagio_pesquisa[]'>  
			<option value='0' selected> 0 </option>
			<option value='1'> 1 </option>
			<option value='2'> 2 </option>
		</select> cr&eacute;ditos -  Orientando: 
	       <select name='orientando[]'>
			<option value="0" selected>Nenhum</option>
			<?
			$select_orientando[$cont_pesq]=pg_query("select coduser,name,firstname from users where coduser in (select coduser from student where status='ativo') order by name");
		while ($registro1[$cont_pesq]=pg_fetch_row($select_orientando[$cont_pesq]))
			{
			?>
			<option value="<? echo $registro1[$cont_pesq][0];?>"> <? echo $registro1[$cont_pesq][1]." ".$registro1[$cont_pesq][2];?></option>
			<?
			}
			?>
			</select>  
			<BR>	
			<?}?>
		</td>
		</tr>
		<tr><td> Preencha as colunas de prioridades abaixo com n&uacute;meros de 1 (um) a 6 (seis), sendo essa escolha sua ordem decrescente de prioridade </td></tr>
		<tr>
			<TABLE WIDTH=482 BORDER=1 BORDERCOLOR="#000000" CELLPADDING=7 CELLSPACING=0 ALIGN=CENTER>
			<COL WIDTH=35>
			<COL WIDTH=275>
			<COL WIDTH=63>
			<COL WIDTH=51>
			<TR VALIGN=TOP>
				<TD WIDTH=35 BGCOLOR="#d8d8d8">
					<P CLASS="western" ALIGN=CENTER><FONT SIZE=2 STYLE="font-size: 11pt">Prio.</FONT></P>
				</TD>
				<TD WIDTH=275 BGCOLOR="#d8d8d8">
					<P CLASS="western" ALIGN=CENTER><FONT SIZE=2 STYLE="font-size: 11pt">Disciplina</FONT></P>
				</TD>
				<TD WIDTH=63 BGCOLOR="#d8d8d8">
					<P CLASS="western" ALIGN=CENTER><FONT SIZE=2 STYLE="font-size: 11pt">Turmas</FONT></P>
				</TD>
				<TD WIDTH=51 BGCOLOR="#d8d8d8">
					<P CLASS="western" ALIGN=CENTER><FONT SIZE=2 STYLE="font-size: 11pt">Cr&eacute;ditos</FONT></P>
				</TD>
			</TR>
<?
//			---------------disciplina 

			
			$cor_de_fundo="#FFFFFF";
			while ($registro_100=pg_fetch_row($select_disciplinas_distintas))
				{
				$query_quantidade_turmas=pg_query("select codigo from ".$tabela." where codigo='".$registro_100[0]."' and turno='Diurno'");
				$num_diurno=pg_num_rows($query_quantidade_turmas);

			if ($cor_de_fundo=="#FFFFFF") $cor_de_fundo="#D0D0D0"; else $cor_de_fundo="#FFFFFF";	
?>
			<TR VALIGN=TOP BGCOLOR="<? echo $cor_de_fundo;?>">
				<TD WIDTH=35>
					<P CLASS="western"><BR>
					<input type=text name='Diurno[<? echo $registro_100[0];?>][]' size="2" maxlength="1" value="0"></P> 
				</TD>
				<TD WIDTH=275>
					<P CLASS="western"><FONT COLOR="#000000"><FONT SIZE=2 STYLE="font-size: 11pt"> <? echo $registro_100[1];?> - diurno </FONT></FONT>
					</P>
				</TD>
				<TD WIDTH=63>
					<P CLASS="western" ALIGN=CENTER><FONT COLOR="#000000"><FONT SIZE=2 STYLE="font-size: 11pt"><? echo $num_diurno;?></FONT></FONT></P>
				</TD>
				<TD WIDTH=51>
					<P CLASS="western" ALIGN=CENTER><FONT COLOR="#000000"><FONT SIZE=2 STYLE="font-size: 11pt"> <? echo $registro_100[2];?> </FONT></FONT></P>
				</TD>
			</TR>

<?
				} // fecha dp-while

			while ($registro_101=pg_fetch_row($select_disciplinas_distintas_noturno))
				{
//				$num_noturno=count($tab_disciplinas[$registro_101[0]]['Noturno']);

				$query_quantidade_turmas=pg_query("select codigo from ".$tabela." where codigo='".$registro_101[0]."' and turno='Noturno'");
				$num_noturno=pg_num_rows($query_quantidade_turmas);

			if ($cor_de_fundo=="#FFFFFF") $cor_de_fundo="#D0D0D0"; else $cor_de_fundo="#FFFFFF";	
?>
			<TR VALIGN=TOP BGCOLOR="<? echo $cor_de_fundo;?>">
				<TD WIDTH=35>
					<P CLASS="western"><BR>
					<input type=text name='Noturno[<? echo $registro_101[0];?>][]' size="2" maxlength="1" value="0"></P> 
				</TD>
				<TD WIDTH=275>
					<P CLASS="western"><FONT COLOR="#000000"><FONT SIZE=2 STYLE="font-size: 11pt"> <? echo $registro_101[1];?> - noturno </FONT></FONT>
					</P>
				</TD>
				<TD WIDTH=63>
					<P CLASS="western" ALIGN=CENTER><FONT COLOR="#000000"><FONT SIZE=2 STYLE="font-size: 11pt"><? echo $num_noturno;?></FONT></FONT></P>
				</TD>
				<TD WIDTH=51>
					<P CLASS="western" ALIGN=CENTER><FONT COLOR="#000000"><FONT SIZE=2 STYLE="font-size: 11pt"> <? echo $registro_101[2];?> </FONT></FONT></P>
				</TD>
			</TR>

<?
				} // fecha dp-while
?>

			<TR>
				<TD COLSPAN=4 WIDTH=466 VALIGN=TOP BGCOLOR="#cccccc">
					<P CLASS="western" ALIGN=CENTER><FONT FACE="Arial, sans-serif"><FONT SIZE=2 STYLE="font-size: 11pt">Optativas
					do semestre</FONT></FONT></P>
				</TD>
			</TR>
			<?			

			while ($registro_102=pg_fetch_row($select_disciplinas_distintas_opt_diurno))
				{
		
				$query_quantidade_turmas=pg_query("select codigo from ".$tabela." where codigo='".$registro_102[0]."' and turno='Diurno'");
				$num_diurno=pg_num_rows($query_quantidade_turmas);


			if ($cor_de_fundo=="#FFFFFF") $cor_de_fundo="#D0D0D0"; else $cor_de_fundo="#FFFFFF";	
?>
			<TR VALIGN=TOP BGCOLOR="<? echo $cor_de_fundo;?>">
				<TD WIDTH=35>
					<P CLASS="western"><BR>
					<input type=text name='Diurno[<? echo $registro_102[0];?>][]' size="2" maxlength="1" value="0"></P> 
				</TD>
				<TD WIDTH=275>
					<P CLASS="western"><FONT COLOR="#000000"><FONT SIZE=2 STYLE="font-size: 11pt"> <? echo $registro_102[1];?> - diurno </FONT></FONT>
					</P>
				</TD>
				<TD WIDTH=63>
					<P CLASS="western" ALIGN=CENTER><FONT COLOR="#000000"><FONT SIZE=2 STYLE="font-size: 11pt"><? echo $num_diurno;?></FONT></FONT></P>
				</TD>
				<TD WIDTH=51>
					<P CLASS="western" ALIGN=CENTER><FONT COLOR="#000000"><FONT SIZE=2 STYLE="font-size: 11pt"> <? echo $registro_102[2];?> </FONT></FONT></P>
				</TD>
			</TR>

<?
				} // fecha dp-while

			while ($registro_103=pg_fetch_row($select_disciplinas_distintas_opt_noturno))
				{
//				$num_noturno=count($tab_disciplinas[$registro_103[0]]['Noturno']);

				$query_quantidade_turmas=pg_query("select codigo from ".$tabela." where codigo='".$registro_103[0]."' and turno='Noturno'");
				$num_noturno=pg_num_rows($query_quantidade_turmas);

			if ($cor_de_fundo=="#FFFFFF") $cor_de_fundo="#D0D0D0"; else $cor_de_fundo="#FFFFFF";	
?>
			<TR VALIGN=TOP BGCOLOR="<? echo $cor_de_fundo;?>">
				<TD WIDTH=35>
					<P CLASS="western"><BR>
					<input type=text name='Noturno[<? echo $registro_103[0];?>][]' size="2" maxlength="1" value="0"></P> 
				</TD>
				<TD WIDTH=275>
					<P CLASS="western"><FONT COLOR="#000000"><FONT SIZE=2 STYLE="font-size: 11pt"> <? echo $registro_103[1];?> - noturno </FONT></FONT>
					</P>
				</TD>
				<TD WIDTH=63>
					<P CLASS="western" ALIGN=CENTER><FONT COLOR="#000000"><FONT SIZE=2 STYLE="font-size: 11pt"><? echo $num_noturno;?></FONT></FONT></P>
				</TD>
				<TD WIDTH=51>
					<P CLASS="western" ALIGN=CENTER><FONT COLOR="#000000"><FONT SIZE=2 STYLE="font-size: 11pt"> <? echo $registro_103[2];?> </FONT></FONT></P>
				</TD>
			</TR>

<?
				} // fecha dp-while

?>

		</TABLE>
	</tr>
	<tr>
<td align=center>
<input type=submit name='registra' value="Confirmar op&ccedil;&otilde;es">
<input type=reset name='limpa' value="Limpar formul&aacute;rio">
<input type=hidden name='semestre' value="<? echo $semestre;?>">
<input type=hidden name='ano' value="<? echo $ano;?>">
</td>
</tr>
</table>
</form>
</BODY>
</HTML>

<?
}

// Inicia confirmacao das opcoes

if(isset($_POST['registra']) and !isset($_POST['confirma']))
{

$ano=$_POST['ano'];
$semestre=$_POST['semestre'];

$professor=$_POST['professor'];

$creditos=$_POST['creditos'];
$disciplinas_iguais_6=$_POST['disciplinas_iguais_6'];

$disc_pos=$_POST['disc_pos'];

$orientando=$_POST['orientando'];
$credito_estagio_pesquisa=$_POST['credito_estagio_pesquisa'];

$Diurno=$_POST['Diurno'];
$Noturno=$_POST['Noturno'];




$select_profs=pg_query("select coduser,name,firstname from users where coduser in (select coduser from profs where situacao='ativo') order by name");

$tabela="oferta_semestre_".$semestre;

$select_disciplinas=pg_query("select dm.codigo, s.turno, dm.nome from disciplinas_mat dm, ".$tabela." s where s.codigo=dm.codigo order by dm.nome,s.turno"); 
$tab_disciplinas=pg_fetch_all($select_disciplinas);


$select_disciplinas_distintas_diurno=pg_query("select codigo, nome, creditos from disciplinas_mat where codigo in (select distinct on (codigo) codigo from ".$tabela." where status='fixa' and turno='Diurno') order by nome");

$select_disciplinas_distintas_noturno=pg_query("select codigo, nome, creditos from disciplinas_mat where codigo in (select distinct on (codigo) codigo from ".$tabela." where status='fixa' and turno='Noturno') order by nome");


$select_disciplinas_distintas_opt_diurno=pg_query("select codigo, nome, creditos from disciplinas_mat where codigo in (select distinct on (codigo) codigo from ".$tabela." where status='optativa' and turno='Diurno') order by nome");

$select_disciplinas_distintas_opt_noturno=pg_query("select codigo, nome, creditos from disciplinas_mat where codigo in (select distinct on (codigo) codigo from ".$tabela." where status='optativa' and turno='Noturno') order by nome");


//$tab_disciplinas=pg_fetch_all($select_disciplinas);

?>
  <body>
      <table class=big>
   <form method="POST" name="formu" action="oferta_escolha_professor.php">
      <tr>
        <td class=header align=center colspan=2>
        <h1>Ficha de Prefer&ecirc;ncias &ndash; <? echo $semestre;?>&ordm;/ <? echo $ano;?></h1><br>
	<h1> Confirma&ccedil;&atilde;o das op&ccedil;&otilde;es </h1>
        </td>
      </tr>
      <tr>
	      <td>Professor:
			<select name='professor'>
				<?	
				while ($registro_0=pg_fetch_row($select_profs))
				{
				?>
				<option value="<? echo $registro_0[0];?>" <? if ($registro_0[0]==$professor) echo "selected";?>> <? echo $registro_0[1]." ".$registro_0[2];?></option>
				<?
				}
				?>
				</select>  
			</td>
	</tr>
	<tr>
	<td>Quantos cr&eacute;ditos pretende lecionar na gradua&ccedil;&atilde;o? 
		<select name='creditos'>
			<option value='0'  <? if ($creditos==0) echo "selected";?>> 0 cr&eacute;ditos</option> 
			<option value='4'  <? if ($creditos==4) echo "selected";?>> 4 cr&eacute;ditos</option> 
			<option value='6'  <? if ($creditos==6) echo "selected";?>> 6 cr&eacute;ditos</option>
			<option value='8'  <? if ($creditos==8) echo "selected";?>> 8 cr&eacute;ditos</option>
			<option value='10' <? if ($creditos==10) echo "selected";?>> 10 cr&eacute;ditos</option>
			<option value='12' <? if ($creditos==12) echo "selected";?>> 12 cr&eacute;ditos</option>
			<option value='14' <? if ($creditos==14) echo "selected";?>> 14 cr&eacute;ditos</option>
			<option value='16' <? if ($creditos==16) echo "selected";?>> 16 cr&eacute;ditos</option>
			</select>
		</td>
	</tr>
	<tr>
		<td>Prefer&ecirc;ncia por 2 (duas) disciplinas de 6 cr&eacute;ditos iguais? 
		<select name='disciplinas_iguais_6'>  
			<option value="nao" <? if ($disciplinas_iguais_6=="nao") echo "selected";?>> N&atilde;o</option>
			<option value="sim" <? if ($disciplinas_iguais_6=="sim") echo "selected";?>> Sim</option>
		</select>
	</td>
	</tr>
	<tr>
	<td>Quais disciplinas pretende lecionar na p&oacute;s-gradua&ccedil;&atilde;o (exceto Est&aacute;gios em Pesquisa)?<BR>
		<select name='disc_pos[]'>
			<option value="0-0" selected>Nenhuma</option>
		<?
		$select_disciplinas_pg=pg_query("select codigo, nome, creditos from disciplinas_mat where status='pgrad' order by nome"); 
		while ($registro_10=pg_fetch_row($select_disciplinas_pg))
			{
			?>
			<option value="<? echo $registro_10[0]."-".$registro_10[2];?>" <? if ($disc_pos[0]==$registro_10[0]."-".$registro_10[2]) echo "selected";?>> <? echo $registro_10[1]." (".$registro_10[2].")";?></option>
			<?
			}
			?>
			</select>  
			<BR>
		<select name='disc_pos[]'>
			<option value="0-0" selected>Nenhuma</option>
			<?
		$select_disciplinas_pg=pg_query("select codigo, nome, creditos from disciplinas_mat where status='pgrad' order by nome"); 
		while ($registro_11=pg_fetch_row($select_disciplinas_pg))
			{
			?>
			<option value="<? echo $registro_11[0]."-".$registro_11[2];?>" <? if ($disc_pos[1]==$registro_11[0]."-".$registro_11[2]) echo "selected";?>> <? echo $registro_11[1]." (".$registro_11[2].")";?></option>
			<?
			}
			?>
			</select>  
			</td>
	      </tr>
	<tr>
		<td>Cr&eacute;ditos em Est&aacute;gio de Pesquisa:<br>
		<select name='credito_estagio_pesquisa[]'>  
			<option value='0' <? if($credito_estagio_pesquisa[0]==0) echo "selected";?>> 0 </option>
			<option value='1' <? if($credito_estagio_pesquisa[0]==1) echo "selected";?>> 1 </option>
			<option value='2' <? if($credito_estagio_pesquisa[0]==2) echo "selected";?>> 2 </option>
		</select> cr&eacute;ditos -  Orientando: 
	       <select name='orientando[]'>
			<option value="0" selected>Nenhum</option>
			<?
			$select_orientando=pg_query("select coduser,name,firstname from users where coduser in (select coduser from student where status='ativo') order by name");
		while ($registro_12=pg_fetch_row($select_orientando))
			{
			?>
			<option value="<? echo $registro_12[0];?>" <? if($orientando[0]==$registro_12[0]) echo "selected";?>> <? echo $registro_12[1]." ".$registro_12[2];?></option>
			<?
			}
			?>
			</select>  
			<BR>	
		<select name='credito_estagio_pesquisa[]'>  
			<option value='0' <? if($credito_estagio_pesquisa[1]==0) echo "selected";?>> 0 </option>
			<option value='1' <? if($credito_estagio_pesquisa[1]==1) echo "selected";?>> 1 </option>
			<option value='2' <? if($credito_estagio_pesquisa[1]==2) echo "selected";?>> 2 </option>
		</select> cr&eacute;ditos  -  Orientando: 
	       <select name='orientando[]'>
			<option value="0" selected>Nenhum</option>
			<?
			$select_orientando=pg_query("select coduser,name,firstname from users where coduser in (select coduser from student where status='ativo') order by name");
		while ($registro_13=pg_fetch_row($select_orientando))
			{
			?>
			<option value="<? echo $registro_13[0];?>" <? if($orientando[1]==$registro_13[0]) echo "selected";?>> <? echo $registro_13[1]." ".$registro_13[2];?></option>
			<?
			}
			?>
			</select>  
			<BR>
			<select name='credito_estagio_pesquisa[]'>  
			<option value='0' <? if($credito_estagio_pesquisa[2]==0) echo "selected";?>> 0 </option>
			<option value='1' <? if($credito_estagio_pesquisa[2]==1) echo "selected";?>> 1 </option>
			<option value='2' <? if($credito_estagio_pesquisa[2]==2) echo "selected";?>> 2 </option>
		</select> cr&eacute;ditos  -  Orientando: 
	       <select name='orientando[]'>
			<option value="0" selected>Nenhum</option>
			<?
			$select_orientando=pg_query("select coduser,name,firstname from users where coduser in (select coduser from student where status='ativo') order by name");
		while ($registro_14=pg_fetch_row($select_orientando))
			{
			?>
			<option value="<? echo $registro_14[0];?>" <? if($orientando[2]==$registro_14[0]) echo "selected";?>> <? echo $registro_14[1]." ".$registro_14[2];?></option>
			<?
			}
			?>
			</select>  
			<BR>
			<select name='credito_estagio_pesquisa[]'>  
			<option value='0' <? if($credito_estagio_pesquisa[3]==0) echo "selected";?>> 0 </option>
			<option value='1' <? if($credito_estagio_pesquisa[3]==1) echo "selected";?>> 1 </option>
			<option value='2' <? if($credito_estagio_pesquisa[3]==2) echo "selected";?>> 2 </option>
		</select> cr&eacute;ditos  -  Orientando: 
	       <select name='orientando[]'>
			<option value="0" selected>Nenhum</option>
			<?
			$select_orientando=pg_query("select coduser,name,firstname from users where coduser in (select coduser from student where status='ativo') order by name");
		while ($registro_15=pg_fetch_row($select_orientando))
			{
			?>
			<option value="<? echo $registro_15[0];?>" <? if($orientando[3]==$registro_15[0]) echo "selected";?>> <? echo $registro_15[1]." ".$registro_15[2];?></option>
			<?
			}
			?>
			</select>  
			<BR>
			<select name='credito_estagio_pesquisa[]'>  
			<option value='0' <? if($credito_estagio_pesquisa[4]==0) echo "selected";?>> 0 </option>
			<option value='1' <? if($credito_estagio_pesquisa[4]==1) echo "selected";?>> 1 </option>
			<option value='2' <? if($credito_estagio_pesquisa[4]==2) echo "selected";?>> 2 </option>
		</select> cr&eacute;ditos  -  Orientando: 
	       <select name='orientando[]'>
			<option value="0" selected>Nenhum</option>
			<?
			$select_orientando=pg_query("select coduser,name,firstname from users where coduser in (select coduser from student where status='ativo') order by name");
		while ($registro_16=pg_fetch_row($select_orientando))
			{
			?>
			<option value="<? echo $registro_16[0];?>" <? if($orientando[4]==$registro_16[0]) echo "selected";?>> <? echo $registro_16[1]." ".$registro_16[2];?></option>
			<?
			}
			?>
			</select>  
			<BR>
		</td>
		</tr>
		<tr><td> Preencha as colunas de prioridades abaixo com n&uacute;meros de 1 (um) a 6 (seis), sendo essa escolha sua ordem decrescente de prioridade </td></tr>
		<tr>
			<TABLE WIDTH=482 BORDER=1 BORDERCOLOR="#000000" CELLPADDING=7 CELLSPACING=0 ALIGN=CENTER>
			<COL WIDTH=35>
			<COL WIDTH=275>
			<COL WIDTH=63>
			<COL WIDTH=51>
			<TR VALIGN=TOP>
				<TD WIDTH=35 BGCOLOR="#d8d8d8">
					<P CLASS="western" ALIGN=CENTER><FONT SIZE=2 STYLE="font-size: 11pt">Prio.</FONT></P>
				</TD>
				<TD WIDTH=275 BGCOLOR="#d8d8d8">
					<P CLASS="western" ALIGN=CENTER><FONT SIZE=2 STYLE="font-size: 11pt">Disciplina</FONT></P>
				</TD>
				<TD WIDTH=63 BGCOLOR="#d8d8d8">
					<P CLASS="western" ALIGN=CENTER><FONT SIZE=2 STYLE="font-size: 11pt">Turmas</FONT></P>
				</TD>
				<TD WIDTH=51 BGCOLOR="#d8d8d8">
					<P CLASS="western" ALIGN=CENTER><FONT SIZE=2 STYLE="font-size: 11pt">Cr&eacute;ditos</FONT></P>
				</TD>
			</TR>
<?
//			---------------disciplina 

			
			$cor_de_fundo="#FFFFFF";
			while ($registro_100=pg_fetch_row($select_disciplinas_distintas_diurno))
				{
				$query_quantidade_turmas=pg_query("select codigo from ".$tabela." where codigo='".$registro_100[0]."' and turno='Diurno'");
				$num_diurno=pg_num_rows($query_quantidade_turmas);

			if ($cor_de_fundo=="#FFFFFF") $cor_de_fundo="#D0D0D0"; else $cor_de_fundo="#FFFFFF";	
?>
			<TR VALIGN=TOP BGCOLOR="<? echo $cor_de_fundo;?>">
				<TD WIDTH=35>
					<P CLASS="western"><BR>
					<input type=text name='Diurno[<? echo $registro_100[0];?>][]' size="2" maxlength="1" value="<? echo $Diurno[$registro_100[0]][0];?>"></P> 
				</TD>
				<TD WIDTH=275>
					<P CLASS="western"><FONT COLOR="#000000"><FONT SIZE=2 STYLE="font-size: 11pt"> <? echo $registro_100[1];?> - diurno </FONT></FONT>
					</P>
				</TD>
				<TD WIDTH=63>
					<P CLASS="western" ALIGN=CENTER><FONT COLOR="#000000"><FONT SIZE=2 STYLE="font-size: 11pt"><? echo $num_diurno;?></FONT></FONT></P>
				</TD>
				<TD WIDTH=51>
					<P CLASS="western" ALIGN=CENTER><FONT COLOR="#000000"><FONT SIZE=2 STYLE="font-size: 11pt"> <? echo $registro_100[2];?> </FONT></FONT></P>
				</TD>
			</TR>

<?
				} // fecha dp-while

			while ($registro_101=pg_fetch_row($select_disciplinas_distintas_noturno))
				{
//				$num_noturno=count($tab_disciplinas[$registro_101[0]]['Noturno']);

				$query_quantidade_turmas=pg_query("select codigo from ".$tabela." where codigo='".$registro_101[0]."' and turno='Noturno'");
				$num_noturno=pg_num_rows($query_quantidade_turmas);

			if ($cor_de_fundo=="#FFFFFF") $cor_de_fundo="#D0D0D0"; else $cor_de_fundo="#FFFFFF";	
?>
			<TR VALIGN=TOP BGCOLOR="<? echo $cor_de_fundo;?>">
				<TD WIDTH=35>
					<P CLASS="western"><BR>
					<input type=text name='Noturno[<? echo $registro_101[0];?>][]' size="2" maxlength="1" value="<? echo $Noturno[$registro_101[0]][0];?>"></P> 
				</TD>
				<TD WIDTH=275>
					<P CLASS="western"><FONT COLOR="#000000"><FONT SIZE=2 STYLE="font-size: 11pt"> <? echo $registro_101[1];?> - noturno </FONT></FONT>
					</P>
				</TD>
				<TD WIDTH=63>
					<P CLASS="western" ALIGN=CENTER><FONT COLOR="#000000"><FONT SIZE=2 STYLE="font-size: 11pt"><? echo $num_noturno;?></FONT></FONT></P>
				</TD>
				<TD WIDTH=51>
					<P CLASS="western" ALIGN=CENTER><FONT COLOR="#000000"><FONT SIZE=2 STYLE="font-size: 11pt"> <? echo $registro_101[2];?> </FONT></FONT></P>
				</TD>
			</TR>

<?
				} // fecha dp-while
?>

			<TR>
				<TD COLSPAN=4 WIDTH=466 VALIGN=TOP BGCOLOR="#cccccc">
					<P CLASS="western" ALIGN=CENTER><FONT FACE="Arial, sans-serif"><FONT SIZE=2 STYLE="font-size: 11pt">Optativas
					do semestre</FONT></FONT></P>
				</TD>
			</TR>
			<?			

			while ($registro_102=pg_fetch_row($select_disciplinas_distintas_opt_diurno))
				{
		
				$query_quantidade_turmas=pg_query("select codigo from ".$tabela." where codigo='".$registro_102[0]."' and turno='Diurno'");
				$num_diurno=pg_num_rows($query_quantidade_turmas);


			if ($cor_de_fundo=="#FFFFFF") $cor_de_fundo="#D0D0D0"; else $cor_de_fundo="#FFFFFF";	
?>
			<TR VALIGN=TOP BGCOLOR="<? echo $cor_de_fundo;?>">
				<TD WIDTH=35>
					<P CLASS="western"><BR>
					<input type=text name='Diurno[<? echo $registro_102[0];?>][]' size="2" maxlength="1" value="<? echo $Diurno[$registro_102[0]][0];?>"></P> 
				</TD>
				<TD WIDTH=275>
					<P CLASS="western"><FONT COLOR="#000000"><FONT SIZE=2 STYLE="font-size: 11pt"> <? echo $registro_102[1];?> - diurno </FONT></FONT>
					</P>
				</TD>
				<TD WIDTH=63>
					<P CLASS="western" ALIGN=CENTER><FONT COLOR="#000000"><FONT SIZE=2 STYLE="font-size: 11pt"><? echo $num_diurno;?></FONT></FONT></P>
				</TD>
				<TD WIDTH=51>
					<P CLASS="western" ALIGN=CENTER><FONT COLOR="#000000"><FONT SIZE=2 STYLE="font-size: 11pt"> <? echo $registro_102[2];?> </FONT></FONT></P>
				</TD>
			</TR>

<?
				} // fecha dp-while

			while ($registro_103=pg_fetch_row($select_disciplinas_distintas_opt_noturno))
				{
//				$num_noturno=count($tab_disciplinas[$registro_103[0]]['Noturno']);

				$query_quantidade_turmas=pg_query("select codigo from ".$tabela." where codigo='".$registro_103[0]."' and turno='Noturno'");
				$num_noturno=pg_num_rows($query_quantidade_turmas);

			if ($cor_de_fundo=="#FFFFFF") $cor_de_fundo="#D0D0D0"; else $cor_de_fundo="#FFFFFF";	
?>
			<TR VALIGN=TOP BGCOLOR="<? echo $cor_de_fundo;?>">
				<TD WIDTH=35>
					<P CLASS="western"><BR>
					<input type=text name='Noturno[<? echo $registro_103[0];?>][]' size="2" maxlength="1" value="<? echo $Noturno[$registro_103[0]][0];?>"></P> 
				</TD>
				<TD WIDTH=275>
					<P CLASS="western"><FONT COLOR="#000000"><FONT SIZE=2 STYLE="font-size: 11pt"> <? echo $registro_103[1];?> - noturno </FONT></FONT>
					</P>
				</TD>
				<TD WIDTH=63>
					<P CLASS="western" ALIGN=CENTER><FONT COLOR="#000000"><FONT SIZE=2 STYLE="font-size: 11pt"><? echo $num_noturno;?></FONT></FONT></P>
				</TD>
				<TD WIDTH=51>
					<P CLASS="western" ALIGN=CENTER><FONT COLOR="#000000"><FONT SIZE=2 STYLE="font-size: 11pt"> <? echo $registro_103[2];?> </FONT></FONT></P>
				</TD>
			</TR>

<?
				} // fecha dp-while

?>

		</TABLE>
	</tr>
	<tr>
<td align=center>
<input type=hidden name='registra' value="Confirmar op&ccedil;&otilde;es">
<input type=submit name='confirma' value="Confirmar op&ccedil;&otilde;es">
<input type=reset name='limpa' value="Limpar formul&aacute;rio">
<input type=hidden name='semestre' value="<? echo $semestre;?>">
<input type=hidden name='ano' value="<? echo $ano;?>">
</td>
</tr>
</table>
</form>
</BODY>
</HTML>


<?

}


// Inicia gravacao das opcoes

if(isset($_POST['registra']) and isset($_POST['confirma']))

{

$ano=$_POST['ano'];
$semestre=$_POST['semestre'];

$tabela="oferta_semestre_".$semestre;

$select_disciplinas_distintas_diurno=pg_query("select codigo, nome, creditos from disciplinas_mat where codigo in (select distinct on (codigo) codigo from ".$tabela." where status='fixa' and turno='Diurno') order by nome");

$select_disciplinas_distintas_noturno=pg_query("select codigo, nome, creditos from disciplinas_mat where codigo in (select distinct on (codigo) codigo from ".$tabela." where status='fixa' and turno='Noturno') order by nome");


$select_disciplinas_distintas_opt_diurno=pg_query("select codigo, nome, creditos from disciplinas_mat where codigo in (select distinct on (codigo) codigo from ".$tabela." where status='optativa' and turno='Diurno') order by nome");

$select_disciplinas_distintas_opt_noturno=pg_query("select codigo, nome, creditos from disciplinas_mat where codigo in (select distinct on (codigo) codigo from ".$tabela." where status='optativa' and turno='Noturno') order by nome");


$professor=$_POST['professor'];

$creditos=$_POST['creditos'];
$disciplinas_iguais_6=$_POST['disciplinas_iguais_6'];

$disc_pos=$_POST['disc_pos'];

$orientando=$_POST['orientando'];
$credito_estagio_pesquisa=$_POST['credito_estagio_pesquisa'];

$Diurno=$_POST['Diurno'];
$Noturno=$_POST['Noturno'];


while ($registro=pg_fetch_row($select_disciplinas_distintas_diurno))
	{
	if (($Diurno[$registro[0]][0]!=0) and ($Diurno[$registro[0]][0]!=""))
		{
		$query_insere_diurno="insert into oferta_escolha_disciplina values('".$professor."','".$Diurno[$registro[0]][0]."','".$registro[0]."','0','0','".$semestre."','".$ano."','Diurno','".$registro[2]."','nao')";
//		echo $query_insere_diurno;
		$res=pg_query($query_insere_diurno) or die ("Problemas no acesso ao Banco de dados");
		}
	}

while ($registro=pg_fetch_row($select_disciplinas_distintas_noturno))
	{
	if (($Noturno[$registro[0]][0]!=0)  and ($Noturno[$registro[0]][0]!=""))
		{
		$query_insere_noturno="insert into oferta_escolha_disciplina values('".$professor."','".$Noturno[$registro[0]][0]."','".$registro[0]."','0','0','".$semestre."','".$ano."','Noturno','".$registro[2]."','nao')";
	//	echo $query_insere_noturno;
		$res=pg_query($query_insere_noturno) or die ("Problemas no acesso ao Banco de dados");
		}
	}


while ($registro=pg_fetch_row($select_disciplinas_distintas_opt_diurno))
	{
	if (($Diurno[$registro[0]][0]!=0) and ($Diurno[$registro[0]][0]!=""))
		{
		$query_insere_diurno="insert into oferta_escolha_disciplina values('".$professor."','".$Diurno[$registro[0]][0]."','".$registro[0]."','0','0','".$semestre."','".$ano."','Diurno','".$registro[2]."','nao')";
	//	echo $query_insere_diurno;
		$res=pg_query($query_insere_diurno) or die ("Problemas no acesso ao Banco de dados");
		}
	}

while ($registro=pg_fetch_row($select_disciplinas_distintas_opt_noturno))
	{
	if (($Noturno[$registro[0]][0]!=0) and ($Noturno[$registro[0]][0]!=""))
		{
		$query_insere_noturno="insert into oferta_escolha_disciplina values('".$professor."','".$Noturno[$registro[0]][0]."','".$registro[0]."','0','0','".$semestre."','".$ano."','Noturno','".$registro[2]."','nao')";
	//	echo $query_insere_noturno;
		$res=pg_query($query_insere_noturno) or die ("Problemas no acesso ao Banco de dados");
		}
	}


	$query_insere_escolha_creditos="insert into oferta_escolha_creditos values('".$professor."','".$creditos."','".$disciplinas_iguais_6."','".$semestre."','".$ano."')";
//echo $query_insere_escolha_creditos;
	$res=pg_query($query_insere_escolha_creditos) or die ("Problemas no acesso ao Banco de dados");


for ($i=0;$i<count($disc_pos);$i++)
	{
	$pos=explode("-",$disc_pos[$i]);
	if (($pos[1]!=0) and ($pos[0]!=0)) 
		{
		$query_insere_escolha_creditos_pos="insert into oferta_escolha_creditos_pos values('".$professor."','".$pos[1]."','".$pos[0]."','".$semestre."','".$ano."')";
//	echo $query_insere_escolha_creditos_pos;
		$res=pg_query($query_insere_escolha_creditos_pos) or die ("Problemas no acesso ao Banco de dados");
		}
	}


for ($i=0;$i<count($orientando);$i++)
	{
	if(($orientando[$i]!=0) and ($credito_estagio_pesquisa[$i]!=0))
		{
		$query_insere_escolha_creditos_est_pesq_pos="insert into oferta_escolha_creditos_est_pesq_pos values('".$professor."','".$credito_estagio_pesquisa[$i]."','".$orientando[$i]."','".$semestre."','".$ano."')";
//	echo $query_insere_escolha_creditos_est_pesq_pos;
		$res=pg_query($query_insere_escolha_creditos_est_pesq_pos) or die ("Problemas no acesso ao Banco de dados");
		}
	}

	echo "Op&ccedil;&otilde;es confirmadas e registradas.";
}
pg_close($idconn);
?>

