#FROM php:7.3.11-fpm
#
#COPY composer.lock composer.json /var/www/
#COPY database /var/www/database
#
#WORKDIR /var/www
#
#RUN apt-get update && apt-get -y install git && apt-get -y install zip
#RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
#    && php -r "if (hash_file('sha384', 'composer-setup.php') === 'baf1608c33254d00611ac1705c1d9958c817a1a33bce370c0595974b342601bd80b92a3f46067da89e3b06bff421f182') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;" \
#    && php composer-setup.php \
#    && php -r "unlink('composer-setup.php');" \
#    && php composer.phar install --no-dev --no-scripts \
#    && rm composer.phar
#
#COPY . /var/www
#RUN chown -R www-data:www-data \
#        /var/www/storage
#RUN  apt-get install -y libmcrypt-dev \
#        libmagickwand-dev --no-install-recommends \
#        && pecl install mcrypt-1.0.2 \
#        && docker-php-ext-install pdo_mysql \
#        && docker-php-ext-enable mcrypt
#
#RUN php artisan migrate

FROM composer as composer

WORKDIR /var/www/html/
COPY composer.json composer.lock /var/www/html/
RUN composer install --prefer-dist --no-scripts --no-dev --no-autoloader && rm -rf /root/.composer
COPY . /var/www/html/
RUN composer dump-autoload --no-scripts --no-dev --optimize


FROM php:7.3.11-apache-stretch

RUN apt-get update && apt-get install -y libmcrypt-dev libzip-dev && apt clean
RUN pecl install mcrypt && docker-php-ext-enable mcrypt
RUN apt-get install -y libfreetype6-dev libjpeg62-turbo-dev libmcrypt-dev libpng-dev && apt clean
RUN docker-php-ext-install -j$(nproc) iconv pdo_mysql
RUN docker-php-ext-install mbstring zip exif pcntl
RUN docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/
RUN docker-php-ext-install -j$(nproc) gd

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

COPY . /var/www/html/

COPY --from=composer /var/www/html/ /var/www/html/

COPY vhost.conf /etc/apache2/sites-available/000-default.conf
COPY start.sh /usr/local/bin/start

RUN docker-php-ext-install pdo pdo_mysql pcntl

RUN chown -R www-data:www-data /var/www/html/ \
    && chmod u+x /usr/local/bin/start \
    && a2enmod rewrite

CMD ["/usr/local/bin/start"]
