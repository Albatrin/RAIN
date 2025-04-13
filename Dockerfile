# Izberi osnovno sliko PHP
FROM php:7.4-apache

# Nastavi delovni direktorij
WORKDIR /var/www/html

# Kopiraj vse iz lokalnega direktorija v Docker container
COPY . .

# Nastavi potrebne Apache module
RUN apt-get update && apt-get install -y libpng-dev libjpeg-dev libfreetype6-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd \
    && docker-php-ext-install mysqli

EXPOSE 80
