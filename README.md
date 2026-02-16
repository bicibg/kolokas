# Kolokas

Multilingual recipe-sharing platform featuring traditional Cypriot cuisine in English, Turkish, and Greek.

**Live:** [kolokas.com](https://kolokas.com)

## Tech Stack

- **Backend:** Laravel 12, PHP 8.3, Livewire 4, Filament 5
- **Frontend:** Vue 2, Bootstrap 4, Vite 6
- **Database:** SQLite
- **Translations:** Spatie Laravel Translatable + Google Translate API
- **Localization:** mcamara/laravel-localization (en, tr, el)

## Setup

```bash
composer install
npm install

cp .env.example .env
php artisan key:generate

touch database/database.sqlite
php artisan migrate --seed

npm run dev
php artisan serve
```

## Testing

```bash
php artisan test
php artisan test --filter=RecipeShowTest   # single test class
```

## CI/CD

GitHub Actions runs on push/PR to master: PHPUnit tests + npm build verification.

## Admin

- Filament admin panel: `/admin`
- Log viewer: `/log-viewer`

## Deployment

Deployed via Laravel Forge. After deploy:

```bash
php artisan optimize:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan queue:restart
```
