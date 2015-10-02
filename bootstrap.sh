#!/bin/bash

#root
sudo -i

apt-get update

# Install Nginx
apt-get -y install nginx

# Install PHP
apt-get -y install php5 libapache2-mod-php5 php5-mcrypt php5-cli php5-fpm