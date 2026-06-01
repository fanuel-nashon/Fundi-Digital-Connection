# Fundi Digital Connection

A Laravel platform connecting customers with skilled tradespeople in Tanzania, supporting plumbing, electrical, carpentry, welding, and masonry services.

---

## Requirements

| Tool | Version |
|------|---------|
| PHP | 8.2+ |
| Composer | 2.x |
| MySQL | 8.0+ |
| Node.js + NPM | 18+ (Vite assets) |

---

## Setup

### 1. Clone and install
```bash
git clone <repository-url>
cd Fundi-Digital-Connection
composer install
npm install && npm run build
```

### 2. Environment
```bash
cp .env.example .env
php artisan key:generate
```

Set your database in `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=fundi_digital_connection
DB_USERNAME=root
DB_PASSWORD=your_password
MAIL_MAILER=log
```

### 3. Database
```sql
CREATE DATABASE fundi_digital_connection CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

```bash
php artisan migrate
php artisan db:seed
php artisan permission:cache-reset
php artisan serve
```

Visit: **http://127.0.0.1:8000**

---

## Test Accounts  *(password: `password123`)*

| Role | Email |
|------|-------|
| Admin | abdul.admin@gmail.com |
| Customer | asha.customer@gmail.com |
| Tradesperson | juma.trades@gmail.com |

---

## Role Access

| Role | Dashboard | Can Do |
|------|-----------|--------|
| Admin | `/admin/dashboard` | Create, edit, delete users |
| Customer | `/customer/dashboard` | Browse/filter tradespeople, request service, message, rate |
| Tradesperson | `/tradesperson/tradesperson-dashboard` | Accept/decline jobs, manage profile |

---

## Key Artisan Commands

```bash
php artisan migrate:fresh --seed        # Full fresh install
php artisan db:seed --class=PermissionSeeder
php artisan db:seed --class=TradespersonProfileSeeder
php artisan db:seed --class=ReviewSeeder
php artisan permission:cache-reset      # Clear role/permission cache
php artisan route:clear && php artisan config:clear
php artisan route:list                  # View all routes
```

---

## Project Structure

```
app/Http/Controllers/
  Admin/       DashboardController, UsersController
  Auth/        (Breeze) login, register, password reset
  Customer/    DashboardController, JobRequestController, MessageController, ReviewController
  Tradesperson/ ProfileController, JobRequestController

app/Models/    User, TradespersonProfile, JobRequest, Message, Review

database/
  migrations/  All schema files
  seeders/     PermissionSeeder, UsersTableSeeder, TradespersonProfileSeeder, ReviewSeeder

resources/views/
  layouts/     admin.blade.php, customer.blade.php, tradesperson.blade.php, guest.blade.php
  admin/       dashboard, users (index, create, edit)
  customer/    dashboard, tradesperson-show, request-service, messages, rate
  tradesperson/ dashboard, profile, create-profile, job-requests
  auth/        login, register, forgot-password, reset-password
```

---

## Features

- [x] Auth: login, register, forgot/reset password
- [x] Role-based access (Spatie Permission — admin, tradesperson, customer)
- [x] Admin: user CRUD with SweetAlert delete confirmation
- [x] Customer: browse & filter tradespeople (category, location, availability, rating)
- [x] Customer: service request booking with preferred date
- [x] Customer: messaging thread per job request
- [x] Customer: star rating + written review after completion
- [x] Tradesperson: accept/decline job requests
- [x] Tradesperson: public profile (bio, category, availability)
- [x] Strong passwords (min 8, uppercase, number, symbol)
- [x] Password eye-toggle + strength meter
- [x] Toast notifications + SweetAlert confirmations

## Pending
- [ ] Payment processing (Stripe / M-Pesa)
- [ ] Calendar interface for scheduling
- [ ] Real-time notifications (Laravel Echo)

