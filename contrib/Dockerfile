FROM php:8.4-fpm

RUN apt-get update && apt-get install -y \
    libzip-dev \
    unzip \
    zip \
    git \
    curl \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_mysql mysqli zip gd \
    && docker-php-ext-enable pdo pdo_mysql mysqli gd

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# COPY ./contrib/php.ini /usr/local/etc/php/php.ini

WORKDIR /var/www

COPY ./composer.json ./composer.lock ./
RUN composer install --no-interaction --prefer-dist --no-dev

COPY . .

RUN chown -R www-data:www-data /var/www

CMD ["php-fpm"]