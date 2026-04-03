#!/bin/bash

# Initialize wp-content from defaults if volume is empty (first run only)
if [ ! -f /var/www/html/wp-content/index.php ]; then
    echo "First run: initializing wp-content from defaults..."
    cp -a /var/www/html/wp-content-default/. /var/www/html/wp-content/
    chown -R www-data:www-data /var/www/html/wp-content
fi

# Always ensure mu-plugins are up to date from build
mkdir -p /var/www/html/wp-content/mu-plugins
cp -f /var/www/html/wp-content-default/mu-plugins/* /var/www/html/wp-content/mu-plugins/ 2>/dev/null || true
chown -R www-data:www-data /var/www/html/wp-content/mu-plugins

# Replace $PORT in nginx config with actual PORT value
envsubst '$PORT' < /etc/nginx/conf.d/default.conf.template > /etc/nginx/conf.d/default.conf

# Start PHP-FPM in background
php-fpm -D

# Start Nginx in foreground
nginx -g 'daemon off;'
