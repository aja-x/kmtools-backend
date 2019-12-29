FROM composer as composer

WORKDIR /var/www/html/
COPY ../../composer.json composer.lock /var/www/html/
RUN composer install --prefer-dist --no-scripts --no-dev --no-autoloader && rm -rf /root/.composer
COPY ../.. /var/www/html/
RUN composer dump-autoload --no-scripts --no-dev --optimize


FROM php:7.3.11-apache-stretch

RUN apt-get update && apt-get install -y libmcrypt-dev libzip-dev
RUN pecl install mcrypt && docker-php-ext-enable mcrypt
RUN apt-get install -y libfreetype6-dev libjpeg62-turbo-dev libmcrypt-dev libpng-dev
RUN docker-php-ext-install -j$(nproc) iconv pdo pdo_mysql
RUN docker-php-ext-install mbstring zip exif pcntl
RUN docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/
RUN docker-php-ext-install -j$(nproc) gd

RUN apt-get clean && rm -rf /var/lib/apt/lists/*

COPY ../.. /var/www/html/
COPY --from=composer /var/www/html/ /var/www/html/

COPY vhost.conf /etc/apache2/sites-available/000-default.conf
COPY start.sh /usr/local/bin/start

RUN chown -R www-data:www-data /var/www/html/ \
    && chmod u+x /usr/local/bin/start \
    && a2enmod rewrite

CMD ["/usr/local/bin/start"]
