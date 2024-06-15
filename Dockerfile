FROM php:8.1-cli

# Install dependencies and PHP extensions
RUN apt-get update && apt-get install -y \
    libzip-dev \
    unzip \
    git \
    autoconf \
    g++ \
    make \
    && pecl install chunkutils2 \
    && docker-php-ext-enable chunkutils2 \
    && docker-php-ext-install mbstring

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /app

# Copy application files
COPY . /app

# Install Composer dependencies
RUN composer install --no-progress --prefer-dist --optimize-autoloader

# Run PHPUnit tests
CMD ["./vendor/bin/phpunit", "--coverage-text"]
