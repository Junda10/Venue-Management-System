# Use an official PHP runtime
FROM php:8.2-apache

# Install the mysqli extension (required for your DB connection)
RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli

# Set the working directory to the web root
WORKDIR /var/www/html

# Copy the current directory contents into the container at /var/www/html
COPY . /var/www/html/

# Expose port 80 for the web server
EXPOSE 80

# Use the default production configuration
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"

# (Optional) Update permissions if necessary, usually standard user is fine but www-data is the apache user
RUN chown -R www-data:www-data /var/www/html

# Start Apache in the foreground
CMD ["apache2-foreground"]
