#!/bin/sh
chmod -R 777 /var/www/storage /var/www/bootstrap/cache
php artisan config:clear
php artisan migrate --force 2>&1
php artisan config:cache
php artisan route:cache
php artisan view:cache
php-fpm -D
nginx -g "daemon off;"
