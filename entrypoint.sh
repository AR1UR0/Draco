#!/bin/bash
set -e

# 1. Clonar si la carpeta está vacía o actualizar si ya existe
if [ ! -d "/var/www/html/.git" ]; then
    echo "Clonando repositorio por primera vez..."
    git clone https://github.com/AR1UR0/Draco /var/www/html
else
    echo "Actualizando repositorio..."
    cd /var/www/html && git pull origin main
fi

# 2. Instalar dependencias de Laravel
cd /var/www/html/DracoLaravel
composer install --no-dev --optimize-autoloader

# 3. Corregir permisos de carpetas de escritura
chown -R www-data:www-data /var/www/html/DracoLaravel/storage /var/www/html/DracoLaravel/bootstrap/cache
chmod -R 775 /var/www/html/DracoLaravel/storage /var/www/html/DracoLaravel/bootstrap/cache

# 4. Iniciar Apache en primer plano
exec apache2-foreground