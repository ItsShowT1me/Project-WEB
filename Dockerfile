FROM php:8.2-apache

COPY . /var/www/html/

EXPOSE 80

RUN apt-get update && apt-get install -y libpq-dev libssl-dev \
    && docker-php-ext-install pgsql
