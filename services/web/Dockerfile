FROM php:7.1-apache

RUN apt-get update &&\
    apt-get install -y mysql-client libicu-dev libmcrypt-dev zlib1g-dev zip &&\
    docker-php-ext-install mbstring mcrypt intl pdo_mysql zip

WORKDIR /var/www/app

COPY ./myapp.conf /etc/apache2/sites-available/myapp.conf
RUN a2ensite myapp.conf &&\
    a2dissite 000-default.conf
