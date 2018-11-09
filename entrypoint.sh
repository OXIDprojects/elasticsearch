#!/bin/bash

chown -R mysql:mysql /var/lib/mysql /var/run/mysqld
service mysql start 
service elasticsearch start
/usr/sbin/apache2ctl -D FOREGROUND &
wait
