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
WORKDIR /var/www/html

# Copier les fichiers du projet
COPY . /var/www/html/

# Installation des dépendances Composer
RUN if [ "$ENV" = "production" ]; then \
        composer install --no-dev --optimize-autoloader; \
    else \
        composer install; \
    fi

# Installation des dépendances NPM (si nécessaire)
RUN if [ "$ENV" = "production" ]; then \
        npm ci && npm run build; \
    else \
        npm install && npm run dev; \
    fi

# Copier le fichier .env pour l'environnement approprié
RUN if [ "$ENV" = "production" ]; then \
        cp .env.production .env; \
    else \
        cp .env.development .env; \
    fi

# Générer la clé Laravel
RUN php artisan key:generate

# Configuration des permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage

# Optimiser pour la production si nécessaire
RUN if [ "$ENV" = "production" ]; then \
        php artisan config:cache && \
        php artisan route:cache && \
        php artisan view:cache; \
    fi

EXPOSE 9000

CMD ["php-fpm"]
