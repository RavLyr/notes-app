FROM composer:2.7 as vendor
WORKDIR /app
COPY database/ database/
COPY composer.json composer.lock ./
RUN composer install --no-scripts --no-dev --no-interaction --prefer-dist --optimize-autoloader

FROM node:18-alpine as frontend
RUN npm install -g pnpm
WORKDIR /app
COPY package.json pnpm-lock.yaml ./
RUN pnpm install
COPY . .
RUN pnpm run build

FROM php:8.3-fpm-alpine

WORKDIR /app

RUN apk add --no-cache --virtual .build-deps $PHPIZE_DEPS \
    && apk add --no-cache \
         bash \
        libpng-dev \
        jpeg-dev \      
        freetype-dev \
        oniguruma-dev \ 
        libxml2-dev \
        libzip-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl gd zip xml \
    && apk del .build-deps

COPY --from=vendor /app/vendor /app/vendor
COPY --from=frontend /app/public/build /app/public/build
COPY . /app


RUN php artisan optimize && \
    php artisan config:cache && \
    php artisan route:cache 

RUN chown -R www-data:www-data /app/storage /app/bootstrap/cache

EXPOSE 9000
CMD ["php-fpm"]
