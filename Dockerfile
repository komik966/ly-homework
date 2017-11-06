FROM php:7.1.11-fpm-jessie
COPY . /var/www/html/
RUN apt-get update; apt-get install -y nginx wget zlib1g-dev; \
    docker-php-ext-install zip; \
    ./init-docker/composer.sh; \
    cp ./init-docker/nginx-site.conf /etc/nginx/sites-available/default; \
    /etc/init.d/nginx start; \
    chown www-data:www-data -R /var/www
USER www-data:www-data
RUN composer install --no-dev
