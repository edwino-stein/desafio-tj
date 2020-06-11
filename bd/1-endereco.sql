CREATE TABLE public.endereco
(
    id serial NOT NULL,
    cep character varying(8) NOT NULL,
    logradouro character varying(255) NOT NULL,
    numero character varying(20) NOT NULL,
    complemento character varying(255),
    bairro character varying(50) NOT NULL,
    cidade character varying(50) NOT NULL,
    estado character varying(50) NOT NULL,
    PRIMARY KEY (id)
)
WITH (
    OIDS = FALSE
);

ALTER TABLE public.endereco
    OWNER to tj;
