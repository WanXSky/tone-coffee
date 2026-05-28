# =========================================
# Stage 1 — Composer Dependencies
# =========================================
FROM composer:2 AS vendor

WORKDIR /app

COPY composer.json composer.lock ./

RUN composer install \
    --no-dev \
    --prefer-dist \
    --no-interaction \
    --no-scripts

COPY . .

RUN composer dump-autoload --optimize

# =========================================
# Stage 2 — Frontend Build
# =========================================
FROM node:20 AS frontend

WORKDIR /app

COPY package*.json ./

RUN npm install

COPY . .

RUN npm run build

# =========================================
# Stage 3 — Runtime
# =========================================
FROM dunglas/frankenphp:latest

WORKDIR /app

# Install PHP extensions
RUN install-php-extensions \
    pdo_mysql \
    pcntl \
    mbstring \
    intl \
    zip \
    bcmath \
    opcache

# Copy application
COPY . .

# Copy vendor
COPY --from=vendor /app/vendor ./vendor

# Copy built frontend assets
COPY --from=frontend /app/public/build ./public/build

# Permissions
RUN chown -R www-data:www-data storage bootstrap/cache

EXPOSE 8000


CMD ["php", "-S", "0.0.0.0:8000", "-t", "public"]
