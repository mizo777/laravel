FROM php:8.0-fpm-buster

SHELL ["/bin/bash", "-oeux", "pipefail", "-c"]

# install Composer
ENV COMPOSER_ALLOW_SUPERUSER=1 \
  COMPOSER_HOME=/composer
COPY --from=composer:2.0 /usr/bin/composer /usr/bin/composer

# install Node.js
COPY --from=node:10.22 /usr/local/bin /usr/local/bin
COPY --from=node:10.22 /usr/local/lib /usr/local/lib

# install Packeges
RUN apt-get update && \
  apt-get -y install \
  git unzip libzip-dev libicu-dev libonig-dev vim && \
  apt-get clean && \
  rm -rf /var/lib/apt/lists/* && \
  docker-php-ext-install intl pdo_mysql zip bcmath

# setting PHP
COPY ./php.ini /usr/local/etc/php/php.ini

WORKDIR /work