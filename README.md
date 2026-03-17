# BlogApp

A full-stack blog application built with Laravel. Users can register, log in, write blog posts, and like or dislike each other's posts. The app ships with two interfaces — a server-rendered Blade web UI and a REST API for a React frontend. Unit tests conducted using Pest.

---

## Screenshots

### Login
<img width="969" height="594" alt="image" src="https://github.com/user-attachments/assets/d33401d2-238f-4bcb-9743-5d647a3bc206" />


### Register
<img width="975" height="634" alt="image" src="https://github.com/user-attachments/assets/41f2c8ce-9796-4c3d-b377-4b658f2c584d" />


### All Blog Posts
<img width="975" height="488" alt="image" src="https://github.com/user-attachments/assets/cef3263e-b9bd-47b8-bd4d-01b5ba42f3ff" />


### New Blog Post
<img width="975" height="530" alt="image" src="https://github.com/user-attachments/assets/71bf1a8a-c355-42bd-8016-ccc39c04c207" />

<img width="975" height="400" alt="image" src="https://github.com/user-attachments/assets/6b411881-4d4f-4372-8e24-cc9a4ea8a522" />


### Edit Blog Post
<img width="975" height="508" alt="image" src="https://github.com/user-attachments/assets/02a238ae-a6d3-4825-995f-c566bfc9538a" />

<img width="975" height="393" alt="image" src="https://github.com/user-attachments/assets/2c3284bb-f0c3-419b-9abb-e812fd66161d" />


---

## Features

- User registration and login with email verification
- Create, view, edit, and delete blog posts
- View posts from all users on the index page
- Like and dislike any post (toggleable, one vote per user per post)
- Edit and delete controls restricted to the post owner
- REST API with Bearer token authentication (Laravel Passport)
- Full test suite using Pest

---

## Tech Stack

| Layer | Technology |
|---|---|
| Backend framework | Laravel 11 |
| Database | MySQL |
| Web authentication | Laravel Breeze (session-based) |
| API authentication | Laravel Passport (OAuth2 Bearer tokens) |
| Frontend (web) | Blade + Tailwind CSS |
| Frontend (React) | Separate React project consuming the API |
| Testing | Pest |

---

## Requirements

- PHP 8.2+
- Composer
- MySQL
- npm

---

## Installation


**1. Install dependencies**
```bash
composer install
npm install
```

**2. Set up environment**
```bash
cp .env.example .env
php artisan key:generate
```

**3. Configure your database**

Update the following values in `.env` to match your MySQL setup:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

Create the database in MySQL:
```sql
CREATE DATABASE your_database_name;
```

**5. Run migrations and seed**
```bash
php artisan migrate --seed
php artisan passport:client --personal --no-interaction
```

**6. Build frontend assets**
```bash
npm run dev
```

---

## Running the App

```bash
php artisan serve
```

The app will be available at `http://127.0.0.1:8000`.

---


## Running Tests

```bash
php artisan test
```
