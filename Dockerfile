FROM composer:2 AS vendor
WORKDIR /app
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader --no-progress

FROM node:18 AS node_builder
WORKDIR /app
COPY package.json package-lock.json ./
RUN npm ci --silent
COPY . /app
RUN npm run build

FROM php:8.2-fpm-alpine
RUN apk add --no-cache nginx supervisor bash curl libzip-dev oniguruma-dev zlib-dev icu-dev libpng-dev libjpeg-turbo-dev freetype-dev \
    && docker-php-ext-configure zip && docker-php-ext-install pdo_mysql zip bcmath pcntl sockets exif intl && \
    docker-php-ext-configure gd --with-jpeg --with-freetype && docker-php-ext-install gd

WORKDIR /var/www/html

# Copy composer vendor from vendor stage
COPY --from=vendor /app/vendor /var/www/html/vendor
COPY --from=vendor /app/composer.json /var/www/html/composer.json

# Copy application source
COPY . /var/www/html

# Copy built assets
COPY --from=node_builder /app/public/build /var/www/html/public/build

RUN chown -R www-data:www-data /var/www/html && chmod -R 755 /var/www/html

# Nginx and supervisor configs
COPY docker/default.conf.template /etc/nginx/conf.d/default.conf.template
COPY docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf
COPY docker/entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

EXPOSE 8080
CMD ["/entrypoint.sh"]
