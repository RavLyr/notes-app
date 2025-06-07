# 1. Gunakan base image PHP 8.3-FPM-Alpine
FROM php:8.3-fpm-alpine

# 2. Install paket sistem yang diperlukan via apk
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

# 3. Copy Composer dari image resmi
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 4. Set working directory
WORKDIR /var/www

# 5. Copy seluruh source Laravel
COPY . .

# 6. Install dependency PHP (Laravel) via Composer
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# (Opsional) Expose port 9000 jika pakai php-fpm + reverse proxy
EXPOSE 9000
