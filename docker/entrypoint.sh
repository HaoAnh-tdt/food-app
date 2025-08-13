#!/bin/bash
set -e

: "${PORT:=8080}"

# render nginx template -> nginx conf
envsubst '${PORT}' < /etc/nginx/sites-available/default.template > /etc/nginx/sites-available/default

# ensure storage link (bạn có thể bỏ nếu đã xử lý)
if [ ! -L /var/www/public/storage ]; then
  php artisan storage:link || true
fi

# config cache (tuỳ bạn muốn)
php artisan config:cache || true
php artisan route:cache || true
php artisan view:cache || true

# start supervisord (sẽ chạy nginx + php-fpm)
exec /usr/bin/supervisord -n -c /etc/supervisor/conf.d/supervisord.conf
