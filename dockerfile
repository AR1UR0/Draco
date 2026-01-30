# --------------------------------------------------
# BASE IMAGE
# --------------------------------------------------
FROM php:8.2-apache

# --------------------------------------------------
# VARIABLES DE ENTORNO
# --------------------------------------------------
# Apuntamos a la subcarpeta DracoLaravel/public según tu estructura
ENV APACHE_DOCUMENT_ROOT=/var/www/html/DracoLaravel/public

# --------------------------------------------------
# DEPENDENCIAS DEL SISTEMA
# --------------------------------------------------
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    openssl \
    && docker-php-ext-install pdo pdo_mysql zip gd

# Limpieza de caché de apt para reducir tamaño de imagen
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# --------------------------------------------------
# CONFIGURACIÓN DE APACHE
# --------------------------------------------------
RUN a2enmod rewrite ssl headers

# Copiamos tus archivos de configuración específicos
COPY apache/laravel.conf /etc/apache2/sites-available/000-default.conf
COPY apache/ssl.conf /etc/apache2/sites-available/default-ssl.conf

# Copiamos los certificados SSL a las rutas estándar de Debian/Ubuntu
COPY ssl/server.crt /etc/ssl/certs/server.crt
COPY ssl/server.key /etc/ssl/private/server.key

# Habilitamos los sitios configurados
RUN a2ensite 000-default.conf default-ssl.conf

# --------------------------------------------------
# DESPLIEGUE DEL CÓDIGO (Regla 4a: Clonar desde GitHub)
# --------------------------------------------------
WORKDIR /var/www/html
RUN git clone https://github.com/AR1UR0/Draco .

# --------------------------------------------------
# DEPENDENCIAS DE PHP (Composer)
# --------------------------------------------------
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Entramos en la carpeta del proyecto Laravel para instalar dependencias
WORKDIR /var/www/html/DracoLaravel
RUN composer install --no-dev --optimize-autoloader

# --------------------------------------------------
# PERMISOS (Regla de escritura para Laravel)
# --------------------------------------------------
RUN chown -R www-data:www-data /var/www/html/DracoLaravel/storage /var/www/html/DracoLaravel/bootstrap/cache \
    && chmod -R 775 /var/www/html/DracoLaravel/storage /var/www/html/DracoLaravel/bootstrap/cache

# --------------------------------------------------
# EXPOSICIÓN DE PUERTOS Y EJECUCIÓN
# --------------------------------------------------
EXPOSE 80 443

CMD ["apache2-foreground"]