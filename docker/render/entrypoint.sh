#!/bin/sh
set -e

cd /var/www

# Generate app key if not already set (Render injects APP_KEY as an env var normally,
# but this is a safety net for first deploys)
if [ -z "$APP_KEY" ]; then
  php artisan key:generate --force
fi

php artisan config:cache
php artisan route:cache
php artisan view:cache

# Run migrations automatically on every deploy (safe with --force in production)
php artisan migrate --force
php artisan db:seed --force

# Hand off to supervisord which runs nginx + php-fpm
exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf