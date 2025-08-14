#!/bin/bash
set -e

: "${PORT:=8000}"

# nếu có secret .env từ Render, copy vào (tuỳ bạn cấu hình Render)
if [ -f /etc/secrets/.env ]; then
  cp /etc/secrets/.env /var/www/.env || true
fi

# Nếu không có .env thì dùng env.example tạm (debug)
if [ ! -f /var/www/.env ] && [ -f /var/www/env.example ]; then
  cp /var/www/env.example /var/www/.env
fi

# ---- Ensure storage & cache dirs exist and have correct ownership/permissions ----
mkdir -p /var/www/storage /var/www/storage/logs /var/www/bootstrap/cache
# remove possibly stale cached files that can block clearing (safe to rm)
rm -f /var/www/bootstrap/cache/config.php /var/www/bootstrap/cache/services.php /var/www/bootstrap/cache/routes-v7.php || true

# Set ownership and mode so artisan can write
chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache || true
chmod -R 775 /var/www/storage /var/www/bootstrap/cache || true

# Sometimes vendor files created as root - ensure vendor is readable
chown -R www-data:www-data /var/www/vendor || true

# ---- Now run artisan cleanup commands (safe even if some fail) ----
# run as php CLI (running in container as root is fine)
php artisan config:clear || echo "config:clear failed (ignored)"
php artisan cache:clear || echo "cache:clear failed (ignored)"
php artisan route:clear || echo "route:clear failed (ignored)"
php artisan view:clear || echo "view:clear failed (ignored)"

# ensure storage link (won't fail the container)
php artisan storage:link || true

# Ensure a laravel.log exists and is writeable
touch /var/www/storage/logs/laravel.log || true
chown www-data:www-data /var/www/storage/logs/laravel.log || true
chmod 664 /var/www/storage/logs/laravel.log || true

# ---- Debug dump (temporary) ----
echo "===== START: env keys (redacted) ====="
env | sed -E 's/^([^=]+=).*/\1<redacted>/' || true
echo "===== END: env keys ====="

echo "===== START: permissions check ====="
ls -la /var/www || true
ls -la /var/www/storage || true
ls -la /var/www/storage/logs || true
ls -la /var/www/bootstrap/cache || true
echo "===== END: permissions check ====="

echo "===== START: tail laravel.log (last 200 lines) ====="
if [ -f /var/www/storage/logs/laravel.log ]; then
  tail -n 200 /var/www/storage/logs/laravel.log || true
else
  echo "No laravel.log found at /var/www/storage/logs/laravel.log"
fi
echo "===== END: laravel.log ====="

# ---- Start server, bind to $PORT ----
exec php artisan serve --host=0.0.0.0 --port=${PORT}
