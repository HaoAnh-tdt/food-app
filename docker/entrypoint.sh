#!/bin/bash
set -e

# default port nếu không có PORT từ môi trường
: "${PORT:=8000}"

# If a secret .env provided by Render exists, copy it (adjust path if needed)
if [ -f /etc/secrets/.env ]; then
  echo "Found secret .env, copying..."
  cp /etc/secrets/.env /var/www/.env
fi

# If no .env file but env vars present on runtime, you can optionally create a .env from template here
if [ ! -f /var/www/.env ] && [ -f /var/www/env.example ]; then
  cp /var/www/env.example /var/www/.env
  echo "Created .env from env.example (for debug)."
fi

# ensure APP_KEY exists (if not, generate one at runtime)
if [ -z "${APP_KEY:-}" ] || [[ "${APP_KEY}" == "" ]]; then
  echo "APP_KEY not set -> generate one (runtime)"
  php artisan key:generate --ansi --force || true
fi

# permissions
chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache || true
chmod -R 775 /var/www/storage /var/www/bootstrap/cache || true

# clear caches to ensure newest env vars used
php artisan config:clear || true
php artisan cache:clear || true
php artisan route:clear || true
php artisan view:clear || true

# ensure storage link
php artisan storage:link || true

# Debug dump: print env keys (values redacted) + tail laravel.log (DEBUG ONLY)
echo "===== START: env keys (redacted) ====="
env | sed -E 's/^([^=]+=).*/\1<redacted>/' || true
echo "===== END: env keys ====="

echo "===== START: permissions check ====="
ls -la /var/www || true
ls -la /var/www/storage || true
ls -la /var/www/bootstrap/cache || true
echo "===== END: permissions check ====="

echo "===== START: tail laravel.log (last 200 lines) ====="
if [ -f /var/www/storage/logs/laravel.log ]; then
  tail -n 200 /var/www/storage/logs/laravel.log || true
else
  echo "No laravel.log found at /var/www/storage/logs/laravel.log"
fi
echo "===== END: laravel.log ====="

# start app - use PORT from env
exec php artisan serve --host=0.0.0.0 --port=${PORT}
