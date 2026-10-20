<?php
  require("head_user.php");
//   $query="select * from users where matricul='".$_POST['matricul']."' or identity= '".$_POST['identity']."' or cpf='".$_POST['cpf']."'";

if ($_POST['modificacao']=="nao")
 {
  if (($_POST['status_usuario']=='visitor') or ($_POST['status_usuario']=='Visitante')) list($query, $query__p) = array("select * from users where identity=? and cpf=?", array($_POST['identity'], $_POST['cpf'])); 
	else list($query, $query__p) = array("select * from users where identity= ? or cpf=?", array($_POST['identity'], $_POST['cpf']));
//   $query="select * from users where identity= '".$_POST['identity']."' or cpf='".$_POST['cpf']."'";
  }
else list($query, $query__p) = array("select * from users where coduser=?", array($_POST['user'])); 
   $result=db_query($query, $query__p);
   $count=db_num_rows($result);

?>
<html>
   <header>
    <script language=javascript src="formu.js">
    </script>
    <script language=javascript>
      function verif_pass()
{
            if (document.utilisateur.pass1.value!= document.utilisateur.pass2.value)
            {
                alert('As duas senhas nao sao identicas!');
                document.utilisateur.pass1.focus();
                return false;
            }
            if (document.utilisateur.login.value.length==0)
            {
                alert("Voce deve digitar um login!");
                document.forms['utilisateur'].login.focus();
                return false;
            }
            if ((document.utilisateur.pass1.value.length==0)||(document.utilisateur.pass2.value.length==0))
            {
                alert("Voce deve digitar a senha e confirma-la!");
                document.forms['utilisateur'].pass1.focus();
                return false;
            }
            return true;
}

    </script>
    <link type="text/css" rel="stylesheet" href="../../global/grafic.css">
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
  </header>
  <body>
  <table class=big>
  <form method=POST name="utilisateur" action='add_user3.php' onsubmit="return verif_pass();">
  <tr>
      <td class=header align=center colspan=2>
        <h1>Cria&ccedil;&atilde;o de conta de usu&aacute;rio</h1><br>Informa&ccedil;&otilde;es sobre a conta
      </td>
    </tr>
<?php
   if (($count!=0) and ($_POST['modificacao']=="nao"))
	{
?>
  <tr>
      <td align=center>
        <table class=form>
        <tr>
          <td class=header align=center>Ja Existe um usuario com esses dados!!</td>
        </tr>
        <tr>
          <td>Use o formulario modificacao de usuario<br>
        </td>
        </tr>
        </table>
      </td>
    </tr>

<?php
	}

   if (($count!=0) and ($_POST['modificacao']=="sim"))
   {
// update data
	$status_usuario1=$_POST['status_usuario'];
	if ($_POST['status_usuario1']=='nao_modifica') $status_usuario=$status_usuario1; else {$status_usuario=$_POST['status_usuario1']; $tipo_users=$_POST['status_usuario1'];}

	if (($status_usuario=='Aluno') or ($status_usuario=='student')){$tipo_users="student"; $status_usuario="student";}
        if (($status_usuario=='Visitante') or ($status_usuario=='visitor')) {$tipo_users="visitor"; $status_usuario="visitor";} 
        if (($status_usuario=='Professor') or ($status_usuario=='professor')) {$tipo_users="professor";	$status_usuario='professor';} 
	if (($status_usuario=='Administrativo') or ($status_usuario=='administrativo')) {$tipo_users="administrativo";$status_usuario=='administrativo';}
	
//	if ($_POST['status_usuario']=='Aluno') {$tipo_users='student';} else if ($_POST['status_usuario']=='Visitante') {$tipo_users='visitor';} else {$tipo_users=$_POST['status_usuario'];}
       $usuario_a_mudar0=db_fetch_array($result,0);
       $matricul_atual=str_replace("/", "", $usuario_a_mudar0['matricul']);
       $usuario_a_mudar=$usuario_a_mudar0['coduser'];
       $tipo_users_atual=$usuario_a_mudar0['tipo_users'];

	//se houve modificacao da $_POST['tipo_contrato'] entao matricul deve ser distinto; Se nao for assim entao a modificacao nao pode ocorrer.

	if ($tipo_users_atual=='student') list($busca_tipo_contract, $busca_tipo_contract__p) = array("select formation from student where matricul=?", array($matricul_atual));
	if (($tipo_users_atual=='professor') or ($tipo_users_atual=='administrativo')) list($busca_tipo_contract, $busca_tipo_contract__p) = array("select contract_type from fonctionnaire where coduser=?", array($usuario_a_mudar));
	if ($tipo_users_atual=='visitor') list($busca_tipo_contract, $busca_tipo_contract__p) = array("select tipo_visitor from visitor where coduser=? order by date_begin DESC  limit 1", array($usuario_a_mudar));
	$query_busca_tipo_contract=db_query($busca_tipo_contract, $busca_tipo_contract__p);
	//$tipo_contrato_atual=db_fetch_array($query_busca_tipo_contract);
	$tipo_contrato_atual=db_fetch_row($query_busca_tipo_contract);

	if (($_POST['tipo_contrato']=='nao_modifica')) $tipo_contrato=$tipo_contrato_atual[0]; else $tipo_contrato=$_POST['tipo_contrato'];

	if ( ( ($_POST['tipo_contrato']!='nao_modifica') and ($matricul_atual==str_replace("/", "", $_POST['matricul'])) ) or 
	     ( ($_POST['tipo_contrato']=='nao_modifica') and ($matricul_atual!=str_replace("/", "", $_POST['matricul'])) ) or
	     ( ($_POST['tipo_contrato']!='nao_modifica') and ($matricul_atual!=str_replace("/", "", $_POST['matricul'])) 
               and (empty($_POST['dia_novo']) or empty($_POST['mes_novo']) or empty($_POST['ano_novo'])) ) or 
	     ( ($_POST['tipo_contrato']=='nao_modifica') and ($matricul_atual==str_replace("/", "", $_POST['matricul'])) 
            and ($tipo_users!='visitor') and (!empty($_POST['dia_novo']) or !empty($_POST['mes_novo']) or !empty($_POST['ano_novo'])) )  
	   ) 
	{ 
?>
  <tr>
      <td align=center>
        <table class=form>
        <tr>
          <td class=header align=center><b>operacao imposs&iacute;vel!!</b></td>
        </tr>
        <tr>
          <td> O tipo contratual, a matr&iacute;cula e a nova data de admiss&atilde;o devem sofrer altera&ccedil;&otilde;es simultaneamente!;<br>
        </td>
        </tr>
        </table>
      </td>
    </tr>

<?php
	exit;
	}
	else
	{
	// as modificaçoes são efetuadas.
//	$nome=mb_convert_encoding($_POST['name'],"UTF-8");
//	$sobrenome=mb_convert_encoding($_POST['firstname'],"UTF-8");
//	$endereco=mb_convert_encoding($_POST['adresse'],"UTF-8");
//	$cidade=mb_convert_encoding($_POST['city'],"UTF-8");
        
        $nome=$_POST['name'];
        $sobrenome=$_POST['firstname'];
        $endereco=$_POST['adresse'];
        $cidade=$_POST['city'];

// Atualizacao da tabela unix:
	if (($tipo_users=="professor") or ($tipo_users=="administrativo")) $tabela_user="fonctionnaire"; else $tabela_user=$tipo_users;
	list($query_unix, $query_unix__p) = array("update unix set tabela_user=? where coduser=?", array($tabela_user, $usuario_a_mudar));
	$res_unix=db_query($query_unix, $query_unix__p);



//Atualizacao da taberla users:
       list($query, $query__p) = array("update users set name=?, firstname=?,\n               matricul=?, cpf=?,identity=?, phone_home=?,\n               phone_work=?, adresse=?, cp=?, city=?, is_actif=true,  tipo_users=? where coduser=?", array($nome, $sobrenome, str_replace("/", "", $_POST['matricul']), $_POST['cpf'], $_POST['identity'], $_POST['phone_home'], $_POST['phone_work'], $endereco, $_POST['cp'], $cidade, $tipo_users, $usuario_a_mudar));
        $result=db_query($query, $query__p);
//        db_free_result($result);
// update mails
	list($deleta_mails, $deleta_mails__p) = array("delete from mail where coduser=?", array($usuario_a_mudar));
	$res_deleta_mail=db_query($deleta_mails, $deleta_mails__p);
/////
     if (!empty($_POST['mail1']))
        {
	list($query, $query__p) = array("insert into mail values(?,?)", array($_POST['mail1'], $usuario_a_mudar));
	$result=db_query($query, $query__p);
//	db_free_result($result);
	}

	if (!empty($_POST['mail2']))
	{
       list($query, $query__p) = array("insert into mail values(?,?)", array($_POST['mail2'], $usuario_a_mudar));
       $result=db_query($query, $query__p);
       db_free_result($result);
	}

	if (!empty($_POST['mail3']))
	{
       list($query, $query__p) = array("insert into mail values(?,?)", array($_POST['mail3'], $usuario_a_mudar));
       $result=db_query($query, $query__p);
	}
	if (!empty($_POST['mail4']))
	{
       list($query, $query__p) = array("insert into mail values(?,?)", array($_POST['mail4'], $usuario_a_mudar));
       $result=db_query($query, $query__p);
	}

	if ($_POST['especialidade']=='nao_modifica') {$especialidade=$_POST['especialidade1'];} else {$especialidade=$_POST['especialidade'];}
	if ($_POST['bolsista']=='nao_modifica') {$bolsista=$_POST['bolsista1'];} else {$bolsista=$_POST['bolsista'];}
	if ($_POST['prof_orientador']=='nao_modifica') {$prof_orientador=$_POST['prof_orientador1'];} else {$prof_orientador=$_POST['prof_orientador'];}
	if ($_POST['funcional']=='nao_modifica') {$funcional=$_POST['funcional1'];} else {$funcional=$_POST['funcional'];}

//alteraçao incuida em 18/10/2018
//
list($query_ja_credenciado, $query_ja_credenciado__p) = array("select * from orientateur where coduser=?", array($usuario_a_mudar));

$result_credenciado=db_query($query_ja_credenciado, $query_ja_credenciado__p);
$count_credenciado=db_num_rows($result_credenciado);

if ($count_credenciado == 0) 
	{
	if (($_POST['credencia_nivel']!='nao_modifica') and ($_POST['credencia_nivel']!='nulo'))
		{
		$data_hoje= date('Y-m-d');
//		echo $data_hoje;
		list($query_credencia_orientador, $query_credencia_orientador__p) = array("insert into orientateur (coduser,date_debut,date_fin,orientacao) values(?,?,?,?)", array($usuario_a_mudar, $data_hoje, $_POST['fim_credencia_ano'].'-'.$_POST['fim_credencia_mes'].'-'.$_POST['fim_credencia_dia'], $_POST['credencia_nivel']));
		$result_fonctionnaire=db_query($query_credencia_orientador, $query_credencia_orientador__p);
		}
	}
	else
	{ 
	if ($_POST['credencia_nivel']=='nao_modifica')
		{
      		list($query_orientador, $query_orientador__p) = array("update orientateur set date_fin=? where coduser=?", array($_POST['fim_credencia_ano'].'-'.$_POST['fim_credencia_mes'].'-'.$_POST['fim_credencia_dia'], $usuario_a_mudar));}
		else 
		{list($query_orientador, $query_orientador__p) = array("update orientateur set date_fin=?, orientacao=? where coduser=?", array($_POST['fim_credencia_ano'].'-'.$_POST['fim_credencia_mes'].'-'.$_POST['fim_credencia_dia'], $_POST['credencia_nivel'], $usuario_a_mudar));}
	$result_fonctionnaire=db_query($query_orientador, $query_orientador__p);
	}
		
//fim alteracao 18/10/2018


// update dados profissionais: status_usuario,tipo_contrato,data_de_entrada,      dia_dois,mes_dois,ano_dois,especialidade,funcional,prof_orientador
//	if (($_POST['status_usuario']=='professor') or ($_POST['status_usuario']=='administrativo'))
//	if ((($status_usuario=='professor') or ($status_usuario=='administrativo'))  and ($status_usuario1=='nao_modifica') )
	if ((($status_usuario=='professor') or ($status_usuario=='administrativo'))  and ($_POST['status_usuario1']=='nao_modifica') )
		{  //dia_dois,mes_dois,ano_dois,especialidade,funcional,prof_orientador
		$data_saida=$_POST['ano_dois'].$_POST['mes_dois'].$_POST['dia_dois'];
		list($query_fonctionnaire, $query_fonctionnaire__p) = array("update fonctionnaire set contract_end=?, contract_type=? where coduser=?", array($data_saida, $tipo_contrato, $usuario_a_mudar));
		$result_fonctionnaire=db_query($query_fonctionnaire, $query_fonctionnaire__p);
	 	//if ($_POST['status_usuario']=='professor')
		if ($status_usuario=='professor')
		   {
		if($_POST['situacao']=="nao_modifica") $situacao=$_POST['situacao1']; else $situacao=$_POST['situacao'];
           	    list($query_profs, $query_profs__p) = array("update profs set niveau_fonctionnel=?,bolsista=?, area_atuacao=?, situacao=? where coduser=?", array($funcional, $bolsista, $especialidade, $situacao, $usuario_a_mudar));
		    $result_profs=db_query($query_profs, $query_profs__p);

		    if ($_POST['tipo_contrato']!='nao_modifica')
			{
			//if (($_POST['tipo_contrato']=="dedicacao exclusiva") or ($_POST['tipo_contrato']=="professor associado")) $periodo="35 anos";
			if ($_POST['tipo_contrato']=="dedicacao exclusiva") $periodo="35 anos";// corrigido em 18/10/2018
			if ($_POST['tipo_contrato']=="professor aposentado") $periodo="2 anos";
			if ($_POST['tipo_contrato']=="pesquisador associado") $periodo="10 anos"; // corrigido em 18/10/2018
			if ($_POST['tipo_contrato']=="professor voluntario") $periodo="2 anos"; // corrigido em 18/10/2018
		        if (($_POST['tipo_contrato']=="prestador servico") or ($_POST['tipo_contrato']=="substituto ms20") or ($_POST['tipo_contrato']=="substituto ms40") or ($_POST['tipo_contrato']=="substituto gr40") or ($_POST['tipo_contrato']=="substituto dr40")) $periodo="2 anos";
		        if ($_POST['tipo_contrato']=="estagiario grad") $periodo="06 meses";
		        if ($_POST['tipo_contrato']=="estagiario tec") $periodo="1 ano";
		        $data_entrada=$_POST['ano_novo']."-".$_POST['mes_novo']."-".$_POST['dia_novo'];
			$data_de_saida= gera_data_saida($_POST['dia_novo'],$_POST['mes_novo'],$_POST['ano_novo'],$periodo);
		//        $query="update fonctionnaire set contract_date='".$data_entrada."', contract_type='".$_POST['tipo_contrato']."',statut='".$_POST['status_usuario']."',contract_end='".$data_de_saida."' where coduser=".$usuario_a_mudar;
        list($query, $query__p) = array("update fonctionnaire set contract_date=?, contract_type=?,statut=?,contract_end=? where coduser=?", array($data_entrada, $_POST['tipo_contrato'], $status_usuario, $data_de_saida, $usuario_a_mudar));
		        $result=db_query($query, $query__p);
			}
		   }
		}


//	if (($status_usuario=='professor') and ($status_usuario1!='nao_modifica') )
	if (($status_usuario=='professor') and ($_POST['status_usuario1']!='nao_modifica') )
                {  //dia_dois,mes_dois,ano_dois,especialidade,funcional,prof_orientador
		//comando insert: INSERT INTO table_name (column1, column2, column3,...) VALUES (value1, value2, value3,...);
		//tabela profs:  coduser | orientateur |    area_atuacao     | niveau_fonctionnel | bolsista  |   situacao 
		if ($funcional=="indefinido") $orientateur="f"; else $orientateur="t";
if($_POST['situacao']=="nao_modifica") $situacao=$_POST['situacao1']; else $situacao=$_POST['situacao'];
           	list($query_profs, $query_profs__p) = array("insert into profs (coduser,orientateur,niveau_fonctionnel,bolsista,area_atuacao,situacao) values(?,?,?,?,?,?)", array($usuario_a_mudar, $orientateur, $funcional, $bolsista, $especialidade, $situacao));
                $result_profs=db_query($query_profs, $query_profs__p);
                if ($_POST['tipo_contrato']!='nao_modifica')
                        {
                        //if (($_POST['tipo_contrato']=="dedicacao exclusiva") or ($_POST['tipo_contrato']=="professor associado")) $periodo="35 anos";
			if ($_POST['tipo_contrato']=="dedicacao exclusiva") $periodo="35 anos";  // corrigido em 18/10/2018
			if ($_POST['tipo_contrato']=="pesquisador associado") $periodo="10 anos"; // corrigido em 18/10/2018
			if ($_POST['tipo_contrato']=="professor voluntario") $periodo="2 anos"; // corrigido em 18/10/2018
                        if ($_POST['tipo_contrato']=="professor aposentado") $periodo="2 anos";
                        if (($_POST['tipo_contrato']=="prestador servico") or ($_POST['tipo_contrato']=="substituto ms20") or ($_POST['tipo_contrato']=="substituto ms40") or ($_POST['tipo_contrato']=="substituto gr40") or ($_POST['tipo_contrato']=="substituto dr40")) $periodo="2 anos";
                        if ($_POST['tipo_contrato']=="estagiario grad") $periodo="06 meses";
                        if ($_POST['tipo_contrato']=="estagiario tec") $periodo="1 ano";
                        $data_entrada=$_POST['ano_novo']."-".$_POST['mes_novo']."-".$_POST['dia_novo'];
                        $data_de_saida= gera_data_saida($_POST['dia_novo'],$_POST['mes_novo'],$_POST['ano_novo'],$periodo);
			//tabela fonctionnaire:  coduser | contract_date |         contract_type          |     statut     | contract_end 
		        list($query, $query__p) = array("insert into fonctionnaire (coduser,contract_date,contract_type,statut,contract_end) values(?,?,?,?,?)", array($usuario_a_mudar, $data_entrada, $_POST['tipo_contrato'], $status_usuario, $data_de_saida));
                        $result=db_query($query, $query__p);
                        }
                  }

//	if ($_POST['status_usuario']=='Aluno')
	if ($status_usuario=='student')
		{ //dia_dois,mes_dois,ano_dois,especialidade,prof_orientador
		if (str_replace("/", "", $_POST['matricul'])==$matricul_atual)
			{
			$data_saida=$_POST['ano_dois'].$_POST['mes_dois'].$_POST['dia_dois'];
if($_POST['situacao']=="nao_modifica") $situacao=$_POST['situacao1']; else $situacao=$_POST['situacao'];
			list($query_student, $query_student__p) = array("update student set depart_date1=?, speciality=?,orientateur=?,bolsista=?, status=? where matricul=?", array($data_saida, $especialidade, $prof_orientador, $bolsista, $situacao, $matricul_atual));
			$result_student=db_query($query_student, $query_student__p);
			}
		else
			{
			// novo student;  "ver data de inicio"
			if ($_POST['tipo_contrato']=="doutorado") $periodo="4 anos";
			if (($_POST['tipo_contrato']=="mestrado") or ($_POST['tipo_contrato']=="profmat")) $periodo="2 anos";
			if ($_POST['tipo_contrato']=="graduacao") $periodo="06 meses";
			if ($_POST['tipo_contrato']=="especializacao") $periodo="1 ano";
			if ($_POST['tipo_contrato']=="verao") $periodo="30 dias";

        		$data_entrada=$_POST['ano_novo']."-".$_POST['mes_novo']."-".$_POST['dia_novo'];
        		$data_saida= gera_data_saida($_POST['dia_novo'],$_POST['mes_novo'],$_POST['ano_novo'],$periodo);
        		list($query, $query__p) = array("insert into student values(?,?,?,?,?,'ativo',?,?,?)", array($usuario_a_mudar, $data_entrada, $data_saida, $especialidade, $prof_orientador, $_POST['tipo_contrato'], $bolsista, str_replace("/", "", $_POST['matricul'])));
        		$result=db_query($query, $query__p);
        		db_free_result($result);
			}
//		db_free_result($result);
		}
//	if ($_POST['status_usuario']=='Visitante')
	if ($status_usuario=='visitor')
		{
		if (!empty($_POST['dia_novo']) and !empty($_POST['mes_novo']) and !empty($_POST['ano_novo']))
			{
		   	$data_entrada=$_POST['ano_novo']."-".$_POST['mes_novo']."-".$_POST['dia_novo'];
		        $data_saida= gera_data_saida($_POST['dia_novo'],$_POST['mes_novo'],$_POST['ano_novo'],"30 dias");
			list($query_visitor, $query_visitor__p) = array("insert into visitor values(?,?,?,?,?)", array($usuario_a_mudar, $data_entrada, $data_saida, $tipo_contrato, $especialidade));
			$result_visitor=db_query($query_visitor, $query_visitor__p);
			db_free_result($result_visitor);
			}
		else
			{//dia_dois,mes_dois,ano_dois
			$data_saida=$_POST['ano_dois'].$_POST['mes_dois'].$_POST['dia_dois'];
			list($query_visitor, $query_visitor__p) = array("update visitor set date_end=?,area_atuacao=? where coduser=?", array($data_saida, $especialidade, $usuario_a_mudar));
			$result_visitor=db_query($query_visitor, $query_visitor__p);
			db_free_result($result_visitor);
			}
		}

	$coduser=$usuario_a_mudar;
	}
?>
    <tr>
      <td align=center>
        <table class=form>
        <tr>
          <td class=header align=center>Modifica&ccedil;&otilde;s :</td>
        </tr>
        <tr>
          <td>As informa&ccedil;&otilde;es foram modificadas com sucesso<br>
        </td>
        </tr>
        </table>
      </td>
    </tr>
<?php
   }
//   else
   if ($count==0)
   {
     $compte=new c_user;
     $compte->set_name       ($_POST['name']       ) ;
     $compte->set_firstname  ($_POST['firstname']  ) ;
     $compte->set_matricul   (str_replace("/", "", $_POST['matricul'])   ) ;
     $compte->set_cpf        ($_POST['cpf']        ) ;
     $compte->set_identity   ($_POST['identity']   ) ;
     $compte->set_phone_home ($_POST['phone_home'] ) ;
     $compte->set_phone_work ($_POST['phone_work']   ) ;
     $compte->set_adresse    ($_POST['adresse']    ) ;
     $compte->set_cp         ($_POST['cp']         ) ;
     $compte->set_city       ($_POST['city']       ) ;
     $compte->set_status_usuario    ($_POST['status_usuario'] ) ;
     $compte->set_coduser($compte->add_user ());
     if (!empty($_POST['mail1']))
	{
     list($query, $query__p) = array("insert into mail values(?,?)", array($_POST['mail1'], $compte->get_coduser()));
     $result=db_query($query, $query__p);
     db_free_result($result);
	}
	if (!empty($_POST['mail2']))
	{
       list($query, $query__p) = array("insert into mail values(?,?)", array($_POST['mail2'], $compte->get_coduser()));
       $result=db_query($query, $query__p);
       db_free_result($result);
	}
	if (!empty($_POST['mail3']))
	{
       list($query, $query__p) = array("insert into mail values(?,?)", array($_POST['mail3'], $compte->get_coduser()));
       $result=db_query($query, $query__p);
	}
	if (!empty($_POST['mail4']))
	{
       list($query, $query__p) = array("insert into mail values(?,?)", array($_POST['mail4'], $compte->get_coduser()));
       $result=db_query($query, $query__p);
	}

//novo visitante
     if ($_POST['status_usuario']=="visitor")
        {
	$data_entrada=$_POST['ano_dois']."-".$_POST['mes_dois']."-".$_POST['dia_dois'];
        $data_saida= gera_data_saida($_POST['dia_dois'],$_POST['mes_dois'],$_POST['ano_dois'],"30 dias");
	list($query, $query__p) = array("insert into visitor values(?,?,?,?,?)", array($compte->get_coduser(), $data_entrada, $data_saida, $_POST['tipo_contrato'], $_POST['especialidade']));
	$result=db_query($query, $query__p);
	db_free_result($result);
	}
// novo fonctionnaire
     if (($_POST['status_usuario']=="professor") or ($_POST['status_usuario']=="administrativo"))
        {
//         if (($_POST['tipo_contrato']=="dedicacao exclusiva") or ($_POST['tipo_contrato']=="professor associado")) $periodo="35 anos";
         if ($_POST['tipo_contrato']=="dedicacao exclusiva") $periodo="35 anos"; //corrigido em 18/10/2018
	 if ($_POST['tipo_contrato']=="pesquisador associado") $periodo="10 anos"; //corrigido em 18/10/2018
	 if ($_POST['tipo_contrato']=="professor voluntario") $periodo="2 anos"; //corrigido em 18/10/2018
         if (($_POST['tipo_contrato']=="prestador servico") or ($_POST['tipo_contrato']=="substituto ms20") or ($_POST['tipo_contrato']=="substituto ms40") or ($_POST['tipo_contrato']=="substituto gr40") or ($_POST['tipo_contrato']=="substituto dr40")) $periodo="2 anos";
         if ($_POST['tipo_contrato']=="estagiario grad") $periodo="06 meses";
         if ($_POST['tipo_contrato']=="estagiario tec") $periodo="1 ano";
         $data_entrada=$_POST['ano_dois']."-".$_POST['mes_dois']."-".$_POST['dia_dois'];
	 $data_de_saida= gera_data_saida($_POST['dia_dois'],$_POST['mes_dois'],$_POST['ano_dois'],$periodo);
         list($query, $query__p) = array("insert into fonctionnaire values(?,?,?,?,?)", array($compte->get_coduser(), $data_entrada, $_POST['tipo_contrato'], $_POST['status_usuario'], $data_de_saida));
         $result=db_query($query, $query__p);
//       db_free_result($result);
	 if ($_POST['status_usuario']=="professor")
	    {
	    //if(($_POST['tipo_contrato']=="dedicacao exclusiva") or ($_POST['tipo_contrato']=="professor associado")) $orientateur='true'; else $orientateur='false';
	if(($_POST['tipo_contrato']=="dedicacao exclusiva") or ($_POST['tipo_contrato']=="pesquisador associado")) $orientateur='true'; else $orientateur='false'; //corrigido em 18/10/2018
             list($query_profs, $query_profs__p) = array("insert into profs values(?,?,?,?,?,'ativo')", array($compte->get_coduser(), $orientateur, $_POST['especialidade'], $_POST['nivel_funcional'], $_POST['bolsista']));
             $result_profs=db_query($query_profs, $query_profs__p);
	     // acrescentado em 18/10/2018
//       var_dump($_POST); 
		if($_POST['credencia_nivel']!="nulo")
			{
//			$data_credencia=$_POST['data_credencia_orientador'];
//var_dump($data_credencia);
			$data_cred_ini=$_POST['cred_ano']."-".$_POST['cred_mes']."-".$_POST['cred_dia'];
		        $data_cred_fim= gera_data_saida($_POST['cred_dia'],$_POST['cred_mes'],$_POST['cred_ano'],"5 anos");
			list($query_credencia, $query_credencia__p) = array("insert into orientateur values(?,?,?,?)", array($compte->get_coduser(), $data_cred_ini, $data_cred_fim, $_POST['credencia_nivel']));
echo $query_credencia;
		        $result_credencia=db_query($query_credencia, $query_credencia__p);
			}
		// fin acrescimo 18/10/2018
	     }
         }
// novo student
     if ($_POST['status_usuario']=="student")
        {
	if ($_POST['tipo_contrato']=="doutorado") $periodo="4 anos";
	if (($_POST['tipo_contrato']=="mestrado") or ($_POST['tipo_contrato']=="profmat")) $periodo="2 anos";
	if ($_POST['tipo_contrato']=="graduacao") $periodo="06 meses";
	if ($_POST['tipo_contrato']=="especializacao") $periodo="1 ano";
	if ($_POST['tipo_contrato']=="verao") $periodo="30 dias";

        $data_entrada=$_POST['ano_dois']."-".$_POST['mes_dois']."-".$_POST['dia_dois'];
        $data_saida= gera_data_saida($_POST['dia_dois'],$_POST['mes_dois'],$_POST['ano_dois'],$periodo);
        list($query, $query__p) = array("insert into student values(?,?,?,?,?,'ativo',?,?,?)", array($compte->get_coduser(), $data_entrada, $data_saida, $_POST['especialidade'], $_POST['prof_orientador'], $_POST['tipo_contrato'], $_POST['bolsista'], str_replace("/", "", $_POST['matricul'])));
        $result=db_query($query, $query__p);
        db_free_result($result);
        }
	$coduser=$compte->get_coduser();
?>
    <tr>
      <td align=center>

       Por favor, escolha um<b>Nome de usuario</b>:
        <input type=text name='login' maxlength=10 onkeypress="return verif_log(event);">
      </td>
    </tr>
<?php
/*
     <tr>
      <td align=center>
        Uma <b>Senha</b>:
        <input type=password name=pass1 maxlength=8>
        e <b>confirme</b> :
        <input type=password name=pass2 maxlength=8>
      </td>
    </tr> 
*/ 
?>
    <tr>
      <td align=center>
        <input type=submit value='Cadastrar'>
      </td>
    </tr> 
        </table>
      </td>
    </tr>

<?php
}
  //  if (isset($_POST['unix']))
    {
?>
    <input type=hidden value='un_prec' name='un_prec'>
<?php
    }
?>
    <input type=hidden name='coduser' value="<?php echo $coduser ?>"> 
    <input type=hidden name='status_usuario' value="<?php echo $_POST['status_usuario'] ?>" >
    <input type=hidden name='tipo_contrato' value="<?php echo $_POST['tipo_contrato'] ?>" >
  </form>
  </table>
  </body>
</html>
<?php
//  }
  db_close($idconn);
?>
