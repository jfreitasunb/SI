<?php
// Entrega um anexo de documento apenas para usuarios autenticados no modulo
// Servidor Administrativo. A pasta anexos/ nao e acessivel diretamente pela web
// (ver anexos/.htaccess e a config do nginx).
//
// Uso: baixa_anexo.php?doc=<id_documento>&n=<numero_anexo>
require("head_admin.php");
require_once("anexos_config.php");

$doc = isset($_GET['doc']) ? (string)$_GET['doc'] : '';
$num = isset($_GET['n'])   ? (string)$_GET['n']   : '';

if (!ctype_digit($doc) || !ctype_digit($num)) {
    http_response_code(400);
    die(error("Anexo invalido."));
}

// O nome do arquivo vem do banco (gravado no upload), nunca do cliente.
$res = db_query("select nome_arquivo from admin_anexos where id_documento=? and numero_anexo=?", array($doc, $num));
$linha = db_fetch_row($res);
if ($linha === false) {
    http_response_code(404);
    die(error("Anexo nao encontrado."));
}

$nome = basename((string)$linha[0]);
$caminho = anexos_dir() . $nome;
$extensao = strtolower(pathinfo($nome, PATHINFO_EXTENSION));
$tipos = anexos_tipos();

if (!isset($tipos[$extensao]) || !is_file($caminho)) {
    http_response_code(404);
    die(error("Anexo nao encontrado."));
}

// Descarta o buffer do header (injecao de CSRF) para nao corromper o binario.
while (ob_get_level() > 0) {
    ob_end_clean();
}

header('Content-Type: ' . $tipos[$extensao]);
header('Content-Length: ' . filesize($caminho));
header('Content-Disposition: inline; filename="' . $nome . '"');
header('X-Content-Type-Options: nosniff');
header('Cache-Control: private, no-store');
readfile($caminho);
exit;
