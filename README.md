# 🍕 Pizza Place Management System

A full-stack web application for managing pizzas, orders, and sales.  
Built using **Laravel 12**, **Vue 3**, **Inertia.js**, **TailwindCSS**, and **TypeScript**.

---

## 🚀 Features

- 🍕 Pizza CRUD with types, sizes, and prices
- 📦 Order and order details management
- 🔍 Filtering, sorting, and pagination (Spatie Query Builder)
- 📊 Dashboard with statistics
- 📃 RESTful API powered by Laravel
- ⚡ Fast SPA experience using Inertia.js and Vue 3
- 💅 Fully styled with TailwindCSS

---

## 🛠️ Project Setup

### 🔧 Requirements

- PHP ^8.2
- Composer
- Node.js + npm
- MySQL / MariaDB
- Laravel 12

---

### 🐘 Backend (Laravel)

```bash
# Clone the repository
git clone https://github.com/Marlon-O/Pizza-Place
cd pizza-place

# Install PHP dependencies
composer install

# Create .env file
cp .env.example .env

# Generate app key
php artisan key:generate

# Configure your .env with DB credentials
# DB_DATABASE=pizza_place
# DB_USERNAME=root
# DB_PASSWORD=

# Import the exported csv on this link
https://www.kaggle.com/datasets/mysarahmadbhat/pizza-place-sales

# Start Laravel dev server
php artisan serve
```
## 🌐 Frontend (Vue 3 + Inertia.js)
```bash
# Install frontend dependencies
npm install

# Start Vite dev server
npm run dev
```

### 📦 Folder Structure
```bash
├── app/
│   ├── Http/Controllers/Api/
│   ├── Http/Resources/
│   ├── Services/
├── resources/js/
│   ├── Pages/
│   ├── Components/
│   ├── store/ (Vuex modules)
├── routes/
│   ├── api.php
│   └── web.php
```

### 📬 API Endpoints
The project includes RESTful APIs for:

- GET /api/pizzas
- GET /api/orders
- POST /api/orders
- GET /dashboard-stats
- ...and more

All API routes are documented and testable via Postman. You can import the pizza-api.postman_collection.json from this project on Postman