FROM php:7.1.11-fpm-jessie
RUN apt update
RUN apt install -y nginx net-tools vim