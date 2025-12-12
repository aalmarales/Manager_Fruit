FROM php:8.4-apache

WORKDIR /var/www/html

#Dependencias del Sistema...

RUN apt-get update && apt-get install -y \
    git \
    curl \
    zip \
    unzip \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libpq-dev \
    libicu-dev \
    libwebp-dev \
    libzip-dev \
    postgresql-client \
    && rm -rf /var/lib/apt/lists/*

#Dependencias de Docker...
RUN docker-php-ext-install \
    pdo \
    pdo_pgsql \
    pgsql \
    bcmath \
    mbstring \
    gd \
    zip \
    intl

#Dependencias de Nodejs...
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs \
    && rm -rf /var/lib/apt/lists/*

COPY package-lock.json package.json vite.config.js ./

RUN npm install

# Configuraciones de Apache
RUN a2enmod rewrite headers

# Configuraciones de Laravel
RUN mkdir -p bootstrap/cache \
    storage/framework/cache \
    storage/framework/sessions \
    storage/framework/views \
    storage/logs \
    && chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage /var/www/html/bootstrap/cache


COPY composer.json composer.lock ./
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN composer install --no-dev --optimize-autoloader --no-scripts

COPY . .

# Puerto de exposición
EXPOSE 80

CMD ["apache2-foreground"]



