-- 2015/10/10

CREATE TABLE lo_credits_semester (
  lcs_clcs    SERIAL NOT NULL,
  lcs_coduser INTEGER NOT NULL,
  lcs_cred    INTEGER,
  lcs_year    INTEGER,
  lcs_seme    INTEGER,
  PRIMARY KEY (lcs_clcs),
  FOREIGN KEY (lcs_coduser)
    REFERENCES users (coduser));




-- 2015/11/02

CREATE TABLE lo_preferred_disciplines_graduation (
  pdg_cpdg    SERIAL NOT NULL,
  pdg_coduser INTEGER NOT NULL,
  pdg_disc    INTEGER,
  pdg_year    INTEGER,
  pdg_seme    INTEGER,
  pdg_rank    INTEGER,
  PRIMARY KEY (pdg_cpdg),
  FOREIGN KEY (pdg_coduser)
    REFERENCES users (coduser));




-- 2015/11/12

ALTER TABLE oferta_abertura_tela_lo
  ADD COLUMN codigo serial NOT NULL;
ALTER TABLE oferta_abertura_tela_lo
  ADD PRIMARY KEY (codigo);
ALTER TABLE oferta_abertura_tela_lo
  ADD COLUMN status character varying(20);

UPDATE oferta_abertura_tela_lo SET status = 'closed';




-- 2015/11/17

CREATE TABLE lo_offer_list_temporary (
  lol_clol    SERIAL NOT NULL,
  lol_cdis    INTEGER NOT NULL,
  lol_coduser INTEGER,
  lol_clas    CHARACTER VARYING(2),
  lol_peri    CHARACTER VARYING(7),
  lol_sche    CHARACTER VARYING(11),
  lol_seme    INTEGER,
  lol_year    INTEGER,
  lol_stat    CHARACTER VARYING(20) DEFAULT 'active'::CHARACTER VARYING,
  PRIMARY KEY (lol_clol),
  FOREIGN KEY (lol_cdis)
    REFERENCES disciplinas_mat (codigo),
  FOREIGN KEY (lol_coduser)
    REFERENCES users (coduser));




-- 2015/11/24

CREATE TABLE lo_table (
  lta_clta SERIAL NOT NULL,
  lta_desc CHARACTER VARYING(100),
  lta_edit BOOLEAN,
  PRIMARY KEY (lta_clta));


CREATE TABLE lo_table_item (
  lti_clti serial NOT NULL,
  lti_clta integer NOT NULL,
  lti_sval character varying(20),
  lti_valu character varying(100),
  PRIMARY KEY (lti_clti),
  FOREIGN KEY (lti_clta)
    REFERENCES lo_table (lta_clta));

INSERT INTO lo_table VALUES (1, 'Turno Tipo', false);
INSERT INTO lo_table_item VALUES (1, 1, 'Ambos', 'Ambos');
INSERT INTO lo_table_item VALUES (2, 1, 'Diurno', 'Diurno');
INSERT INTO lo_table_item VALUES (3, 1, 'Noturno', 'Noturno');

SELECT pg_catalog.setval('lo_table_lta_clta_seq', 1, true);
SELECT pg_catalog.setval('lo_table_item_lti_clti_seq', 3, true);




-- 2015/12/10

ALTER TABLE oferta_lista_de_ofertas
  ADD COLUMN sala character varying(30);


ALTER TABLE lo_offer_list_temporary
  ADD COLUMN lol_croo character varying(30);
COMMENT ON COLUMN lo_offer_list_temporary.lol_croo IS 'Classroom';




-- 2016/03/20

ALTER TABLE lo_preferred_disciplines_graduation
  ADD COLUMN pdg_quan integer;
ALTER TABLE lo_preferred_disciplines_graduation
  ADD COLUMN pdg_type character varying(20);
COMMENT ON COLUMN lo_preferred_disciplines_graduation.pdg_quan IS 'Quantidade de turmas desejada desejada';
COMMENT ON COLUMN lo_preferred_disciplines_graduation.pdg_type IS 'Tipo da disciplina: normal, exercicio, teorica';




-- 2016/09/08

INSERT INTO lo_table VALUES (2, 'Disciplina Tipo', false);
INSERT INTO lo_table_item VALUES (4, 2, 'grad', 'Graduação');
INSERT INTO lo_table_item VALUES (5, 2, 'pgrad', 'Pós Graduação');

SELECT pg_catalog.setval('lo_table_lta_clta_seq', 2, true);
SELECT pg_catalog.setval('lo_table_item_lti_clti_seq', 5, true);




-- 2016/11/07

INSERT INTO lo_table VALUES (3, 'Semestre Status', false);
INSERT INTO lo_table_item VALUES (6, 3, 'etapa1', 'Concessão Créditos, Organizar LO');
INSERT INTO lo_table_item VALUES (7, 3, 'etapa2', 'Seleção Disciplinas Preferíveis');

INSERT INTO lo_table VALUES (4, 'Secretaria de Graduação', false);
INSERT INTO lo_table VALUES (5, 'Secretaria de Pós-Graduação', false);

INSERT INTO lo_table_item VALUES (8, 4, '8', 'Administração');
INSERT INTO lo_table_item VALUES (9, 4, '9', 'Orientação');
INSERT INTO lo_table_item VALUES (10, 5, '10', 'Aulas');
INSERT INTO lo_table_item VALUES (11, 5, '11', 'Orientação');
INSERT INTO lo_table_item VALUES (12, 5, '12', 'Pesquisa');

SELECT pg_catalog.setval('lo_table_lta_clta_seq', 5, true);
SELECT pg_catalog.setval('lo_table_item_lti_clti_seq', 12, true);




-- 2016/11/08

CREATE TABLE lo_activities (
  lac_clac    SERIAL NOT NULL,
  lac_grou    CHARACTER VARYING(20),
  lac_desc    CHARACTER VARYING(100),
  lac_cred    INTEGER,
  lac_stat    CHARACTER VARYING(20) DEFAULT 'active'::CHARACTER VARYING,
  lac_maxi    INTEGER,
  PRIMARY KEY (lac_clac));

CREATE TABLE lo_granted_credits (
  lgc_clgc    SERIAL NOT NULL,
  lgc_coduser INTEGER NOT NULL,
  lgc_clac    INTEGER NOT NULL,
  lgc_year    INTEGER,
  lgc_seme    INTEGER,
  lgc_cred    INTEGER,
  lgc_stat    CHARACTER VARYING(20),
  PRIMARY KEY (lgc_clgc),
  FOREIGN KEY (lgc_coduser)
    REFERENCES users (coduser),
  FOREIGN KEY (lgc_clac)
    REFERENCES lo_activities (lac_clac));

INSERT INTO lo_activities VALUES (1, '10', 'Aulas Pós-Graduação', NULL, 'active', NULL);
INSERT INTO lo_activities VALUES (2, '11', 'Alunos de Mestrado', NULL, 'active', NULL);
INSERT INTO lo_activities VALUES (3, '11', 'Alunos de Doutorado', NULL, 'active', NULL);

SELECT pg_catalog.setval('lo_activities_lac_clac_seq', 3, true);




-- 2017/04/02

CREATE TABLE lo_offer_list_magisterial (
  lom_clom    SERIAL NOT NULL,
  lom_cdis    INTEGER NOT NULL,
  lom_coduser INTEGER,
  lom_clas    CHARACTER VARYING(40),
  lom_sche    CHARACTER VARYING(40),
  lom_peri    CHARACTER VARYING(20),
  lom_year    INTEGER,
  lom_seme    INTEGER,
  lom_type    CHARACTER VARYING(20),
  PRIMARY KEY (lom_clom),
  FOREIGN KEY (lom_cdis)
    REFERENCES disciplinas_mat (codigo),
  FOREIGN KEY (lom_coduser)
    REFERENCES users (coduser));




-- 2017/07/10

ALTER TABLE lo_preferred_disciplines_graduation
ADD COLUMN pdg_peri character varying(20);




-- 2017/08/24

ALTER TABLE oferta_disciplinas_magistral
  ADD COLUMN id serial;
ALTER TABLE oferta_disciplinas_magistral
  ADD PRIMARY KEY (id);

ALTER TABLE oferta_grupos_magistral_teoria
  ADD COLUMN id serial;
ALTER TABLE oferta_grupos_magistral_teoria
  ADD PRIMARY KEY (id);

ALTER TABLE oferta_grupos_magistral_teoria
  ALTER COLUMN turmas TYPE character varying(2);




-- 2017/09/18
-- Criação dos módulos no SI

ALTER TABLE functions
ALTER COLUMN funcurl TYPE character varying(100);

INSERT INTO module (idmodule, name, url, descr) VALUES (107, 'Lista de Oferta', '../modules/lista_oferta/', 'Criação da LO de graduação');
INSERT INTO module (idmodule, name, url, descr) VALUES (108, 'Concessão de Carga Graduação', '../modules/lista_oferta/module/graduation/', 'Concessão de créditos graduação');
INSERT INTO module (idmodule, name, url, descr) VALUES (109, 'Concessão de Carga Pós', '../modules/lista_oferta/module/post/', 'Concessão de créditos pós graduação');

SELECT pg_catalog.setval('module_idmodule_seq', 109, true);

INSERT INTO functions (idmodule, funcname, funcurl) VALUES (107, 'Atividades', '../modules/lista_oferta/maintain_activities.php');
INSERT INTO functions (idmodule, funcname, funcurl) VALUES (108, 'Concessão de Carga', '../modules/lista_oferta/module/graduation/graduation_granted_credits.php');
INSERT INTO functions (idmodule, funcname, funcurl) VALUES (109, 'Concessão de Carga', '../modules/lista_oferta/module/post/post_granted_credits.php');

INSERT INTO permission (login, idmodule, permission) SELECT login, 107 AS idmodule, 0 AS permission FROM admin;
INSERT INTO permission (login, idmodule, permission) SELECT login, 108 AS idmodule, 0 AS permission FROM admin;
INSERT INTO permission (login, idmodule, permission) SELECT login, 109 AS idmodule, 0 AS permission FROM admin;



-- 2017/10/02

ALTER TABLE lo_granted_credits
  ALTER COLUMN lgc_cred TYPE real;

ALTER TABLE oferta_abertura_tela_lo
  ADD COLUMN carga_media real;

INSERT INTO functions (idmodule, funcname, funcurl) VALUES (107, 'Semestre', '../modules/lista_oferta/maintain_semester.php');
INSERT INTO functions (idmodule, funcname, funcurl) VALUES (107, 'Turmas', '../modules/lista_oferta/maintain_classes.php');
INSERT INTO functions (idmodule, funcname, funcurl) VALUES (107, 'Lista de Oferta', '../modules/lista_oferta/offer_list.php');
INSERT INTO functions (idmodule, funcname, funcurl) VALUES (107, 'Disciplinas', '../modules/lista_oferta/maintain_course.php');




-- 2017/10/10

ALTER TABLE lo_granted_credits
  ADD COLUMN lgc_extr character varying(100);