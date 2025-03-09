# Usa la imagen oficial de PHP con Apache
FROM php:8.4-apache

# Establecer ServerName para evitar advertencias
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Habilitar mod_rewrite para Laravel
RUN a2enmod rewrite

# Establecer DocumentRoot en /public y permitir .htaccess
RUN sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/sites-available/000-default.conf \
    && echo '<Directory /var/www/html/public>' >> /etc/apache2/apache2.conf \
    && echo '    AllowOverride All' >> /etc/apache2/apache2.conf \
    && echo '    Require all granted' >> /etc/apache2/apache2.conf \
    && echo '</Directory>' >> /etc/apache2/apache2.conf

# Instalar dependencias necesarias para Laravel
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    zip \
    unzip \
    git \
    curl \
    libonig-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd mbstring pdo pdo_mysql \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Instalar Composer globalmente
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copiar los archivos del proyecto Laravel
COPY . /var/www/html

# Definir el directorio de trabajo
WORKDIR /var/www/html

# Ajustar permisos de Laravel
RUN chown -R www-data:www-data storage bootstrap/cache && chmod -R 777 storage bootstrap/cache

# Instalar dependencias de Composer sin caché
RUN COMPOSER_MEMORY_LIMIT=-1 composer install --no-dev --optimize-autoloader --prefer-dist --no-cache || (echo "Composer install failed" && exit 1)

# Generar clave de aplicación Laravel
RUN php artisan key:generate

# Configurar Apache para usar el puerto de Railway
RUN sed -i "s/Listen 80/Listen ${PORT}/" /etc/apache2/ports.conf

# Exponer el puerto que Railway asigna dinámicamente
EXPOSE 80

# Comando para iniciar Apache
CMD ["apache2-foreground"]
