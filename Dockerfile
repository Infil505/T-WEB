# Usa la imagen oficial de PHP con Apache
FROM php:8.4-apache

# Establecer ServerName para suprimir la advertencia
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Verificar si mod_rewrite está habilitado
RUN a2enmod rewrite && \
    if apache2ctl -M | grep -q 'rewrite_module'; then \
        echo "mod_rewrite is enabled"; \
    else \
        echo "mod_rewrite is not enabled"; \
        exit 1; \
    fi

# Establecer DocumentRoot en /public
RUN sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/sites-available/000-default.conf

# Instalar dependencias necesarias para Laravel (sin MySQL)
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
    && echo "Installed required PHP extensions"

# Copiar los archivos del proyecto Laravel (incluido el archivo .env y composer.json)
COPY . /var/www/html

# Verificar que el archivo `composer.json` exista
RUN if [ ! -f /var/www/html/composer.json ]; then \
        echo "composer.json is missing"; \
        exit 1; \
    else \
        echo "composer.json exists"; \
    fi

# Definir el directorio de trabajo
WORKDIR /var/www/html

# Instalar Composer globalmente
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Verificar que Composer se haya instalado correctamente
RUN ls -l /usr/local/bin/composer  # Verificar que Composer está en la ubicación correcta
RUN composer --version  # Verificar que Composer está accesible

# Configurar Git para permitir acceso al repositorio
RUN git config --global --add safe.directory /var/www/html

# Limpiar el directorio vendor para evitar problemas con archivos no comprometidos
RUN rm -rf /var/www/html/vendor

# Instalar las dependencias de Composer sin caché
RUN COMPOSER_MEMORY_LIMIT=-1 composer install --no-dev --optimize-autoloader --prefer-dist --no-cache \
    && echo "Composer dependencies installed successfully"

# Asegurarse de que Apache sirva desde la carpeta 'public' y que .htaccess esté funcionando
RUN if [ ! -f /var/www/html/public/.htaccess ]; then \
        echo ".htaccess is missing"; \
        exit 1; \
    else \
        echo ".htaccess file exists"; \
    fi

# Asignar permisos correctos a Laravel
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 storage bootstrap/cache \
    && echo "Permissions set for storage and bootstrap/cache"

# Verificar las rutas en `web.php` y registrar en los logs si hay problemas
RUN if [ ! -f /var/www/html/routes/web.php ]; then \
        echo "Routes file web.php is missing.\n" >> /var/www/html/storage/logs/error.log; \
        echo "Routes file web.php is missing" && exit 1; \
    else \
        echo "Routes file web.php exists"; \
    fi

# Exponer el puerto 80
EXPOSE 80

# Comando para iniciar Apache y manejar el proceso
CMD ["sh", "-c", "apache2-foreground || echo 'Apache failed to start' >> /var/www/html/storage/logs/error.log && exit 1"]
