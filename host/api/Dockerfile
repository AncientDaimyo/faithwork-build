FROM php:8.3-apache

ADD --chmod=0755 https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/
RUN chmod +x /usr/local/bin/install-php-extensions

# Install additional PHP modules
RUN install-php-extensions pdo_mysql mysqli simplexml

# Enable Apache mod_rewrite
RUN a2enmod rewrite
