

ALTER TABLE prestaciones.prestaciones_doi_pagadas OWNER TO postgres;

--
-- Name: prestaciones_doi_pagadas_id_seq; Type: SEQUENCE; Schema: prestaciones; Owner: postgres
--

CREATE SEQUENCE prestaciones.prestaciones_doi_pagadas_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE prestaciones.prestaciones_doi_pagadas_id_seq OWNER TO postgres;

--
-- Name: prestaciones_doi_pagadas_id_seq; Type: SEQUENCE OWNED BY; Schema: prestaciones; Owner: postgres
--

ALTER SEQUENCE prestaciones.prestaciones_doi_pagadas_id_seq OWNED BY prestaciones.prestaciones_doi_pagadas.id;


--
-- Name: prestaciones_doi_pagadas id; Type: DEFAULT; Schema: prestaciones; Owner: postgres
--

ALTER TABLE ONLY prestaciones.prestaciones_doi_pagadas ALTER COLUMN id SET DEFAULT nextval('prestaciones.prestaciones_doi_pagadas_id_seq'::regclass);


--
-- Name: prestaciones_doi_pagadas prestaciones_doi_pagadas_pkey; Type: CONSTRAINT; Schema: prestaciones; Owner: postgres
--

ALTER TABLE ONLY prestaciones.prestaciones_doi_pagadas
    ADD CONSTRAINT prestaciones_doi_pagadas_pkey PRIMARY KEY (id);


--
-- Name: prestaciones_doi_pagadas prestaciones_prestaciones_doi_pagadas_beneficiario_clase_docume; Type: FK CONSTRAINT; Schema: prestaciones; Owner: postgres
--

ALTER TABLE ONLY prestaciones.prestaciones_doi_pagadas
    ADD CONSTRAINT prestaciones_prestaciones_doi_pagadas_beneficiario_clase_docume FOREIGN KEY (beneficiario_clase_documento) REFERENCES sistema.clases_documento(clase_documento);


--
-- Name: prestaciones_doi_pagadas prestaciones_prestaciones_doi_pagadas_beneficiario_sexo_foreign; Type: FK CONSTRAINT; Schema: prestaciones; Owner: postgres
--

ALTER TABLE ONLY prestaciones.prestaciones_doi_pagadas
    ADD CONSTRAINT prestaciones_prestaciones_doi_pagadas_beneficiario_sexo_foreign FOREIGN KEY (beneficiario_sexo) REFERENCES sistema.sexos(sigla);


--
-- Name: prestaciones_doi_pagadas prestaciones_prestaciones_doi_pagadas_beneficiario_tipo_documen; Type: FK CONSTRAINT; Schema: prestaciones; Owner: postgres
--

ALTER TABLE ONLY prestaciones.prestaciones_doi_pagadas
    ADD CONSTRAINT prestaciones_prestaciones_doi_pagadas_beneficiario_tipo_documen FOREIGN KEY (beneficiario_tipo_documento) REFERENCES sistema.tipo_documento(tipo_documento);


--
-- Name: prestaciones_doi_pagadas prestaciones_prestaciones_doi_pagadas_cuie_foreign; Type: FK CONSTRAINT; Schema: prestaciones; Owner: postgres
--

ALTER TABLE ONLY prestaciones.prestaciones_doi_pagadas
    ADD CONSTRAINT prestaciones_prestaciones_doi_pagadas_cuie_foreign FOREIGN KEY (cuie) REFERENCES efectores.efectores(cuie);


--
-- Name: prestaciones_doi_pagadas prestaciones_prestaciones_doi_pagadas_id_provincia_foreign; Type: FK CONSTRAINT; Schema: prestaciones; Owner: postgres
--

ALTER TABLE ONLY prestaciones.prestaciones_doi_pagadas
    ADD CONSTRAINT prestaciones_prestaciones_doi_pagadas_id_provincia_foreign FOREIGN KEY (id_provincia) REFERENCES geo.provincias(id_provincia);


--
-- Name: prestaciones_doi_pagadas prestaciones_prestaciones_doi_pagadas_prestacion_codigo_foreign; Type: FK CONSTRAINT; Schema: prestaciones; Owner: postgres
--

ALTER TABLE ONLY prestaciones.prestaciones_doi_pagadas
    ADD CONSTRAINT prestaciones_prestaciones_doi_pagadas_prestacion_codigo_foreign FOREIGN KEY (prestacion_codigo) REFERENCES pss.codigos(codigo_prestacion);


--
-- PostgreSQL database dump complete
--

