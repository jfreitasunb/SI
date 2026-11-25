<?php
  require("head_account.php");
  exige_post();

  $coduser_alvo = coduser_sessao();
  if ($coduser_alvo === null) {
      die(error("Sessao invalida."));
  }

  $queryverif2="select * from unix where coduser=?"; $queryverif2__p = array($coduser_alvo);
  $resverif2=db_query($queryverif2, $queryverif2__p);
  $countverif2=db_num_rows($resverif2);

  if ($countverif2==0)
    {$verifbool=true;}
  else
    {$verifbool=false;}

  $query_tabela_user="select tipo_users from users where coduser=?"; $query_tabela_user__p = array($coduser_alvo);
  $result_tabela_user=db_query($query_tabela_user, $query_tabela_user__p);
  $result_tabela_user1=db_fetch_array($result_tabela_user,0);

	if ($_POST['cota_mail']=='nao_modifica') {$cota_mail=$_POST['cota_mail1'];} else {$cota_mail=$_POST['cota_mail'];}
	if ($_POST['cota_disco']=='nao_modifica') {$cota_disco=$_POST['cota_disco1'];} else {$cota_disco=$_POST['cota_disco'];}
	if ($_POST['ssh']=='nao_modifica') {$ssh=$_POST['ssh1'];} else {$ssh=$_POST['ssh'];}

  $senha_alterada = false;
  if (!$verifbool)
  {
    $compte2= new c_conta_unix;
    $compte2->set_login($_SESSION['login']);
    $compte2->set_passwd0(isset($_POST['pass0']) ? (string)$_POST['pass0'] : '');
    $compte2->set_passwd(isset($_POST['pass1']) ? (string)$_POST['pass1'] : '');
    $compte2->set_cota_impressao     ($_POST['cota_impressao']);
    $compte2->set_cota_disco     ($cota_disco);
    $compte2->set_cota_mail     ($cota_mail);
    $compte2->set_coduser ($coduser_alvo);
    $compte2->set_tabela_user ($result_tabela_user1[0]);
    $compte2->set_ssh     ($ssh);
    $senha_alterada = $compte2->update_account();
  }
?>
<html>
  <header>
    <link type="text/css" rel="stylesheet" href="../../global/grafic.css">
  </header>
  <body>
    <table class=big>
    <tr>
      <td class=header align=center>
        <h1>Cria&ccedil;&atilde;o da conta</h1>
      </td>
    </tr>
    <tr>
     <td align=center>
       <table class=form>
       <tr>
<?php
///////////////////////////

	//if ((!empty($this->passwd)) and (crypt($this->passwd0)==$confere_senha_array[0]))
///////////////////////////

       if ($verifbool)
         echo "<td class=header align=center>Imposs&iacute;vel criar a conta: cadastrar o novo usu&aacute;rio </td>";
       else
		{
		if ($senha_alterada)
         		echo "<td class=header align=center>A conta foi alterada com sucesso. </td>";
		else
			echo "<td class=header align=center>A senha n&atilde;o foi alterada. </td>";
		}
?>
       </tr>
       <tr>
         <td align=center>
         </td>
       </tr>
       </table>
     </td>
    </tr>
    </table>
  </body>
</html>
<?php
  db_close($idconn);
?>
