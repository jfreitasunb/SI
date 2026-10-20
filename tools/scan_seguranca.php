<?php
/**
 * Scanner de padroes de seguranca do SI.
 *
 * Objetivo: quando arquivos novos forem adicionados, rodar isto em vez de
 * reauditar tudo. Ele varre os *.php procurando os padroes que ja corrigimos
 * e compara com um baseline (tools/seguranca_baseline.txt) com as excecoes
 * ja conhecidas/aceitas (codigo morto, parse-errors pre-existentes). So o que
 * for NOVO aparece, e o codigo de saida fica !=0 se houver achado novo.
 *
 * Uso:
 *   php tools/scan_seguranca.php                 # varre o repo todo
 *   php tools/scan_seguranca.php arquivo1 ...    # varre arquivos especificos
 *   php tools/scan_seguranca.php --atualiza-baseline   # regrava o baseline
 *
 * Sem PHP local? Rode no Docker:
 *   docker run --rm -v "$PWD":/app -w /app php:7.4-cli php tools/scan_seguranca.php
 */

error_reporting(E_ALL & ~E_DEPRECATED);

$root = dirname(__DIR__);
$baselineFile = __DIR__ . '/seguranca_baseline.txt';

$args = array_slice($argv, 1);
$atualiza = false;
$alvos = array();
foreach ($args as $a) {
    if ($a === '--atualiza-baseline') $atualiza = true;
    else $alvos[] = $a;
}

/** Lista de arquivos .php a analisar. */
function lista_php($root, array $alvos)
{
    if ($alvos) {
        $out = array();
        foreach ($alvos as $a) {
            if (is_file($a) && substr($a, -4) === '.php') $out[] = $a;
        }
        return $out;
    }
    $out = array();
    $rii = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($root, FilesystemIterator::SKIP_DOTS)
    );
    foreach ($rii as $f) {
        $p = $f->getPathname();
        if (strpos($p, '/.git/') !== false) continue;
        if (strpos($p, '/tools/') !== false) continue; // nao analisa a si mesmo
        if ($f->getExtension() === 'php') $out[] = $p;
    }
    sort($out);
    return $out;
}

/** Caminho relativo ao repo. */
function rel($root, $path)
{
    $r = realpath($path);
    $base = realpath($root);
    if ($r !== false && $base !== false && strpos($r, $base) === 0) {
        return ltrim(substr($r, strlen($base)), '/');
    }
    return $path;
}

/**
 * Analisa um arquivo e devolve achados: array de [linha, regra, trecho].
 * Usa o tokenizer para nao marcar codigo dentro de comentarios.
 */
function analisa($path)
{
    $achados = array();
    $src = @file_get_contents($path);
    if ($src === false) return $achados;
    $linhas = preg_split('/\r\n|\r|\n/', $src);

    $tokens = @token_get_all($src);
    if ($tokens === false) return $achados;

    // Varre tokens que NAO sao comentarios.
    $n = count($tokens);
    for ($i = 0; $i < $n; $i++) {
        $t = $tokens[$i];
        if (!is_array($t)) continue;
        list($id, $txt, $ln) = array($t[0], $t[1], $t[2]);

        // 1) Conexao/consulta legada pg_* (ja migramos tudo para PDO/db_query)
        if ($id === T_STRING) {
            $low = strtolower($txt);
            if (in_array($low, array('pg_query', 'pg_exec', 'pg_send_query', 'pg_connect', 'pg_pconnect'))) {
                $achados[] = array($ln, 'pg-legado', "uso de $txt() (migrar para db_query/PDO parametrizado)");
            }
            if (in_array($low, array('mysql_query', 'mysqli_query'))) {
                $achados[] = array($ln, 'sql-driver', "uso de $txt()");
            }
        }

        // 2) Hashing fraco de senha: md5( / crypt( sem $6$
        if ($id === T_STRING && strtolower($txt) === 'md5') {
            $achados[] = array($ln, 'hash-fraco', 'md5() — use hash_senha_app()/cripta_senha_unix()');
        }
    }

    // Checagens por linha (regex) — complementam o tokenizer.
    foreach ($linhas as $idx => $linha) {
        $ln = $idx + 1;
        $semComentario = preg_replace('#//.*$#', '', $linha);

        // 3) echo de superglobal sem escape h(...)
        if (preg_match('/\becho\b[^;]*\$_(GET|POST|REQUEST|COOKIE|SERVER)\b/', $semComentario)
            && !preg_match('/\bh\s*\(/', $semComentario)
            && !preg_match('/htmlspecialchars|htmlentities/', $semComentario)) {
            $achados[] = array($ln, 'xss-echo', 'echo de superglobal sem h()/htmlspecialchars');
        }

        // 4) SQL montada por concatenacao/interpolacao com variavel
        if (preg_match('/\b(pg_query|pg_exec|db_query)\s*\(\s*"[^"]*(\$|"\s*\.)/', $semComentario)
            || preg_match("/\b(pg_query|pg_exec|db_query)\s*\(\s*'[^']*(\\\$|'\s*\\.)/", $semComentario)) {
            $achados[] = array($ln, 'sql-interpolada', 'SQL com variavel interpolada/concatenada (use ? + array de params)');
        }

        // 5) Senha hardcoded
        if (preg_match('/(passwd|password|senha|pwd)\s*[=:]\s*["\'][^"\']+["\']/i', $semComentario)
            && !preg_match('/getenv|db_config|\$_|TROQUE|REPLACE|example|placeholder|=>\s*null/i', $semComentario)) {
            $achados[] = array($ln, 'senha-hardcoded', 'possivel senha/credencial em texto claro');
        }

        // 6) crypt() sem SHA-512 ($6$) para senha
        if (preg_match('/\bcrypt\s*\(/', $semComentario)
            && !preg_match('/\$6\$|cripta_senha_unix/', $semComentario)) {
            $achados[] = array($ln, 'crypt-fraco', 'crypt() sem $6$ — use cripta_senha_unix()');
        }
    }

    return $achados;
}

// ---- Execucao ----
$arquivos = lista_php($root, $alvos);
$atual = array();          // "rel:linha:regra" => "trecho"
foreach ($arquivos as $f) {
    foreach (analisa($f) as $a) {
        list($ln, $regra, $trecho) = $a;
        $chave = rel($root, $f) . ':' . $ln . ':' . $regra;
        $atual[$chave] = $trecho;
    }
}

if ($atualiza) {
    $linhas = array_keys($atual);
    sort($linhas);
    $cab = "# Baseline de seguranca do SI — achados conhecidos/aceitos.\n"
         . "# Gerado por tools/scan_seguranca.php --atualiza-baseline.\n"
         . "# Cada linha: caminho:linha:regra. O scanner so reporta o que NAO estiver aqui.\n";
    file_put_contents($baselineFile, $cab . implode("\n", $linhas) . "\n");
    echo "Baseline atualizado: " . count($linhas) . " achado(s) registrados em " . rel($root, $baselineFile) . "\n";
    exit(0);
}

// Carrega baseline
$baseline = array();
if (is_readable($baselineFile)) {
    foreach (file($baselineFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $l) {
        if ($l[0] === '#') continue;
        $baseline[$l] = true;
    }
}

// Novos = atual - baseline
$novos = array();
foreach ($atual as $chave => $trecho) {
    if (!isset($baseline[$chave])) $novos[$chave] = $trecho;
}

if (!$novos) {
    echo "OK: nenhum achado novo (" . count($atual) . " conhecido(s) no baseline).\n";
    exit(0);
}

ksort($novos);
echo "ACHADOS NOVOS DE SEGURANCA (" . count($novos) . "):\n\n";
foreach ($novos as $chave => $trecho) {
    echo "  $chave\n      $trecho\n";
}
echo "\nRevise cada um. Se for falso-positivo/aceito, registre com:\n";
echo "  php tools/scan_seguranca.php --atualiza-baseline\n";
exit(1);
