#!/bin/sh
chmod -R 777 /var/www/storage /var/www/bootstrap/cache
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan migrate --force
php-fpm -D
nginx -g "daemon off;"
