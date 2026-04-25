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

# Custom theme + plugins + mu-plugins + languages
COPY wp-content/themes/elena/ /var/www/html/wp-content/themes/elena/
COPY wp-content/plugins/ /var/www/html/wp-content/plugins/
COPY wp-content/mu-plugins* /var/www/html/wp-content/mu-plugins/
COPY wp-content/languages* /var/www/html/wp-content/languages/

# Bake the DB seed into the image so it's available to the auto-import entrypoint.
COPY db-init/init.sql /opt/elena/init.sql

# Entrypoint that imports the DB on first deploy if empty, then runs Apache.
COPY docker/elena-entrypoint.sh /usr/local/bin/elena-entrypoint.sh
RUN chmod +x /usr/local/bin/elena-entrypoint.sh

RUN chown -R www-data:www-data /var/www/html/wp-content

EXPOSE 80

ENTRYPOINT ["elena-entrypoint.sh"]
CMD ["apache2-foreground"]
