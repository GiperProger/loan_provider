FROM php:8.2-fpm

# Установим необходимые зависимости
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    curl \
    libicu-dev \
    libonig-dev \
    libzip-dev \
    && docker-php-ext-install intl mbstring zip pdo_mysql \
    && docker-php-ext-enable intl

# Установим Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Установим рабочую директорию
WORKDIR /var/www/html