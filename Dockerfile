# Use the official PHP 7.4 image as base
FROM php:8.1.19-fpm-buster

# Install necessary librarie

RUN apt-get clean && apt-get update && apt-get install -y \
    libzip-dev \
    libonig-dev \
    zip \
    unzip \
    git \
    curl

# Install necessary PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring zip exif pcntl

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Set working directory
WORKDIR /var/www

# Remove the default Nginx public directory and replace with our application
RUN rm -rf /var/www/html

# Copy over your application code
COPY . /var/www

# Set correct permissions for the storage directory
RUN chown -R www-data:www-data \
    /var/www/storage \
    /var/www/bootstrap/cache

# Install Laravel dependencies using Composer
RUN composer install

CMD php artisan serve --host=0.0.0.0 --port=8000

EXPOSE 8000
