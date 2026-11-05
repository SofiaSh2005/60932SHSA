FROM php:8.2-fpm

RUN apt update
RUN apt install -y libpng-dev zip unzip curl git iproute2
RUN docker-php-ext-install pdo pdo_mysql gd

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www
COPY . /var/www

RUN composer install

RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

RUN sed -i 's/listen = 127.0.0.1:9000/listen = 0.0.0.0:9000/' /usr/local/etc/php-fpm.d/www.conf

CMD ["php-fpm"]
