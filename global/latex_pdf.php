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

// Remove um diretório temporário e o seu conteúdo (não recursivo: o pdflatex só gera arquivos).
function latex_remove_dir($dir)
{
    foreach (glob($dir . '/*') as $arquivo) {
        @unlink($arquivo);
    }
    @rmdir($dir);
}

// Preenche um modelo .tex com os valores de $seds e devolve o PDF gerado (ou false).
//   $modelo: caminho do arquivo .tex do modelo (deve existir dentro de um diretório modelo_tex)
//   $seds:   array PLACEHOLDER => valor
// Os valores são inseridos literalmente, sem passar pelo shell. O pdflatex roda em modo
// restrito, com leitura/escrita de arquivos limitada ao diretório de trabalho e com tempo limite.
function gera_pdf_latex($modelo, array $seds)
{
    $modelo_real = realpath($modelo);
    if ($modelo_real === false || basename(dirname($modelo_real)) !== 'modelo_tex'
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
    $cmd = 'timeout 30 pdflatex -shell-restricted -interaction=nonstopmode -halt-on-error'
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
