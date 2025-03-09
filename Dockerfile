# Usa la imagen oficial de PHP con Apache
FROM php:8.4-apache

# Establecer ServerName para suprimir advertencias
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Habilitar mod_rewrite
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
    && docker-php-ext-install gd mbstring \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Copiar los archivos del proyecto Laravel
COPY . /var/www/html

# Definir el directorio de trabajo
WORKDIR /var/www/html

# Instalar Composer globalmente
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Solucionar error de propiedad en Git dentro del contenedor
RUN git config --global --add safe.directory /var/www/html

# Asegurar que la carpeta vendor no tenga archivos no comprometidos
RUN rm -rf /var/www/html/vendor

# Asignar permisos correctos a Laravel antes de ejecutar Composer
RUN chown -R www-data:www-data /var/www/html && chmod -R 775 storage bootstrap/cache

# Cambiar a usuario `www-data` y ejecutar Composer sin `sudo`
USER www-data

# Instalar dependencias de Composer sin caché
RUN COMPOSER_MEMORY_LIMIT=-1 composer install --no-dev --optimize-autoloader --prefer-dist --no-cache || (echo "Composer install failed" && exit 1)

# Volver a usuario root para continuar con el setup
USER root

# Exponer el puerto 80
EXPOSE 80

# Comando para iniciar Apache
CMD ["apache2-foreground"]
