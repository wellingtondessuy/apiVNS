#!/bin/bash
 
	## Validação se o docker e o mysql estão instalados no host

# Nome do container
container="fc_mysql"

# Diretório do host onde os dados do banco serão guardados 
directory="/usr/share/fcontrol"

hasData=0

if [ -d "$directory" ]
then
	echo 'Diretório local para armazenamento dos dados já existe.'
	hasData=1
else
	echo 'Criando diretório local para armazenamento dos dados...'
	sudo mkdir $directory
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

# if [ $hasData = 0 ]
# then 
# echo 'Criando a estrutura do banco...'
# 	mysql -uroot -proot_pass -P3306 -h127.0.0.1 fcontrol < db/create_tables.sql
# fi