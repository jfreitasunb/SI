<?php
// Paginas desta pasta so podem ser usadas apos a autenticacao em prioriza_licencas.php,
// que guarda o coduser do professor na sessao.
if (session_status() == PHP_SESSION_NONE) session_start();
if (empty($_SESSION['priori_coduser'])) {
   die("Acesso negado. Fa&ccedil;a login em prioriza_licencas.php.");
}
?>
