-- -*- mode: sql; sql-product: postgres; -*-

CREATE TABLE public.wwff (
    id integer NOT NULL,
    ts timestamp without time zone NOT NULL,
    park text NOT NULL,
    local text NOT NULL,
    remote text NOT NULL,
    frequency numeric NOT NULL,
    notes text
);

CREATE SEQUENCE public.wwff_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;

CREATE UNIQUE INDEX wwff_ts_park_local_remote_frequency_idx ON public.wwff USING btree (ts, park, local, remote, frequency);
