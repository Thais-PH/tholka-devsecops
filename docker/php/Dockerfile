# --- Stage 1: Build Dependencies (Composer) ---
FROM composer:2 AS vendor
WORKDIR /app
COPY backend/composer.json backend/composer.lock ./
# On installe proprement
RUN composer install --no-dev --no-interaction --prefer-dist --ignore-platform-reqs --optimize-autoloader

# --- Stage 2: Final Production Image ---
FROM php:8.3-fpm

# Installation des extensions (ton code était bon, on garde GD)
RUN apt-get update && apt-get install -y --no-install-recommends \
    libzip-dev libpng-dev libjpeg-dev libfreetype6-dev zip unzip git \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd pdo_mysql zip opcache \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

WORKDIR /var/www/html

# 1. Copier le code source d'abord
COPY backend/ /var/www/html/

# 2. Copier les vendors par-dessus (pour être sûr d'avoir les binaires propres)
COPY --from=vendor /app/vendor /var/www/html/vendor

# 3. S'assurer que les fichiers scaffold (index.php, etc.) sont là si Composer ne les a pas copiés
# (Optionnel si tu les as déjà dans ton Git)

RUN chown -R www-data:www-data /var/www/html