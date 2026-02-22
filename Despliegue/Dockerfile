# --------------------------------------------------
#  @author Thais
#  @version 1.6.0
#  BASE IMAGE
# --------------------------------------------------
FROM php:8.2-apache

# --------------------------------------------------
# SYSTEM DEPENDENCIES
# --------------------------------------------------
RUN apt-get update && apt-get install -y \
    git unzip libzip-dev libpng-dev libonig-dev libxml2-dev openssl \
    && docker-php-ext-install pdo pdo_mysql zip gd \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# 1. Enable Apache modules
RUN a2enmod rewrite ssl headers

# 2. File configuration (Your configuration file)
#COPY apache/laravel.conf /etc/apache2/sites-available/000-default.conf

#RUN a2ensite 000-default.conf

# 3. SSL Certificates
COPY ../ssl/server.crt /etc/ssl/certs/server.crt
COPY ../ssl/server.key /etc/ssl/private/server.key

# --------------------------------------------------
# APPLICATION (Adjusted to your DracoLaravel structure)
# --------------------------------------------------
# 4. Working directory: Must match your Apache DocumentRoot
WORKDIR /var/www/html

# 5. Copy content
# We copy what is inside the local DracoLaravel folder to the current folder of the container
RUN git clone https://github.com/AR1UR0/Draco.git
WORKDIR /var/www/html/Draco/DracoLaravel

RUN cp ../apache/laravel.conf /etc/apache2/sites-available/000-default.conf
RUN a2ensite 000-default.conf

# We install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
RUN composer install --no-dev --optimize-autoloader

# --------------------------------------------------
# PERMISSIONS (Corrected to avoid the "No such file" error)
# --------------------------------------------------
# 6. Since the WORKDIR is /var/www/html/Draco/DracoLaravel, we use relative paths "."
RUN chown -R www-data:www-data /var/www/html/Draco/DracoLaravel \
    && chmod -R 775 ./storage ./bootstrap/cache

EXPOSE 80 443

CMD git fetch && git pull && php artisan migrate && apache2-foreground