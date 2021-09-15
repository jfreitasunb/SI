<?php

include("head_relatorios_pos.php");

//<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

//<?php include_once("../pgsql/pgsql.php"); 


?>

<html>
	<head>
	<META http-equiv="Content-Type" content="text/html; charset=utf-8">
<link type="text/css" rel="stylesheet" href="../../global/grafic.css">
	</head>
	

<body>
	<h2 align="center">
		Lista dos Candidatos para o programa de Pós-Graduação
	</h2>
<br>
<br>
	<hr><hr><hr><hr><hr><hr><hr><hr>
	
		<form name="homologacao" method="POST" action="listahomologados.php">
		

<?php				
		$query_coduser = pg_query("select coduser from inscricao_pos_login where status='candidato'"); 
			
		$listacoduser = pg_fetch_all($query_coduser);
		
		
		for ($i=0;$i<count($listacoduser);$i++)
		{
		$coduserarray=$listacoduser[$i];	
		$coduser = $coduserarray['coduser'];
		
		
		$query_cadas1 = pg_query("select * from inscricao_pos_dados_candidato where id_aluno='".$coduser."'");
		$cadas1 = pg_fetch_assoc($query_cadas1);
		
		$query_cadas2 = pg_query("select * from inscricao_pos_dados_profissionais_candidato where id_aluno='".$coduser."'");
		$cadas2 = pg_fetch_assoc($query_cadas2);
		
		$query_cadas3 = pg_query("select * from inscricao_pos_contatos_recomendante where id_aluno='".$coduser."'");
		$cadas3 = pg_fetch_assoc($query_cadas3);
		
		$query_carta_motivacao = pg_query("select * from inscricao_pos_carta_motivacao where id_aluno='".$coduser."'");
		$cadas31 = pg_fetch_assoc($query_carta_motivacao);
		
			
			
		$query_arquivos=pg_query("select * from inscricao_pos_anexos where coduser='".$coduser."'");
		
		?>	
		<h2 align="center" style="color:red">Candidato Código: <?php echo $coduser;?> &nbsp </h2>
		<h3> Dados Pessoais.</h3>
		<p>
         
			
            Nome: 
            <?php echo $cadas1['name'];?>
            &nbsp; &nbsp; &nbsp;
            
            Sobrenome : 
            <?php echo $cadas1['firstname'];?>
        <br>  
            Data de Nascimento: 
            <?php echo $cadas1['dianascimento']."/".$cadas1['mesnascimento']."/".$cadas1['anonascimento'];?>
        
        &nbsp; &nbsp; &nbsp;
             Sexo: <?php echo $cadas1['sexo'];?>
		 <br>
        Naturalidade: <?php echo $cadas1['naturalidade'];?>  
        &nbsp &nbsp &nbsp
        Estado: <?php echo $cadas1['ufnaturalidade'];?>
		<br>
        Nacionalidade: <?php echo $cadas1['nacionalidade'];?>
	    &nbsp &nbsp &nbsp
	    
	    Pa&iacute;s: <?php echo $cadas1['paisnacionalidade'];?>
        <br>
      
        Nome do pai : &nbsp <?php echo $cadas1['nome_pai'];?>
        <br>
        
		Nome da mãe: &nbsp <?php echo $cadas1['nome_mae'];?>          
        <br>
               
        
               
        <p>  
			<h3> Endereço Pessoal </h3>
        <p>
                          
       	Endereço residencial: <?php $cadas1['adresse'];?>            
        <br>
        CEP: <?php echo $cadas1['cpendereco'];?> 
        &nbsp; &nbsp; &nbsp;
        Cidade: <?php echo $cadas1['cityendereco'];?> 
        &nbsp; &nbsp; &nbsp;
        <br>
        Estado: <?php echo $cadas1['ufendereco'];?> 
		&nbsp; &nbsp; &nbsp;
		País: <?php echo $cadas1['country'];?>
		<br>		
		Telefone comercial :
		<?php echo "+".$cadas1['ddi_phonework']."(".$cadas1['ddd_phonework'].")".$cadas1['phonework'];?>
        <br>
        Telefone residencial: 
        <?php echo "+".$cadas1['ddi_phonehome']."(".$cadas1['ddd_phonehome'].")".$cadas1['phonehome'];?>
        <br>       
        Telefone celular : 
        <?php echo "+".$cadas1['ddi_cel']."(".$cadas1['ddd_cel'].")".$cadas1['telcelular'];?>
        </p>
         
		E-mail principal: <?php echo $cadas1['mail1'];?>
        <br>
        E-mail alternativo: <?php echo $cadas1['mail2'];?> 
    
        <p>  
			<h3> Documentos Pessoais.</h3>
        </p>
        
        Número de CPF : <?php echo $cadas1['cpf'];?>
        <br>
        Número de Identidade (ou Passaporte para estrangeiros):
        <?php echo $cadas1['identity'];?>
        <br>
        &Oacute;rg&atilde;o emissor: 
        <?php echo $cadas1['id_emissor'];?>
        &nbsp &nbsp
            
        Estado: <?php echo $cadas1['estadoemissaoid']; ?>
		<br>
					
		Data de emiss&atilde;o:
        <?php echo $cadas1['diaemissaoid']."/".$cadas1['mesemissaoid']."/".$cadas1['anoemissaoid']; ?>
        <br> 

	<br>    
				
	<b> Grau acadêmico mais alto obtido:</b>
	
		Curso (Matemática, Física, etc.): <?php echo $cadas2['instrucaocurso'];?>
        <br>
        Grau : <?php echo $cadas2['instrucaograu'];?>
		<br>
		
		Instituição : <?php echo $cadas2['instrucaoinstituicao'];?>
		<br>
			
		Ano de Conclusão ou Previsão:
		<?php echo $cadas2['instrucaoanoconclusao'];?>
		  
        <p>  
			<b> Experiência Profissional mais recente (se for o caso):</b>
        </p>  
         
        Tem experiência: <?php echo $cadas2['experienciatipo1']." ".$cadas2['experienciatipo2'];?>  
        <br>
        Instituição: <?php echo $cadas2['experienciainstituicao']; ?>
        <br>
        Período: &nbsp;
        início: <?php echo $cadas2['experienciaperiodoiniciosemestre']."-".$cadas2['experienciaperiodoinicioano'];?>
        &nbsp &nbsp 
        fim:
        <?php echo $cadas2['experienciaperiodofimsemestre']."-".$cadas2['experienciaperiodofimano']?>        
        
        <p>  
			<b> Programa Pretendido:</b> <?php echo $cadas2['cursopos'];?>
        </p>
		Área : <?php echo $cadas2['areadoutorado']; ?>
		<br>
		Interesse em bolsa: <?php echo $cadas2['interessebolsa']; ?>
					
		
		
		
		<h3 >
		Dados dos Recomendantes
		</h3>
		1- Nome: <?php echo $cadas3['nomeprofrecomendante1']; ?>
            &nbsp 
 		e-mail: <?php echo $cadas3['emailprofrecomendante1']; ?> 
        <br>
           2- Nome: <?php echo $cadas3['nomeprofrecomendante2']; ?>
            &nbsp 
 		e-mail: <?php echo $cadas3['emailprofrecomendante2']; ?> 
        <br>
           3- Nome: <?php echo $cadas3['nomeprofrecomendante3']; ?>
            &nbsp 
 		e-mail: <?php echo $cadas3['emailprofrecomendante3']; ?> 
        <br>
        <br>   
 		Motivação e expectativa do candidato em relação ao programa pretendido:
		<br>
		<?php echo $cadas31['motivacaoprogramapretendido']; ?> 
		
		

		<?php
			while($registro=pg_fetch_row($query_arquivos)){
				echo "<br><a href=\"http://www.mat.unb.br/inscricoespos/upload/".$registro[2]."\"> 
						arquivo do tipo ".$registro[1]." enviado em ".$registro[3]."</a>";
			}
		?>
		
		





<!-- Primeira Carta de Recomendação deste aluno -->











	<hr>
	<h3>
		Carta de Recomendação de: <?php echo $cadas3['nomeprofrecomendante1'];?>
	</h3>
	<?php
	
	$query_pega_idprof1 = pg_query("select coduser from inscricao_pos_login where login='".$cadas3['emailprofrecomendante1']."'");
	$coduser1=pg_fetch_row($query_pega_idprof1);
	$id_prof1=$coduser1[0];
	
	
	
	
	echo "Códidgio de usuário do professor é :".$id_prof1."<br><br><br>";
	
	
	
	
	if($id_prof1!="")
	{	
	$query_formu1 = pg_query("select * from inscricao_pos_recomendacoes where id_aluno='".$cadas1['id_aluno']."' and id_prof='".$id_prof1."'");
	$formu1 = pg_fetch_assoc($query_formu1);
	
	$query_formu3 = pg_query("select * from inscricao_pos_dados_pessoais_recomendante where id_prof='".$id_prof1."'");
	$formu3 = pg_fetch_assoc($query_formu3);
	
	?>
	
	Conhece-o candidato há quanto tempo (For how long have you known the applicant)? &nbsp
	<?php echo $formu1['tempoconhececandidato'];?>
	<br>
	Conhece-o sob as seguintes circunstâncias: &nbsp
	<?php echo $formu1['circunstancia1'];?> &nbsp &nbsp
	<?php echo $formu1['circunstancia2'];?> &nbsp &nbsp
	<?php echo $formu1['circunstancia3'];?> &nbsp &nbsp
	<?php echo $formu1['circunstancia4'];?> &nbsp &nbsp
	Outra. Qual (Other.Which)? &nbsp
	<?php echo $formu1['circunstanciaoutra'];?>
	<br>
	<p>
	<b>Avaliações: </b>
		1) Excelente (Excellent), &nbsp &nbsp 
		2) Bom (Good),  &nbsp &nbsp 
		3) Regular (Regular),  &nbsp &nbsp 
		4) Insuficiente (Insufficient),  &nbsp &nbsp 
		?) Não sabe (Don’t know)
	<br>
    Desempenho acadêmico (Academic achievements):<?php echo $formu1['desempenhoacademico'];?><br>
    Capacidade de aprender novos conceitos (Ability to learn new concepts): <?php echo $formu1['capacidadeaprender'];?><br>
	Capacidade de trabalhar sozinho (Ability to work independently):<?php echo $formu1['capacidadetrabalhar'];?><br>
	Criatividade (Creativity):<?php echo $formu1['criatividade'];?><br>
	Curiosidade, interesse (Curiosity, interest):<?php echo $formu1['curiosidade'];?><br>
	Esforço, persistência (Effort, persistence):<?php echo $formu1['esforco'];?><br>
	Expressão escrita (Written expression):<?php echo $formu1['expressaoescrita'];?><br>
	Expressão oral (Oral expression):<?php echo $formu1['expressaooral'];?><br>
	Relacionamento com colegas (Relationship with colleagues): <?php echo $formu1['relacionamento'];?>
	
	<p> 
	<b> Opinião sobre seus antecedentes acadêmicos, profissionais e/ou técnicos do candidato:</b>
	<br> 
	<?php echo $formu1['antecedentesacademicos'];?> 
	</p>
	<p>
	<b>Opinião sobre seu possível aproveitamento, se aceito no Programa:</b>
	<br> 
	<?php echo $formu1['possivelaproveitamento'];?>
	</p>
	<p>
	<b>Outras informações relevantes:</b>
	<br>
	<?php echo $formu1['informacoesrelevantes'];?>
	</p>
	
	<p>
	<b>Dentre os estudantes que já conheceu, sob os itens abaixo, você diria que o candidato está entre os:</b>
	<br>
	1) 5% melhores (Top 5%), &nbsp &nbsp 
	2) 10% melhores (Top 10%),  &nbsp &nbsp 
	3) 25% melhores(Top 25%),  &nbsp &nbsp 
	4) 50% melhores (Top 50%),  &nbsp &nbsp 
	?) Não sabe (Don’t know)
	<br> 
	Como aluno, em aulas (As student, in classes):<?php echo $formu1['comoaluno'];?>
	<br>
	Como orientando (During advisory): <?php echo $formu1['comoorientando'];?>
	
	</p>
	
	
	<b>
		Dados pessoais do professor: <?php echo $cadas3['nomeprofrecomendante1'];?>
	</b>
	<br>
	Instituição (Institution): &nbsp <?php echo $formu3['instituicaorecomendante'];?>
	<br>
	Grau acadêmico mais alto obtido (Highest academic degree obtained):&nbsp <?php echo $formu3['titulacaorecomendante'];?>
	&nbsp &nbsp em &nbsp <?php echo $formu3['arearecomendante'];?>.
	<br>
	Ano de obtenção deste grau (Year when it was obtained): &nbsp 
	<?php echo $formu3['anoobtencaorecomendante']; ?>
	<br>
	Instituição de obtenção deste grau (Institution where it was obtained):
	<?php echo $formu3['instobtencaorecomendante'];?>
	<br>
	Endereço institucional do recomendante (Recommender’s institutional address):
	<?php echo $formu3['enderecorecomendante'];?>
<?php	}
?>	





<!-- Segunda carta de recomendação --> 








	

	<hr>
	<h3>
		Carta de Recomendação de: <?php echo $cadas3['nomeprofrecomendante2'];?>
	</h3>
	<?php
	
	$query_pega_idprof2 = pg_query("select coduser from inscricao_pos_login where login='".$cadas3['emailprofrecomendante2']."'  ");
	$coduser2=pg_fetch_row($query_pega_idprof2);
	$id_prof2=$coduser2[0];
	
	
	
	
	echo "Código de usuário do professor é :".$id_prof2."<br><br><br>";
	
	
	
	
	if($id_prof2!="")
	{	
	
	$query_formu1 = pg_query("select * from inscricao_pos_recomendacoes where id_aluno='".$cadas1['id_aluno']."' and id_prof='".$id_prof2."'");
	$formu1 = pg_fetch_assoc($query_formu1);
	
	$query_formu3 = pg_query("select * from inscricao_pos_dados_pessoais_recomendante where id_prof='".$id_prof2."'");
	$formu3 = pg_fetch_assoc($query_formu3);
	
	?>
	
	Conhece-o candidato há quanto tempo (For how long have you known the applicant)? &nbsp
	<?php echo $formu1['tempoconhececandidato'];?>
	<br>
	Conhece-o sob as seguintes circunstâncias: &nbsp
	<?php echo $formu1['circunstancia1'];?> &nbsp &nbsp
	<?php echo $formu1['circunstancia2'];?> &nbsp &nbsp
	<?php echo $formu1['circunstancia3'];?> &nbsp &nbsp
	<?php echo $formu1['circunstancia4'];?> &nbsp &nbsp
	Outra. Qual (Other.Which)? &nbsp
	<?php echo $formu1['circunstanciaoutra'];?>
	<br>
	<p>
	<b>Avaliações: </b>
		1) Excelente (Excellent), &nbsp &nbsp 
		2) Bom (Good),  &nbsp &nbsp 
		3) Regular (Regular),  &nbsp &nbsp 
		4) Insuficiente (Insufficient),  &nbsp &nbsp 
		?) Não sabe (Don’t know)
	<br>
    Desempenho acadêmico (Academic achievements):<?php echo $formu1['desempenhoacademico'];?><br>
    Capacidade de aprender novos conceitos (Ability to learn new concepts): <?php echo $formu1['capacidadeaprender'];?><br>
	Capacidade de trabalhar sozinho (Ability to work independently):<?php echo $formu1['capacidadetrabalhar'];?><br>
	Criatividade (Creativity):<?php echo $formu1['criatividade'];?><br>
	Curiosidade, interesse (Curiosity, interest):<?php echo $formu1['curiosidade'];?><br>
	Esforço, persistência (Effort, persistence):<?php echo $formu1['esforco'];?><br>
	Expressão escrita (Written expression):<?php echo $formu1['expressaoescrita'];?><br>
	Expressão oral (Oral expression):<?php echo $formu1['expressaooral'];?><br>
	Relacionamento com colegas (Relationship with colleagues): <?php echo $formu1['relacionamento'];?>
	
	<p> 
	<b> Opinião sobre seus antecedentes acadêmicos, profissionais e/ou técnicos do candidato:</b>
	<br> 
	<?php echo $formu1['antecedentesacademicos'];?> 
	</p>
	<p>
	<b>Opinião sobre seu possível aproveitamento, se aceito no Programa:</b>
	<br> 
	<?php echo $formu1['possivelaproveitamento'];?>
	</p>
	<p>
	<b>Outras informações relevantes:</b>
	<br>
	<?php echo $formu1['informacoesrelevantes'];?>
	</p>
	
	<p>
	<b>Dentre os estudantes que já conheceu, sob os itens abaixo, você diria que o candidato está entre os:</b>
	<br>
	1) 5% melhores (Top 5%), &nbsp &nbsp 
	2) 10% melhores (Top 10%),  &nbsp &nbsp 
	3) 25% melhores(Top 25%),  &nbsp &nbsp 
	4) 50% melhores (Top 50%),  &nbsp &nbsp 
	?) Não sabe (Don’t know)
	<br> 
	Como aluno, em aulas (As student, in classes):<?php echo $formu1['comoaluno'];?>
	<br>
	Como orientando (During advisory): <?php echo $formu1['comoorientando'];?>
	
	</p>
	
	
	<b>
		Dados pessoais do professor: <?php echo $cadas3['nomeprofrecomendante2'];?>
	</b>
	<br>
	Instituição (Institution): &nbsp <?php echo $formu3['instituicaorecomendante'];?>
	<br>
	Grau acadêmico mais alto obtido (Highest academic degree obtained):&nbsp <?php echo $formu3['titulacaorecomendante'];?>
	&nbsp &nbsp em &nbsp <?php echo $formu3['arearecomendante'];?>.
	<br>
	Ano de obtenção deste grau (Year when it was obtained): &nbsp 
	<?php echo $formu3['anoobtencaorecomendante']; ?>
	<br>
	Instituição de obtenção deste grau (Institution where it was obtained):
	<?php echo $formu3['instobtencaorecomendante'];?>
	<br>
	Endereço institucional do recomendante (Recommender’s institutional address):
	<?php echo $formu3['enderecorecomendante'];?>

	<?php }?>






<!-- Terceira Carta de Recomendação --> 










	<hr>
	<h3>
		Carta de Recomendação de: <?php echo $cadas3['nomeprofrecomendante3'];?>
	</h3>
	<?php
	
	$query_pega_idprof3 = pg_query("select coduser from inscricao_pos_login	where login='".$cadas3['emailprofrecomendante3']."'  ");
	$coduser3=pg_fetch_row($query_pega_idprof3);
	$id_prof3=$coduser3[0];
	
	
	
	
	echo "Código de usuário do professor é :".$id_prof3."<br><br><br>";
	
	
	
	
	
	if($id_prof3!="")
	{	
	$query_formu1 = pg_query("select * from inscricao_pos_recomendacoes where id_aluno='".$cadas1['id_aluno']."' and id_prof='".$id_prof3."'");
	$formu1 = pg_fetch_assoc($query_formu1);
	
	$query_formu3 = pg_query("select * from inscricao_pos_dados_pessoais_recomendante where id_prof='".$id_prof3."'");
	$formu3 = pg_fetch_assoc($query_formu3);
	
	?>
	
	Conhece-o candidato há quanto tempo (For how long have you known the applicant)? &nbsp
	<?php echo $formu1['tempoconhececandidato'];?>
	<br>
	Conhece-o sob as seguintes circunstâncias: &nbsp
	<?php echo $formu1['circunstancia1'];?> &nbsp &nbsp
	<?php echo $formu1['circunstancia2'];?> &nbsp &nbsp
	<?php echo $formu1['circunstancia3'];?> &nbsp &nbsp
	<?php echo $formu1['circunstancia4'];?> &nbsp &nbsp
	Outra. Qual (Other.Which)? &nbsp
	<?php echo $formu1['circunstanciaoutra'];?>
	<br>
	<p>
	<b>Avaliações: </b>
		1) Excelente (Excellent), &nbsp &nbsp 
		2) Bom (Good),  &nbsp &nbsp 
		3) Regular (Regular),  &nbsp &nbsp 
		4) Insuficiente (Insufficient),  &nbsp &nbsp 
		?) Não sabe (Don’t know)
	<br>
    Desempenho acadêmico (Academic achievements):<?php echo $formu1['desempenhoacademico'];?><br>
    Capacidade de aprender novos conceitos (Ability to learn new concepts): <?php echo $formu1['capacidadeaprender'];?><br>
	Capacidade de trabalhar sozinho (Ability to work independently):<?php echo $formu1['capacidadetrabalhar'];?><br>
	Criatividade (Creativity):<?php echo $formu1['criatividade'];?><br>
	Curiosidade, interesse (Curiosity, interest):<?php echo $formu1['curiosidade'];?><br>
	Esforço, persistência (Effort, persistence):<?php echo $formu1['esforco'];?><br>
	Expressão escrita (Written expression):<?php echo $formu1['expressaoescrita'];?><br>
	Expressão oral (Oral expression):<?php echo $formu1['expressaooral'];?><br>
	Relacionamento com colegas (Relationship with colleagues): <?php echo $formu1['relacionamento'];?>
	
	<p> 
	<b> Opinião sobre seus antecedentes acadêmicos, profissionais e/ou técnicos do candidato:</b>
	<br> 
	<?php echo $formu1['antecedentesacademicos'];?> 
	</p>
	<p>
	<b>Opinião sobre seu possível aproveitamento, se aceito no Programa:</b>
	<br> 
	<?php echo $formu1['possivelaproveitamento'];?>
	</p>
	<p>
	<b>Outras informações relevantes:</b>
	<br>
	<?php echo $formu1['informacoesrelevantes'];?>
	</p>
	
	<p>
	<b>Dentre os estudantes que já conheceu, sob os itens abaixo, você diria que o candidato está entre os:</b>
	<br>
	1) 5% melhores (Top 5%), &nbsp &nbsp 
	2) 10% melhores (Top 10%),  &nbsp &nbsp 
	3) 25% melhores(Top 25%),  &nbsp &nbsp 
	4) 50% melhores (Top 50%),  &nbsp &nbsp 
	?) Não sabe (Don’t know)
	<br> 
	Como aluno, em aulas (As student, in classes):<?php echo $formu1['comoaluno'];?>
	<br>
	Como orientando (During advisory): <?php echo $formu1['comoorientando'];?>
	
	</p>
	
	
	<b>
		Dados pessoais do professor: <?php echo $cadas3['nomeprofrecomendante3'];?>
	</b>
	<br>
	Instituição (Institution): &nbsp <?php echo $formu3['instituicaorecomendante'];?>
	<br>
	Grau acadêmico mais alto obtido (Highest academic degree obtained):&nbsp <?php echo $formu3['titulacaorecomendante'];?>
	&nbsp &nbsp em &nbsp <?php echo $formu3['arearecomendante'];?>.
	<br>
	Ano de obtenção deste grau (Year when it was obtained): &nbsp 
	<?php echo $formu3['anoobtencaorecomendante']; ?>
	<br>
	Instituição de obtenção deste grau (Institution where it was obtained):
	<?php echo $formu3['instobtencaorecomendante'];?>
	<br>
	Endereço institucional do recomendante (Recommender’s institutional address):
	<?php echo $formu3['enderecorecomendante'];?>

<?php }?>	

		
		<br><br>
		<br><input type=checkbox name='homologa[<?php echo $i;?>]' value="<?php echo $coduser;?>">
		<b>Homologar inscricao de <?php echo $cadas1['name']." ".$cadas1['firstname'];?> - Usuário:<?php echo $coduser;?> </b>
		<hr><hr><hr><hr><hr><hr><hr><hr>
		
	<?php
	}
	?>
		<p align="center"> <input type="submit" value="Gera Lista de Inscrições Homologadas"> </p>
		</form>

</body>
</html>

<?php
pg_close($idconn);
?>
	
	
