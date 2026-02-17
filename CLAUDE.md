# Critical Rules

### NEVER Sign Commits
Do NOT add "Generated with Claude Code" or "Co-Authored-By: Claude" to commits!

# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

Kolokas is a multilingual recipe sharing web application built with Laravel 12, PHP 8.3, SQLite. It supports three languages: English (en), Turkish (tr), and Greek (el).

## Common Commands

```bash
# Serve locally
php artisan serve

# Asset compilation (Vite)
npm run dev          # Dev server with HMR
npm run build        # Production build

# Database
php artisan migrate
php artisan db:seed

# Tests
php artisan test                          # Run all tests
php artisan test tests/Feature            # Feature tests only
php artisan test --filter=TestName        # Single test

# Cache management
php artisan config:cache
php artisan route:cache
php artisan view:clear
```

## Architecture

### Multilingual System
All routes are prefixed with locale via `mcamara/laravel-localization` (e.g., `/en/recipes`, `/tr/recipes`). Recipe content fields (title, description, ingredients, instructions, notes, servings) are translatable using `spatie/laravel-translatable`. Missing translations are auto-filled via Google Translate API (`GOOGLE_TRANSLATE_API_KEY` env var) through the `translateMissing()` helper in `app/helpers.php`. Auto-translation also runs as a queue job (`TranslateRecipeFields`).

### Frontend Stack
- **Livewire 4** — Components in `app/Livewire/` with views in `resources/views/livewire/` for recipe forms, search box, favourites
- **Alpine.js** — Ships with Livewire, used for flash messages and interactive UI (replaces former Vue.js)
- **Bootstrap 5** — CSS framework, imported via Sass (`@import 'bootstrap/scss/bootstrap'`)
- **FontAwesome SVG Core** — Tree-shaken icons in `resources/js/icons.js`, uses `dom.watch()` to replace `<i>` tags with SVGs
- **Vite** — Asset bundling with 4 entry points: app.js, app.scss, styles.scss, styles-print.scss

### Admin Panel
Filament v5 provides the admin interface at `/admin`. Resources in `app/Filament/Resources/` for Recipes, Users, and Categories. Access gated by `canAccessPanel()` on User model.

### Key Traits
- `Favouritable` — Polymorphic favorites (used by Recipe)
- `Visitable` — Polymorphic visit tracking (used by Recipe)
- `HasTranslations` — Custom translation handling layered on Spatie's translatable
- `HandlesRecipeForm` — Shared logic for RecipeCreate/RecipeEdit Livewire components

### Image Handling
Images are stored in `storage/app/public/images/recipes/`. Processing handled by `ImageService` (`app/Services/ImageService.php`). Uses `intervention/image` (JPEG, 90% quality), named via MD5 hash.

### Route Model Binding
Recipes are resolved by `slug` (not `id`) — see `Recipe::getRouteKeyName()`.

### Authorization
`RecipePolicy` handles recipe authorization (edit, update, delete). Registered in `AuthServiceProvider`.

### Caching
Category and recipe caches are invalidated via model observers in `AppServiceProvider`. Search box stats are cached with explicit invalidation.

## Key Environment Variables

- `GOOGLE_TRANSLATE_API_KEY` — Required for auto-translation
- `DB_CONNECTION=sqlite` — Default database
- Standard Laravel Mail/Cache config in `.env`

## Code Style

EditorConfig: 4-space indentation, LF line endings, UTF-8.
