FROM php:8.1-rc-fpm-bullseye

RUN echo 'deb [trusted=yes] https://repo.symfony.com/apt/ /' | tee /etc/apt/sources.list.d/symfony-cli.list \
 && apt-get update \
 && apt-get install -y curl git symfony-cli unzip

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer --version

# Set timezone
RUN rm /etc/localtime
RUN ln -s /usr/share/zoneinfo/Europe/Berlin /etc/localtime
RUN "date"

# set up php
RUN echo "error_reporting = E_ALL" >> /usr/local/etc/php/php.ini \
 && echo "display_startup_errors = On" >> /usr/local/etc/php.ini \
 && echo "display_errors = On" >> /usr/local/etc/php/php.ini \
 && echo "date.timezone=\"Europe/Berlin\"" >> /usr/local/etc/php/php.ini

RUN pecl install xdebug && docker-php-ext-enable xdebug

ADD entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]
CMD ["symfony","server:start", "--port", "80", "--no-tls"]

VOLUME /www
WORKDIR /www
EXPOSE 80
