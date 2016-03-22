#!/bin/bash

composer=0

# Busca os parâmetros passados
while [ "$1" != "" ]; do
	case $1 in
		-c | --composer )
			composer=1
			shift
			;;
		-h | --help )
			shift
			echo "Instructions:"
			echo "	-c | --composer - Atualiza as dependências via composer"
			echo "	-h | --help 	- Lista os comandos"
			exit
			;;
		* )
			echo "Comando $1 não encontrado!"
			exit 
			;;
	esac
done

# Nome do container
container="fc_api"

# Cria a imagem docker a partir do Dockerfile existente na pasta do projeto
docker build -t fc_api_image .

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
	docker run --name $container -p 9998:80 -v $(pwd):/usr/share/nginx/fc:ro -d fc_api_image

	# Faz o download do arquivo do composer e instala as dependências
	composer install
	composer update --ignore-platform-reqs
	# docker exec $container /bin/bash -c 'cd /usr/share/nginx/fc && php composer.phar install'

	# Configura o php.ini para apresentar os erros (utilizar somente no desenvolvimento)
	docker exec $container /bin/bash -c "sed -i 's/display_errors = .*/display_errors = On/g' /etc/php5/cli/php.ini" &
	docker exec $container /bin/bash -c "sed -i 's/html_errors = .*/html_errors = Off/g' /etc/php5/cli/php.ini" &
	docker exec $container /bin/bash -c "sed -i 's/display_startup_errors = .*/display_startup_errors = Off/g' /etc/php5/cli/php.ini" &
	docker exec $container /bin/bash -c "sed -i 's/display_errors = .*/display_errors = On/g' /etc/php5/fpm/php.ini" &
	docker exec $container /bin/bash -c "sed -i 's/html_errors = .*/html_errors = Off/g' /etc/php5/fpm/php.ini" &
	docker exec $container /bin/bash -c "sed -i 's/display_startup_errors = .*/display_startup_errors = Off/g' /etc/php5/fpm/php.ini" &
	# --

	docker exec $container /bin/bash -c 'service php5-fpm restart && chmod go+rw /var/run/php5-fpm.sock && service php5-fpm restart'

fi

sudo chmod -R 777 tmp/ &> /dev/null

if [ $composer = 1 ]
then 
	echo 'Atualizando dependências via composer...'
	composer update --ignore-platform-reqs
fi