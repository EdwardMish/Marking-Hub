FROM php:7.2-apache
RUN apt-get update -y && apt-get install -y openssl zip unzip git libpng-dev

RUN docker-php-ext-install gd pdo mbstring zip pdo_mysql
COPY apache2.conf /etc/apache2/apache2.conf
RUN  rm /etc/apache2/sites-available/000-default.conf \
         && rm /etc/apache2/sites-enabled/000-default.conf

RUN yes | pecl install xdebug \
    && echo "zend_extension=$(find /usr/local/lib/php/extensions/ -name xdebug.so)" > /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.remote_enable=on" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.client_port=9003" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.mode=debug" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.discover_client_host=1" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.idekey=PHPSTORM" >> /usr/local/etc/php/conf.d/xdebug.ini

# Enable rewrite module
RUN a2enmod rewrite

WORKDIR /var/www/html

# Download and Install Composer
RUN curl -s http://getcomposer.org/installer | php \
    && mv composer.phar /usr/local/bin/composer

# Add vendor binaries to PATH
ENV PATH=/var/www/html/vendor/bin:$PATH

ONBUILD COPY . /var/www/html

ONBUILD RUN php composer.phar install

# Configure directory permissions for the web server
ONBUILD RUN chgrp -R www-data storage /var/www/html/bootstrap/cache
ONBUILD RUN chmod -R ug+rwx storage /var/www/html/bootstrap/cache

ONBUILD RUN chgrp -R www-data storage /var/www/html/storage
ONBUILD RUN chmod -R ug+rwx storage /var/www/html/storage

# Configure data volume
ONBUILD VOLUME /var/www/html/storage/app
ONBUILD VOLUME /var/www/html/storage/framework/sessions
ONBUILD VOLUME /var/www/html/storage/logs

ONBUILD RUN php artisan migrate:fresh --seed