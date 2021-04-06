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

Copy example configuration `cp settings.conf.example settings.conf`
and edit it. If you just want to populate database but don't need to
use notifier, just leave `[filter]` and `[matrix]` sections
unconfigured.

In both data collection and notification tools, configuration file
location defaults to `settings.conf` in the tool directory. You may
override it by passing it as a argument to individual tools.

Try to run the tool once.

```sh
./wwff-populate
```

If it works it's time to make it periodic. Install systemd timer and
service to `/etc/systemd/system` or your user instance, if you have
one. See examples for [service](examples/wwff-db.service) and
[timer](examples/wwff-db.timer) files.

Works with legacy cron, too.

## Notifier

Notifier, `./notifier`, is a separate tool which can be run in the
same systemd service. Just uncomment that line in the example systemd
service file and also remember to set Matrix settings in the
configuration file.

With mautrix-telegram, mautrix-whatsapp and IRC bridging you can get
the bot to notify to wide variety of different chat platforms at once!

Please note on the first run it may spam a lot. Set up proper filter
and run on a test channel first!

## License

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU Lesser General Public License as
published by the Free Software Foundation, either version 3 of the
License, or (at your option) any later version.
