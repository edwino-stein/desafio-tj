CREATE TABLE public.magistrado
(
    id serial NOT NULL,
    pessoa integer NOT NULL,
    vara integer NOT NULL,
    PRIMARY KEY (id),
    CONSTRAINT pessoa_fk FOREIGN KEY (pessoa)
        REFERENCES public.pessoa_fisica (id) MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE NO ACTION
        NOT VALID,
    CONSTRAINT vara_fk FOREIGN KEY (vara)
        REFERENCES public.vara (id) MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE NO ACTION
        NOT VALID
)
WITH (
    OIDS = FALSE
);

ALTER TABLE public.magistrado
    OWNER to tj;
