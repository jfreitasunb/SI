-- Tentativas de login malsucedidas, usadas pelo limite contra forca bruta
-- (global/limite_login.php). Aplicar uma vez em cada banco:
--   psql -U si -d si -f sql/2026-11-08_login_falha.sql
CREATE TABLE IF NOT EXISTS login_falha (
    id      bigserial   PRIMARY KEY,
    login   varchar(60) NOT NULL,
    ip      varchar(45) NOT NULL,
    momento timestamp   NOT NULL DEFAULT now()
);

CREATE INDEX IF NOT EXISTS login_falha_login_idx ON login_falha (login, momento);
CREATE INDEX IF NOT EXISTS login_falha_ip_idx    ON login_falha (ip, momento);
