<?php
   require_once(dirname(__FILE__).'/sessao_cookie.php');
   session_start();
   include("function_php.php");

   // Conexão com o banco de dados (agora retorna um objeto PDO)
   $idconn = db_connect();

   // Previne erros de "Undefined variable" se $idmodule não estiver setado antes
   $idmodule = isset($idmodule) ? $idmodule : null;

   // Protecao contra Login CSRF: valida o token em POSTs antes de autenticar.
   csrf_valida();

   // Checa a identificação
   if (isset($_POST['login']) && isset($_POST['pass'])) {
       $identification = secure($_POST['login'], $_POST['pass'], $idmodule);
   } else {
       // Sessao existente: autenticacao validada pela flag de sessao + vinculo de IP.
       $identification = secure('', '', $idmodule);
   }

   // Se não estivermos identificados, transfere para a página de login
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
       exit; // IMPORTANTE: Interrompe o carregamento da página caso o usuário não esteja logado
   }

   // Garante que o token CSRF exista ja na carga inicial pos-login.
   csrf_token();

   $sess_login = isset($_SESSION['login']) ? $_SESSION['login'] : '';

   // PDO: Consulta principal com Prepared Statement para evitar SQL Injection
   $query = "SELECT m.url, m.name, m.idmodule FROM module m, permission p WHERE m.idmodule = p.idmodule AND p.login = :login AND p.permission > 0 ORDER BY m.name";

   try {
       $stmt = $idconn->prepare($query);
       $stmt->execute([':login' => $sess_login]);
       $modules = $stmt->fetchAll(PDO::FETCH_ASSOC);
   } catch (PDOException $e) {
       die(error());
   }

   // Carrega as funcoes permitidas para cada modulo (rejeitando URLs perigosas)
   $menu_tree = array();
   $stmt2 = $idconn->prepare("SELECT funcurl, funcname FROM functions f WHERE f.idmodule = :idmodule ORDER BY f.funcname");

   foreach ($modules as $mod) {
       try {
           $stmt2->execute([':idmodule' => $mod['idmodule']]);
           $functions = $stmt2->fetchAll(PDO::FETCH_ASSOC);
       } catch (PDOException $e) {
           die(error());
       }

       $safe_links = array();
       foreach ($functions as $fn) {
           $funcurl = (string)$fn['funcurl'];
           // Rejeita esquemas perigosos (ex.: javascript:, data:) em URLs do menu.
           if (preg_match('/^\s*(javascript|data|vbscript):/i', $funcurl)) {
               continue;
           }
           $safe_links[] = array(
               'name' => $fn['funcname'],
               'url'  => $funcurl,
           );
       }

       $menu_tree[] = array(
           'id'    => $mod['idmodule'],
           'name'  => $mod['name'],
           'links' => $safe_links,
       );
   }

   $idconn = null;
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>SI — Sistema de Informações</title>
  <link type="text/css" rel="stylesheet" href="grafic.css?v=<?php echo (int)@filemtime(__DIR__ . '/grafic.css'); ?>">
</head>
<body class="si-shell-body">
  <header class="si-topbar">
    <div class="si-topbar-left">
      <button
        type="button"
        id="si-sidebar-toggle"
        class="si-sidebar-toggle si-btn-raw"
        aria-label="Alternar menu lateral"
        aria-expanded="true"
        title="Mostrar ou recolher menu"
      >
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
          <line x1="3" y1="6" x2="21" y2="6"></line>
          <line x1="3" y1="12" x2="21" y2="12"></line>
          <line x1="3" y1="18" x2="21" y2="18"></line>
        </svg>
      </button>

      <a href="accueil.php" target="right" class="si-brand-link" id="si-brand-home">
        <span class="si-brand-pill" aria-hidden="true">SI</span>
        <span class="si-brand-text">
          <span class="si-brand-title">Sistema de Informações</span>
          <span class="si-brand-sub">Departamento de Matemática &bull; UnB</span>
        </span>
      </a>
    </div>

    <div class="si-topbar-right">
      <div class="si-user-chip" title="Usuário autenticado">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
          <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
          <circle cx="12" cy="7" r="4"></circle>
        </svg>
        <span><?php echo h($sess_login); ?></span>
      </div>

      <form method="post" action="logout.php" target="_top" class="si-logout-form">
        <?php echo csrf_campo(); ?>
        <button type="submit" class="si-logout-btn si-btn-raw" title="Encerrar sessão">
          <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
            <polyline points="16 17 21 12 16 7"></polyline>
            <line x1="21" y1="12" x2="9" y2="12"></line>
          </svg>
          <span>Sair</span>
        </button>
      </form>
    </div>
  </header>

  <div class="si-shell-main">
    <aside class="si-sidebar" id="si-sidebar" aria-label="Menu principal">
      <div class="si-sidebar-search">
        <div class="si-search-wrap">
          <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <circle cx="11" cy="11" r="8"></circle>
            <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
          </svg>
          <input
            type="search"
            id="si-menu-filter"
            placeholder="Filtrar módulos ou funções..."
            aria-label="Filtrar módulos ou funções"
          >
        </div>
      </div>

      <nav class="si-nav" id="si-nav">
        <a href="accueil.php" target="right" class="si-nav-home is-active" data-si-nav-link="accueil.php">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
            <polyline points="9 22 9 12 15 12 15 22"></polyline>
          </svg>
          <span>Página principal</span>
        </a>

        <?php foreach ($menu_tree as $idx => $mod): ?>
        <div class="si-nav-group" data-group-name="<?php echo h(strtolower($mod['name'])); ?>">
          <button
            type="button"
            class="si-nav-group-btn si-btn-raw"
            aria-expanded="false"
            aria-controls="si-group-list-<?php echo (int)$idx; ?>"
          >
            <span><?php echo h($mod['name']); ?></span>
            <svg class="si-nav-chevron" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
              <polyline points="9 18 15 12 9 6"></polyline>
            </svg>
          </button>

          <?php if (!empty($mod['links'])): ?>
          <ul class="si-nav-list" id="si-group-list-<?php echo (int)$idx; ?>">
            <?php foreach ($mod['links'] as $link): ?>
            <li>
              <a
                href="<?php echo h($link['url']); ?>"
                target="right"
                class="si-nav-link"
                data-si-nav-link="<?php echo h($link['url']); ?>"
              ><?php echo h($link['name']); ?></a>
            </li>
            <?php endforeach; ?>
          </ul>
          <?php endif; ?>
        </div>
        <?php endforeach; ?>

        <div class="si-nav-empty" id="si-nav-empty" style="display:none;">
          Nenhum módulo ou função encontrado.
        </div>
      </nav>
    </aside>

    <div class="si-sidebar-backdrop" id="si-sidebar-backdrop" aria-hidden="true"></div>

    <main class="si-workspace">
      <iframe
        id="si-content-frame"
        name="right"
        src="accueil.php"
        class="si-iframe"
        title="Área de trabalho do SI"
      ></iframe>
    </main>
  </div>

  <script>
    (function () {
      var body = document.body;
      var toggleBtn = document.getElementById('si-sidebar-toggle');
      var backdrop = document.getElementById('si-sidebar-backdrop');
      var filterInput = document.getElementById('si-menu-filter');
      var nav = document.getElementById('si-nav');
      var emptyMsg = document.getElementById('si-nav-empty');
      var brandHome = document.getElementById('si-brand-home');
      var homeLink = nav ? nav.querySelector('.si-nav-home') : null;
      var groups = nav ? Array.prototype.slice.call(nav.querySelectorAll('.si-nav-group')) : [];
      var navLinks = nav ? Array.prototype.slice.call(nav.querySelectorAll('[data-si-nav-link]')) : [];

      function isMobile() {
        return window.innerWidth <= 860;
      }

      function closeMobileSidebar() {
        body.classList.remove('si-sidebar-open');
        if (toggleBtn) toggleBtn.setAttribute('aria-expanded', 'false');
      }

      if (toggleBtn) {
        toggleBtn.addEventListener('click', function () {
          if (isMobile()) {
            var opened = body.classList.toggle('si-sidebar-open');
            toggleBtn.setAttribute('aria-expanded', opened ? 'true' : 'false');
          } else {
            var collapsed = body.classList.toggle('si-sidebar-collapsed');
            toggleBtn.setAttribute('aria-expanded', collapsed ? 'false' : 'true');
          }
        });
      }

      if (backdrop) {
        backdrop.addEventListener('click', closeMobileSidebar);
      }

      function setActiveLink(targetEl) {
        navLinks.forEach(function (el) {
          el.classList.remove('is-active');
        });
        if (targetEl) {
          targetEl.classList.add('is-active');
          var parentGroup = targetEl.closest('.si-nav-group');
          if (parentGroup) {
            parentGroup.classList.add('is-open');
            var btn = parentGroup.querySelector('.si-nav-group-btn');
            if (btn) btn.setAttribute('aria-expanded', 'true');
          }
        }
      }

      // Permite que a pagina inicial (accueil.php) sincronize o destaque no menu lateral
      window.siHighlightNavByUrl = function (url) {
        var found = null;
        for (var i = 0; i < navLinks.length; i++) {
          if (navLinks[i].getAttribute('data-si-nav-link') === url) {
            found = navLinks[i];
            break;
          }
        }
        if (found) setActiveLink(found);
      };

      groups.forEach(function (group) {
        var btn = group.querySelector('.si-nav-group-btn');
        if (!btn) return;
        btn.addEventListener('click', function () {
          var isOpen = group.classList.toggle('is-open');
          btn.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
        });
      });

      navLinks.forEach(function (link) {
        link.addEventListener('click', function () {
          setActiveLink(link);
          if (isMobile()) closeMobileSidebar();
        });
      });

      if (brandHome && homeLink) {
        brandHome.addEventListener('click', function () {
          setActiveLink(homeLink);
          if (isMobile()) closeMobileSidebar();
        });
      }

      function normalize(str) {
        var s = (str || '').toLowerCase();
        if (s.normalize) {
          s = s.normalize('NFD').replace(/[\u0300-\u036f]/g, '');
        }
        return s.trim();
      }

      if (filterInput) {
        filterInput.addEventListener('input', function () {
          var q = normalize(filterInput.value);
          var visibleGroups = 0;

          groups.forEach(function (group) {
            var btn = group.querySelector('.si-nav-group-btn');
            var groupText = normalize(btn ? btn.textContent : '');
            var items = Array.prototype.slice.call(group.querySelectorAll('.si-nav-list li'));

            if (!q) {
              group.style.display = '';
              items.forEach(function (li) { li.style.display = ''; });
              visibleGroups++;
              return;
            }

            var groupMatches = groupText.indexOf(q) !== -1;
            var anyChildMatches = false;

            items.forEach(function (li) {
              var match = groupMatches || normalize(li.textContent).indexOf(q) !== -1;
              li.style.display = match ? '' : 'none';
              if (match) anyChildMatches = true;
            });

            var showGroup = groupMatches || anyChildMatches;
            group.style.display = showGroup ? '' : 'none';
            if (showGroup) {
              group.classList.add('is-open');
              if (btn) btn.setAttribute('aria-expanded', 'true');
              visibleGroups++;
            }
          });

          if (emptyMsg) {
            emptyMsg.style.display = (q && visibleGroups === 0) ? 'block' : 'none';
          }
        });
      }
    })();
  </script>
</body>
</html>
