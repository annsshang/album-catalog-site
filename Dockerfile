FROM php:8.2-apache

# Install system packages required to compile PHP SQLite extensions
RUN apt-get update && apt-get install -y \
    libsqlite3-dev \
    zlib1g-dev \
    && docker-php-ext-install pdo pdo_sqlite

# Enable Apache rewrite (optional but useful)
RUN a2enmod rewrite

# Copy project files
COPY . /var/www/html/
WORKDIR /var/www/html/

EXPOSE 80
