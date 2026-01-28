FROM php:8.2-apache
# Instalar dependencias del sistema y extensiones de PHP necesarias para CodeIgniter 4
RUN apt-get update && apt-get install -y \
    libicu-dev \
    libpng-dev \
    libzip-dev \
    zip \
    unzip \
    && docker-php-ext-install intl gd pdo_mysql mysqli zip opcache
# Habilitar mod_rewrite de Apache para el enrutamiento de CodeIgniter
RUN a2enmod rewrite
# Cambiar el DocumentRoot de Apache a la carpeta 'public' de CI4
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/inc/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf
# Establecer el directorio de trabajo
WORKDIR /var/www/html
# Copiar los archivos del proyecto al contenedor
COPY . .
# Configurar permisos para la carpeta writable (fundamental para CI4)
RUN chown -R www-data:www-data /var/www/html/writable
# Exponer el puerto 80
EXPOSE 80
# Apache se ejecutará en primer plano por defecto por la imagen base