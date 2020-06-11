CREATE TABLE public.processo
(
    id serial NOT NULL,
    numero character varying(20) NOT NULL,
    juiz integer NOT NULL,
    orgao integer NOT NULL,
    assunto character varying(255) NOT NULL,
    distribuicao date NOT NULL,
    partes integer NOT NULL,
    valor double precision,
    fatos character varying(255) NOT NULL,
    pedidos character varying(255) NOT NULL,
    PRIMARY KEY (id),
    CONSTRAINT numero_unique UNIQUE (numero),
    CONSTRAINT juiz_fk FOREIGN KEY (juiz)
        REFERENCES public.magistrado (id) MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE NO ACTION
        NOT VALID,
    CONSTRAINT orgao_fk FOREIGN KEY (orgao)
        REFERENCES public.orgao (id) MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE NO ACTION
        NOT VALID,
    CONSTRAINT partes_fk FOREIGN KEY (partes)
        REFERENCES public.partes (id) MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE NO ACTION
        NOT VALID
)
WITH (
    OIDS = FALSE
);

ALTER TABLE public.processo
    OWNER to tj;
