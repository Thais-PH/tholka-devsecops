# --- Stage 1: Build Dependencies ---
FROM composer:2 AS vendor
WORKDIR /app
COPY backend/composer.json backend/composer.lock ./
RUN composer install --no-dev --no-interaction --prefer-dist --ignore-platform-reqs --optimize-autoloader

# --- Stage 2: Final Production Image ---
FROM php:8.3-fpm

# Installation des extensions
RUN apt-get update && apt-get install -y --no-install-recommends \
    libzip-dev libpng-dev libjpeg-dev libfreetype6-dev zip unzip git \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd pdo_mysql zip opcache \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Ajout de Composer dans l'image finale (Optionnel mais pratique)
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# On copie tout le backend (y compris web/)
COPY backend/ /var/www/html/

# On copie les vendors du stage précédent
COPY --from=vendor /app/vendor /var/www/html/vendor

RUN chown -R www-data:www-data /var/www/html