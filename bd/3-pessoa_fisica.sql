CREATE TABLE public.pessoa_fisica
(
    sexo character varying(20) NOT NULL,
    rg character varying(20) NOT NULL,
    nacionalidade character varying(50) NOT NULL,
    estado_civil character varying(50) NOT NULL,
    profissao character varying(50) NOT NULL
)
    INHERITS (public.pessoa)
WITH (
    OIDS = FALSE
);

ALTER TABLE public.pessoa_fisica
    OWNER to tj;
