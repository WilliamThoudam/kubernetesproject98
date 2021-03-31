FROM alpine:3.13.1
RUN apk add --no-cache \
    php7-fpm php7-curl php7-dom php7-exif php7-fileinfo php7-gd php7-iconv php7-imagick php7-json php7-mbstring \
    php7-mcrypt php7-mysqli php7-openssl php7-sodium php7-xml php7-xmlreader php7-zip php7-zlib  php7-ctype php7-session \
    mariadb mariadb-client mariadb-server-utils \
    supervisor \
    nginx


RUN rm -rf /etc/php7/php-fpm.d/www.conf
RUN rm -rf /etc/my.cnf.d/mariadb-server.cnf
RUN rm -rf /etc/nginx/nginx.conf
RUN rm -rf /etc/php7/php.ini
RUN rm -rf /etc/supervisord.conf
RUN rm -rf /etc/nginx/conf.d/default.conf

RUN mkdir /dojoko-wp
COPY ./  /dojoko-wp/

RUN mkdir /var/log/mysql
RUN chown -R mysql.mysql /var/log/mysql

RUN mkdir /var/log/php-fpm
RUN chown -R nobody.nobody /var/log/php-fpm

RUN rm -rf /tmp/mysql-init.sql
COPY /etc/* /tmp/

RUN mv /tmp/fpm-www.conf /etc/php7/php-fpm.d/www.conf
RUN mv /tmp/mariadb-server.conf /etc/my.cnf.d/mariadb-server.cnf
RUN mv /tmp/nginx.conf /etc/nginx/nginx.conf
RUN mv /tmp/php.ini /etc/php7/php.ini
RUN mv /tmp/supervisord.conf /etc/supervisord.conf
RUN mv /tmp/mysql-init.ini /etc/mysql/mysql-init.sql

RUN chown -R mysql:mysql /var/lib/mysql

RUN mysql_install_db --user=mysql --ldata=/var/lib/mysql >/dev/null

RUN /usr/bin/mysqld --user=mysql --bootstrap --verbose=0 --skip-name-resolve --skip-networking=0 </etc/mysql/mysql-init.sql
# RUN mysql -u dojoko -pdojoko@123$ dojoko < /dojoko-wp/seed/dojoko.sql
ENTRYPOINT ["supervisord", "--nodaemon", "--configuration", "/etc/supervisord.conf"]

#CMD ["sh"," /dojoko-wp/scripts/init.sh"]se


EXPOSE 80