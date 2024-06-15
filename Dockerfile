# Gunakan image PHP 8.1 yang sesuai
FROM php:8.1-cli

# Instal ekstensi PHP yang diperlukan
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    libicu-dev \
    libonig-dev \
    libxslt-dev \
    && docker-php-ext-install -j$(nproc) \
    mbstring \
    xml \
    chunkutils2

# Salin sumber kode dan plugin.yml ke dalam container
COPY src /usr/src/myapp/src
COPY plugin.yml /usr/src/myapp/

# Salin PocketMine-MP.phar ke dalam container
ADD https://github.com/pmmp/PocketMine-MP/releases/latest/download/PocketMine-MP.phar /usr/src/myapp/PocketMine-MP.phar

# Set workdir ke direktori sumber
WORKDIR /usr/src/myapp

# Build plugin menjadi .phar
RUN mkdir -p plugins/ClearLagg \
    && cp -R src/* plugins/ClearLagg/ \
    && cp plugin.yml plugins/ClearLagg/ \
    && php PocketMine-MP.phar --make-plugin ClearLagg \
    && mv ClearLagg.phar /usr/src/myapp/ClearLagg.phar

CMD ["php", "-v"]
