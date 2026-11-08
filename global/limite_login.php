<?php
///////////////////////////////////////
//////  LIMITE DE TENTATIVAS  /////////
///////////////////////////////////////
// Protecao contra forca bruta em TODOS os formularios que conferem senha.
// As falhas ficam no banco (tabela login_falha, ver sql/2026-11-08_login_falha.sql),
// e nao na sessao: descartar o cookie nao zera o contador.
//
// Uso tipico:
//   if (login_bloqueado($login)) { mensagem de bloqueio; nao confere a senha }
//   elseif (senha ok)            { login_sucesso($login); ... }
//   else                         { login_falhou($login); ... }
//
// Se a tabela ainda nao existir (migracao nao aplicada), as funcoes registram o
// erro no log e NAO bloqueiam ninguem, para nao derrubar o login do sistema.

define('LOGIN_JANELA_MIN', 15);        // janela de contagem, em minutos
define('LOGIN_MAX_FALHAS_LOGIN', 5);   // falhas por login dentro da janela
define('LOGIN_MAX_FALHAS_IP', 30);     // falhas por IP dentro da janela (varios logins)

function login_ip_cliente()
{
    return isset($_SERVER['REMOTE_ADDR']) ? (string)$_SERVER['REMOTE_ADDR'] : '';
}

function login_normaliza($login)
{
    return strtolower(trim((string)$login));
}

// true se o login (ou o IP de origem) excedeu o limite de falhas na janela.
function login_bloqueado($login)
{
    try {
        $stmt = db_connect()->prepare(
            "SELECT
                 count(*) FILTER (WHERE login = :login) AS por_login,
                 count(*) FILTER (WHERE ip = :ip)       AS por_ip
             FROM login_falha
             WHERE momento > now() - make_interval(mins => :janela)
               AND (login = :login2 OR ip = :ip2)");
        $l = login_normaliza($login);
        $ip = login_ip_cliente();
        $stmt->execute(array(':login' => $l, ':ip' => $ip, ':janela' => LOGIN_JANELA_MIN,
                             ':login2' => $l, ':ip2' => $ip));
        $r = $stmt->fetch(PDO::FETCH_ASSOC);
        return $r && ($r['por_login'] >= LOGIN_MAX_FALHAS_LOGIN || $r['por_ip'] >= LOGIN_MAX_FALHAS_IP);
    } catch (PDOException $e) {
        error_log("login_bloqueado: " . $e->getMessage());
        return false;
    }
}

// Registra uma tentativa malsucedida (senha errada ou login inexistente).
function login_falhou($login)
{
    try {
        $pdo = db_connect();
        $stmt = $pdo->prepare("INSERT INTO login_falha (login, ip) VALUES (:login, :ip)");
        $stmt->execute(array(':login' => login_normaliza($login), ':ip' => login_ip_cliente()));
        // Limpeza ocasional dos registros antigos (~1 a cada 50 falhas).
        if (mt_rand(1, 50) === 1) {
            $pdo->exec("DELETE FROM login_falha WHERE momento < now() - interval '1 day'");
        }
    } catch (PDOException $e) {
        error_log("login_falhou: " . $e->getMessage());
    }
}

// Login bem-sucedido: zera as falhas daquele login.
function login_sucesso($login)
{
    try {
        $stmt = db_connect()->prepare("DELETE FROM login_falha WHERE login = :login");
        $stmt->execute(array(':login' => login_normaliza($login)));
    } catch (PDOException $e) {
        error_log("login_sucesso: " . $e->getMessage());
    }
}

function login_msg_bloqueio()
{
    return "Muitas tentativas de login malsucedidas. Aguarde " . LOGIN_JANELA_MIN
         . " minutos e tente novamente.";
}
