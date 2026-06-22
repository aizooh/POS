#!/bin/bash
set -e

# Ensure storage directories exist with correct permissions
# Use sudo to escalate permissions for mkdir and chmod
sudo mkdir -p /var/www/storage/logs
sudo mkdir -p /var/www/storage/framework/cache
sudo mkdir -p /var/www/storage/framework/sessions
sudo mkdir -p /var/www/storage/framework/views
sudo mkdir -p /var/www/bootstrap/cache
sudo chmod -R 775 /var/www/storage /var/www/bootstrap/cache
sudo chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

php artisan migrate --force
php artisan config:cache
php artisan route:cache
php artisan view:cache

php-fpm
