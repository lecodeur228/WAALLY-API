# Utilisation de PHP 8.2 avec FPM
FROM php:8.2-fpm

# Arguments pour la configuration d'environnement
ARG ENV=production

# Installation des dépendances système
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libpq-dev \
    nodejs \
    npm

# Installer les extensions PHP nécessaires
RUN docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd

# Installer Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Définir le répertoire de travail
WORKDIR /var/app/prod/wally-app

# Copier les fichiers du projet
COPY . /var/app/prod/wally-app/

# Installation des dépendances Composer
RUN composer install --no-dev --optimize-autoloader

# Installation des dépendances NPM (si nécessaire)
RUN npm install && npm run build

# Copier le fichier .env.example pour l'environnement approprié
COPY ./env.example .env

# Générer la clé Laravel
RUN php artisan key:generate

# Configuration des permissions
RUN chown -R www-data:www-data //var/app/prod/wally-app \
    && chmod -R 755 /var/app/prod/wally-app/public/storage

# Optimiser pour la production si nécessaire
RUN php artisan config:cache && \
    php artisan route:cache && \
    php artisan view:cache

EXPOSE 9000

CMD ["php-fpm"]
