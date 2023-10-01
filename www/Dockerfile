FROM php:8.2-fpm

## Install Composer
COPY --from=composer /usr/bin/composer /usr/bin/composer

## Update packages information
RUN apt-get update

## Install packages and extensions
RUN apt-get install -y git zlib1g-dev libzip-dev libicu-dev
RUN docker-php-ext-configure intl
RUN docker-php-ext-install intl zip pdo_mysql

## Install XDebug
RUN pecl install xdebug
RUN docker-php-ext-enable xdebug

WORKDIR /var/www

COPY commands.sh /scripts/commands.sh
RUN ["chmod", "+x", "/scripts/commands.sh"]
ENTRYPOINT ["/scripts/commands.sh"]
