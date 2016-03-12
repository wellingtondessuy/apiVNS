FROM ubuntu:14.04

RUN apt-get -y update

RUN apt-get -y install

RUN apt-get install -y nginx nginx-extras

RUN apt-get -y install php5 php5-mcrypt php5-cli php5-fpm php5-mysql

RUN apt-get -y install curl

COPY config/nginx.conf /etc/nginx/nginx.conf

CMD ["nginx", "-g", "daemon off;"]