# WWFF cluster database

Reads radio amateur [World Wide Flora & Fauna](https://wwff.co/)
cluster data from https://www.cqgma.org/wwff/ww1011.php and writes to
a PostgreSQL database.

Written by OH64K / Zouppen.

## Purpose

The database is used for notifications of nearby activity to Matrix
chat channel for radio amateurs.

The tool stores only the unique data, so it's suitable for periodic
running by a timer.

## Installation

Create database from the schema:

```sh
psql -f schema.sql "dbname=MY_DATABASE_NAME"
```

Try to run the tool once:

```sh
./wwff-populate "dbname=MY_DATABASE_NAME"
```

If it works it's time to make it periodic. Install systemd timer and
service to `/etc/systemd/system` or your user instance, if you have
one. See examples for [service](examples/wwff-db.service) and
[timer](examples/wwff-db.timer) files.

Works with legacy cron, too.

## License

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU Lesser General Public License as
published by the Free Software Foundation, either version 3 of the
License, or (at your option) any later version.
