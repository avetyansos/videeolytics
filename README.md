# UI Hackthon


## On production server

#### Build and up docker containers
    make docker-start
    
#### Stop/remove all docker containers
    make docker-stop
    
#### Tail docker logs for all containers
    make logs-tail

#### Dump MySQL data (to: data/backups/db/mysql/latest-dump.sql)
    make mysql-dump

#### Restore MySQL data (from: data/backups/db/mysql/latest-dump.sql)
    make mysql-restore

#### Stop/remove all docker containers and images (!!! BE CAREFUL)
    docker stop $(docker ps -a -q)
    docker rm $(docker ps -a -q)
    docker rmi $(docker images -a -q)
    

