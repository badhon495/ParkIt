FROM richarvey/nginx-php-fpm:latest

COPY . .

# Image config
ENV SKIP_COMPOSER=1
ENV WEBROOT=/var/www/html/public
ENV PHP_ERRORS_STDERR=1
ENV RUN_SCRIPTS=1
ENV REAL_IP_HEADER=1

# Laravel config
ENV APP_ENV=production
ENV APP_DEBUG=false
ENV LOG_CHANNEL=stderr

# Render.com specific settings - bind to 0.0.0.0:10000
ENV PORT=10000
ENV HOST=0.0.0.0
# Set Nginx to listen on the specified port
RUN sed -i 's/listen 80;/listen ${PORT};/g' /etc/nginx/sites-available/default.conf
# Set Laravel to use the PORT from environment
ENV APP_URL=http://0.0.0.0:10000

# Allow composer to run as root
ENV COMPOSER_ALLOW_SUPERUSER=1

# Expose the port that the application will run on
EXPOSE 10000

CMD ["/start.sh"]

# https://github.com/codingnninja/laravel-render-template