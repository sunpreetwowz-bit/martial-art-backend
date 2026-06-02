# Martial Arts - Laravel API

Laravel 8 API for the Dojo Master martial arts management app. Uses MySQL and Laravel Sanctum for API authentication.

## Setup

1. Copy `.env.example` to `.env` and configure MySQL:
   ```
   DB_DATABASE=martial_arts
   DB_USERNAME=root
   DB_PASSWORD=your_password
   ```

2. Install dependencies and generate key:
   ```bash
   composer install
   php artisan key:generate
   ```

3. Run migrations and seed:
   ```bash
   php artisan migrate
   php artisan db:seed
   ```

4. Start the server:
   ```bash
   php artisan serve
   ```

API base URL: `http://localhost:8000/api`

## Default Admin

After seeding:

- **Email:** admin@dojo.com  
- **Password:** password  

## API Overview

- **POST** `/api/login` – Login (email, password)
- **POST** `/api/register` – Register (name, email, password, password_confirmation, role: student|instructor)
- **GET** `/api/user` – Current user (auth)
- **POST** `/api/logout` – Logout (auth)

**Student portal (auth):**

- **GET** `/api/student/dashboard`
- **GET** `/api/student/my-classes`
- **GET** `/api/student/my-attendance`
- **PUT** `/api/student/profile`

**Admin portal (auth + role admin):**

- **GET** `/api/admin/dashboard`
- **GET/POST** `/api/admin/students`
- **GET/PUT/DELETE** `/api/admin/students/{id}`
- **GET/POST** `/api/admin/classes`
- **GET** `/api/admin/dojos` – **POST/PUT/DELETE** dojos, belt-levels, instructors, enrollments

## CORS

CORS is configured for the React app. Ensure `config/cors.php` has `supports_credentials => true` when using Sanctum with a separate frontend.
