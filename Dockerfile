FROM php:7.2-apache

RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"

RUN apt-get update && apt-get -y upgrade && apt-get -y install libc-client-dev libkrb5-dev msmtp && rm -r /var/lib/apt/lists/*
RUN docker-php-ext-configure imap --with-kerberos --with-imap-ssl && docker-php-ext-install imap
RUN docker-php-ext-install mysqli

COPY ./www/. /var/www/html/

COPY ./msmtprc /etc/msmtprc
RUN chown www-data /etc/msmtprc && chmod 600 /etc/msmtprc
RUN sed -i '/sendmail_path/c\sendmail_path = /usr/bin/msmtp -C /etc/msmtprc -a rakbook -t' "$PHP_INI_DIR/php.ini"
