FROM node:18-bullseye-slim

# Instala PHP y extensiones necesarias para Laravel
RUN apt-get update && apt-get install -y \
    php php-cli php-mbstring php-mysql php-xml php-curl php-bcmath unzip curl git \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Instala Yarn
RUN npm install -g yarn

# Crea carpeta de trabajo y copia archivos
WORKDIR /var/www
COPY . .

# Instala dependencias y compila assets
RUN composer install --no-interaction --prefer-dist --optimize-autoloader \
    && yarn install \
    && yarn build \
    && php artisan config:cache \
    && php artisan route:cache \
    && php artisan view:cache \
    && php artisan migrate --force

# Comando por defecto al ejecutar el contenedor
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8080"]
