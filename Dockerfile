# PHP 8.1 Dockefile template for development
#
# New project template of PHP 8.1 Dockerfile for development. It includes optional extensions (intl, gd, exif, bcmath,
# zip, pdo, pdo_mysql, mysqli, mbstring, ffmpeg), xdebug 3 and latest composer.
#
# Original gist: https://gist.github.com/postfriday/0488dbd444a3e0e02e475099f34d4b71/raw
#
FROM php:8.1-cli-alpine

WORKDIR /var/www/html

# Use the default development configuration
RUN mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"

# Update repository
RUN set -xe \
    && apk update \
    && apk upgrade

# Fixed Intl version
#RUN apk add libintl icu icu-dev \
#    && docker-php-ext-install intl \
#    && apk del icu-dev

# Install GD
#RUN apk add libpng-dev jpeg-dev freetype-dev libjpeg-turbo-dev \
#    && docker-php-ext-configure gd --with-freetype=/usr/include/ --with-jpeg=/usr/include/ \
#    && docker-php-ext-install -j$(nproc) gd

# Install Exif extension
#RUN docker-php-ext-install -j$(nproc) exif

# Install Bcmath extension
#RUN docker-php-ext-install -j$(nproc) bcmath

# Install Zip extension
#RUN apk add libzip-dev \
#    && docker-php-ext-install -j$(nproc) zip

# Install PDO
#RUN docker-php-ext-install -j$(nproc) pdo_mysql

# Install MySQLi extension
#RUN docker-php-ext-install -j$(nproc) mysqli

## Install ffmpeg
#RUN apk add ffmpeg

# Install mbstring
#RUN apk add oniguruma-dev \
#  && docker-php-ext-install -j$(nproc) mbstring

# Install Composer
#
# If set to 1, this env disables the warning about running commands as root/super user. It also disables automatic
# clearing of sudo sessions, so you should really only set this if you use Composer as a super user at all times like
# in docker containers.
#
# https://getcomposer.org/doc/03-cli.md#composer-allow-superuser
ENV COMPOSER_ALLOW_SUPERUSER=1
# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Install xdebug
#ENV XDEBUGINI_PATH=/usr/local/etc/php/conf.d/xdebug.ini
#RUN apk add --virtual .phpize-deps $PHPIZE_DEPS \
#    && pecl install xdebug \
#    && rm -rf /tmp/pear \
#    && echo "zend_extension="`find /usr/local/lib/php/extensions/ -iname 'xdebug.so'` > $XDEBUGINI_PATH
#RUN echo "xdebug.mode=debug" >> $XDEBUGINI_PATH \
#    && echo "xdebug.client_host=docker.for.mac.host.internal" >> $XDEBUGINI_PATH \
#    && echo "xdebug.start_with_request=yes" >> $XDEBUGINI_PATH

# Clear
RUN rm -rf /tmp/* /var/cache/apk/*

#RUN sed -i 's,^post_max_size =.*$,post_max_size = 500M,' /usr/local/etc/php/php.ini \
#    && sed -i 's,^upload_max_filesize =.*$,upload_max_filesize = 500M,' /usr/local/etc/php/php.ini \
#    && sed -i 's,^memory_limit =.*$,memory_limit = 512M,' /usr/local/etc/php/php.ini