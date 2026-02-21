# 🛒 E-Commerce API - Laravel 12

![Laravel](https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![Sanctum](https://img.shields.io/badge/Sanctum-43c3f3?style=for-the-badge&logo=laravel&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-4479A1?style=for-the-badge&logo=mysql&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)

A simple RESTful E-Commerce API built using Laravel with token-based authentication using Laravel Sanctum.
This project implements role-based access control (Admin & User) and includes feature testing.
---

## 🚀 Features
#### 🔐 Authentication (Login & Logout)
#### 🛡 Role-based Authorization (Admin & User)
#### 📦 Product Management (CRUD – Admin only)
#### 🧾 Order Creation
#### 🔒 Protected API Routes using Sanctum
#### 🧪 Feature Testing with PHPUnit

## 🛠 Tech Stack
#### PHP 8+
#### Laravel 11+
#### Laravel Sanctum
#### MySQL
#### PHPUnit
#### 
## ⚙️ Installation Guide
### 1️⃣ Clone Repository
````bash
git clone https://github.com/dudiddump/ECommerce-Laravel.git
cd ECommerce-Laravel
````
### 2️⃣ Install Dependencies
````bash
composer install
````
### 3️⃣ Setup Environment File
Copy the example environment file:
```bash
cp .env.example .env
```
Generate application key:
```bash
php artisan key:generate
```
### 4️⃣ Configure Database
Edit .env file:
```bash
DB_DATABASE=ecommerce
DB_USERNAME=root
DB_PASSWORD=
```
Then run migration and seeder:
```bash
php artisan migrate --seed
```
### 5️⃣ Run Development Server
```
php artisan serve
```
API will run at:
http://127.0.0.1:8000

## 🔐 Authentication
Login
```
POST /api/login
```
Example request body:
```JSON
{
    "email": "admin@example.com",
    "password": "password"
}
```
Response:
```
{
  "access_token": "your_token_here",
  "token_type": "Bearer"
}
```
Use the token in headers:
```
Authorization: Bearer your_token_here
```
## 📦 API Endpoints
| Method | Endpoint | Auth Required | Description |
|--------|----------|--------------|------------|
| POST   | /api/login | ❌ No | Authenticate user and return access token |
| GET    | /api/products | ❌ No | Retrieve all products |
| GET    | /api/products/{id} | ❌ No | Retrieve product detail by ID |
| POST   | /api/orders | ❌ No | Create a new order |

## 🔒 Admin Routes (Requires Authentication + Admin Role)
| Method | Endpoint | Auth Required | Role | Description |
|--------|----------|--------------|------|------------|
| POST   | /api/products | ✅ Yes | Admin | Create new product |
| PUT    | /api/products/{id} | ✅ Yes | Admin | Update product |
| DELETE | /api/products/{id} | ✅ Yes | Admin | Delete product |
| GET    | /api/orders | ✅ Yes | Admin | Retrieve all orders |
| GET    | /api/orders/{id} | ✅ Yes | Admin | Retrieve order detail |

## 🧪 Running Feature Tests
Run all tests:
```bash
php artisan test
```
If successful:
```
PASS  Tests\Feature\ProductTest
```
## 📂 Project Structure Overview
```
app/
 ├── Http/
 │    ├── Controllers/
 │    └── Middleware/
 ├── Models/
database/
 ├── migrations/
 └── seeders/
tests/
 ├── Feature/
 └── Unit/
 ```
## 👩‍💻 Author
##### Talitha Khansa Fahira Information Systems & Technology Student - Cyber University
##### Developed for Technical Test Purposes - 2026

## 📌 Notes
##### Make sure database is running before migration.
##### Sanctum must be properly configured before testing authenticated routes.
##### Admin access is required for product management endpoints.
