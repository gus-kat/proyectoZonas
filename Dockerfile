# Imagen base con PHP, Node, npm y Composer preinstalados
FROM laravelsail/php82-composer

# Instala yarn globalmente
RUN npm install -g yarn

# Instala extensiones necesarias para Laravel
RUN docker-php-ext-install pdo pdo_mysql mbstring

# Copia el código del proyecto
WORKDIR /var/www
COPY . .

# Instala dependencias PHP y JS, compila assets y cachea Laravel
RUN composer install --no-interaction --prefer-dist --optimize-autoloader \
    && yarn install \
    && yarn build \
    && php artisan optimize \
    && php artisan config:cache \
    && php artisan route:cache \
    && php artisan view:cache \
    && php artisan migrate --force

# Comando por defecto al iniciar el contenedor
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8080"]
