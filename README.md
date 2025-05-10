# ParkIt - Parking Booking System

ParkIt is a web application for booking parking slots. Users can book a parking slot for their car, and homeowners can rent out their garages—think of it as Airbnb, but for cars!

## Features
- Users can sign up, log in, and manage their profile
- Homeowners can list their garages for rent
- Users can search and book available parking slots
- Forgot password functionality with email reset

## How to Run the Project

1. **Clone the repository:**
   ```bash
   git clone <your-repo-url>
   cd ParkIt
   ```
2. **Install dependencies:**
   ```bash
   composer install
   npm install
   ```
3. **Copy the example environment file and set your environment variables:**
   ```bash
   cp .env.example .env
   ```
4. **Generate application key:**
   ```bash
   php artisan key:generate
   ```
5. **Set up the database:**
   - Edit `.env` and set your database connection (SQLite is supported by default)
   - Run migrations:
     ```bash
     php artisan migrate
     ```
6. **Run the development server:**
   ```bash
   php artisan serve
   ```
7. **(Optional) Build frontend assets:**
   ```bash
   npm run dev
   ```

## Setting up SMTP Mail for Forgot Password

To enable the forgot password email feature, configure your SMTP settings in the `.env` file. For Gmail SMTP, add the following lines:

```
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your mail
MAIL_PASSWORD=password without any gap
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your mail
MAIL_FROM_NAME="ParkIt"
```

You can get the app password from (App Password)[https://myaccount.google.com/u/2/apppasswords]. Make sure to replace `your mail` and `password without any gap` with your actual Gmail address and app password, respectively.
You can also use other SMTP providers like SendGrid, Mailgun, etc. Just replace the `MAIL_HOST`, `MAIL_PORT`, and other relevant fields with the appropriate values for your SMTP provider.
After updating `.env`, run:
```bash
php artisan config:cache
php artisan config:clear
```

**Note:**
- If you use 2-Step Verification on your Gmail, you must use an App Password instead of your regular password.
- Make sure to allow access for less secure apps or use App Passwords in your Google account settings.
- You can check the website from the ParkIt [https://parkit-2arc.onrender.com] to see the working of the project. As it is hosted on Render free tier, it may take some time to load the website.
- In wireframe diagram, you can see the flow of the project.