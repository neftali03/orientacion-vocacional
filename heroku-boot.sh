#!/bin/sh

# Ensure writable directories
mkdir -p storage/framework/sessions storage/framework/views storage/framework/cache storage/logs bootstrap/cache
# Set permissions
chmod -R 775 storage bootstrap/cache

# Clear and cache config if needed
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Start the web server
exec vendor/bin/heroku-php-apache2 public/