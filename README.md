# apiVNS

	docker build -t fc_api_image .

	docker run --name fc_api -p 9998:80 -v $(pwd):/usr/share/nginx/fc:ro -d fc_api_image
	
	Executar o init.sh. Caso não esteja com permissão de execução, execute o comando: chmod +x init.sh .