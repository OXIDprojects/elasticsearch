#!/bin/bash

service mysql start 
service elasticsearch start
/usr/sbin/apache2ctl -D FOREGROUND &
wait
