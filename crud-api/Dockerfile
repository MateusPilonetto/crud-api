FROM php:8.2-apache

WORKDIR /var/www/html

COPY . .

RUN mkdir -p data && chmod -R 777 data

RUN docker-php-ext-install pdo_mysql

COPY . /var/www/html/

EXPOSE 8000

CMD ["php", "-S", "0.0.0.0:8000", "-t", "src/public", "src/public/index.php"]