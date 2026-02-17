# Audit Progress

## Session 1 — 2026-02-16

### Completed
- Full codebase audit across all 10 areas
- Created audit documentation structure in /docs/audit/
- Files created: AUDIT_REPORT.md, FINDINGS.md, BACKLOG.md, PROGRESS.md

### Findings Summary
- **5 CRITICAL**, **32 HIGH**, **60 MEDIUM**, **34 LOW**, **11 INFO**
- Total: ~142 findings (some overlap between audit areas)

### Areas Audited
1. Security (auth, XSS, CSRF, headers, rate limiting, file uploads)
2. Code Quality (duplication, dead code, naming, bugs)
3. Architecture (N+1 queries, missing indexes, fat models, no policies)
4. Frontend (Vue 2 EOL, Bootstrap 4, JS quality)
5. SEO (no meta description, no JSON-LD, no hreflang, no canonical)
6. Accessibility (missing aria-labels, alt text, skip nav, contrast)
7. Performance (bundle size, lazy loading, font loading)
8. Testing (zero coverage, no CI)
9. CI/CD (nothing configured)
10. Infrastructure (logging, caching, queues, error tracking)

### Key Discoveries
- **RegisterController logs plaintext passwords** (CQ-001) — immediate security fix needed
- **Recipe::setImagesAttribute has double-prefix bug** (CQ-007) — corrupts image URLs
- **/translate endpoint is unauthenticated** (SEC-002) — Google API cost abuse vector
- **Recipe $appends causes 64+ extra queries on listing pages** (ARCH-002)
- **No tests, no CI, no error tracking** (TEST-001, CICD-001, INFRA-005)
- **No SEO fundamentals** for a recipe site (meta description, JSON-LD, hreflang)

### Next Session
- Begin P0 fixes (password logging, double-prefix bug, translate auth)
- Then P1 quick wins (SEO tags, a11y fixes, security headers)

---

## Session 2 — 2026-02-16

### Completed — All P0 Fixes
- **CQ-001**: Removed `Log::info(print_r($data))` that leaked plaintext passwords to logs
- **CQ-007**: Fixed double-prefixed image URL in `setImagesAttribute` (`images/recipes/images/recipes/` -> `images/recipes/`)
- **SEC-002**: Added `auth` + `throttle:10,1` middleware to `/translate` route
- **SEC-001**: Removed `created_by`/`updated_by` from Recipe `$fillable` (kept toggles for Filament admin)
- **CQ-006**: Moved `$this->validate()` before all file/DB operations in `RecipeEdit::submit()`
- **CQ-005**: Removed broken manual `DB::commit()`/`DB::rollBack()` inside `DB::transaction()` closure
- **CQ-003 (toggleExistingImage)**: Fixed `$existing_images[]` -> `$this->existing_images[]`
- **CQ-019**: Replaced `detach()` + loop `attach()` with `sync()`
- **ARCH-009** (partial): Fixed `file_exists()` -> `Storage::disk('public')->exists()` in RecipeEdit

### Also Fixed
- Storage::delete paths corrected to include `public/` prefix
- Removed unused `Log` import from RecipeEdit
- Updated BACKLOG.md and PROGRESS.md

### Next Session
- P1 quick wins: SEO tags, a11y fixes, security headers, lazy loading
- Then P2: JSON-LD, database indexes, N+1 query fixes

---

## Session 3 — 2026-02-16

### Completed — SEO Deep Dive + P1 Quick Wins

#### Phase 1: SEO Foundations
- **SEO-001**: Added `<meta name="description">` with `@yield('meta_description')` to layout
- **SEO-003**: Added `<link rel="canonical">` using `url()->current()`
- **SEO-004**: Added hreflang tags for en/tr/el + x-default using LaravelLocalization
- Updated OG tags: renamed sections from `facebook_share_*` to `og_*`, added `og:site_name`, fixed `og:type` default from "article" to "website"
- Added Twitter Card meta tags (card, title, description, image)
- Added recipe-specific meta overrides in `recipe/show.blade.php`
- Fixed recipe title from `<h2>` to `<h1>` on show page

#### Phase 2: JSON-LD Structured Data
- **SEO-002**: Created `partials/recipe-schema.blade.php` — full schema.org/Recipe with ingredients, instructions (HowToStep), times, categories, author, publisher
- Created `partials/organization-schema.blade.php` — Organization with social sameAs links
- Created `partials/website-schema.blade.php` — WebSite with SearchAction
- Created `partials/breadcrumb-schema.blade.php` — BreadcrumbList with dynamic crumbs
- Added `@stack('schema')` to layout head for JSON-LD injection
- Included Organization + WebSite schemas on homepage
- Included Recipe + Breadcrumb schemas on recipe show page

#### Phase 3: Technical SEO
- Enhanced sitemap with proper xhtml:link hreflang alternates for all URLs
- Localized static pages in sitemap (home, recipes, authors, contact, about-us)
- Fixed homepage carousel H1 → H2 (carousel titles shouldn't be H1)
- **SEO-007**: Removed dead UA analytics (UA-86539141-2)
- Updated robots.txt with admin/livewire disallows

#### Phase 4: P1 Quick Wins
- **SEC-017**: Created SecurityHeaders middleware (X-Content-Type-Options, X-Frame-Options, HSTS, Referrer-Policy, Permissions-Policy)
- **SEC-020**: Added `throttle:5,1` to /contact and /subscribe POST routes
- **A11Y-001**: Added skip-to-content link with `id="main-content"` on `<main>`
- **A11Y-002/003**: Added aria-labels + `rel="noopener"` to all icon-only social links (topbar + share-modal)
- **A11Y-004**: Added meaningful alt text to about_us team photos
- **PERF-002**: Added `loading="lazy"` to recipe card images
- **CQ-010**: Removed unused `ContactFormMessage` import from ContactController, `Response` from RecipeController
- **CQ-011/012**: Removed empty `destroy()` method and dead `recipe.update` PATCH route
- **FE-016**: Removed duplicate Google Fonts `<link>` tag (kept SCSS @import)

#### Phase 5: Data Repair
- Checked database for double-prefixed image URLs — none found (bug was fixed before new data was created)

### Files Created
- `app/Http/Middleware/SecurityHeaders.php`
- `resources/views/partials/recipe-schema.blade.php`
- `resources/views/partials/organization-schema.blade.php`
- `resources/views/partials/website-schema.blade.php`
- `resources/views/partials/breadcrumb-schema.blade.php`

### Files Modified
- `resources/views/layouts/app.blade.php` — meta tags, hreflang, OG/Twitter, skip-nav, removed dead analytics + duplicate font
- `resources/views/recipe/show.blade.php` — meta overrides, H1 fix, JSON-LD includes
- `resources/views/home/index.blade.php` — Organization + WebSite schema includes
- `resources/views/home/partial/carousel.blade.php` — H1 → H2
- `resources/views/home/about_us.blade.php` — alt text
- `resources/views/partials/topbar.blade.php` — aria-labels, rel="noopener"
- `resources/views/partials/share-modal.blade.php` — aria-labels, rel="noopener"
- `resources/views/livewire/recipe-box.blade.php` — loading="lazy"
- `resources/views/sitemap.blade.php` — hreflang alternates, localized static pages
- `routes/web.php` — throttle on contact/subscribe, removed dead route
- `bootstrap/app.php` — SecurityHeaders middleware registration
- `app/Http/Controllers/ContactController.php` — removed unused import
- `app/Http/Controllers/RecipeController.php` — removed destroy() + unused imports
- `public/robots.txt` — disallow admin paths
- `docs/audit/BACKLOG.md` — checked off completed items
- `docs/audit/PROGRESS.md` — added session 3 entry

### Next Session
- P2 items: database indexes, N+1 query fixes ($appends, $with), caching
- P3 items: tests, CI pipeline, bundle optimization

---

## Session 4 — 2026-02-16

### Completed — P2 Architecture & Performance

#### Phase 1: Fix N+1 Query Issues (ARCH-002, ARCH-003)
- **ARCH-002**: Removed `favouritesCount`, `isFavourited`, `isVisited`, `visitsCount` from Recipe `$appends` (kept `url`)
- **ARCH-003**: Removed global `$with = ['author', 'images']` from Recipe model
- Added explicit `with(['author', 'images'])->withCount('favourites', 'visits')` in:
  - `HomeController::index()` — all 5 recipe queries
  - `RecipeController::index()`, `show()`, `myRecipes()`, `favourites()`, `edit()`
  - `ProfileController::show()`
  - `RecipeBox::pullRecipe()` and `favourite()` refresh
  - `Favourite::favourite()` refresh
- Updated `recipe-box.blade.php` and `Favourite.php` templates to use `favourites_count`/`visits_count` with fallback

#### Phase 2: Database Indexes (ARCH-004)
- Created migration `add_performance_indexes` with indexes on:
  - `recipes`: slug, published, featured, composite(published+featured), created_at
  - `favourites`: favourited_id
  - `visits`: visited_id
  - `category_recipe`: recipe_id, category_id
- Migration ran successfully on SQLite

#### Phase 3: Caching & SearchBox Optimization (ARCH-014, ARCH-008, INFRA-011)
- **ARCH-008**: Replaced 8 separate queries in RecipeSearchBox with single cached aggregate query
- **INFRA-011**: Added cache invalidation for categories and search stats via model events in AppServiceProvider
- Category cache already existed (`Cache::rememberForever('categories')`) — added `saved`/`deleted` listeners

#### Phase 4: Authorization & Error Handling
- **ARCH-005**: Created `RecipePolicy` with `update()` and `delete()` methods. Replaced inline auth checks in `RecipeController::edit()` and `RecipeEdit::submit()` with policy calls
- **ARCH-007**: Added try/catch to `translate()` helper — returns original text on failure instead of crashing
- **SEC-018**: Changed TrustProxies from `'*'` (all) to `'127.0.0.1'` (nginx only)

#### Phase 5: Data & Relationship Fixes
- **CQ-015**: Fixed `Category::recipes()` from `hasManyThrough` to `belongsToMany`. Deleted unused `CategoryRecipe` model
- **CQ-022**: Fixed `ProfileController::index()` orWhere scoping — wrapped search in closure to preserve `has('user.recipes')` constraint

#### Phase 6: DX Improvements
- **DX-007**: Updated `.env.example` — changed to SQLite, removed MySQL/Redis/Pusher/AWS, added GOOGLE_TRANSLATE_API_KEY and SENTRY config

### Files Created
- `app/Policies/RecipePolicy.php`
- `database/migrations/2026_02_16_225613_add_performance_indexes.php`

### Files Modified
- `app/Models/Recipe.php` — removed `$with`, removed 4 items from `$appends`
- `app/Models/Category.php` — fixed `recipes()` relationship to `belongsToMany`
- `app/Http/Controllers/HomeController.php` — explicit eager loading + withCount
- `app/Http/Controllers/RecipeController.php` — eager loading, withCount, policy auth
- `app/Http/Controllers/ProfileController.php` — eager loading, orWhere scoping fix
- `app/Livewire/RecipeBox.php` — eager reload on favourite/pullRecipe
- `app/Livewire/Favourite.php` — eager reload, template uses favourites_count
- `app/Livewire/RecipeSearchBox.php` — single aggregate query, cached
- `app/Livewire/RecipeEdit.php` — policy-based auth check
- `app/Providers/AppServiceProvider.php` — cache invalidation events
- `app/helpers.php` — translate() error handling
- `bootstrap/app.php` — TrustProxies 127.0.0.1
- `.env.example` — updated for current stack
- `resources/views/livewire/recipe-box.blade.php` — favourites_count/visits_count

### Files Deleted
- `app/Models/CategoryRecipe.php`

### Next Session
- P3 items: tests, CI pipeline, bundle optimization
- INFRA-005: Sentry integration (composer require)

---

## Session 5 — 2026-02-17

### Completed — P3: Testing, CI/CD, Refactoring & Performance

#### Phase 1: Log Viewer Integration (INFRA-005)
- Replaced Sentry with `opcodesio/log-viewer` (user preference)
- Configured admin-only access via `LogViewer::auth()` in AppServiceProvider
- Available at `/log-viewer` for admin users

#### Phase 2: Feature Tests (TEST-001)
- **39 tests, 87 assertions** — from zero coverage to comprehensive test suite
- Configured PHPUnit for SQLite in-memory, disabled locale redirect middleware in tests
- **Auth tests** (11): Registration (valid, duplicate, missing fields, short password), Login (correct, wrong password, nonexistent email), Logout, Guest redirect
- **Recipe tests** (7): Show (published/unpublished), Listing (published/unpublished/auth), My Recipes (auth required, own recipes)
- **Authorization tests** (4): Owner access, non-owner denied, admin override, guest redirect
- **SEO tests** (8): Meta description, canonical, hreflang (en/tr/el/x-default), OpenGraph, Twitter Card, JSON-LD, sitemap
- **Security tests** (7): X-Content-Type-Options, X-Frame-Options, Referrer-Policy, Permissions-Policy, rate limiting (contact, subscribe, translate)
- **Translation tests** (3): Unauthenticated denied, authenticated access, empty input handling

#### Phase 3: GitHub Actions CI/CD (CICD-001)
- Created `.github/workflows/ci.yml` with two jobs:
  - `test`: PHP 8.3, Composer, Node 20, SQLite, migrations, `php artisan test`
  - `build`: Node 20, `npm run build` verification
- Runs on push/PR to master

#### Phase 4: Refactoring (CQ-008)
- Extracted `HandlesRecipeForm` trait from RecipeCreate/RecipeEdit
- Shared: properties, locale init, tab switching, tab checks, validation rules, image storage, render
- RecipeCreate: 186 → 68 lines, RecipeEdit: 244 → 131 lines
- Both components still use the same Blade view (`livewire.recipe-create`)

#### Phase 5: XSS Fixes (SEC-010)
- `{!! cache('translations') !!}` → `{{ Js::from(cache('translations')) }}` in layout
- 9 error pages: escaped `$exception->getMessage()` with `{{ }}`, kept `{!! !!}` only for trusted default HTML

#### Phase 6: Frontend Bundle Optimization (PERF-001)
- **Removed lodash** (~72KB): replaced `_.forEach` with `Object.entries().forEach()`
- **Removed axios** (~14KB): replaced with native `fetch()` + CSRF token header
- **Removed jQuery UI** (~26KB + CSS): was imported but never used (sliders use native `<input type="range">`)
- **JS bundle**: 449KB → 337KB (gzipped: 152KB → 112KB) — **25% reduction**
- **CSS bundle**: 270KB → 236KB (gzipped: 48KB → 41KB) — **13% reduction** (removed jquery-ui CSS)

### Files Created
- `app/Livewire/Concerns/HandlesRecipeForm.php`
- `.github/workflows/ci.yml`
- `config/log-viewer.php`
- `tests/Feature/Auth/RegistrationTest.php`
- `tests/Feature/Auth/LoginTest.php`
- `tests/Feature/Recipe/RecipeShowTest.php`
- `tests/Feature/Recipe/RecipeListingTest.php`
- `tests/Feature/Recipe/RecipeAuthorizationTest.php`
- `tests/Feature/Translation/TranslateEndpointTest.php`
- `tests/Feature/Seo/MetaTagsTest.php`
- `tests/Feature/Security/SecurityHeadersTest.php`
- `tests/Feature/Security/RateLimitingTest.php`

### Files Modified
- `app/Livewire/RecipeCreate.php` — refactored to use HandlesRecipeForm trait (186 → 68 lines)
- `app/Livewire/RecipeEdit.php` — refactored to use HandlesRecipeForm trait (244 → 131 lines)
- `app/Providers/AppServiceProvider.php` — LogViewer auth gate
- `resources/js/bootstrap.js` — removed lodash and axios imports
- `resources/js/app.js` — removed jQuery UI imports
- `resources/js/trans.js` — replaced _.forEach with native, axios.post with fetch
- `resources/sass/app.scss` — removed jquery-ui CSS import
- `resources/views/layouts/app.blade.php` — `Js::from()` for translations
- `resources/views/errors/*.blade.php` (9 files) — escaped exception messages
- `tests/TestCase.php` — disabled locale redirect middleware
- `tests/Feature/ExampleTest.php` — added RefreshDatabase
- `phpunit.xml` — SQLite in-memory, output buffer config
- `.env.example` — replaced Sentry vars with LOG_VIEWER_ENABLED
- `package.json` — removed lodash, axios, jquery-ui
- `composer.json` — added opcodesio/log-viewer, removed sentry/sentry-laravel
- `docs/audit/BACKLOG.md` — checked off P3 items
- `docs/audit/PROGRESS.md` — session 5 entry

### Remaining (P3/P4)
- ARCH-010: Extract image processing to service
- INFRA-012: Async translation via queue
- PERF-004: FontAwesome subsetting (36 icons identified)
- PERF-005: Consolidate breakpoint CSS
- FE-001/002/003: Vue 2→3, Bootstrap 4→5, drop jQuery
- DX-008: README

---

## Session 6 — 2026-02-17

### Completed — Remaining P3 + P4 Quick Wins

#### Phase 1: Extract Image Processing (ARCH-010)
- Created `app/Services/ImageService.php` with `storeUploadedImage()`, `storeRecipeImages()`, `deleteImage()`, `deleteRecipeImagesByIds()`
- Updated `HandlesRecipeForm` trait to delegate to ImageService
- Updated `RecipeEdit` to use ImageService for image deletion
- Removed dead base64 image mutators (`setMainImageAttribute`, `setImagesAttribute`) from Recipe model
- Removed unused imports (Storage, Image, File) from Recipe model

#### Phase 2: Async Translation Queue (INFRA-012)
- Created `TranslateRecipeFields` job with retry logic (3 tries, 30s backoff)
- Moved translation from synchronous model boot events to async queue dispatch
- Extracted slug generation to separate `generateSlug()` method
- Created `jobs` table migration for database queue driver
- Updated `.env.example`: `QUEUE_CONNECTION=database`

#### Phase 3: FontAwesome Subsetting (PERF-004)
- Replaced full FontAwesome CSS/webfonts with SVG core + tree-shaken imports
- Created `resources/js/icons.js` — imports only 36 used icons (23 solid, 4 regular, 8 brands)
- Updated all FA4 class names to FA5 across 19 files (fas/far/fab prefixes, renamed icons)
- Removed `@fortawesome/fontawesome-free` package, added SVG core packages
- Removed duplicate FontAwesome loading (was in both `app.scss` and `fontawesome.scss`)
- Updated CSS selectors for SVG compatibility (.fa → .svg-inline--fa)
- Replaced FontAwesome unicode checkmark with CSS unicode (\\2714)

#### Phase 4: CSS Consolidation (PERF-005)
- Merged 4 breakpoint files into `styles.scss` (480px, 768px, 992px empty, 1200px)
- Deleted `styles-480px.scss`, `styles-768px.scss`, `styles-992px.scss`, `styles-1200px.scss`, `fontawesome.scss`
- Reduced Vite entry points from 9 to 4 (app.js, app.scss, styles.scss, styles-print.scss)
- Reduced HTTP requests from 9 to 4

#### Phase 5: Accessibility Fixes (A11Y-008, A11Y-010, A11Y-011)
- **A11Y-008**: Replaced `display: none` with visually-hidden technique for checkboxes (image-checkbox + ingredient-check)
- **A11Y-010**: Added global `:focus-visible` outline styles, replaced `outline: none` with `:focus:not(:focus-visible)` pattern
- **A11Y-011**: Fixed body text contrast (#888 → #595959), fixed secondary text colors (#999/#aaa/#ccc → #767676)

#### Phase 6: DX & Config Fixes
- **DX-008**: Replaced default Laravel README with project-specific documentation
- **SEC-004**: Added `MustVerifyEmail` to User model, created backfill migration for existing users
- **ARCH-011**: Already implemented (RememberLocale already checks locale !== App::getLocale())
- Added `MAIL_FROM_ADDRESS` and `MAIL_FROM_NAME` to phpunit.xml for verification email tests
- Added `verified` middleware to recipe create/edit routes

### Files Created
- `app/Services/ImageService.php`
- `app/Jobs/TranslateRecipeFields.php`
- `resources/js/icons.js`
- `database/migrations/2026_02_16_233719_create_jobs_table.php`
- `database/migrations/2026_02_16_234550_backfill_email_verified_at_for_existing_users.php`

### Files Modified
- `app/Models/Recipe.php` — removed image mutators, async translation dispatch, slug extraction
- `app/Models/User.php` — added MustVerifyEmail, removed unused Hash import
- `app/Livewire/Concerns/HandlesRecipeForm.php` — delegates to ImageService
- `app/Livewire/RecipeEdit.php` — uses ImageService for deletion
- `app/Livewire/Favourite.php` — FA5 class names
- `resources/js/app.js` — imports icons.js
- `resources/sass/app.scss` — removed FontAwesome imports
- `resources/sass/styles.scss` — merged breakpoints, a11y fixes, FA5 selectors
- `resources/views/layouts/app.blade.php` — 4 Vite entry points (was 9)
- `vite.config.js` — 4 entry points (was 9)
- 16 Blade templates — FA4 → FA5 class names
- `routes/web.php` — verified middleware, Auth::routes(['verify' => true])
- `.env.example` — QUEUE_CONNECTION=database
- `phpunit.xml` — MAIL_FROM_ADDRESS/NAME for test env
- `package.json` — swapped fontawesome-free for SVG core packages
- `README.md` — project-specific docs
- `docs/audit/BACKLOG.md` — checked off all completed items
- `docs/audit/PROGRESS.md` — session 6 entry

### Files Deleted
- `resources/sass/styles-480px.scss`
- `resources/sass/styles-768px.scss`
- `resources/sass/styles-992px.scss`
- `resources/sass/styles-1200px.scss`
- `resources/sass/fontawesome.scss`

### Remaining
- **FE-001/002/003**: Vue 2→3, Bootstrap 4→5, drop jQuery (separate project)

---

## Session 7 — 2026-02-17

### Completed — Frontend Modernization (FE-001/002/003) — AUDIT COMPLETE

#### Phase 1: Remove Vue.js (FE-001)
- Removed Vue 2 entirely — replaced with Alpine.js (ships with Livewire 4)
- Replaced `Flash.vue` component with Alpine.js `flashMessage` data component
- Replaced `<base-button>` Vue component with plain HTML `<button>`/`<a>` in 10 templates (15 instances)
- Replaced Vue event bus (`window.events = new Vue()`) with native `CustomEvent` dispatch
- Removed `v-pre` attributes from navbar/topbar (no longer needed without Vue)
- Removed Vue mixin export from trans.js (kept window.__ and window.gtranslate)
- Removed `@vitejs/plugin-vue2` from Vite config
- JS bundle: 424KB → 264KB (-38%)

#### Phase 2: Bootstrap 4 → 5 + Remove jQuery (FE-002/003)
- Upgraded `bootstrap` 4.x → 5.x, replaced `popper.js` with `@popperjs/core`
- Removed jQuery (no longer needed by BS5)
- Removed `bootstrap-select` jQuery plugin, replaced with native `<select class="form-select">`
- Rewrote `bootstrap.js`: BS5 ESM imports (no jQuery)
- Rewrote `custom.js`: vanilla JS (lockScroll toggle)
- Migrated all `data-*` attributes to `data-bs-*` across 15 templates (~47 occurrences)
- Migrated all deprecated BS4 class names to BS5 equivalents across ~30 templates:
  - Spacing: `ml-*`→`ms-*`, `mr-*`→`me-*`, `pl-*`→`ps-*`, `pr-*`→`pe-*`
  - Text: `text-left`→`text-start`, `text-right`→`text-end`, `text-md-right`→`text-md-end`
  - Floats: `float-right`→`float-end`
  - Typography: `font-weight-bold`→`fw-bold`, `font-weight-light`→`fw-light`, `font-italic`→`fst-italic`
  - Accessibility: `sr-only`→`visually-hidden`, `sr-only-focusable`→`visually-hidden-focusable`
  - Forms: `form-group`→`mb-3`, `form-row`→`row g-3`, `form-inline`→`d-flex align-items-center`
  - Custom controls: `custom-control custom-checkbox`→`form-check`, etc.
  - Badges: `badge-pill`→`rounded-pill`, `badge-primary`→`text-bg-primary`
  - Layout: `dropdown-menu-right`→`dropdown-menu-end`, `close`→`btn-close`
- Converted carousel controls from `<a>` to `<button>` elements
- Updated share modal close button to BS5 format
- Removed dead BS3 CSS selectors from styles.scss
- JS bundle: 264KB → 171KB (-35%)

### Bundle Size Summary (Session 1 → Session 7)
| Asset | Before Audit | After Session 7 | Savings |
|-------|-------------|-----------------|---------|
| JS | 449KB (152KB gz) | 171KB (53KB gz) | **-62%** |
| CSS (app) | 270KB (48KB gz) | 227KB (31KB gz) | **-16%** |
| CSS (styles) | — | 21KB (5KB gz) | consolidated |
| CSS (FA) | — | 12KB (2KB gz) | SVG core |
| Total | ~719KB | ~431KB | **-40%** |

### Files Created
- None

### Files Modified
- `resources/js/app.js` — removed Vue, added Alpine.js flash component
- `resources/js/bootstrap.js` — BS5 ESM imports, no jQuery
- `resources/js/custom.js` — vanilla JS lockScroll
- `resources/js/trans.js` — removed Vue mixin export
- `resources/sass/app.scss` — BS5 import, removed bootstrap-select
- `resources/sass/styles.scss` — updated .custom-control-label → .form-check-label, removed dead BS3 CSS
- `vite.config.js` — removed vue2 plugin and jQuery/Vue aliases
- ~30 Blade templates — BS4→BS5 data attributes, class names, component replacements
- `package.json` — removed vue, jquery, popper.js, bootstrap-select, @vitejs/plugin-vue2; added bootstrap@5, @popperjs/core

### Files Deleted
- `resources/js/components/Flash.vue`
- `resources/js/components/BaseButtonComponent.vue`

### AUDIT STATUS: COMPLETE
All 56/56 findings addressed across 7 sessions.
