#!/bin/bash
docker stop oxid6hackathon
if [[ "$(docker ps -aq)" != "" ]]; then
	docker rm $(docker ps -qa)
fi && \
if [[ "$(docker images -q)" != "" ]]; then
	docker rmi  $(docker images -q)
fi && \
docker build -t oxid6 . 
