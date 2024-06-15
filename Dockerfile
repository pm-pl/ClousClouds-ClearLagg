# Use the official PHP 8.1 CLI image as a base
FROM php:8.1-cli

# Install system dependencies
RUN apt-get update \
    && apt-get install -y --no-install-recommends \
        libzip-dev \
        unzip \
        git \
        autoconf \
        g++ \
        make

# Install PHP extensions
RUN pecl install chunkutils2 \
    && docker-php-ext-enable chunkutils2 \
    && docker-php-ext-install mbstring

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set the working directory
WORKDIR /app

# Copy application files
COPY . /app

# Install Composer dependencies
RUN composer install --no-progress --prefer-dist --optimize-autoloader

# Command to run tests
CMD ["./vendor/bin/phpunit", "--coverage-text"]
