FROM composer:2.7 AS composer-base
WORKDIR /app
COPY composer.json composer.lock ./
RUN composer install --no-dev --prefer-dist --no-interaction --no-scripts


FROM node:18-alpine AS frontend
WORKDIR /app
RUN npm install -g pnpm
COPY package.json pnpm-lock.yaml ./
RUN pnpm install
COPY resources resources
COPY vite.config.js tailwind.config.js postcss.config.js ./
RUN pnpm run build

FROM php:8.3-fpm-alpine
WORKDIR /app

RUN apk add --no-cache bash libzip-dev oniguruma-dev libxml2-dev \
    && docker-php-ext-install pdo_mysql mbstring zip xml

COPY . .

COPY --from=composer-base /app/vendor /app/vendor
COPY --from=frontend /app/public/build /app/public/build

RUN mkdir -p storage/framework/views \
    storage/framework/cache \
    storage/framework/sessions \
    bootstrap/cache \
    && chmod -R 777 storage bootstrap/cache

RUN php artisan config:clear && php artisan config:cache && \
    php artisan route:cache && \
    php artisan view:cache

COPY .docker/wait-for-it.sh /usr/local/bin/wait-for-it
RUN chmod +x /usr/local/bin/wait-for-it

EXPOSE 9000
CMD ["bash", "-c", "wait-for-it ${DB_HOST:-db}:${DB_PORT:-3306} -- php artisan migrate --force && php-fpm"]