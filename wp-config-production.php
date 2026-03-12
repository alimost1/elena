<?php
/**
 * Production wp-config.php for Elena — reads everything from environment variables.
 * Set these values in Coolify's dashboard under your service's Environment Variables.
 */

// ** Database settings ** //
define( 'DB_NAME',     getenv('WORDPRESS_DB_NAME')     ?: 'elena_wp' );
define( 'DB_USER',     getenv('WORDPRESS_DB_USER')     ?: 'elena' );
define( 'DB_PASSWORD', getenv('WORDPRESS_DB_PASSWORD') ?: '' );
define( 'DB_HOST',     getenv('WORDPRESS_DB_HOST')     ?: 'db:3306' );
define( 'DB_CHARSET',  'utf8mb4' );
define( 'DB_COLLATE',  '' );

// ** Site URLs (set in Coolify env) ** //
if ( getenv('WP_HOME') ) {
    define( 'WP_HOME',    getenv('WP_HOME') );
    define( 'WP_SITEURL', getenv('WP_SITEURL') ?: getenv('WP_HOME') );
}

// ** Authentication keys and salts ** //
// Generate fresh ones at https://api.wordpress.org/secret-key/1.1/salt/
// Then paste them in Coolify's env vars, or replace the defaults below.
define( 'AUTH_KEY',         getenv('AUTH_KEY')         ?: 'put-unique-phrase-here' );
define( 'SECURE_AUTH_KEY',  getenv('SECURE_AUTH_KEY')  ?: 'put-unique-phrase-here' );
define( 'LOGGED_IN_KEY',    getenv('LOGGED_IN_KEY')    ?: 'put-unique-phrase-here' );
define( 'NONCE_KEY',        getenv('NONCE_KEY')        ?: 'put-unique-phrase-here' );
define( 'AUTH_SALT',        getenv('AUTH_SALT')        ?: 'put-unique-phrase-here' );
define( 'SECURE_AUTH_SALT', getenv('SECURE_AUTH_SALT') ?: 'put-unique-phrase-here' );
define( 'LOGGED_IN_SALT',   getenv('LOGGED_IN_SALT')   ?: 'put-unique-phrase-here' );
define( 'NONCE_SALT',       getenv('NONCE_SALT')       ?: 'put-unique-phrase-here' );

// ** Table prefix ** //
$table_prefix = getenv('WORDPRESS_TABLE_PREFIX') ?: 'wp_';

// ** Debugging ** //
define( 'WP_DEBUG',         (bool) getenv('WP_DEBUG') );
define( 'WP_DEBUG_LOG',     (bool) getenv('WP_DEBUG_LOG') );
define( 'WP_DEBUG_DISPLAY', false );

// ** Performance & Security ** //
define( 'WP_ENVIRONMENT_TYPE', 'production' );
define( 'DISALLOW_FILE_EDIT', true );    // Disable theme/plugin editor in admin
define( 'WP_AUTO_UPDATE_CORE', false );  // Core is managed by Docker image version
define( 'FS_METHOD', 'direct' );

// ** Reverse Proxy / SSL (Coolify uses Traefik) ** //
if ( isset( $_SERVER['HTTP_X_FORWARDED_PROTO'] ) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https' ) {
    $_SERVER['HTTPS'] = 'on';
}

/* That's all, stop editing! Happy publishing. */
if ( ! defined( 'ABSPATH' ) ) {
    define( 'ABSPATH', __DIR__ . '/' );
}
require_once ABSPATH . 'wp-settings.php';
