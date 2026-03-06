# --- Stage 1: Build Dependencies (Composer) ---
FROM composer:2 AS vendor

WORKDIR /app

# Copie uniquement des fichiers de dépendances pour profiter du cache Docker
COPY backend/composer.json backend/composer.lock ./

# Installation des dépendances (sans dev pour la prod)
RUN composer install \
    --no-dev \
    --no-interaction \
    --prefer-dist \
    --ignore-platform-reqs \
    --optimize-autoloader

# --- Stage 2: Final Production Image ---
FROM php:8.3-fpm

# Optimisation: Installation des dépendances système + nettoyage en une seule couche
RUN apt-get update && apt-get install -y --no-install-recommends \
    libzip-dev \
    libpng-dev \
    libjpeg-dev     libfreetype6-dev \
    zip     unzip     git \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd pdo_mysql zip opcache \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

WORKDIR /var/www/html

# On nettoie avant de copier (pour être sûr)
RUN rm -rf /var/www/html/*

# Copie des vendors depuis le stage de build
COPY --from=vendor /app/ /var/www/html/

# Copie du code source backend
COPY backend/ /var/www/html/

# On s'assure que les permissions sont correctes
RUN ls -la /var/www/html && chown -R www-data:www-data /var/www/html
