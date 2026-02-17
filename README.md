# Admin Dashboard for Blogging & CRM

A robust **Admin Dashboard** built with **Laravel** for managing blogging operations and CRM workflows efficiently. This project provides a clean **controller-to-frontend** data flow, making it easy to manage blogs, comments, tags, users, and CRM contacts from a centralized interface.

---

## ✨ Key Features

* 📝 **Blog Management**: Create, update, delete, and publish blogs.
* 🏷 **Tag & Category Management**: Organize content effectively.
* 💬 **Comment Moderation**: Approve, reject, and manage comments.
* 👥 **CRM Contact Management**: Handle user data and interactions.
* 📊 **Dashboard Analytics**: Visualize statistics and reports.
* 🔐 **Role-Based Access**: Secure areas for admins and moderators.
* ⚡ **Controller-Driven Frontend**: Efficient data rendering with scalable architecture.

---

## 🛠 Tech Stack

* **Backend**: Laravel
* **Frontend**: Blade / Livewire / API-driven UI
* **Database**: MySQL
* **Deployment**: Hostinger via GitHub Actions & SSH

---

## 🚀 Getting Started

1. Clone the repository:

```bash
git clone https://github.com/amowogbaje/maxlifecenter-backend.git admin-dashboard-crm
cd admin-dashboard-crm
```

2. Install dependencies:

```bash
composer install
npm install && npm run dev
```

3. Copy `.env.example` to `.env` and configure database & environment variables.

```bash
cp .env.example .env
php artisan key:generate
```

4. Run migrations and seeders:

```bash
php artisan migrate --seed
php artisan permission:sync
```

5. Serve locally:

```bash
php artisan serve
```

---

            
```


## 🎯 Purpose

* Demonstrates **clean Laravel architecture** with **controller-service separation**.
* Provides a **scalable dashboard** for both blogging and CRM.
