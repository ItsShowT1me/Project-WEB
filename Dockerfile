FROM php:8.2-apache

# Copy code to Apache web root
COPY . /var/www/html/

# Expose port
EXPOSE 80

RUN apt-get update && apt-get install -y libpq-dev \
    && docker-php-ext-install pgsql
