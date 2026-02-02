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
# DEPENDENCIAS DE PHP (Composer)
# --------------------------------------------------
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# --------------------------------------------------
# SCRIPT DE ENTRADA (Actualización en cada inicio)
# --------------------------------------------------
# Copiamos el script que hará el git pull al arrancar
COPY entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

# --------------------------------------------------
# PERMISOS INICIALES Y DIRECTORIO
# --------------------------------------------------
WORKDIR /var/www/html

# --------------------------------------------------
# EXPOSICIÓN DE PUERTOS Y EJECUCIÓN
# --------------------------------------------------
EXPOSE 80 443

# Usamos el script como punto de entrada
ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]