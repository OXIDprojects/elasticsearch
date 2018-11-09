#!/bin/bash
docker stop oxid6hackathon
if [[ "$(docker ps -aq)" != "" ]]; then
	docker rm $(docker ps -qa)
fi && \
if [[ "$(docker images -q)" != "" ]]; then
	docker rmi  $(docker images -q)
fi && \
docker build -t oxid6 . && \
docker run -P -p80:80 -p 443:443 -p 8080:8080 -p 8443:8443 -v $PWD/shared/:/var/www/html/ -d --name oxid6hackathon  oxid6:latest && \
docker exec -ti oxid6hackathon /bin/bash -l
