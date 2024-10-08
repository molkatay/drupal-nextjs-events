FROM php:8.3-fpm


RUN apt-get update && \
    apt-get install -y --no-install-recommends \
        libzip-dev \
        libz-dev \
        libzip-dev \
        libjpeg-dev \
    libwebp-dev \
        libpng-dev \
        libfreetype6-dev \
        libssl-dev \
        libxml2-dev \
        libreadline-dev \
        git \
        unzip \
        supervisor \
      curl

# Install the FTP extension
RUN apt-get update && apt-get install -y \
    libcurl4-openssl-dev \
    && docker-php-ext-install ftp
# Add NodeSource repository for Node.js 18 and install Node.js
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - && \
    apt-get install -y nodejs

# Verify Node.js installation
RUN node -v && npm -v
#####################################
# PHP Extensions
#####################################


# Install the PHP bcmath extension
RUN docker-php-ext-install bcmath

# Install for image manipulation
RUN docker-php-ext-install exif

# Install the PHP graphics library
RUN docker-php-ext-configure gd \
    --with-freetype \
    --with-jpeg \
     --with-webp
RUN docker-php-ext-install gd

# Install the PHP intl extention
RUN docker-php-ext-install intl


# Install the PHP opcache extention
RUN docker-php-ext-install opcache

# Install APCu extension
RUN pecl install apcu \
    && docker-php-ext-enable apcu

# Install the PHP pcntl extention
RUN docker-php-ext-install pcntl

# Install Postgre PDO
RUN apt-get install -y libpq-dev \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install pdo pdo_pgsql pgsql

# install  and enable XDebug
RUN pecl install xdebug
RUN docker-php-ext-enable xdebug

# Install the PHP zip extention
RUN docker-php-ext-install zip

# Install Redis extension for PHP
RUN pecl install redis && \
    docker-php-ext-enable redis
#####################################
# Composer
#####################################
RUN curl -s http://getcomposer.org/installer | php && \
    mv composer.phar /usr/local/bin/composer

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
ENV COMPOSER_ALLOW_SUPERUSER=1
# Allow the necessary Composer plugin
RUN composer global config --no-plugins allow-plugins.dealerdirect/phpcodesniffer-composer-installer true

# Install coder and PHP_CodeSniffer
RUN mkdir -p /root/.composer && composer global require drupal/coder && composer global require squizlabs/php_codesniffer

# Install PHPCBF
RUN composer global require squizlabs/php_codesniffer

# Add Composer's global bin directory to the PATH
ENV PATH="/root/.composer/vendor/bin:${PATH}"

RUN export PATH="$PATH:$HOME/.config/composer/vendor/bin"

# Copy php.ini configuration
COPY conf/php/php.ini /usr/local/etc/php/conf.d/php.ini

# Copy xdebug configuration
COPY conf/php/xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini
