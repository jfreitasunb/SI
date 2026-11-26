-- Rodizio noturno: disciplina passa a ser o codigo do SIGAA (MAT0025) em vez do
-- codigo SIGRA (113034), e corrige registros errados.
-- Aplicar uma vez em cada banco, DEPOIS de um backup:
--   docker exec db pg_dump -U si -d si -Fc > ~/si_antes_rodizio.dump
--   docker exec -i db psql -U si -d si -v ON_ERROR_STOP=1 < sql/2026-11-26_rodizio_noturno_codigo_sigaa.sql
-- Roda numa transacao: se qualquer passo falhar, nada e alterado.

BEGIN;

-- 1) Duplicatas: mesmo professor, semestre, ano, disciplina e turma. Mantem o
--    registro mais antigo (menor id). No banco de 2026-11-26 eram 12 linhas a mais,
--    em 2/2022 (117471 e 113042) e 1/2024 (113603 e 117480, 6 copias cada), que
--    somavam pontos de noturno em dobro.
DELETE FROM oferta_horarios_rodizio_noturno_creditos a
 USING oferta_horarios_rodizio_noturno_creditos b
 WHERE a.id > b.id
   AND a.coduser = b.coduser
   AND a.semestre = b.semestre
   AND a.ano = b.ano
   AND a.disciplina = b.disciplina
   AND a.turma = b.turma;

-- 2) disciplina: integer com codigo SIGRA -> texto com codigo SIGAA, pela tabela de
--    modules/oferta_atualizacao/codigos_disciplinas_sigaa.php. 113034 e o codigo de
--    MAT0025 e MAT0137; vira MAT0025 (nao ha turmas SP gravadas).
--    117141 nao existe no SIGRA: foi gravado em 2 registros de 1/2025 no lugar de
--    141 (MAT0141, Praticas de Extensao em Matematica 3) e vira MAT0141.
--    Codigos sem correspondente ficam como estao, em texto.
ALTER TABLE oferta_horarios_rodizio_noturno_creditos
    ALTER COLUMN disciplina TYPE character varying(10)
    USING CASE disciplina
        WHEN 139 THEN 'MAT0139'
        WHEN 140 THEN 'MAT0140'
        WHEN 141 THEN 'MAT0141'
        WHEN 163 THEN 'MAT0163'
        WHEN 164 THEN 'MAT0164'
        WHEN 166 THEN 'MAT0166'
        WHEN 174 THEN 'MAT0174'
        WHEN 105317 THEN 'MAT0002'
        WHEN 105881 THEN 'MAT0010'
        WHEN 113018 THEN 'MAT0022'
        WHEN 113026 THEN 'MAT0023'
        WHEN 113034 THEN 'MAT0025'
        WHEN 113042 THEN 'MAT0026'
        WHEN 113051 THEN 'MAT0027'
        WHEN 113069 THEN 'MAT0028'
        WHEN 113093 THEN 'MAT0031'
        WHEN 113107 THEN 'MAT0034'
        WHEN 113115 THEN 'MAT0038'
        WHEN 113123 THEN 'MAT0039'
        WHEN 113131 THEN 'MAT0040'
        WHEN 113158 THEN 'MAT0041'
        WHEN 113204 THEN 'MAT0045'
        WHEN 113212 THEN 'MAT0046'
        WHEN 113263 THEN 'MAT0047'
        WHEN 113328 THEN 'MAT0050'
        WHEN 113417 THEN 'MAT0053'
        WHEN 113433 THEN 'MAT0054'
        WHEN 113506 THEN 'MAT0057'
        WHEN 113522 THEN 'MAT0059'
        WHEN 113603 THEN 'MAT0060'
        WHEN 113611 THEN 'MAT0061'
        WHEN 113671 THEN 'MAT0066'
        WHEN 113689 THEN 'MAT0068'
        WHEN 113697 THEN 'MAT0069'
        WHEN 113808 THEN 'MAT0072'
        WHEN 113824 THEN 'MAT0075'
        WHEN 113825 THEN 'MAT0006'
        WHEN 113832 THEN 'MAT0076'
        WHEN 113841 THEN 'MAT0077'
        WHEN 113859 THEN 'MAT0078'
        WHEN 113930 THEN 'MAT0080'
        WHEN 113948 THEN 'MAT0081'
        WHEN 113972 THEN 'MAT0082'
        WHEN 117013 THEN 'MAT0087'
        WHEN 117030 THEN 'MAT0091'
        WHEN 117056 THEN 'MAT0097'
        WHEN 117064 THEN 'MAT0098'
        WHEN 117072 THEN 'MAT0099'
        WHEN 117081 THEN 'MAT0100'
        WHEN 117099 THEN 'MAT0101'
        WHEN 117102 THEN 'MAT0102'
        WHEN 117111 THEN 'MAT0103'
        WHEN 117129 THEN 'MAT0105'
        WHEN 117137 THEN 'MAT0106'
        WHEN 117145 THEN 'MAT0107'
        WHEN 117161 THEN 'MAT0111'
        WHEN 117170 THEN 'MAT0114'
        WHEN 117293 THEN 'MAT0115'
        WHEN 117307 THEN 'MAT0117'
        WHEN 117323 THEN 'MAT0118'
        WHEN 117358 THEN 'MAT0119'
        WHEN 117412 THEN 'MAT0120'
        WHEN 117421 THEN 'MAT0122'
        WHEN 117439 THEN 'MAT0124'
        WHEN 117447 THEN 'MAT0125'
        WHEN 117455 THEN 'MAT0126'
        WHEN 117463 THEN 'MAT0127'
        WHEN 117471 THEN 'MAT0129'
        WHEN 117480 THEN 'MAT0131'
        WHEN 117498 THEN 'MAT0132'
        WHEN 117501 THEN 'MAT0134'
        WHEN 117510 THEN 'MAT0136'
        WHEN 200142 THEN 'MAT0142'
        WHEN 200143 THEN 'MAT0143'
        WHEN 200144 THEN 'MAT0144'
        WHEN 117141 THEN 'MAT0141'
        ELSE disciplina::text
    END;

-- 3) Creditos errados em 2/2026, conferidos contra a lista do SIGAA (lo_20262.txt):
--    creditos = horas do professor na turma / 15.
UPDATE oferta_horarios_rodizio_noturno_creditos SET credito_noturno = 4   -- Jiazheng Zhou (60h), estava 6
 WHERE coduser = 464 AND semestre = 2 AND ano = 2026 AND disciplina = 'MAT0025' AND turma = '3';
UPDATE oferta_horarios_rodizio_noturno_creditos SET credito_noturno = 2   -- Ary Vasconcelos Medino (30h), estava 4
 WHERE coduser = 580 AND semestre = 2 AND ano = 2026 AND disciplina = 'MAT0087' AND turma = '3';
UPDATE oferta_horarios_rodizio_noturno_creditos SET credito_noturno = 4   -- Mauro Moraes Alves Patrao (60h), estava 2
 WHERE coduser = 405 AND semestre = 2 AND ano = 2026 AND disciplina = 'MAT0111' AND turma = '1';

-- 4) Turmas noturnas de 2/2026 que estao na lista do SIGAA e faltam no banco.
--    O envio do arquivo em recupera_lista_SAA.php tambem as insere; o NOT EXISTS
--    evita duplicar se uma das duas coisas ja tiver sido feita.
INSERT INTO oferta_horarios_rodizio_noturno_creditos (coduser, semestre, ano, credito_noturno, disciplina, turma)
SELECT v.coduser, 2, 2026, v.credito, v.disciplina, v.turma
  FROM (VALUES
        ( 978, 6, 'MAT0122', '1'),   -- Cleyton Hercules Gontijo (90h)
        (1222, 4, 'MAT0025', '7'),   -- Geovane Matheus Lemes Andrade (60h)
        (1124, 4, 'MAT0025', '8'),   -- Julia Mitsuno Kato Aiza Alvarez (60h)
        (1102, 4, 'MAT0025', '9'),   -- Melissa de Sousa Luiz (60h)
        ( 904, 4, 'MAT0031', '5'),   -- Ricardo Parreira da Silva (60h)
        ( 875, 4, 'MAT0022', '3'),   -- Irving Joseph Ramirez Barreto (60h)
        (1222, 4, 'MAT0022', '4'),   -- Geovane Matheus Lemes Andrade (60h)
        ( 741, 4, 'MAT0022', '5'),   -- Henrique Costa dos Reis (60h)
        ( 741, 4, 'MAT0022', '9')    -- Henrique Costa dos Reis (60h)
       ) AS v(coduser, credito, disciplina, turma)
 WHERE NOT EXISTS (
        SELECT 1 FROM oferta_horarios_rodizio_noturno_creditos c
         WHERE c.coduser = v.coduser AND c.semestre = 2 AND c.ano = 2026
           AND c.disciplina = v.disciplina AND c.turma = v.turma);

COMMIT;
