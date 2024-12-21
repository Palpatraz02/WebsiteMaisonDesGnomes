FROM php:8.0-apache
WORKDIR /var/www/html
RUN apt-get update && apt-get install -y libmariadb-dev libpng-dev libjpeg-dev
RUN docker-php-ext-install mysqli
RUN docker-php-ext-configure gd --with-jpeg
RUN docker-php-ext-install gd

RUN useradd -ms /bin/bash admin
RUN chown -R admin:admin /var/www/html
RUN chmod 755 /var/www/html
USER admin