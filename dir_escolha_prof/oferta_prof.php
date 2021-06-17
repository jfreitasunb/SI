<?php
$lang="pt_BR";
//require("muda_senha/libs.php");
//require("muda_senha/forms.php");
require("muda_senha/pgsql.php");

//include("dir_escolha_prof/atuacao_noturno.php");

//require("muda_senha/header.php");

$submit           = trim(addslashes($_POST['submit']));
$usuario          = trim(addslashes($_POST['usuario']));
$senhaatual       = trim(addslashes($_POST['senhaatual']));

$msgL="Login invalido.";
$msgS="Senha atual invalida.";

if(strlen($submit)>0)
{
  sleep(1);

   if(strlen($usuario)==0)
	{
	echo $msgL;
   	}
   elseif(strlen($senhaatual)==0)
	{
        echo $msgS;
        }
   else {
   
     $res = pg_query("select login,passwd,tabela_user from unix where login='$usuario'");
   
//     $msg="Dados Invalidos!";
   
     if(pg_num_rows($res)==1 )
	{
           $senhaBD = pg_result($res,0,1);
	   $tipo_usuario=pg_result($res,0,2);
 
		if((crypt($senhaatual,$senhaBD) == $senhaBD) and ($tipo_usuario=="fonctionnaire")) //:so permite acesso a professores e administrativos
		{
              // Hora de solicitar documentos
//              SOLICITAR DISCILPINAS
//$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$
?>
	<html>
	  <header>
	    <link type="text/css" rel="stylesheet" href="global/grafic.css">
	    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	 </header>
<?php
	//	if(!isset($_POST['registra']))
	//	{
		$select_profs=pg_query("select coduser,name,firstname from users where coduser in (select coduser from unix where login='".pg_result($res,0,0)."')");
		$registro_0=pg_fetch_row($select_profs);
		$coduser=$registro_0[0];
		$mes=date(n);
		$semestre=$mes/12;
//		if ($semestre<=0.5) $semestre=2; else $semestre=1;

//		if ($semestre==1) $ano=date(Y)+1; else $ano=date(Y);
// recupera semestre e ano da lista: 
		$query_semestre=pg_query("select semestre,ano from oferta_acusa_lista where encaminhada='nova'") or die("problema de conexao com o banco");
		$dados_semestre=pg_fetch_row($query_semestre);
		$semestre=$dados_semestre[0];
		$ano=$dados_semestre[1];;


		//oferta_escolha_disciplina: coduser | prioridade | disciplina | dias | horarios | semestre | ano  |  turno  | creditos | atendido
		$query_escolha_disciplinas=pg_query("select * from oferta_escolha_disciplina where coduser='".$coduser."' and semestre='".$semestre."' and ano='".$ano."' order by prioridade");
		$registro_disciplinas=pg_fetch_all($query_escolha_disciplinas);
		$num_disc=pg_num_rows($query_escolha_disciplinas);
 
		//oferta_escolha_creditos:  coduser | creditos | disciplinas_iguais_6 | semestre | ano 
		$query_escolha_creditos=pg_query("select * from oferta_escolha_creditos where coduser='".$coduser."' and semestre='".$semestre."' and ano='".$ano."'");
		$registro_creditos=pg_fetch_row($query_escolha_creditos);

		//oferta_escolha_creditos_pos: coduser | creditos | disciplina | semestre | ano
		$query_escolha_creditos_pos=pg_query("select * from oferta_escolha_creditos_pos where coduser='".$coduser."' and semestre='".$semestre."' and ano='".$ano."'");
		$registro_creditos_pos=pg_fetch_all($query_escolha_creditos_pos);
		$num_creditos_pos=pg_num_rows($query_escolha_creditos_pos);


		//oferta_escolha_creditos_est_pesq_pos: coduser | creditos | orientando | semestre | ano
		$query_escolha_creditos_est_pesq_pos=pg_query("select * from oferta_escolha_creditos_est_pesq_pos where coduser='".$coduser."' and semestre='".$semestre."' and ano='".$ano."'");
		$registro_creditos_est_pesq_pos=pg_fetch_all($query_escolha_creditos_est_pesq_pos);
		$num_creditos_est_pesq_pos=pg_num_rows($query_escolha_creditos_est_pesq_pos);

		
		// pega dados de oferta_magistral_opcoes_profs
		$query_magistral_opcoes_profs=pg_query("select * from oferta_magistral_opcoes_profs where coduser='".$coduser."' and semestre='".$semestre."' and ano='".$ano."'");
		$ck_c1_teoria="";
		$ck_c1_exos="";
		$ck_m1_teoria="";
		$ck_m1_exos="";
		$ck_ims_teoria="";
		$ck_ims_exos="";
		while($registro_magistral=pg_fetch_row($query_magistral_opcoes_profs))
			{
			if($registro_magistral[1]==113034)
				{ 
				if($registro_magistral[1]=="teoria") $ck_c1_teoria="checked";
				if($registro_magistral[1]=="exercicios") $ck_c1_exos="checked";
				}
			if($registro_magistral[1]==113018)
				{
				if($registro_magistral[1]=="teoria") $ck_m1_teoria="checked";
				if($registro_magistral[1]=="exercicios") $ck_m1_exos="checked";
				}
			if($registro_magistral[1]==113701)
				{
				if($registro_magistral[1]=="teoria") $ck_ims_teoria="checked";
				if($registro_magistral[1]=="exercicios") $ck_ims_exos="checked";
				}
			}

		// TESTE:
		//$semestre=1;
		//$ano=2012;
		//$tabela="oferta_semestre_".$semestre;
		//$tabela="oferta_lista_de_ofertas_".$semestre."_".$ano;
		$tabela="oferta_lista_de_ofertas_nova";


?>
		  <body>
		      <table class=big>
		   <form method="POST" name="formu" action="dir_escolha_prof/oferta_escolha_professor.php">
		      <tr>
		        <td class=header align=center colspan=2>
	        <h1>Ficha de Prefer&ecirc;ncias &ndash; <?php echo $semestre;?>&ordm;/ <?php echo $ano;?></h1>
        	</td>
	      </tr>
	      <tr>
              <td><b>Professor:</b> <?php echo $registro_0[1]." ".$registro_0[2];?></td>
        	</tr>
        	<tr>
        	<td>Quantos cr&eacute;ditos pretende lecionar na gradua&ccedil;&atilde;o? 
                <select name='creditos'>
                        <option value='0' <?php if ($registro_creditos[1]==0) echo "selected";?>> 0 cr&eacute;ditos</option> 
                        <option value='4' <?php if ($registro_creditos[1]==4) echo "selected";?>> 4 cr&eacute;ditos</option> 
                        <option value='6' <?php if ($registro_creditos[1]==6) echo "selected";?>> 6 cr&eacute;ditos</option>
                        <option value='8' <?php if ($registro_creditos[1]==8) echo "selected";?>> 8 cr&eacute;ditos</option>
                        <option value='10' <?php if ($registro_creditos[1]==10) echo "selected";?>> 10 cr&eacute;ditos</option>
                        <option value='12' <?php if ($registro_creditos[1]==12) echo "selected";?>> 12 cr&eacute;ditos</option>
                        <option value='14' <?php if ($registro_creditos[1]==14) echo "selected";?>> 14 cr&eacute;ditos</option>
                        <option value='16' <?php if ($registro_creditos[1]==16) echo "selected";?>> 16 cr&eacute;ditos</option>
                        </select>
                </td>
	        </tr>
        	<tr>
                <td>Prefer&ecirc;ncia por 2 (duas) disciplinas de 6 cr&eacute;ditos iguais? 
                <select name='disciplinas_iguais_6'>  
                        <option value="nao" <?php if ($registro_creditos[2]=="nao") echo "selected";?>> N&atilde;o</option>
                        <option value="sim" <?php if ($registro_creditos[2]=="sim") echo "selected";?>> Sim</option>
                </select>
	        </td>
	        </tr>
        	<tr>
	        <td>Quais disciplinas pretende lecionar na p&oacute;s-gradua&ccedil;&atilde;o (exceto Est&aacute;gios em Pesquisa)?<BR>
        <?php
        	for ($cont_pos=0;$cont_pos<2;$cont_pos++)
                	{
        ?>
	                <select name='disc_pos[]'>
                        <option value="0-0" <?php if ($num_creditos_pos==0) echo "selected";?>>Nenhuma</option>
                <?php
			$cor_de_fundo="#FFFFFF";
        	        $select_disciplinas_pg[$cont_pos]=pg_query("select codigo, nome, creditos from disciplinas_mat where status='pgrad' order by nome"); 
                	while ($registro[$cont_pos]=pg_fetch_row($select_disciplinas_pg[$cont_pos]))
                        	{
                        	if ($cor_de_fundo=="#FFFFFF") $cor_de_fundo="#D3D3D3"; else $cor_de_fundo="#FFFFFF";
			?>
	                        <option value="<?php echo $registro[$cont_pos][0]."-".$registro[$cont_pos][2];?>" <?php if ($registro[$cont_pos][0]==$registro_creditos_pos[$cont_pos]['disciplina']) echo "selected";?> style="COLOR: #000000; BACKGROUND-COLOR: <?php echo $cor_de_fundo;?>"> <?php echo $registro[$cont_pos][0]."-".$registro[$cont_pos][1]." (".$registro[$cont_pos][2].")";?></option>
                        <?php
        	                }
                	?>
                        	</select>  
	                        <BR>
                <?php
        	        }
                ?>
                </td>
		</tr>
	        <tr>
                <td>Cr&eacute;ditos em Est&aacute;gio de Pesquisa:<br>
                <?php
		//$registro_creditos_est_pesq_pos=pg_fetch_all($query_escolha_creditos_est_pesq_pos); coduser | creditos | orientando | semestre | ano
		//$num_creditos_est_pesq_pos=pg_num_rows($query_escolha_creditos_est_pesq_pos);

                for ($cont_pesq=0;$cont_pesq<5;$cont_pesq++)
                        {
                ?>
                	<select name='credito_estagio_pesquisa[<?php echo $cont_pesq;?>]'>
                        <option value='0' <?php if (($num_creditos_est_pesq_pos==0) or ($registro_creditos_est_pesq_pos[$cont_pesq]['creditos']==0)) echo "selected";?>> 0 </option>
                        <option value='1' <?php if ($registro_creditos_est_pesq_pos[$cont_pesq]['creditos']==1) echo "selected";?>> 1 </option>
                        <option value='2' <?php if ($registro_creditos_est_pesq_pos[$cont_pesq]['creditos']==2) echo "selected";?>> 2 </option>
	                </select> cr&eacute;ditos -  Orientando: 
        	        <select name='orientando[<?php echo $cont_pesq;?>]'>
                        <option value="0" selected>Nenhum</option>
                        <?php
                        $select_orientando[$cont_pesq]=pg_query("select coduser,name,firstname from users where coduser in (select coduser from student where status='ativo') order by name");
                	while ($registro1[$cont_pesq]=pg_fetch_row($select_orientando[$cont_pesq]))
                        	{
                        ?>
	                        <option value="<?php echo $registro1[$cont_pesq][0];?>" <?php if ($registro_creditos_est_pesq_pos[$cont_pesq]['orientando']==$registro1[$cont_pesq][0]) echo "selected";?>> <?php echo $registro1[$cont_pesq][1]." ".$registro1[$cont_pesq][2];?></option>
                        <?php
        	                }
                        ?>
                        </select>  
                        <BR>    
                        <?php}?>
                </td>
                </tr>
<?php
//$registro_disciplinas: coduser | prioridade | disciplina | dias | horarios | semestre | ano  |  turno  | creditos | atendido
?>
                <tr><td> Escolha a disciplina/turno:<br>
                        <?php for ($i=1;$i<7;$i++)
                                {
                                echo "<b>Prioridade ".$i.":</b> <select name='disciplina[".$i."]'>";
$select_disciplinas[$i]=pg_query("select distinct on (m.nome,lo.turno) lo.codigo,m.nome,m.creditos,upper(lo.turno),lo.status from ".$tabela." lo, disciplinas_mat m where m.codigo=lo.codigo order by m.nome,lo.turno");                                                $cor_de_fundo="#FFFFFF";
                                if (($num_disc==0) or ($registro_disciplinas[$i-1]['disciplina']==0)) echo "<option value=\"_0\" selected>Escolher uma disciplina</option>";
                                while($registro2[$i]=pg_fetch_row($select_disciplinas[$i]))
					{
                                        if ($cor_de_fundo=="#FFFFFF") $cor_de_fundo="#BEBEBE"; else $cor_de_fundo="#FFFFFF";
                                        if (($registro2[$i][0]==$registro_disciplinas[$i-1]['disciplina']) and ($registro2[$i][3]==strtoupper($registro_disciplinas[$i-1]['turno']))) $selected="selected"; else $selected="";
                                        echo "<option value=\"".$registro2[$i][0]."_".$registro2[$i][3]."\" style=\"COLOR: #000000; BACKGROUND-COLOR: ".$cor_de_fundo."\" ".$selected.">".$registro2[$i][3].":  ".$registro2[$i][0]."-".$registro2[$i][1]." (".$registro2[$i][2].")</option>";
					}
                                echo "</select><br>";
                                }
                        ?>
                </td></tr>
	<tr><td>Atua&ccedil;&atilde;o em disciplinas no esquema magistral:</td></tr>
	<tr><td><b>C&aacute;lculo 1:</b>  Teoria(<input type=checkbox name='magistral_teoria[113034]' <?php echo $ck_c1_teoria;?>>); Exerc&iacute;cios(<input type=checkbox name='magistral_exercicios[113034]'  <?php echo $ck_c1_exos;?>>)</td></tr>
	<tr><td><b>Matem&aacute;tica 1:</b>  Teoria(<input type=checkbox name='magistral_teoria[113018]'  <?php echo $ck_m1_teoria;?>>); Exerc&iacute;cios(<input type=checkbox name='magistral_exercicios[113018]'  <?php echo $ck_m1_exos;?>>)</td></tr>
	<tr><td><br><br></td></tr>
	<tr><td>
	<a href="dir_escolha_prof/atuacao_noturno.php?semestre=<?php echo $semestre;?>&ano=<?php echo $ano;?>">Veja rela&ccedil;&atilde;o de atua&ccedil;&otilde;es no Noturno</a>
	</td></tr>
        <tr>
        <td align=center>
        <input type=submit name='registra' value="Confirmar op&ccedil;&otilde;es">
        <!input type=reset name='limpa' value="Limpar formul&aacute;rio">
        <input type=hidden name='semestre' value="<?php echo $semestre;?>">
        <input type=hidden name='ano' value="<?php echo $ano;?>">
        <input type=hidden name='professor' value="<?php echo $coduser;?>">
        </td>
        </tr>
        </table>
        </form>
        </BODY>
        </HTML>

<?php
// FIM solicitar arquivo
		pg_close($con);
 	         }
		else 
		{
	        echo $msgS;       
	        } 
     	}
	else echo $msgL; 
   }
}

if (!isset($_POST['submit']))
{
if (((date(j)>5) and (date(n)==5) and (date(Y)==2013)) or ((date(j)<7) and (date(n)==5) and (date(Y)==2013)))
{
?>
<HTML>
<HEAD>
</HEAD>
<BODY onload="document.form1.usuario.focus();">

<FORM name="form1" method="POST" action="<?php=$PHP_SELF;?>">

<h2> Login e Senha do usuarios </h2>

<h3>
<font color="red"><?php=$msg;?></font>
</h3>

<table border="0">
<tr>
  <td> Usuario: </td>
  <td> <INPUT type="TEXT" name="usuario" value="<?php=$usuario;?>"> </td>
</tr>
<tr>
  <td> Senha: </td>
  <td> <INPUT type="password" name="senhaatual" value="<?php=$senhaatual;?>"> </td>
</tr>
<tr>
  <td> </td>
  <td> <input type="submit" value="Confirmar" name="submit"> </td>
</tr>

</table>

</FORM>

</BODY>
</HTML>
<?php
}
else echo "op&ccedil;&otilde;es n&atilde;o dispon&iacute;veis";
}
?>

