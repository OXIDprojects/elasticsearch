#!/bin/bash
docker stop oxid6hackathon
if [[ "$(docker ps -aq)" != "" ]]; then
	docker rm $(docker ps -qa)
fi && \
docker run -P -p80:80 -p443:443 -p9200:9200 -p9300:9300 -v $PWD/shared/oxideshop/:/var/www/  -d --name oxid6hackathon  oxid6:latest

