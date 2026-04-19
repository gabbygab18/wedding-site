# Stage 1 - Build Frontend (Vite)
FROM node:18-alpine AS frontend
WORKDIR /app
COPY package*.json ./
RUN npm install --include=dev
COPY . .
RUN npm run build

# Stage 2 - Production (PHP + Nginx)
FROM php:8.2-fpm-alpine

RUN apk add --no-cache \
    nginx git curl unzip \
    libpng-dev oniguruma-dev \
    libzip-dev \
    postgresql-dev \
    && docker-php-ext-install \
        pdo pdo_pgsql pgsql mbstring zip gd

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www
COPY . .
COPY --from=frontend /app/public/build ./public/build

RUN composer install --no-dev --optimize-autoloader --no-interaction

RUN rm -f bootstrap/cache/config.php \
          bootstrap/cache/routes*.php \
          bootstrap/cache/packages.php \
          bootstrap/cache/services.php \
          .env

RUN mkdir -p storage/framework/sessions \
             storage/framework/views \
             storage/framework/cache \
             storage/logs \
             bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache public

ENV APP_ENV=production
ENV APP_DEBUG=false
ENV LOG_CHANNEL=stderr

COPY docker/nginx.conf /etc/nginx/nginx.conf
COPY docker/entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

EXPOSE 10000
CMD ["/entrypoint.sh"]
