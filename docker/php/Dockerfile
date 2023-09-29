FROM php:8.1-fpm

RUN apt-get update
RUN apt-get install -y curl git

RUN docker-php-ext-install dev xdebug pcov bcmath curl gd intl mbstring mysql soap xml xsl zip

WORKDIR /var/www

COPY --from=composer /usr/bin/composer /usr/bin/composer

ENTRYPOINT [ "php-fpm" ]
