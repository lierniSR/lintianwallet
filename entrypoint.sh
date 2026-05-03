#!/bin/bash
set -e

echo "Iniciando MariaDB..."
service mariadb start

# Esperar a que MariaDB esté listo
until mysqladmin ping >/dev/null 2>&1; do
  echo "Esperando a MariaDB..."
  sleep 2
done

# Crear la base de datos si no existe e importar el dump
DB_NAME="bdlintianwallet"

echo "Configurando base de datos: $DB_NAME"
mysql -e "CREATE DATABASE IF NOT EXISTS \`$DB_NAME\`;"
mysql -e "GRANT ALL PRIVILEGES ON \`$DB_NAME\`.* TO 'root'@'localhost' IDENTIFIED BY '1234';"
mysql -e "FLUSH PRIVILEGES;"

# Importar el dump solo si la tabla 'usuario' no existe (para evitar duplicados)
if ! mysql -e "USE $DB_NAME; SHOW TABLES LIKE 'usuario';" | grep -q "usuario"; then
    echo "Importando dump SQL..."
    mysql "$DB_NAME" < /var/www/html/dump-bdlintianwallet-202605031826.sql
    echo "¡Importación completada!"
else
    echo "La base de datos ya contiene tablas, saltando importación."
fi

echo "Iniciando Apache..."
apache2-foreground
