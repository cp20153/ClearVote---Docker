FROM php:7.4-apache

# Install required PHP extensions
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Enable Apache modules
RUN a2enmod mpm_prefork
RUN a2enmod php7

# Copy custom Apache config
COPY ./apache2.conf /etc/apache2/apache2.conf

# Copy application files
COPY ./ /var/www/html/

# Set working directory
WORKDIR /var/www/html/
