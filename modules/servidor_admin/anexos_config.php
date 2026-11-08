<?php
// Configuracao compartilhada dos anexos de documentos (upload, listagem e download).

// Pasta onde os anexos sao gravados. Nao e servida diretamente pela web:
// o acesso passa por baixa_anexo.php, que exige login no modulo.
function anexos_dir()
{
    return __DIR__ . '/anexos/';
}

// Extensoes aceitas e o Content-Type com que sao entregues.
function anexos_tipos()
{
    return array(
        'pdf' => 'application/pdf',
        'jpg' => 'image/jpeg',
        'png' => 'image/png',
        'gif' => 'image/gif',
    );
}

// Link autenticado para um anexo.
function anexo_link($id_documento, $numero_anexo)
{
    return 'baixa_anexo.php?doc=' . rawurlencode($id_documento) . '&n=' . rawurlencode($numero_anexo);
}
