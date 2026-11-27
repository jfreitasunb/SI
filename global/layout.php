<?php
/**
 * Helpers compartilhados de layout e normalizacao HTML5 do SI (Fase 4).
 *
 * Oferece:
 *  - si_grafic_css_href(): URL versionada do grafic.css (cache-busting)
 *  - si_layout_head() / si_layout_inicio() / si_layout_fim(): layout padrao UnB
 *  - si_alerta(): componente de alerta (info, success, warning, error)
 *  - si_render_error(): pagina de erro padronizada na paleta UnB
 *  - si_normaliza_html() / si_processa_html(): normalizacao automatica das telas
 *    legadas servidas via global/header.php (DOCTYPE HTML5, <header>-><head>,
 *    viewport e cache-busting do grafic.css).
 */

function si_grafic_css_version()
{
    static $ver = null;
    if ($ver === null) {
        $mtime = @filemtime(__DIR__ . '/grafic.css');
        $ver = $mtime ? (string)(int)$mtime : '1';
    }
    return $ver;
}

function si_grafic_css_href($prefix = '../../global/')
{
    return $prefix . 'grafic.css?v=' . si_grafic_css_version();
}

function si_layout_head($titulo, array $opcoes = array())
{
    $prefix = isset($opcoes['css_prefix']) ? $opcoes['css_prefix'] : '../../global/';
    $extra_css = isset($opcoes['css']) && is_array($opcoes['css']) ? $opcoes['css'] : array();
    $extra_js  = isset($opcoes['js']) && is_array($opcoes['js']) ? $opcoes['js'] : array();
    $body_class = isset($opcoes['body_class']) ? (string)$opcoes['body_class'] : '';

    echo "<!DOCTYPE html>\n";
    echo "<html lang=\"pt-BR\">\n";
    echo "<head>\n";
    echo "  <meta charset=\"UTF-8\">\n";
    echo "  <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">\n";
    echo "  <title>" . h($titulo) . " — SI</title>\n";
    echo "  <link type=\"text/css\" rel=\"stylesheet\" href=\"" . h(si_grafic_css_href($prefix)) . "\">\n";
    foreach ($extra_css as $css) {
        echo "  <link type=\"text/css\" rel=\"stylesheet\" href=\"" . h($css) . "\">\n";
    }
    foreach ($extra_js as $js) {
        echo "  <script src=\"" . h($js) . "\"></script>\n";
    }
    echo "</head>\n";
    if ($body_class !== '') {
        echo "<body class=\"" . h($body_class) . "\">\n";
    } else {
        echo "<body>\n";
    }
}

function si_layout_inicio($titulo, array $opcoes = array())
{
    si_layout_head($titulo, $opcoes);
    $subtitulo = isset($opcoes['subtitulo']) ? (string)$opcoes['subtitulo'] : '';

    echo "<div class=\"si-page-card\">\n";
    echo "  <div class=\"si-page-header\">\n";
    echo "    <h1>" . h($titulo) . "</h1>\n";
    if ($subtitulo !== '') {
        echo "    <p>" . h($subtitulo) . "</p>\n";
    }
    echo "  </div>\n";
    echo "  <div class=\"si-page-content\">\n";
}

function si_layout_fim()
{
    echo "  </div>\n";
    echo "</div>\n";
    echo "</body>\n";
    echo "</html>\n";
}

function si_alerta($mensagem, $tipo = 'info')
{
    $permitidos = array('info', 'success', 'warning', 'error');
    if (!in_array($tipo, $permitidos, true)) {
        $tipo = 'info';
    }
    $role = ($tipo === 'error' || $tipo === 'warning') ? 'alert' : 'status';
    return '<div class="si-alert si-alert--' . $tipo . '" role="' . $role . '">'
         . h($mensagem)
         . '</div>';
}

function si_render_error($safe_error)
{
    $css = '/global/grafic.css?v=' . si_grafic_css_version();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Erro — SI</title>
  <link type="text/css" rel="stylesheet" href="<?php echo $css; ?>">
</head>
<body class="si-error-body">
  <main class="si-error-card" role="alert">
    <div class="si-error-header">
      <h1>Ocorreu um erro</h1>
    </div>
    <div class="si-error-content">
      <p><?php echo $safe_error; ?></p>
      <div class="si-error-actions">
        <button type="button" onclick="history.back();">Voltar</button>
        <a href="/global/accueil.php" class="si-btn-link">Página principal</a>
      </div>
    </div>
  </main>
</body>
</html>
<?php
}

/**
 * Normaliza HTML legado emitido pelos modulos antigos:
 *  - Corrige <header>...</header> usado no lugar de <head>...</head> antes do <body>
 *  - Adiciona <!DOCTYPE html> para sair do Quirks Mode
 *  - Garante <meta name="viewport"> e cache-busting no grafic.css
 *  - Injeta grafic.css em paginas HTML legadas sem folha de estilo
 */
function si_normaliza_html($html)
{
    if (!is_string($html) || $html === '') {
        return $html;
    }

    // Nao altera respostas nao-HTML (PDF, imagens, CSV, downloads, etc.)
    foreach (headers_list() as $cabecalho) {
        if (stripos($cabecalho, 'Content-Type:') === 0
            && stripos($cabecalho, 'text/html') === false) {
            return $html;
        }
    }

    // So atua em documentos HTML completos (ignora fragmentos AJAX/texto puro)
    if (stripos($html, '<html') === false) {
        return $html;
    }

    // 1) Converte <header>...</header> usado incorretamente como <head> antes de <body>
    $posBody = stripos($html, '<body');
    $posHead = stripos($html, '<head>');
    if ($posHead === false) {
        $posHead = stripos($html, '<head ');
    }
    if ($posHead === false) {
        $html = preg_replace_callback(
            '/(<html\b[^>]*>\s*)<header\b[^>]*>(.*?)<\/header>/is',
            function ($m) {
                return $m[1] . '<head>' . $m[2] . '</head>';
            },
            $html,
            1
        );
    }

    // 2) Adiciona <!DOCTYPE html> se ausente (tira as telas legadas do Quirks Mode)
    if (!preg_match('/^\s*<!DOCTYPE\b/i', $html)) {
        $html = preg_replace('/^(\s*)(<html\b)/i', "$1<!DOCTYPE html>\n$2", $html, 1);
    }

    // 3) Garante que exista <head>...</head> antes de <body> (ex.: inclui_assinatura.php)
    if (stripos($html, '<head') === false && $posBody !== false) {
        $html = preg_replace('/(<body\b)/i', "<head>\n</head>\n$1", $html, 1);
    }

    // 4) Garante <meta name="viewport"> dentro do <head>
    if (stripos($html, 'name="viewport"') === false && stripos($html, "name='viewport'") === false) {
        $html = preg_replace(
            '/(<head\b[^>]*>)/i',
            "$1\n  <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">",
            $html,
            1
        );
    }

    // 5) Cache-busting automatico no grafic.css (ou injecao caso a pagina nao importe nenhum CSS)
    $ver = si_grafic_css_version();
    if (stripos($html, 'grafic.css') !== false) {
        $html = preg_replace(
            '/(grafic\.css)(?!\?v=)([\'"])/i',
            '$1?v=' . $ver . '$2',
            $html
        );
    } elseif (stripos($html, '<link') === false && stripos($html, '</head>') !== false) {
        $link = "  <link type=\"text/css\" rel=\"stylesheet\" href=\"/global/grafic.css?v=" . $ver . "\">\n";
        $html = preg_replace('/(<\/head>)/i', $link . '$1', $html, 1);
    }

    return $html;
}

/**
 * Callback combinado de output buffering usado em global/header.php:
 * primeiro normaliza o HTML legado, depois injeta os tokens CSRF.
 */
function si_processa_html($html)
{
    $html = si_normaliza_html($html);
    if (function_exists('csrf_injeta')) {
        $html = csrf_injeta($html);
    }
    return $html;
}
