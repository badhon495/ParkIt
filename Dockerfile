FROM richarvey/nginx-php-fpm:latest

COPY . .

RUN composer install --no-dev --optimize-autoloader
RUN npm install && npm run build
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