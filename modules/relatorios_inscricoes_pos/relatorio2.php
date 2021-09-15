<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
	<head>
	<META http-equiv="Content-Type" content="text/html; charset=utf-8">
	</head>
	

<body>
	<h2 align="center">
		Lista dos Candidatos para o programa de Pós-Graduação
	</h2>

<hr>
		
		<?php include_once("../pgsql/pgsql.php"); 

		$query_cadas1 = pg_query("select * from inscricao_pos_dados_candidato where id_aluno='182'");
		$cadas1 = pg_fetch_assoc($query_cadas1);
		
		$query_cadas2 = pg_query("select * from inscricao_pos_dados_profissionais_candidato where id_aluno='182'");
		$cadas2 = pg_fetch_assoc($query_cadas2);
		
		$query_cadas3 = pg_query("select * from inscricao_pos_contatos_recomendante where id_aluno='182'");
		$cadas3 = pg_fetch_assoc($query_cadas3);
		
		$query_carta_motivacao = pg_query("select * from inscricao_pos_carta_motivacao where id_aluno='182'");
		$cadas31 = pg_fetch_assoc($query_carta_motivacao);
		
		?>
		
		
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
		1- Nome: <?php $cadas3['nomeprofrecomendante1']; ?>
            &nbsp 
 		e-mail: <?php $cadas3['emailprofrecomendante1']; ?> 
        <br>
           2- Nome: <?php $cadas3['nomeprofrecomendante2']; ?>
            &nbsp 
 		e-mail: <?php $cadas3['emailprofrecomendante2']; ?> 
        <br>
           3- Nome: <?php $cadas3['nomeprofrecomendante3']; ?>
            &nbsp 
 		e-mail: <?php $cadas3['emailprofrecomendante3']; ?> 
        <br>
        <br>   
 		Motivação e expectativa do candidato em relação ao programa pretendido:
		<br>
		<?php echo $cadas31['motivacaoprogramapretendido']; ?> 
		
		
	
	<h3 align="center">
		Carta de Recomendação - Página 1 de 3
	</h3>
	
	<form method="POST" action ="processacarta.php">
	<p> Candidato a que programa (Applicant to which level) ?
	<br> 
	<input type="radio" name="formu1['Nivel']" value="mestrado" > Mestrado (Master's)
	<input type="radio" name="formu1['Nivel']" value="doutorado"> Doutorado (PhD)
	<input type="radio" name="formu1['Verao']" value="verao"> Verão
	</p>
	
	<p>
	Nome do candidato (Applicant’s name):
	<br>
	<input type="text" size="35" maxlength="256" name="Nome">
	</p>
	
	<p>
	Conhece-o há quanto tempo (For how long have you known the applicant)?
	<br>
	<input type="text" size="35" maxlength="50" name="formu1['TempoConheceCandidato']">
	</p>
	
	<p>
	Conhece-o sob que circunstâncias (Under which circumstances have you known the applicant)?
	<br>
	<input type="checkbox" name="formu1['Circunstancia1']" value="aulas" > Aulas &nbsp &nbsp
	<input type="checkbox" name="formu1['Circunstancia2']" value="orientacao" > Orientação &nbsp &nbsp
	<input type="checkbox" name="formu1['Circunstancia3']" value="seminarios" > Seminários &nbsp &nbsp
	<input type="checkbox" name="formu1['Circunstancia4']" value="outra" > 
	Outra. Qual (Other.Which)? 
	<input type="text" size="35" maxlength="256" name="formu1['CircunstanciaOutra']">
	</p>
	<br>
		
	
	
	
	
	<p>
	Procure avaliá-lo sob os itens abaixo (Try to evaluate the applicant under the items below):
	<br><br>
	<table cellspacing="0">
	<tr> 
		<td></td>
		<td></td>
		<td align="center">1 </td> <td align="center">2 </td> <td align="center">3 </td> <td align="center">4 </td> 
		<td width="100" align="center">? </td>
	</tr>
	
	
	<tr onmouseover="this.bgColor='#CDCDC1'" onmouseout="this.bgColor='white'"> 
		<td>Desempenho acadêmico (Academic achievements)</td>
		<td>&nbsp &nbsp  &nbsp &nbsp &nbsp </td>
		<td> <input type="radio" name="formu1['DesempenhoAcademico']" value="1" >  </td>
		<td> <input type="radio" name="formu1['DesempenhoAcademico']" value="2" >  </td>
		<td> <input type="radio" name="formu1['DesempenhoAcademico']" value="3" >  </td>
		<td> <input type="radio" name="formu1['DesempenhoAcademico']" value="4" >  </td>
		<td align="center" width="100"> <input type="radio" name="formu1['DesempenhoAcademico']" value="naoinfo" > </td>
	</tr>
	
	
	<tr onmouseover="this.bgColor='#CDCDC1'" onmouseout="this.bgColor='white'">  
		<td> Capacidade de aprender novos conceitos (Ability to learn new concepts)</td>
		<td>&nbsp &nbsp  &nbsp &nbsp &nbsp </td>
		<td> <input type="radio" name="formu1['CapacidadeAprender']" value="1" >  </td>
		<td> <input type="radio" name="formu1['CapacidadeAprender']" value="2" >  </td>
		<td> <input type="radio" name="formu1['CapacidadeAprender']" value="3" >  </td>
		<td> <input type="radio" name="formu1['CapacidadeAprender']" value="4" >  </td>
		<td align="center" width="100"> <input type="radio" name="formu1['CapacidadeAprender']" value="naoinfo" > 	</td>
	</tr>
	
	
	<tr onmouseover="this.bgColor='#CDCDC1'" onmouseout="this.bgColor='white'"> 
		<td> Capacidade de trabalhar sozinho (Ability to work independently)</td>
		<td>&nbsp &nbsp  &nbsp &nbsp &nbsp </td>
		<td> <input type="radio" name="formu1['CapacidadeTrabalhar']" value="1" >  </td>
		<td> <input type="radio" name="formu1['CapacidadeTrabalhar']" value="2" >  </td>
		<td> <input type="radio" name="formu1['CapacidadeTrabalhar']" value="3" >  </td>
		<td> <input type="radio" name="formu1['CapacidadeTrabalhar']" value="4" >  </td>
		<td align="center" width="100"> <input type="radio" name="formu1['CapacidadeTrabalhar']" value="naoinfo" > 	</td>
	</tr>
	
	
	<tr onmouseover="this.bgColor='#CDCDC1'" onmouseout="this.bgColor='white'"> 
		<td>Criatividade (Creativity)</td>
		<td>&nbsp &nbsp  &nbsp &nbsp &nbsp </td>
		<td> <input type="radio" name="formu1['Criatividade']" value="1" > </td>
		<td> <input type="radio" name="formu1['Criatividade']" value="2" > </td>
		<td> <input type="radio" name="formu1['Criatividade']" value="3" > </td>
		<td> <input type="radio" name="formu1['Criatividade']" value="4" > </td>
		<td align="center" width="100"> <input type="radio" name="formu1['Criatividade']" value="naoinfo" > 	</td>
	</tr>
	
	
	<tr onmouseover="this.bgColor='#CDCDC1'" onmouseout="this.bgColor='white'"> 
		<td>Curiosidade, interesse (Curiosity, interest)</td>
		<td>&nbsp &nbsp  &nbsp &nbsp &nbsp </td>
		<td> <input type="radio" name="formu1['Curiosidade']" value="1" > </td>
		<td> <input type="radio" name="formu1['Curiosidade']" value="2" > </td>
		<td> <input type="radio" name="formu1['Curiosidade']" value="3" > </td>
		<td> <input type="radio" name="formu1['Curiosidade']" value="4" > </td>
		<td align="center" width="100"> <input type="radio" name="formu1['Curiosidade']" value="naoinfo" > 	</td>
	</tr>
	
	
	<tr onmouseover="this.bgColor='#CDCDC1'" onmouseout="this.bgColor='white'"> 
		<td>Esforço, persistência (Effort, persistence)</td>
		<td>&nbsp &nbsp  &nbsp &nbsp &nbsp </td>
		<td> <input type="radio" name="formu1['Esforco']" value="1" >  </td>
		<td> <input type="radio" name="formu1['Esforco']" value="2" >  </td>
		<td> <input type="radio" name="formu1['Esforco']" value="3" >  </td>
		<td> <input type="radio" name="formu1['Esforco']" value="4" >  </td>
		<td align="center" width="100"> <input type="radio" name="formu1['Esforco']" value="naoinfo" >  	</td>
	</tr>
	
	
	<tr onmouseover="this.bgColor='#CDCDC1'" onmouseout="this.bgColor='white'"> 
		<td>Expressão escrita (Written expression)</td>
		<td>&nbsp &nbsp  &nbsp </td>
		<td> <input type="radio" name="formu1['ExpressaoEscrita']" value="1" > </td>
		<td> <input type="radio" name="formu1['ExpressaoEscrita']" value="2" > </td> 
		<td> <input type="radio" name="formu1['ExpressaoEscrita']" value="3" > </td>
		<td> <input type="radio" name="formu1['ExpressaoEscrita']" value="4" > </td>
		<td align="center" width="100"> <input type="radio" name="formu1['ExpressaoEscrita']" value="naoinfo" > 	</td>
	</tr>
	
	
	<tr onmouseover="this.bgColor='#CDCDC1'" onmouseout="this.bgColor='white'"> 
		<td> Expressão oral (Oral expression)</td>
		<td>&nbsp &nbsp  &nbsp </td>
		<td> <input type="radio" name="formu1['ExpressaoOral']" value="1" >  </td>
		<td> <input type="radio" name="formu1['ExpressaoOral']" value="2" >  </td>
		<td> <input type="radio" name="formu1['ExpressaoOral']" value="3" >  </td>
		<td> <input type="radio" name="formu1['ExpressaoOral']" value="4" >  </td>
		<td align="center" width="100"> <input type="radio" name="formu1['ExpressaoOral']" value="naoinfo" >  </td>
	</tr>

	
	<tr onmouseover="this.bgColor='#CDCDC1'" onmouseout="this.bgColor='white'"> 
		<td>Relacionamento com colegas (Relationship with colleagues)</td>
		<td>&nbsp &nbsp  &nbsp </td>
		<td> <input type="radio" name="formu1['Relacionamento']" value="1" > </td>
		<td> <input type="radio" name="formu1['Relacionamento']" value="2" > </td>
		<td> <input type="radio" name="formu1['Relacionamento']" value="3" > </td>
		<td> <input type="radio" name="formu1['Relacionamento']" value="4" > </td>
		<td align="center" width="100"> <input type="radio" name="formu1['Relacionamento']" value="naoinfo" > </td>
	</tr>
	<table>
	<br>
	1) Excelente (Excellent), &nbsp &nbsp 
	2) Bom (Good),  &nbsp &nbsp 
	3) Regular (Regular),  &nbsp &nbsp 
	4) Insuficiente (Insufficient),  &nbsp &nbsp 
	?) Não sabe (Don’t know)
	</p>
	
	<p align="center">
	<!-- <input type="hidden" name="OndeEstou" value="pag1">
	<input type="hidden" name="id_aluno" value="<?php echo $id_aluno;?>">
	<input type="hidden" name="id_prof" value="<?php echo $id_prof;?>">
	<input type="submit" name="rota" value="Salvar e Prosseguir">
	<input type="submit" value="Salvar e Prosseguir">
	<input type="reset" value="Limpar Formulário">
	</p>
	-->
	</form>
	
	
		<h3 align="center">
		Carta de Recomendação - Página 2 de 3
	</h3>
	
	<form method="POST" action ="processacarta.php">
	
	<p> 
		Dê-nos sua opinião sobre seus antecedentes acadêmicos, profissionais e/ou técnicos <br>
		(Please give us your opinion about his/her academic, professional and/or technical background):
	<br> 
	<textarea style="background:#EEE9E9" name="formu2['AntecedentesAcademicos']" rows="7" cols="73" ></textarea>
	</p>
	
	<p>
		Dê-nos sua opinião sobre seu possível aproveitamento, se aceito no Programa <br>
		(Please give us your opinion about his/her potential performance, if accepted into the Program):
	<br> 
	<textarea style="background:#EEE9E9" name="formu2['PossivelAproveitamento']" rows="7" cols="73" ></textarea>
	</p>
	
	<p>
		Outras informações relevantes (Other information you may consider relevant):
	<br>
	<textarea style="background:#EEE9E9" name="formu2['InformacoesRelevantes']" rows="7" cols="73" ></textarea>
	</p>
	
	
	
	
	
	<p>
	Dentre os estudantes que já conheceu, sob os itens abaixo, você diria que o candidato está entre os
	<br>
	(Among all students you’ve already met, under the items below, you’d say that he/she is in the):

	<br><br>
	<table cellspacing="0">
	<tr> 
		<td></td>
		<td></td>
		<td align="center">1 </td> <td align="center">2 </td> <td align="center">3 </td> <td align="center">4 </td> 
		<td width="100" align="center">? </td>
	</tr>
	
	
	<tr onmouseover="this.bgColor='#CDCDC1'" onmouseout="this.bgColor='white'"> 
		<td>Como aluno, em aulas (As student, in classes) </td>
		<td>&nbsp &nbsp  &nbsp &nbsp &nbsp </td>
		<td> <input type="radio" name="formu2['ComoAluno']" value="1" > </td>
		<td> <input type="radio" name="formu2['ComoAluno']" value="2" > </td>
		<td> <input type="radio" name="formu2['ComoAluno']" value="3" > </td>
		<td> <input type="radio" name="formu2['ComoAluno']" value="4" > </td>
		<td width="100" align="center"> <input type="radio" name="formu2['ComoAluno']" value="naoinfo" > </td>
	</tr>
	
	
	<tr onmouseover="this.bgColor='#CDCDC1'" onmouseout="this.bgColor='white'">  
		<td> Como orientando (During advisory) </td>
		<td>&nbsp &nbsp  &nbsp &nbsp &nbsp </td>
		<td> <input type="radio" name="formu2['ComoOrientando']" value="1" > </td>
		<td> <input type="radio" name="formu2['ComoOrientando']" value="2" > </td>
		<td> <input type="radio" name="formu2['ComoOrientando']" value="3" > </td>
		<td> <input type="radio" name="formu2['ComoOrientando']" value="4" > </td>
		<td width="100" align="center"> <input type="radio" name="formu2['ComoOrientando']" value="naoinfo" > </td>
	</tr>
	

	<table>
	<br> 

	1) 5% melhores (Top 5%), &nbsp &nbsp 
	2) 10% melhores (Top 10%),  &nbsp &nbsp 
	3) 25% melhores(Top 25%),  &nbsp &nbsp 
	4) 50% melhores (Top 50%),  &nbsp &nbsp 
	?) Não sabe (Don’t know)
	</p>
	
	
	</form>
	<h3 align="center">
		Carta de Recomendação - Página 3 de 3
	</h3>
	
	<form method="POST" action ="processacarta.php">
	
	<p> 
		Nome do recomendante (Recommender’s name):
	<br> 
	<input type="text" size="50" maxlength="256" name="formu3['NomeRecomendante']">
	</p>
	
	<p>
	Instituição (Institution):
	<br> 
	<input type="text" size="70" maxlength="256" name="formu3['InstituicaoRecomendante']">
	</p>
	
	<p>
	Grau acadêmico mais alto obtido (Highest academic degree obtained):
	<br> 
	<select name="formu3['TitulacaoRecomendante']" size="1">
	<option  value="nselecionado"> Selecione uma opção:</option>
	<option value="doutor"> Doutor</option>
	<option value="mestre"> Mestre</option>
	<option value="especialista"> Especialista</option>
	<option value="bacharel"> Bacharel</option>
	<option value="licenciado"> Licenciado</option>
	<option value="outro"> Outro</option>
	</select>
	</p>
	
	
	<p>
	Em que área (In which area):<br>
	<input type="text" size="70" maxlength="256" name="formu3['AreaRecomendante']">
	</p>
	
	<p>
	Ano de obtenção deste grau (Year when it was obtained):
	<input type="text" size="4" maxlength="256" name="formu3['AnoObtencaoRecomendante']">
	</p>
	
	<p>
	Instituição de obtenção deste grau (Institution where it was obtained):
	<br>
	<input type="text" size="70" maxlength="256" name="formu3['InstObtencaoRecomendante']">
	</p>

	
	<p>
	Endereço institucional do recomendante (Recommender’s institutional address):
	<br> 
	<textarea style="background:white" name="formu3['EnderecoRecomendante']" rows="3" cols="70" ></textarea>
	</p>

</form>


</body>
</html>

	
	
