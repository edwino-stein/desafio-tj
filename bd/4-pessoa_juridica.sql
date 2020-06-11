CREATE TABLE public.pessoa_juridica
(
    fantasia character varying(50) NOT NULL,
    inscrissao character varying(50) NOT NULL
)
    INHERITS (public.pessoa)
WITH (
    OIDS = FALSE
);

ALTER TABLE public.pessoa_juridica
    OWNER to tj;
