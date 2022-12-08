--Geomentria Análitica
UPDATE oferta_lista_de_ofertas SET turma = 1 WHERE disciplina = 105881 AND semestre = 1 AND ano = 2020 AND turma = 'A';
UPDATE oferta_lista_de_ofertas SET horarios = '316-516' WHERE disciplina = 105881 AND semestre = 1 AND ano = 2020 and turma = '1';
UPDATE lo_offer_list_temporary SET lol_clas = 1 WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '105881' AND lol_clas = 'A';
UPDATE lo_offer_list_temporary SET lol_sche = '316-516' WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '105881' AND lol_clas = '1';

UPDATE oferta_lista_de_ofertas SET turma = 2 WHERE disciplina = 105881 AND semestre = 1 AND ano = 2020 AND turma = 'B';
UPDATE oferta_lista_de_ofertas SET horarios = '421-219' WHERE disciplina = 105881 AND semestre = 1 AND ano = 2020 and turma = '2';
UPDATE lo_offer_list_temporary SET lol_clas = 2 WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '105881' AND lol_clas = 'B';
UPDATE lo_offer_list_temporary SET lol_sche = '421-219' WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '105881' AND lol_clas = '2';

--História da Matemática
UPDATE oferta_lista_de_ofertas SET turma = 1 WHERE disciplina = 113603 AND semestre = 1 AND ano = 2020 AND turma = 'A';
UPDATE lo_offer_list_temporary SET lol_clas = 1 WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '113603' AND lol_clas = 'A';

--TOPOLOGIA DOS ESPACOS METRICOS
UPDATE oferta_lista_de_ofertas SET turma = 1 WHERE disciplina = 113263 AND semestre = 1 AND ano = 2020 AND turma = 'A';
UPDATE lo_offer_list_temporary SET lol_clas = 1 WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '113263' AND lol_clas = 'A';

--TOPICOS DE EDUCACAO MATEMATICA
UPDATE oferta_lista_de_ofertas SET turma = 1 WHERE disciplina = 105317 AND semestre = 1 AND ano = 2020 AND turma = 'A';
UPDATE lo_offer_list_temporary SET lol_clas = 1 WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '105317' AND lol_clas = 'A';

--SEMINARIO DE TOP EM GEOMETRIA
UPDATE oferta_lista_de_ofertas SET turma = 1 WHERE disciplina = 113697 AND semestre = 1 AND ano = 2020 AND turma = 'A';
UPDATE lo_offer_list_temporary SET lol_clas = 1 WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '113697' AND lol_clas = 'A';

--Introdução a Teoria da Medida e Integração
UPDATE oferta_lista_de_ofertas SET turma = 1 WHERE disciplina = 117412 AND semestre = 1 AND ano = 2020 AND turma = 'A';
UPDATE lo_offer_list_temporary SET lol_clas = 1 WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '117412' AND lol_clas = 'A';

--SEMINARIO DE TOP MAT APLICADA
UPDATE oferta_lista_de_ofertas SET turma = 1 WHERE disciplina = 117307 AND semestre = 1 AND ano = 2020 AND turma = 'A';
UPDATE lo_offer_list_temporary SET lol_clas = 1 WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '117307' AND lol_clas = 'A';

--MAT1
UPDATE oferta_lista_de_ofertas SET turma = 10 WHERE disciplina = 113018 AND semestre = 1 AND ano = 2020 AND turma = 'L';
UPDATE oferta_lista_de_ofertas SET horarios = '321-521' WHERE disciplina = 113018 AND semestre = 1 AND ano = 2020 and turma = '10';
UPDATE oferta_grupos_magistral_teoria SET turmas = 10 WHERE codigo = 113018 AND semestre = 1 AND ano = 2020 AND turmas = 'L';
UPDATE oferta_grupos_magistral_teoria SET horario = '321-521' WHERE codigo = 113018 AND semestre = 1 AND ano = 2020 AND turmas = '10';
UPDATE lo_offer_list_temporary SET lol_clas = 10 WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '113018' AND lol_clas = 'L';
UPDATE lo_offer_list_temporary SET lol_sche = '321-521' WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '113018' AND lol_clas = '10';
UPDATE lo_offer_list_magisterial set lom_clas = 10 WHERE lom_seme = 1 AND lom_year=2020 AND lom_cdis=113018 AND lom_type = 'E' AND lom_clas = 'L';
UPDATE lo_offer_list_magisterial set lom_clas = 10 WHERE lom_seme = 1 AND lom_year=2020 AND lom_cdis=113018 AND lom_type = 'T' AND lom_clas = 'L';
UPDATE lo_offer_list_magisterial set lom_sche = '321' WHERE lom_seme = 1 AND lom_year=2020 AND lom_cdis=113018 AND lom_type = 'T' AND lom_clas = '10';

--UPDATE oferta_grupos_magistral_teoria SET grupo = 4 WHERE codigo = 113018 AND semestre = 1 AND ano = 2020 AND turmas = '10';

UPDATE oferta_lista_de_ofertas SET turma = 1 WHERE disciplina = 113018 AND semestre = 1 AND ano = 2020 AND turma = 'B';
UPDATE oferta_lista_de_ofertas SET horarios = '216-416' WHERE disciplina = 113018 AND semestre = 1 AND ano = 2020 and turma = '1';
UPDATE oferta_grupos_magistral_teoria SET turmas = 1 WHERE codigo = 113018 AND semestre = 1 AND ano = 2020 AND turmas = 'B';
UPDATE oferta_grupos_magistral_teoria SET horario = '216-416' WHERE codigo = 113018 AND semestre = 1 AND ano = 2020 AND turmas = '1';
UPDATE lo_offer_list_temporary SET lol_clas = 1 WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '113018' AND lol_clas = 'B';
UPDATE lo_offer_list_temporary SET lol_sche = '216-416' WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '113018' AND lol_clas = '1';
UPDATE lo_offer_list_magisterial set lom_clas = 1 WHERE lom_seme = 1 AND lom_year=2020 AND lom_cdis=113018 AND lom_type = 'E' AND lom_clas = 'B';

--UPDATE oferta_grupos_magistral_teoria SET grupo = 1 WHERE codigo = 113018 AND semestre = 1 AND ano = 2020 AND turmas = '1';

UPDATE oferta_lista_de_ofertas SET turma = 4 WHERE disciplina = 113018 AND semestre = 1 AND ano = 2020 AND turma = 'AB';
UPDATE oferta_lista_de_ofertas SET horarios = '216-416' WHERE disciplina = 113018 AND semestre = 1 AND ano = 2020 and turma = '4';
UPDATE oferta_grupos_magistral_teoria SET turmas = 4 WHERE codigo = 113018 AND semestre = 1 AND ano = 2020 AND turmas = 'AB';
UPDATE oferta_grupos_magistral_teoria SET horario = '216-416' WHERE codigo = 113018 AND semestre = 1 AND ano = 2020 AND turmas = '4';
UPDATE lo_offer_list_temporary SET lol_clas = 4 WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '113018' AND lol_clas = 'AB';
UPDATE lo_offer_list_temporary SET lol_sche = '216-416' WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '113018' AND lol_clas = '4';
UPDATE lo_offer_list_magisterial set lom_clas = 4 WHERE lom_seme = 1 AND lom_year=2020 AND lom_cdis=113018 AND lom_type = 'E' AND lom_clas = 'AB';

--UPDATE oferta_grupos_magistral_teoria SET grupo = 1 WHERE codigo = 113018 AND semestre = 1 AND ano = 2020 AND turmas = '4';

UPDATE oferta_lista_de_ofertas SET turma = 2 WHERE disciplina = 113018 AND semestre = 1 AND ano = 2020 AND turma = 'A';
UPDATE oferta_lista_de_ofertas SET horarios = '216-416' WHERE disciplina = 113018 AND semestre = 1 AND ano = 2020 and turma = '2';
UPDATE oferta_grupos_magistral_teoria SET turmas = 2 WHERE codigo = 113018 AND semestre = 1 AND ano = 2020 AND turmas = 'A';
UPDATE oferta_grupos_magistral_teoria SET horario = '216-416' WHERE codigo = 113018 AND semestre = 1 AND ano = 2020 AND turmas = '2';
UPDATE lo_offer_list_temporary SET lol_clas = 2 WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '113018' AND lol_clas = 'A';
UPDATE lo_offer_list_temporary SET lol_sche = '216-416' WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '113018' AND lol_clas = '2';
UPDATE lo_offer_list_magisterial set lom_clas = 2 WHERE lom_seme = 1 AND lom_year=2020 AND lom_cdis=113018 AND lom_type = 'E' AND lom_clas = 'A';
UPDATE lo_offer_list_magisterial set lom_clas = '2-4-1' WHERE lom_seme = 1 AND lom_year=2020 AND lom_cdis=113018 AND lom_type = 'T' AND lom_clas = 'A-AB-B';
UPDATE lo_offer_list_magisterial set lom_sche = '216' WHERE lom_seme = 1 AND lom_year=2020 AND lom_cdis=113018 AND lom_type = 'T' AND lom_clas = '2-4-1';

--UPDATE oferta_grupos_magistral_teoria SET grupo = 1 WHERE codigo = 113018 AND semestre = 1 AND ano = 2020 AND turmas = '2';

UPDATE oferta_lista_de_ofertas SET turma = 8 WHERE disciplina = 113018 AND semestre = 1 AND ano = 2020 AND turma = 'C';
UPDATE oferta_lista_de_ofertas SET horarios = '308-508' WHERE disciplina = 113018 AND semestre = 1 AND ano = 2020 and turma = '8';
UPDATE oferta_grupos_magistral_teoria SET grupo = 2 WHERE codigo = 113018 AND semestre = 1 AND ano = 2020 AND turmas = 'C';
UPDATE oferta_grupos_magistral_teoria SET turmas = 8 WHERE codigo = 113018 AND semestre = 1 AND ano = 2020 AND turmas = 'C';
UPDATE oferta_grupos_magistral_teoria SET horario = '308-508' WHERE codigo = 113018 AND semestre = 1 AND ano = 2020 AND turmas = '8';
UPDATE lo_offer_list_temporary SET lol_clas = 8 WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '113018' AND lol_clas = 'C';
UPDATE lo_offer_list_temporary SET lol_sche = '308-508' WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '113018' AND lol_clas = '8';
UPDATE lo_offer_list_magisterial set lom_clas = 8 WHERE lom_seme = 1 AND lom_year=2020 AND lom_cdis=113018 AND lom_type = 'E' AND lom_clas = '8';
UPDATE lo_offer_list_magisterial set lom_clas = 8 WHERE lom_seme = 1 AND lom_year=2020 AND lom_cdis=113018 AND lom_type = 'T' AND lom_clas = '8';
UPDATE lo_offer_list_magisterial set lom_sche = '308' WHERE lom_seme = 1 AND lom_year=2020 AND lom_cdis=113018 AND lom_type = 'T' AND lom_clas = '8';

UPDATE oferta_lista_de_ofertas SET turma = 11 WHERE disciplina = 113018 AND semestre = 1 AND ano = 2020 AND turma = 'E';
UPDATE oferta_lista_de_ofertas SET horarios = '219-419' WHERE disciplina = 113018 AND semestre = 1 AND ano = 2020 and turma = '11';
UPDATE oferta_grupos_magistral_teoria SET turmas = 11 WHERE codigo = 113018 AND semestre = 1 AND ano = 2020 AND turmas = 'E';
UPDATE oferta_grupos_magistral_teoria SET horario = '219-419' WHERE codigo = 113018 AND semestre = 1 AND ano = 2020 AND turmas = '11';
UPDATE lo_offer_list_temporary SET lol_clas = 11 WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '113018' AND lol_clas = 'E';
UPDATE lo_offer_list_temporary SET lol_sche = '219-419' WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '113018' AND lol_clas = '11';
UPDATE lo_offer_list_magisterial set lom_clas = 11 WHERE lom_seme = 1 AND lom_year=2020 AND lom_cdis=113018 AND lom_type = 'E' AND lom_clas = 'E';
UPDATE lo_offer_list_magisterial set lom_clas = '11-3-9' WHERE lom_seme = 1 AND lom_year=2020 AND lom_cdis=113018 AND lom_type = 'T' AND lom_clas = 'E-K-N';
--UPDATE oferta_grupos_magistral_teoria SET grupo = 3 WHERE codigo = 113018 AND semestre = 1 AND ano = 2020 AND turmas = '11';

UPDATE oferta_lista_de_ofertas SET turma = 3 WHERE disciplina = 113018 AND semestre = 1 AND ano = 2020 AND turma = 'K';
UPDATE oferta_lista_de_ofertas SET horarios = '219-621' WHERE disciplina = 113018 AND semestre = 1 AND ano = 2020 and turma = '3';
UPDATE oferta_grupos_magistral_teoria SET turmas = 3 WHERE codigo = 113018 AND semestre = 1 AND ano = 2020 AND turmas = 'K';
UPDATE oferta_grupos_magistral_teoria SET horario = '219-621' WHERE codigo = 113018 AND semestre = 1 AND ano = 2020 AND turmas = '3';
UPDATE lo_offer_list_temporary SET lol_clas = 3 WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '113018' AND lol_clas = 'K';
UPDATE lo_offer_list_temporary SET lol_sche = '219-621' WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '113018' AND lol_clas = '1';
UPDATE lo_offer_list_magisterial set lom_clas = 3 WHERE lom_seme = 1 AND lom_year=2020 AND lom_cdis=113018 AND lom_type = 'E' AND lom_clas = 'K';
--UPDATE oferta_grupos_magistral_teoria SET grupo = 3 WHERE codigo = 113018 AND semestre = 1 AND ano = 2020 AND turmas = '3';


UPDATE oferta_lista_de_ofertas SET turma = 7 WHERE disciplina = 113018 AND semestre = 1 AND ano = 2020 AND turma = 'M';
UPDATE oferta_lista_de_ofertas SET horarios = '321-521' WHERE disciplina = 113018 AND semestre = 1 AND ano = 2020 and turma = '7';
UPDATE oferta_grupos_magistral_teoria SET turmas = 7 WHERE codigo = 113018 AND semestre = 1 AND ano = 2020 AND turmas = 'M';
UPDATE oferta_grupos_magistral_teoria SET horario = '321-521' WHERE codigo = 113018 AND semestre = 1 AND ano = 2020 AND turmas = '7';
UPDATE lo_offer_list_temporary SET lol_clas = 7 WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '113018' AND lol_clas = 'M';
UPDATE lo_offer_list_temporary SET lol_sche = '321-521' WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '113018' AND lol_clas = '7';

--UPDATE oferta_grupos_magistral_teoria SET grupo = 4 WHERE codigo = 113018 AND semestre = 1 AND ano = 2020 AND turmas = '7';

UPDATE oferta_lista_de_ofertas SET turma = 9 WHERE disciplina = 113018 AND semestre = 1 AND ano = 2020 AND turma = 'N';
UPDATE oferta_lista_de_ofertas SET horarios = '219-419' WHERE disciplina = 113018 AND semestre = 1 AND ano = 2020 and turma = '9';
UPDATE oferta_grupos_magistral_teoria SET turmas = 9 WHERE codigo = 113018 AND semestre = 1 AND ano = 2020 AND turmas = 'N';
UPDATE oferta_grupos_magistral_teoria SET horario = '219-419' WHERE codigo = 113018 AND semestre = 1 AND ano = 2020 AND turmas = '9';
UPDATE lo_offer_list_temporary SET lol_clas = 9 WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '113018' AND lol_clas = 'N';
UPDATE lo_offer_list_temporary SET lol_sche = '219-419' WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '113018' AND lol_clas = '9';
UPDATE lo_offer_list_magisterial set lom_clas = 9 WHERE lom_seme = 1 AND lom_year=2020 AND lom_cdis=113018 AND lom_type = 'E' AND lom_clas = 'N';

UPDATE oferta_lista_de_ofertas SET turma = 6 WHERE disciplina = 113018 AND semestre = 1 AND ano = 2020 AND turma = 'G';
UPDATE oferta_lista_de_ofertas SET horarios = '419-619' WHERE disciplina = 113018 AND semestre = 1 AND ano = 2020 and turma = '6';
UPDATE oferta_grupos_magistral_teoria SET turmas = 6 WHERE codigo = 113018 AND semestre = 1 AND ano = 2020 AND turmas = 'G';
UPDATE oferta_grupos_magistral_teoria SET horario = '419-619' WHERE codigo = 113018 AND semestre = 1 AND ano = 2020 AND turmas = '6';
UPDATE lo_offer_list_temporary SET lol_clas = 6 WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '113018' AND lol_clas = 'G';
UPDATE lo_offer_list_temporary SET lol_sche = '419-619' WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '113018' AND lol_clas = '6';
UPDATE lo_offer_list_magisterial set lom_clas = 6 WHERE lom_seme = 1 AND lom_year=2020 AND lom_cdis=113018 AND lom_type = 'E' AND lom_clas = 'G';


UPDATE oferta_lista_de_ofertas SET turma = 5 WHERE disciplina = 113018 AND semestre = 1 AND ano = 2020 AND turma = 'H';
UPDATE oferta_lista_de_ofertas SET horarios = '308-508' WHERE disciplina = 113018 AND semestre = 1 AND ano = 2020 and turma = '5';
UPDATE oferta_grupos_magistral_teoria SET turmas = 5 WHERE codigo = 113018 AND semestre = 1 AND ano = 2020 AND turmas = 'H';
UPDATE oferta_grupos_magistral_teoria SET horario = '308-508' WHERE codigo = 113018 AND semestre = 1 AND ano = 2020 AND turmas = '5';
UPDATE lo_offer_list_temporary SET lol_clas = 5 WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '113018' AND lol_clas = 'H';
UPDATE lo_offer_list_temporary SET lol_sche = '308-508' WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '113018' AND lol_clas = '5';
UPDATE lo_offer_list_magisterial set lom_clas = 5 WHERE lom_seme = 1 AND lom_year=2020 AND lom_cdis=113018 AND lom_type = 'E' AND lom_clas = 'H';

UPDATE oferta_lista_de_ofertas SET turma = 12 WHERE disciplina = 113018 AND semestre = 1 AND ano = 2020 AND turma = 'I';
UPDATE oferta_lista_de_ofertas SET horarios = '419-619' WHERE disciplina = 113018 AND semestre = 1 AND ano = 2020 and turma = '12';
UPDATE oferta_grupos_magistral_teoria SET turmas = 12 WHERE codigo = 113018 AND semestre = 1 AND ano = 2020 AND turmas = 'I';
UPDATE oferta_grupos_magistral_teoria SET horario = '419-619' WHERE codigo = 113018 AND semestre = 1 AND ano = 2020 AND turmas = '12';
UPDATE lo_offer_list_temporary SET lol_clas = 12 WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '113018' AND lol_clas = 'I';
UPDATE lo_offer_list_temporary SET lol_sche = '419-619' WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '113018' AND lol_clas = '12';
UPDATE lo_offer_list_magisterial set lom_clas = 12 WHERE lom_seme = 1 AND lom_year=2020 AND lom_cdis=113018 AND lom_type = 'E' AND lom_clas = 'I';

--UPDATE oferta_grupos_magistral_teoria SET grupo = 3 WHERE codigo = 113018 AND semestre = 1 AND ano = 2020 AND turmas = '9';

--C1
UPDATE oferta_lista_de_ofertas SET turma = 27 WHERE disciplina = 113034 AND semestre = 1 AND ano = 2020 AND turma = 'A';
UPDATE oferta_lista_de_ofertas SET horarios = '210-310-510' WHERE disciplina = 113034 AND semestre = 1 AND ano = 2020 and turma = '27';
UPDATE oferta_grupos_magistral_teoria SET turmas = 27 WHERE codigo = 113034 AND semestre = 1 AND ano = 2020 AND turmas = 'A';
UPDATE oferta_grupos_magistral_teoria SET horario = '210-310-510' WHERE codigo = 113034 AND semestre = 1 AND ano = 2020 AND turmas = '27';
UPDATE lo_offer_list_temporary SET lol_clas = 27 WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '113034' AND lol_clas = 'A';
UPDATE lo_offer_list_temporary SET lol_sche = '210-310-510' WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '113034' AND lol_clas = '27';
UPDATE lo_offer_list_magisterial set lom_clas = 27 WHERE lom_seme = 1 AND lom_year=2020 AND lom_cdis=113034 AND lom_type = 'E' AND lom_clas = 'A';
UPDATE lo_offer_list_magisterial set lom_sche = '210-310-510' WHERE lom_seme = 1 AND lom_year=2020 AND lom_cdis=113034 AND lom_type = 'T' AND lom_clas = 'A-F';
UPDATE lo_offer_list_magisterial set lom_clas = '27-13' WHERE lom_seme = 1 AND lom_year=2020 AND lom_cdis=113034 AND lom_type = 'T' AND lom_clas = 'A-F';


--UPDATE oferta_grupos_magistral_teoria SET grupo = 3 WHERE codigo = 113018 AND semestre = 1 AND ano = 2020 AND turmas = '27';

UPDATE oferta_lista_de_ofertas SET turma = 2 WHERE disciplina = 113034 AND semestre = 1 AND ano = 2020 AND turma = 'B';
UPDATE oferta_lista_de_ofertas SET horarios = '214-414-614' WHERE disciplina = 113034 AND semestre = 1 AND ano = 2020 and turma = '2';
UPDATE oferta_grupos_magistral_teoria SET turmas = 2 WHERE codigo = 113034 AND semestre = 1 AND ano = 2020 AND turmas = 'B';
UPDATE oferta_grupos_magistral_teoria SET horario = '214-414-614' WHERE codigo = 113034 AND semestre = 1 AND ano = 2020 AND turmas = '2';
UPDATE lo_offer_list_temporary SET lol_clas = 2 WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '113034' AND lol_clas = 'B';
UPDATE lo_offer_list_temporary SET lol_sche = '214-414-614' WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '113034' AND lol_clas = '2';
UPDATE lo_offer_list_magisterial SET lom_clas = 2 WHERE lom_seme = 1 AND lom_year=2020 AND lom_cdis=113034 AND lom_type = 'E' AND lom_clas = 'B';
UPDATE lo_offer_list_magisterial SET lom_sche = '214-414-614' WHERE lom_seme = 1 AND lom_year=2020 AND lom_cdis=113034 AND lom_type = 'T' AND lom_clas = 'B-Z';
UPDATE lo_offer_list_magisterial SET lom_clas = '2-16' WHERE lom_seme = 1 AND lom_year=2020 AND lom_cdis=113034 AND lom_type = 'T' AND lom_clas = 'B-Z';

UPDATE oferta_lista_de_ofertas SET turma = 31 WHERE disciplina = 113034 AND semestre = 1 AND ano = 2020 AND turma = 'C';
UPDATE oferta_lista_de_ofertas SET horarios = '308-508-608' WHERE disciplina = 113034 AND semestre = 1 AND ano = 2020 and turma = '31';
UPDATE oferta_grupos_magistral_teoria SET turmas = 31 WHERE codigo = 113034 AND semestre = 1 AND ano = 2020 AND turmas = 'C';
UPDATE oferta_grupos_magistral_teoria SET horario = '308-508-608' WHERE codigo = 113034 AND semestre = 1 AND ano = 2020 AND turmas = '31';
UPDATE lo_offer_list_temporary SET lol_clas = 31 WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '113034' AND lol_clas = 'C';
UPDATE lo_offer_list_temporary SET lol_sche = '308-508-608' WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '113034' AND lol_clas = '31';
UPDATE lo_offer_list_magisterial SET lom_clas = 31 WHERE lom_seme = 1 AND lom_year=2020 AND lom_cdis=113034 AND lom_type = 'E' AND lom_clas = 'C';
UPDATE lo_offer_list_magisterial SET lom_sche = '308-508-608' WHERE lom_seme = 1 AND lom_year=2020 AND lom_cdis=113034 AND lom_type = 'T' AND lom_clas = 'C-H';
UPDATE lo_offer_list_magisterial SET lom_clas = '31-21' WHERE lom_seme = 1 AND lom_year=2020 AND lom_cdis=113034 AND lom_type = 'T' AND lom_clas = 'C-H';

UPDATE oferta_lista_de_ofertas SET turma = 3 WHERE disciplina = 113034 AND semestre = 1 AND ano = 2020 AND turma = 'D';
UPDATE oferta_lista_de_ofertas SET horarios = '210-310-510' WHERE disciplina = 113034 AND semestre = 1 AND ano = 2020 and turma = '3';
UPDATE oferta_grupos_magistral_teoria SET turmas = 3 WHERE codigo = 113034 AND semestre = 1 AND ano = 2020 AND turmas = 'D';
UPDATE oferta_grupos_magistral_teoria SET horario = '210-310-510' WHERE codigo = 113034 AND semestre = 1 AND ano = 2020 AND turmas = '3';
UPDATE lo_offer_list_temporary SET lol_clas = 3 WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '113034' AND lol_clas = 'D';
UPDATE lo_offer_list_temporary SET lol_sche = '210-310-510' WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '113034' AND lol_clas = '3';
UPDATE lo_offer_list_magisterial SET lom_clas = 3 WHERE lom_seme = 1 AND lom_year=2020 AND lom_cdis=113034 AND lom_type = 'E' AND lom_clas = 'D';
UPDATE lo_offer_list_magisterial SET lom_sche = '210-310-510' WHERE lom_seme = 1 AND lom_year=2020 AND lom_cdis=113034 AND lom_type = 'T' AND lom_clas = 'D-H';
UPDATE lo_offer_list_magisterial SET lom_clas = '3-21' WHERE lom_seme = 1 AND lom_year=2020 AND lom_cdis=113034 AND lom_type = 'T' AND lom_clas = 'D-H';
UPDATE lo_offer_list_magisterial SET lom_sche = '210-310-510' WHERE lom_seme = 1 AND lom_year=2020 AND lom_cdis=113034 AND lom_type = 'T' AND lom_clas = 'D-M';
UPDATE lo_offer_list_magisterial SET lom_clas = '3-14' WHERE lom_seme = 1 AND lom_year=2020 AND lom_cdis=113034 AND lom_type = 'T' AND lom_clas = 'D-M';

UPDATE oferta_lista_de_ofertas SET turma = 32 WHERE disciplina = 113034 AND semestre = 1 AND ano = 2020 AND turma = 'E';
UPDATE oferta_lista_de_ofertas SET horarios = '214-414-614' WHERE disciplina = 113034 AND semestre = 1 AND ano = 2020 and turma = '32';
UPDATE oferta_grupos_magistral_teoria SET turmas = 32 WHERE codigo = 113034 AND semestre = 1 AND ano = 2020 AND turmas = 'E';
UPDATE oferta_grupos_magistral_teoria SET horario = '214-414-614' WHERE codigo = 113034 AND semestre = 1 AND ano = 2020 AND turmas = '32';
UPDATE lo_offer_list_temporary SET lol_clas = 32 WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '113034' AND lol_clas = 'E';
UPDATE lo_offer_list_temporary SET lol_sche = '214-414-614' WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '113034' AND lol_clas = '32';
UPDATE lo_offer_list_magisterial SET lom_sche = '214-414-614' WHERE lom_seme = 1 AND lom_year=2020 AND lom_cdis=113034 AND lom_type = 'T' AND lom_clas = 'E';
UPDATE lo_offer_list_magisterial SET lom_clas = 32 WHERE lom_seme = 1 AND lom_year=2020 AND lom_cdis=113034 AND lom_type = 'E' AND lom_clas = 'E';
UPDATE lo_offer_list_magisterial SET lom_clas = 32 WHERE lom_seme = 1 AND lom_year=2020 AND lom_cdis=113034 AND lom_type = 'T' AND lom_clas = 'E';

UPDATE oferta_lista_de_ofertas SET turma = 13 WHERE disciplina = 113034 AND semestre = 1 AND ano = 2020 AND turma = 'F';
UPDATE oferta_lista_de_ofertas SET horarios = '210-310-510' WHERE disciplina = 113034 AND semestre = 1 AND ano = 2020 and turma = '13';
UPDATE oferta_grupos_magistral_teoria SET turmas = 13 WHERE codigo = 113034 AND semestre = 1 AND ano = 2020 AND turmas = 'F';
UPDATE oferta_grupos_magistral_teoria SET horario = '210-310-510' WHERE codigo = 113034 AND semestre = 1 AND ano = 2020 AND turmas = '13';
UPDATE lo_offer_list_temporary SET lol_clas = 13 WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '113034' AND lol_clas = 'F';
UPDATE lo_offer_list_temporary SET lol_sche = '210-310-510' WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '113034' AND lol_clas = '13';
UPDATE lo_offer_list_magisterial SET lom_clas = 13 WHERE lom_seme = 1 AND lom_year=2020 AND lom_cdis=113034 AND lom_type = 'E' AND lom_clas = 'F';

UPDATE oferta_lista_de_ofertas SET turma = 26 WHERE disciplina = 113034 AND semestre = 1 AND ano = 2020 AND turma = 'G';
UPDATE oferta_lista_de_ofertas SET horarios = '219-321-521' WHERE disciplina = 113034 AND semestre = 1 AND ano = 2020 and turma = '26';
UPDATE oferta_grupos_magistral_teoria SET turmas = 26 WHERE codigo = 113034 AND semestre = 1 AND ano = 2020 AND turmas = 'G';
UPDATE oferta_grupos_magistral_teoria SET horario = '219-321-521' WHERE codigo = 113034 AND semestre = 1 AND ano = 2020 AND turmas = '26';
UPDATE lo_offer_list_temporary SET lol_clas = 26 WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '113034' AND lol_clas = 'G';
UPDATE lo_offer_list_temporary SET lol_sche = '219-321-521' WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '113034' AND lol_clas = '26';
UPDATE lo_offer_list_magisterial SET lom_clas = 26 WHERE lom_seme = 1 AND lom_year=2020 AND lom_cdis=113034 AND lom_type = 'E' AND lom_clas = 'G';
UPDATE lo_offer_list_magisterial SET lom_sche = '219-321-521' WHERE lom_seme = 1 AND lom_year=2020 AND lom_cdis=113034 AND lom_type = 'T' AND lom_clas = 'G-K';
UPDATE lo_offer_list_magisterial SET lom_clas = '26-24' WHERE lom_seme = 1 AND lom_year=2020 AND lom_cdis=113034 AND lom_type = 'T' AND lom_clas = 'G-K';

UPDATE oferta_lista_de_ofertas SET turma = 21 WHERE disciplina = 113034 AND semestre = 1 AND ano = 2020 AND turma = 'H';
UPDATE oferta_lista_de_ofertas SET horarios = '308-508-608' WHERE disciplina = 113034 AND semestre = 1 AND ano = 2020 and turma = '21';
UPDATE oferta_grupos_magistral_teoria SET turmas = 21 WHERE codigo = 113034 AND semestre = 1 AND ano = 2020 AND turmas = 'H';
UPDATE oferta_grupos_magistral_teoria SET horario = '308-508-608' WHERE codigo = 113034 AND semestre = 1 AND ano = 2020 AND turmas = '21';
UPDATE lo_offer_list_temporary SET lol_clas = 21 WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '113034' AND lol_clas = 'H';
UPDATE lo_offer_list_temporary SET lol_sche = '308-508-608' WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '113034' AND lol_clas = '21';
UPDATE lo_offer_list_magisterial set lom_clas = 21 WHERE lom_seme = 1 AND lom_year=2020 AND lom_cdis=113034 AND lom_type = 'E' AND lom_clas = 'H';

UPDATE oferta_lista_de_ofertas SET turma = 23 WHERE disciplina = 113034 AND semestre = 1 AND ano = 2020 AND turma = 'I';
UPDATE oferta_lista_de_ofertas SET horarios = '219-321-521' WHERE disciplina = 113034 AND semestre = 1 AND ano = 2020 and turma = '23';
UPDATE oferta_grupos_magistral_teoria SET turmas = 23 WHERE codigo = 113034 AND semestre = 1 AND ano = 2020 AND turmas = 'I';
UPDATE oferta_grupos_magistral_teoria SET horario = '219-321-521' WHERE codigo = 113034 AND semestre = 1 AND ano = 2020 AND turmas = '23';
UPDATE lo_offer_list_temporary SET lol_clas = 23 WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '113034' AND lol_clas = 'I';
UPDATE lo_offer_list_temporary SET lol_sche = '219-321-521' WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '113034' AND lol_clas = '23';
UPDATE lo_offer_list_magisterial set lom_clas = 23 WHERE lom_seme = 1 AND lom_year=2020 AND lom_cdis=113034 AND lom_type = 'E' AND lom_clas = 'I';
UPDATE lo_offer_list_magisterial set lom_clas = 23 WHERE lom_seme = 1 AND lom_year=2020 AND lom_cdis=113034 AND lom_type = 'T' AND lom_clas = 'I';
UPDATE lo_offer_list_magisterial set lom_sche = '219' WHERE lom_seme = 1 AND lom_year=2020 AND lom_cdis=113034 AND lom_type = 'T' AND lom_clas = '23';

UPDATE oferta_lista_de_ofertas SET turma = 22 WHERE disciplina = 113034 AND semestre = 1 AND ano = 2020 AND turma = 'J';
UPDATE oferta_lista_de_ofertas SET horarios = '214-414-614' WHERE disciplina = 113034 AND semestre = 1 AND ano = 2020 and turma = '22';
UPDATE oferta_grupos_magistral_teoria SET turmas = 22 WHERE codigo = 113034 AND semestre = 1 AND ano = 2020 AND turmas = 'J';
UPDATE oferta_grupos_magistral_teoria SET horario = '214-414-614' WHERE codigo = 113034 AND semestre = 1 AND ano = 2020 AND turmas = '22';
UPDATE lo_offer_list_temporary SET lol_clas = 22 WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '113034' AND lol_clas = 'J';
UPDATE lo_offer_list_temporary SET lol_sche = '214-414-614' WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '113034' AND lol_clas = '22';
UPDATE lo_offer_list_magisterial set lom_clas = 22 WHERE lom_seme = 1 AND lom_year=2020 AND lom_cdis=113034 AND lom_type = 'E' AND lom_clas = 'J';
UPDATE lo_offer_list_magisterial set lom_clas = 22 WHERE lom_seme = 1 AND lom_year=2020 AND lom_cdis=113034 AND lom_type = 'T' AND lom_clas = 'J';
UPDATE lo_offer_list_magisterial set lom_sche = '214' WHERE lom_seme = 1 AND lom_year=2020 AND lom_cdis=113034 AND lom_type = 'T' AND lom_clas = '22';

UPDATE oferta_lista_de_ofertas SET turma = 24 WHERE disciplina = 113034 AND semestre = 1 AND ano = 2020 AND turma = 'K';
UPDATE oferta_lista_de_ofertas SET horarios = '219-321-521' WHERE disciplina = 113034 AND semestre = 1 AND ano = 2020 and turma = '24';
UPDATE oferta_grupos_magistral_teoria SET turmas = 24 WHERE codigo = 113034 AND semestre = 1 AND ano = 2020 AND turmas = 'K';
UPDATE oferta_grupos_magistral_teoria SET horario = '219-321-521' WHERE codigo = 113034 AND semestre = 1 AND ano = 2020 AND turmas = '24';
UPDATE lo_offer_list_temporary SET lol_clas = 24 WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '113034' AND lol_clas = 'K';
UPDATE lo_offer_list_temporary SET lol_sche = '219-321-521' WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '113034' AND lol_clas = '24';
UPDATE lo_offer_list_magisterial set lom_clas = 24 WHERE lom_seme = 1 AND lom_year=2020 AND lom_cdis=113034 AND lom_type = 'E' AND lom_clas = 'K';

UPDATE oferta_lista_de_ofertas SET turma = 14 WHERE disciplina = 113034 AND semestre = 1 AND ano = 2020 AND turma = 'M';
UPDATE oferta_lista_de_ofertas SET horarios = '210-310-510' WHERE disciplina = 113034 AND semestre = 1 AND ano = 2020 and turma = '14';
UPDATE oferta_grupos_magistral_teoria SET turmas = 14 WHERE codigo = 113034 AND semestre = 1 AND ano = 2020 AND turmas = 'M';
UPDATE oferta_grupos_magistral_teoria SET horario = '210-310-510' WHERE codigo = 113034 AND semestre = 1 AND ano = 2020 AND turmas = '14';
UPDATE lo_offer_list_temporary SET lol_clas = 14 WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '113034' AND lol_clas = 'M';
UPDATE lo_offer_list_temporary SET lol_sche = '210-310-510' WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '113034' AND lol_clas = '14';
UPDATE lo_offer_list_magisterial set lom_clas = 14 WHERE lom_seme = 1 AND lom_year=2020 AND lom_cdis=113034 AND lom_type = 'E' AND lom_clas = 'M';

UPDATE oferta_lista_de_ofertas SET turma = 6 WHERE disciplina = 113034 AND semestre = 1 AND ano = 2020 AND turma = 'N';
UPDATE oferta_lista_de_ofertas SET horarios = '210-310-410' WHERE disciplina = 113034 AND semestre = 1 AND ano = 2020 and turma = '6';
UPDATE oferta_grupos_magistral_teoria SET turmas = 6 WHERE codigo = 113034 AND semestre = 1 AND ano = 2020 AND turmas = 'N';
UPDATE oferta_grupos_magistral_teoria SET horario = '210-310-410' WHERE codigo = 113034 AND semestre = 1 AND ano = 2020 AND turmas = '6';
UPDATE lo_offer_list_temporary SET lol_clas = 6 WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '113034' AND lol_clas = 'N';
UPDATE lo_offer_list_temporary SET lol_sche = '210-310-410' WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '113034' AND lol_clas = '6';
UPDATE lo_offer_list_magisterial set lom_clas = 6 WHERE lom_seme = 1 AND lom_year=2020 AND lom_cdis=113034 AND lom_type = 'E' AND lom_clas = 'N';
UPDATE lo_offer_list_magisterial set lom_clas = 6 WHERE lom_seme = 1 AND lom_year=2020 AND lom_cdis=113034 AND lom_type = 'T' AND lom_clas = 'N';
UPDATE lo_offer_list_magisterial set lom_sche = '210' WHERE lom_seme = 1 AND lom_year=2020 AND lom_cdis=113034 AND lom_type = 'T' AND lom_clas = '6';

UPDATE oferta_lista_de_ofertas SET turma = 9 WHERE disciplina = 113034 AND semestre = 1 AND ano = 2020 AND turma = 'O';
UPDATE oferta_lista_de_ofertas SET horarios = '308-508-608' WHERE disciplina = 113034 AND semestre = 1 AND ano = 2020 and turma = '9';
UPDATE oferta_grupos_magistral_teoria SET turmas = 9 WHERE codigo = 113034 AND semestre = 1 AND ano = 2020 AND turmas = 'O';
UPDATE oferta_grupos_magistral_teoria SET horario = '308-508-608' WHERE codigo = 113034 AND semestre = 1 AND ano = 2020 AND turmas = '9';
UPDATE lo_offer_list_temporary SET lol_clas = 9 WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '113034' AND lol_clas = 'O';
UPDATE lo_offer_list_temporary SET lol_sche = '308-508-608' WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '113034' AND lol_clas = '9';
UPDATE lo_offer_list_magisterial set lom_clas = 9 WHERE lom_seme = 1 AND lom_year=2020 AND lom_cdis=113034 AND lom_type = 'E' AND lom_clas = 'O';
UPDATE lo_offer_list_magisterial set lom_clas = 9 WHERE lom_seme = 1 AND lom_year=2020 AND lom_cdis=113034 AND lom_type = 'T' AND lom_clas = 'O';
UPDATE lo_offer_list_magisterial set lom_sche = '308' WHERE lom_seme = 1 AND lom_year=2020 AND lom_cdis=113034 AND lom_type = 'T' AND lom_clas = '9';

UPDATE oferta_lista_de_ofertas SET turma = 19 WHERE disciplina = 113034 AND semestre = 1 AND ano = 2020 AND turma = 'P';
UPDATE oferta_lista_de_ofertas SET horarios = '219-321-521' WHERE disciplina = 113034 AND semestre = 1 AND ano = 2020 and turma = '19';
UPDATE oferta_grupos_magistral_teoria SET turmas = 19 WHERE codigo = 113034 AND semestre = 1 AND ano = 2020 AND turmas = 'P';
UPDATE oferta_grupos_magistral_teoria SET horario = '219-321-521' WHERE codigo = 113034 AND semestre = 1 AND ano = 2020 AND turmas = '19';
UPDATE lo_offer_list_temporary SET lol_clas = 19 WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '113034' AND lol_clas = 'P';
UPDATE lo_offer_list_temporary SET lol_sche = '219-321-521' WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '113034' AND lol_clas = '19';
UPDATE lo_offer_list_magisterial set lom_clas = 19 WHERE lom_seme = 1 AND lom_year=2020 AND lom_cdis=113034 AND lom_type = 'E' AND lom_clas = 'P';
UPDATE lo_offer_list_magisterial set lom_clas = '9-29-28' WHERE lom_seme = 1 AND lom_year=2020 AND lom_cdis=113034 AND lom_type = 'T' AND lom_clas = 'P-Q-R';
UPDATE lo_offer_list_magisterial set lom_clas = '9-29-7' WHERE lom_seme = 1 AND lom_year=2020 AND lom_cdis=113034 AND lom_type = 'T' AND lom_clas = 'P-Q-T';

UPDATE oferta_lista_de_ofertas SET turma = 29 WHERE disciplina = 113034 AND semestre = 1 AND ano = 2020 AND turma = 'Q';
UPDATE oferta_lista_de_ofertas SET horarios = '219-419-619' WHERE disciplina = 113034 AND semestre = 1 AND ano = 2020 and turma = '29';
UPDATE oferta_grupos_magistral_teoria SET turmas = 29 WHERE codigo = 113034 AND semestre = 1 AND ano = 2020 AND turmas = 'Q';
UPDATE oferta_grupos_magistral_teoria SET horario = '219-419-619' WHERE codigo = 113034 AND semestre = 1 AND ano = 2020 AND turmas = '29';
UPDATE lo_offer_list_temporary SET lol_clas = 29 WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '113034' AND lol_clas = 'Q';
UPDATE lo_offer_list_temporary SET lol_sche = '219-419-619' WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '113034' AND lol_clas = '29';
UPDATE lo_offer_list_magisterial set lom_clas = 29 WHERE lom_seme = 1 AND lom_year=2020 AND lom_cdis=113034 AND lom_clas = 'Q' AND lom_type = 'E';

UPDATE oferta_lista_de_ofertas SET turma = 28 WHERE disciplina = 113034 AND semestre = 1 AND ano = 2020 AND turma = 'R';
UPDATE oferta_lista_de_ofertas SET horarios = '214-414-614' WHERE disciplina = 113034 AND semestre = 1 AND ano = 2020 and turma = '28';
UPDATE oferta_grupos_magistral_teoria SET turmas = 28 WHERE codigo = 113034 AND semestre = 1 AND ano = 2020 AND turmas = 'R';
UPDATE oferta_grupos_magistral_teoria SET horario = '214-414-614' WHERE codigo = 113034 AND semestre = 1 AND ano = 2020 AND turmas = '28';
UPDATE lo_offer_list_temporary SET lol_clas = 28 WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '113034' AND lol_clas = 'R';
UPDATE lo_offer_list_temporary SET lol_sche = '214-414-614' WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '113034' AND lol_clas = '28';
UPDATE lo_offer_list_magisterial set lom_clas = 28 WHERE lom_seme = 1 AND lom_year=2020 AND lom_cdis=113034 AND lom_type = 'E' AND lom_clas = 'R';
UPDATE lo_offer_list_magisterial set lom_clas = '28-11-25' WHERE lom_seme = 1 AND lom_year=2020 AND lom_cdis=113034 AND lom_type = 'T' AND lom_clas = 'R-S-Y';
UPDATE lo_offer_list_magisterial set lom_sche = '208' WHERE lom_seme = 1 AND lom_year=2020 AND lom_cdis=113034 AND lom_type = 'T' AND lom_clas = '28-11-25';

UPDATE oferta_lista_de_ofertas SET turma = 11 WHERE disciplina = 113034 AND semestre = 1 AND ano = 2020 AND turma = 'S';
UPDATE oferta_lista_de_ofertas SET horarios = '208-408-608' WHERE disciplina = 113034 AND semestre = 1 AND ano = 2020 and turma = '11';
UPDATE oferta_grupos_magistral_teoria SET turmas = 11 WHERE codigo = 113034 AND semestre = 1 AND ano = 2020 AND turmas = 'S';
UPDATE oferta_grupos_magistral_teoria SET horario = '208-408-608' WHERE codigo = 113034 AND semestre = 1 AND ano = 2020 AND turmas = '11';
UPDATE lo_offer_list_temporary SET lol_clas = 11 WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '113034' AND lol_clas = 'S';
UPDATE lo_offer_list_temporary SET lol_sche = '208-408-608' WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '113034' AND lol_clas = '11';
UPDATE lo_offer_list_magisterial set lom_clas = 11 WHERE lom_seme = 1 AND lom_year=2020 AND lom_cdis=113034 AND lom_type = 'E' AND lom_clas = 'S';

UPDATE oferta_lista_de_ofertas SET turma = 7 WHERE disciplina = 113034 AND semestre = 1 AND ano = 2020 AND turma = 'T';
UPDATE oferta_lista_de_ofertas SET horarios = '219-419-619' WHERE disciplina = 113034 AND semestre = 1 AND ano = 2020 and turma = '7';
UPDATE oferta_grupos_magistral_teoria SET turmas = 7 WHERE codigo = 113034 AND semestre = 1 AND ano = 2020 AND turmas = 'T';
UPDATE oferta_grupos_magistral_teoria SET horario = '219-419-619' WHERE codigo = 113034 AND semestre = 1 AND ano = 2020 AND turmas = '7';
UPDATE lo_offer_list_temporary SET lol_clas = 7 WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '113034' AND lol_clas = 'T';
UPDATE lo_offer_list_temporary SET lol_sche = '219-419-619' WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '113034' AND lol_clas = '7';
UPDATE lo_offer_list_magisterial set lom_clas = 7 WHERE lom_seme = 1 AND lom_year=2020 AND lom_cdis=113034 AND lom_type = 'E' AND lom_clas = 'T';

UPDATE oferta_lista_de_ofertas SET turma = 25 WHERE disciplina = 113034 AND semestre = 1 AND ano = 2020 AND turma = 'Y';
UPDATE oferta_lista_de_ofertas SET horarios = '208-408-608' WHERE disciplina = 113034 AND semestre = 1 AND ano = 2020 and turma = '25';
UPDATE oferta_grupos_magistral_teoria SET turmas = 25 WHERE codigo = 113034 AND semestre = 1 AND ano = 2020 AND turmas = 'Y';
UPDATE oferta_grupos_magistral_teoria SET horario = '208-408-608' WHERE codigo = 113034 AND semestre = 1 AND ano = 2020 AND turmas = '25';
UPDATE lo_offer_list_temporary SET lol_clas = 25 WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '113034' AND lol_clas = 'Y';
UPDATE lo_offer_list_temporary SET lol_sche = '208-408-608' WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '113034' AND lol_clas = '25';
UPDATE lo_offer_list_magisterial set lom_clas = 25 WHERE lom_seme = 1 AND lom_year=2020 AND lom_cdis=113034 AND lom_type = 'E' AND lom_clas = 'Y';

UPDATE oferta_lista_de_ofertas SET turma = 16 WHERE disciplina = 113034 AND semestre = 1 AND ano = 2020 AND turma = 'Z';
UPDATE oferta_lista_de_ofertas SET horarios = '214-414-614' WHERE disciplina = 113034 AND semestre = 1 AND ano = 2020 and turma = '16';
UPDATE oferta_grupos_magistral_teoria SET turmas = 16 WHERE codigo = 113034 AND semestre = 1 AND ano = 2020 AND turmas = 'Z';
UPDATE oferta_grupos_magistral_teoria SET horario = '214-414-614' WHERE codigo = 113034 AND semestre = 1 AND ano = 2020 AND turmas = '16';
UPDATE lo_offer_list_temporary SET lol_clas = 16 WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '113034' AND lol_clas = 'Z';
UPDATE lo_offer_list_temporary SET lol_sche = '214-414-614' WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '113034' AND lol_clas = '16';
UPDATE lo_offer_list_magisterial set lom_clas = 16 WHERE lom_seme = 1 AND lom_year=2020 AND lom_cdis=113034 AND lom_type = 'E' AND lom_clas = 'Z';

--Cálculo 1 Semipresencial
UPDATE oferta_lista_de_ofertas SET turma = 1 WHERE disciplina = 200107 AND semestre = 1 AND ano = 2020 AND turma = 'A';
UPDATE oferta_lista_de_ofertas SET horarios = '212-412-612' WHERE disciplina = 200107 AND semestre = 1 AND ano = 2020 and turma = '1';
UPDATE lo_offer_list_temporary SET lol_clas = 1 WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '200107' AND lol_clas = 'A';
UPDATE lo_offer_list_temporary SET lol_sche = '212-412-612' WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '200107' AND lol_clas = '1';

UPDATE oferta_lista_de_ofertas SET turma = 2 WHERE disciplina = 200107 AND semestre = 1 AND ano = 2020 AND turma = 'B';
UPDATE oferta_lista_de_ofertas SET horarios = '419-708-710' WHERE disciplina = 200107 AND semestre = 1 AND ano = 2020 and turma = '2';
UPDATE lo_offer_list_temporary SET lol_clas = 2 WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '200107' AND lol_clas = 'B';
UPDATE lo_offer_list_temporary SET lol_sche = '419-708-710' WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '200107' AND lol_clas = '2';

UPDATE oferta_lista_de_ofertas SET turma = 3 WHERE disciplina = 200107 AND semestre = 1 AND ano = 2020 AND turma = 'C';
UPDATE oferta_lista_de_ofertas SET horarios = '212-412-612' WHERE disciplina = 200107 AND semestre = 1 AND ano = 2020 and turma = '3';
UPDATE lo_offer_list_temporary SET lol_clas = 3 WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '200107' AND lol_clas = 'C';
UPDATE lo_offer_list_temporary SET lol_sche = '212-412-612' WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '200107' AND lol_clas = '3';

UPDATE oferta_lista_de_ofertas SET turma = 4 WHERE disciplina = 200107 AND semestre = 1 AND ano = 2020 AND turma = 'D';
UPDATE oferta_lista_de_ofertas SET horarios = '419-708-710' WHERE disciplina = 200107 AND semestre = 1 AND ano = 2020 and turma = '4';
UPDATE lo_offer_list_temporary SET lol_clas = 4 WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '200107' AND lol_clas = 'D';
UPDATE lo_offer_list_temporary SET lol_sche = '419-708-710' WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '200107' AND lol_clas = '4';

UPDATE oferta_lista_de_ofertas SET turma = 5 WHERE disciplina = 200107 AND semestre = 1 AND ano = 2020 AND turma = 'E';
UPDATE oferta_lista_de_ofertas SET horarios = '212-412-612' WHERE disciplina = 200107 AND semestre = 1 AND ano = 2020 and turma = '5';
UPDATE lo_offer_list_temporary SET lol_clas = 5 WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '200107' AND lol_clas = 'E';
UPDATE lo_offer_list_temporary SET lol_sche = '212-412-612' WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '200107' AND lol_clas = 'E';

UPDATE oferta_lista_de_ofertas SET turma = 6 WHERE disciplina = 200107 AND semestre = 1 AND ano = 2020 AND turma = 'F';
UPDATE oferta_lista_de_ofertas SET horarios = '419-708-710' WHERE disciplina = 200107 AND semestre = 1 AND ano = 2020 and turma = '6';
UPDATE lo_offer_list_temporary SET lol_clas = 6 WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '200107' AND lol_clas = 'F';
UPDATE lo_offer_list_temporary SET lol_sche = '419-708-710' WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '200107' AND lol_clas = 'F';

UPDATE oferta_lista_de_ofertas SET turma = 7 WHERE disciplina = 200107 AND semestre = 1 AND ano = 2020 AND turma = 'G';
UPDATE oferta_lista_de_ofertas SET horarios = '212-412-612' WHERE disciplina = 200107 AND semestre = 1 AND ano = 2020 and turma = '7';
UPDATE lo_offer_list_temporary SET lol_clas = 7 WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '200107' AND lol_clas = 'G';
UPDATE lo_offer_list_temporary SET lol_sche = '212-412-612' WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '200107' AND lol_clas = 'G';

UPDATE oferta_lista_de_ofertas SET turma = 8 WHERE disciplina = 200107 AND semestre = 1 AND ano = 2020 AND turma = 'H';
UPDATE oferta_lista_de_ofertas SET horarios = '419-708-710' WHERE disciplina = 200107 AND semestre = 1 AND ano = 2020 and turma = '8';
UPDATE lo_offer_list_temporary SET lol_clas = 8 WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '200107' AND lol_clas = 'H';
UPDATE lo_offer_list_temporary SET lol_sche = '419-708-710' WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '200107' AND lol_clas = '8';

UPDATE oferta_lista_de_ofertas SET turma = 9 WHERE disciplina = 200107 AND semestre = 1 AND ano = 2020 AND turma = 'I';
UPDATE oferta_lista_de_ofertas SET horarios = '419-708-710' WHERE disciplina = 200107 AND semestre = 1 AND ano = 2020 and turma = '9';
UPDATE lo_offer_list_temporary SET lol_clas = 9 WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '200107' AND lol_clas = 'I';
UPDATE lo_offer_list_temporary SET lol_sche = '419-708-710' WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '200107' AND lol_clas = '9';

--Álgebra 1
UPDATE oferta_lista_de_ofertas SET turma = 1 WHERE disciplina = 113107 AND semestre = 1 AND ano = 2020 AND turma = 'A';
UPDATE oferta_lista_de_ofertas SET horarios = '308-508' WHERE disciplina = 113107 AND semestre = 1 AND ano = 2020 and turma = '1';
UPDATE lo_offer_list_temporary SET lol_clas = 1 WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '113107' AND lol_clas = 'A';
UPDATE lo_offer_list_temporary SET lol_sche = '308-508' WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '113107' AND lol_clas = '1';

UPDATE oferta_lista_de_ofertas SET turma = 3 WHERE disciplina = 113107 AND semestre = 1 AND ano = 2020 AND turma = 'B';
UPDATE oferta_lista_de_ofertas SET horarios = '308-608' WHERE disciplina = 113107 AND semestre = 1 AND ano = 2020 and turma = '3';
UPDATE lo_offer_list_temporary SET lol_clas = 3 WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '113107' AND lol_clas = 'B';
UPDATE lo_offer_list_temporary SET lol_sche = '308-608' WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '113107' AND lol_clas = '3';

UPDATE oferta_lista_de_ofertas SET turma = 2 WHERE disciplina = 113107 AND semestre = 1 AND ano = 2020 AND turma = 'C';
UPDATE oferta_lista_de_ofertas SET horarios = '319-619' WHERE disciplina = 113107 AND semestre = 1 AND ano = 2020 and turma = '2';
UPDATE lo_offer_list_temporary SET lol_clas = 2 WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '113107' AND lol_clas = 'C';
UPDATE lo_offer_list_temporary SET lol_sche = '319-619' WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '113107' AND lol_clas = '2';

--Álgebra 2
UPDATE oferta_lista_de_ofertas SET turma = 1 WHERE disciplina = 113131 AND semestre = 1 AND ano = 2020 AND turma = 'A';
UPDATE oferta_lista_de_ofertas SET horarios = '308-508' WHERE disciplina = 113131 AND semestre = 1 AND ano = 2020 and turma = '1';
UPDATE lo_offer_list_temporary SET lol_clas = 1 WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '113131' AND lol_clas = 'A';
UPDATE lo_offer_list_temporary SET lol_sche = '308-508' WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '113131' AND lol_clas = '1';

--Álgebra 3
UPDATE oferta_lista_de_ofertas SET turma = 1 WHERE disciplina = 117145 AND semestre = 1 AND ano = 2020 AND turma = 'A';
UPDATE oferta_lista_de_ofertas SET horarios = '308-508' WHERE disciplina = 117145 AND semestre = 1 AND ano = 2020 and turma = '1';
UPDATE lo_offer_list_temporary SET lol_clas = 1 WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '117145' AND lol_clas = 'A';
UPDATE lo_offer_list_temporary SET lol_sche = '308-508' WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '117145' AND lol_clas = '1';

--Álgebra Linear
UPDATE oferta_lista_de_ofertas SET turma = 1 WHERE disciplina = 113123 AND semestre = 1 AND ano = 2020 AND turma = 'A';
UPDATE oferta_lista_de_ofertas SET horarios = '216-316-516' WHERE disciplina = 113123 AND semestre = 1 AND ano = 2020 and turma = '1';
UPDATE lo_offer_list_temporary SET lol_clas = 1 WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '113123' AND lol_clas = 'A';
UPDATE lo_offer_list_temporary SET lol_sche = '216-316-516' WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '113123' AND lol_clas = '1';

--Álgebra Para o Ensino 1
UPDATE oferta_lista_de_ofertas SET turma = 1 WHERE disciplina = 117421 AND semestre = 1 AND ano = 2020 AND turma = 'B';
UPDATE oferta_lista_de_ofertas SET horarios = '216-316-516' WHERE disciplina = 117421 AND semestre = 1 AND ano = 2020 and turma = '1';
UPDATE lo_offer_list_temporary SET lol_clas = 1 WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '117421' AND lol_clas = 'B';
UPDATE lo_offer_list_temporary SET lol_sche = '216-316-516' WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '117421' AND lol_clas = '1';

--Álgebra Para o Ensino 2
UPDATE oferta_lista_de_ofertas SET turma = 2 WHERE disciplina = 117501 AND semestre = 1 AND ano = 2020 AND turma = 'B';
UPDATE oferta_lista_de_ofertas SET horarios = '708-408-410' WHERE disciplina = 117501 AND semestre = 1 AND ano = 2020 and turma = '2';
UPDATE lo_offer_list_temporary SET lol_clas = 2 WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '117501' AND lol_clas = 'B';
UPDATE lo_offer_list_temporary SET lol_sche = '214-314-316' WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '117501' AND lol_clas = '2';

--Cálculo de Probabilidade 1
UPDATE oferta_lista_de_ofertas SET turma = 1 WHERE disciplina = 113824 AND semestre = 1 AND ano = 2020 AND turma = 'A';
UPDATE oferta_lista_de_ofertas SET horarios = '210-310-510' WHERE disciplina = 113824 AND semestre = 1 AND ano = 2020 and turma = '1';
UPDATE lo_offer_list_temporary SET lol_clas = 1 WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '113824' AND lol_clas = 'A';
UPDATE lo_offer_list_temporary SET lol_sche = '210-310-510' WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '113824' AND lol_clas = '1';

UPDATE oferta_lista_de_ofertas SET turma = 2 WHERE disciplina = 113824 AND semestre = 1 AND ano = 2020 AND turma = 'B';
UPDATE oferta_lista_de_ofertas SET horarios = '219-421-619' WHERE disciplina = 113824 AND semestre = 1 AND ano = 2020 and turma = '2';
UPDATE lo_offer_list_temporary SET lol_clas = 2 WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '113824' AND lol_clas = 'B';
UPDATE lo_offer_list_temporary SET lol_sche = '219-421-619' WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '113824' AND lol_clas = '2';

UPDATE oferta_lista_de_ofertas SET turma = 3 WHERE disciplina = 113824 AND semestre = 1 AND ano = 2020 AND turma = 'C';
UPDATE oferta_lista_de_ofertas SET horarios = '210-410-610' WHERE disciplina = 113824 AND semestre = 1 AND ano = 2020 and turma = '3';
UPDATE lo_offer_list_temporary SET lol_clas = 3 WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '113824' AND lol_clas = 'C';
UPDATE lo_offer_list_temporary SET lol_sche = '210-410-610' WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '113824' AND lol_clas = '3';

--Cálculo de Probabilidade 2
UPDATE oferta_lista_de_ofertas SET turma = 1 WHERE disciplina = 113832 AND semestre = 1 AND ano = 2020 AND turma = 'A';
UPDATE oferta_lista_de_ofertas SET horarios = '210-410' WHERE disciplina = 113832 AND semestre = 1 AND ano = 2020 and turma = '1';
UPDATE lo_offer_list_temporary SET lol_clas = 1 WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '113832' AND lol_clas = 'A';
UPDATE lo_offer_list_temporary SET lol_sche = '210-410' WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '113832' AND lol_clas = '1';

--Análise 1
UPDATE oferta_lista_de_ofertas SET turma = 1 WHERE disciplina = 113204 AND semestre = 1 AND ano = 2020 AND turma = 'A';
UPDATE oferta_lista_de_ofertas SET horarios = '321-619' WHERE disciplina = 113204 AND semestre = 1 AND ano = 2020 and turma = '1';
UPDATE lo_offer_list_temporary SET lol_clas = 1 WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '113204' AND lol_clas = 'A';
UPDATE lo_offer_list_temporary SET lol_sche = '321-619' WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '113204' AND lol_clas = '1';

UPDATE oferta_lista_de_ofertas SET turma = 2 WHERE disciplina = 113204 AND semestre = 1 AND ano = 2020 AND turma = 'B';
UPDATE oferta_lista_de_ofertas SET horarios = '208-408' WHERE disciplina = 113204 AND semestre = 1 AND ano = 2020 and turma = '2';
UPDATE lo_offer_list_temporary SET lol_clas = 2 WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '113204' AND lol_clas = 'B';
UPDATE lo_offer_list_temporary SET lol_sche = '208-408' WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '113204' AND lol_clas = '2';

--Análise 2
UPDATE oferta_lista_de_ofertas SET turma = 1 WHERE disciplina = 113212 AND semestre = 1 AND ano = 2020 AND turma = 'A';
UPDATE oferta_lista_de_ofertas SET horarios = '210-410' WHERE disciplina = 113212 AND semestre = 1 AND ano = 2020 and turma = '1';
UPDATE lo_offer_list_temporary SET lol_clas = 1 WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '113212' AND lol_clas = 'A';
UPDATE lo_offer_list_temporary SET lol_sche = '208-408' WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '113212' AND lol_clas = '1';

--Análise 3
UPDATE oferta_lista_de_ofertas SET turma = 1 WHERE disciplina = 117137 AND semestre = 1 AND ano = 2020 AND turma = 'A';
UPDATE oferta_lista_de_ofertas SET horarios = '310-510' WHERE disciplina = 117137 AND semestre = 1 AND ano = 2020 and turma = '1';
UPDATE lo_offer_list_temporary SET lol_clas = 1 WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '117137' AND lol_clas = 'A';
UPDATE lo_offer_list_temporary SET lol_sche = '310-510' WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '117137' AND lol_clas = '1';

UPDATE oferta_lista_de_ofertas SET turma = 2 WHERE disciplina = 113204 AND semestre = 1 AND ano = 2020 AND turma = 'B';
UPDATE oferta_lista_de_ofertas SET horarios = '208-408' WHERE disciplina = 113204 AND semestre = 1 AND ano = 2020 and turma = '2';
UPDATE lo_offer_list_temporary SET lol_clas = 2 WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '117137' AND lol_clas = 'B';
UPDATE lo_offer_list_temporary SET lol_sche = '208-408' WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '117137' AND lol_clas = '2';

--Análise Conbinatória
UPDATE oferta_lista_de_ofertas SET turma = 1 WHERE disciplina = 113972 AND semestre = 1 AND ano = 2020 AND turma = 'A';
UPDATE oferta_lista_de_ofertas SET horarios = '210-410' WHERE disciplina = 113972 AND semestre = 1 AND ano = 2020 and turma = '1';
UPDATE lo_offer_list_temporary SET lol_clas = 2 WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '113972' AND lol_clas = 'A';
UPDATE lo_offer_list_temporary SET lol_sche = '208-408' WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '113972' AND lol_clas = '1';

--Cálculo Numérico
UPDATE oferta_lista_de_ofertas SET turma = 5 WHERE disciplina = 113417 AND semestre = 1 AND ano = 2020 AND turma = 'A';
UPDATE oferta_lista_de_ofertas SET horarios = '316-516' WHERE disciplina = 113417 AND semestre = 1 AND ano = 2020 and turma = '5';
UPDATE lo_offer_list_temporary SET lol_clas = 5 WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '113417' AND lol_clas = 'A';
UPDATE lo_offer_list_temporary SET lol_sche = '316-516' WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '113417' AND lol_clas = '5';

UPDATE oferta_lista_de_ofertas SET turma = 3 WHERE disciplina = 113417 AND semestre = 1 AND ano = 2020 AND turma = 'B';
UPDATE oferta_lista_de_ofertas SET horarios = '314-514' WHERE disciplina = 113417 AND semestre = 1 AND ano = 2020 and turma = '3';
UPDATE lo_offer_list_temporary SET lol_clas = 3 WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '113417' AND lol_clas = 'B';
UPDATE lo_offer_list_temporary SET lol_sche = '314-514' WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '113417' AND lol_clas = '3';

UPDATE oferta_lista_de_ofertas SET turma = 4 WHERE disciplina = 113417 AND semestre = 1 AND ano = 2020 AND turma = 'C';
UPDATE oferta_lista_de_ofertas SET horarios = '314-514' WHERE disciplina = 113417 AND semestre = 1 AND ano = 2020 and turma = '4';
UPDATE lo_offer_list_temporary SET lol_clas = 4 WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '113417' AND lol_clas = 'C';
UPDATE lo_offer_list_temporary SET lol_sche = '314-514' WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '113417' AND lol_clas = '4';

UPDATE oferta_lista_de_ofertas SET turma = 1 WHERE disciplina = 113417 AND semestre = 1 AND ano = 2020 AND turma = 'D';
UPDATE oferta_lista_de_ofertas SET horarios = '314-514' WHERE disciplina = 113417 AND semestre = 1 AND ano = 2020 and turma = '1';
UPDATE lo_offer_list_temporary SET lol_clas = 1 WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '113417' AND lol_clas = 'D';
UPDATE lo_offer_list_temporary SET lol_sche = '314-514' WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '113417' AND lol_clas = '1';

UPDATE oferta_lista_de_ofertas SET turma = 2 WHERE disciplina = 113417 AND semestre = 1 AND ano = 2020 AND turma = 'E';
UPDATE oferta_lista_de_ofertas SET horarios = '208-408' WHERE disciplina = 113417 AND semestre = 1 AND ano = 2020 and turma = '2';
UPDATE lo_offer_list_temporary SET lol_clas = 2 WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '113417' AND lol_clas = 'E';
UPDATE lo_offer_list_temporary SET lol_sche = '208-408' WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '113417' AND lol_clas = '2';

--Geometria Diferencial
UPDATE oferta_lista_de_ofertas SET turma = 1 WHERE disciplina = 113328 AND semestre = 1 AND ano = 2020 AND turma = 'A';
UPDATE lo_offer_list_temporary SET lol_clas = 1 WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '113328' AND lol_clas = 'A';

--Geometria 1
UPDATE oferta_lista_de_ofertas SET turma = 1 WHERE disciplina = 117161 AND semestre = 1 AND ano = 2020 AND turma = 'A';
UPDATE oferta_lista_de_ofertas SET horarios = '219-321' WHERE disciplina = 117161 AND semestre = 1 AND ano = 2020 and turma = '1';
UPDATE lo_offer_list_temporary SET lol_clas = 1 WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '117161' AND lol_clas = 'A';
UPDATE lo_offer_list_temporary SET lol_sche = '219-321' WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '117161' AND lol_clas = '1';

--Geometria 2
UPDATE oferta_lista_de_ofertas SET turma = 1 WHERE disciplina =  117170 AND semestre = 1 AND ano = 2020 AND turma = 'A';
UPDATE oferta_lista_de_ofertas SET horarios = '208-408' WHERE disciplina = 117170 AND semestre = 1 AND ano = 2020 and turma = '1';
UPDATE lo_offer_list_temporary SET lol_clas = 1 WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '117170' AND lol_clas = 'A';
UPDATE lo_offer_list_temporary SET lol_sche = '208-408' WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '117170' AND lol_clas = '1';

--Geometria para o Ensino 1
UPDATE oferta_lista_de_ofertas SET turma = 2 WHERE disciplina = 117471 AND semestre = 1 AND ano = 2020 AND turma = 'B';
UPDATE oferta_lista_de_ofertas SET horarios = '319-321-710' WHERE disciplina = 117471 AND semestre = 1 AND ano = 2020 and turma = '2';
UPDATE lo_offer_list_temporary SET lol_clas = 2 WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '117471' AND lol_clas = 'B';
UPDATE lo_offer_list_temporary SET lol_sche = '319-321-710' WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '117471' AND lol_clas = '2';

--Geometria para o Ensino 2
UPDATE oferta_lista_de_ofertas SET turma = 2 WHERE disciplina = 117480 AND semestre = 1 AND ano = 2020 AND turma = 'B';
UPDATE oferta_lista_de_ofertas SET horarios = '216-410-616' WHERE disciplina = 117480 AND semestre = 1 AND ano = 2020 and turma = '2';
UPDATE lo_offer_list_temporary SET lol_clas = 2 WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '117480' AND lol_clas = 'B';
UPDATE lo_offer_list_temporary SET lol_sche = '216-410-616' WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '117480' AND lol_clas = '2';

--Introdução à Teoria dos Grafos
UPDATE oferta_lista_de_ofertas SET turma = 1 WHERE disciplina = 113930 AND semestre = 1 AND ano = 2020 AND turma = 'A';
UPDATE oferta_lista_de_ofertas SET horarios = '314-514' WHERE disciplina = 113930 AND semestre = 1 AND ano = 2020 and turma = '1';
UPDATE lo_offer_list_temporary SET lol_clas = 1 WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '113930' AND lol_clas = 'A';
UPDATE lo_offer_list_temporary SET lol_sche = '314-514' WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '113930' AND lol_clas = '1';

--Métodos Matemáticos da Física 1
UPDATE oferta_lista_de_ofertas SET turma = 1 WHERE disciplina = 113522 AND semestre = 1 AND ano = 2020 AND turma = 'A';
UPDATE oferta_lista_de_ofertas SET horarios = '210-410-610' WHERE disciplina = 113522 AND semestre = 1 AND ano = 2020 and turma = '1';
UPDATE lo_offer_list_temporary SET lol_clas = 1 WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '113522' AND lol_clas = 'A';
UPDATE lo_offer_list_temporary SET lol_sche = '210-410-610' WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '113522' AND lol_clas = '1';

--MAT2
UPDATE oferta_lista_de_ofertas SET turma = 1 WHERE disciplina = 113026 AND semestre = 1 AND ano = 2020 AND turma = 'A';
UPDATE oferta_lista_de_ofertas SET horarios = '414-614' WHERE disciplina = 113026 AND semestre = 1 AND ano = 2020 and turma = '1';
UPDATE lo_offer_list_temporary SET lol_clas = 1 WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '113026' AND lol_clas = 'A';
UPDATE lo_offer_list_temporary SET lol_sche = '414-614' WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '113026' AND lol_clas = '1';

UPDATE oferta_lista_de_ofertas SET turma = 2 WHERE disciplina = 113026 AND semestre = 1 AND ano = 2020 AND turma = 'B';
UPDATE oferta_lista_de_ofertas SET horarios = '314-514' WHERE disciplina = 113026 AND semestre = 1 AND ano = 2020 and turma = '2';
UPDATE lo_offer_list_temporary SET lol_clas = 2 WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '113026' AND lol_clas = 'B';
UPDATE lo_offer_list_temporary SET lol_sche = '314-514' WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '113026' AND lol_clas = '2';

--Regencia 2
UPDATE oferta_lista_de_ofertas SET turma = 1 WHERE disciplina = 117439 AND semestre = 1 AND ano = 2020 AND turma = 'B';
UPDATE oferta_lista_de_ofertas SET horarios = '519-521' WHERE disciplina = 117439 AND semestre = 1 AND ano = 2020 and turma = '1';
UPDATE lo_offer_list_temporary SET lol_clas = 1 WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '117439' AND lol_clas = 'B';
UPDATE lo_offer_list_temporary SET lol_sche = '519-521' WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '117439' AND lol_clas = '1';

UPDATE oferta_lista_de_ofertas SET turma = 2 WHERE disciplina = 117439 AND semestre = 1 AND ano = 2020 AND turma = 'A';
UPDATE oferta_lista_de_ofertas SET horarios = '608-610-708' WHERE disciplina = 117439 AND semestre = 1 AND ano = 2020 and turma = '2';
UPDATE lo_offer_list_temporary SET lol_clas = 2 WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '117439' AND lol_clas = 'A';
UPDATE lo_offer_list_temporary SET lol_sche = '608-610-708' WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '117439' AND lol_clas = '2';

--Regencia 1
UPDATE oferta_lista_de_ofertas SET turma = 1 WHERE disciplina = 117510 AND semestre = 1 AND ano = 2020 AND turma = 'A';
UPDATE oferta_lista_de_ofertas SET horarios = '519-521-714' WHERE disciplina = 117510 AND semestre = 1 AND ano = 2020 and turma = '1';
UPDATE lo_offer_list_temporary SET lol_clas = 1 WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '117510' AND lol_clas = 'A';
UPDATE lo_offer_list_temporary SET lol_sche = '519-521-714' WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '117510' AND lol_clas = '1';

--TN 1
UPDATE oferta_lista_de_ofertas SET turma = 1 WHERE disciplina = 113115 AND semestre = 1 AND ano = 2020 AND turma = 'B';
UPDATE oferta_lista_de_ofertas SET horarios = '319-519' WHERE disciplina = 113115 AND semestre = 1 AND ano = 2020 and turma = '1';
UPDATE lo_offer_list_temporary SET lol_clas = 1 WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '113115' AND lol_clas = 'B';
UPDATE lo_offer_list_temporary SET lol_sche = '319-519' WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '113115' AND lol_clas = '1';

UPDATE oferta_lista_de_ofertas SET turma = 2 WHERE disciplina = 113115 AND semestre = 1 AND ano = 2020 AND turma = 'A';
UPDATE oferta_lista_de_ofertas SET horarios = '310-510' WHERE disciplina = 113115 AND semestre = 1 AND ano = 2020 and turma = '2';
UPDATE lo_offer_list_temporary SET lol_clas = 2 WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '113115' AND lol_clas = 'A';
UPDATE lo_offer_list_temporary SET lol_sche = '310-510' WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '113115' AND lol_clas = '2';

--VC 1
UPDATE oferta_lista_de_ofertas SET turma = 1 WHERE disciplina = 113069 AND semestre = 1 AND ano = 2020 AND turma = 'B';
UPDATE oferta_lista_de_ofertas SET horarios = '214-314-514' WHERE disciplina = 113069 AND semestre = 1 AND ano = 2020 and turma = '1';
UPDATE lo_offer_list_temporary SET lol_clas = 1 WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '113069' AND lol_clas = 'B';
UPDATE lo_offer_list_temporary SET lol_sche = '214-314-514' WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '113069' AND lol_clas = '1';

UPDATE oferta_lista_de_ofertas SET turma = 2 WHERE disciplina = 113069 AND semestre = 1 AND ano = 2020 AND turma = 'A';
UPDATE oferta_lista_de_ofertas SET horarios = '214-314-514' WHERE disciplina = 113069 AND semestre = 1 AND ano = 2020 and turma = '2';
UPDATE lo_offer_list_temporary SET lol_clas = 2 WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '113069' AND lol_clas = 'A';
UPDATE lo_offer_list_temporary SET lol_sche = '214-314-514' WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '113069' AND lol_clas = '2';

UPDATE oferta_lista_de_ofertas SET turma = 3 WHERE disciplina = 113069 AND semestre = 1 AND ano = 2020 AND turma = 'C';
UPDATE oferta_lista_de_ofertas SET horarios = '214-321-521' WHERE disciplina = 113069 AND semestre = 1 AND ano = 2020 and turma = '3';
UPDATE lo_offer_list_temporary SET lol_clas = 3 WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '113069' AND lol_clas = 'C';
UPDATE lo_offer_list_temporary SET lol_sche = '219-321-521' WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '113069' AND lol_clas = '3';

--C2
UPDATE oferta_lista_de_ofertas SET turma = 12 WHERE disciplina = 113042 AND semestre = 1 AND ano = 2020 AND turma = 'A';
UPDATE oferta_lista_de_ofertas SET horarios = '208-308-508' WHERE disciplina = 113042 AND semestre = 1 AND ano = 2020 and turma = '12';
UPDATE lo_offer_list_temporary SET lol_clas = 12 WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '113042' AND lol_clas = 'A';
UPDATE lo_offer_list_temporary SET lol_sche = '208-308-508' WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '113042' AND lol_clas = '12';

UPDATE oferta_lista_de_ofertas SET turma = 8 WHERE disciplina = 113042 AND semestre = 1 AND ano = 2020 AND turma = 'B';
UPDATE oferta_lista_de_ofertas SET horarios = '210-310-510' WHERE disciplina = 113042 AND semestre = 1 AND ano = 2020 and turma = '8';
UPDATE lo_offer_list_temporary SET lol_clas = 8 WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '113042' AND lol_clas = 'B';
UPDATE lo_offer_list_temporary SET lol_sche = '210-310-510' WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '113042' AND lol_clas = '8';

UPDATE oferta_lista_de_ofertas SET turma = 17 WHERE disciplina = 113042 AND semestre = 1 AND ano = 2020 AND turma = 'C';
UPDATE oferta_lista_de_ofertas SET horarios = '210-310-510' WHERE disciplina = 113042 AND semestre = 1 AND ano = 2020 and turma = '17';
UPDATE lo_offer_list_temporary SET lol_clas = 17 WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '113042' AND lol_clas = 'C';
UPDATE lo_offer_list_temporary SET lol_sche = '210-310-510' WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '113042' AND lol_clas = '17';

UPDATE oferta_lista_de_ofertas SET turma = 6 WHERE disciplina = 113042 AND semestre = 1 AND ano = 2020 AND turma = 'D';
UPDATE oferta_lista_de_ofertas SET horarios = '214-414-614' WHERE disciplina = 113042 AND semestre = 1 AND ano = 2020 and turma = '6';
UPDATE lo_offer_list_temporary SET lol_clas = 6 WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '113042' AND lol_clas = 'D';
UPDATE lo_offer_list_temporary SET lol_sche = '214-314-514' WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '113042' AND lol_clas = '6';

UPDATE oferta_lista_de_ofertas SET turma = 2 WHERE disciplina = 113042 AND semestre = 1 AND ano = 2020 AND turma = 'E';
UPDATE oferta_lista_de_ofertas SET horarios = '219-321-521' WHERE disciplina = 113042 AND semestre = 1 AND ano = 2020 and turma = '2';
UPDATE lo_offer_list_temporary SET lol_clas = 2 WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '113042' AND lol_clas = 'E';
UPDATE lo_offer_list_temporary SET lol_sche = '219-321-521' WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '113042' AND lol_clas = '2';

UPDATE oferta_lista_de_ofertas SET turma = 4 WHERE disciplina = 113042 AND semestre = 1 AND ano = 2020 AND turma = 'F';
UPDATE oferta_lista_de_ofertas SET horarios = '308-508-608' WHERE disciplina = 113042 AND semestre = 1 AND ano = 2020 and turma = '4';
UPDATE lo_offer_list_temporary SET lol_clas = 4 WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '113042' AND lol_clas = 'F';
UPDATE lo_offer_list_temporary SET lol_sche = '308-508-608' WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '113042' AND lol_clas = '4';

UPDATE oferta_lista_de_ofertas SET turma = 18 WHERE disciplina = 113042 AND semestre = 1 AND ano = 2020 AND turma = 'G';
UPDATE oferta_lista_de_ofertas SET horarios = '208-308-508' WHERE disciplina = 113042 AND semestre = 1 AND ano = 2020 and turma = '18';
UPDATE lo_offer_list_temporary SET lol_clas = 18 WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '113042' AND lol_clas = 'G';
UPDATE lo_offer_list_temporary SET lol_sche = '208-308-508' WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '113042' AND lol_clas = '18';

UPDATE oferta_lista_de_ofertas SET turma = 7 WHERE disciplina = 113042 AND semestre = 1 AND ano = 2020 AND turma = 'H';
UPDATE oferta_lista_de_ofertas SET horarios = '219-321-521' WHERE disciplina = 113042 AND semestre = 1 AND ano = 2020 and turma = '7';
UPDATE lo_offer_list_temporary SET lol_clas = 7 WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '113042' AND lol_clas = 'H';
UPDATE lo_offer_list_temporary SET lol_sche = '219-321-521' WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '113042' AND lol_clas = '7';

UPDATE oferta_lista_de_ofertas SET turma = 14 WHERE disciplina = 113042 AND semestre = 1 AND ano = 2020 AND turma = 'I';
UPDATE oferta_lista_de_ofertas SET horarios = '210-310-510' WHERE disciplina = 113042 AND semestre = 1 AND ano = 2020 and turma = '14';
UPDATE lo_offer_list_temporary SET lol_clas = 14 WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '113042' AND lol_clas = 'I';
UPDATE lo_offer_list_temporary SET lol_sche = '210-310-510' WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '113042' AND lol_clas = '14';

UPDATE oferta_lista_de_ofertas SET turma = 1 WHERE disciplina = 113042 AND semestre = 1 AND ano = 2020 AND turma = 'J';
UPDATE oferta_lista_de_ofertas SET horarios = '321-519-619' WHERE disciplina = 113042 AND semestre = 1 AND ano = 2020 and turma = '1';
UPDATE lo_offer_list_temporary SET lol_clas = 1 WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '113042' AND lol_clas = 'J';
UPDATE lo_offer_list_temporary SET lol_sche = '321-519-619' WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '113042' AND lol_clas = '1';

UPDATE oferta_lista_de_ofertas SET turma = 15 WHERE disciplina = 113042 AND semestre = 1 AND ano = 2020 AND turma = 'K';
UPDATE oferta_lista_de_ofertas SET horarios = '214-414-614' WHERE disciplina = 113042 AND semestre = 1 AND ano = 2020 and turma = '15';
UPDATE lo_offer_list_temporary SET lol_clas = 15 WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '113042' AND lol_clas = 'K';
UPDATE lo_offer_list_temporary SET lol_sche = '214-414-614' WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '113042' AND lol_clas = '15';

UPDATE oferta_lista_de_ofertas SET turma = 11 WHERE disciplina = 113042 AND semestre = 1 AND ano = 2020 AND turma = 'L';
UPDATE oferta_lista_de_ofertas SET horarios = '208-308-508' WHERE disciplina = 113042 AND semestre = 1 AND ano = 2020 and turma = '11';
UPDATE lo_offer_list_temporary SET lol_clas = 11 WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '113042' AND lol_clas = 'L';
UPDATE lo_offer_list_temporary SET lol_sche = '208-308-508' WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '113042' AND lol_clas = '11';

UPDATE oferta_lista_de_ofertas SET turma = 13 WHERE disciplina = 113042 AND semestre = 1 AND ano = 2020 AND turma = 'M';
UPDATE oferta_lista_de_ofertas SET horarios = '210-310-510' WHERE disciplina = 113042 AND semestre = 1 AND ano = 2020 and turma = '13';
UPDATE lo_offer_list_temporary SET lol_clas = 13 WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '113042' AND lol_clas = 'M';
UPDATE lo_offer_list_temporary SET lol_sche = '210-310-510' WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '113042' AND lol_clas = '13';

UPDATE oferta_lista_de_ofertas SET turma = 19 WHERE disciplina = 113042 AND semestre = 1 AND ano = 2020 AND turma = 'N';
UPDATE oferta_lista_de_ofertas SET horarios = '214-414-614' WHERE disciplina = 113042 AND semestre = 1 AND ano = 2020 and turma = '19';
UPDATE lo_offer_list_temporary SET lol_clas = 19 WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '113042' AND lol_clas = 'N';
UPDATE lo_offer_list_temporary SET lol_sche = '214-414-614' WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '113042' AND lol_clas = '19';

--C3
UPDATE oferta_lista_de_ofertas SET turma = 11 WHERE disciplina = 113051 AND semestre = 1 AND ano = 2020 AND turma = 'A';
UPDATE oferta_lista_de_ofertas SET horarios = '214-414-614' WHERE disciplina = 113051 AND semestre = 1 AND ano = 2020 and turma = '11';
UPDATE lo_offer_list_temporary SET lol_clas = 11 WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '113051' AND lol_clas = 'A';
UPDATE lo_offer_list_temporary SET lol_sche = '214-414-614' WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '113051' AND lol_clas = '11';

UPDATE oferta_lista_de_ofertas SET turma = 12 WHERE disciplina = 113051 AND semestre = 1 AND ano = 2020 AND turma = 'B';
UPDATE oferta_lista_de_ofertas SET horarios = '308-508-608' WHERE disciplina = 113051 AND semestre = 1 AND ano = 2020 and turma = '12';
UPDATE lo_offer_list_temporary SET lol_clas = 12 WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '113051' AND lol_clas = 'B';
UPDATE lo_offer_list_temporary SET lol_sche = '308-508-608' WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '113051' AND lol_clas = '12';

UPDATE oferta_lista_de_ofertas SET turma = 4 WHERE disciplina = 113051 AND semestre = 1 AND ano = 2020 AND turma = 'C';
UPDATE oferta_lista_de_ofertas SET horarios = '210-310-510' WHERE disciplina = 113051 AND semestre = 1 AND ano = 2020 and turma = '4';
UPDATE lo_offer_list_temporary SET lol_clas = 4 WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '113051' AND lol_clas = 'C';
UPDATE lo_offer_list_temporary SET lol_sche = '210-310-510' WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '113051' AND lol_clas = '4';

UPDATE oferta_lista_de_ofertas SET turma = 6 WHERE disciplina = 113051 AND semestre = 1 AND ano = 2020 AND turma = 'D';
UPDATE oferta_lista_de_ofertas SET horarios = '321-521-619' WHERE disciplina = 113051 AND semestre = 1 AND ano = 2020 and turma = '6';
UPDATE lo_offer_list_temporary SET lol_clas = 6 WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '113051' AND lol_clas = 'D';
UPDATE lo_offer_list_temporary SET lol_sche = '321-521-619' WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '113051' AND lol_clas = '6';

UPDATE oferta_lista_de_ofertas SET turma = 1 WHERE disciplina = 113051 AND semestre = 1 AND ano = 2020 AND turma = 'E';
UPDATE oferta_lista_de_ofertas SET horarios = '210-310-510' WHERE disciplina = 113051 AND semestre = 1 AND ano = 2020 and turma = '1';
UPDATE lo_offer_list_temporary SET lol_clas = 1 WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '113051' AND lol_clas = 'E';
UPDATE lo_offer_list_temporary SET lol_sche = '210-310-510' WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '113051' AND lol_clas = '1';

UPDATE oferta_lista_de_ofertas SET turma = 7 WHERE disciplina = 113051 AND semestre = 1 AND ano = 2020 AND turma = 'F';
UPDATE oferta_lista_de_ofertas SET horarios = '214-414-614' WHERE disciplina = 113051 AND semestre = 1 AND ano = 2020 and turma = '7';
UPDATE lo_offer_list_temporary SET lol_clas = 7 WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '113051' AND lol_clas = 'F';
UPDATE lo_offer_list_temporary SET lol_sche = '214-414-614' WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '113051' AND lol_clas = '7';

UPDATE oferta_lista_de_ofertas SET turma = 8 WHERE disciplina = 113051 AND semestre = 1 AND ano = 2020 AND turma = 'G';
UPDATE oferta_lista_de_ofertas SET horarios = '308-508-608' WHERE disciplina = 113051 AND semestre = 1 AND ano = 2020 and turma = '8';
UPDATE lo_offer_list_temporary SET lol_clas = 8 WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '113051' AND lol_clas = 'G';
UPDATE lo_offer_list_temporary SET lol_sche = '308-508-608' WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '113051' AND lol_clas = '8';

UPDATE oferta_lista_de_ofertas SET turma = 3 WHERE disciplina = 113051 AND semestre = 1 AND ano = 2020 AND turma = 'I';
UPDATE oferta_lista_de_ofertas SET horarios = '308-508-608' WHERE disciplina = 113051 AND semestre = 1 AND ano = 2020 and turma = '3';
UPDATE lo_offer_list_temporary SET lol_clas = 3 WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '113051' AND lol_clas = 'I';
UPDATE lo_offer_list_temporary SET lol_sche = '308-508-608' WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '113051' AND lol_clas = '3';

UPDATE oferta_lista_de_ofertas SET turma = 9 WHERE disciplina = 113051 AND semestre = 1 AND ano = 2020 AND turma = 'J';
UPDATE oferta_lista_de_ofertas SET horarios = '308-508-608' WHERE disciplina = 113051 AND semestre = 1 AND ano = 2020 and turma = '9';
UPDATE lo_offer_list_temporary SET lol_clas = 9 WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '113051' AND lol_clas = 'J';
UPDATE lo_offer_list_temporary SET lol_sche = '308-508-608' WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '113051' AND lol_clas = '9';

UPDATE oferta_lista_de_ofertas SET turma = 10 WHERE disciplina = 113051 AND semestre = 1 AND ano = 2020 AND turma = 'K';
UPDATE oferta_lista_de_ofertas SET horarios = '219-419-619' WHERE disciplina = 113051 AND semestre = 1 AND ano = 2020 and turma = '10';
UPDATE lo_offer_list_temporary SET lol_clas = 10 WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '113051' AND lol_clas = 'K';
UPDATE lo_offer_list_temporary SET lol_sche = '219-419-619' WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '113051' AND lol_clas = '10';

--IAL
UPDATE oferta_lista_de_ofertas SET turma = 10 WHERE disciplina = 113093 AND semestre = 1 AND ano = 2020 AND turma = 'A';
UPDATE oferta_lista_de_ofertas SET horarios = '216-416' WHERE disciplina = 113093 AND semestre = 1 AND ano = 2020 and turma = '10';
UPDATE lo_offer_list_temporary SET lol_clas = 10 WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '113093' AND lol_clas = 'A';
UPDATE lo_offer_list_temporary SET lol_sche = '216-416' WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '113093' AND lol_clas = '10';

UPDATE oferta_lista_de_ofertas SET turma = 5 WHERE disciplina = 113093 AND semestre = 1 AND ano = 2020 AND turma = 'B';
UPDATE oferta_lista_de_ofertas SET horarios = '316-516' WHERE disciplina = 113093 AND semestre = 1 AND ano = 2020 and turma = '5';
UPDATE lo_offer_list_temporary SET lol_clas = 5 WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '113093' AND lol_clas = 'B';
UPDATE lo_offer_list_temporary SET lol_sche = '316-516' WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '113093' AND lol_clas = '5';

UPDATE oferta_lista_de_ofertas SET turma = 15 WHERE disciplina = 113093 AND semestre = 1 AND ano = 2020 AND turma = 'C';
UPDATE oferta_lista_de_ofertas SET horarios = '216-416' WHERE disciplina = 113093 AND semestre = 1 AND ano = 2020 and turma = '15';
UPDATE lo_offer_list_temporary SET lol_clas = 15 WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '113093' AND lol_clas = 'C';
UPDATE lo_offer_list_temporary SET lol_sche = '216-416' WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '113093' AND lol_clas = '15';

UPDATE oferta_lista_de_ofertas SET turma = 6 WHERE disciplina = 113093 AND semestre = 1 AND ano = 2020 AND turma = 'D';
UPDATE oferta_lista_de_ofertas SET horarios = '216-416' WHERE disciplina = 113093 AND semestre = 1 AND ano = 2020 and turma = '6';
UPDATE lo_offer_list_temporary SET lol_clas = 6 WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '113093' AND lol_clas = 'D';
UPDATE lo_offer_list_temporary SET lol_sche = '216-416' WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '113093' AND lol_clas = '6';

UPDATE oferta_lista_de_ofertas SET turma = 9 WHERE disciplina = 113093 AND semestre = 1 AND ano = 2020 AND turma = 'E';
UPDATE oferta_lista_de_ofertas SET horarios = '319-519' WHERE disciplina = 113093 AND semestre = 1 AND ano = 2020 and turma = '9';
UPDATE lo_offer_list_temporary SET lol_clas = 9 WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '113093' AND lol_clas = 'E';
UPDATE lo_offer_list_temporary SET lol_sche = '319-519' WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '113093' AND lol_clas = '9';

UPDATE oferta_lista_de_ofertas SET turma = 8 WHERE disciplina = 113093 AND semestre = 1 AND ano = 2020 AND turma = 'F';
UPDATE oferta_lista_de_ofertas SET horarios = '216-416' WHERE disciplina = 113093 AND semestre = 1 AND ano = 2020 and turma = '8';
UPDATE lo_offer_list_temporary SET lol_clas = 8 WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '113093' AND lol_clas = 'F';
UPDATE lo_offer_list_temporary SET lol_sche = '216-416' WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '113093' AND lol_clas = '8';

UPDATE oferta_lista_de_ofertas SET turma = 2 WHERE disciplina = 113093 AND semestre = 1 AND ano = 2020 AND turma = 'G';
UPDATE oferta_lista_de_ofertas SET horarios = '319-519' WHERE disciplina = 113093 AND semestre = 1 AND ano = 2020 and turma = '2';
UPDATE lo_offer_list_temporary SET lol_clas = 2 WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '113093' AND lol_clas = 'G';
UPDATE lo_offer_list_temporary SET lol_sche = '319-519' WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '113093' AND lol_clas = '2';

UPDATE oferta_lista_de_ofertas SET turma = 7 WHERE disciplina = 113093 AND semestre = 1 AND ano = 2020 AND turma = 'H';
UPDATE oferta_lista_de_ofertas SET horarios = '410-610' WHERE disciplina = 113093 AND semestre = 1 AND ano = 2020 and turma = '7';
UPDATE lo_offer_list_temporary SET lol_clas = 7 WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '113093' AND lol_clas = 'H';
UPDATE lo_offer_list_temporary SET lol_sche = '410-610' WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '113093' AND lol_clas = '7';

UPDATE oferta_lista_de_ofertas SET turma = 12 WHERE disciplina = 113093 AND semestre = 1 AND ano = 2020 AND turma = 'I';
UPDATE oferta_lista_de_ofertas SET horarios = '316-516' WHERE disciplina = 113093 AND semestre = 1 AND ano = 2020 and turma = '12';
UPDATE lo_offer_list_temporary SET lol_clas = 12 WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '113093' AND lol_clas = 'I';
UPDATE lo_offer_list_temporary SET lol_sche = '316-516' WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '113093' AND lol_clas = '12';

UPDATE oferta_lista_de_ofertas SET turma = 11 WHERE disciplina = 113093 AND semestre = 1 AND ano = 2020 AND turma = 'J';
UPDATE oferta_lista_de_ofertas SET horarios = '216-416' WHERE disciplina = 113093 AND semestre = 1 AND ano = 2020 and turma = '11';
UPDATE lo_offer_list_temporary SET lol_clas = 11 WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '113093' AND lol_clas = 'J';
UPDATE lo_offer_list_temporary SET lol_sche = '216-416' WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '113093' AND lol_clas = '11';

UPDATE oferta_lista_de_ofertas SET turma = 3 WHERE disciplina = 113093 AND semestre = 1 AND ano = 2020 AND turma = 'K';
UPDATE oferta_lista_de_ofertas SET horarios = '316-516' WHERE disciplina = 113093 AND semestre = 1 AND ano = 2020 and turma = '3';
UPDATE lo_offer_list_temporary SET lol_clas = 3 WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '113093' AND lol_clas = 'K';
UPDATE lo_offer_list_temporary SET lol_sche = '316-516' WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '113093' AND lol_clas = '3';

UPDATE oferta_lista_de_ofertas SET turma = 13 WHERE disciplina = 113093 AND semestre = 1 AND ano = 2020 AND turma = 'L';
UPDATE oferta_lista_de_ofertas SET horarios = '210-410' WHERE disciplina = 113093 AND semestre = 1 AND ano = 2020 and turma = '13';
UPDATE lo_offer_list_temporary SET lol_clas = 13 WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '113093' AND lol_clas = 'L';
UPDATE lo_offer_list_temporary SET lol_sche = '210-410' WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '113093' AND lol_clas = '13';

UPDATE oferta_lista_de_ofertas SET turma = 14 WHERE disciplina = 113093 AND semestre = 1 AND ano = 2020 AND turma = 'M';
UPDATE oferta_lista_de_ofertas SET horarios = '319-519' WHERE disciplina = 113093 AND semestre = 1 AND ano = 2020 and turma = '14';
UPDATE lo_offer_list_temporary SET lol_clas = 14 WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '113093' AND lol_clas = 'M';
UPDATE lo_offer_list_temporary SET lol_sche = '319-519' WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '113093' AND lol_clas = '14';

--Seminários de Tópicos em Análise
UPDATE oferta_lista_de_ofertas SET turma = 1 WHERE disciplina = 113671 AND semestre = 1 AND ano = 2020 AND turma = 'A';
UPDATE oferta_lista_de_ofertas SET horarios = '214-414' WHERE disciplina = 113671 AND semestre = 1 AND ano = 2020 and turma = '1';
UPDATE lo_offer_list_temporary SET lol_clas = 1 WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '113671' AND lol_clas = 'A';
UPDATE lo_offer_list_temporary SET lol_sche = '214-414' WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '113671' AND lol_clas = '1';

--Seminários de Tópicos Especiais
UPDATE oferta_lista_de_ofertas SET turma = 3 WHERE disciplina = 117013 AND semestre = 1 AND ano = 2020 AND turma = 'A';
UPDATE oferta_lista_de_ofertas SET horarios = '412' WHERE disciplina = 117013 AND semestre = 1 AND ano = 2020 and turma = '3';
UPDATE lo_offer_list_temporary SET lol_clas = 3 WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '117013' AND lol_clas = 'A';
UPDATE lo_offer_list_temporary SET lol_sche = '412' WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '117013' AND lol_clas = '3';

UPDATE oferta_lista_de_ofertas SET turma = 1 WHERE disciplina = 117013 AND semestre = 1 AND ano = 2020 AND turma = 'B';
UPDATE oferta_lista_de_ofertas SET horarios = '210' WHERE disciplina = 117013 AND semestre = 1 AND ano = 2020 and turma = '1';
UPDATE lo_offer_list_temporary SET lol_clas = 1 WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '117013' AND lol_clas = 'B';
UPDATE lo_offer_list_temporary SET lol_sche = '210' WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '117013' AND lol_clas = '1';

UPDATE oferta_lista_de_ofertas SET turma = 2 WHERE disciplina = 117013 AND semestre = 1 AND ano = 2020 AND turma = 'C';
UPDATE oferta_lista_de_ofertas SET horarios = '519' WHERE disciplina = 117013 AND semestre = 1 AND ano = 2020 and turma = '2';
UPDATE lo_offer_list_temporary SET lol_clas = 2 WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '117013' AND lol_clas = 'C';
UPDATE lo_offer_list_temporary SET lol_sche = '519' WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '117013' AND lol_clas = '2';

UPDATE oferta_lista_de_ofertas SET turma = 4 WHERE disciplina = 117013 AND semestre = 1 AND ano = 2020 AND turma = 'D';
UPDATE oferta_lista_de_ofertas SET horarios = '212' WHERE disciplina = 117013 AND semestre = 1 AND ano = 2020 and turma = '4';
UPDATE lo_offer_list_temporary SET lol_clas = 4 WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '117013' AND lol_clas = 'D';
UPDATE lo_offer_list_temporary SET lol_sche = '212' WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '117013' AND lol_clas = '4';

UPDATE oferta_lista_de_ofertas SET turma = 5 WHERE disciplina = 117013 AND semestre = 1 AND ano = 2020 AND turma = 'E';
UPDATE oferta_lista_de_ofertas SET horarios = '212' WHERE disciplina = 117013 AND semestre = 1 AND ano = 2020 and turma = '5';
UPDATE lo_offer_list_temporary SET lol_clas = 5 WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '117013' AND lol_clas = 'E';
UPDATE lo_offer_list_temporary SET lol_sche = '212' WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '117013' AND lol_clas = '5';

--LOGICA MAT E COMPUTACIONAL
UPDATE oferta_lista_de_ofertas SET turma = 1 WHERE disciplina = 117358 AND semestre = 1 AND ano = 2020 AND turma = 'A';
UPDATE lo_offer_list_temporary SET lol_clas = 1 WHERE lol_seme = '1' AND lol_year='2020' AND lol_cdis = '117358' AND lol_clas = 'A';