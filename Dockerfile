FROM php:8.2-fpm-alpine

# Install OS deps
RUN apk add --no-cache \
    nginx \
    bash \
    curl \
    supervisor \
    libzip-dev \
    oniguruma-dev \
    zip \
    unzip \
    git \
    icu-dev \
    libxml2-dev \
    && docker-php-ext-install pdo pdo_mysql mbstring zip intl xml

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Create user for Laravel
RUN addgroup -g 1000 www && adduser -u 1000 -G www -s /bin/sh -D www

# Set working dir
WORKDIR /var/www

# Copy source
COPY . /var/www

# Copy nginx config
COPY .docker/nginx.conf /etc/nginx/nginx.conf

# Set permissions
RUN chown -R www:www /var/www

# Laravel optimization
RUN composer install --no-dev --optimize-autoloader && \
    php artisan config:cache && \
    php artisan route:cache && \
    php artisan view:cache

# Supervisor config to run php-fpm & nginx together
COPY .docker/supervisord.conf /etc/supervisord.conf

# Expose port 80
EXPOSE 80

USER www

COPY .docker/entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh
CMD ["/entrypoint.sh"]

