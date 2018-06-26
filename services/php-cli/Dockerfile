FROM php:7.1-cli

ARG USER_ID
ARG GROUP_ID

WORKDIR /var/www/app

RUN apt-get update &&\
    apt-get install -y git mysql-client libicu-dev libmcrypt-dev zlib1g-dev zip busybox-static &&\
    pecl install xdebug &&\
    docker-php-ext-install mbstring mcrypt intl pdo_mysql zip &&\
    docker-php-ext-enable xdebug &&\
    curl -sS https://getcomposer.org/installer | php &&\
    mv composer.phar /usr/local/bin/composer &&\
    groupadd -g $GROUP_ID -o developer &&\
    useradd -m developer -u $USER_ID -g $GROUP_ID

COPY ./crontab /var/spool/cron/crontabs/developer

USER developer

CMD ["busybox", "crond", "-f", "-L /dev/stderr"]
