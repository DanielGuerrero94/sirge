CREATE TABLE diccionarios (
    padron integer NOT NULL,
    orden integer NOT NULL,
    campo character varying(255),
    tipo character varying(255),
    obligatorio character(2),
    descripcion text,
    ejemplo character varying(255)
);

ALTER TABLE diccionarios OWNER TO postgres;
ALTER TABLE ONLY diccionarios
    ADD CONSTRAINT diccionarios_pkey PRIMARY KEY (padron, orden);
