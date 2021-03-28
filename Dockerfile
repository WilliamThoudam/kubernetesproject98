FROM centos:latest
MAINTAINER kubernetesproject98@gmail.com
RUN yum install -y httpd \ zip \
unzip
ADD https://www.free-css.com/assets/files/free-css-templates/download/page258/loxury.zip /var/www/html/ WORKING /var/www/html
RUN unzip luxury.zip RUN cp -rvf luxury/* .
RUN rm -rf luxury luxury.zip
CMD [“/user/sbin/httpd”, “-D”, “FOREGROUND”]
EXPOSE 80
####FinalTestWaredEibo
