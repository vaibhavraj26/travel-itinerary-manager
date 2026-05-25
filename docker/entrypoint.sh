#!/bin/sh
set -e

# Substitute PORT into nginx config
PORT=${PORT:-8080}
sed "s/{{PORT}}/$PORT/g" /etc/nginx/conf.d/default.conf.template > /etc/nginx/conf.d/default.conf

# Ensure storage and bootstrap cache dirs exist and are writable
mkdir -p storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache /var/www/html/public

# Ensure sqlite database file exists when using sqlite
if [ "${DB_CONNECTION}" = "sqlite" ] && [ -n "${DB_DATABASE}" ]; then
  DB_PATH="${DB_DATABASE}"
  mkdir -p "$(dirname "$DB_PATH")"
  touch "$DB_PATH"
  chown -R www-data:www-data "$(dirname "$DB_PATH")"
fi

# Generate APP_KEY if missing
if [ -z "${APP_KEY}" ] || [ "${APP_KEY}" = "" ]; then
  php artisan key:generate --force
fi

# Run migrations (best-effort)
php artisan migrate --force || true

# Optimize
php artisan config:cache || true
php artisan route:cache || true

# Start supervisord to launch nginx + php-fpm
exec /usr/bin/supervisord -n -c /etc/supervisor/conf.d/supervisord.conf
