FROM composer:2.7 as vendor
WORKDIR /app
COPY database/ database/
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader

FROM node:18-alpine as frontend

RUN npm install -g pnpm

WORKDIR /app

COPY package.json pnpm-lock.yaml ./

RUN pnpm install

COPY . .

RUN pnpm run build

FROM php:8.3-fpm-alpine

WORKDIR /var/www

RUN apk add --no-cache \
    libpng \
    libjpeg-turbo \
    freetype \
    oniguruma \
    libxml2 \
    libzip \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl gd zip xml

COPY --from=vendor /app/vendor /var/www/vendor
COPY --from=frontend /app/public/build /var/www/public/build
COPY . /var/www

RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

EXPOSE 9000
CMD ["php-fpm"]