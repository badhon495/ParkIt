# ParkIt - Smart Parking Booking System

<div align="center">

![Laravel](https://img.shields.io/badge/Laravel-11.x-red?style=flat-square&logo=laravel)
![PHP](https://img.shields.io/badge/PHP-8.2+-blue?style=flat-square&logo=php)
![SQLite](https://img.shields.io/badge/SQLite-Database-003B57?style=flat-square&logo=sqlite)
![Vite](https://img.shields.io/badge/Vite-6.x-646CFF?style=flat-square&logo=vite)

</div>

**ParkIt** is a comprehensive web application for parking space management and booking. Think of it as **Airbnb for parking spaces** - connecting car owners who need parking with homeowners who have available garage space to rent out.

## Key Features

### Multi-User System
- **Users/Drivers**: Book parking spaces, manage bookings, view history
- **Homeowners/Owners**: List garages, manage listings, track earnings
- **Administrators**: Full system oversight and management

### Authentication & Security
- **User Registration & Login** with email/phone
- **Google OAuth Integration** for seamless sign-in
- **Password Reset** via email with SMTP support
- **Session Management** with secure authentication
- **Role-based Access Control** (User, Owner, Admin)

### Garage Management
- **List Parking Spaces** with detailed information
- **Image Uploads** for garage listings
- **Slot-based Booking System** with hourly rates
- **Real-time Availability** checking
- **Location & Amenity Details** (CCTV, Guard, Indoor/Outdoor)

### Smart Booking System
- **Time Slot Selection** with conflict prevention
- **Date-based Booking** with availability calendar
- **Vehicle Type Support** (Car, Bike, Bicycle)
- **Transaction Management** with payment tracking
- **Booking Confirmation** with detailed receipts

### Dashboard & Analytics
- **Owner Dashboard** with earnings overview
- **Booking History** for all user types
- **Admin Panel** for complete system management
- **User Management** with profile editing capabilities
- **Parking List Management** with search functionality

### Advanced Search & Filtering
- **Location-based Search** by division and area
- **Filter by Amenities** (CCTV, Guard, Indoor)
- **Price Range Filtering**
- **Real-time Availability** updates

## Live Demo

**Try the live application:** [https://parkit-2arc.onrender.com](https://parkit-2arc.onrender.com)

> **Note:** Hosted on Render's free tier - initial load may take up to 60 seconds if the server is idle.

### Demo Credentials
- **Admin Access**: `admin@gmail.com` / `admin123`
- **Regular User**: Sign up with Google or create a new account

## Prerequisites

Ensure you have the following installed on your system:

### System Requirements

| Software | Version | Purpose |
|----------|---------|---------|
| **PHP** | 8.2+ | Backend runtime |
| **Composer** | Latest | Dependency management |
| **Node.js** | 18+ | Frontend build tools |
| **Git** | Latest | Version control |

### Installation Steps

#### 1. Install Git

**Windows:**
```bash
# Download from https://git-scm.com/download/win
# Run installer with default settings
```

**Linux (Ubuntu/Debian):**
```bash
sudo apt update && sudo apt install git
```

**macOS:**
```bash
# Install via Homebrew
brew install git
```

#### 2. Install PHP 8.2+

**Windows:**
```bash
# Download from https://windows.php.net/download/
# Extract to C:\php and add to PATH
```

**Linux (Ubuntu/Debian):**
```bash
sudo apt update
sudo apt install php8.3 php8.3-cli php8.3-xml php8.3-sqlite3 \
                 php8.3-mbstring php8.3-curl php8.3-zip php8.3-gd
```

**macOS:**
```bash
brew install php@8.3
```

#### 3. Install Composer
```bash
# Visit https://getcomposer.org/download/
# Follow installation instructions for your OS
```

#### 4. Install Node.js and npm
**Windows:**
```bash
# Download from https://nodejs.org/en/download/
# Run installer with default settings
```
**Linux (Ubuntu/Debian):**
```bash
curl -fsSL https://deb.nodesource.com/setup_18.x | sudo -E bash -
sudo apt install -y nodejs
```
**macOS:**
```bash
brew install node
```
#### 5. Verify Installations
```bash
git --version
php -v
composer --version
node -v
npm -v
```

## Quick Start

### 1. Clone Repository
```bash
git clone https://github.com/your-username/ParkIt.git
cd ParkIt
```

### 2. Install Dependencies
```bash
# Install PHP dependencies
composer install

# Install Node.js dependencies (optional)
npm install
```

### 3. Environment Setup
```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

### 4. Database Configuration

**Option A: SQLite (Recommended for development)**
```bash
# Database is already configured in .env
# SQLite file is located at: database/database.sqlite
```

**Option B: PostgreSQL (Production)**
```env
DB_CONNECTION=pgsql
DB_HOST=your-postgres-host
DB_PORT=5432
DB_DATABASE=your-database-name
DB_USERNAME=your-username
DB_PASSWORD=your-password
```

### 5. Run Migrations
```bash
php artisan migrate
```

### 6. Start Development Server
```bash
# Backend server
php artisan serve
# Access at: http://localhost:8000

# Frontend assets (optional)
npm run dev
# Vite server runs on: http://localhost:5173
```

## Email Configuration (Forgot Password)

To enable the forgot password functionality, configure SMTP in your `.env` file:

### Gmail SMTP Setup
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your-email@gmail.com
MAIL_FROM_NAME="ParkIt"
```

### Get Gmail App Password
1. Visit [Google App Passwords](https://myaccount.google.com/apppasswords)
2. Generate a new app password
3. Use this password (not your regular Gmail password)

### Other SMTP Providers
- **SendGrid**: Configure with SendGrid SMTP settings
- **Mailgun**: Use Mailgun SMTP credentials
- **Amazon SES**: Set up AWS SES SMTP

### Apply Configuration
```bash
php artisan config:cache
php artisan config:clear
```

## Google OAuth Setup

Enable Google Sign-In for seamless authentication:

### 1. Create Google API Project
1. Go to [Google Developers Console](https://console.developers.google.com/)
2. Create a new project or select existing
3. Enable **Google+ API** for your project

### 2. Configure OAuth Credentials
1. Navigate to **Credentials** → **Create Credentials** → **OAuth 2.0 Client IDs**
2. Set **Application Type**: Web Application
3. **Authorized JavaScript Origins**:
   ```
   http://localhost:8000
   https://your-domain.com
   ```
4. **Authorized Redirect URIs**:
   ```
   http://localhost:8000/auth/google/callback
   https://your-domain.com/auth/google/callback
   ```

### 3. Environment Configuration
Add to your `.env` file:
```env
GOOGLE_CLIENT_ID=your-google-client-id
GOOGLE_CLIENT_SECRET=your-google-client-secret
GOOGLE_REDIRECT_URI=http://localhost:8000/auth/google/callback
```

### 4. Test Integration
```bash
# Clear config cache
php artisan config:clear

# Test Google login at
# http://localhost:8000/signin → "Sign in with Google"
```
## 🏗️ Project Structure

```
ParkIt/
├── 📁 app/
│   ├── Http/Controllers/     # Application controllers
│   └── Models/              # Eloquent models
├── 📁 config/               # Configuration files
├── 📁 database/
│   ├── migrations/          # Database migrations
│   └── database.sqlite      # SQLite database
├── 📁 public/
│   ├── images/              # Static images
│   └── storage/             # Uploaded files
├── 📁 resources/
│   ├── css/                 # Stylesheets
│   ├── js/                  # JavaScript files
│   └── views/               # Blade templates
├── 📁 routes/
│   └── web.php              # Web routes
├── 📁 storage/              # File storage
└── 📄 package.json          # Node.js dependencies
```

## User Interface

### Homepage
- **Hero Section** with featured parking spaces
- **Navigation** based on user role
- **Call-to-Action** buttons for sign-up


## Troubleshooting

### Common Issues & Solutions

#### Cache Path Error
```bash
# Clear all caches
php artisan cache:clear
php artisan config:clear
php artisan view:clear
php artisan route:clear
```

#### Permission Denied (Linux/macOS)
```bash
# Fix storage permissions
sudo chmod -R 775 storage bootstrap/cache
sudo chown -R www-data:www-data storage bootstrap/cache
```

#### Missing PHP Extensions
```bash
# Ubuntu/Debian
sudo apt install php8.3-mbstring php8.3-xml php8.3-curl \
                 php8.3-zip php8.3-sqlite3 php8.3-gd

# macOS (Homebrew)
brew install php@8.3
```

#### Composer Issues
```bash
# Clear Composer cache
composer clear-cache
composer install --no-cache

# Update dependencies
composer update
```

#### Database Migration Errors
```bash
# Fresh migration ( Deletes all data)
php artisan migrate:fresh

# Reset migrations
php artisan migrate:reset
php artisan migrate
```

#### Application Key Error
```bash
# Generate new key
php artisan key:generate
```

#### Vite Build Issues
```bash
# Clear node modules
rm -rf node_modules package-lock.json
npm install

# Build for production
npm run build
```

### Performance Tips

- **Enable caching** in production:
  ```bash
  php artisan config:cache
  php artisan route:cache
  php artisan view:cache
  ```

- **Optimize autoloader**:
  ```bash
  composer install --optimize-autoloader --no-dev
  ```

- **Use PostgreSQL** for production instead of SQLite

### Getting Help

1. **Check logs**: `storage/logs/laravel.log`
2. **Enable debug mode**: Set `APP_DEBUG=true` in `.env`
3. **Verify environment**: Run `php artisan about`
4. **Database connection**: Run `php artisan migrate:status`

## Contributing

We welcome contributions! Please follow these steps:

1. **Fork** the repository
2. **Create** a feature branch: `git checkout -b feature-name`
3. **Commit** changes: `git commit -m 'Add feature'`
4. **Push** to branch: `git push origin feature-name`
5. **Submit** a Pull Request
