FROM nginx:stable-alpine

RUN sed -i "s/user  nginx/user root/g" /etc/nginx/nginx.conf

ADD ./nginx-soketi/default.conf /etc/nginx/conf.d/

RUN mkdir -p /var/www/html
