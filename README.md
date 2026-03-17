# Blog App

A full-stack blog application built with Laravel. Users can register, log in, write blog posts, and like or dislike each other's posts. The app ships with two interfaces — a server-rendered Blade web UI and a REST API for a React frontend.

---

## Screenshots

### Login
<!-- paste screenshot here -->

### Register
<!-- paste screenshot here -->

### All Blog Posts
<!-- paste screenshot here -->

### New Blog Post
<!-- paste screenshot here -->

### Edit Blog Post
<!-- paste screenshot here -->

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
- Node.js & npm

---

## Installation

**1. Clone the repository**
```bash
git clone <repository-url>
cd crashcourse
```

**2. Install dependencies**
```bash
composer install
npm install
```

**3. Set up environment**
```bash
cp .env.example .env
php artisan key:generate
```

**4. Configure your database**

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

## API

The REST API is available at `/api/*` and uses Laravel Passport Bearer tokens.

### Authentication

| Method | Endpoint | Auth | Description |
|---|---|---|---|
| POST | `/api/register` | No | Register a new user. Returns `user` + `token` |
| POST | `/api/login` | No | Login. Returns `user` + `token` |
| POST | `/api/logout` | Yes | Revoke the current token |
| GET | `/api/me` | Yes | Get the authenticated user |

### Blog Posts

| Method | Endpoint | Auth | Description |
|---|---|---|---|
| GET | `/api/posts` | Yes | List all posts (paginated) |
| POST | `/api/posts` | Yes | Create a post |
| GET | `/api/posts/{id}` | Yes | Get a single post |
| PUT | `/api/posts/{id}` | Yes | Update a post (owner only) |
| DELETE | `/api/posts/{id}` | Yes | Delete a post (owner only) |
| POST | `/api/posts/{id}/vote/like` | Yes | Like a post |
| POST | `/api/posts/{id}/vote/dislike` | Yes | Dislike a post |

Include the token in the `Authorization` header on all protected requests:
```
Authorization: Bearer <your-token>
```

---

## Running Tests

```bash
php artisan test
```

---

## License

This project is open-sourced under the [MIT license](https://opensource.org/licenses/MIT).
