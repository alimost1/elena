FROM wordpress:php8.2-apache

# Copy the production wp-config into the container as wp-config.php
COPY wp-config-production.php /var/www/html/wp-config.php

# Copy custom theme
COPY wp-content/themes/elena/ /var/www/html/wp-content/themes/elena/

# Copy plugins (Elementor, Elementor Pro, WooCommerce)
COPY wp-content/plugins/ /var/www/html/wp-content/plugins/

# Copy any mu-plugins if they exist
# COPY wp-content/mu-plugins/ /var/www/html/wp-content/mu-plugins/

# Set correct ownership for Apache
RUN chown -R www-data:www-data /var/www/html/wp-content

# WordPress operates on port 80 by default
EXPOSE 80
