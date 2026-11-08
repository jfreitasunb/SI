<?php
// Carregado tanto por global/function_php.php quanto por conf/default.php
// (lista_oferta), para que todo o sistema use a mesma configuracao de banco.

///////////////////////////////////////
////////////  DB_CONFIG   /////////////
///////////////////////////////////////
// Credenciais do banco NAO ficam no codigo versionado. Sao lidas, nesta ordem
// de precedencia:
//   1. variaveis de ambiente (SI_DB_*, PYKOTA_DB_* — ex.: SetEnv no Apache);
//   2. arquivo local global/db_config.php (fora do versionamento; ver .sample);
//   3. defaults nao-sensiveis abaixo (host/porta/base/usuario; a SENHA nunca
//      tem default — se ausente, a conexao falha com mensagem clara).

function db_config()
{
    static $cfg = null;
    if ($cfg !== null) {
        return $cfg;
    }

    $cfg = array(
        'host'   => '192.168.122.36',
        'port'   => '5432',
        'dbname' => 'si',
        'user'   => 'si',
        'passwd' => null,
        'pykota_host'   => '127.0.0.1',
        'pykota_port'   => '5432',
        'pykota_dbname' => 'pykotanovo',
        'pykota_user'   => 'pykotaadmin',
        'pykota_passwd' => null,
    );

    $arquivo = __DIR__ . '/db_config.php';
    if (is_readable($arquivo)) {
        $local = include $arquivo;
        if (is_array($local)) {
            $cfg = array_merge($cfg, $local);
        }
    }

    foreach (array('host', 'port', 'dbname', 'user', 'passwd') as $k) {
        $env = getenv('SI_DB_' . strtoupper($k));
        if ($env !== false && $env !== '') {
            $cfg[$k] = $env;
        }
        $envp = getenv('PYKOTA_DB_' . strtoupper($k));
        if ($envp !== false && $envp !== '') {
            $cfg['pykota_' . $k] = $envp;
        }
    }

    return $cfg;
}
