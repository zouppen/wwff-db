-- -*- mode: sql; sql-product: postgres; -*-

CREATE TABLE wwff (
    id serial PRIMARY KEY,
    ts timestamp without time zone NOT NULL,
    park text NOT NULL,
    local text NOT NULL,
    remote text NOT NULL,
    frequency numeric NOT NULL,
    notes text
);

CREATE UNIQUE INDEX ON wwff (ts, park, local, remote, frequency);

CREATE TABLE wwff_park (
    park text PRIMARY KEY,
    info jsonb NOT NULL
);

CREATE TABLE wwff_notify (
    id serial PRIMARY KEY,
    ts timestamp without time zone NOT NULL DEFAULT CURRENT_TIMESTAMP,
    park text NOT NULL,
    instance text NOT NULL
);
