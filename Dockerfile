FROM php:8.2-apache
# 1. Instalar dependencias del sistema y extensiones de PHP necesarias para CodeIgniter 4
RUN apt-get update && apt-get install -y \
    libicu-dev \
    libpng-dev \
    libzip-dev \
    zip \
    unzip \
    git \
    && docker-php-ext-install intl gd pdo_mysql mysqli zip opcache
# 2. Instalar Composer desde la imagen oficial
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
# 3. Habilitar mod_rewrite de Apache para el enrutamiento de CodeIgniter
RUN a2enmod rewrite
# 4. Cambiar el DocumentRoot de Apache a la carpeta 'public' de CI4
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/inc/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf
# 5. Establecer el directorio de trabajo
WORKDIR /var/www/html
# 6. Copiar los archivos del proyecto al contenedor
COPY . .
# 7. Instalar dependencias de PHP (esto crea la carpeta vendor que te falta)
# Usamos --no-dev para producción y optimizamos el autoloader
RUN composer install --no-dev --optimize-autoloader --no-interaction
# 8. Configurar permisos para la carpeta writable (fundamental para CI4)
RUN chown -R www-data:www-data /var/www/html/writable
# Exponer el puerto 80
EXPOSE 80
