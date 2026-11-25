<?php

///////////////////////////////////////
////////  GERA_PDF_LATEX  /////////////
///////////////////////////////////////

// Diretório onde ficam as classes/estilos (.cls/.sty) usados pelos modelos.
define('LATEX_DIR_CLASSES', realpath(dirname(__FILE__) . '/../modules/servidor_admin/Tex'));

// Escapa texto puro para ser inserido num documento LaTeX (campos que não devem conter comandos LaTeX).
function latex_escape($texto)
{
    return strtr((string)$texto, array(
        '\\' => '\textbackslash{}',
        '{'  => '\{',
        '}'  => '\}',
        '#'  => '\#',
        '$'  => '\$',
        '%'  => '\%',
        '&'  => '\&',
        '_'  => '\_',
        '~'  => '\textasciitilde{}',
        '^'  => '\textasciicircum{}',
    ));
}

// Remove um diretório temporário e o seu conteúdo (incluindo dotfiles).
function latex_remove_dir($dir)
{
    $itens = @scandir($dir);
    if (is_array($itens)) {
        foreach ($itens as $item) {
            if ($item === '.' || $item === '..') continue;
            $caminho = $dir . '/' . $item;
            if (is_dir($caminho)) {
                latex_remove_dir($caminho);
            } else {
                @unlink($caminho);
            }
        }
    }
    @rmdir($dir);
}

// Preenche um modelo .tex com os valores de $seds e devolve o PDF gerado (ou false).
//   $modelo: caminho do arquivo .tex do modelo (deve existir dentro de modules/*/modelo_tex)
//   $seds:   array PLACEHOLDER => valor
// Os valores são inseridos literalmente, sem passar pelo shell. O pdflatex roda sem
// shell-escape (-no-shell-escape), com leitura/escrita limitada ao diretório temporário e timeout.
function gera_pdf_latex($modelo, array $seds)
{
    $modelo_real = realpath($modelo);
    $modules_base = realpath(dirname(__FILE__) . '/../modules');
    if ($modelo_real === false || $modules_base === false
        || strpos($modelo_real, $modules_base . DIRECTORY_SEPARATOR) !== 0
        || basename(dirname($modelo_real)) !== 'modelo_tex'
        || substr($modelo_real, -4) !== '.tex') {
        return false;
    }

    $conteudo = file_get_contents($modelo_real);
    if ($conteudo === false) {
        return false;
    }

    // Quebras de linha eram removidas no fluxo antigo; mantém o mesmo comportamento.
    $substituicoes = array();
    foreach ($seds as $chave => $valor) {
        $substituicoes[(string)$chave] = str_replace(array("\r\n", "\n", "\r"), '', (string)$valor);
    }
    // strtr faz uma única passada: um valor inserido nunca é reprocessado como placeholder.
    $conteudo = strtr($conteudo, $substituicoes);

    // Diretório de trabalho privado, fora da raiz web.
    $dir = sys_get_temp_dir() . '/si_pdf_' . bin2hex(random_bytes(12));
    if (!mkdir($dir, 0700)) {
        return false;
    }
    $tex = $dir . '/documento.tex';
    file_put_contents($tex, $conteudo);

    $texinputs = LATEX_DIR_CLASSES . ':' . dirname($modelo_real) . ':';
    $cmd = 'timeout 30 pdflatex -no-shell-escape -interaction=nonstopmode -halt-on-error'
         . ' -output-directory=' . escapeshellarg($dir) . ' ' . escapeshellarg($tex);
    $env = array(
        'PATH'         => '/usr/local/bin:/usr/bin:/bin',
        'HOME'         => $dir,
        'TEXINPUTS'    => $texinputs,
        'TEXMFOUTPUT'  => $dir,
        'openin_any'   => 'p',
        'openout_any'  => 'p',
    );
    $descritores = array(0 => array('file', '/dev/null', 'r'),
                         1 => array('file', '/dev/null', 'w'),
                         2 => array('file', '/dev/null', 'w'));

    $proc = proc_open($cmd, $descritores, $pipes, $dir, $env);
    if (is_resource($proc)) {
        proc_close($proc);
    }

    $pdf = is_file($dir . '/documento.pdf') ? file_get_contents($dir . '/documento.pdf') : false;
    latex_remove_dir($dir);
    return $pdf;
}
?>
