FROM php:8.3-apache

# Instalar dependências do sistema e extensões PHP para PostgreSQL
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    curl \
    libpq-dev \
    libzip-dev \
    zip \
    && docker-php-ext-install pdo pdo_pgsql pgsql zip

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copiar projeto Laravel para dentro do container
COPY . /var/www/html

# Diretório de trabalho
WORKDIR /var/www/html

# Instalar dependências do Laravel (sem pacotes de desenvolvimento para ser mais rápido)
RUN composer install --no-dev --optimize-autoloader

# Limpar caches para garantir que as novas variáveis de ambiente sejam lidas
RUN php artisan config:clear || true
RUN php artisan cache:clear || true
RUN php artisan route:clear || true
RUN php artisan view:clear || true

# Dar permissão para as pastas de escrita do Laravel
RUN chown -R www-data:www-data /var/www/html/storage
RUN chown -R www-data:www-data /var/www/html/bootstrap/cache

# Habilitar mod_rewrite do Apache (necessário para as rotas do Laravel)
RUN a2enmod rewrite

# Apontar a raiz do servidor Apache para a pasta /public do Laravel
RUN sed -i 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/000-default.conf

# Expor a porta 80 para o Render
EXPOSE 80

# COMANDO FINAL: 
# 1. Roda as migrações (cria as tabelas) usando o banco configurado
# 2. Se as migrações derem certo, inicia o servidor Apache
# Instalar dependências sem rodar scripts que dependem do banco de dados
RUN composer install --no-dev --optimize-autoloader --no-scripts