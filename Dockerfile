FROM php:8.4-rc-apache

# set working directory
WORKDIR /var/www/html

# Install system deps for MariaDB, ICU and GD
RUN apt-get update -y \
 && apt-get install -y --no-install-recommends \
      libmariadb-dev \
      libicu-dev \
      libfreetype6-dev \
      libjpeg62-turbo-dev \
      libpng-dev \
 && rm -rf /var/lib/apt/lists/*

# Enable GD (with Freetype & JPEG) and your other extensions
RUN docker-php-ext-configure gd \
      --with-freetype \
      --with-jpeg \
 && docker-php-ext-install -j"$(nproc)" gd \
 && docker-php-ext-install mysqli pdo pdo_mysql intl

# Enable Apache rewrite
RUN a2enmod rewrite

# Copy your application code
COPY . /var/www/html
