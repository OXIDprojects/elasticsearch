FROM ubuntu:18.04
LABEL descritption="Oxid 6"
MAINTAINER "Tobias Veit <t.veit@syseleven.de>"

## JAVA_HOME
ENV JAVA_HOME /usr/lib/jvm/java-8-oracle

## INSTALL PACKAGES
RUN /bin/bash -c "ln -sf /usr/share/zoneinfo/Europe/Berlin /etc/localtime; \ 
apt-get -y update && \
DEBIAN_FRONTEND=noninteractive apt-get install software-properties-common apt-transport-https wget vim zip unzip composer -y && \ 
echo \"oracle-java8-installer shared/accepted-oracle-license-v1-1 select true\" | debconf-set-selections && \
add-apt-repository ppa:webupd8team/java && \
echo \"deb https://artifacts.elastic.co/packages/6.x/apt stable main\" | tee -a /etc/apt/sources.list.d/elastic-6.x.list && \
apt-key adv --keyserver keyserver.ubuntu.com --recv-keys EEA14886 && \
apt-key adv --keyserver keyserver.ubuntu.com --recv-keys D27D666CD88E42B4 && \
apt-get -y update && \
DEBIAN_FRONTEND=noninteractive apt-get -y --allow-downgrades --allow-remove-essential --allow-change-held-packages --no-install-recommends  install tzdata apache2 php libapache2-mod-php mysql-server php-cli php-intl mcrypt php-mysql php-gd php-curl php-xml php-bcmath php-mbstring php-soap oracle-java8-installer && \
DEBIAN_FRONTEND=noninteractive apt-get -y --allow-downgrades --allow-remove-essential --allow-change-held-packages --no-install-recommends  install elasticsearch && \
apt-get clean all "

COPY $PWD/oxid.sql /usr/local/etc/oxid.sql
COPY $PWD/000-default.conf /etc/apache2/sites-available/000-default.conf
RUN bin/bash -c "mkdir /var/run/mysqld/ && \
chown -R mysql:mysql /var/lib/mysql /var/run/mysqld && \
service mysql start && \ 
mysql -e 'create database oxid' && \
mysql -e \"CREATE USER 'oxid'@'localhost' IDENTIFIED BY 'oxid'\" && \
mysql -e \"GRANT ALL PRIVILEGES ON oxid.* TO 'oxid'@'localhost'\" && \
mysql oxid < /usr/local/etc/oxid.sql && \
a2enmod rewrite"

COPY $PWD/entrypoint.sh /usr/local/etc/entrypoint.sh
ENTRYPOINT ["/usr/local/etc/entrypoint.sh"]
