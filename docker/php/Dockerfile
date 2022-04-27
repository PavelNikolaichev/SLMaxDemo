FROM php:7.4-apache

RUN apt-get update && apt-get install -y curl git zip && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install pdo pdo_mysql
RUN docker-php-ext-enable pdo_mysql

COPY --from=composer /usr/bin/composer /usr/bin/composer

EXPOSE 80