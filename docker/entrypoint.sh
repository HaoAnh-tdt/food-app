#!/bin/bash
set -e

: "${PORT:=8000}"

# If you put a secret .env in Render Secrets, copy it into place
if [ -f /etc/secrets/.env ]; then
  echo "[entrypoint] Copying secret .env to /var/www/.env"
  cp /etc/secrets/.env /var/www/.env || true
fi

# If no .env but env.example exists, copy for debug
if [ ! -f /var/www/.env ] && [ -f /var/www/env.example ]; then
  echo "[entrypoint] No .env found — copying env.example to .env (debug)"
  cp /var/www/env.example /var/www/.env || true
fi

# Ensure log & cache directories exist
mkdir -p /var/www/storage /var/www/storage/logs /var/www/bootstrap/cache

# Remove stale cached config files that can block clears
rm -f /var/www/bootstrap/cache/config.php /var/www/bootstrap/cache/services.php /var/www/bootstrap/cache/routes-*.php || true

# Fix ownership/permissions so artisan can write
chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache /var/www/vendor || true
chmod -R 775 /var/www/storage /var/www/bootstrap/cache || true

# Create laravel.log if missing
touch /var/www/storage/logs/laravel.log || true
chown www-data:www-data /var/www/storage/logs/laravel.log || true
chmod 664 /var/www/storage/logs/laravel.log || true

# Clear caches (ignore failures)
php artisan config:clear || echo "[entrypoint] config:clear failed (ignored)"
php artisan cache:clear || echo "[entrypoint] cache:clear failed (ignored)"
php artisan route:clear || echo "[entrypoint] route:clear failed (ignored)"
php artisan view:clear || echo "[entrypoint] view:clear failed (ignored)"

# Ensure storage link exists (ignore failure)
php artisan storage:link || true

# --- DEBUG dump (temporary) ---
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

# Start the app (bind to $PORT)
exec php artisan serve --host=0.0.0.0 --port=${PORT}
