# BlogApp

A full-stack blog application built with Laravel. Users can register, log in, write blog posts, and like or dislike each other's posts. The app ships with two interfaces — a server-rendered Blade web UI and a REST API for a React frontend. Unit tests conducted using Pest.

---

## Screenshots

### Login
<img width="969" height="594" alt="image" src="https://github.com/user-attachments/assets/89117596-38bb-4e4c-9ee3-5f7dfc665a39" />


### Register
<img width="975" height="634" alt="image" src="https://github.com/user-attachments/assets/06335f60-af0b-4529-9655-6be7935409da" />


### All Blog Posts
<img width="975" height="488" alt="image" src="https://github.com/user-attachments/assets/b582df2d-772a-4405-874c-422fe0bea8b8" />


### New Blog Post
<img width="975" height="530" alt="image" src="https://github.com/user-attachments/assets/31ea790c-39fe-4cd9-9698-452dbec1aa58" />

<img width="975" height="400" alt="image" src="https://github.com/user-attachments/assets/fd47a539-085b-4fe4-b7cf-8123e6b95f70" />


### Edit Blog Post
<img width="975" height="508" alt="image" src="https://github.com/user-attachments/assets/ba3354e6-229b-4c39-b39d-48522a0fcddd" />

<img width="975" height="393" alt="image" src="https://github.com/user-attachments/assets/a08db907-bb7b-45fe-88d7-27b3a48e013e" />


---

## Features

- User registration and login with email verification
- Create, view, edit, and delete blog posts
- View posts from all users on the index page
- Like and dislike any post (toggleable, one vote per user per post)
- Edit and delete controls restricted to the original poster
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
