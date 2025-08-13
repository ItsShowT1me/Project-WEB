FROM php:8.2-apache
COPY . /var/www/html/
EXPOSE 80
CMD ["apache2-foreground"]

COPY composer.json /var/www/html/
RUN apt-get update && apt-get install -y unzip
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN cd /var/www/html && composer install
