FROM php:8.3-apache

# Instalar dependências do sistema
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    curl \
    libzip-dev \
    zip \
    && docker-php-ext-install pdo pdo_mysql zip

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copiar projeto Laravel
COPY . /var/www/html

# Diretório de trabalho
WORKDIR /var/www/html

# Instalar dependências Laravel
RUN composer install --no-dev --optimize-autoloader

# Limpar caches do Laravel
RUN php artisan config:clear || true
RUN php artisan cache:clear || true
RUN php artisan route:clear || true
RUN php artisan view:clear || true

# Permissões Laravel
RUN chown -R www-data:www-data /var/www/html/storage
RUN chown -R www-data:www-data /var/www/html/bootstrap/cache

# Habilitar mod_rewrite do Apache
RUN a2enmod rewrite

# Apontar Apache para /public
RUN sed -i 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/000-default.conf

# Expor porta
EXPOSE 80

# Inicialização do container
CMD php artisan migrate --force && apache2-foreground