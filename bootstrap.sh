#!/bin/bash

#root
sudo -i

apt-get update
apt-get upgrade

# Install Nginx
apt-get -y install nginx

# Install PHP
apt-get -y install php5 php5-mcrypt php5-cli php5-fpm

# Removendo o arquivo de configuração padrão do Nginx
rm /etc/nginx/nginx.conf
# Link do arquivo de configuração existente no projeto
ln -s /vagrant/config/nginx.conf /etc/nginx/
# Reiniciando o Nginx
service nginx restart

# Install composer e via composer o Slim Framework
cd /vagrant
curl -sS https://getcomposer.org/installer | php
php composer.phar install
cd ~