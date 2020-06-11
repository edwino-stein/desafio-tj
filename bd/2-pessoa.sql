CREATE TABLE public.pessoa
(
    id serial NOT NULL,
    cp character varying(14) NOT NULL,
    tipo character varying(10) NOT NULL,
    nome character varying(100) NOT NULL,
    endereco integer NOT NULL,
    nascimento date NOT NULL,
    telefone character varying(11) NOT NULL,
    PRIMARY KEY (id),
    CONSTRAINT cp_unique UNIQUE (cp),
    CONSTRAINT endereco_fk FOREIGN KEY (endereco)
        REFERENCES public.endereco (id) MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE NO ACTION
        NOT VALID
)
WITH (
    OIDS = FALSE
);

ALTER TABLE public.pessoa
    OWNER to tj;
