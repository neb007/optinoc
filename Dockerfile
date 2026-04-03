FROM php:7.4-fpm

# Install system dependencies + nginx
RUN apt-get update && apt-get install -y \
    nginx gettext-base \
    libfreetype6-dev libjpeg62-turbo-dev libpng-dev libzip-dev \
    libmagickwand-dev libonig-dev libxml2-dev unzip curl wget \
    && rm -rf /var/lib/apt/lists/*

# Install PHP extensions required by WordPress
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) \
    gd mysqli zip exif intl mbstring xml opcache \
    && pecl install imagick && docker-php-ext-enable imagick

# PHP configuration for Railway
RUN { \
    echo 'upload_max_filesize = 256M'; \
    echo 'post_max_size = 256M'; \
    echo 'memory_limit = 512M'; \
    echo 'max_execution_time = 300'; \
    echo 'max_input_time = 300'; \
} > /usr/local/etc/php/conf.d/railway.ini

# Download WordPress core (without wp-content, stored separately)
RUN wget -q https://wordpress.org/latest.tar.gz -O /tmp/wordpress.tar.gz \
    && tar -xzf /tmp/wordpress.tar.gz -C /tmp \
    && cp -a /tmp/wordpress/. /var/www/html/ \
    && rm -rf /tmp/wordpress /tmp/wordpress.tar.gz

# Save default wp-content for first-run initialization
RUN cp -a /var/www/html/wp-content /var/www/html/wp-content-default

# Copy mu-plugin to default content (will be copied to volume on first run)
RUN mkdir -p /var/www/html/wp-content-default/mu-plugins
COPY mcp-expose-abilities.php /var/www/html/wp-content-default/mu-plugins/mcp-expose-abilities.php

# Copy wp-config and nginx config
COPY wp-config.php /var/www/html/wp-config.php
COPY nginx.conf /etc/nginx/conf.d/default.conf.template

# Remove default nginx config
RUN rm -f /etc/nginx/sites-enabled/default

# Set permissions
RUN chown -R www-data:www-data /var/www/html

# Copy and set start script
COPY start.sh /start.sh
RUN chmod +x /start.sh

ENV PORT=8080
EXPOSE 8080

CMD ["/start.sh"]
