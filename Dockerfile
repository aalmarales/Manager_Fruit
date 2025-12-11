FROM php:8.4-apache

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

# Configuraciones de Apache
RUN a2enmod rewrite headers

#Configuraciones... 
WORKDIR /var/www/html

COPY composer.json composer.lock ./
COPY package-lock.json package.json vite.config.js ./

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN composer install --no-dev --optimize-autoloader

RUN npm install

COPY . .

# Permisos
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage \
    && chmod -R 755 /var/www/html/bootstrap/cache

# Puerto de exposición
EXPOSE 80

CMD ["apache2-foreground"]



