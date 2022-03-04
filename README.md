# Rakbook
Rakbook is a website made by studens for students of "mat-inf 2019 (3 years)" from Uniwersyteckie Liceum Ogólnokształcące, mainly as class-mail, because usual solution with account on gmail with same password for everyone was not good enough.

## Features
+ announcements
+ class-mail
+ students on duty
+ quotes from teachers
+ memes
+ homework list
+ Nodzu-soundboard
+ nick colors shop
+ administration panel
+ API

## Instalation
Setup external database and import database from `database.sql`
Build and run the container with correct `msmtprc` file (for sending emails) attached at `etc/msmtprc` owned by `www-data` with permissions `600`
Give administrator rights to first administrator by manually editing relevant database cell and you are good to go!

## Environment variables
| DB_HOST              | database host                                                                    |
|----------------------|----------------------------------------------------------------------------------|
| DB_USER              | database user                                                                    |
| DB_PASS              | database password                                                                |
| DB_DATABASE          | database name                                                                    |
| IMAP_MAILSERVER      | mailserver for [imap_open](https://www.php.net/manual/en/function.imap-open.php) |
| IMAP_MAILLOGIN       | mail login                                                                       |
| IMAP_MAILPASS        | mail password                                                                    |
| IMAP_TRASH_DIRECTORY | mail trash directory                                                             |
| NEW_USER_EMAILS      | comma separated list of emails to notify when new user wants to register         |

## License
This project is developed under Beerware license.
