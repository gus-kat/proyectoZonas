# Usa una imagen base oficial con PHP, Composer, Node
FROM php:8.2-fpm

# Instala dependencias del sistema
RUN apt-get update && apt-get install -y \
    curl \
    git \
    unzip \
    zip \
    nodejs \
    npm \
    && npm install -g yarn \
    && docker-php-ext-install pdo pdo_mysql mbstring

# Instala Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copia el código del proyecto
COPY . /var/www
WORKDIR /var/www

# Instala dependencias de Laravel
RUN composer install \
    && yarn \
    && yarn prod \
    && php artisan optimize \
    && php artisan config:cache \
    && php artisan route:cache \
    && php artisan view:cache \
    && php artisan migrate --force

CMD ["php-fpm"]
