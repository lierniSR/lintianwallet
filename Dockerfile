FROM php:8.2-apache

# 1. Instalar dependencias, extensiones y el servidor de MariaDB
RUN apt-get update && apt-get install -y \
    libicu-dev \
    libpng-dev \
    libzip-dev \
    zip \
    unzip \
    git \
    mariadb-server \
    && docker-php-ext-install intl gd pdo_mysql mysqli zip opcache

# 2. Configurar MariaDB (permitir que el servicio arranque en el contenedor)
RUN mkdir -p /var/run/mysqld && chown mysql:mysql /var/run/mysqld

# 3. Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 4. Habilitar mod_rewrite
RUN a2enmod rewrite

# 5. Configurar DocumentRoot
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/inc/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# 6. Directorio de trabajo
WORKDIR /var/www/html

# 7. Copiar archivos y el script de inicio
COPY . .
COPY entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

# 8. Instalar dependencias de PHP
RUN composer install --no-dev --optimize-autoloader --no-interaction

# 9. Permisos
RUN chown -R www-data:www-data /var/www/html/writable

# Exponer puertos (solo el 80 para la web)
EXPOSE 80

# Usar el script de inicio para arrancar MariaDB y Apache
ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]
