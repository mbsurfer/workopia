FROM php:8.3-fpm-alpine

WORKDIR /var/www/html

COPY . .

# Install postgres dependencies
RUN apk add --no-cache postgresql-dev

RUN docker-php-ext-install pdo pdo_mysql pdo_pgsql

RUN addgroup -g 1000 laravel && adduser -G laravel -g laravel -s /bin/sh -D laravel

USER laravel