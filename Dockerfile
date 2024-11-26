# Usa la imagen oficial de PHP con Apache
FROM php:7.2-apache


# Instala las dependencias necesarias
RUN apt-get update && apt-get install -y \
    libzip-dev \
    zlib1g-dev

# Instala las extensiones necesarias para CodeIgniter
RUN docker-php-ext-install pdo pdo_mysql mysqli fileinfo zip

# Habilita mod_rewrite para Apache
RUN a2enmod rewrite
