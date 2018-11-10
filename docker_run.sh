#!/bin/bash
docker stop oxid6hackathon
if [[ "$(docker ps -aq)" != "" ]]; then
	docker rm $(docker ps -qa)
fi && \
docker run -P -p80:80 -p443:443 -v $PWD/shared/app/:/opt/ -v $PWD/shared/oxideshop/:/var/www/  -d --name oxid6hackathon  oxid6:latest && \
docker exec -ti oxid6hackathon /bin/bash -l

