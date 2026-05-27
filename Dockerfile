# ========================================
# Stage 1 — Composer Dependencies
# ========================================
FROM composer:2 AS vendor

WORKDIR /app

COPY . .

RUN composer install \
    --no-dev \
    --prefer-dist \
    --no-interaction \
    --optimize-autoloader

# ========================================
# Stage 2 — Vite Frontend Build
# ========================================
FROM node:20-alpine AS frontend

WORKDIR /app

COPY package*.json ./

RUN npm install

COPY . .

RUN npm run build

# ========================================
# Stage 3 — Production Runtime
# ========================================
FROM php:8.3-fpm-alpine

WORKDIR /var/www

# Install runtime packages
RUN apk add --no-cache \
    libzip \
    icu \
    oniguruma \
    fcgi

# Install PHP extensions
RUN apk add --no-cache --virtual .build-deps \
    $PHPIZE_DEPS \
    icu-dev \
    libzip-dev \
    oniguruma-dev \
    && docker-php-ext-install \
        pdo \
        pdo_mysql \
        mbstring \
        intl \
        zip \
        bcmath \
        opcache \
    && apk del .build-deps

# Copy application
COPY . .

# Copy composer vendor
COPY --from=vendor /app/vendor ./vendor

# Copy built frontend assets
COPY --from=frontend /app/public/build ./public/build

# Laravel cache optimization
RUN php artisan config:cache && \
    php artisan route:cache && \
    php artisan view:cache

# Permissions
RUN chown -R www-data:www-data \
    storage \
    bootstrap/cache

USER www-data

EXPOSE 9000

CMD ["php-fpm"]
