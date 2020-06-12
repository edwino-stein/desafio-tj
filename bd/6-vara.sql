CREATE TABLE public.vara
(
    id serial NOT NULL,
    nome character varying(100) NOT NULL,
    comarca character varying(100) NOT NULL,
    endereco integer,
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

ALTER TABLE public.vara
    OWNER to tj;

ALTER TABLE public.vara
    ADD COLUMN ultimo_sorteado integer NOT NULL;

ALTER TABLE public.vara
    ADD COLUMN ultimo_numero_dt date;

ALTER TABLE public.vara
    ADD COLUMN ultimo_numero_seq integer;

ALTER TABLE public.vara
    ALTER COLUMN ultimo_numero_seq SET NOT NULL;

ALTER TABLE public.vara
    ALTER COLUMN ultimo_numero_dt SET NOT NULL;
