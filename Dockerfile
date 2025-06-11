FROM php:8.3-fpm-alpine

RUN apk update \
    && apk add --no-cache \
       bash \
       build-base \
       libpng-dev \
       libjpeg-turbo-dev \
       freetype-dev \
       oniguruma-dev \
       libxml2-dev \
       libzip-dev \
       zlib-dev \
       zip \
       unzip \
       git \
       curl \
    && docker-php-ext-configure gd \
         --with-freetype=/usr/include/ \
         --with-jpeg=/usr/include/ \
    && docker-php-ext-install \
         pdo_mysql \
         mbstring \
         zip \
         exif \
         pcntl \
         gd \
         xml \
    && apk del build-base \
    && rm -rf /var/cache/apk/*

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

COPY . .

RUN composer install --no-interaction --prefer-dist --optimize-autoloader

EXPOSE 9000
