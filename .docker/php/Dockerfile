FROM php:8.3-fpm

RUN docker-php-ext-install pdo_mysql mysqli

RUN pecl install xdebug && docker-php-ext-enable xdebug
COPY docker-php-ext-xdebug.ini /usr/local/etc/php/conf.d/

RUN docker-php-ext-configure pcntl --enable-pcntl \
  && docker-php-ext-install pcntl;