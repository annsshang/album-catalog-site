FROM php:8.2-apache

# Install SQLite and extensions
RUN apt-get update && apt-get install -y \
    libsqlite3-dev \
    zlib1g-dev \
    && docker-php-ext-install pdo pdo_sqlite

# Enable Apache rewrite module
RUN a2enmod rewrite

# Allow .htaccess overrides
RUN sed -i 's/AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf

# Copy project files into container
COPY . /var/www/html/

# Set permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Set working directory
WORKDIR /var/www/html/

# Expose port 80
EXPOSE 80
