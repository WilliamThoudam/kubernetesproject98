#!/bin/bash
mv /var/www/dojoko /var/www/html/mysite
rm /var/www/html/mysite/wp-config.php 
cp /opt/wp-config.php /var/www/html/mysite/wp-config.php
chown -R www-data:www-data /var/www/html/mysite/
chmod -R 775 /var/www/html/mysite/

