FROM php:7.1-apache

RUN docker-php-ext-install pdo_mysql

RUN apt-get update && apt-get install -y zlib1g-dev libicu-dev g++ \
    && docker-php-ext-configure intl \
    && docker-php-ext-install intl
RUN a2enmod rewrite

ADD . /var/www
RUN chmod -R 0777 /var/www/storage \
    && chmod -R 0777 /var/www/bootstrap/cache
ADD ./public /var/www/html