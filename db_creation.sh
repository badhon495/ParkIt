#!/bin/bash

# Config
DB_NAME="parkit"
DB_USER="postgres"
DB_HOST="localhost"
DB_PORT="5432"
DB_PASS="postgres"

export PGPASSWORD=$DB_PASS

# Drop the database if it already exists
DB_EXISTS=$(psql -U $DB_USER -h $DB_HOST -p $DB_PORT -tAc "SELECT 1 FROM pg_database WHERE datname='$DB_NAME'")
if [ "$DB_EXISTS" = "1" ]; then
  echo "Database $DB_NAME exists. Terminating connections..."
  psql -U $DB_USER -h $DB_HOST -p $DB_PORT -d postgres -c "SELECT pg_terminate_backend(pid) FROM pg_stat_activity WHERE datname = '$DB_NAME' AND pid <> pg_backend_pid();"
  echo "Dropping database $DB_NAME..."
  dropdb -U $DB_USER -h $DB_HOST -p $DB_PORT $DB_NAME
fi

echo "Creating PostgreSQL database..."
createdb -U $DB_USER -h $DB_HOST -p $DB_PORT $DB_NAME

echo "Creating tables in $DB_NAME..."

psql -U $DB_USER -h $DB_HOST -p $DB_PORT -d $DB_NAME <<EOF

CREATE TABLE users (
    user_id SERIAL PRIMARY KEY,
    name TEXT NOT NULL,
    type VARCHAR(10) NOT NULL CHECK (type IN ('user', 'owner', 'admin')),
    password TEXT NOT NULL,
    email TEXT NOT NULL UNIQUE,
    phone TEXT NOT NULL
);

CREATE TABLE parking_details (
    garage_id SERIAL PRIMARY KEY,
    images TEXT,
    rent NUMERIC NOT NULL,
    parking_type VARCHAR(50) NOT NULL,
    area VARCHAR(100) NOT NULL,
    division VARCHAR(100) NOT NULL,
    location TEXT NOT NULL,
    camera BOOLEAN,
    guard BOOLEAN,
    usr_id INTEGER REFERENCES users(user_id),
    bike_slot INTEGER,
    car_slot INTEGER,
    bicycle_slot INTEGER,
    slots JSON NOT NULL,
    nid TEXT,
    utility_bill TEXT,
    passport TEXT,
    alt_name TEXT,
    alt_phone TEXT
);

CREATE TABLE bookings (
    booking_id SERIAL PRIMARY KEY,
    garage_id INTEGER REFERENCES parking_details(garage_id),
    user_id INTEGER REFERENCES users(user_id),
    driver_name TEXT,
    driver_phone TEXT,
    owner_name TEXT,
    owner_phone TEXT,
    booked_slots JSON NOT NULL,
    vehicle_type VARCHAR(50),
    vehicle_details TEXT,
    total_cost NUMERIC NOT NULL,
    trxn TEXT NOT NULL,
    booking_date DATE NOT NULL
);

EOF

echo "\n# Database and tables created successfully."
echo "✅ Setup complete!"