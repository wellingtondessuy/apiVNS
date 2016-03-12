#!/bin/bash

# docker build -t fc_api_image .

# docker run --name fc_api -p 9998:80 -v $(pwd):/usr/share/nginx/fc:ro -d fc_api_image

# Faz o download do arquivo do composer e instala as dependências
docker exec fc_api /bin/bash -c 'cd /usr/share/nginx/fc && curl -sS https://getcomposer.org/installer && php composer.phar install'

# Configura o php.ini para apresentar os erros (utilizar somente no desenvolvimento)
docker exec fc_api /bin/bash -c "sed -i 's/display_errors = .*/display_errors = On/g' /etc/php5/cli/php.ini"
docker exec fc_api /bin/bash -c "sed -i 's/html_errors = .*/html_errors = Off/g' /etc/php5/cli/php.ini"
docker exec fc_api /bin/bash -c "sed -i 's/display_startup_errors = .*/display_startup_errors = Off/g' /etc/php5/cli/php.ini"
docker exec fc_api /bin/bash -c "sed -i 's/display_errors = .*/display_errors = On/g' /etc/php5/fpm/php.ini"
docker exec fc_api /bin/bash -c "sed -i 's/html_errors = .*/html_errors = Off/g' /etc/php5/fpm/php.ini"
docker exec fc_api /bin/bash -c "sed -i 's/display_startup_errors = .*/display_startup_errors = Off/g' /etc/php5/fpm/php.ini"
# --

docker exec fc_api /bin/bash -c 'service php5-fpm restart && chmod go+rw /var/run/php5-fpm.sock && service php5-fpm restart'