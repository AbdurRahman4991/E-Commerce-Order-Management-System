📦 Laravel Inventory & Order Management API

AI-Enhanced, Queue-Powered Invoice Generator | Rate-Limited API | CSV Import | Low-Stock Alerts

📘 Project Overview

এই প্রজেক্টটি একটি RESTful Inventory & Order Management API, যেখানে পণ্য ম্যানেজমেন্ট, অর্ডার সিস্টেম, ইনভয়েস জেনারেশন, CSV ইমপোর্ট, Low Stock Alert এবং JWT Authentication ইমপ্লিমেন্ট করা হয়েছে।

মূল ফিচারগুলোঃ

✅ Core Features

User Registration & Login (JWT)

Product Management (CRUD)

CSV Product Bulk Import

Order Create, View & Status Update

Invoice PDF Generation (Queued Job)

Automatic Low-Stock Email Alerts (Queue Job)

API Rate Limiting

Downloadable Invoice PDF

Protected Routes (auth:api middleware)

Optimized Database Indexing

🛠️ Technologies Used

Laravel 11

MySQL

Laravel Queue (Database/Redis)

Barryvdh/DomPDF

JWT Authentication (tymon/jwt-auth)

Laravel Mail

Laravel Rate Limiting

CSV Handling (League CSV)

🚀 Local Setup Instructions
1️⃣ Clone Repository
git clone https://github.com/AbdurRahman4991/E-Commerce-Order-Management-System
cd E-Commerce-Order-Management-System

2️⃣ Install Dependencies
composer install

3️⃣ Create Environment File
cp .env.example .env

4️⃣ Generate App Key
php artisan key:generate

5️⃣ Configure Database

.env এ—

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=order_management
DB_USERNAME=root
DB_PASSWORD=

6️⃣ Run Migrations & Seeders
php artisan migrate --seed

7️⃣ JWT Secret Generate
php artisan jwt:secret

8️⃣ Queue Worker Start
php artisan queue:work

9️⃣ Start Local Server
php artisan serve

🔐 Environment Variables (Fully Documented)
Application
APP_NAME="Inventory API"
APP_ENV=local
APP_KEY=base64:xxxx
APP_DEBUG=true
APP_URL=http://localhost:8000

Database
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=inventory_api
DB_USERNAME=root
DB_PASSWORD=

Mail Configuration
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your_email@gmail.com
MAIL_PASSWORD=your_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your_email@gmail.com
MAIL_FROM_NAME="Inventory API"

JWT
JWT_SECRET=xxxx

Low Stock Threshold
LOW_STOCK_THRESHOLD=5

🔑 API Authentication Guide (JWT Auth)
Register
POST /api/v1/auth/register

Login
POST /api/v1/auth/login


Response includes:

access_token
token_type
expires_in

Send Token in Header
Authorization: Bearer <token>

Logout
POST /api/v1/auth/logout

📡 API Rate Limiting

Laravel throttle ব্যবহার করা হয়েছে:

api:
   throttle: api


You can edit: E-Commerce-Order-Management-System\bootstrap\app.php

Example limit:

RateLimiter::for('api', function () {
    return Limit::perMinute(60)->by(request()->ip());
});

## Postman Collection
You can test all API endpoints using the included Postman collection:
- Path: /postman/ecommerce_collection.json
Import this file into Postman to test all routes quickly.

Run Test with Coverage
php -d xdebug.mode=coverage vendor/bin/phpunit --coverage-html coverage

👨‍💻 Developer Info

Name: Abdur Rahman
Email: engrabdurrahman4991@gmail.com

GitHub: https://github.com/AbdurRahman4991

LinkedIn: https://www.linkedin.com/in/abdur-rahman-engineer-842a17275/




📄 END