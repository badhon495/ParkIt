# Stage 1: Build assets with Node
FROM node:20 AS nodebuild
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
COPY --from=nodebuild /app/public/build /var/www/html/public/build
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
RUN sed -i 's|root /var/www/html;|root /var/www/html/public;|g' /etc/nginx/sites-available/default.conf

# Copy the entrypoint script and make it executable
COPY docker-entrypoint.sh /usr/local/bin/docker-entrypoint.sh
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

EXPOSE 10000

ENTRYPOINT ["/usr/local/bin/docker-entrypoint.sh"]
CMD ["/start.sh"]