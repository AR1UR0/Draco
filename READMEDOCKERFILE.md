# DracoLaravel (PHP + MySQL + phpMyAdmin)

Este proyecto despliega un entorno completo de Laravel utilizando **Docker Compose**. Incluye un servidor web Apache con PHP 8.2, una base de datos MySQL 9.6 y una interfaz de administración de base de datos.

---

## Arquitectura

El entorno se compone de tres servicios principales interconectados:

- **PHP (Apache):** Servidor web configurado con SSL y las extensiones necesarias para Laravel.
- **MySQL:** Base de datos persistente (v9.6) con volumen de datos local.
- **phpMyAdmin:** Herramienta web para gestionar la base de datos.

---

## Requisitos Previos

1.  **Docker & Docker Compose** instalados.

- Ejecuta este bloque en tu terminal de Ubuntu para instalar Docker correctamente:

```bash
# 1. Agregar la clave GPG oficial de Docker:
sudo apt update
sudo apt install ca-certificates curl
sudo install -m 0755 -d /etc/apt/keyrings
sudo curl -fsSL https://download.docker.com/linux/ubuntu/gpg -o /etc/apt/keyrings/docker.asc
sudo chmod a+r /etc/apt/keyrings/docker.asc

# 2. Agregar el repositorio a las fuentes de Apt:
sudo tee /etc/apt/sources.list.d/docker.sources <<EOF
Types: deb
URIs: https://download.docker.com/linux/ubuntu
Suites: $(. /etc/os-release && echo "${UBUNTU_CODENAME:-$VERSION_CODENAME}")
Components: stable
Signed-By: /etc/apt/keyrings/docker.asc
EOF

# 3. Instalar los paquetes de Docker
sudo apt update
sudo apt install docker-ce docker-ce-cli containerd.io docker-buildx-plugin docker-compose-plugin
```

3.  El archivo `.env` de Laravel debe existir en `./DracoLaravel/.env`.
4.  Certificados SSL en `./ssl/` (`server.crt` y `server.key`).
5.  Configuración de Apache en `./apache/laravel.conf`.
6.  **Importante:** Debes esperar a que el contenedor de PHP esté levantado y MySQL esté en estado **"Healthy"**.

- Para ejecutar las migraciones de Laravel dentro del contenedor:

```bash
docker-compose exec php php artisan migrate --seed
```

---

## Despliegue Rápido

Para levantar todo el entorno, simplemente ejecuta el siguiente comando en la raíz del proyecto:

```bash
docker-compose up -d --build
```

## Accesos directos:

- Aplicación (HTTP): http://localhost
- Aplicación (HTTPS): https://localhost:8080
- phpMyAdmin: http://localhost:8081

## Detalles Técnicos

### Dockerfile (Backend)

La imagen personalizada de PHP incluye:

- **Extensiones:** `pdo_mysql`, `zip`, `gd`.
- **Módulos Apache:** `rewrite`, `ssl`, `headers`.
- **Composer:** Integrado para instalar dependencias automáticamente durante el build.
- **Permisos:** Configuración automática de `www-data` para las carpetas `storage` y `bootstrap/cache`.

### Docker Compose

- **Persistencia:** Los datos de MySQL se almacenan en el directorio local `./db_data` para evitar pérdida de información.
- **Healthcheck:** El servicio de PHP espera a que MySQL esté totalmente listo (**Healthy**) antes de iniciar el servidor Apache.
- **Redes:** Utiliza un driver de tipo `bridge` con alias personalizados para comunicación entre contenedores.

---

## Estructura del Repositorio

```text
.
├── apache/
│   └── laravel.conf      # Configuración del sitio en Apache
├── ssl/
│   ├── server.crt        # Certificado SSL
│   └── server.key        # Llave privada SSL
├── DracoLaravel/         # Directorio de la App Laravel
│   ├── .env              # Variables de entorno
│   ├── Dockerfile        # Definición de la imagen PHP
│   └── ...
├── db_data/              # (Auto-generado) Datos de MySQL
├── docker-compose.yml    # Orquestador de servicios
└── README.md             # Instrucciones del proyecto
```
