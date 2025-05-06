# Stage 1: Build assets with Node
FROM node:20@sha256:5b7b3c8b8f8f8c8e8f8f8c8b8f8f8c8b8f8f8c8b8f8f8c8b8f8f8c8b8f8f8c8 AS nodebuild
WORKDIR /app
COPY package*.json ./
RUN npm install
COPY resources/ resources/
COPY vite.config.js ./
RUN npm run build

# Stage 2: Composer and PHP
FROM richarvey/nginx-php-fpm:latest

WORKDIR /var/www/html

COPY . .

# Copy built assets from nodebuild
COPY --from=nodebuild /app/public /var/www/html/public
COPY --from=nodebuild /app/node_modules /var/www/html/node_modules

RUN composer install --no-dev --optimize-autoloader
RUN php artisan key:generate --force || true
RUN php artisan storage:link || true
RUN chown -R www-data:www-data storage bootstrap/cache

ENV APP_ENV=production
ENV APP_DEBUG=false
ENV LOG_CHANNEL=stderr
ENV PORT=10000
ENV HOST=0.0.0.0
ENV COMPOSER_ALLOW_SUPERUSER=1

RUN sed -i 's/listen 80;/listen ${PORT};/g' /etc/nginx/sites-available/default.conf

EXPOSE 10000

CMD ["/start.sh"]