FROM php:7.4-apache-buster

# Install any required extensions
RUN apt-get update && apt-get install -y git \
    && docker-php-ext-install pdo pdo_mysql mysqli \
    && a2enmod rewrite

# Set server name to suppress warning message
RUN echo 'ServerName localhost' >> /etc/apache2/apache2.conf

# Adjust permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Copy application files
COPY . /var/www/html/

# Expose port 80
EXPOSE 80

# Optional: Add a health check
HEALTHCHECK --interval=30s --timeout=30s --start-period=5s --retries=3 \
  CMD curl -f http://localhost/ || exit 1
