#!/bin/bash
rm -f database/database.sqlite
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
composer dump-autoload
npm run dev
npm run build
php artisan optimize:clear
php artisan migrate:fresh
php artisan serve