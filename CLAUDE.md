# Critical Rules

### NEVER Sign Commits
Do NOT add "Generated with Claude Code" or "Co-Authored-By: Claude" to commits!

# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

Kolokas is a multilingual recipe sharing web application built with Laravel 8. It supports three languages: English (en), Turkish (tr), and Greek (el).

## Common Commands

```bash
# Serve locally
php artisan serve

# Asset compilation
npm run dev          # Development build
npm run watch        # Watch mode with auto-recompile
npm run prod         # Production build (with versioning)

# Database
php artisan migrate
php artisan db:seed

# Tests
php vendor/bin/phpunit              # Run all tests
php vendor/bin/phpunit tests/Unit   # Unit tests only
php vendor/bin/phpunit tests/Feature # Feature tests only
php vendor/bin/phpunit --filter=TestName  # Single test

# Cache management
php artisan config:cache
php artisan route:cache
php artisan view:clear
```

## Architecture

### Multilingual System
All routes are prefixed with locale via `mcamara/laravel-localization` (e.g., `/en/recipes`, `/tr/recipes`). Recipe content fields (title, description, ingredients, instructions, notes, servings) are translatable using `spatie/laravel-translatable`. Missing translations are auto-filled via Google Translate API (`GOOGLE_TRANSLATE_API_KEY` env var) through the `translateMissing()` helper in `app/helpers.php`. Auto-translation runs on model creating/updating events in `Recipe::fillTranslations()`.

### Reactive Components
The app uses two complementary frontend approaches:
- **Livewire 2.0** — 7 components in `app/Http/Livewire/` with views in `resources/views/livewire/` for recipe creation/editing forms
- **Vue.js 2.x** — Components in `resources/js/components/` with a global event bus (`window.events`) for flash messages

### Admin Panel
Backpack CRUD 4.1 provides the admin interface. Admin controllers are in `app/Http/Controllers/Admin/` with routes in `routes/backpack/`. Access is gated by `CheckIfAdmin` middleware.

### Key Traits
- `Favouritable` — Polymorphic favorites (used by Recipe)
- `Visitable` — Polymorphic visit tracking (used by Recipe)
- `HasTranslations` — Custom translation handling layered on Spatie's translatable

### Image Handling
Images are stored in `storage/app/public/images/recipes/`. Base64 uploads (from Livewire) and file uploads are both supported. Images are processed with `intervention/image` (JPEG, 90% quality) and named via MD5 hash.

### Route Model Binding
Recipes are resolved by `slug` (not `id`) — see `Recipe::getRouteKeyName()`.

### Responsive Stylesheets
Sass is split into breakpoint-specific files (`styles-480px.scss`, `styles-768px.scss`, etc.) compiled separately via Laravel Mix in `webpack.mix.js`.

## Key Environment Variables

- `GOOGLE_TRANSLATE_API_KEY` — Required for auto-translation
- Standard Laravel DB/Mail/Cache config in `.env`

## Code Style

StyleCI with Laravel preset (`.styleci.yml`). EditorConfig: 4-space indentation, LF line endings, UTF-8.
