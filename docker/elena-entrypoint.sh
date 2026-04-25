#!/usr/bin/env bash
# Elena WordPress entrypoint:
#  1) Lets the upstream wordpress entrypoint copy core files / generate wp-config.php
#  2) Waits for MySQL
#  3) If wp_options table is missing, imports /opt/elena/init.sql AND rewrites URLs
#  4) Hands off to apache2-foreground

set -e

DB_USER="${WORDPRESS_DB_USER:-elena}"
DB_PASS="${WORDPRESS_DB_PASSWORD:-}"
DB_NAME="${WORDPRESS_DB_NAME:-elena_wp}"
DB_HOST_FULL="${WORDPRESS_DB_HOST:-db:3306}"
DB_HOST="${DB_HOST_FULL%%:*}"
DB_PORT="${DB_HOST_FULL#*:}"
[ "$DB_PORT" = "$DB_HOST" ] && DB_PORT=3306

SEED_FILE="/opt/elena/init.sql"
SEED_URL_FROM="${ELENA_SEED_FROM_URL:-http://elena.local}"
SEED_URL_TO="${WP_HOME:-}"

log() { printf '[elena] %s\n' "$*"; }

# 1) Run upstream entrypoint with a benign command so it sets up files and exits.
log "Running upstream WordPress setup..."
/usr/local/bin/docker-entrypoint.sh true || true

# 2) Wait for MySQL
log "Waiting for MySQL at $DB_HOST:$DB_PORT ..."
for i in $(seq 1 60); do
    if mysqladmin ping -h "$DB_HOST" -P "$DB_PORT" -u "$DB_USER" -p"$DB_PASS" --silent >/dev/null 2>&1; then
        log "MySQL reachable."
        break
    fi
    sleep 2
done

# 3) If wp_options is missing, import the seed and rewrite URLs
TABLES_EXIST=$(mysql -h "$DB_HOST" -P "$DB_PORT" -u "$DB_USER" -p"$DB_PASS" "$DB_NAME" -N -B \
    -e "SELECT COUNT(*) FROM information_schema.tables WHERE table_schema='${DB_NAME}' AND table_name='wp_options';" 2>/dev/null || echo 0)

if [ "$TABLES_EXIST" = "0" ] && [ -f "$SEED_FILE" ]; then
    log "wp_options missing — importing seed from $SEED_FILE ..."
    mysql -h "$DB_HOST" -P "$DB_PORT" -u "$DB_USER" -p"$DB_PASS" "$DB_NAME" < "$SEED_FILE"
    log "Seed imported."

    if [ -n "$SEED_URL_TO" ] && [ "$SEED_URL_TO" != "$SEED_URL_FROM" ]; then
        log "Rewriting URLs: $SEED_URL_FROM -> $SEED_URL_TO"
        cd /var/www/html
        wp --allow-root search-replace "$SEED_URL_FROM" "$SEED_URL_TO" --all-tables --skip-columns=guid || true
        host_from="${SEED_URL_FROM#http://}"; host_from="${host_from#https://}"
        host_to="${SEED_URL_TO#http://}";     host_to="${host_to#https://}"
        if [ "$host_from" != "$host_to" ]; then
            wp --allow-root search-replace "//$host_from" "//$host_to" --all-tables --skip-columns=guid || true
        fi
        wp --allow-root cache flush || true
        wp --allow-root rewrite flush --hard || true
        log "URL rewrite complete."
    fi
elif [ "$TABLES_EXIST" != "0" ]; then
    log "wp_options exists — DB already initialized. Skipping import."
else
    log "No seed file at $SEED_FILE — skipping import."
fi

log "Starting: $*"
exec "$@"
