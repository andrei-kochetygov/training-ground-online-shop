FROM php:8.2.8-apache

ENV PHP_OPCACHE_VALIDATE_TIMESTAMPS="0" \
    PHP_OPCACHE_MAX_ACCELERATED_FILES="10000" \
    PHP_OPCACHE_MEMORY_CONSUMPTION="192" \
    PHP_OPCACHE_MAX_WASTED_PERCENTAGE="10"

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

COPY ./conf.d/opcache.ini /usr/local/etc/php/conf.d/opcache.ini

RUN apt update -y && apt upgrade -y

RUN apt install git zip unzip -y

RUN chmod +x /usr/local/bin/composer

RUN docker-php-ext-install opcache mysqli pdo pdo_mysql exif

EXPOSE 8000
