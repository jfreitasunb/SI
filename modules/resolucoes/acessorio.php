<?php //include("head_account.php");
$vetor_assinatura=pg_query("SELECT name, firstname,cargo,titulo FROM users,admin_assinatura WHERE coduser='".$assinante."' and id_assinatura = 
'".$assinatura."'");
$palavra_assinatura=pg_fetch_row($vetor_assinatura);
?>
