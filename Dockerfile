FROM php:8.0-alpine

WORKDIR /var/www

COPY composer.json composer.lock ./

RUN mkdir -p /tmp/build && cd /tmp/build

COPY . .

EXPOSE 80

CMD ["nginx", "-g", "daemon off;"]
