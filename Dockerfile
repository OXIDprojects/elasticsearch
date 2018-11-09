FROM ubuntu:18.04

LABEL descritption="Oxid 6"

MAINTAINER "Tobias Veit <t.veit@syseleven.de>"

RUN apt -y update && DEBIAN_FRONTEND=noninteractive apt -y install tzdata apache2 php libapache2-mod-php

CMD /etc/init.d/apache2 start
