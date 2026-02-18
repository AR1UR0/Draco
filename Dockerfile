# --------------------------------------------------
# BASE IMAGE
# --------------------------------------------------
FROM php:8.2-apache

# --------------------------------------------------
# DEPENDENCIAS DEL SISTEMA
# --------------------------------------------------
RUN apt-get update && apt-get install -y \
    git unzip libzip-dev libpng-dev libonig-dev libxml2-dev openssl \
    && docker-php-ext-install pdo pdo_mysql zip gd \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# 1. Habilitar módulos de Apache
RUN a2enmod rewrite ssl headers

# 2. Configuración de archivos (Tu archivo de configuración)
COPY apache/laravel.conf /etc/apache2/sites-available/000-default.confl


RUN a2ensite 000-default.conf

# 3. Certificados SSL
COPY ssl/server.crt /etc/ssl/certs/server.crt
COPY ssl/server.key /etc/ssl/private/server.key

# --------------------------------------------------
# APLICACIÓN (Ajustado a tu estructura DracoLaravel)
# --------------------------------------------------
# 4. Directorio de trabajo: Debe coincidir con tu DocumentRoot de Apache
WORKDIR /var/www/html

# 5. Copiar contenido
# Copiamos lo que hay dentro de la carpeta local DracoLaravel a la carpeta actual del contenedor
RUN git clone https://github.com/AR1UR0/Draco.git
WORKDIR /var/www/html/Draco/DracoLaravel


#COPY ../apache/laravel.conf /etc/apache2/sites-available/000-default.conf
#RUN a2ensite 000-default.conf

# Instalamos Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
RUN composer install --no-dev --optimize-autoloader

# --------------------------------------------------
# PERMISOS (Corregidos para evitar el error "No such file")
# --------------------------------------------------
# 6. Como el WORKDIR es /var/www/html/DracoLaravel, usamos rutas relativas "."
RUN chown -R www-data:www-data /var/www/html/Draco/DracoLaravel \
    && chmod -R 775 ./storage ./bootstrap/cache



EXPOSE 80 443

CMD git fetch && git pull && php artisan migrate && apache2-foreground


