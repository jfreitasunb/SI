CREATE TABLE public.oferta_horarios_rodizio_noturno_creditos (
    id integer NOT NULL,
    coduser integer,
    semestre integer,
    ano integer,
    credito_noturno integer,
    disciplina integer,
    turma character varying(20)
);


ALTER TABLE public.oferta_horarios_rodizio_noturno_creditos OWNER TO si;

--
-- Name: oferta_horarios_rodizio_noturno_creditos_id_seq1; Type: SEQUENCE; Schema: public; Owner: si
--

CREATE SEQUENCE public.oferta_horarios_rodizio_noturno_creditos_id_seq1
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.oferta_horarios_rodizio_noturno_creditos_id_seq1 OWNER TO si;

--
-- Name: oferta_horarios_rodizio_noturno_creditos_id_seq1; Type: SEQUENCE OWNED BY; Schema: public; Owner: si
--

ALTER SEQUENCE public.oferta_horarios_rodizio_noturno_creditos_id_seq1 OWNED BY public.oferta_horarios_rodizio_noturno_creditos.id;


--
-- Name: oferta_horarios_rodizio_noturno_creditos id; Type: DEFAULT; Schema: public; Owner: si
--

ALTER TABLE ONLY public.oferta_horarios_rodizio_noturno_creditos ALTER COLUMN id SET DEFAULT nextval('public.oferta_horarios_rodizio_noturno_creditos_id_seq1'::regclass);


--
-- Name: oferta_horarios_rodizio_noturno_creditos oferta_horarios_rodizio_noturno_creditos_pkey; Type: CONSTRAINT; Schema: public; Owner: si
--

ALTER TABLE ONLY public.oferta_horarios_rodizio_noturno_creditos
    ADD CONSTRAINT oferta_horarios_rodizio_noturno_creditos_pkey PRIMARY KEY (id);


--
-- PostgreSQL database dump complete
--

