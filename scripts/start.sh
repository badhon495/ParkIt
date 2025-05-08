#!/usr/bin/env bash

# Clear Laravel caches
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
composer dump-autoload
php artisan optimize:clear
php artisan optimize

# Run Laravel migrations
php artisan migrate --force

# Start Laravel server on 0.0.0.0:$PORT
php artisan serve --host=0.0.0.0 --port=$PORT