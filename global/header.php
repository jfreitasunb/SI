<?php
   require_once(dirname(__FILE__).'/sessao_cookie.php');
   session_start();
   include("function_php.php");

   $idconn = db_connect();
   $idmodule = isset($idmodule) ? $idmodule : null;

   // Protecao CSRF: valida o token em qualquer POST antes de processar a requisicao.
   csrf_valida();

   if (isset($_POST['login']) && isset($_POST['pass'])) {
       $identification = secure($_POST['login'], $_POST['pass'], $idmodule);
   } else {
       // Sessao existente: autenticacao validada pela flag de sessao + vinculo de IP.
       $identification = secure('', '', $idmodule);
   }

   if (!$identification)
   {
?>
     <script language="javascript">
       document.location.href="../../global/accueil.php"
     </script>
<?php
       exit;
   }

   // Usuario autenticado: garante o token e injeta o campo oculto em todo
   // <form method=post> da pagina automaticamente (synchronizer token).
   csrf_token();
   ob_start('csrf_injeta');
?>