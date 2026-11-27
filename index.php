<?php
   require_once(dirname(__FILE__).'/global/sessao_cookie.php');
   session_start();
   require_once(dirname(__FILE__).'/global/function_php.php');
   csrf_token();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>SI — Sistema de Informações</title>
  <link type="text/css" rel="stylesheet" href="./global/grafic.css?v=<?php echo (int)@filemtime(__DIR__ . '/global/grafic.css'); ?>">
  <script>
    if (window.top !== window.self) {
      window.top.location = window.self.location.href;
    }
  </script>
<?php
  if (!empty($_SESSION['si_autenticado']) && isset($_SESSION['login']))
  {
?>
  <script>
    window.location.href = "global/index.php";
  </script>
<?php
  }
?>
</head>
<body class="si-login-body">
  <main class="si-login-card" role="main">
    <div class="si-login-header">
      <div class="si-brand-badge" aria-hidden="true">SI</div>
      <h1>Sistema de Informações</h1>
      <p>Departamento de Matemática &bull; UnB</p>
    </div>

    <form class="si-login-form" method="post" name="identification" action="global/index.php">
      <?php echo csrf_campo(); ?>

      <?php if (isset($_GET['error'])): ?>
      <div class="si-alert-error" role="alert">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
          <circle cx="12" cy="12" r="10"></circle>
          <line x1="12" y1="8" x2="12" y2="12"></line>
          <line x1="12" y1="16" x2="12.01" y2="16"></line>
        </svg>
        <div>
          <strong>A identificação falhou.</strong><br>
          Verifique seu login e senha e tente novamente.
        </div>
      </div>
      <?php endif; ?>

      <div class="si-field">
        <label for="si-login">Login</label>
        <div class="si-input-wrap">
          <input
            type="text"
            id="si-login"
            name="login"
            placeholder="Digite seu usuário"
            autocomplete="username"
            required
            autofocus
          >
        </div>
      </div>

      <div class="si-field">
        <label for="si-pass">Senha</label>
        <div class="si-input-wrap has-toggle">
          <input
            type="password"
            id="si-pass"
            name="pass"
            placeholder="Digite sua senha"
            autocomplete="current-password"
            required
          >
          <button
            type="button"
            class="si-pass-toggle si-btn-raw"
            id="si-toggle-pass"
            aria-label="Mostrar ou ocultar senha"
            title="Mostrar ou ocultar senha"
          >
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
              <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
              <circle cx="12" cy="12" r="3"></circle>
            </svg>
          </button>
        </div>
      </div>

      <button type="submit" name="valider" value="Confirmar" class="si-login-submit">
        Entrar no sistema
      </button>
    </form>

    <div class="si-login-footer">
      Acesso restrito a usuários autorizados
    </div>
  </main>

  <script>
    (function () {
      var btn = document.getElementById('si-toggle-pass');
      var input = document.getElementById('si-pass');
      if (!btn || !input) return;
      btn.addEventListener('click', function () {
        var isHidden = input.type === 'password';
        input.type = isHidden ? 'text' : 'password';
        btn.setAttribute('aria-pressed', isHidden ? 'true' : 'false');
      });
    })();
  </script>
</body>
</html>
