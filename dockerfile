# Étape 1 : Construction de l'application avec Composer
FROM composer:2 as build

WORKDIR /app

# Copier les fichiers nécessaires pour l'installation
COPY composer.json composer.lock ./
RUN composer install --no-dev --optimize-autoloader

# Copier le reste du projet
COPY . .

# Étape 2 : Image finale PHP avec FPM
FROM php:8.2-fpm

# Installation des dépendances système nécessaires
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libpq-dev \
 && docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd \
 && apt-get clean && rm -rf /var/lib/apt/lists/*

# Copier Composer depuis l'image Composer officielle
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Définir le répertoire de travail
WORKDIR /var/www

# Copier l'application depuis l'étape build
COPY --from=build /app /var/www

# Configuration des permissions
RUN chown -R www-data:www-data /var/www \
 && chmod -R 755 /var/www/storage

# Port exposé
EXPOSE 9000

# Commande de démarrage
CMD ["php-fpm"]
