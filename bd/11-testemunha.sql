CREATE TABLE public.testemunha
(
    id serial NOT NULL,
    pessoa integer NOT NULL,
    processo integer NOT NULL,
    PRIMARY KEY (id),
    CONSTRAINT pessoa_fk FOREIGN KEY (pessoa)
        REFERENCES public.pessoa_fisica (id) MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE NO ACTION
        NOT VALID,
    CONSTRAINT processo_fk FOREIGN KEY (processo)
        REFERENCES public.processo (id) MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE NO ACTION
        NOT VALID
)
WITH (
    OIDS = FALSE
);

ALTER TABLE public.testemunha
    OWNER to tj;
