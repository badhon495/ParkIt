#!/bin/sh
# filepath: /home/badhon/Documents/CSE391/391_Project/ParkIt/docker-entrypoint.sh
set -e

# Wait for the database to be ready (optional, but good practice if DB starts slowly)
# Add logic here if needed, e.g., using pg_isready or a similar tool

echo "Running database migrations..."
php artisan migrate --force

echo "Starting application..."
# Execute the CMD from the Dockerfile (which is /start.sh)
exec "$@"
