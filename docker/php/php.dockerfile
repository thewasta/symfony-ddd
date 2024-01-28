FROM php:8.1-fpm

RUN apt update \
    && apt install -y zlib1g-dev g++ git libicu-dev zip libzip-dev zip \
    && docker-php-ext-install intl opcache pdo pdo_mysql \
    && pecl install apcu \
    && docker-php-ext-enable apcu \
    && docker-php-ext-configure zip \
    && docker-php-ext-install zip

RUN set -eux; \
    pecl install xdebug; \
    pecl clear-cache; \
    docker-php-ext-enable xdebug

#PHP_INI_DIR = /usr/local/etc/php/conf.d
COPY /docker/php/conf.d/php.dev.ini $PHP_INI_DIR/php.ini
WORKDIR /var/www/html

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

COPY composer.json composer.lock symfony.lock ./

COPY bin bin/
COPY config config/
COPY public public/
COPY src src/
COPY .env ./

RUN chmod +x bin/console; sync

RUN set -eux; \
    composer install --no-scripts --no-progress --prefer-dist --no-interaction --optimize-autoloader; \
    composer clear-cache
