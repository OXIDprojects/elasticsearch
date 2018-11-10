# Elasticsearch module for OXID eShop
Elasticsearch module for OXID eShop / Project at Hackathon 2018

## Run Development Environment

```

git clone git@github.com:OXIDprojects/elasticsearch_hackathon2018.git
cd elasticsearch_hackathon2018
./docker_build.sh
```

Be carefull the script will search for existing docker containers and will
delete them all.

Further it will delete all existing images.

After cleaning up it will build and run the docker image. Followed by entering
the container.

Ready to go.

## Test Environment

Currently there is running a distributed Oxid 6.1 Setup at
https://oxid.jakobspielt.de/. The depoloyment Process will follow.

## Elasticsearch Module

Init submodule:
```
cd shared/oxideshop/oxideshop/source/modules/oxcom/elasticsearch
git submodule init
git submodule update
```
