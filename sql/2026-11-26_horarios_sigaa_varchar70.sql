-- Horarios do SIGAA no formato novo passam de 11 caracteres (ex. "7T2345 5N1234",
-- "35M5 2T23 35T1") e quebravam o envio da lista em recupera_lista_SAA.php
-- (atualiza_oferta_semestres: "value too long for type character varying(11)").
-- Iguala ao tamanho de oferta_lista_sigra.horarios (varchar 70) nas tabelas por onde
-- o horario passa: oferta_semestres -> oferta_lista_de_ofertas_nova (criar_programa_semestre.php)
-- -> oferta_tabela_impressao. So aumenta o limite: nenhum dado muda.
-- Aplicar uma vez em cada banco:
--   docker exec -i db psql -U si -d si -v ON_ERROR_STOP=1 < sql/2026-11-26_horarios_sigaa_varchar70.sql
BEGIN;
ALTER TABLE oferta_semestres             ALTER COLUMN horarios TYPE character varying(70);
ALTER TABLE oferta_lista_de_ofertas_nova ALTER COLUMN horarios TYPE character varying(70);
ALTER TABLE oferta_tabela_impressao      ALTER COLUMN horarios TYPE character varying(70);
COMMIT;
