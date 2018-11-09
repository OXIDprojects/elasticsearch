FROM ubuntu:18.04

LABEL descritption="Oxid 6"

MAINTAINER "Tobias Veit <t.veit@syseleven.de>"

RUN bin/bash -c "ln -s /usr/share/zoneinfo/Europe/Berlin  /etc/localtime   -f; \
apt -y update && \
DEBIAN_FRONTEND=noninteractive apt -y install tzdata apache2 php libapache2-mod-php mysql-server php-cli php-intl mcrypt php-mysql php-gd php-curl php-xml php-bcmath php-mbstring php-soap"

ADD $PWD/shared/ /var/www/html/
COPY $PWD/entrypoint.sh /etc/entrypoint.sh
ENTRYPOINT ["/etc/entrypoint.sh"]
