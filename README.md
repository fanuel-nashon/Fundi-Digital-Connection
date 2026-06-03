# Fundi Digital Connection

**Fundi Digital Connection** is a web platform that bridges the gap between customers and skilled tradespeople in Tanzania. It simplifies the process of finding, hiring, and reviewing local professionals across trades such as plumbing, electrical work, carpentry, welding, and masonry.

---

## The Problem

Customers in Tanzania struggle to find reliable, skilled tradespeople. There is no central platform where they can browse professionals, compare ratings, communicate directly, and book services — forcing them to rely on word-of-mouth which is slow and unreliable.

On the other side, skilled tradespeople have no structured way to advertise their services, manage job requests, or build a digital reputation.

---

## The Solution

Fundi Digital Connection provides a public marketplace and a role-based management platform:

### Public Homepage
- Anyone can browse available tradespeople without logging in
- Filter by trade category and location
- Each card shows name, category, bio, star rating, and availability
- **"Book Service"** prompts the visitor to register as a customer
- **"Post My Services"** prompts the visitor to register as a tradesperson

### For Customers
- Self-register and await admin approval before first login
- After login, land directly on the **public homepage** — no separate dashboard
- Browse and filter tradespeople by **trade category** and **location**
- Send service requests with a preferred date, description, and optional deadline
- **Communicate directly** with the tradesperson through a per-job message thread
- Track all job requests in **My Requests** — including live work-progress bars for active jobs
- Mark jobs as complete and leave a **star rating + written review**

### For Tradespeople
- Self-register with trade category and bio; await admin approval
- Receive credentials by email once account is approved
- Accept or decline incoming job requests
- Update job **progress** (0 → 25 → 50 → 75 → 100%)
- **Communicate directly** with the customer through a per-job message thread
- Get notified when jobs pass their deadline
- Manage a public profile visible on the homepage

### For Admins
- Review **pending registrations** and approve or reject with one click
- On approval: a temporary password is generated and emailed to the user
- On rejection: a notification email is sent with an optional reason
- Create accounts directly (bypasses approval, account is immediately active)
- Full user CRUD — edit, suspend, or delete accounts
- Dashboard with live stats and pending account alerts

---

## Key Features

| Feature | Description |
|---------|-------------|
| Public homepage | Browse tradesperson listings without an account; serves as the customer's main view after login |
| Self-registration | Customers and tradespeople register and await admin approval |
| Admin approval flow | Admin reviews, approves/rejects, and emails credentials |
| Role-based dashboards | Admin, Customer, and Tradesperson each have separate UIs |
| Tradesperson profiles | Bio, trade category, availability, star rating, written reviews |
| Service requests | Booking with start date, optional deadline, and full status tracking |
| Job progress tracking | Tradesperson updates progress (0–100%), auto-completes at 100% |
| Deadline notifications | Daily check sends overdue alerts to both parties |
| In-app messaging | Two-way threaded conversation per job — both customer and tradesperson can send messages |
| Ratings & Reviews | 1–5 star rating + written review after completion |
| Search & Filter | Filter by category, location, availability, and minimum rating |
| Secure auth | Login, forgot/reset password, strong password enforcement |

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
| Frontend | Bootstrap 5.3, Bootstrap Icons, SweetAlert2 |
| Database | MySQL 8 |
| Auth | Laravel Breeze + Spatie Permission |
| Notifications | Laravel Database + Mail notifications |
| Mailing | Log driver (dev) / SMTP (production) |

---

## Project Status

| Requirement | Status |
|-------------|--------|
| Public tradesperson listing | ✅ Complete |
| Customer & tradesperson self-registration | ✅ Complete |
| Admin approval flow + email credentials | ✅ Complete |
| User authentication & roles | ✅ Complete |
| Customer search & filter | ✅ Complete |
| Ratings & written reviews | ✅ Complete |
| Job request tracking (6 stages) | ✅ Complete |
| Job progress updates | ✅ Complete |
| Deadline tracking & overdue notifications | ✅ Complete |
| In-app messaging | ✅ Complete |
| Service booking with date & deadline | ✅ Complete |
| Payment processing | 🔲 Planned |
| Calendar scheduling interface | 🔲 Planned |
| Real-time notifications (Echo/Pusher) | 🔲 Planned |

---

> For setup and development instructions, see [DEVELOPMENT.md](DEVELOPMENT.md)
