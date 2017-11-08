FROM php:7.1.11-fpm-jessie
COPY . /var/www/html/
RUN apt-get update; apt-get install -y nginx wget zlib1g-dev libmagickwand-dev libmagickcore-dev; \
    docker-php-ext-install zip; \
    pecl install xdebug-2.5.0; \
    docker-php-ext-enable xdebug; \
    echo 'autodetect' | pecl install imagick-3.4.3; \
    docker-php-ext-enable imagick; \
    cp ./init-docker/composer.phar /bin/composer;chmod +x /bin/composer; \
    cp ./init-docker/nginx-site.conf /etc/nginx/sites-available/default; \
    chown www-data:www-data -R /var/www
USER www-data:www-data
RUN composer install
