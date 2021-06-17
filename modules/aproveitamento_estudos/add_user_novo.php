<?php
  include("head_aproveitamento.php");
?>
<html>
  <header>

   <script language="javascript">
    function verif_touche(e)
        {
        if(e.keyCode)touche = e.keyCode;
        else touche = e.which;
        if((touche>=48 && touche <= 57) || (touche==8) || (touche==9)) return true;
        else return false;
        }


function verif_mail(mail)
{
        if(mail=="")return "";
         var valide=true;
        var i=0;
         while((i<mail.length) && (valide))
        {
                if( (mail.charAt(i)=="'")||(mail.charAt(i)==",")||(mail.charAt(i)=="<E9>")||(mail.charAt(i)=="<E8>")||(mail.charAt(i)=="~"))
                {
                        valide=false;
                }
                i++;
        }
         if(!valide)
        {
                alert("E-mail invalido");
                return "";
        }
         if((mail.indexOf(".")==-1)||(mail.indexOf("@")==-1))
        {
                alert("E-mail invalido");
                return "";
        }
        return mail;
}

function prem_lettre_majuscule(chaine)
{
         var nouveau = chaine.charAt(0).toUpperCase();
         var i;
         for (i=1;i<chaine.length;i++)
         {
                nouveau = nouveau + chaine.charAt(i);
         }
         return nouveau;
}
    </script>
    <script language=javascript src="function_js.js">
    </script>
    <script language=javascript src="formu.js">
    </script>
    <link type="text/css" rel="stylesheet" href="../../global/grafic.css">
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
  </header>
  <body>
      <table class=big>

<?php
if (!isset($_POST['incluir']))
{
?>
  <form method="POST" name="formu" action="add_user_novo.php"  onsubmit="return valid_form()">
      <tr>
        <td class=header align=center>
          <h1>Inclus&atilde;o de Processos de Aproveitamento de Estudos</h1>
        </td>
      </tr>
      <tr>
        <td align=center><table class=form><tr>
    <td colspan=4 class=header align=center>
      <b>Dados Pessoais do aluno:</b></td>
          </tr>
	<tr><td><b>UnBDoc: </b><blink><?php echo $mensagem2;?><?php echo $mensagem4;?></blink></
td><td> <input type="text" name='unbdoc' size=6 onkeypress="return verif_touche(event);"  />/
        <select name='ano_unbdoc'>
<?php
        $ano_atual=date(Y);
        $ano_fim=$ano_atual+2;
	$ano_inicio=$ano_atual-2;
        for ($indice_ano=$ano_inicio;$indice_ano<$ano_fim+1;$indice_ano++)
                {
                if ($indice_ano==$ano_atual) $selected="selected"; else $selected="";
                echo "<option value='".$indice_ano."' ".$selected." >".$indice_ano."</option>";
                }
?>      
        </select></td>
</tr>

          <tr>
            <td><b>Nome do aluno: </b></td><td colspan=3><input type=text name='nome' maxlength=300 size=60 onblur="this.value= prem_lettre_majuscule(this.value)" ></td>
          </tr>
          <tr>
            <td><b>Telefone do aluno: </b></td><td>(<input type=text name='indicativo_fone' maxlength=3 size=1 onkeypress="return verif_touche(event);">)<input type=text name='fone' maxlength=15 size=8 onkeypress="return verif_touche(event);">
            </td>
          </tr>
          <tr>
            <td><b>E-mail do aluno: </b></td><td><input type=text name='mail' maxlength=30 onblur="this.value=verif_mail(this.value)" ></td>
          </tr>
          <tr>
            <td><b>Matr&iacute;cula do aluno: </b></td>
            <td><input type=text name='matricula_1' maxlength=2 size=1 onkeypress="return verif_touche(event);">/<input type=text name='matricula_2' maxlength=10 size=6 onkeypress="return verif_touche(event);">
           </td>
	   <td><b>Op&ccedil;&atilde;o:</b><td><input type=text name='opcao' size='4' maxlength=6 onkeypress="return verif_touche(event);" ></td>
	</tr>
         </table>
	  </td>
	  </tr>
      <tr>
        <td align=center>
          <input type=submit name='incluir' value="Confirmar">
        </td>
      </form>
      </table>
  </body>
</html>
<?php
}

if (isset($_POST['incluir']))
{
$data_registro=date(Y)."-".date(m)."-".date(d);
$unbdoc=$_POST['unbdoc']."/".$_POST['ano_unbdoc'];
$matricula=$_POST['matricula_1']."/".$_POST['matricula_2'];
$fone=$_POST['indicativo_fone']."_".$_POST['fone'];

$teste_existe=pg_query("select unbdoc from aproveitamento_entrada where unbdoc='".$unbdoc."'");
$teste=pg_num_rows($teste_existe);

if ($teste==0) 
	{
	$registra_dados="insert into aproveitamento_entrada values(default,'".$data_registro."','".$_POST['nome']."','".$matricula."','".$fone."','".$_POST['mail']."','".$_POST['opcao']."','".$unbdoc."')";
//echo $registra_dados;
	$res_registra_dados=pg_query($registra_dados) or die ("problema de conexao com o banco");
	if ($res_registra_dados) echo "cadastro efetuado";
	}
	else echo "UnBDoc ja cadastrado";
}
  pg_close($idconn);
?>
