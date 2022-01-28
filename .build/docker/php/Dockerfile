FROM php:8.1-fpm-bullseye
MAINTAINER SprintF <devops@sprintf.ru>

ENV TIMEZONE            Europe/Moscow
ENV TZ                  $TIMEZONE
ENV PHP_MEMORY_LIMIT    1024M
ENV UPLOAD_MAX_FILESIZE 100M
ENV PHP_MAX_POST        150M
ENV ERROR_REPORTING     E_ALL

ENV SUPERCRONIC_URL=https://github.com/aptible/supercronic/releases/download/v0.1.12/supercronic-linux-amd64
ENV SUPERCRONIC=supercronic-linux-amd64
ENV SUPERCRONIC_SHA1SUM=048b95b48b708983effb2e5c935a1ef8483d9e3e

RUN apt-get update && apt-get install -y tzdata && \
    rm /etc/localtime && \
    ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && \
    dpkg-reconfigure -f noninteractive tzdata

RUN apt-get install -y locales wget curl libpq-dev libzip-dev zip unzip git libonig-dev libxml2-dev && \
    docker-php-ext-install -j$(nproc) iconv mbstring pdo_pgsql zip gettext intl sysvsem

RUN echo 'ru_RU.UTF-8 UTF-8' >> /etc/locale.gen && \
    locale-gen
ENV LANG ru_RU.UTF-8
ENV LANGUAGE ru_RU:en
ENV LC_ALL ru_RU.UTF-8

RUN pecl channel-update pecl.php.net
RUN pecl install xdebug
RUN docker-php-ext-enable xdebug
#COPY xdebug.ini /usr/local/etc/php/conf.d/

RUN ln -s /usr/local/bin/php /bin/php

RUN curl -s https://getcomposer.org/installer | php && mv composer.phar /usr/local/bin/composer
RUN wget https://get.symfony.com/cli/installer -O - | bash &&  mv /root/.symfony/bin/symfony /usr/local/bin/symfony

RUN echo "date.timezone = ${TIMEZONE}" >> /usr/local/etc/php/php.ini && \
    echo "memory_limit = ${PHP_MEMORY_LIMIT}" >> /usr/local/etc/php/php.ini && \
    echo "upload_max_filesize = ${UPLOAD_MAX_FILESIZE}" >> /usr/local/etc/php/php.ini && \
    echo "post_max_size = ${PHP_MAX_POST}" >> /usr/local/etc/php/php.ini && \
    echo "error_reporting = ${ERROR_REPORTING}" >> /usr/local/etc/php/php.ini

RUN curl -fsSLO "$SUPERCRONIC_URL" \
 && echo "${SUPERCRONIC_SHA1SUM}  ${SUPERCRONIC}" | sha1sum -c - \
 && chmod +x "$SUPERCRONIC" \
 && mv "$SUPERCRONIC" "/usr/local/bin/${SUPERCRONIC}" \
 && ln -s "/usr/local/bin/${SUPERCRONIC}" /usr/local/bin/supercronic

ARG UID
ARG GID

RUN usermod -u ${UID} www-data && \
    groupmod -g ${GID} www-data && \
    mkdir /home/www-data && \
    mkdir /home/www-data/.composer && \
    touch /home/www-data/.gitconfig && \
    usermod --home /home/www-data www-data && \
    chown -R www-data.www-data /home/www-data && \
    chown -R www-data.www-data /home/www-data/.composer && \
    chown -R www-data.www-data /home/www-data/.gitconfig


RUN apt-get clean && apt-get -y autoremove && \
    rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/ /usr/share/man/ /usr/share/locale/

USER www-data

RUN git config --global user.email "beptep@sprintf.ru" && \
    git config --global user.name "Робот Вертер"

WORKDIR /app
