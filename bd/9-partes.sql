CREATE TABLE public.partes
(
    id serial NOT NULL,
    autor integer NOT NULL,
    autor_adv integer NOT NULL,
    reu integer NOT NULL,
    reu_adv integer NOT NULL,
    PRIMARY KEY (id),
    CONSTRAINT autor_fk FOREIGN KEY (autor)
        REFERENCES public.pessoa (id) MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE NO ACTION
        NOT VALID,
    CONSTRAINT autor_adv_fk FOREIGN KEY (autor_adv)
        REFERENCES public.defensor (id) MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE NO ACTION
        NOT VALID,
    CONSTRAINT reu FOREIGN KEY (reu)
        REFERENCES public.pessoa (id) MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE NO ACTION
        NOT VALID,
    CONSTRAINT reu_adv_fk FOREIGN KEY (reu_adv)
        REFERENCES public.defensor (id) MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE NO ACTION
        NOT VALID
)
WITH (
    OIDS = FALSE
);

ALTER TABLE public.partes
    OWNER to tj;

ALTER TABLE public.partes DROP CONSTRAINT autor_fk;

ALTER TABLE public.partes DROP CONSTRAINT reu;

ALTER TABLE public.partes DROP CONSTRAINT reu_adv_fk;

ALTER TABLE public.partes DROP CONSTRAINT autor_adv_fk;
