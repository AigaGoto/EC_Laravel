FROM php:7.4-apache

RUN apt update \
        && apt install -y \
            g++ \
            libicu-dev \
            libpq-dev \
            libzip-dev \
            zip \
            zlib1g-dev \
            git \
            unzip \
            nodejs \
            npm \
        && docker-php-ext-install \
            intl \
            opcache \
            pdo \
            pdo_mysql \
            mysqli 
RUN a2enmod rewrite \
    && service apache2 restart
WORKDIR /var/www/ec_Laravel

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
