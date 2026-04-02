<?php
/** WordPress Database Settings - Using Railway environment variables */
define( 'DB_NAME', getenv('MYSQL_DATABASE') ?: getenv('WORDPRESS_DB_NAME') ?: 'railway' );
define( 'DB_USER', getenv('MYSQL_USER') ?: getenv('WORDPRESS_DB_USER') ?: 'root' );
define( 'DB_PASSWORD', getenv('MYSQL_PASSWORD') ?: getenv('WORDPRESS_DB_PASSWORD') ?: '' );
define( 'DB_HOST', (getenv('MYSQL_HOST') ?: getenv('WORDPRESS_DB_HOST') ?: 'localhost') . ':' . (getenv('MYSQL_PORT') ?: '3306') );
define( 'DB_CHARSET', 'utf8mb4' );
define( 'DB_COLLATE', '' );

/** Table prefix from OVH backup */
$table_prefix = 'wor9551_';

/** Authentication Unique Keys and Salts - Generate new ones */
define( 'AUTH_KEY',         getenv('AUTH_KEY')         ?: 'r8#Kj!mN2$pQ9wLx&vZ3tY6uI0oP5aS' );
define( 'SECURE_AUTH_KEY',  getenv('SECURE_AUTH_KEY')  ?: 'f4$Gd!hJ7kL0nM3pR6sT9wX2zA5cE8bU' );
define( 'LOGGED_IN_KEY',    getenv('LOGGED_IN_KEY')    ?: 'q1&We!rT4yU7iO0pA3sD6fG9hJ2kL5zX' );
define( 'NONCE_KEY',        getenv('NONCE_KEY')        ?: 'c8$Vb!nM2lK5jH0gF3dS6aP9oI7uY4tR' );
define( 'AUTH_SALT',        getenv('AUTH_SALT')        ?: 'e1%Wq!rT4yU7iO0pA3sD6fG9hJ2kL5nM' );
define( 'SECURE_AUTH_SALT', getenv('SECURE_AUTH_SALT') ?: 'x8^Zc!vB2nM5lK0jH3gF6dS9aP7oI4uY' );
define( 'LOGGED_IN_SALT',   getenv('LOGGED_IN_SALT')   ?: 't1*Re!wQ4yU7iO0pA3sD6fG9hJ2kL5mN' );
define( 'NONCE_SALT',       getenv('NONCE_SALT')       ?: 'b8@Nx!cV2mL5kJ0hG3fD6sA9pO7iU4yT' );

/** Force HTTPS behind Railway's proxy */
if ( isset( $_SERVER['HTTP_X_FORWARDED_PROTO'] ) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https' ) {
    $_SERVER['HTTPS'] = 'on';
}

/** WordPress URLs */
if ( getenv('WP_HOME') ) {
    define( 'WP_HOME', getenv('WP_HOME') );
}
if ( getenv('WP_SITEURL') ) {
    define( 'WP_SITEURL', getenv('WP_SITEURL') );
}

/** WordPress Debug */
define( 'WP_DEBUG', getenv('WP_DEBUG') === 'true' );
define( 'WP_DEBUG_LOG', getenv('WP_DEBUG') === 'true' );

/** Filesystem method for Railway (no FTP) */
define( 'FS_METHOD', 'direct' );

/** Absolute path to the WordPress directory */
if ( ! defined( 'ABSPATH' ) ) {
    define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files */
require_once ABSPATH . 'wp-settings.php';
