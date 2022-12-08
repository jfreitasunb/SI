--Geomentria Análitica
UPDATE oferta_lista_de_ofertas SET turma = 1 WHERE disciplina = 105881 AND semestre = 2 AND ano = 2020 AND turma = 'A';
UPDATE lo_offer_list_temporary SET lol_clas = 1 WHERE lol_seme='2' AND lol_year='2020' AND lol_cdis = '105881' AND lol_clas = 'A';

UPDATE oferta_lista_de_ofertas SET turma = 2 WHERE disciplina = 105881 AND semestre = 2 AND ano = 2020 AND turma = 'B';
UPDATE lo_offer_list_temporary SET lol_clas = 2 WHERE lol_seme='2' AND lol_year='2020' AND lol_cdis = '105881' AND lol_clas = 'B';


--MAT1
UPDATE oferta_lista_de_ofertas SET turma = 10 WHERE disciplina = 113018 AND semestre = 2 AND ano = 2020 AND turma = 'L';
UPDATE oferta_grupos_magistral_teoria SET turmas = 10 WHERE codigo = 113018 AND semestre = 2 AND ano = 2020 AND turmas = 'L';
UPDATE lo_offer_list_temporary SET lol_clas = 10 WHERE lol_seme='2' AND lol_year='2020' AND lol_cdis = '113018' AND lol_clas = 'L';
UPDATE lo_offer_list_magisterial set lom_clas = 10 WHERE lom_seme=2 AND lom_year=2020 AND lom_cdis=113018 AND lom_type = 'E' AND lom_clas = 'L';
UPDATE lo_offer_list_magisterial set lom_clas = 10 WHERE lom_seme=2 AND lom_year=2020 AND lom_cdis=113018 AND lom_type = 'T' AND lom_clas = 'L';
UPDATE lo_offer_list_magisterial set lom_sche = '321' WHERE lom_seme=2 AND lom_year=2020 AND lom_cdis=113018 AND lom_type = 'T' AND lom_clas = '10';
UPDATE lo_offer_list_magisterial set lom_clas = '10-7' WHERE lom_seme=2 AND lom_year=2020 AND lom_cdis=113018 AND lom_type = 'T' AND lom_clas = 'L-M';

--UPDATE oferta_grupos_magistral_teoria SET grupo = 4 WHERE codigo = 113018 AND semestre = 2 AND ano = 2020 AND turmas = '10';

UPDATE oferta_lista_de_ofertas SET turma = 1 WHERE disciplina = 113018 AND semestre = 2 AND ano = 2020 AND turma = 'B';
UPDATE oferta_grupos_magistral_teoria SET turmas = 1 WHERE codigo = 113018 AND semestre = 2 AND ano = 2020 AND turmas = 'B';
UPDATE lo_offer_list_temporary SET lol_clas = 1 WHERE lol_seme='2' AND lol_year='2020' AND lol_cdis = '113018' AND lol_clas = 'B';
UPDATE lo_offer_list_magisterial set lom_clas = 1 WHERE lom_seme=2 AND lom_year=2020 AND lom_cdis=113018 AND lom_type = 'E' AND lom_clas = 'B';

--UPDATE oferta_grupos_magistral_teoria SET grupo = 1 WHERE codigo = 113018 AND semestre = 2 AND ano = 2020 AND turmas = '1';

UPDATE oferta_lista_de_ofertas SET turma = 4 WHERE disciplina = 113018 AND semestre = 2 AND ano = 2020 AND turma = 'AB';
UPDATE oferta_grupos_magistral_teoria SET turmas = 4 WHERE codigo = 113018 AND semestre = 2 AND ano = 2020 AND turmas = 'AB';
UPDATE lo_offer_list_temporary SET lol_clas = 4 WHERE lol_seme='2' AND lol_year='2020' AND lol_cdis = '113018' AND lol_clas = 'AB';
UPDATE lo_offer_list_magisterial set lom_clas = 4 WHERE lom_seme=2 AND lom_year=2020 AND lom_cdis=113018 AND lom_type = 'E' AND lom_clas = 'AB';

--UPDATE oferta_grupos_magistral_teoria SET grupo = 1 WHERE codigo = 113018 AND semestre = 2 AND ano = 2020 AND turmas = '4';

UPDATE oferta_lista_de_ofertas SET turma = 2 WHERE disciplina = 113018 AND semestre = 2 AND ano = 2020 AND turma = 'A';
UPDATE oferta_grupos_magistral_teoria SET turmas = 2 WHERE codigo = 113018 AND semestre = 2 AND ano = 2020 AND turmas = 'A';
UPDATE lo_offer_list_temporary SET lol_clas = 2 WHERE lol_seme='2' AND lol_year='2020' AND lol_cdis = '113018' AND lol_clas = 'A';
UPDATE lo_offer_list_magisterial set lom_clas = 2 WHERE lom_seme=2 AND lom_year=2020 AND lom_cdis=113018 AND lom_type = 'E' AND lom_clas = 'A';
UPDATE lo_offer_list_magisterial set lom_sche = '216' WHERE lom_seme=2 AND lom_year=2020 AND lom_cdis=113018 AND lom_type = 'T' AND lom_clas = '2-4-1';

--UPDATE oferta_grupos_magistral_teoria SET grupo = 1 WHERE codigo = 113018 AND semestre = 2 AND ano = 2020 AND turmas = '2';

UPDATE oferta_lista_de_ofertas SET turma = 8 WHERE disciplina = 113018 AND semestre = 2 AND ano = 2020 AND turma = 'C';
UPDATE oferta_grupos_magistral_teoria SET grupo = 2 WHERE codigo = 113018 AND semestre = 2 AND ano = 2020 AND turmas = 'C';
UPDATE oferta_grupos_magistral_teoria SET turmas = 8 WHERE codigo = 113018 AND semestre = 2 AND ano = 2020 AND turmas = 'C';
UPDATE lo_offer_list_temporary SET lol_clas = 8 WHERE lol_seme='2' AND lol_year='2020' AND lol_cdis = '113018' AND lol_clas = 'C';
UPDATE lo_offer_list_magisterial set lom_clas = 8 WHERE lom_seme=2 AND lom_year=2020 AND lom_cdis=113018 AND lom_type = 'E' AND lom_clas = 'C';
UPDATE lo_offer_list_magisterial set lom_clas = 8 WHERE lom_seme=2 AND lom_year=2020 AND lom_cdis=113018 AND lom_type = 'T' AND lom_clas = 'C';
UPDATE lo_offer_list_magisterial set lom_sche = '308' WHERE lom_seme=2 AND lom_year=2020 AND lom_cdis=113018 AND lom_type = 'T' AND lom_clas = '8';

UPDATE oferta_lista_de_ofertas SET turma = 11 WHERE disciplina = 113018 AND semestre = 2 AND ano = 2020 AND turma = 'E';
UPDATE oferta_grupos_magistral_teoria SET turmas = 11 WHERE codigo = 113018 AND semestre = 2 AND ano = 2020 AND turmas = 'E';
UPDATE lo_offer_list_temporary SET lol_clas = 11 WHERE lol_seme='2' AND lol_year='2020' AND lol_cdis = '113018' AND lol_clas = 'E';
UPDATE lo_offer_list_magisterial set lom_clas = 11 WHERE lom_seme=2 AND lom_year=2020 AND lom_cdis=113018 AND lom_type = 'E' AND lom_clas = 'E';
UPDATE lo_offer_list_magisterial set lom_clas = '11-3-9' WHERE lom_seme=2 AND lom_year=2020 AND lom_cdis=113018 AND lom_type = 'T' AND lom_clas = 'E-K-N';
--UPDATE oferta_grupos_magistral_teoria SET grupo = 3 WHERE codigo = 113018 AND semestre = 2 AND ano = 2020 AND turmas = '11';

UPDATE oferta_lista_de_ofertas SET turma = 3 WHERE disciplina = 113018 AND semestre = 2 AND ano = 2020 AND turma = 'K';
UPDATE oferta_grupos_magistral_teoria SET turmas = 3 WHERE codigo = 113018 AND semestre = 2 AND ano = 2020 AND turmas = 'K';
UPDATE lo_offer_list_temporary SET lol_clas = 3 WHERE lol_seme='2' AND lol_year='2020' AND lol_cdis = '113018' AND lol_clas = 'K';
UPDATE lo_offer_list_magisterial set lom_clas = 3 WHERE lom_seme=2 AND lom_year=2020 AND lom_cdis=113018 AND lom_type = 'E' AND lom_clas = 'K';
--UPDATE oferta_grupos_magistral_teoria SET grupo = 3 WHERE codigo = 113018 AND semestre = 2 AND ano = 2020 AND turmas = '3';


UPDATE oferta_lista_de_ofertas SET turma = 7 WHERE disciplina = 113018 AND semestre = 2 AND ano = 2020 AND turma = 'M';
UPDATE oferta_grupos_magistral_teoria SET turmas = 7 WHERE codigo = 113018 AND semestre = 2 AND ano = 2020 AND turmas = 'M';
UPDATE lo_offer_list_temporary SET lol_clas = 7 WHERE lol_seme='2' AND lol_year='2020' AND lol_cdis = '113018' AND lol_clas = 'M';
UPDATE lo_offer_list_magisterial set lom_clas = '7' WHERE lom_seme=2 AND lom_year=2020 AND lom_cdis=113018 AND lom_clas = 'M';

--UPDATE oferta_grupos_magistral_teoria SET grupo = 4 WHERE codigo = 113018 AND semestre = 2 AND ano = 2020 AND turmas = '7';

UPDATE oferta_lista_de_ofertas SET turma = 9 WHERE disciplina = 113018 AND semestre = 2 AND ano = 2020 AND turma = 'N';
UPDATE oferta_grupos_magistral_teoria SET turmas = 9 WHERE codigo = 113018 AND semestre = 2 AND ano = 2020 AND turmas = 'N';
UPDATE lo_offer_list_temporary SET lol_clas = 9 WHERE lol_seme='2' AND lol_year='2020' AND lol_cdis = '113018' AND lol_clas = 'N';
UPDATE lo_offer_list_magisterial set lom_clas = 9 WHERE lom_seme=2 AND lom_year=2020 AND lom_cdis=113018 AND lom_type = 'E' AND lom_clas = 'N';

UPDATE oferta_lista_de_ofertas SET turma = 5 WHERE disciplina = 113018 AND semestre = 2 AND ano = 2020 AND turma = 'G';
UPDATE oferta_grupos_magistral_teoria SET turmas = 5 WHERE codigo = 113018 AND semestre = 2 AND ano = 2020 AND turmas = 'G';
UPDATE lo_offer_list_temporary SET lol_clas = 5 WHERE lol_seme='2' AND lol_year='2020' AND lol_cdis = '113018' AND lol_clas = 'G';
UPDATE lo_offer_list_magisterial set lom_clas = 5 WHERE lom_seme=2 AND lom_year=2020 AND lom_cdis=113018 AND lom_type = 'E' AND lom_clas = 'G';

UPDATE oferta_lista_de_ofertas SET turma = 6 WHERE disciplina = 113018 AND semestre = 2 AND ano = 2020 AND turma = 'H';
UPDATE oferta_grupos_magistral_teoria SET turmas = 6 WHERE codigo = 113018 AND semestre = 2 AND ano = 2020 AND turmas = 'H';
UPDATE lo_offer_list_temporary SET lol_clas = 6 WHERE lol_seme='2' AND lol_year='2020' AND lol_cdis = '113018' AND lol_clas = 'H';
UPDATE lo_offer_list_magisterial set lom_clas = 6 WHERE lom_seme=2 AND lom_year=2020 AND lom_cdis=113018 AND lom_type = 'E' AND lom_clas = 'H';
UPDATE lo_offer_list_magisterial SET lom_clas = '8-6' WHERE lom_seme=2 AND lom_year=2020 AND lom_cdis=113018 AND lom_type = 'T' AND lom_clas = 'C-H';

UPDATE oferta_lista_de_ofertas SET turma = 12 WHERE disciplina = 113018 AND semestre = 2 AND ano = 2020 AND turma = 'I';
UPDATE oferta_grupos_magistral_teoria SET turmas = 12 WHERE codigo = 113018 AND semestre = 2 AND ano = 2020 AND turmas = 'I';
UPDATE lo_offer_list_temporary SET lol_clas = 12 WHERE lol_seme='2' AND lol_year='2020' AND lol_cdis = '113018' AND lol_clas = 'I';
UPDATE lo_offer_list_magisterial set lom_clas = 12 WHERE lom_seme=2 AND lom_year=2020 AND lom_cdis=113018 AND lom_type = 'E' AND lom_clas = 'I';
UPDATE lo_offer_list_magisterial SET lom_clas = '5-12' WHERE lom_seme=2 AND lom_year=2020 AND lom_cdis=113018 AND lom_type = 'T' AND lom_clas = 'G-I';

--UPDATE oferta_grupos_magistral_teoria SET grupo = 3 WHERE codigo = 113018 AND semestre = 2 AND ano = 2020 AND turmas = '9';

--C1
UPDATE oferta_lista_de_ofertas SET turma = 27 WHERE disciplina = 113034 AND semestre = 2 AND ano = 2020 AND turma = 'A';
UPDATE oferta_grupos_magistral_teoria SET turmas = 27 WHERE codigo = 113034 AND semestre = 2 AND ano = 2020 AND turmas = 'A';
UPDATE lo_offer_list_temporary SET lol_clas = 27 WHERE lol_seme='2' AND lol_year='2020' AND lol_cdis = '113034' AND lol_clas = 'A';
UPDATE lo_offer_list_magisterial set lom_clas = 27 WHERE lom_seme=2 AND lom_year=2020 AND lom_cdis=113034 AND lom_type = 'E' AND lom_clas = 'A';
UPDATE lo_offer_list_magisterial set lom_clas = '27-13' WHERE lom_seme=2 AND lom_year=2020 AND lom_cdis=113034 AND lom_type = 'T' AND lom_clas = 'A-F';


--UPDATE oferta_grupos_magistral_teoria SET grupo = 3 WHERE codigo = 113018 AND semestre = 2 AND ano = 2020 AND turmas = '27';

UPDATE oferta_lista_de_ofertas SET turma = 2 WHERE disciplina = 113034 AND semestre = 2 AND ano = 2020 AND turma = 'B';
UPDATE oferta_grupos_magistral_teoria SET turmas = 2 WHERE codigo = 113034 AND semestre = 2 AND ano = 2020 AND turmas = 'B';
UPDATE lo_offer_list_temporary SET lol_clas = 2 WHERE lol_seme='2' AND lol_year='2020' AND lol_cdis = '113034' AND lol_clas = 'B';
UPDATE lo_offer_list_magisterial SET lom_clas = 2 WHERE lom_seme=2 AND lom_year=2020 AND lom_cdis=113034 AND lom_type = 'E' AND lom_clas = 'B';
UPDATE lo_offer_list_magisterial SET lom_clas = '2-16' WHERE lom_seme=2 AND lom_year=2020 AND lom_cdis=113034 AND lom_type = 'T' AND lom_clas = 'B-Z';

UPDATE oferta_lista_de_ofertas SET turma = 31 WHERE disciplina = 113034 AND semestre = 2 AND ano = 2020 AND turma = 'C';
UPDATE oferta_grupos_magistral_teoria SET turmas = 31 WHERE codigo = 113034 AND semestre = 2 AND ano = 2020 AND turmas = 'C';
UPDATE lo_offer_list_temporary SET lol_clas = 31 WHERE lol_seme='2' AND lol_year='2020' AND lol_cdis = '113034' AND lol_clas = 'C';
UPDATE lo_offer_list_magisterial SET lom_clas = 31 WHERE lom_seme=2 AND lom_year=2020 AND lom_cdis=113034 AND lom_type = 'E' AND lom_clas = 'C';
UPDATE lo_offer_list_magisterial SET lom_clas = '31-21' WHERE lom_seme=2 AND lom_year=2020 AND lom_cdis=113034 AND lom_type = 'T' AND lom_clas = 'C-H';

UPDATE oferta_lista_de_ofertas SET turma = 3 WHERE disciplina = 113034 AND semestre = 2 AND ano = 2020 AND turma = 'D';
UPDATE oferta_grupos_magistral_teoria SET turmas = 3 WHERE codigo = 113034 AND semestre = 2 AND ano = 2020 AND turmas = 'D';
UPDATE lo_offer_list_temporary SET lol_clas = 3 WHERE lol_seme='2' AND lol_year='2020' AND lol_cdis = '113034' AND lol_clas = 'D';
UPDATE lo_offer_list_magisterial SET lom_clas = 3 WHERE lom_seme=2 AND lom_year=2020 AND lom_cdis=113034 AND lom_type = 'E' AND lom_clas = 'D';
UPDATE lo_offer_list_magisterial SET lom_clas = '3-21' WHERE lom_seme=2 AND lom_year=2020 AND lom_cdis=113034 AND lom_type = 'T' AND lom_clas = 'D-H';
UPDATE lo_offer_list_magisterial SET lom_clas = '3-14' WHERE lom_seme=2 AND lom_year=2020 AND lom_cdis=113034 AND lom_type = 'T' AND lom_clas = 'D-M';

UPDATE oferta_lista_de_ofertas SET turma = 32 WHERE disciplina = 113034 AND semestre = 2 AND ano = 2020 AND turma = 'E';
UPDATE oferta_grupos_magistral_teoria SET turmas = 32 WHERE codigo = 113034 AND semestre = 2 AND ano = 2020 AND turmas = 'E';
UPDATE lo_offer_list_temporary SET lol_clas = 32 WHERE lol_seme='2' AND lol_year='2020' AND lol_cdis = '113034' AND lol_clas = 'E';
UPDATE lo_offer_list_magisterial SET lom_clas = 32 WHERE lom_seme=2 AND lom_year=2020 AND lom_cdis=113034 AND lom_type = 'E' AND lom_clas = 'E';
UPDATE lo_offer_list_magisterial SET lom_clas = 32 WHERE lom_seme=2 AND lom_year=2020 AND lom_cdis=113034 AND lom_type = 'T' AND lom_clas = 'E';

UPDATE oferta_lista_de_ofertas SET turma = 13 WHERE disciplina = 113034 AND semestre = 2 AND ano = 2020 AND turma = 'F';
UPDATE oferta_grupos_magistral_teoria SET turmas = 13 WHERE codigo = 113034 AND semestre = 2 AND ano = 2020 AND turmas = 'F';
UPDATE lo_offer_list_temporary SET lol_clas = 13 WHERE lol_seme='2' AND lol_year='2020' AND lol_cdis = '113034' AND lol_clas = 'F';
UPDATE lo_offer_list_magisterial SET lom_clas = 13 WHERE lom_seme=2 AND lom_year=2020 AND lom_cdis=113034 AND lom_type = 'E' AND lom_clas = 'F';

UPDATE oferta_lista_de_ofertas SET turma = 26 WHERE disciplina = 113034 AND semestre = 2 AND ano = 2020 AND turma = 'G';
UPDATE oferta_grupos_magistral_teoria SET turmas = 26 WHERE codigo = 113034 AND semestre = 2 AND ano = 2020 AND turmas = 'G';
UPDATE lo_offer_list_temporary SET lol_clas = 26 WHERE lol_seme='2' AND lol_year='2020' AND lol_cdis = '113034' AND lol_clas = 'G';
UPDATE lo_offer_list_magisterial SET lom_clas = 26 WHERE lom_seme=2 AND lom_year=2020 AND lom_cdis=113034 AND lom_type = 'E' AND lom_clas = 'G';
UPDATE lo_offer_list_magisterial SET lom_clas = '26-24' WHERE lom_seme=2 AND lom_year=2020 AND lom_cdis=113034 AND lom_type = 'T' AND lom_clas = 'G-K';

UPDATE oferta_lista_de_ofertas SET turma = 21 WHERE disciplina = 113034 AND semestre = 2 AND ano = 2020 AND turma = 'H';
UPDATE oferta_grupos_magistral_teoria SET turmas = 21 WHERE codigo = 113034 AND semestre = 2 AND ano = 2020 AND turmas = 'H';
UPDATE lo_offer_list_temporary SET lol_clas = 21 WHERE lol_seme='2' AND lol_year='2020' AND lol_cdis = '113034' AND lol_clas = 'H';
UPDATE lo_offer_list_magisterial set lom_clas = 21 WHERE lom_seme=2 AND lom_year=2020 AND lom_cdis=113034 AND lom_type = 'E' AND lom_clas = 'H';

UPDATE oferta_lista_de_ofertas SET turma = 23 WHERE disciplina = 113034 AND semestre = 2 AND ano = 2020 AND turma = 'I';
UPDATE oferta_grupos_magistral_teoria SET turmas = 23 WHERE codigo = 113034 AND semestre = 2 AND ano = 2020 AND turmas = 'I';
UPDATE lo_offer_list_temporary SET lol_clas = 23 WHERE lol_seme='2' AND lol_year='2020' AND lol_cdis = '113034' AND lol_clas = 'I';
UPDATE lo_offer_list_magisterial set lom_clas = 23 WHERE lom_seme=2 AND lom_year=2020 AND lom_cdis=113034 AND lom_type = 'E' AND lom_clas = 'I';
UPDATE lo_offer_list_magisterial set lom_clas = 23 WHERE lom_seme=2 AND lom_year=2020 AND lom_cdis=113034 AND lom_type = 'T' AND lom_clas = 'I';
UPDATE lo_offer_list_magisterial set lom_sche = '219' WHERE lom_seme=2 AND lom_year=2020 AND lom_cdis=113034 AND lom_type = 'T' AND lom_clas = '23';

UPDATE oferta_lista_de_ofertas SET turma = 22 WHERE disciplina = 113034 AND semestre = 2 AND ano = 2020 AND turma = 'J';
UPDATE oferta_grupos_magistral_teoria SET turmas = 22 WHERE codigo = 113034 AND semestre = 2 AND ano = 2020 AND turmas = 'J';
UPDATE lo_offer_list_temporary SET lol_clas = 22 WHERE lol_seme='2' AND lol_year='2020' AND lol_cdis = '113034' AND lol_clas = 'J';
UPDATE lo_offer_list_magisterial set lom_clas = 22 WHERE lom_seme=2 AND lom_year=2020 AND lom_cdis=113034 AND lom_type = 'E' AND lom_clas = 'J';
UPDATE lo_offer_list_magisterial set lom_clas = 22 WHERE lom_seme=2 AND lom_year=2020 AND lom_cdis=113034 AND lom_type = 'T' AND lom_clas = 'J';
UPDATE lo_offer_list_magisterial set lom_sche = '214' WHERE lom_seme=2 AND lom_year=2020 AND lom_cdis=113034 AND lom_type = 'T' AND lom_clas = '22';

UPDATE oferta_lista_de_ofertas SET turma = 24 WHERE disciplina = 113034 AND semestre = 2 AND ano = 2020 AND turma = 'K';
UPDATE oferta_grupos_magistral_teoria SET turmas = 24 WHERE codigo = 113034 AND semestre = 2 AND ano = 2020 AND turmas = 'K';
UPDATE lo_offer_list_temporary SET lol_clas = 24 WHERE lol_seme='2' AND lol_year='2020' AND lol_cdis = '113034' AND lol_clas = 'K';
UPDATE lo_offer_list_magisterial set lom_clas = 24 WHERE lom_seme=2 AND lom_year=2020 AND lom_cdis=113034 AND lom_type = 'E' AND lom_clas = 'K';

UPDATE oferta_lista_de_ofertas SET turma = 14 WHERE disciplina = 113034 AND semestre = 2 AND ano = 2020 AND turma = 'M';
UPDATE oferta_grupos_magistral_teoria SET turmas = 14 WHERE codigo = 113034 AND semestre = 2 AND ano = 2020 AND turmas = 'M';
UPDATE lo_offer_list_temporary SET lol_clas = 14 WHERE lol_seme='2' AND lol_year='2020' AND lol_cdis = '113034' AND lol_clas = 'M';
UPDATE lo_offer_list_magisterial set lom_clas = 14 WHERE lom_seme=2 AND lom_year=2020 AND lom_cdis=113034 AND lom_type = 'E' AND lom_clas = 'M';

UPDATE oferta_lista_de_ofertas SET turma = 6 WHERE disciplina = 113034 AND semestre = 2 AND ano = 2020 AND turma = 'N';
UPDATE oferta_grupos_magistral_teoria SET turmas = 6 WHERE codigo = 113034 AND semestre = 2 AND ano = 2020 AND turmas = 'N';
UPDATE lo_offer_list_temporary SET lol_clas = 6 WHERE lol_seme='2' AND lol_year='2020' AND lol_cdis = '113034' AND lol_clas = 'N';
UPDATE lo_offer_list_magisterial set lom_clas = 6 WHERE lom_seme=2 AND lom_year=2020 AND lom_cdis=113034 AND lom_type = 'E' AND lom_clas = 'N';
UPDATE lo_offer_list_magisterial set lom_clas = 6 WHERE lom_seme=2 AND lom_year=2020 AND lom_cdis=113034 AND lom_type = 'T' AND lom_clas = 'N';
UPDATE lo_offer_list_magisterial set lom_sche = '210' WHERE lom_seme=2 AND lom_year=2020 AND lom_cdis=113034 AND lom_type = 'T' AND lom_clas = '6';

UPDATE oferta_lista_de_ofertas SET turma = 9 WHERE disciplina = 113034 AND semestre = 2 AND ano = 2020 AND turma = 'O';
UPDATE oferta_grupos_magistral_teoria SET turmas = 9 WHERE codigo = 113034 AND semestre = 2 AND ano = 2020 AND turmas = 'O';
UPDATE lo_offer_list_temporary SET lol_clas = 9 WHERE lol_seme='2' AND lol_year='2020' AND lol_cdis = '113034' AND lol_clas = 'O';
UPDATE lo_offer_list_magisterial set lom_clas = 9 WHERE lom_seme=2 AND lom_year=2020 AND lom_cdis=113034 AND lom_type = 'E' AND lom_clas = 'O';
UPDATE lo_offer_list_magisterial set lom_clas = 9 WHERE lom_seme=2 AND lom_year=2020 AND lom_cdis=113034 AND lom_type = 'T' AND lom_clas = 'O';
UPDATE lo_offer_list_magisterial set lom_sche = '308' WHERE lom_seme=2 AND lom_year=2020 AND lom_cdis=113034 AND lom_type = 'T' AND lom_clas = '9';

UPDATE oferta_lista_de_ofertas SET turma = 19 WHERE disciplina = 113034 AND semestre = 2 AND ano = 2020 AND turma = 'P';
UPDATE oferta_grupos_magistral_teoria SET turmas = 19 WHERE codigo = 113034 AND semestre = 2 AND ano = 2020 AND turmas = 'P';
UPDATE lo_offer_list_temporary SET lol_clas = 19 WHERE lol_seme='2' AND lol_year='2020' AND lol_cdis = '113034' AND lol_clas = 'P';
UPDATE lo_offer_list_magisterial set lom_clas = 19 WHERE lom_seme=2 AND lom_year=2020 AND lom_cdis=113034 AND lom_type = 'E' AND lom_clas = 'P';
UPDATE lo_offer_list_magisterial set lom_clas = '9-29-28' WHERE lom_seme=2 AND lom_year=2020 AND lom_cdis=113034 AND lom_type = 'T' AND lom_clas = 'P-Q-R';
UPDATE lo_offer_list_magisterial set lom_clas = '9-29-7' WHERE lom_seme=2 AND lom_year=2020 AND lom_cdis=113034 AND lom_type = 'T' AND lom_clas = 'P-Q-T';
UPDATE lo_offer_list_magisterial set lom_clas = '9-7' WHERE lom_seme=2 AND lom_year=2020 AND lom_cdis=113034 AND lom_type = 'T' AND lom_clas = 'P-T';

UPDATE oferta_lista_de_ofertas SET turma = 29 WHERE disciplina = 113034 AND semestre = 2 AND ano = 2020 AND turma = 'Q';
UPDATE oferta_grupos_magistral_teoria SET turmas = 29 WHERE codigo = 113034 AND semestre = 2 AND ano = 2020 AND turmas = 'Q';
UPDATE lo_offer_list_temporary SET lol_clas = 29 WHERE lol_seme='2' AND lol_year='2020' AND lol_cdis = '113034' AND lol_clas = 'Q';
UPDATE lo_offer_list_magisterial set lom_clas = 29 WHERE lom_seme=2 AND lom_year=2020 AND lom_cdis=113034 AND lom_clas = 'Q' AND lom_type = 'E';

UPDATE oferta_lista_de_ofertas SET turma = 28 WHERE disciplina = 113034 AND semestre = 2 AND ano = 2020 AND turma = 'R';
UPDATE oferta_grupos_magistral_teoria SET turmas = 28 WHERE codigo = 113034 AND semestre = 2 AND ano = 2020 AND turmas = 'R';
UPDATE lo_offer_list_temporary SET lol_clas = 28 WHERE lol_seme='2' AND lol_year='2020' AND lol_cdis = '113034' AND lol_clas = 'R';
UPDATE lo_offer_list_magisterial set lom_clas = 28 WHERE lom_seme=2 AND lom_year=2020 AND lom_cdis=113034 AND lom_type = 'E' AND lom_clas = 'R';
UPDATE lo_offer_list_magisterial set lom_clas = '28-11-25' WHERE lom_seme=2 AND lom_year=2020 AND lom_cdis=113034 AND lom_type = 'T' AND lom_clas = 'R-S-Y';
UPDATE lo_offer_list_magisterial set lom_sche = '208' WHERE lom_seme=2 AND lom_year=2020 AND lom_cdis=113034 AND lom_type = 'T' AND lom_clas = '28-11-25';

UPDATE oferta_lista_de_ofertas SET turma = 11 WHERE disciplina = 113034 AND semestre = 2 AND ano = 2020 AND turma = 'S';
UPDATE oferta_grupos_magistral_teoria SET turmas = 11 WHERE codigo = 113034 AND semestre = 2 AND ano = 2020 AND turmas = 'S';
UPDATE lo_offer_list_temporary SET lol_clas = 11 WHERE lol_seme='2' AND lol_year='2020' AND lol_cdis = '113034' AND lol_clas = 'S';
UPDATE lo_offer_list_magisterial set lom_clas = 11 WHERE lom_seme=2 AND lom_year=2020 AND lom_cdis=113034 AND lom_type = 'E' AND lom_clas = 'S';

UPDATE oferta_lista_de_ofertas SET turma = 7 WHERE disciplina = 113034 AND semestre = 2 AND ano = 2020 AND turma = 'T';
UPDATE oferta_grupos_magistral_teoria SET turmas = 7 WHERE codigo = 113034 AND semestre = 2 AND ano = 2020 AND turmas = 'T';
UPDATE lo_offer_list_temporary SET lol_clas = 7 WHERE lol_seme='2' AND lol_year='2020' AND lol_cdis = '113034' AND lol_clas = 'T';
UPDATE lo_offer_list_magisterial set lom_clas = 7 WHERE lom_seme=2 AND lom_year=2020 AND lom_cdis=113034 AND lom_type = 'E' AND lom_clas = 'T';

UPDATE oferta_lista_de_ofertas SET turma = 25 WHERE disciplina = 113034 AND semestre = 2 AND ano = 2020 AND turma = 'Y';
UPDATE oferta_grupos_magistral_teoria SET turmas = 25 WHERE codigo = 113034 AND semestre = 2 AND ano = 2020 AND turmas = 'Y';
UPDATE lo_offer_list_temporary SET lol_clas = 25 WHERE lol_seme='2' AND lol_year='2020' AND lol_cdis = '113034' AND lol_clas = 'Y';
UPDATE lo_offer_list_magisterial set lom_clas = 25 WHERE lom_seme=2 AND lom_year=2020 AND lom_cdis=113034 AND lom_type = 'E' AND lom_clas = 'Y';
UPDATE lo_offer_list_magisterial set lom_clas = '11-25' WHERE lom_seme=2 AND lom_year=2020 AND lom_cdis=113034 AND lom_type = 'T' AND lom_clas = 'S-Y';

UPDATE oferta_lista_de_ofertas SET turma = 16 WHERE disciplina = 113034 AND semestre = 2 AND ano = 2020 AND turma = 'Z';
UPDATE oferta_grupos_magistral_teoria SET turmas = 16 WHERE codigo = 113034 AND semestre = 2 AND ano = 2020 AND turmas = 'Z';
UPDATE lo_offer_list_temporary SET lol_clas = 16 WHERE lol_seme='2' AND lol_year='2020' AND lol_cdis = '113034' AND lol_clas = 'Z';
UPDATE lo_offer_list_magisterial set lom_clas = 16 WHERE lom_seme=2 AND lom_year=2020 AND lom_cdis=113034 AND lom_type = 'E' AND lom_clas = 'Z';

--Cálculo 1 Semipresencial
UPDATE oferta_lista_de_ofertas SET turma = 1 WHERE disciplina = 200107 AND semestre = 2 AND ano = 2020 AND turma = 'A';
UPDATE lo_offer_list_temporary SET lol_clas = 1 WHERE lol_seme='2' AND lol_year='2020' AND lol_cdis = '200107' AND lol_clas = 'A';

UPDATE oferta_lista_de_ofertas SET turma = 2 WHERE disciplina = 200107 AND semestre = 2 AND ano = 2020 AND turma = 'B';
UPDATE lo_offer_list_temporary SET lol_clas = 2 WHERE lol_seme='2' AND lol_year='2020' AND lol_cdis = '200107' AND lol_clas = 'B';

UPDATE oferta_lista_de_ofertas SET turma = 3 WHERE disciplina = 200107 AND semestre = 2 AND ano = 2020 AND turma = 'C';
UPDATE lo_offer_list_temporary SET lol_clas = 3 WHERE lol_seme='2' AND lol_year='2020' AND lol_cdis = '200107' AND lol_clas = 'C';

UPDATE oferta_lista_de_ofertas SET turma = 4 WHERE disciplina = 200107 AND semestre = 2 AND ano = 2020 AND turma = 'D';
UPDATE lo_offer_list_temporary SET lol_clas = 4 WHERE lol_seme='2' AND lol_year='2020' AND lol_cdis = '200107' AND lol_clas = 'D';

UPDATE oferta_lista_de_ofertas SET turma = 5 WHERE disciplina = 200107 AND semestre = 2 AND ano = 2020 AND turma = 'E';
UPDATE lo_offer_list_temporary SET lol_clas = 5 WHERE lol_seme='2' AND lol_year='2020' AND lol_cdis = '200107' AND lol_clas = 'E';

UPDATE oferta_lista_de_ofertas SET turma = 6 WHERE disciplina = 200107 AND semestre = 2 AND ano = 2020 AND turma = 'F';
UPDATE lo_offer_list_temporary SET lol_clas = 6 WHERE lol_seme='2' AND lol_year='2020' AND lol_cdis = '200107' AND lol_clas = 'F';

UPDATE oferta_lista_de_ofertas SET turma = 7 WHERE disciplina = 200107 AND semestre = 2 AND ano = 2020 AND turma = 'G';
UPDATE lo_offer_list_temporary SET lol_clas = 7 WHERE lol_seme='2' AND lol_year='2020' AND lol_cdis = '200107' AND lol_clas = 'G';

UPDATE oferta_lista_de_ofertas SET turma = 8 WHERE disciplina = 200107 AND semestre = 2 AND ano = 2020 AND turma = 'H';
UPDATE lo_offer_list_temporary SET lol_clas = 8 WHERE lol_seme='2' AND lol_year='2020' AND lol_cdis = '200107' AND lol_clas = 'H';

UPDATE oferta_lista_de_ofertas SET turma = 9 WHERE disciplina = 200107 AND semestre = 2 AND ano = 2020 AND turma = 'I';
UPDATE lo_offer_list_temporary SET lol_clas = 9 WHERE lol_seme='2' AND lol_year='2020' AND lol_cdis = '200107' AND lol_clas = 'I';

--Álgebra 1
UPDATE oferta_lista_de_ofertas SET turma = 1 WHERE disciplina = 113107 AND semestre = 2 AND ano = 2020 AND turma = 'A';
UPDATE lo_offer_list_temporary SET lol_clas = 1 WHERE lol_seme='2' AND lol_year='2020' AND lol_cdis = '113107' AND lol_clas = 'A';

UPDATE oferta_lista_de_ofertas SET turma = 3 WHERE disciplina = 113107 AND semestre = 2 AND ano = 2020 AND turma = 'B';
UPDATE lo_offer_list_temporary SET lol_clas = 3 WHERE lol_seme='2' AND lol_year='2020' AND lol_cdis = '113107' AND lol_clas = 'B';

UPDATE oferta_lista_de_ofertas SET turma = 2 WHERE disciplina = 113107 AND semestre = 2 AND ano = 2020 AND turma = 'C';
UPDATE lo_offer_list_temporary SET lol_clas = 2 WHERE lol_seme='2' AND lol_year='2020' AND lol_cdis = '113107' AND lol_clas = 'C';

--Álgebra 2
UPDATE oferta_lista_de_ofertas SET turma = 1 WHERE disciplina = 113131 AND semestre = 2 AND ano = 2020 AND turma = 'A';
UPDATE lo_offer_list_temporary SET lol_clas = 1 WHERE lol_seme='2' AND lol_year='2020' AND lol_cdis = '113131' AND lol_clas = 'A';

--Álgebra 3
UPDATE oferta_lista_de_ofertas SET turma = 1 WHERE disciplina = 117145 AND semestre = 2 AND ano = 2020 AND turma = 'A';
UPDATE lo_offer_list_temporary SET lol_clas = 1 WHERE lol_seme='2' AND lol_year='2020' AND lol_cdis = '117145' AND lol_clas = 'A';

--Álgebra Linear
UPDATE oferta_lista_de_ofertas SET turma = 1 WHERE disciplina = 113123 AND semestre = 2 AND ano = 2020 AND turma = 'A';
UPDATE lo_offer_list_temporary SET lol_clas = 1 WHERE lol_seme='2' AND lol_year='2020' AND lol_cdis = '113123' AND lol_clas = 'A';

--Álgebra Para o Ensino 1
UPDATE oferta_lista_de_ofertas SET turma = 1 WHERE disciplina = 117421 AND semestre = 2 AND ano = 2020 AND turma = 'A';
UPDATE lo_offer_list_temporary SET lol_clas = 1 WHERE lol_seme='2' AND lol_year='2020' AND lol_cdis = '117421' AND lol_clas = 'A';

--Álgebra Para o Ensino 2
UPDATE oferta_lista_de_ofertas SET turma = 2 WHERE disciplina = 117501 AND semestre = 2 AND ano = 2020 AND turma = 'A';
UPDATE lo_offer_list_temporary SET lol_clas = 2 WHERE lol_seme='2' AND lol_year='2020' AND lol_cdis = '117501' AND lol_clas = 'A';

--Cálculo de Probabilidade 1
UPDATE oferta_lista_de_ofertas SET turma = 1 WHERE disciplina = 113824 AND semestre = 2 AND ano = 2020 AND turma = 'A';
UPDATE lo_offer_list_temporary SET lol_clas = 1 WHERE lol_seme='2' AND lol_year='2020' AND lol_cdis = '113824' AND lol_clas = 'A';

UPDATE oferta_lista_de_ofertas SET turma = 2 WHERE disciplina = 113824 AND semestre = 2 AND ano = 2020 AND turma = 'B';
UPDATE lo_offer_list_temporary SET lol_clas = 2 WHERE lol_seme='2' AND lol_year='2020' AND lol_cdis = '113824' AND lol_clas = 'B';

UPDATE oferta_lista_de_ofertas SET turma = 3 WHERE disciplina = 113824 AND semestre = 2 AND ano = 2020 AND turma = 'C';
UPDATE lo_offer_list_temporary SET lol_clas = 3 WHERE lol_seme='2' AND lol_year='2020' AND lol_cdis = '113824' AND lol_clas = 'C';

--Cálculo de Probabilidade 2
UPDATE oferta_lista_de_ofertas SET turma = 1 WHERE disciplina = 113832 AND semestre = 2 AND ano = 2020 AND turma = 'A';
UPDATE lo_offer_list_temporary SET lol_clas = 1 WHERE lol_seme='2' AND lol_year='2020' AND lol_cdis = '113832' AND lol_clas = 'A';

--Análise 1
UPDATE oferta_lista_de_ofertas SET turma = 1 WHERE disciplina = 113204 AND semestre = 2 AND ano = 2020 AND turma = 'A';
UPDATE lo_offer_list_temporary SET lol_clas = 1 WHERE lol_seme='2' AND lol_year='2020' AND lol_cdis = '113204' AND lol_clas = 'A';

UPDATE oferta_lista_de_ofertas SET turma = 2 WHERE disciplina = 113204 AND semestre = 2 AND ano = 2020 AND turma = 'B';
UPDATE lo_offer_list_temporary SET lol_clas = 2 WHERE lol_seme='2' AND lol_year='2020' AND lol_cdis = '113204' AND lol_clas = 'B';

--Análise 2
UPDATE oferta_lista_de_ofertas SET turma = 1 WHERE disciplina = 113212 AND semestre = 2 AND ano = 2020 AND turma = 'A';
UPDATE lo_offer_list_temporary SET lol_clas = 1 WHERE lol_seme='2' AND lol_year='2020' AND lol_cdis = '113212' AND lol_clas = 'A';

--Análise 3
UPDATE oferta_lista_de_ofertas SET turma = 1 WHERE disciplina = 117137 AND semestre = 2 AND ano = 2020 AND turma = 'A';
UPDATE lo_offer_list_temporary SET lol_clas = 1 WHERE lol_seme='2' AND lol_year='2020' AND lol_cdis = '117137' AND lol_clas = 'A';

UPDATE oferta_lista_de_ofertas SET turma = 2 WHERE disciplina = 113204 AND semestre = 2 AND ano = 2020 AND turma = 'B';
UPDATE lo_offer_list_temporary SET lol_clas = 2 WHERE lol_seme='2' AND lol_year='2020' AND lol_cdis = '117137' AND lol_clas = 'B';

--Análise Conbinatória
UPDATE oferta_lista_de_ofertas SET turma = 1 WHERE disciplina = 113972 AND semestre = 2 AND ano = 2020 AND turma = 'A';
UPDATE lo_offer_list_temporary SET lol_clas = 2 WHERE lol_seme='2' AND lol_year='2020' AND lol_cdis = '113972' AND lol_clas = 'A';

--Cálculo Numérico
UPDATE oferta_lista_de_ofertas SET turma = 5 WHERE disciplina = 113417 AND semestre = 2 AND ano = 2020 AND turma = 'A';
UPDATE lo_offer_list_temporary SET lol_clas = 5 WHERE lol_seme='2' AND lol_year='2020' AND lol_cdis = '113417' AND lol_clas = 'A';

UPDATE oferta_lista_de_ofertas SET turma = 3 WHERE disciplina = 113417 AND semestre = 2 AND ano = 2020 AND turma = 'B';
UPDATE lo_offer_list_temporary SET lol_clas = 3 WHERE lol_seme='2' AND lol_year='2020' AND lol_cdis = '113417' AND lol_clas = 'B';

UPDATE oferta_lista_de_ofertas SET turma = 4 WHERE disciplina = 113417 AND semestre = 2 AND ano = 2020 AND turma = 'C';
UPDATE lo_offer_list_temporary SET lol_clas = 4 WHERE lol_seme='2' AND lol_year='2020' AND lol_cdis = '113417' AND lol_clas = 'C';

UPDATE oferta_lista_de_ofertas SET turma = 1 WHERE disciplina = 113417 AND semestre = 2 AND ano = 2020 AND turma = 'D';
UPDATE lo_offer_list_temporary SET lol_clas = 1 WHERE lol_seme='2' AND lol_year='2020' AND lol_cdis = '113417' AND lol_clas = 'D';

UPDATE oferta_lista_de_ofertas SET turma = 2 WHERE disciplina = 113417 AND semestre = 2 AND ano = 2020 AND turma = 'E';
UPDATE lo_offer_list_temporary SET lol_clas = 2 WHERE lol_seme='2' AND lol_year='2020' AND lol_cdis = '113417' AND lol_clas = 'E';

--Geometria 1
UPDATE oferta_lista_de_ofertas SET turma = 1 WHERE disciplina = 117161 AND semestre = 2 AND ano = 2020 AND turma = 'A';
UPDATE lo_offer_list_temporary SET lol_clas = 1 WHERE lol_seme='2' AND lol_year='2020' AND lol_cdis = '117161' AND lol_clas = 'A';

--Geometria 2
UPDATE oferta_lista_de_ofertas SET turma = 1 WHERE disciplina =  117170 AND semestre = 2 AND ano = 2020 AND turma = 'A';
UPDATE lo_offer_list_temporary SET lol_clas = 1 WHERE lol_seme='2' AND lol_year='2020' AND lol_cdis = '117170' AND lol_clas = 'A';

--Geometria para o Ensino 1
UPDATE oferta_lista_de_ofertas SET turma = 2 WHERE disciplina = 117471 AND semestre = 2 AND ano = 2020 AND turma = 'B';
UPDATE lo_offer_list_temporary SET lol_clas = 2 WHERE lol_seme='2' AND lol_year='2020' AND lol_cdis = '117471' AND lol_clas = 'B';

--Geometria para o Ensino 2
UPDATE oferta_lista_de_ofertas SET turma = 2 WHERE disciplina = 117480 AND semestre = 2 AND ano = 2020 AND turma = 'B';
UPDATE lo_offer_list_temporary SET lol_clas = 2 WHERE lol_seme='2' AND lol_year='2020' AND lol_cdis = '117480' AND lol_clas = 'B';

--Introdução à Teoria dos Grafos
UPDATE oferta_lista_de_ofertas SET turma = 1 WHERE disciplina = 113930 AND semestre = 2 AND ano = 2020 AND turma = 'A';
UPDATE lo_offer_list_temporary SET lol_clas = 1 WHERE lol_seme='2' AND lol_year='2020' AND lol_cdis = '113930' AND lol_clas = 'A';

--Métodos Matemáticos da Física 1
UPDATE oferta_lista_de_ofertas SET turma = 1 WHERE disciplina = 113522 AND semestre = 2 AND ano = 2020 AND turma = 'A';
UPDATE lo_offer_list_temporary SET lol_clas = 1 WHERE lol_seme='2' AND lol_year='2020' AND lol_cdis = '113522' AND lol_clas = 'A';

--MAT2
UPDATE oferta_lista_de_ofertas SET turma = 1 WHERE disciplina = 113026 AND semestre = 2 AND ano = 2020 AND turma = 'A';
UPDATE lo_offer_list_temporary SET lol_clas = 1 WHERE lol_seme='2' AND lol_year='2020' AND lol_cdis = '113026' AND lol_clas = 'A';

UPDATE oferta_lista_de_ofertas SET turma = 2 WHERE disciplina = 113026 AND semestre = 2 AND ano = 2020 AND turma = 'B';
UPDATE lo_offer_list_temporary SET lol_clas = 2 WHERE lol_seme='2' AND lol_year='2020' AND lol_cdis = '113026' AND lol_clas = 'B';

--Regencia 2
UPDATE oferta_lista_de_ofertas SET turma = 1 WHERE disciplina = 117439 AND semestre = 2 AND ano = 2020 AND turma = 'B';
UPDATE lo_offer_list_temporary SET lol_clas = 1 WHERE lol_seme='2' AND lol_year='2020' AND lol_cdis = '117439' AND lol_clas = 'B';

UPDATE oferta_lista_de_ofertas SET turma = 2 WHERE disciplina = 117439 AND semestre = 2 AND ano = 2020 AND turma = 'A';
UPDATE lo_offer_list_temporary SET lol_clas = 2 WHERE lol_seme='2' AND lol_year='2020' AND lol_cdis = '117439' AND lol_clas = 'A';

--Regencia 1
UPDATE oferta_lista_de_ofertas SET turma = 1 WHERE disciplina = 117510 AND semestre = 2 AND ano = 2020 AND turma = 'A';
UPDATE lo_offer_list_temporary SET lol_clas = 1 WHERE lol_seme='2' AND lol_year='2020' AND lol_cdis = '117510' AND lol_clas = 'A';

--TN 1
UPDATE oferta_lista_de_ofertas SET turma = 1 WHERE disciplina = 113115 AND semestre = 2 AND ano = 2020 AND turma = 'B';
UPDATE lo_offer_list_temporary SET lol_clas = 1 WHERE lol_seme='2' AND lol_year='2020' AND lol_cdis = '113115' AND lol_clas = 'B';

UPDATE oferta_lista_de_ofertas SET turma = 2 WHERE disciplina = 113115 AND semestre = 2 AND ano = 2020 AND turma = 'A';
UPDATE lo_offer_list_temporary SET lol_clas = 2 WHERE lol_seme='2' AND lol_year='2020' AND lol_cdis = '113115' AND lol_clas = 'A';

--VC 1
UPDATE oferta_lista_de_ofertas SET turma = 1 WHERE disciplina = 113069 AND semestre = 2 AND ano = 2020 AND turma = 'B';
UPDATE lo_offer_list_temporary SET lol_clas = 1 WHERE lol_seme='2' AND lol_year='2020' AND lol_cdis = '113069' AND lol_clas = 'B';

UPDATE oferta_lista_de_ofertas SET turma = 2 WHERE disciplina = 113069 AND semestre = 2 AND ano = 2020 AND turma = 'A';
UPDATE lo_offer_list_temporary SET lol_clas = 2 WHERE lol_seme='2' AND lol_year='2020' AND lol_cdis = '113069' AND lol_clas = 'A';

UPDATE oferta_lista_de_ofertas SET turma = 3 WHERE disciplina = 113069 AND semestre = 2 AND ano = 2020 AND turma = 'C';
UPDATE lo_offer_list_temporary SET lol_clas = 3 WHERE lol_seme='2' AND lol_year='2020' AND lol_cdis = '113069' AND lol_clas = 'C';

--C2
UPDATE oferta_lista_de_ofertas SET turma = 12 WHERE disciplina = 113042 AND semestre = 2 AND ano = 2020 AND turma = 'A';
UPDATE lo_offer_list_temporary SET lol_clas = 12 WHERE lol_seme='2' AND lol_year='2020' AND lol_cdis = '113042' AND lol_clas = 'A';

UPDATE oferta_lista_de_ofertas SET turma = 8 WHERE disciplina = 113042 AND semestre = 2 AND ano = 2020 AND turma = 'B';
UPDATE lo_offer_list_temporary SET lol_clas = 8 WHERE lol_seme='2' AND lol_year='2020' AND lol_cdis = '113042' AND lol_clas = 'B';

UPDATE oferta_lista_de_ofertas SET turma = 17 WHERE disciplina = 113042 AND semestre = 2 AND ano = 2020 AND turma = 'C';
UPDATE lo_offer_list_temporary SET lol_clas = 17 WHERE lol_seme='2' AND lol_year='2020' AND lol_cdis = '113042' AND lol_clas = 'C';

UPDATE oferta_lista_de_ofertas SET turma = 6 WHERE disciplina = 113042 AND semestre = 2 AND ano = 2020 AND turma = 'D';
UPDATE lo_offer_list_temporary SET lol_clas = 6 WHERE lol_seme='2' AND lol_year='2020' AND lol_cdis = '113042' AND lol_clas = 'D';

UPDATE oferta_lista_de_ofertas SET turma = 2 WHERE disciplina = 113042 AND semestre = 2 AND ano = 2020 AND turma = 'E';
UPDATE lo_offer_list_temporary SET lol_clas = 2 WHERE lol_seme='2' AND lol_year='2020' AND lol_cdis = '113042' AND lol_clas = 'E';

UPDATE oferta_lista_de_ofertas SET turma = 4 WHERE disciplina = 113042 AND semestre = 2 AND ano = 2020 AND turma = 'F';
UPDATE lo_offer_list_temporary SET lol_clas = 4 WHERE lol_seme='2' AND lol_year='2020' AND lol_cdis = '113042' AND lol_clas = 'F';

UPDATE oferta_lista_de_ofertas SET turma = 18 WHERE disciplina = 113042 AND semestre = 2 AND ano = 2020 AND turma = 'G';
UPDATE lo_offer_list_temporary SET lol_clas = 18 WHERE lol_seme='2' AND lol_year='2020' AND lol_cdis = '113042' AND lol_clas = 'G';

UPDATE oferta_lista_de_ofertas SET turma = 7 WHERE disciplina = 113042 AND semestre = 2 AND ano = 2020 AND turma = 'H';
UPDATE lo_offer_list_temporary SET lol_clas = 7 WHERE lol_seme='2' AND lol_year='2020' AND lol_cdis = '113042' AND lol_clas = 'H';

UPDATE oferta_lista_de_ofertas SET turma = 14 WHERE disciplina = 113042 AND semestre = 2 AND ano = 2020 AND turma = 'I';
UPDATE lo_offer_list_temporary SET lol_clas = 14 WHERE lol_seme='2' AND lol_year='2020' AND lol_cdis = '113042' AND lol_clas = 'I';

UPDATE oferta_lista_de_ofertas SET turma = 1 WHERE disciplina = 113042 AND semestre = 2 AND ano = 2020 AND turma = 'J';
UPDATE lo_offer_list_temporary SET lol_clas = 1 WHERE lol_seme='2' AND lol_year='2020' AND lol_cdis = '113042' AND lol_clas = 'J';

UPDATE oferta_lista_de_ofertas SET turma = 15 WHERE disciplina = 113042 AND semestre = 2 AND ano = 2020 AND turma = 'K';
UPDATE lo_offer_list_temporary SET lol_clas = 15 WHERE lol_seme='2' AND lol_year='2020' AND lol_cdis = '113042' AND lol_clas = 'K';

UPDATE oferta_lista_de_ofertas SET turma = 11 WHERE disciplina = 113042 AND semestre = 2 AND ano = 2020 AND turma = 'L';
UPDATE lo_offer_list_temporary SET lol_clas = 11 WHERE lol_seme='2' AND lol_year='2020' AND lol_cdis = '113042' AND lol_clas = 'L';

UPDATE oferta_lista_de_ofertas SET turma = 13 WHERE disciplina = 113042 AND semestre = 2 AND ano = 2020 AND turma = 'M';
UPDATE lo_offer_list_temporary SET lol_clas = 13 WHERE lol_seme='2' AND lol_year='2020' AND lol_cdis = '113042' AND lol_clas = 'M';

UPDATE oferta_lista_de_ofertas SET turma = 19 WHERE disciplina = 113042 AND semestre = 2 AND ano = 2020 AND turma = 'N';
UPDATE lo_offer_list_temporary SET lol_clas = 19 WHERE lol_seme='2' AND lol_year='2020' AND lol_cdis = '113042' AND lol_clas = 'N';

--C3
UPDATE oferta_lista_de_ofertas SET turma = 11 WHERE disciplina = 113051 AND semestre = 2 AND ano = 2020 AND turma = 'A';
UPDATE lo_offer_list_temporary SET lol_clas = 11 WHERE lol_seme='2' AND lol_year='2020' AND lol_cdis = '113051' AND lol_clas = 'A';

UPDATE oferta_lista_de_ofertas SET turma = 12 WHERE disciplina = 113051 AND semestre = 2 AND ano = 2020 AND turma = 'B';
UPDATE lo_offer_list_temporary SET lol_clas = 12 WHERE lol_seme='2' AND lol_year='2020' AND lol_cdis = '113051' AND lol_clas = 'B';

UPDATE oferta_lista_de_ofertas SET turma = 4 WHERE disciplina = 113051 AND semestre = 2 AND ano = 2020 AND turma = 'C';
UPDATE lo_offer_list_temporary SET lol_clas = 4 WHERE lol_seme='2' AND lol_year='2020' AND lol_cdis = '113051' AND lol_clas = 'C';

UPDATE oferta_lista_de_ofertas SET turma = 6 WHERE disciplina = 113051 AND semestre = 2 AND ano = 2020 AND turma = 'D';
UPDATE lo_offer_list_temporary SET lol_clas = 6 WHERE lol_seme='2' AND lol_year='2020' AND lol_cdis = '113051' AND lol_clas = 'D';

UPDATE oferta_lista_de_ofertas SET turma = 1 WHERE disciplina = 113051 AND semestre = 2 AND ano = 2020 AND turma = 'E';
UPDATE lo_offer_list_temporary SET lol_clas = 1 WHERE lol_seme='2' AND lol_year='2020' AND lol_cdis = '113051' AND lol_clas = 'E';

UPDATE oferta_lista_de_ofertas SET turma = 7 WHERE disciplina = 113051 AND semestre = 2 AND ano = 2020 AND turma = 'F';
UPDATE lo_offer_list_temporary SET lol_clas = 7 WHERE lol_seme='2' AND lol_year='2020' AND lol_cdis = '113051' AND lol_clas = 'F';

UPDATE oferta_lista_de_ofertas SET turma = 8 WHERE disciplina = 113051 AND semestre = 2 AND ano = 2020 AND turma = 'G';
UPDATE lo_offer_list_temporary SET lol_clas = 8 WHERE lol_seme='2' AND lol_year='2020' AND lol_cdis = '113051' AND lol_clas = 'G';

UPDATE oferta_lista_de_ofertas SET turma = 3 WHERE disciplina = 113051 AND semestre = 2 AND ano = 2020 AND turma = 'I';
UPDATE lo_offer_list_temporary SET lol_clas = 3 WHERE lol_seme='2' AND lol_year='2020' AND lol_cdis = '113051' AND lol_clas = 'I';

UPDATE oferta_lista_de_ofertas SET turma = 9 WHERE disciplina = 113051 AND semestre = 2 AND ano = 2020 AND turma = 'J';
UPDATE lo_offer_list_temporary SET lol_clas = 9 WHERE lol_seme='2' AND lol_year='2020' AND lol_cdis = '113051' AND lol_clas = 'J';

UPDATE oferta_lista_de_ofertas SET turma = 2 WHERE disciplina = 113051 AND semestre = 2 AND ano = 2020 AND turma = 'K';
UPDATE lo_offer_list_temporary SET lol_clas = 2 WHERE lol_seme='2' AND lol_year='2020' AND lol_cdis = '113051' AND lol_clas = 'K';

--IAL
UPDATE oferta_lista_de_ofertas SET turma = 10 WHERE disciplina = 113093 AND semestre = 2 AND ano = 2020 AND turma = 'A';
UPDATE lo_offer_list_temporary SET lol_clas = 10 WHERE lol_seme='2' AND lol_year='2020' AND lol_cdis = '113093' AND lol_clas = 'A';

UPDATE oferta_lista_de_ofertas SET turma = 5 WHERE disciplina = 113093 AND semestre = 2 AND ano = 2020 AND turma = 'B';
UPDATE lo_offer_list_temporary SET lol_clas = 5 WHERE lol_seme='2' AND lol_year='2020' AND lol_cdis = '113093' AND lol_clas = 'B';

UPDATE oferta_lista_de_ofertas SET turma = 15 WHERE disciplina = 113093 AND semestre = 2 AND ano = 2020 AND turma = 'C';
UPDATE lo_offer_list_temporary SET lol_clas = 15 WHERE lol_seme='2' AND lol_year='2020' AND lol_cdis = '113093' AND lol_clas = 'C';

UPDATE oferta_lista_de_ofertas SET turma = 6 WHERE disciplina = 113093 AND semestre = 2 AND ano = 2020 AND turma = 'D';
UPDATE lo_offer_list_temporary SET lol_clas = 6 WHERE lol_seme='2' AND lol_year='2020' AND lol_cdis = '113093' AND lol_clas = 'D';

UPDATE oferta_lista_de_ofertas SET turma = 9 WHERE disciplina = 113093 AND semestre = 2 AND ano = 2020 AND turma = 'E';
UPDATE lo_offer_list_temporary SET lol_clas = 9 WHERE lol_seme='2' AND lol_year='2020' AND lol_cdis = '113093' AND lol_clas = 'E';

UPDATE oferta_lista_de_ofertas SET turma = 8 WHERE disciplina = 113093 AND semestre = 2 AND ano = 2020 AND turma = 'F';
UPDATE lo_offer_list_temporary SET lol_clas = 8 WHERE lol_seme='2' AND lol_year='2020' AND lol_cdis = '113093' AND lol_clas = 'F';

UPDATE oferta_lista_de_ofertas SET turma = 2 WHERE disciplina = 113093 AND semestre = 2 AND ano = 2020 AND turma = 'G';
UPDATE lo_offer_list_temporary SET lol_clas = 2 WHERE lol_seme='2' AND lol_year='2020' AND lol_cdis = '113093' AND lol_clas = 'G';

UPDATE oferta_lista_de_ofertas SET turma = 7 WHERE disciplina = 113093 AND semestre = 2 AND ano = 2020 AND turma = 'H';
UPDATE lo_offer_list_temporary SET lol_clas = 7 WHERE lol_seme='2' AND lol_year='2020' AND lol_cdis = '113093' AND lol_clas = 'H';

UPDATE oferta_lista_de_ofertas SET turma = 12 WHERE disciplina = 113093 AND semestre = 2 AND ano = 2020 AND turma = 'I';
UPDATE lo_offer_list_temporary SET lol_clas = 12 WHERE lol_seme='2' AND lol_year='2020' AND lol_cdis = '113093' AND lol_clas = 'I';

UPDATE oferta_lista_de_ofertas SET turma = 11 WHERE disciplina = 113093 AND semestre = 2 AND ano = 2020 AND turma = 'J';
UPDATE lo_offer_list_temporary SET lol_clas = 11 WHERE lol_seme='2' AND lol_year='2020' AND lol_cdis = '113093' AND lol_clas = 'J';

UPDATE oferta_lista_de_ofertas SET turma = 3 WHERE disciplina = 113093 AND semestre = 2 AND ano = 2020 AND turma = 'K';
UPDATE lo_offer_list_temporary SET lol_clas = 3 WHERE lol_seme='2' AND lol_year='2020' AND lol_cdis = '113093' AND lol_clas = 'K';

UPDATE oferta_lista_de_ofertas SET turma = 14 WHERE disciplina = 113093 AND semestre = 2 AND ano = 2020 AND turma = 'L';
UPDATE lo_offer_list_temporary SET lol_clas = 14 WHERE lol_seme='2' AND lol_year='2020' AND lol_cdis = '113093' AND lol_clas = 'L';

--Seminários de Tópicos em Análise
UPDATE oferta_lista_de_ofertas SET turma = 1 WHERE disciplina = 113671 AND semestre = 2 AND ano = 2020 AND turma = 'A';
UPDATE lo_offer_list_temporary SET lol_clas = 1 WHERE lol_seme='2' AND lol_year='2020' AND lol_cdis = '113671' AND lol_clas = 'A';

--Seminários de Tópicos Especiais
UPDATE oferta_lista_de_ofertas SET turma = 3 WHERE disciplina = 117013 AND semestre = 2 AND ano = 2020 AND turma = 'A';
UPDATE oferta_lista_de_ofertas SET horarios = '412' WHERE disciplina = 117013 AND semestre = 2 AND ano = 2020 and turma = '3';
UPDATE lo_offer_list_temporary SET lol_clas = 3 WHERE lol_seme='2' AND lol_year='2020' AND lol_cdis = '117013' AND lol_clas = 'A';
UPDATE lo_offer_list_temporary SET lol_sche = '412' WHERE lol_seme='2' AND lol_year='2020' AND lol_cdis = '117013' AND lol_clas = '3';

UPDATE oferta_lista_de_ofertas SET turma = 1 WHERE disciplina = 117013 AND semestre = 2 AND ano = 2020 AND turma = 'B';
UPDATE oferta_lista_de_ofertas SET horarios = '210' WHERE disciplina = 117013 AND semestre = 2 AND ano = 2020 and turma = '1';
UPDATE lo_offer_list_temporary SET lol_clas = 1 WHERE lol_seme='2' AND lol_year='2020' AND lol_cdis = '117013' AND lol_clas = 'B';
UPDATE lo_offer_list_temporary SET lol_sche = '210' WHERE lol_seme='2' AND lol_year='2020' AND lol_cdis = '117013' AND lol_clas = '1';

UPDATE oferta_lista_de_ofertas SET turma = 2 WHERE disciplina = 117013 AND semestre = 2 AND ano = 2020 AND turma = 'C';
UPDATE oferta_lista_de_ofertas SET horarios = '519' WHERE disciplina = 117013 AND semestre = 2 AND ano = 2020 and turma = '2';
UPDATE lo_offer_list_temporary SET lol_clas = 2 WHERE lol_seme='2' AND lol_year='2020' AND lol_cdis = '117013' AND lol_clas = 'C';
UPDATE lo_offer_list_temporary SET lol_sche = '519' WHERE lol_seme='2' AND lol_year='2020' AND lol_cdis = '117013' AND lol_clas = '2';

UPDATE oferta_lista_de_ofertas SET turma = 4 WHERE disciplina = 117013 AND semestre = 2 AND ano = 2020 AND turma = 'D';
UPDATE oferta_lista_de_ofertas SET horarios = '212' WHERE disciplina = 117013 AND semestre = 2 AND ano = 2020 and turma = '4';
UPDATE lo_offer_list_temporary SET lol_clas = 4 WHERE lol_seme='2' AND lol_year='2020' AND lol_cdis = '117013' AND lol_clas = 'D';
UPDATE lo_offer_list_temporary SET lol_sche = '212' WHERE lol_seme='2' AND lol_year='2020' AND lol_cdis = '117013' AND lol_clas = '4';

UPDATE oferta_lista_de_ofertas SET turma = 5 WHERE disciplina = 117013 AND semestre = 2 AND ano = 2020 AND turma = 'E';
UPDATE oferta_lista_de_ofertas SET horarios = '212' WHERE disciplina = 117013 AND semestre = 2 AND ano = 2020 and turma = '5';
UPDATE lo_offer_list_temporary SET lol_clas = 5 WHERE lol_seme='2' AND lol_year='2020' AND lol_cdis = '117013' AND lol_clas = 'E';
UPDATE lo_offer_list_temporary SET lol_sche = '212' WHERE lol_seme='2' AND lol_year='2020' AND lol_cdis = '117013' AND lol_clas = '5';

--HISTORIA DA MATEMATICA
UPDATE oferta_lista_de_ofertas SET turma = 5 WHERE disciplina = 113603 AND semestre = 2 AND ano = 2020 AND turma = 'A';
UPDATE lo_offer_list_temporary SET lol_clas = 5 WHERE lol_seme='2' AND lol_year='2020' AND lol_cdis = '113603' AND lol_clas = 'A';
