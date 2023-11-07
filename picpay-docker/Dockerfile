FROM php:8.2-fpm

# Copy composer.lock and composer.json
#COPY ../api/composer.lock /var/www/api/

# Set working directory
WORKDIR "/var/www/api"

USER root

# Install dependencies
RUN apt-get update && apt-get install -y \
    git \
    libonig-dev \
    build-essential \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    locales \
    zip \
    jpegoptim optipng pngquant gifsicle \
    vim \
    unzip \
    git \
    curl \
    libzip-dev

ENV ACCEPT_EULA=Y
ENV COMPOSER_ALLOW_SUPERUSER=1

# Install prerequisites required for tools and extensions installed later on.
RUN apt-get update \
    && apt-get install -y apt-transport-https gnupg2 \
    && rm -rf /var/lib/apt/lists/*

# Retrieve the script used to install PHP extensions from the source container.
COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/bin/install-php-extensions

# Install XDebug
RUN pecl install -o -f xdebug

RUN echo "zend_extension=$(find /usr/local/lib/php/extensions/ -name xdebug.so)" | tee /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.mode=coverage,debug" | tee -a /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.client_host=host.docker.internal" | tee -a /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.client_port=9003" | tee -a /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.start_with_request=trigger" | tee -a /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.discover_client_host=1" | tee -a /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.idekey=docker" | tee -a /usr/local/etc/php/conf.d/xdebug.ini

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

## Copy existing application directory contents
# COPY . /var/www
#
## Copy existing application directory permissions
# COPY --chown=www:www . /var/www

# Install extensions
RUN docker-php-ext-install mysqli mbstring zip exif pcntl && docker-php-ext-enable mysqli

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN echo 'alias app="php bin/console"' >> ~/.bashrc

EXPOSE 9000
CMD ["php-fpm"]