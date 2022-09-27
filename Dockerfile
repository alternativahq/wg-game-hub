FROM ubuntu:22.04

#RUN useradd -ms /bin/bash -u 1000 ubuntu

WORKDIR /var/www/html

ENV DEBIAN_FRONTEND noninteractive
ENV TZ=UTC
ARG NODE_VERSION=16

RUN apt-get update \
    && apt-get install -y gosu gnupg vim ca-certificates wget curl gzip unzip git supervisor sqlite3 \
    && mkdir -p ~/.gnupg \
    && chmod 600 ~/.gnupg \
    && echo "disable-ipv6" >> ~/.gnupg/dirmngr.conf \
    && echo "keyserver hkp://keyserver.ubuntu.com:80" >> ~/.gnupg/dirmngr.conf \
    && gpg --recv-key 0x14aa40ec0831756756d7f66c4f4ea0aae5267a6c \
    && gpg --export 0x14aa40ec0831756756d7f66c4f4ea0aae5267a6c > /usr/share/keyrings/ppa_ondrej_php.gpg \
    && echo "deb [signed-by=/usr/share/keyrings/ppa_ondrej_php.gpg] https://ppa.launchpadcontent.net/ondrej/php/ubuntu jammy main" > /etc/apt/sources.list.d/ppa_ondrej_php.list \
    && apt-get update \
    && apt-get install -y nginx php8.1-fpm php8.1-cli php8.1-pgsql php8.1-sqlite3 php8.1-gd php8.1-curl php8.1-memcached php8.1-imap php8.1-mysql php8.1-mbstring php8.1-xml php8.1-zip php8.1-bcmath php8.1-soap php8.1-intl php8.1-readline php8.1-msgpack php8.1-igbinary php8.1-imagick php8.1-ldap php8.1-gmp php8.1-redis php8.1-swoole \
    && php -r "readfile('https://getcomposer.org/installer');" | php -- --install-dir=/usr/bin/ --filename=composer \
    && mkdir -p /run/php \
    && curl -sLS https://deb.nodesource.com/setup_$NODE_VERSION.x | bash - \
    && apt-get install -y nodejs \
    && npm install -g npm \
    && apt-get update \
    && apt-get -y autoremove \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* \
    && echo "daemon off;" >> /etc/nginx/nginx.conf \
    && ln -sf /dev/stdout /var/log/nginx/access.log \
    && ln -sf /dev/stderr /var/log/nginx/error.log \
    && sed -i 's/^;daemonize.*$/daemonize = no/g' /etc/php/8.1/fpm/php-fpm.conf \
    && sed -i 's@^error_log.*$@error_log = /proc/self/fd/2@g' /etc/php/8.1/fpm/php-fpm.conf

COPY default /etc/nginx/sites-available/default
COPY supervisord.conf /etc/supervisor/conf.d/supervisord.conf
COPY start-container /usr/local/bin/start-container
RUN chmod +x /usr/local/bin/start-container

EXPOSE 80
ENTRYPOINT ["start-container"]

#CMD mkdir gamehub
COPY . /var/www/html
#RUN composer install --no-interaction --prefer-dist --optimize-autoloader
#RUN npm install
#RUN npm run prod
#RUN php artisan optimize:clear
#RUN php artisan optimize

RUN chown -R root:www-data /var/www/html
RUN chmod 777 storage/logs/laravel.log
RUN chmod -R 777 storage/
