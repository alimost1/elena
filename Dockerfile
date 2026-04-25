FROM wordpress:php8.2-apache

# Install useful tools (mysql client for DB tasks, wp-cli for migrations / search-replace)
RUN apt-get update && apt-get install -y --no-install-recommends \
        curl less default-mysql-client \
    && rm -rf /var/lib/apt/lists/* \
    && curl -fsSL -o /usr/local/bin/wp \
        https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar \
    && chmod +x /usr/local/bin/wp

# Use our env-driven wp-config in production
COPY wp-config-production.php /var/www/html/wp-config.php

# Copy custom theme (the elena theme)
COPY wp-content/themes/elena/ /var/www/html/wp-content/themes/elena/

# Copy plugins (must be tracked in git — see .gitignore)
COPY wp-content/plugins/ /var/www/html/wp-content/plugins/

# Copy mu-plugins if present (force-loaded utility plugins)
COPY wp-content/mu-plugins* /var/www/html/wp-content/mu-plugins/

# Copy bundled language files (Arabic, French, etc.)
COPY wp-content/languages* /var/www/html/wp-content/languages/

# Set correct ownership for Apache
RUN chown -R www-data:www-data /var/www/html/wp-content

EXPOSE 80
