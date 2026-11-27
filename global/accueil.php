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
       exit; // Bloqueia o carregamento do resto da página
   }

   // PDO: Utilizando Prepared Statements
   $query = "SELECT m.idmodule, m.name, m.descr FROM module m, permission p WHERE m.idmodule = p.idmodule AND p.login = :login AND p.permission > 0 ORDER BY m.name";
   try {
       $stmt = $idconn->prepare($query);
       $stmt->execute([':login' => $sess_login]);
       $modules = $stmt->fetchAll(PDO::FETCH_ASSOC);
   } catch (PDOException $e) {
       die(error());
   }

   // Busca as funcoes disponiveis de cada modulo para oferecer atalhos diretos nos cards
   $stmtFn = $idconn->prepare("SELECT funcurl, funcname FROM functions f WHERE f.idmodule = :idmodule ORDER BY f.funcname");
   $cards = array();
   $total_functions = 0;

   foreach ($modules as $mod) {
       try {
           $stmtFn->execute([':idmodule' => $mod['idmodule']]);
           $fns = $stmtFn->fetchAll(PDO::FETCH_ASSOC);
       } catch (PDOException $e) {
           die(error());
       }

       $safe_links = array();
       foreach ($fns as $fn) {
           $funcurl = (string)$fn['funcurl'];
           if (preg_match('/^\s*(javascript|data|vbscript):/i', $funcurl)) {
               continue;
           }
           $safe_links[] = array(
               'name' => $fn['funcname'],
               'url'  => $funcurl,
           );
       }

       $total_functions += count($safe_links);
       $cards[] = array(
           'name'  => $mod['name'],
           'descr' => $mod['descr'],
           'links' => $safe_links,
       );
   }

   $idconn = null;
   $total_modules = count($cards);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Página principal — SI</title>
  <link type="text/css" rel="stylesheet" href="grafic.css?v=<?php echo (int)@filemtime(__DIR__ . '/grafic.css'); ?>">
</head>
<body class="si-home-body">
  <div class="si-home-container">
    <section class="si-home-hero" aria-label="Boas-vindas">
      <div>
        <h1>Bem-vindo(a), <?php echo h($sess_login); ?></h1>
        <p>Selecione um módulo abaixo ou utilize o menu lateral para acessar as funcionalidades do sistema.</p>
      </div>
      <div class="si-home-stat">
        <span class="si-home-stat-num"><?php echo (int)$total_modules; ?></span>
        <span class="si-home-stat-label"><?php echo $total_modules === 1 ? 'módulo ativo' : 'módulos ativos'; ?></span>
      </div>
    </section>

    <?php if ($total_modules === 0): ?>
      <div class="si-empty-state">
        <h2>Nenhum módulo atribuído</h2>
        <p>Sua conta ainda não possui permissões de acesso a módulos. Entre em contato com o administrador do sistema.</p>
      </div>
    <?php else: ?>
      <section class="si-module-grid" aria-label="Módulos disponíveis">
        <?php foreach ($cards as $card): ?>
          <?php $fnCount = count($card['links']); ?>
          <article class="si-module-card">
            <div class="si-module-card-head">
              <h2 class="si-module-card-title"><?php echo h($card['name']); ?></h2>
              <?php if ($fnCount > 0): ?>
                <span class="si-module-badge">
                  <?php echo (int)$fnCount; ?> <?php echo $fnCount === 1 ? 'opção' : 'opções'; ?>
                </span>
              <?php endif; ?>
            </div>

            <?php if (trim((string)$card['descr']) !== ''): ?>
              <p class="si-module-card-desc"><?php echo h($card['descr']); ?></p>
            <?php endif; ?>

            <?php if ($fnCount > 0): ?>
              <div class="si-module-links">
                <?php foreach ($card['links'] as $link): ?>
                  <a
                    href="<?php echo h($link['url']); ?>"
                    class="si-module-link-pill"
                    data-si-quick-link="<?php echo h($link['url']); ?>"
                  ><?php echo h($link['name']); ?></a>
                <?php endforeach; ?>
              </div>
            <?php endif; ?>
          </article>
        <?php endforeach; ?>
      </section>
    <?php endif; ?>
  </div>

  <script>
    (function () {
      var pills = document.querySelectorAll('[data-si-quick-link]');
      for (var i = 0; i < pills.length; i++) {
        pills[i].addEventListener('click', function () {
          var url = this.getAttribute('data-si-quick-link');
          try {
            if (window.parent && typeof window.parent.siHighlightNavByUrl === 'function') {
              window.parent.siHighlightNavByUrl(url);
            }
          } catch (e) {
            // Ignora se aberto fora do shell
          }
        });
      }
    })();
  </script>
</body>
</html>
