# Travel Itinerary Manager — Project Summary

## Project Overview
- Name: Travel Itinerary Manager
- Type: Web application (Laravel PHP)
- Purpose: Manage trips, itineraries, participants, and expenses for travel planning.

## Tech Stack
- Backend: PHP 8.x, Laravel framework
- Frontend: Blade views, Vite, JavaScript
- Package managers: Composer, NPM
- Database: MySQL 

## Key Directories & Files
- app/Models: User.php, Trip.php, ItineraryActivity.php, Expense.php
- app/Http/Controllers: (controllers live here)
- routes/web.php: main web routes
- resources/views: Blade templates (landing, checkout, etc.)
- resources/js, resources/css: frontend assets (Vite)
- database/migrations: schema changes and table definitions
- database/factories, database/seeders: test data and seeding
- tests/: Feature and Unit tests

## Main Models (brief)
- `User` — application users; migrations include profile fields and `plan` column
- `Trip` — trip records; migrations include budget (see migrations that add budget)
- `ItineraryActivity` — scheduled activities for trips
- `Expense` — expenses tied to trips; migrations add `type`, `soft deletes`, `edited_by`, and `user_id`

## Notable Database Details
- Pivot table for users and trips: `trip_user` (invitations/participation). There are migrations adding `is_accepted` to this table.
- Multiple migrations around expenses adding `type`, `soft deletes`, and `edited_by` tracking.
- Users table has a migration adding `plan` and profile fields.

## Routes & Controllers
- Main routes are in `routes/web.php` and map to controllers in `app/Http/Controllers`.
- Controllers handle trip creation, invitations (trip_user pivot), itinerary management, and expense tracking.

## Frontend & Assets
- Vite is configured (`vite.config.js`) for building assets found under `resources/js` and `resources/css`.
- Blade views render the UI (e.g., `landing.blade.php`, `checkout.blade.php`).

## Testing
- Tests are located in `tests/Feature` and `tests/Unit` with a `TestCase.php` base.

## How to Run Locally (typical steps)
1. Install PHP, Composer, Node.js, and a DB (MySQL)
2. Install PHP dependencies:

```bash
composer install
```

3. Install JS dependencies and build assets:

```bash
npm install
npm run dev   # or `npm run build` for production
```

4. Copy and configure environment:

```bash
cp .env.example .env
php artisan key:generate
# update DB credentials in .env
```

5. Run migrations and seeders:

```bash
php artisan migrate
php artisan db:seed
```

6. Serve the app locally:

```bash
php artisan serve
```

## Useful Commands
- Run tests: `vendor/bin/phpunit` or `php artisan test`
- Clear caches: `php artisan config:cache && php artisan route:cache`

## Where to Inspect for More Detail
- Models: `app/Models` — check each model file for relationships and properties
- Migrations: `database/migrations` — chronological schema changes
- Controllers & Requests: `app/Http/Controllers` and `app/Http/Requests`
- Routes: `routes/web.php`
- Views: `resources/views`

## Summary / Notes
- Project follows typical Laravel structure. Main features: multi-user trips (pivot), itinerary activities, expense tracking with types and auditing, and budget support on trips.
- For schema questions, inspect specific migration files in `database/migrations` (they contain timestamps and change descriptions).

---
Generated on: 2026-05-18
