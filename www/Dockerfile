FROM php:8.2-fpm

## Install Composer
COPY --from=composer /usr/bin/composer /usr/bin/composer

## Update package information
RUN apt-get update

## Install zip libraries and extension
RUN apt-get install --yes git zlib1g-dev libzip-dev
RUN docker-php-ext-install zip

## Install intl library and extension
RUN apt-get install --yes libicu-dev
RUN docker-php-ext-configure intl
RUN docker-php-ext-install intl

## MySQL PDO support
RUN docker-php-ext-install pdo_mysql

WORKDIR /var/www

COPY commands.sh /scripts/commands.sh
RUN ["chmod", "+x", "/scripts/commands.sh"]
ENTRYPOINT ["/scripts/commands.sh"]
