FROM nginx:stable-alpine

RUN sed -i "s/user  nginx/user root/g" /etc/nginx/nginx.conf

ADD ./nginx/default.conf /etc/nginx/conf.d/

RUN mkdir -p /var/www/html

WORKDIR /var/www/html

# After preparing nginx, install roadrunner for the worker
CMD ["php", "./vendor/bin/rr", "get-binary", "-n", "--ansi"]
