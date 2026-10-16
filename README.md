# GPLYUK Backend API

This is the [Laravel](https://laravel.com) backend API service for the **GPLYUK** project.

---

## Getting Started

First, install dependencies and prepare your local environment:

```bash
# 1. Install dependencies
composer install
npm install

# 2. Setup environment configuration
cp .env.example .env
php artisan key:generate

# 3. Run database migrations
php artisan migrate
```

Then, run the development server:

```bash
composer run dev
# or
php artisan serve
```

Open [http://localhost:8000](http://localhost:8000) with your browser or API client (Postman/Insomnia) to test the server.

---

## API Development (`routes/api.php`)

This backend serves REST API endpoints for the frontend application:

- **API Routes:** Defined in `routes/api.php`.
- **URL Prefix:** All routes in this file are automatically prefixed with `/api` (for example: `http://localhost:8000/api/user`).
- **Controllers:** Located in `app/Http/Controllers/`.
- **Models:** Located in `app/Models/` (e.g. `User.php` with `HasApiTokens` for authentication).

---

## Team & Git Collaboration Workflow

To keep the codebase clean and avoid merge conflicts, team members should follow this workflow:

1. **Get the latest updates:**

    ```bash
    git checkout Staging
    git pull origin Staging
    ```

2. **Create your own feature branch:**

    ```bash
    git checkout -b feature/nama-fitur-kamu
    ```

    _Examples:_ `feature/auth-login`, `feature/kelola-produk`, `fix/navbar-issue`.

3. **Commit and push your changes:**

    ```bash
    git add .
    git commit -m "feat: deskripsi perubahan yang dibuat"
    git push origin feature/nama-fitur-kamu
    ```

4. **Open a Pull Request (PR):**
    - Open a PR from your branch to `Staging` on GitHub.
    - Wait for the automated CI tests to pass before merging.

---

## Continuous Integration (CI)

This repository includes automated CI workflows via GitHub Actions (`.github/workflows/laravel.yml`):

- Automatically triggers on push and pull requests to `main` and `Staging`.
- Sets up PHP 8.2 and a dedicated MySQL test service container.
- Verifies composer dependencies, runs database migrations, and executes the test suite (`php artisan test`).

---

## Learn More

- [Laravel Documentation](https://laravel.com/docs)
- [Laravel Sanctum (API Tokens)](https://laravel.com/docs/sanctum)
