<?php
// Modelo de configuracao de credenciais do banco.
// Copie para global/db_config.php (que NAO e versionado) e ajuste os valores,
// OU defina as variaveis de ambiente correspondentes (precedencia maior):
//   SI_DB_HOST, SI_DB_PORT, SI_DB_DBNAME, SI_DB_USER, SI_DB_PASSWD
//   PYKOTA_DB_HOST, PYKOTA_DB_PORT, PYKOTA_DB_DBNAME, PYKOTA_DB_USER, PYKOTA_DB_PASSWD
// Apenas as chaves que quiser sobrescrever precisam estar presentes.
return array(
    // Banco principal (si)
    'host'          => '192.168.122.36',
    'port'          => '5432',
    'dbname'        => 'si',
    'user'          => 'si',
    'passwd'        => 'TROQUE_AQUI',

    // Banco pykota (contabilidade de impressao) - usado por modules/aliases
    'pykota_host'   => '127.0.0.1',
    'pykota_port'   => '5432',
    'pykota_dbname' => 'pykotanovo',
    'pykota_user'   => 'pykotaadmin',
    'pykota_passwd' => 'TROQUE_AQUI',
);
