# Development Guide

This document covers everything needed to clone, set up, and run the **Fundi Digital Connection** project locally.

---

## Requirements

| Tool | Version |
|------|---------|
| PHP | 8.2+ |
| Composer | 2.x |
| MySQL | 8.0+ |
| Node.js & NPM | 18+ (for Vite/assets) |

---

## Installation

### 1. Clone the repository
```bash
git clone <repository-url>
cd Fundi-Digital-Connection
```

### 2. Install PHP dependencies
```bash
composer install
```

### 3. Install Node dependencies and build assets
```bash
npm install
npm run build
```
> For live development use `npm run dev` instead.

### 4. Set up environment
```bash
cp .env.example .env
php artisan key:generate
```

Edit `.env` with your database credentials:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=fundi_digital_connection
DB_USERNAME=root
DB_PASSWORD=your_password
```

Mail is configured to use the log driver by default (emails are written to `storage/logs/laravel.log`):
```env
MAIL_MAILER=log
```

### 5. Create the database
```sql
CREATE DATABASE fundi_digital_connection
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;
```

### 6. Run migrations
```bash
php artisan migrate
```

### 7. Seed the database
```bash
php artisan db:seed
```

This runs the following seeders in order:

| Seeder | What it creates |
|--------|----------------|
| `PermissionSeeder` | Roles (admin, tradesperson, customer) and permissions |
| `UsersTableSeeder` | 3 admins, 10 customers, 10 tradespeople |
| `TradespersonProfileSeeder` | Profiles for all 10 tradespeople |
| `ReviewSeeder` | Sample job requests and star ratings |

### 8. Clear permission cache
```bash
php artisan permission:cache-reset
```

### 9. Start the development server
```bash
php artisan serve
```

Visit: **http://127.0.0.1:8000**

---

## Test Accounts

> All accounts use the password: `password123`

### Admins
| Name | Email |
|------|-------|
| Abdul Mussa | abdul.admin@gmail.com |
| Neema Joseph | neema.admin@gmail.com |
| Hassan Mwinyi | hassan.admin@gmail.com |

### Customers
| Name | Email |
|------|-------|
| Asha Said | asha.customer@gmail.com |
| John Mwakalinga | john.customer@gmail.com |
| Rehema Suleiman | rehema.customer@gmail.com |
| Peter Nyerere | peter.customer@gmail.com |
| Fatma Omari | fatma.customer@gmail.com |

### Tradespeople
| Name | Email |
|------|-------|
| Juma Fundi | juma.trades@gmail.com |
| Moses Mafundi | moses.trades@gmail.com |
| Ali Mchomeleaji | ali.trades@gmail.com |
| Isack Umeme | isack.trades@gmail.com |
| Baraka Seremala | baraka.trades@gmail.com |

---

## Role Dashboards

| Role | Login redirects to | Access |
|------|--------------------|--------|
| Admin | `/admin/dashboard` | User management, stats |
| Customer | `/customer/dashboard` | Browse, request, message, review |
| Tradesperson | `/tradesperson/tradesperson-dashboard` | Jobs, profile |

> **Note:** Public registration is disabled. All accounts must be created by an admin through `/admin/users/create`.

---

## Forgot Password (Dev)

Since `MAIL_MAILER=log`, reset emails are not sent — they are written to the log file.

1. Submit the forgot-password form at `/forgot-password`
2. Open `storage/logs/laravel.log`
3. Search for `reset-password` and copy the full URL
4. Open it in the browser to reset the password

---

## Common Artisan Commands

```bash
# Full fresh install — drops all tables and reseeds
php artisan migrate:fresh --seed

# Run individual seeders
php artisan db:seed --class=PermissionSeeder
php artisan db:seed --class=TradespersonProfileSeeder
php artisan db:seed --class=ReviewSeeder

# Clear caches
php artisan permission:cache-reset
php artisan route:clear
php artisan config:clear
php artisan view:clear
php artisan cache:clear

# List all registered routes
php artisan route:list

# Manually trigger overdue job notifications
php artisan jobs:check-deadlines

# Run the scheduler locally (checks deadlines daily at 08:00)
php artisan schedule:work

# Create a new migration
php artisan make:migration create_payments_table

# Create a new controller
php artisan make:controller Admin/PaymentController
```

---

## Job Request Lifecycle

```
pending → accepted → in_progress → complete → reviewed
                ↘ declined
```

| Status | Set by | Meaning |
|--------|--------|---------|
| `pending` | Customer | Request submitted, awaiting tradesperson response |
| `accepted` | Tradesperson | Tradesperson confirmed the job |
| `in_progress` | Tradesperson | Progress updated (25–75%) |
| `complete` | Tradesperson (100%) or Customer | Job finished |
| `reviewed` | Customer | Customer left a star rating + written review |
| `declined` | Tradesperson | Request rejected |

---

## Deadline & Notifications

- Customers can set an optional **deadline** when submitting a service request
- The deadline must be on or after the start date
- When a job's deadline passes and it is still active, the `jobs:check-deadlines`
  command sends a **database notification** to both the tradesperson and the customer
- Notifications are stored in the `notifications` table (Laravel's built-in system)
- Tradesperson sees a bell icon with unread count in the navbar
- To run deadline checks automatically, start the scheduler:

```bash
php artisan schedule:work
```

---

## Project Structure

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── Admin/
│   │   │   ├── DashboardController.php   # Stats & recent users
│   │   │   └── UsersController.php       # Full user CRUD
│   │   ├── Auth/                         # Laravel Breeze auth
│   │   ├── Customer/
│   │   │   ├── DashboardController.php   # Browse & filter tradespeople
│   │   │   ├── JobRequestController.php  # Create service requests
│   │   │   ├── MessageController.php     # Messaging thread
│   │   │   └── ReviewController.php      # Star rating + written review
│   │   └── Tradesperson/
│   │       ├── ProfileController.php     # Create & view profile
│   │       └── JobRequestController.php  # Accept/decline, update progress, notifications
│   │       └── JobRequestController.php  # Accept / decline requests
│   └── Middleware/
│       └── CheckRole.php                 # Role-based access guard
├── Console/Commands/
│   └── CheckJobDeadlines.php             # php artisan jobs:check-deadlines
├── Notifications/
│   └── JobOverdueNotification.php        # Database notification for overdue jobs
├── Models/
│   ├── User.php
│   ├── TradespersonProfile.php
│   ├── JobRequest.php                    # includes deadline, progress, isOverdue()
│   ├── Message.php
│   └── Review.php

database/
├── migrations/                           # All schema files
└── seeders/
    ├── PermissionSeeder.php
    ├── UsersTableSeeder.php
    ├── TradespersonProfileSeeder.php
    └── ReviewSeeder.php

resources/views/
├── layouts/
│   ├── admin.blade.php                   # Dark sidebar admin layout
│   ├── customer.blade.php                # Orange-branded customer layout
│   ├── tradesperson.blade.php            # Teal-branded tradesperson layout
│   └── guest.blade.php                   # Split-screen auth layout
├── admin/
│   ├── dashboard.blade.php
│   └── users/ (index, create, edit)
├── customer/
│   ├── dashboard.blade.php               # Tradesperson cards + filter
│   ├── tradesperson-show.blade.php
│   ├── request-service.blade.php
│   ├── messages.blade.php
│   └── rate.blade.php
├── tradesperson/
│   ├── dashboard.blade.php
│   ├── profile.blade.php
│   ├── create-profile.blade.php
│   └── job-requests.blade.php
└── auth/ (login, forgot-password, reset-password)

routes/
├── web.php                               # All role-grouped routes
└── auth.php                              # Breeze auth routes
```

---

## Password Policy

All passwords must meet the following requirements:
- Minimum **8 characters**
- At least one **uppercase** letter
- At least one **lowercase** letter
- At least one **number**
- At least one **symbol** (e.g. `@`, `!`, `#`)

This is enforced both client-side (strength meter) and server-side (Laravel Password rules).
