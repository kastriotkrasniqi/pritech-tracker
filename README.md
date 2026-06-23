# Pritech Tracker

A project and issue tracking application built with Laravel, Blade, Alpine.js, and Tailwind CSS.

## Description

Pritech Tracker is a full-featured project management tool that lets teams create projects, manage issues with status and priority tracking, organise work with colour-coded tags, and collaborate via comments — all without page reloads for tag/user assignment and comment interactions.

## Tech Stack

- **Backend:** Laravel 12, PHP 8.2
- **Frontend:** Blade templates, Alpine.js, Tailwind CSS
- **Auth:** Laravel Breeze
- **Database:** SQLite
- **Testing:** PHPUnit (38 tests)

## Features

### Core
- Projects CRUD with start date and deadline
- Issues CRUD with status (`open`, `in_progress`, `closed`) and priority (`low`, `medium`, `high`, `critical`) enums
- Tags with name (unique) and optional hex colour
- Comments per issue with author name and body
- Issues list with filters: status, priority, tag
- Eager loading throughout — no N+1 queries
- Resource controllers with Form Request validation
- Migrations, model factories, and database seeders

### Bonus
- User many-to-many assignment on issues (AJAX, no page reload)
- ProjectPolicy — only the project owner can edit or delete
- Issue search with debounced AJAX (no page reload)
- Tag attach/detach via AJAX (no page reload)
- Comments loaded and submitted via AJAX with inline validation (no alert boxes)

## Setup

```bash
git clone <repo-url> pritech-tracker
cd pritech-tracker

composer install
npm install

cp .env.example .env
php artisan key:generate

touch database/database.sqlite
php artisan migrate --seed

npm run build
php artisan serve
```

Open [http://localhost:8000](http://localhost:8000) in your browser.

## Demo Credentials

| Field    | Value              |
|----------|--------------------|
| Email    | demo@example.com   |
| Password | password           |

You can also register a new account on the registration page.

## Running Tests

```bash
php artisan test
```

All 38 tests should pass.

## License

MIT
