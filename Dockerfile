#Primer Stage Build (Alpine)
FROM composer:latest AS vendor

WORKDIR /app

RUN apk add --no-cache icu-dev \
    icu-data-full \
    && docker-php-ext-install intl

COPY composer.json composer.lock ./

RUN composer install --optimize-autoloader --no-scripts

#Segundo Stage Build (Debian)
FROM node:alpine AS node-modules

WORKDIR /app

# Copiar vendor DE Composer primero
COPY --from=vendor /app/vendor ./vendor

COPY package.json package-lock.json vite.config.js ./

COPY resources ./resources/
COPY public ./public/

RUN npm ci --only=production && npm run build

#Final Stage Build

FROM php:8.4-fpm-alpine

WORKDIR /var/www/html

#Copiar el binario de Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

#Copiar vendor desde Composer del build
COPY --from=vendor /app/vendor ./vendor

# Copiar assets compilados desde node-builder
COPY --from=node-modules /app/public/build ./public/build/

# Copiar código de la aplicación
COPY . .

#Dependencias del Sistema...
RUN apk add --no-cache \
    git \
    curl \
    zip \
    unzip \
    libpng-dev \
    oniguruma-dev \
    libxml2-dev \
    libpq-dev \
    icu-dev \
    postgresql-dev \
    libzip-dev \
    freetype-dev \
    postgresql-client \
    postgresql-dev \
    && docker-php-ext-install \
    pdo \
    pdo_pgsql \
    pgsql \
    bcmath \
    pcntl \
    mbstring \
    gd \
    zip \
    intl

RUN composer dump-autoload --optimize \
    && php artisan package:discover --ansi \
    && php artisan config:cache \
    && php artisan route:cache \
    && php artisan view:cache

# Limpiar
RUN rm /usr/bin/composer

# Puerto de exposición
EXPOSE 9000

CMD ["php-fpm"]



