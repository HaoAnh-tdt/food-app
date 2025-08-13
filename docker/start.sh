#!/bin/bash

# Set default port if not provided
export PORT=${PORT:-8080}

# Replace $PORT in nginx config
sed -i "s/\$PORT/$PORT/g" /etc/nginx/sites-available/default

# Create necessary directories
mkdir -p /var/run/php /var/log/supervisor

# Set permissions
chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache
chmod -R 775 /var/www/storage /var/www/bootstrap/cache

# Run Laravel commands
cd /var/www
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Start supervisor
exec /usr/bin/supervisord -n -c /etc/supervisor/conf.d/supervisord.conf
