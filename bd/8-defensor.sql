CREATE TABLE public.defensor
(
    id serial NOT NULL,
    pessoa integer NOT NULL,
    oab character varying(50) NOT NULL,
    PRIMARY KEY (id),
    CONSTRAINT pessoa_fk FOREIGN KEY (pessoa)
        REFERENCES public.pessoa (id) MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE NO ACTION
        NOT VALID
)
WITH (
    OIDS = FALSE
);

ALTER TABLE public.defensor
    OWNER to tj;

ALTER TABLE public.defensor DROP CONSTRAINT pessoa_fk;
