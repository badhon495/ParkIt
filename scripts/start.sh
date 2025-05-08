#!/usr/bin/env bash

# Run Laravel migrations
php artisan migrate --force

# Start Laravel server on 0.0.0.0:$PORT
php artisan serve --host=0.0.0.0 --port=$PORT