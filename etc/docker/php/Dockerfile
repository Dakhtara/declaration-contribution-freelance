FROM php:8.0.12-fpm-alpine

RUN apk --update --no-cache add git
RUN set -ex \
  && apk --no-cache add \
    postgresql-dev
RUN apk add --update make

RUN docker-php-ext-install pgsql pdo pdo_pgsql

RUN apk add icu-dev && \
    docker-php-ext-configure  intl && \
    docker-php-ext-install  intl

COPY --from=composer /usr/bin/composer /usr/bin/composer
WORKDIR /var/www
CMD composer install ; wait-for-it database:5432 -- bin/console doctrine:migrations:migrate ;  php-fpm
EXPOSE 9000
