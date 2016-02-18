#!/bin/bash

#root
sudo -i

echo 'Removendo apache2'
apt-get --purge remove apache2

apt-get update
apt-get upgrade

# Installing Mysql server
# debconf-set-selections <<< 'mysql-server-5.5 mysql-server/root_password password rootpass'
# debconf-set-selections <<< 'mysql-server-5.5 mysql-server/root_password_again password rootpass'
# apt-get -y install mysql-server libapache2-mod-auth-mysql php5-mysql

# precisa ser alterado para salvar corretamente no arquivo
# sed -i "57a\default-storage-engine = myisam" /etc/mysql/my.cnf 

# /etc/init.d/mysql start

# Install Nginx
echo 'Instalando Nginx'
apt-get -y install nginx
apt-get install -y nginx-extras

# Install PHP
echo 'Instalando PHP e plugins'
apt-get -y install php5 php5-mcrypt php5-cli php5-fpm php5-mysql

####
echo 'Alterando arquivo de configuração do Nginx'
# Removendo o arquivo de configuração padrão do Nginx
rm /etc/nginx/nginx.conf
# Link do arquivo de configuração existente no projeto
ln -s /vagrant/config/nginx.conf /etc/nginx/

# Install composer e via composer o Slim Framework
echo 'Instalando Composer'
cd /vagrant
curl -sS https://getcomposer.org/installer | php
echo 'Instalando Slim via composer'
php composer.phar install
cd ~

# Reiniciando o Nginx
echo 'Reiniciando Nginx'
service nginx restart
