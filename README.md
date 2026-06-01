# Fundi Digital Connection

**Fundi Digital Connection** is a web platform that bridges the gap between customers and skilled tradespeople in Tanzania. It simplifies the process of finding, hiring, and reviewing local professionals across trades such as plumbing, electrical work, carpentry, welding, and masonry.

---

## The Problem

Customers in Tanzania struggle to find reliable, skilled tradespeople. There is no central platform where they can browse professionals, compare ratings, communicate directly, and book services — forcing them to rely on word-of-mouth which is slow and unreliable.

On the other side, skilled tradespeople have no structured way to advertise their services, manage job requests, or build a digital reputation.

---

## The Solution

Fundi Digital Connection provides a role-based platform with three distinct user groups:

### For Customers
- Browse and filter tradespeople by **trade category**, **location**, **availability**, and **star rating**
- View detailed profiles including bio and customer reviews
- Send service requests with a preferred date and job description
- Communicate with the tradesperson through a **built-in messaging thread**
- Mark jobs as complete and leave a **star rating + written review**

### For Tradespeople
- Set up a public profile with bio, trade category, and availability status
- Receive and manage job requests — **accept or decline** with one click
- Track job history (pending → accepted → complete → reviewed)

### For Admins
- Create and manage all user accounts (customers, tradespeople, other admins)
- Monitor platform activity through a central dashboard
- View user statistics by role

---

## Key Features

| Feature | Description |
|---------|-------------|
| Role-based access | Admin, Customer, and Tradesperson roles with separate dashboards |
| Tradesperson profiles | Bio, trade category, availability, star rating, written reviews |
| Service requests | Job booking with description, scheduled date, and status tracking |
| Messaging | In-app conversation thread linked to each job request |
| Ratings & Reviews | 1–5 star rating plus written review after job completion |
| Search & Filter | Filter by category, location, availability, and minimum rating |
| Secure auth | Login, forgot/reset password, strong password enforcement |
| Admin user management | Admin-only account creation — no public registration |

---

## Trade Categories

- Plumbing
- Electrical
- Carpentry
- Welding
- Masonry

---

## Tech Stack

| Layer | Technology |
|-------|-----------|
| Backend | Laravel 12 (PHP 8.2) |
| Frontend | Bootstrap 5.3, Bootstrap Icons |
| Database | MySQL 8 |
| Auth | Laravel Breeze + Spatie Permission |
| Mailing | Log driver (dev) / SMTP (production) |

---

## Project Status

| Requirement | Status |
|-------------|--------|
| User authentication & roles | ✅ Complete |
| Customer search & filter | ✅ Complete |
| Ratings & written reviews | ✅ Complete |
| Job request tracking (4 stages) | ✅ Complete |
| In-app messaging | ✅ Complete |
| Service booking with date | ✅ Complete |
| Payment processing | 🔲 Planned |
| Calendar scheduling interface | 🔲 Planned |
| Real-time notifications | 🔲 Planned |

---

> For setup and development instructions, see [DEVELOPMENT.md](DEVELOPMENT.md)
