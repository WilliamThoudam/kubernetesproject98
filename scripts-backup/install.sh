#!/bin/sh

set -e

echo "[i] Installing base system..."
apk add --no-cache \
  php7-fpm php7-curl php7-dom php7-exif php7-fileinfo php7-gd php7-iconv php7-imagick php7-json php7-mbstring \
  php7-mcrypt php7-mysqli php7-openssl php7-sodium php7-xml php7-xmlreader php7-zip php7-zlib \
  mariadb mariadb-client mariadb-server-utils \
  supervisor \
  nginx

echo "[i] Removing default configurations..."
rm -rf /etc/php7/php-fpm.d/www.conf
rm -rf /etc/my.cnf.d/mariadb-server.cnf
rm -rf /etc/nginx/nginx.conf
rm -rf /etc/php7/php.ini
rm -rf /etc/supervisord.conf
rm -rf /etc/nginx/conf.d/default.conf

echo "[i] Creating wp root folder..."
mkdir /dojoko-wp

mkdir /var/log/mysql
chown -R mysql.mysql /var/log/mysql

mkdir /var/log/php-fpm
chown -R nobody.nobody /var/log/php-fpm

if [ -d /var/lib/mysql/mysql ]; then
  echo "[i] MySQL directory already present, skipping creation"
  chown -R mysql:mysql /var/lib/mysql
else
  echo "[i] MySQL data directory not found, creating initial DBs"

  chown -R mysql:mysql /var/lib/mysql

  mysql_install_db --user=mysql --ldata=/var/lib/mysql >/dev/null

  /usr/bin/mysqld --user=mysql --bootstrap --verbose=0 --skip-name-resolve --skip-networking=0 </tmp/mysql-init.sql
  rm -rf /tmp/mysql-init.sql
fi