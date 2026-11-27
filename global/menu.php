<?php
   require_once(dirname(__FILE__).'/sessao_cookie.php');
   session_start();
   include("function_php.php");

   $idconn = db_connect();
   $idmodule = isset($idmodule) ? $idmodule : null;

   if (isset($_POST['login']) && isset($_POST['pass'])) {
       $identification = secure($_POST['login'], $_POST['pass'], $idmodule);
   } else {
       // Sessao existente: autenticacao validada pela flag de sessao + vinculo de IP.
       $identification = secure('', '', $idmodule);
   }

   if (!$identification)
   {
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <script>
    window.top.location.href = "../index.php";
  </script>
</head>
<body></body>
</html>
<?php
       exit; // Previne vazamento de informações da tela
   }

   csrf_token();
   $idconn = null;
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Menu — SI</title>
  <script src="menu2.js"></script>
  <link type="text/css" rel="stylesheet" href="grafic.css?v=<?php echo (int)@filemtime(__DIR__ . '/grafic.css'); ?>">
</head>
<body>
  <table class="big">
    <tr>
      <td class="header">
        <h1 align="center">Menu</h1>
      </td>
    </tr>
    <tr valign="top">
      <td>
        <p>
          <a href="accueil.php" target="right" class="menu"><b>Página principal</b></a>
        </p>
        <form method="post" action="logout.php" target="_top" style="margin: 8px 0 12px;">
          <?php echo csrf_campo(); ?>
          <button type="submit">Sair</button>
        </form>
        <script>
          if (parent && parent.menu && typeof Aff === 'function') {
            Aff(parent.menu);
          }
        </script>
      </td>
    </tr>
  </table>
</body>
</html>
