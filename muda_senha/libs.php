<?php

require_once("semestre.php");


# Essa biblioteca foi feita especialmente para o sistema da matematica
# Por Paulo Angelo Alves Resende <pa@mat.unb.br>
function pa_get_rel($id,$tabela,$cid,$clabel)
{
    

}

function pa_set_more($label,$notes,$turma)
{
  global $con;

  pg_exec("update turmas set tur_resultado_da='$label' where tur_id='$turma'");
  $q=pg_exec("select obs_obs from observacoes where obs_turma='$turma'");

  if(@pg_numrows($q)>0)
  {
  pg_exec("update observacoes set obs_obs='$notes' where obs_turma='$turma'");
   }else{
  pg_exec("insert into observacoes(obs_obs,obs_turma) values('$notes','$turma')");
   }
}

function pa_result($turma)
{
  global $con;

@$q=pg_exec("select tur_resultado_da from turmas where tur_id='$turma'");
return pg_result($q,0,0);
}

function pa_obs($turma)
{
  global $con;
@$q=pg_exec("select obs_obs from observacoes where obs_turma='$turma'");
return @pg_result($q,0,0);
}

function pa_html_select($name,$idd,$label,$table,$value,$js="",$where="")
{
 global $con;

 @$q=pg_exec("select $idd,$label from $table $where");
 
 echo '<select name="'.$name.'" '.$js.'>';
 echo '<option values="0">---===---</option>';
 for($i=0;$i<pg_numrows($q);$i++)
  {
   if($value==pg_result($q,$i,0))
    {
   echo '<option value="'.pg_result($q,$i,0).'" SELECTED>'.pg_result($q,$i,1).'</option>';
	}else{
   echo '<option value="'.pg_result($q,$i,0).'">'.pg_result($q,$i,1).'</option>';
	}
  }
 echo '</select>';
}

function pa_html_select_turmas($name,$value,$js="",$where="")
{
 global $con;

 $q=pg_exec("select tur_id,cur_descr,tur_turma from turmas,cursos $where order by cur_descr,tur_turma");

 echo '<select name="'.$name.'" '.$js.'>';
 echo '<option values="0">---===---</option>';
 for($i=0;$i<pg_numrows($q);$i++)
  {
   if($value==pg_result($q,$i,0))
    {
   echo '<option value="'.pg_result($q,$i,0).'" SELECTED>'.pg_result($q,$i,1).' - '.pg_result($q,$i,2).'</option>';
    }else{
   echo '<option value="'.pg_result($q,$i,0).'">'.pg_result($q,$i,1).' - '.pg_result($q,$i,2).'</option>';
	};
  }
 echo '</select>';

}


function pa_view_conf_turma($turma,$tipo,$data,$peso,$naval)
{
  global $con;

  $q=pg_exec("select ava_tipo,to_char(ava_data,'DDMMYY'),ava_peso from avaliacoes where ava_turma='$turma'");

  for($i=0;$i<pg_numrows($q);$i++)
  {
   $tipo[$i]=pg_result($q,$i,0);
   $data[$i]=pg_result($q,$i,1);
   $peso[$i]=pg_result($q,$i,2);
   }
   $naval=$i;
}


// Essa funcao inseri, atualiza ou apaga as avaliacoes
function pa_conf_turma($turma,$tipo,$data,$peso,$naval)
{
  global $con;

  $q=pg_exec("select ava_id from avaliacoes where ava_turma='$turma'");

  for($i=0;$i<pg_numrows($q) and $i<$naval;$i++)
  {
   pg_exec("update avaliacoes set ava_tipo='$tipo[$i]',ava_data=to_date('$data[$i]','DDMMYY'),ava_peso='$peso[$i]' where ava_ordem='$i' and ava_turma='$turma'");
   }

  for( ;$i<$naval;$i++)
   {
   pg_exec("insert into avaliacoes(ava_turma,ava_peso,ava_tipo,ava_ordem,ava_data) values('$turma','$peso[$i]','$tipo[$i]','$i',to_date('$data[$i]','DDMMYY'))");
  }

  for($i=$naval;$i<pg_numrows($q);$i++)
  {
   pg_exec("delete from avaliacoes where ava_turma='$turma' and ava_ordem='$i'");
   }
}

// Essa funcao recebe um array com as notas dos alunos
// Ela deve inserir ou atualizar as notas dos alunos
function pa_set_notas($notas,$turma,$avaliacao=0)
{
  global $con;

  if($avaliacao!=0)
   {
    $quer=pg_exec("select ctur_aluno from comp_turmas where ctur_turma = '$turma'  order by alu_matr_data,alu_matr_num");
    for($i=0;$i<pg_numrows($quer);$i++)
    {
	$aluno=pg_result($quer,$i,0);
	  $qq=pg_exec("select not_id from notas where not_aluno='$aluno' and not_avaliacao='$avaliacao'");

	  if(@$not_id=pg_result($qq,0,0))
           {
	     $nota_n=$notas[$aluno][$avaliacao];
             pg_exec("update notas set not_nota = '$nota_n'  where not_id='$not_id'");

            if(strlen($notas[$aluno][$avaliacao])==0)
	    pg_exec("delete from notas where not_id='$not_id'") ;

           } else {
            if(strlen($notas[$aluno][$avaliacao])==0)
	    continue;

	  $not_nota= $notas[$aluno][$avaliacao];
         pg_exec("insert into notas(not_turma,not_avaliacao,not_nota,not_aluno) values('$turma','$avaliacao','$not_nota','$aluno')");
           }
    $ctur_mencao=$notas[$aluno][MENCAO];
    $ctur_media=$notas[$aluno][MEDIA];
    $ctur_faltas=$notas[$aluno][FALTAS];
    pg_exec("update comp_turmas set ctur_mencao='$ctur_mencao',ctur_media='$ctur_media',ctur_faltas='$ctur_faltas' where ctur_aluno='$aluno' and ctur_turma='$turma'");
	}
$q_ava=pg_exec("select ava_id from avaliacoes where ava_turma='$turma'");
for($w=0;$w<pg_numrows($q_ava);$w++)
{
$ava_now=pg_result($q_ava,$w,0);
$ava_d=($notas[SHARE][$ava_now]==1)? 1 : 0 ;
pg_exec("update avaliacoes set ava_divulgar='$ava_d' where ava_id='$ava_now'");
}

   }else{
    $quer=pg_exec("select ctur_aluno from comp_turmas where ctur_turma = '$turma'  order by alu_matr_data,alu_matr_num");
    for($i=0;$i<pg_numrows($notas);$i++)
    {
	$aluno=pg_result($quer,$i);
       for($c=0;$c<(sizeof($notas[$aluno])-2);$c++)
       {

         $ordem=$c;
	  $q_ava=pg_exec("select ava_id from avaliacoes where ava_turma='$turma' and not_ordem='$ordem'");
          $ava_now=pg_result($q_ava,0,0);
	  $qq=pg_exec("select not_id from notas where not_aluno='$aluno' and not_turma='$turma' and not_avaliacao='$ava_now'");

          
	  if(! @$not_id=pg_result($qq,0))
           {
             pg_exec("update notas set not_nota = '$notas[$aluno][$ava_now]' where not_id='$not_id'");
            if(strlen($notas[$aluno][$ava_now])==0)
	    pg_exec("delete from notas where not_id='$not_id'") ;

           } else {
            if(strlen($notas[$aluno][$ava_now])==0)
	    continue;

          pg_exec("insert into notas(not_avaliacao,not_nota,not_aluno) values('$ava_now','$notas[$aluno][$ava_now]','$aluno')");
           }
	}
    }
   }

   $ctur_mencao_d=($notas[SHARE][MENCAO]==1)? 1 : 0 ;
   $ctur_media_d=($notas[SHARE][MEDIA]==1)? 1 : 0 ;;
   $ctur_faltas_d=($notas[SHARE][FALTAS]==1)? 1 : 0 ;;
 pg_exec("update turmas set tur_mencao_divulgar='$ctur_mencao_d', tur_media_divulgar='$ctur_media_d', tur_faltas_divulgar='$ctur_faltas_d'  where tur_id='$turma'");
}







// Cria estatisticas
function pa_create_est_form($turma)
{
  global $con;

 @$n_q=pg_exec("select count(ctur_aluno) from comp_turmas where ctur_turma='$turma'");
 @$ap_q=pg_exec("select count(ctur_aluno) from comp_turmas  where ctur_turma='$turma' and ctur_media >= '5'");

$ht='<table border="0" align="left">';
$ht.='<tr><td>';

    $ht.='<table border="1" align="left">';
    $ht.='<tr><td>';
    $ht.=pa_lang("N. Students");
    $ht.='</td><td>';
    $ht.=$n_stud=@pg_result($n_q,0,0);
    $ht.='</td></tr><tr><td>';
    $ht.=pa_lang("Aprovados(EN?)");
    $ht.='</td><td>';
    $ht.=$n_now=@pg_result($ap_q,0,0);
    @$ht.='&nbsp;&nbsp;('.number_format(100*$n_now/$n_stud,2,",",".").'%)';
    $ht.='</td></tr>';
    $ht.='</table>';

$ht.='</td></tr><tr><td></td></tr><tr><td>';

$ht.='<table border="1" align="left">';
$ht.='<tr><td></td><td>';
$ht.=pa_lang("Avarage");
$ht.='</td><td>';
$ht.=pa_lang("Min");
$ht.='</td><td>';
$ht.=pa_lang("Max");
$ht.='</td><td>';
$ht.=pa_lang("StdDev");
$ht.='</td><td>';
$ht.=pa_lang("Variance");
$ht.='</td><tr>';

@$av_q=pg_exec("select ava_id,tava_descr from avaliacoes,tipo_avaliacoes where ava_turma='$turma' and ava_tipo=tava_id order by ava_ordem");

for($i=0;$i<@pg_numrows($av_q);$i++)
{
   $ava_now=pg_result($av_q,$i,0);

   $avg_q=pg_exec("select avg(not_nota) from notas 
   where not_turma='$turma' and not_avaliacao='$ava_now'");

   $min_q=pg_exec("select min(not_nota) from notas 
   where not_turma='$turma' and not_avaliacao='$ava_now'");

   $max_q=pg_exec("select max(not_nota) from notas 
   where not_turma='$turma' and not_avaliacao='$ava_now'");

   $stddev_q=pg_exec("select stddev(not_nota) from notas 
   where not_turma='$turma' and not_avaliacao='$ava_now'");

   $variance_q=pg_exec("select variance(not_nota) from notas 
   where not_turma='$turma' and not_avaliacao='$ava_now'");

 $ht.='<tr><td>&nbsp;';
 $ht.=pg_result($av_q,$i,1);
 $ht.='</td><td>&nbsp;';
 $ht.=number_format(pg_result($avg_q,0,0),2,",",".");
 $ht.='</td><td>&nbsp;';
 $ht.=number_format(pg_result($min_q,0,0),2,",",".");
 $ht.='</td><td>&nbsp;';
 $ht.=number_format(pg_result($max_q,0,0),2,",",".");
 $ht.='</td><td>&nbsp;';
 $ht.=number_format(pg_result($stddev_q,0,0),2,",",".");
 $ht.='</td><td>&nbsp;';
 $ht.=number_format(pg_result($variance_q,0,0),2,",",".");
 $ht.='</td></tr>';

}

   $ht.='</table>';
$ht.='</td></tr><tr><td></td></tr><tr><td>';

@$his_q=pg_exec("select ctur_mencao,count(ctur_aluno),avg(ctur_faltas),stddev(ctur_faltas) from comp_turmas  where ctur_turma='$turma' group by ctur_mencao");

$ht.='<table border="1" align="left" valign="botton">';
$ht.='<tr><td>'.pa_lang("Mencao(EN?)").'</td><td>'.pa_lang("Qt.").'</td><td>'.pa_lang("Falts(STDDEV)").'</td></tr>';
  for($i=0;$i<@pg_numrows($his_q);$i++)
  {
  $ht.='<tr><td>&nbsp;';
  $ht.=pg_result($his_q,$i,0);
  $ht.='</td><td>';
  $ht.=$n_now=pg_result($his_q,$i,1);
  $ht.='&nbsp;&nbsp;('.number_format(100*$n_now/$n_stud,2,",",".").'%)';
  $ht.='</td><td>';
  $ht.=pg_result($his_q,$i,2);
  $ht.='&nbsp;&nbsp;('.pg_result($his_q,$i,3).')';
  $ht.='</td><tr>';
  }
  $ht.='</table>';

$ht.='</td></tr></table>';

echo $ht;

// - Número de alunos
// - Número de Aprovados
// - Distribuição das notas (tipo)
// - Torda com distr das notas
// - Histograma (número de alunos X Nota)
// - Desempenho médio dos alunos entre as provas (Avaliacao X Desp. Medio)


}

// Essa funcao cria o relatorio a ser impresso
// Eh a lista impresa
function pa_create_report_p($turma)
{
  global $con;

 @$alu=pg_exec("select to_char(ctur_aluno,'0999999'),alu_nome from comp_turmas,alunos where ctur_aluno=alu_matr and ctur_turma='$turma' order by alu_matr_data,alu_matr_num");
 @$ava=pg_exec("select ava_id,tava_descr,ava_peso from avaliacoes,tipo_avaliacoes where ava_tipo=tava_id and ava_turma='$turma' order by ava_ordem ");

// for($i=0;$i<pg_numrows($ava);$i++)
// {
//  $av_now=pg_result($ava,$i,0);
//  $qn=pg_exec("select ava_divulgar from avaliacoes where ava_id='$av_now'");
//  $ava_d[$av_now]=pg_result($qn,0,0);
// }

//  $qn=pg_exec("select distinct(ctur_turma),ctur_media_divulgar,ctur_mencao_divulgar from comp_turmas where ctur_turma='$turma'");
//   $ava_d[MEDIA]=pg_result($qn,0,0);
//   $ava_d[MENCAO]=pg_result($qn,0,1);
 
 echo '<tr><td>';
 pa_create_est_form_num_st($turma);
 echo '</td></tr>';

 echo "<tr><td>".pa_lang("Number").'</td><td width="25%">'.pa_lang("Name").'</td>';
 for($i=0;$i<@pg_numrows($ava);$i++)
 {
 echo "<td>";
 echo pg_result($ava,$i,1);
 echo "</td>";
 }
 echo "<td>".pa_lang("Avarage")."</td><td>".pa_lang("Mencao(EN?)")."</td><td>".pa_lang("Falts(%)")."</td></tr>";

 for($i=0;$i<@pg_numrows($alu);$i++)
 {

  echo '<tr><td>';
  echo pg_result($alu,$i,0);
  echo '</td><td>';
  echo pg_result($alu,$i,1);
  echo '</td>';
  $alu_now=pg_result($alu,$i,0)*1;
$a=0;
   for($c=0;$c<($num_p=pg_numrows($ava));$c++)
   {
    $ava_now=pg_result($ava,$c,0);
    $nalu=pg_exec("select to_char(not_nota,'90D99') from notas where not_aluno='$alu_now' and not_turma='$turma' and not_avaliacao='$ava_now'");

  echo '<td>';
 echo (@pg_result($nalu,0,0)=="")? "&nbsp;" : @pg_result($nalu,0,0);
  echo '</td>';

   }

    $nalu=pg_exec("select to_char(ctur_media,'90D99'),ctur_mencao,ctur_faltas from comp_turmas where ctur_aluno='$alu_now' and ctur_turma='$turma'");
  echo '<td>';
echo (@pg_result($nalu,0,0)=="")? "&nbsp;" : pg_result($nalu,0,0) ;
  echo '</td>';
  echo '<td>&nbsp;';
echo (@pg_result($nalu,0,1)=="")? "&nbsp;" : pg_result($nalu,0,1) ;
  echo '</td>';
  echo '<td>';
echo (@pg_result($nalu,0,2)=="")? "&nbsp;" : pg_result($nalu,0,2) ;
  echo '</td>';
  echo '</tr>';
 }

// Parte onde fica as estatisicas :)
 
 $EST=pa_get_est_vet($turma);

for($a=0;$a<sizeof($EST[MEDIA]);$a++)
{
 echo '<tr><td>&nbsp;</td>';
  echo "<td>";
  echo $EST[MEDIA][$a][NAME];
  echo "</td>";

  for($i=0;$i<@pg_numrows($ava);$i++)
  {
  $ava_now=@pg_result($ava,$i,0);

  echo "<td>";
  echo $EST[$ava_now][$a];
  echo "</td>";
  }
 
  echo '<td>';
  echo $EST[MEDIA][$a][VALUE];
  echo '</td>';
  echo '<td>&nbsp;</td><td>&nbsp;</td></tr>';
}
 
echo '</table><br><br><br>';

pa_create_est_form_mencao($turma);
}

function pa_create_report_a($turma)
{
  global $con;

 $alu=pg_exec("select to_char(ctur_aluno,'0999999') from comp_turmas,alunos where ctur_aluno=alu_matr and ctur_turma='$turma' order by alu_matr_data,alu_matr_num");
 $ava=pg_exec("select ava_id,tava_descr,ava_peso from avaliacoes,tipo_avaliacoes where ava_tipo=tava_id and ava_turma='$turma' and ava_divulgar='true' order by ava_ordem ");

$dmm_q=pg_exec("select tur_mencao_divulgar,tur_media_divulgar,tur_faltas_divulgar,tur_resultado_da from turmas where tur_id='$turma'");

 @$men_d=pg_result($dmm_q,0,0);
 @$med_d=pg_result($dmm_q,0,1);
 @$faltas_d=pg_result($dmm_q,0,2);
 @$resultof=pg_result($dmm_q,0,3);

echo '<p><font face="Verdana, Arial, Helvetica, sans-serif" size="2"><b><font color="#FFCC66" size="1">&gt;</font><font color="#006699">';
echo pa_lang("Teacher's Notes:");
echo '</font></b></font><br>';
echo '<TEXTAREA rows="3" COLS="73">';
echo pa_obs($turma);
echo '</textarea></p>';

 echo '<table>';
 echo '<tr><td>';
 echo pa_lang("Result of:");
 echo '</td><td>';
 echo $resultof;
 echo '</td></tr>';
 echo '</table>' ;

 echo '  <table width="100%" border="0" align="center" cellpadding="0">';
 echo '    <tr bgcolor="#FFCC66">';
 echo '      <td width="135"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">'.pa_lang("Number").'</font></td>';
 for($i=0;$i<pg_numrows($ava);$i++)
 {
 echo '      <td width="146"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">';
 echo pg_result($ava,$i,1);
 echo '      </font></td>';
 }
 if($med_d=="t"){
 echo '      <td width="146"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">';
 echo pa_lang("Avarage");
 echo '      </font></td>';
 }
 if($men_d=="t"){
 echo '      <td width="146"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">';
 echo pa_lang("Mencao(EN?)");
 echo '      </font></td>';
 }
 if($faltas_d=="t"){
 echo '      <td width="146"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">';
 echo pa_lang("Falts");
 echo '      </font></td>';
 }
echo '</tr>';
 
 $d=0;
 for($i=0;$i<pg_numrows($alu);$i++)
 {

  if($d==1)
  {
   $d=0;
   $color='bgcolor="#CCCCCC"';
  }else{ 
   $d=1;
   $color='';
  }
  echo '<tr '.$color.'>';
  echo ' <td width="135"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">';
  echo pg_result($alu,$i,0);
  echo '</font></td>';
  $alu_now=pg_result($alu,$i,0)*1;
$a=0;
   for($c=0;$c<($num_p=pg_numrows($ava));$c++)
   {
    $ava_now=pg_result($ava,$c,0);
    $nalu=pg_exec("select to_char(not_nota,'90D99') from notas where not_aluno='$alu_now' and not_turma='$turma' and not_avaliacao='$ava_now'");

  echo '<td width="146"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">';
  echo (@pg_result($nalu,0,0)=="")? "&nbsp;" : pg_result($nalu,0,0) ;
  echo '</font></td>';

   }

    $nalu=pg_exec("select to_char(ctur_media,'90D99'),ctur_mencao,ctur_faltas from comp_turmas where ctur_aluno='$alu_now' and ctur_turma='$turma'");
if($med_d=="t"){
  echo '<td width="143"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">';
echo (@pg_result($nalu,0,0)=="")? "0" : @pg_result($nalu,0,0) ;
  echo '</font></td>';
}
if($men_d=="t"){
  echo '<td width="143"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">&nbsp;';
echo (@pg_result($nalu,0,1)=="")? "" : @pg_result($nalu,0,1) ;
  echo '</font></td>';
}
if($faltas_d=="t"){
  echo '<td width="143"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">&nbsp;';
echo (@pg_result($nalu,0,1)=="")? "0" : @pg_result($nalu,0,2) ;
  echo '</font></td>';
}
  echo '</tr>';

 }

 echo '    <tr bgcolor="#FFCC66">';
 echo '      <td width="135"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">'.pa_lang("Avarage").'</font></td>';
 for($i=0;$i<pg_numrows($ava);$i++)
 {
 $av_n= pg_result($ava,$i,0);
 $w=pg_exec(" select to_char(avg(not_nota),'9.99') from notas where not_avaliacao='$av_n'");
 echo '      <td width="146"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">';
 echo pg_result($w,0,0);
 echo '      </font></td>';
 }
 if($med_d=="t"){
 echo '      <td width="146"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">';
 echo pa_lang("Avarage");
 echo '      </font></td>';
 }
 if($men_d=="t"){
 echo '      <td width="146"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">';
 echo pa_lang("Mencao(EN?)");
 echo '      </font></td>';
 }
 if($faltas_d=="t"){
 echo '      <td width="146"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">';
 echo pa_lang("Falts");
 echo '      </font></td>';
 }
echo '</tr>';

echo '</table><br><br><br></div>';
}

// Autentica os usuarios prioritariamente no sistema
// Depois nas tabelas do banco
// Depois inseri os cookies necessarios (lang,id)
function pa_auth_user($user,$pass)
{
  global $con;

$auth_q=pg_exec("select pro_senha from professores where pro_login='$user'");

if($pass==@pg_result($auth_q,0,0) and pg_numrows($auth_q)>0 )
{
 @setcookie("user","$user","time()+36000","","mx1.mat.unb.br");
 @setcookie("pass","$pass","time()+36000","","mx1.mat.unb.br");
  return true ;
}else{
  return false ;
}
}

// Tira os cookies
function pa_deauth_user($user,$pass)
{
 setcookie("user","","time() - 3600","","mx1.mat.unb.br");
 setcookie("pass","","time() - 3600","","mx1.mat.unb.br");
}

// Traduz para a lingua de cada usuario
function pa_lang($word)
{
  global $lang;
  global $con;
  global $user;

if(!strlen($lang)>0)
{
 $lanop_q=pg_exec("select pro_lang from professores where pro_login='$user'");
 @$lang=pg_result($lanop_q,0,0);
}
 $word=str_replace("'","\'",$word);
 $lan_q=pg_exec("select lan_trad from lang where lan_en='$word' and lan_lang='$lang'");

  if(!@$w=pg_result($lan_q,0,0) or $lang=="")
  {
 $word=str_replace("\'","'",$word);
  return $word;
  }else{
  return $w;
  }
}

function pa_create_form($turma,$avaliacao)
{
  global $con;

 $alu=pg_exec("select to_char(ctur_aluno,'0999999'),alu_nome from comp_turmas,alunos where ctur_aluno=alu_matr and ctur_turma='$turma' order by alu_matr_data,alu_matr_num");
 $ava=pg_exec("select ava_id,tava_descr,ava_peso from avaliacoes,tipo_avaliacoes where ava_tipo=tava_id and ava_turma='$turma' order by ava_ordem ");

$dmm_q=pg_exec("select tur_mencao_divulgar,tur_media_divulgar,tur_faltas_divulgar from turmas where tur_id='$turma'");

 @$men_d=pg_result($dmm_q,0,0);
 @$med_d=pg_result($dmm_q,0,1);
 @$faltas_d=pg_result($dmm_q,0,2);


//  if((Math.ceil(num)-num)<0.1)
//  {
//   num = Math.ceil(num);
//  }
 echo '
<script>
function pa_round(num)
{
   num = num*100;
teste=num - Math.round(num);
if(teste>=0.499999) {
   num = num + 0.1
}
   num = Math.round(num) ;
   num = num/100;
   return num ;
}

function pa_cal_media(num_p,num_f)
{
   var media = 0 ;
   var pesot = 0 ;

   for(i=1 ; i <= num_p ; i=i+1 )
   {
     if ( i > 30 )
	{
	break;
	}
  m_n=1*5+i+1*num_p ;
  m_nn=i+1*num_f+1*1 ;
  media = document.form1.elements[m_n].value * document.form1.elements[m_nn].value + 1*media ;
  pesot = 1*document.form1.elements[m_n].value + 1*pesot ;
   }
 m_n=1*num_p+1*num_f+1*2;
 document.form1.elements[m_n].value = pa_round(media/pesot) ;

}

function pa_cal_mencao(num_f)
{
 var med;

 med=document.form1.elements[num_f*1 - 1*1].value;
 faltas=document.form1.elements[num_f*1 + 3*1].value;
num_f=num_f*1+1*1;
 if(med > 10) {
   document.form1.elements[num_f].value="XX";
  } else if(med >= 9) {
   document.form1.elements[num_f].value="SS";
  } else if(med >= 7) {
   document.form1.elements[num_f].value="MS";
  } else if(med >= 5) {
   document.form1.elements[num_f].value="MM";
  }  else if(med >= 3) {
   document.form1.elements[num_f].value="MI";
  }  else if(med > 0) {
   document.form1.elements[num_f].value="II";
  }  else if(med <= 0) {
   document.form1.elements[num_f].value="SR";
  }
 if(faltas>=25)
 {
   document.form1.elements[num_f].value="SR";
 }
}
</script>
      ';

 echo "<tr><td></td>";
 for($i=0;$i<pg_numrows($ava);$i++)
 {
  $av_now=pg_result($ava,$i,0);
  $qn=pg_exec("select ava_divulgar from avaliacoes where ava_id='$av_now'");
  $qn_v=(pg_result($qn,0,0)=="t")? "CHECKED" : "";

 echo "<td>".pa_lang("Share");
 echo '<input type="checkbox" '.$qn_v.' value="1" name="notas[SHARE]['.$av_now.']">';
 echo "</td>";
 }
   $qn_v=($med_d=="t")? "CHECKED" : "";
   $qn_vm=($men_d=="t")? "CHECKED" : "";
   $qn_vf=($faltas_d=="t")? "CHECKED" : "";
 echo "<td>".pa_lang("Share").'<input type="checkbox" '.$qn_v.' value="1" name="notas[SHARE][MEDIA]"></td><td>'.pa_lang("Share").'<input type="checkbox" '.$qn_vm.' value="1" name="notas[SHARE][MENCAO]"></td><td>'.pa_lang("Share").'<input type="checkbox" '.$qn_vf.' value="1" name="notas[SHARE][FALTAS]"> </td></tr>';

 //echo "<tr><td>".pa_lang("Number").'</td><td>'.pa_lang("Name").'</td>';
 echo "<tr><td>".pa_lang("Number").'</td>';
 for($i=0;$i<pg_numrows($ava);$i++)
 {
 echo "<td>";
 echo '<input type="hidden" name="notas[PESO]['.pg_result($ava,$i,0).']" value="'.pg_result($ava,$i,2).'">';
 echo pg_result($ava,$i,1);
 echo "</td>";
 }
 echo "<td>".pa_lang("Avarage")."</td><td>".pa_lang("Mencao(EN?)")."</td><td>".pa_lang("Falts(%)")."</td></tr>";

$num_f=pg_numrows($ava)*2+5;
 for($i=0;$i<pg_numrows($alu);$i++)
 {
  $media=0;
  $peso_sum=0;
  $media=$media+0;

  echo '<tr><td onclick="alert(\''.pg_result($alu,$i,1).'\');">';
  echo pg_result($alu,$i,0);
//  echo '</td><td>';
//  echo '<img src="imgs/nome.gif" alt="'.pg_result($alu,$i,1).'">';
  echo '</td>';
//  echo '</td><td>';
//  echo pg_result($alu,$i,1);
//  echo '</td>';
  $alu_now=pg_result($alu,$i,0)*1;
$a=0;
   for($c=0;$c<($num_p=pg_numrows($ava));$c++)
   {
    $ava_now=pg_result($ava,$c,0);
    $nalu=pg_exec("select to_char(not_nota,'90D99') from notas where not_aluno='$alu_now' and not_turma='$turma' and not_avaliacao='$ava_now'");

  if($ava_now==$avaliacao)
  {
	$a++;
  echo '<td bgcolor="gray">';
echo '<input tabindex="'.$a.'" type="text" value="'.trim(@pg_result($nalu,0,0)).'" size="5" maxlength="5" name="notas['.$alu_now.']['.$ava_now.']">';
  echo '</td>';
  }else{
  echo '<td>';
  echo '<input type="hidden" name="notas['.$alu_now.']['.$ava_now.']" value="'.@pg_result($nalu,0,0).'">';
  echo (@pg_result($nalu,0,0)=="")? "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" : pg_result($nalu,0,0) ;
  echo '</td>';
  }
$num_f++;
   }
    $nalu=pg_exec("select to_char(ctur_media,'90D99'),ctur_mencao,ctur_faltas from comp_turmas where ctur_aluno='$alu_now' and ctur_turma='$turma'");
  echo '<td>';
$num_f++;
echo '<input type="text" value="'.trim(@pg_result($nalu,0,0)).'" size="5" maxlength="5" name="notas['.$alu_now.'][MEDIA]">';
$num_f++;
$js_med.='   pa_cal_media("'.$num_p.'","'.($num_f-$num_p-1).'") ;  ';
echo '<input type="button" value="M" name="bot_med_'.$alu_now.'" onclick=\'pa_cal_media("'.$num_p.'","'.($num_f-$num_p-1).'") ; \' >';
  echo '</td>';
  echo '<td>';
$num_f++;
echo '<input type="text" value="'.trim(@pg_result($nalu,0,1)).'" size="3" maxlength="2" name="notas['.$alu_now.'][MENCAO]">';
$num_f++;
$js_men.='   pa_cal_mencao("'.$num_f.'") ;  ';
echo '<input type="button" value="M" name="bot_men_'.$alu_now.'" onclick=\'pa_cal_mencao("'.$num_f.'") ; \' >';
  echo '</td>';
  echo '<td>';
$num_f++;
echo '<input type="text" value="'.@pg_result($nalu,0,2).'" size="3" maxlength="3" name="notas['.$alu_now.'][FALTAS]">';
  echo '</td>';
  echo '</tr>';
 }

echo '<script>';
echo 'function pa_cal_all_med() {';
echo $js_med;
echo '};';
echo 'function pa_cal_all_men() {';
echo $js_men;
echo '};';
echo '</script>';
}



function pa_get_prof($user)
{
	global $con;

 $q=pg_exec("select pro_id from professores where pro_login='$user'");

 if(pg_numrows($q)==1)
  {
   return pg_result($q,0,0);
  }

 return "";

}

function pa_get_est_vet($turma)
{

 @$ava=pg_exec("select ava_id,tava_descr,ava_peso from avaliacoes,tipo_avaliacoes where ava_tipo=tava_id and ava_turma='$turma' order by ava_ordem ");

   for($c=0;$c<($num_p=@pg_numrows($ava));$c++)
   {
    $ava_now=pg_result($ava,$c,0);
    $nalu=pg_exec("select to_char(min(not_nota),'90D99'),to_char(max(not_nota),'90D99'),to_char(avg(not_nota),'90D99'),to_char(stddev(not_nota),'90D99') from notas where not_turma='$turma' and not_avaliacao='$ava_now'");


    $EST[$ava_now][0]=(@pg_result($nalu,0,0)=="")? "&nbsp;" : @pg_result($nalu,0,0);
    $EST[$ava_now][1]=(@pg_result($nalu,0,1)=="")? "&nbsp;" : @pg_result($nalu,0,1);
    $EST[$ava_now][2]=(@pg_result($nalu,0,2)=="")? "&nbsp;" : @pg_result($nalu,0,2);
    $EST[$ava_now][3]=(@pg_result($nalu,0,3)=="")? "&nbsp;" : @pg_result($nalu,0,3);
   }
    @$nalu=pg_exec("select to_char(min(ctur_media),'90D99'),to_char(max(ctur_media),'90D99'),to_char(avg(ctur_media),'90D99'),to_char(stddev(ctur_media),'90D99') from comp_turmas where ctur_turma='$turma'");
    $EST[MEDIA][0][NAME]=pa_lang("Min");
    $EST[MEDIA][1][NAME]=pa_lang("Max");
    $EST[MEDIA][2][NAME]=pa_lang("Avarage");
    $EST[MEDIA][3][NAME]=pa_lang("StdDev");

    $EST[MEDIA][0][VALUE]=(@pg_result($nalu,0,0)=="")? "&nbsp;" : @pg_result($nalu,0,0);
    $EST[MEDIA][1][VALUE]=(@pg_result($nalu,0,1)=="")? "&nbsp;" : @pg_result($nalu,0,1);
    $EST[MEDIA][2][VALUE]=(@pg_result($nalu,0,2)=="")? "&nbsp;" : @pg_result($nalu,0,2);
    $EST[MEDIA][3][VALUE]=(@pg_result($nalu,0,3)=="")? "&nbsp;" : @pg_result($nalu,0,3);
 return $EST;

}

// Cria estatisticas
function pa_create_est_form_num_st($turma)
{
  global $con;

 @$n_q=pg_exec("select count(ctur_aluno) from comp_turmas where ctur_turma='$turma'");
 @$ap_q=pg_exec("select count(ctur_aluno) from comp_turmas  where ctur_turma='$turma' and ctur_media >= '5'");


    $ht='<table border="1" align="left">';
    $ht.='<tr><td>';
    $ht.=pa_lang("N. Students");
    $ht.='</td><td>';
    $ht.=$n_stud=@pg_result($n_q,0,0);
    $ht.='</td></tr><tr><td>';
    $ht.=pa_lang("Aprovados(EN?)");
    $ht.='</td><td>';
    $ht.=$n_now=@pg_result($ap_q,0,0);
    @$ht.='&nbsp;&nbsp;('.number_format(100*$n_now/$n_stud,2,",",".").'%)';
    $ht.='</td></tr>';
    $ht.='</table>';

echo $ht;

}

function pa_create_est_form_mencao($turma)
{
  global $con;

 @$n_q=pg_exec("select count(ctur_aluno) from comp_turmas where ctur_turma='$turma'");
 $n_stud=@pg_result($n_q,0,0);

@$his_q=pg_exec("select ctur_mencao,count(ctur_aluno),avg(ctur_faltas),stddev(ctur_faltas) from comp_turmas  where ctur_turma='$turma' group by ctur_mencao");

$ht.='<table border="1" align="left" valign="botton">';
$ht.='<tr><td>'.pa_lang("Mencao(EN?)").'</td><td>'.pa_lang("Qt.").'</td><td>'.pa_lang("Falts(STDDEV)").'</td></tr>';
  for($i=0;$i<@pg_numrows($his_q);$i++)
  {
  $ht.='<tr><td>&nbsp;';
  $ht.=pg_result($his_q,$i,0);
  $ht.='</td><td>';
  $ht.=$n_now=pg_result($his_q,$i,1);
  $ht.='&nbsp;&nbsp;('.number_format(100*$n_now/$n_stud,2,",",".").'%)';
  $ht.='</td><td>';
  $ht.=pg_result($his_q,$i,2);
  $ht.='&nbsp;&nbsp;('.pg_result($his_q,$i,3).')';
  $ht.='</td><tr>';
  }
  $ht.='</table>';

echo $ht;
}

?>
