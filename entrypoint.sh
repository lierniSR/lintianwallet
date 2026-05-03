#!/bin/bash
set -e

echo "Iniciando MariaDB..."
service mariadb start

# Esperar a que MariaDB esté listo
until mysqladmin ping >/dev/null 2>&1; do
  echo "Esperando a MariaDB..."
  sleep 2
done

# Crear la base de datos y configurar privilegios
DB_NAME="bdlintianwallet"
DB_PASS="1234"

echo "Configurando base de datos: $DB_NAME"

# Usar el socket de unix para entrar como root sin problemas de contraseña inicial
mysql --protocol=socket -e "CREATE DATABASE IF NOT EXISTS \`$DB_NAME\`;"
mysql --protocol=socket -e "ALTER USER 'root'@'localhost' IDENTIFIED BY '$DB_PASS';"
mysql --protocol=socket -e "GRANT ALL PRIVILEGES ON \`$DB_NAME\`.* TO 'root'@'localhost';"
mysql --protocol=socket -e "FLUSH PRIVILEGES;"

# Importar el dump solo si la tabla 'usuario' no existe (usamos la nueva contraseña)
if ! mysql -u root -p"$DB_PASS" -e "USE $DB_NAME; SHOW TABLES LIKE 'usuario';" | grep -q "usuario"; then
    echo "Importando dump SQL..."
    mysql -u root -p"$DB_PASS" "$DB_NAME" < /var/www/html/dump-bdlintianwallet-202605031826.sql
    echo "¡Importación completada!"
else
    echo "La base de datos ya contiene tablas, saltando importación."
fi

echo "Iniciando Apache..."
apache2-foreground
