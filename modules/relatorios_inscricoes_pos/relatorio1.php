<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
	<head>
	<META http-equiv="Content-Type" content="text/html; charset=utf-8">
	</head>
	

<body  style="background-image: url('../imagens/bg_pixel.png'); padding: 20px">
	<h2 align="center">
		Relação de Candidatos para o programa de Pós-Graduação <br>
		MAT-UnB <?php echo date("Y")+1;?>
	</h2>

<hr>
<?php include_once("../pgsql/pgsql.php"); 

$query_candidatos = pg_query("select * from inscricao_pos_login where status='candidato' order by coduser");
$num_candidatos = pg_num_rows($query_candidatos);
echo "<br> Temos ".$num_candidatos." candidatos para o programa de Pós-Graduação.<br>";

$query_id_mestrado = pg_query("
				 select A.coduser, B.cursopos, C.name||''||C.firstname as nome 
				 from inscricao_pos_login A, 
					  inscricao_pos_dados_profissionais_candidato B,
					  inscricao_pos_dados_candidato C 
				 where A.status='candidato' and 
					   A.coduser=B.id_aluno and 
					   C.id_aluno=A.coduser and 
					   B.cursopos like('%estrad%')");

$query_id_mestrado2 = pg_query("
				 select A.coduser, B.cursopos 
				 from inscricao_pos_login A, 
					  inscricao_pos_dados_profissionais_candidato B
				 where A.status='candidato' and 
					   A.coduser=B.id_aluno and 
					   B.cursopos like('%estrad%') order by A.coduser");

?>

<h2 align="center">Relatório do Mestrado </h2>
<table border=1 width=100%  ALIGN=center >
	

<tr><td align=center><span style="font-size:25">Cadastro Completo</span> </td>   
	<td align=center><span style="font-size:25">Cadastrados com alguma tabela possivelmente vazia</span></td> </tr>

<tr> 
<td valign=top width="65%">
			<ol>
			<?php	
			while($lista = pg_fetch_array($query_id_mestrado)){
				echo "<li>".$lista['coduser']." Nome: ".$lista['nome']."</li>";
			}
			?>
			</ol>
</td>



<td valign=top >
			<ol>
			<?php	
			while($lista2 = pg_fetch_array($query_id_mestrado2)){
				echo "<li>".$lista2['coduser']." Curso: ".$lista2['cursopos']."</li>";
			}
			?>
			</ol>
</td>
</tr>

</table>



















<?php
$query_id_doutorado = pg_query("
				select A.coduser, B.cursopos, C.name||''||C.firstname as nome 
				from inscricao_pos_login A, 
					  inscricao_pos_dados_profissionais_candidato B,
					  inscricao_pos_dados_candidato C 
				where A.status='candidato' and 
					   A.coduser=B.id_aluno and 
					   C.id_aluno=A.coduser and 
					   B.cursopos like('%outorad%')");

$query_id_doutorado2 = pg_query("
				select A.coduser, B.cursopos 
				from inscricao_pos_login A, 
					  inscricao_pos_dados_profissionais_candidato B
				where A.status='candidato' and 
					   A.coduser=B.id_aluno and 
					   B.cursopos like('%outorad%') 
				order by A.coduser");

?>
<br><br><br>
<h2 align="center">Relatório do Doutorado </h2>
<table border=1 width=100%  ALIGN=center >
	

<tr><td align=center><span style="font-size:25">Cadastro Completo</span> </td>   
	<td align=center><span style="font-size:25">Cadastrados com alguma tabela possivelmente vazia</span></td> </tr>

<tr> 
<td valign=top width="65%">
			<ol>
			<?php	
			while($lista3 = pg_fetch_array($query_id_doutorado)){
				echo "<li>".$lista3['coduser']." Nome: ".$lista3['nome']."</li>";
			}
			?>
			</ol>
</td>



<td valign=top >
			<ol>
			<?php	
			while($lista4 = pg_fetch_array($query_id_doutorado2)){
				echo "<li>".$lista4['coduser']." Curso: ".$lista4['cursopos']."</li>";
			}
			?>
			</ol>
</td>
</tr>

</table>









<?php
$query_id_indefinidos = pg_query("
				select A.coduser, B.cursopos, C.name||''||C.firstname as nome 
				from inscricao_pos_login A, 
					  inscricao_pos_dados_profissionais_candidato B,
					  inscricao_pos_dados_candidato C 
				where A.status='candidato' and 
					   A.coduser=B.id_aluno and 
					   C.id_aluno=A.coduser and 
					   B.cursopos like('0')");

$query_id_indefinidos2 = pg_query("
				select A.coduser, B.cursopos 
				from inscricao_pos_login A, 
					  inscricao_pos_dados_profissionais_candidato B
				where A.status='candidato' and 
					   A.coduser=B.id_aluno and 
					   B.cursopos like('0') 
				order by A.coduser");

?>
<br><br><br>
<h2 align="center">Relatório dos Indefinidos </h2>
<table border=1 width=100%  ALIGN=center >
	

<tr><td align=center><span style="font-size:25">Cadastro Completo</span> </td>   
	<td align=center><span style="font-size:25">Cadastrados com alguma tabela possivelmente vazia</span></td> </tr>

<tr> 
<td valign=top width="70%">
			<ol>
			<?php	
			while($lista5 = pg_fetch_array($query_id_indefinidos)){
				echo "<li>".$lista5['coduser']." Nome: ".$lista5['nome']."</li>";
			}
			?>
			</ol>
</td>



<td valign=top >
			<ol>
			<?php	
			while($lista6 = pg_fetch_array($query_id_indefinidos2)){
				echo "<li>".$lista6['coduser']." Curso: ".$lista6['cursopos']."</li>";
			}
			?>
			</ol>
</td>
</tr>

</table>

















<?php

$query_id_tudo = pg_query("
				select A.coduser, B.cursopos 
				from inscricao_pos_login A, 
					  inscricao_pos_dados_profissionais_candidato B
				where A.status='candidato' and 
					   A.coduser=B.id_aluno 
				order by A.coduser");


/*$query_id_tudo = pg_query("
				select A.coduser, B.cursopos 
				from inscricao_pos_login A, 
					  inscricao_pos_dados_profissionais_candidato B
				where A.status='candidato' and 
					   A.coduser=B.id_aluno and 
					   B.cursopos like('%') 
				order by A.coduser");
*/
?>
<br><br><br>
<h2 align="center">Relatório Completo </h2>
<table border=1 width=100%  ALIGN=center >
	

<tr><td align=center><span style="font-size:25">Cadastro Completo</span> </td>   
	<td align=center><span style="font-size:25">Cadastrados com alguma tabela possivelmente vazia</span></td> </tr>

<tr> 
<td valign=top width="40%">
			<ol>
			<?php	
			while($lista7 = pg_fetch_array($query_id_tudo)){
				echo "<li>".$lista7['coduser']." curso: ".$lista7['cursopos']."</li>";
			}
			?>
			</ol>
</td>



<td valign=top >
			<ol>
			<?php	
			while($lista8 = pg_fetch_array($query_candidatos)){
				echo "<li>".$lista8['coduser']." login: ".$lista8['login']."</li>";
			}
			?>
			</ol>
</td>
</tr>

</table>








</body>
</html>
