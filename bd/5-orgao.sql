CREATE TABLE public.orgao
(
    id serial NOT NULL,
    nome character varying(100) NOT NULL,
    endereco integer NOT NULL,
    PRIMARY KEY (id),
    CONSTRAINT endereco_fk FOREIGN KEY (endereco)
        REFERENCES public.endereco (id) MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE NO ACTION
        NOT VALID
)
WITH (
    OIDS = FALSE
);

ALTER TABLE public.orgao
    OWNER to tj;
