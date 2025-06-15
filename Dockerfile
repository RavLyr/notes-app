# 1. Install PHP dependencies only
FROM composer:2.7 AS composer-base
WORKDIR /app
COPY composer.json composer.lock ./
RUN composer install --no-dev --prefer-dist --no-interaction --no-scripts

# 2. Build Frontend Assets
FROM node:18-alpine AS frontend
WORKDIR /app
RUN npm install -g pnpm
COPY package.json pnpm-lock.yaml ./
RUN pnpm install
COPY resources resources
COPY vite.config.js tailwind.config.js postcss.config.js ./
RUN pnpm run build

# 3. Final Production Image
FROM php:8.3-fpm-alpine
WORKDIR /app

# Install PHP Extensions
RUN apk add --no-cache bash libzip-dev oniguruma-dev libxml2-dev \
    && docker-php-ext-install pdo_mysql mbstring zip xml

# Copy application code
COPY . .

# Copy vendor dan assets dari stage sebelumnya
COPY --from=composer-base /app/vendor /app/vendor
COPY --from=frontend /app/public/build /app/public/build

RUN php artisan config:cache && php artisan route:cache
RUN chown -R www-data:www-data /app/storage /app/bootstrap/cache

COPY .docker/wait-for-it.sh /usr/local/bin/wait-for-it
RUN chmod +x /usr/local/bin/wait-for-it

EXPOSE 9000
CMD ["bash", "-c", "wait-for-it ${DB_HOST:-db}:${DB_PORT:-3306} -- php artisan migrate --force && php-fpm"]
