FROM ubuntu:18.04

LABEL descritption="Oxid 6"

MAINTAINER "Tobias Veit <t.veit@syseleven.de>"

#CMD apt install -y tzdata && apt update && apt -y install apache2 php libapache2-mod-php && while true; do sleep 10; done
CMD apt-get update && apt -y install apache2 php libapache2-mod-php && while true; do sleep 10; done
