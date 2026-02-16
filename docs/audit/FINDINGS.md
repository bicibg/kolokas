# Audit Findings

All findings from the full codebase audit, deduplicated and organized by severity.

---

## CRITICAL

### CQ-001: Debug print_r logs plaintext passwords
- **File:** `app/Http/Controllers/Auth/RegisterController.php:68`
- **Description:** `Log::info('Something for bugra: ' . print_r($data, true))` logs the entire registration `$data` array including plaintext passwords to application logs.
- **Fix:** Remove the debug log statement immediately.

### SEO-001: No meta description tag on any page
- **File:** `resources/views/layouts/app.blade.php`
- **Description:** No `<meta name="description">` tag exists. Search engines auto-generate snippets, which is suboptimal.
- **Fix:** Add `<meta name="description" content="@yield('meta_description', 'Kolokas - Authentic Cyprus Recipes')">` to layout.

### SEO-002: No JSON-LD structured data for recipes
- **File:** `resources/views/recipe/show.blade.php`
- **Description:** Recipe pages have no schema.org/Recipe structured data. Critical for Google rich results (recipe cards).
- **Fix:** Add `<script type="application/ld+json">` block with Recipe schema.

### TEST-001: Zero meaningful test coverage
- **File:** `tests/`
- **Description:** Only 2 scaffold tests exist. 65+ app files untested. No auth, CRUD, translation, or Livewire tests.
- **Fix:** Start with feature tests for auth, recipe CRUD, and the translation endpoint.

### CICD-001: No CI/CD pipeline
- **Description:** No GitHub Actions, no automated testing, linting, or deployment pipeline.
- **Fix:** Add GitHub Actions workflow with PHP lint, PHPUnit, npm build.

---

## HIGH

### SEC-001: Recipe mass-assignment allows self-publishing
- **File:** `app/Models/Recipe.php:46`
- **Description:** `published`, `featured`, `traditional`, `created_by`, `updated_by` are in `$fillable`. Users could manipulate requests to self-publish.
- **Fix:** Remove these from `$fillable`. Set only through admin operations.

### SEC-002: /translate endpoint has no auth or rate limiting
- **File:** `routes/web.php:51`, `app/Http/Controllers/TranslationController.php`
- **Description:** Public POST endpoint proxies to Google Translate API. Unlimited abuse = unlimited billing.
- **Fix:** Add `auth` and `throttle:10,1` middleware.

### SEC-003: Admin emails hardcoded in multiple locations
- **Files:** `app/Http/Middleware/CheckIfAdmin.php:18`, `app/Models/User.php:19`, `app/Http/Controllers/HomeController.php:44-45`
- **Fix:** Use `is_admin` column or role system.

### SEC-020: No rate limiting on public form submissions
- **File:** `routes/web.php`
- **Description:** POST /contact, /subscribe, /translate have no throttle middleware.
- **Fix:** Add `throttle` middleware to all public POST routes.

### CQ-003: Livewire favouriting saves recipe to wrong user
- **File:** `app/Livewire/RecipeCreate.php:121`
- **Description:** `$recipe->user_id = 1` hardcodes author to user ID 1.
- **Fix:** Change to `auth()->id()`.

### CQ-004: Broken toggle in RecipeCreate
- **File:** `app/Livewire/RecipeCreate.php:123-125`
- **Description:** Traditional/featured/published toggle logic is inverted.
- **Fix:** Check and correct the boolean logic.

### CQ-005: Broken DB::transaction() with manual commit/rollback
- **File:** `app/Livewire/RecipeEdit.php:188-200`
- **Description:** Manual `DB::commit()` inside `DB::transaction()` closure causes undefined behavior.
- **Fix:** Use either automatic (closure) or manual transaction handling, not both.

### CQ-006: Validation runs after file upload in RecipeEdit
- **File:** `app/Livewire/RecipeEdit.php:176-186`
- **Description:** Images uploaded and old images deleted before `$this->validate()`. Failed validation = orphaned files.
- **Fix:** Move `$this->validate()` to top of `submit()`.

### CQ-007: Double-prefixed image URL in setImagesAttribute
- **File:** `app/Models/Recipe.php:148-151`
- **Description:** Path stored as `images/recipes/images/recipes/filename.jpg` (double prefix).
- **Fix:** Change line 150 to `'url' => $newImage` (already has prefix).

### ARCH-001: N+1 queries on home page
- **File:** `app/Http/Controllers/HomeController.php:17-35`
- **Description:** 6+ queries, featured loaded twice, `$appends` triggers per-model queries.
- **Fix:** Combine queries, use `withCount()`, cache results.

### ARCH-002: $appends forces N+1 queries on every serialization
- **File:** `app/Models/Recipe.php:49`
- **Description:** `favouritesCount`, `isFavourited`, `isVisited`, `visitsCount` in `$appends` trigger 4 extra queries per recipe.
- **Fix:** Remove from `$appends`, use `withCount()` in controllers.

### ARCH-003: Global $with eager loads always
- **File:** `app/Models/Recipe.php:48`
- **Description:** `$with = ['author', 'images']` loads on every query including admin, sitemap, counts.
- **Fix:** Remove global `$with`, add explicit eager loading where needed.

### ARCH-004: No index on recipes.slug (route model binding)
- **File:** `database/migrations/2020_06_20_194155_create_recipes_table.php`
- **Fix:** Add migration with unique index on `slug`, indexes on `published`, `featured`.

### ARCH-005: No authorization layer (no Policies)
- **Description:** Manual inline auth checks. No Policy classes exist.
- **Fix:** Create RecipePolicy with update/delete methods.

### SEO-003: No canonical URL tags
- **File:** `resources/views/layouts/app.blade.php`
- **Fix:** Add `<link rel="canonical" href="{{ url()->current() }}">`.

### SEO-004: No hreflang tags
- **File:** `resources/views/layouts/app.blade.php`
- **Fix:** Loop through supported locales and output hreflang link tags.

### A11Y-001: No skip navigation link
- **File:** `resources/views/layouts/app.blade.php`
- **Fix:** Add `<a href="#main-content" class="sr-only sr-only-focusable">Skip to content</a>`.

### A11Y-002: Social links in topbar have no accessible text
- **File:** `resources/views/partials/topbar.blade.php:4-11`
- **Fix:** Add `aria-label` to each icon-only link.

### A11Y-003: Share modal social links have no accessible text
- **File:** `resources/views/partials/share-modal.blade.php`
- **Fix:** Add `aria-label` to each social sharing link.

### A11Y-004: Empty alt attributes on meaningful images
- **File:** `resources/views/home/about_us.blade.php`
- **Fix:** Add descriptive alt text to team member photos.

### PERF-001: Massive JS bundle (~571KB uncompressed)
- **File:** `vite.config.js`, `package.json`
- **Description:** jQuery + jQuery-UI + lodash + Vue + Bootstrap + axios all bundled together.
- **Fix:** Remove lodash (use native), remove jQuery-UI, consider dropping jQuery.

### PERF-002: No image lazy loading
- **File:** `resources/views/livewire/recipe-box.blade.php`
- **Fix:** Add `loading="lazy"` to below-fold images.

### INFRA-003: Debug log leaks passwords (same as CQ-001)
- **File:** `app/Http/Controllers/Auth/RegisterController.php:68`

### INFRA-005: No external error tracking
- **Description:** No Sentry/Bugsnag. Errors only in local log files.
- **Fix:** Integrate Sentry (free tier).

### DX-007: .env.example outdated
- **File:** `.env.example`
- **Description:** Still says MySQL, missing GOOGLE_TRANSLATE_API_KEY, references Mix.
- **Fix:** Update to reflect SQLite, add required vars, remove Mix refs.

### DX-008: README is default Laravel boilerplate
- **File:** `README.md`
- **Fix:** Replace with project-specific docs.

---

## MEDIUM

### SEC-004: User model doesn't implement MustVerifyEmail
- **File:** `app/Models/User.php`

### SEC-005: API guard uses unhashed tokens
- **File:** `config/auth.php:47-48`

### SEC-006: LIKE wildcards not escaped in search
- **Files:** `app/Http/Controllers/RecipeController.php:49-51`, `ProfileController.php:23-24`

### SEC-007: No file validation in RecipeController::images()
- **File:** `app/Http/Controllers/RecipeController.php:145-163`

### SEC-010: Unescaped cache output (XSS risk)
- **File:** `resources/views/layouts/app.blade.php:109`

### SEC-014: Session encryption disabled
- **File:** `config/session.php:49`

### SEC-015: Session secure cookie not explicitly true
- **File:** `config/session.php:171`

### SEC-017: No security headers middleware
- **File:** `bootstrap/app.php`

### SEC-018: All proxies trusted (wildcard)
- **File:** `app/Http/Middleware/TrustProxies.php:15`

### SEC-025: Livewire file upload throttle may be null
- **File:** `config/livewire.php:88`

### CQ-008: Massive duplication between RecipeCreate and RecipeEdit
- **Files:** `app/Livewire/RecipeCreate.php`, `app/Livewire/RecipeEdit.php`

### CQ-009: Favourite toggle duplicated across components
- **Files:** `app/Livewire/Favourite.php`, `app/Livewire/RecipeBox.php`

### CQ-010: Unused imports (ContactFormMessage class doesn't exist)
- **File:** `app/Http/Controllers/ContactController.php:5`

### CQ-011: Empty destroy() stub
- **File:** `app/Http/Controllers/RecipeController.php:140-143`

### CQ-012: Route exists for non-existent update() method
- **File:** `routes/web.php:45`

### CQ-013: Commented-out code in production
- **Files:** `app/Livewire/RecipeCreate.php:94`, `app/Casts/LocalUrl.php:21-22`

### CQ-014: RecipeUpdateRequest defined but never used
- **File:** `app/Http/Requests/RecipeUpdateRequest.php`

### CQ-015: CategoryRecipe model is unused, Category::recipes() is wrong relationship type
- **Files:** `app/Models/CategoryRecipe.php`, `app/Models/Category.php:14-17`

### CQ-016: Favourite and Visit use $guarded = []
- **Files:** `app/Models/Favourite.php`, `app/Models/Visit.php`

### CQ-017: getIngredientsArray/getInstructionsArray duplicated logic
- **File:** `app/Models/Recipe.php:183-203`

### CQ-018: Inconsistent naming (snake_case vs camelCase in controllers)
- **File:** `app/Http/Controllers/HomeController.php`

### CQ-019: detach()+loop attach() instead of sync()
- **File:** `app/Livewire/RecipeEdit.php:191-194`

### ARCH-006: No rate limiting on translate endpoint (dup of SEC-002)

### ARCH-007: No error handling in translate() helper
- **File:** `app/helpers.php:59-68`

### ARCH-008: RecipeSearchBox fires 8+ queries for min/max times
- **File:** `app/Livewire/RecipeSearchBox.php:74-104`

### ARCH-009: file_exists() instead of Storage::exists()
- **Files:** `app/Casts/LocalUrl.php:23`, `app/Livewire/RecipeEdit.php:160`

### ARCH-010: Fat Recipe model (image processing, translation, file mgmt)
- **File:** `app/Models/Recipe.php`

### ARCH-011: Locale saved to DB on every request
- **File:** `app/Http/Middleware/RememberLocale.php`

### ARCH-012: Missing indexes on published, featured, recipe_id, user_id
- **File:** `database/migrations/`

### ARCH-014: No caching on home page
- **File:** `app/Http/Controllers/HomeController.php`

### INFRA-011: Category cache never invalidated
- **File:** `app/Providers/AppServiceProvider.php:43`

### INFRA-012: Google Translate runs synchronously (blocks HTTP)
- **File:** `app/Models/Recipe.php:58-64`

### SEO-005: Sitemap lacks locale prefixes for static pages
- **File:** `resources/views/sitemap.blade.php`

### SEO-006: Homepage has no H1 / multiple H1s in carousel
- **File:** `resources/views/home/index.blade.php`

### SEO-007: Google Analytics uses deprecated UA (no data collected since July 2024)
- **File:** `resources/views/layouts/app.blade.php:25-36`

### A11Y-005: target="_blank" links missing rel="noopener"
### A11Y-006: Footer email input has no label
### A11Y-007: Author box has hardcoded placeholder social links
### A11Y-008: Checkboxes hidden with display:none (inaccessible)
### A11Y-009: Flash dismiss button has no aria-label

### FE-011: No consistent CSS methodology
### FE-012: 14+ !important declarations
### FE-015: $blue variable is actually orange (#ff9638)
### FE-016: Google Fonts loaded twice (CSS @import + HTML link)
### FE-017: gtranslate has no error handling for API failures
### FE-020: Breakpoint files mix min-width/max-width
### FE-022: No loading states for Livewire interactions

### PERF-003: Google Fonts render-blocking + duplicated
### PERF-004: Full FontAwesome loaded (thousands of icons, ~20 used)
### PERF-005: 9 separate CSS entry points
### PERF-006: Facebook Pixel loaded synchronously
### PERF-007: All translations dumped to window on every page

### I18N-001: Hardcoded English strings in templates
### DX-004: All development on master, no branch protection
### DX-005: .gitignore missing common entries
### DX-009: RecipeEdit DB operations before validation (dup of CQ-006)

---

## LOW & INFO

*(See individual agent outputs for full details on 45 LOW/INFO findings including: Vue 2 ReDoS, copyright year hardcoded, empty media query file, misleading variable names, deprecated validation Rule interface, old migration class style, etc.)*
