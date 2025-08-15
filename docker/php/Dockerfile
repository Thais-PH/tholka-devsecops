# On part d'une image PHP 8.3-FPM officielle et propre
FROM php:8.3-fpm

# On définit le répertoire de travail
WORKDIR /var/www/html

# On installe les dépendances système nécessaires pour les extensions PHP
RUN apt-get update && apt-get install -y \
    libzip-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    zip \
    unzip \
    git

# On installe les extensions PHP dont Drupal a besoin
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd \
    && docker-php-ext-install pdo_mysql \
    && docker-php-ext-install zip \
    && docker-php-ext-install opcache

# On installe Composer (le gestionnaire de dépendances de PHP)
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# On s'assure que les permissions seront bonnes pour le futur code
RUN chown -R www-data:www-data /var/www/html