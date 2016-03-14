#!/bin/bash

container="fc_mysql"
directory="/usr/share/fcontrol"
hasData=0

if [ -d "$directory" ]
then
	echo 'Diretório local para armazenamento dos dados já existe.'
	hasData=1
else
	echo 'Criando diretório local para armazenamento dos dados...'
	sudo mkdir /usr/share/fcontrol
fi

docker ps -a | grep "$container" > /dev/null
wasCreated=$?

if [ $wasCreated = 0 ]
then 
	echo 'Container já existe.'
	docker ps | grep $container > /dev/null
	isRunning=$?
	if [ $isRunning = 0 ]
	then 
		echo 'Container já iniciado.'	
	else
		echo 'Iniciando o container...'
		docker start $container
	fi
else
	echo 'Criando e iniciando o container...'
	docker run --name $container -p 3306:3306 -v $directory:/var/lib/mysql -e MYSQL_DATABASE=fcontrol -e MYSQL_ROOT_PASSWORD=root_pass -d mysql:latest		
fi

if [ $hasData = 0 ]
then 
echo 'Criando a estrutura do banco...'
	mysql -uroot -proot_pass fcontrol < create_tables.sql
fi