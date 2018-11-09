FROM ubuntu:18.04

LABEL descritption="Oxid 6"

MAINTAINER "Tobias Veit <t.veit@syseleven.de>"

RUN apt -y update && DEBIAN_FRONTEND=noninteractive apt -y install tzdata apache2 php libapache2-mod-php

ADD $PWD/shared/ /var/www/html/
#EXPOSE 80:80 443:443 8080:8080 8443:8443
ENTRYPOINT ["/usr/sbin/apache2ctl","-D","FOREGROUND"]

#CMD while true; do sleep 1; done
