FROM php:7.0-apache
RUN apt-get update
RUN apt-get install -y git
RUN docker-php-ext-install pdo pdo_mysql mysqli
RUN apt-get install -y libmcrypt-dev
RUN docker-php-ext-install mcrypt
RUN docker-php-ext-install calendar
COPY  html /var/www/html

EXPOSE 80
