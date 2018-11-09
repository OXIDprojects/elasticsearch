FROM ubuntu:18.04

LABEL descritption="Oxid 6"

MAINTAINER "Tobias Veit <t.veit@syseleven.de>"

RUN bin/bash -c "ln -s /usr/share/zoneinfo/Europe/Berlin  /etc/localtime   -f; \
apt-get -y update && DEBIAN_FRONTEND=noninteractive apt-get -y install tzdata \
apache2 php libapache2-mod-php mysql-server php-cli php-intl mcrypt php-mysql \
php-gd php-curl php-xml php-bcmath php-mbstring php-soap vim"

COPY $PWD/oxid.sql /opt/oxid.sql
RUN bin/bash -c "mkdir /var/run/mysqld/ && \
chown -R mysql:mysql /var/lib/mysql /var/run/mysqld && \
service mysql start \
&& mysql -e 'create database oxid' \
&& mysql oxid < /opt/oxid.sql"

ADD $PWD/shared/ /var/www/html/
COPY $PWD/entrypoint.sh /etc/entrypoint.sh
ENTRYPOINT ["/etc/entrypoint.sh"]
