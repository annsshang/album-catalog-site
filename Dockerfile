FROM php:8.2-apache

# Enable Apache rewrite (optional but commonly needed)
RUN a2enmod rewrite

# Install SQLite PDO extension
RUN docker-php-ext-install pdo pdo_sqlite

# Copy all project files into the container
COPY . /var/www/html/

# Set working directory
WORKDIR /var/www/html/

# The server will run on port 80
EXPOSE 80
