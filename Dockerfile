FROM php:8.2-apache

# Install SQLite and extensions
RUN apt-get update && apt-get install -y \
    libsqlite3-dev \
    zlib1g-dev \
    && docker-php-ext-install pdo pdo_sqlite

FROM php:8.2-apache

# Install SQLite support
RUN apt-get update && apt-get install -y \
    libsqlite3-dev \
    zlib1g-dev \
    && docker-php-ext-install pdo pdo_sqlite

# Enable Apache rewrite
RUN a2enmod rewrite

# Allow .htaccess overrides
RUN sed -i 's/AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf

# Copy project files
COPY . /var/www/html/

# Set permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

WORKDIR /var/www/html/
EXPOSE 80
