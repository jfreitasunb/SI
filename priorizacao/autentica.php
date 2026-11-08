<?php
// Paginas desta pasta so podem ser usadas apos a autenticacao em prioriza_licencas.php,
// que guarda o coduser do professor na sessao.
require_once(dirname(__FILE__).'/../global/sessao_cookie.php');
if (session_status() == PHP_SESSION_NONE) session_start();
if (empty($_SESSION['priori_coduser'])) {
   die("Acesso negado. Fa&ccedil;a login em prioriza_licencas.php.");
}
// CSRF: o token e emitido em prioriza_licencas.php e injetado nos formularios.
require_once(dirname(__FILE__).'/../global/function_php.php');
csrf_valida();
csrf_token();
ob_start('csrf_injeta');
?>
