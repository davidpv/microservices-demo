FROM php:8.3-alpine3.19

RUN apk update && apk add --no-cache curl bash

RUN curl -1sLf 'https://dl.cloudsmith.io/public/symfony/stable/setup.alpine.sh' | bash
RUN apk add symfony-cli sqlite-libs expect mysql-client

ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/
RUN chmod +x /usr/local/bin/install-php-extensions && install-php-extensions @composer intl amqp pdo_mysql

COPY . /var/www/html
ENV COMPOSER_ALLOW_SUPERUSER=1
CMD ["symfony", "server:start", "--allow-http","--no-tls","--port=5001"]

EXPOSE 5001

WORKDIR /var/www/html
