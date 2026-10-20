<?php
   require_once(dirname(__FILE__).'/sessao_cookie.php');
   session_start();
   include("function_php.php");

   // Conexão com o banco de dados (PDO)
   $idconn = db_connect();

   $idmodule = isset($idmodule) ? $idmodule : null;
   $sess_login = isset($_SESSION['login']) ? $_SESSION['login'] : '';

   // Checa a identificação (sessao existente: flag + vinculo de IP).
   $identification = secure('', '', $idmodule);
   if (!$identification)
   {
?>
     <script language="javascript">
       document.location.href="../index.php"
     </script>
<?php
       exit; // Bloqueia o carregamento do resto da página
   }
?>
<html>
  <head>
    <link type="text/css" rel="stylesheet" href="grafic.css">    
  </head>
  <body>
    <table class="big">
    <tr>
      <td class="header" align="center">
        <h1>P&aacute;gina principal:</h1>
      </td>
    </tr>
<?php
  // PDO: Utilizando Prepared Statements
  $query = "SELECT m.name, m.descr FROM module m, permission p WHERE m.idmodule=p.idmodule AND p.login = :login AND p.permission > 0";
  try {
      $stmt = $idconn->prepare($query);
      $stmt->execute([':login' => $sess_login]);
      $modules = $stmt->fetchAll(PDO::FETCH_ASSOC);
  } catch (PDOException $e) {
      die(error());
  }
?>
    <tr>
      <td align="center" valign="top"><br>
<?php
      // Substituição do for + pg_fetch_array por um foreach limpo
      foreach ($modules as $tab)
      {
?>
        <br>
        <table class="form" align="center" width="60%">
        <tr>
          <td class="header" align="center">
            <b><?php echo mb_convert_encoding($tab['name'], "HTML-ENTITIES", "auto").' : ' ?></b>
          </td> 
        </tr>
        <tr>
          <td class="data">
            <?php echo mb_convert_encoding($tab['descr'], "HTML-ENTITIES", "auto"); ?>
          </td> 
        </tr>
        </table>
<?php
      }  
?> 
       </td>
    </tr>
    </table>
  </body> 
</html>
<?php
  // Fechando conexão PDO
  $idconn = null;
?>