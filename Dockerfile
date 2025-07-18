# Usa una imagen base con Node (que sí incluye npm)
FROM node:18-bullseye-slim

# Instala PHP + extensiones necesarias + Composer
RUN apt-get update && apt-get install -y \
    php php-cli php-mbstring php-mysql php-xml php-curl php-bcmath unzip curl git \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Instala Yarn
RUN npm install -g yarn

# Establece el directorio de trabajo
WORKDIR /var/www

# Copia todos los archivos del proyecto
COPY . .

# Instala dependencias PHP y JS
RUN composer install --no-interaction --prefer-dist --optimize-autoloader \
    && yarn install \
    && yarn build

# Ejecuta comandos de Laravel
RUN php artisan config:cache \
    && php artisan route:cache \
    && php artisan view:cache \
    && php artisan migrate --force

# Comando por defecto al iniciar el contenedor
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8080"]
