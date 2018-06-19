# https://hub.docker.com/r/richarvey/nginx-php-fpm/
FROM richarvey/nginx-php-fpm:php5

#WITH XDEBUG :xdebug
#RUN apk add --update --no-cache --repository http://dl-cdn.alpinelinux.org/alpine/edge/main --repository http://dl-cdn.alpinelinux.org/alpine/edge/community php5-apcu php5-pear php5-phalcon php5-xdebug

#WITHOUT XDEBUG :latest
RUN apk add --no-cache php5-apcu php5-pear php5-phalcon

# Add nginx config
ADD meta/docker/phalcon.ini /etc/php5/conf.d/phalcon.ini
ADD meta/docker/nginx-site.conf /etc/nginx/sites-available/default.conf


#:xdebug
#RUN docker-php-ext-enable xdebug

### CONSOLE REFERENCE ###

#To build:
#docker build -t metehan/phalcon:latest .

#Run:
#docker run -p 8080:80 -v /d/dev/solar/venus.dev:/var/www/html --name m.phalcon -e "DBUSER=mercury" -e "DBPASS=mercury" metehan/phalcon:latest

#Run with nginx-proxy docker run -v /d/dev/solar/venus.dev:/var/www/html --name m.phalcon -e "DBUSER=mercury" -e "DBPASS=mercury" -e VIRTUAL_HOST=example.com,www.example.com metehan/phalcon:latest