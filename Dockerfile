# Use official PHP 8.2 with Apache
FROM php:8.2-apache

# Install SQLite support
RUN apt-get update && apt-get install -y libsqlite3-dev zlib1g-dev \
    && docker-php-ext-install pdo pdo_sqlite

# Enable Apache rewrite module
RUN a2enmod rewrite

# Copy project files into container
COPY . /var/www/html/

# Set ownership and permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Ensure Apache serves PHP from the root
WORKDIR /var/www/html/

# Expose port 80 (Render maps automatically)
EXPOSE 80

# Start Apache in foreground
CMD ["apache2-foreground"]
