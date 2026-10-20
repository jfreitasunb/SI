<?php
// Flags de seguranca do cookie de sessao. DEVE ser incluido ANTES de session_start().
//   - httponly: cookie inacessivel a JavaScript (mitiga roubo de sessao via XSS);
//   - secure:   so trafega sob HTTPS (ativado automaticamente quando ha HTTPS);
//   - samesite: Lax reduz envio cross-site (defesa em profundidade contra CSRF).
if (session_status() === PHP_SESSION_NONE && !headers_sent()) {
    session_set_cookie_params(array(
        'lifetime' => 0,
        'path'     => '/',
        'httponly' => true,
        'secure'   => (!empty($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) !== 'off'),
        'samesite' => 'Lax',
    ));
}
?>
