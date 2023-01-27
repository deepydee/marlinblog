FROM php:8.1-fpm

RUN docker-php-ext-install pdo_mysql opcache

COPY docker/php/php.ini /usr/local/etc/php/php.ini

COPY docker/php/composer-installer.sh /usr/local/bin/composer-installer

RUN apt-get -y update \
    && apt-get -y install --no-install-recommends zip unzip \
    && chmod +x /usr/local/bin/composer-installer \
    && composer-installer \
    && mv composer.phar /usr/local/bin/composer \
    && chmod +x /usr/local/bin/composer \
    && composer --version

WORKDIR /tmp
COPY composer.json composer.lock /tmp/
RUN composer install \
        --no-interaction \
        --no-plugins \
        --no-scripts \
        --prefer-dist \
    && rm -rf composer.json composer.lock auth.json vendor/

RUN usermod -u 1000 www-data
USER www-data

WORKDIR /srv
