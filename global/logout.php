<?php
require_once(dirname(__FILE__) . '/sessao_cookie.php');
session_start();
require_once(dirname(__FILE__) . '/function_php.php');

exige_post();
csrf_valida();
destroy_session_completa();

header('Location: ../index.php', true, 302);
exit;
