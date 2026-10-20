<?php
  require("head_account.php");

  $queryverif2="select * from unix where login=?"; $queryverif2__p = array($_POST['login']);
  $resverif2=db_query($queryverif2, $queryverif2__p);
  $countverif2=db_num_rows($resverif2);
  $confere_senha=db_fetch_array($resverif2); //// teste 13:34 Cristiano

//  if ( ($countverif1==0)&&($countverif2==0)&&($countverif3==0) )
  if ($countverif2==0)
    {$verifbool=true;}
  else
    {$verifbool=false;}

  $query_tabela_user="select tipo_users from users where coduser=?"; $query_tabela_user__p = array($_POST['coduser']);
  $result_tabela_user=db_query($query_tabela_user, $query_tabela_user__p);
  $result_tabela_user1=db_fetch_array($result_tabela_user,0);

	if ($_POST['cota_mail']=='nao_modifica') {$cota_mail=$_POST['cota_mail1'];} else {$cota_mail=$_POST['cota_mail'];}
	if ($_POST['cota_disco']=='nao_modifica') {$cota_disco=$_POST['cota_disco1'];} else {$cota_disco=$_POST['cota_disco'];}
	if ($_POST['ssh']=='nao_modifica') {$ssh=$_POST['ssh1'];} else {$ssh=$_POST['ssh'];}

//  if ( (!empty($_POST['un_prec']))&& $verifbool)

  if (!$verifbool)
  {
	$query_confere_senha="select passwd from unix where coduser=?"; $query_confere_senha__p = array($_POST['coduser']);
	$confere_senha=db_query($query_confere_senha, $query_confere_senha__p);
	$confere_senha_array=db_fetch_array($confere_senha,0);


    $compte2= new c_conta_unix;
    $compte2->set_login($_POST['login']);
    $compte2->set_passwd0($_POST['pass0']);
    $compte2->set_passwd($_POST['pass1']);
    $compte2->set_cota_impressao     ($_POST['cota_impressao']);
    $compte2->set_cota_disco     ($cota_disco);
    $compte2->set_cota_mail     ($cota_mail);
//    $compte2->set_senha_nova_2     ($_POST['gid']);
//    $compte2->set_class   ($_POST['class']);
//    $compte2->set_change  ($_POST['change']);
//    $compte2->set_expire  ($_POST['expire']);
//    $compte2->set_gecos   ($_POST['gecos']);
//    $compte2->set_homedir ($_POST['homedir']);
//    $compte2->set_shell   ($_POST['shell']);
//     $compte2->set_coduser ($_POST['coduser']);
     $compte2->set_coduser ($_POST['coduser']);
     $compte2->set_tabela_user ($result_tabela_user1[0]);
    $compte2->set_ssh     ($ssh);
     $compte2->update_account();

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
		if  (crypt($_POST['pass0'],$confere_senha_array[0])==$confere_senha_array[0])
         		echo "<td class=header align=center>A conta foi alterada com sucesso: </td>";
		else
			echo "<td class=header align=center>A conta foi alterada com sucesso, a senha n&atilde;o foi alterada. </td>";
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
