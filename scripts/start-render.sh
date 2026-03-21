#!/usr/bin/env sh
set -eu

cd /var/www/html

if [ -z "${APP_KEY:-}" ]; then
    echo "APP_KEY is missing."
    exit 1
fi

php artisan optimize:clear
php artisan storage:link || true
php artisan migrate --force

exec php artisan serve --host=0.0.0.0 --port="${PORT:-10000}"
