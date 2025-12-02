FROM php:8.2-fpm

# Instalar dependencias del sistema
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    nodejs \
    npm

# Limpiar cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Instalar extensiones de PHP
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Obtener Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Establecer directorio de trabajo
WORKDIR /var/www

# Copiar archivos del proyecto
COPY . .

# Instalar dependencias de PHP
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Dar permisos
RUN chown -R www-data:www-data /var/www
RUN chmod -R 775 /var/www/storage /var/www/bootstrap/cache

# Exponer puerto
EXPOSE 8000

# Comando de inicio
CMD php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=8000