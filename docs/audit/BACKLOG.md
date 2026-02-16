# Audit Fix Backlog

Prioritized by impact and effort. Work top-to-bottom.

---

## P0 — Do Immediately (security / data corruption)

- [x] **CQ-001**: Remove `print_r($data)` password logging in RegisterController:68
- [x] **CQ-007**: Fix double-prefixed image URL in Recipe::setImagesAttribute
- [x] **CQ-003**: ~~Fix hardcoded `user_id = 1`~~ Already correct (`auth()->id()`) — was misreported. Fixed `toggleExistingImage` missing `$this->` instead.
- [x] **SEC-002**: Add auth + throttle middleware to /translate route
- [x] **SEC-001**: Removed `created_by`/`updated_by` from Recipe $fillable (kept `published`/`featured`/`traditional` for Filament admin — Livewire forms don't expose them)
- [x] **CQ-006**: Move validate() before file operations in RecipeEdit::submit()
- [x] **CQ-005**: Fix broken DB::transaction in RecipeEdit (removed manual commit/rollback)

## P1 — High Impact Quick Wins (< 1 hour each)

- [x] **SEO-001**: Add meta description tag to layout
- [x] **SEO-003**: Add canonical URL tag to layout
- [x] **SEO-004**: Add hreflang tags for en/tr/el
- [x] **A11Y-001**: Add skip-to-content link
- [x] **A11Y-002/003**: Add aria-labels to icon-only social links (topbar + share-modal) + rel="noopener"
- [x] **A11Y-004**: Add alt text to about_us images
- [x] **SEC-017**: Add security headers middleware (X-Content-Type-Options, X-Frame-Options, HSTS, Referrer-Policy, Permissions-Policy)
- [x] **SEC-020**: Add throttle to /contact, /subscribe POST routes
- [x] **PERF-002**: Add loading="lazy" to recipe card images
- [x] **SEO-007**: Removed dead UA analytics (UA-86539141-2 — stopped collecting July 2024)
- [x] **INFRA-011**: Add Category + Recipe cache invalidation in AppServiceProvider
- [x] **CQ-010**: Remove unused imports (ContactFormMessage from ContactController, Response from RecipeController)
- [x] **CQ-011/012**: Remove empty destroy() and dead route for update()
- [x] **CQ-015**: Fix Category::recipes() to belongsToMany, delete CategoryRecipe model

## P2 — Important Improvements (1-3 hours each)

- [x] **SEO-002**: Add JSON-LD Recipe structured data to show page (+ Organization, WebSite, Breadcrumb schemas)
- [x] **ARCH-004**: Add migration for indexes on slug, published, featured, favourited_id, visited_id, category_recipe
- [x] **ARCH-002**: Remove $appends from Recipe (kept 'url'), use withCount('favourites', 'visits') in controllers
- [x] **ARCH-003**: Remove global $with from Recipe, add explicit with(['author', 'images']) where needed
- [x] **ARCH-014**: Cache search box cook time stats with invalidation
- [x] **ARCH-008**: Optimize RecipeSearchBox from 8 queries to 1 aggregate query (cached)
- [x] **CQ-019**: Replace detach()+loop attach() with sync()
- [x] **ARCH-005**: Create RecipePolicy for authorization, replace inline auth checks
- [x] **ARCH-007**: Add try/catch + fallback to translate() helper
- [x] **SEC-018**: Configure TrustProxies to trust only 127.0.0.1
- [x] **CQ-022**: Fix ProfileController search orWhere scoping (wrap in closure)
- [x] **DX-007**: Update .env.example for SQLite + GOOGLE_TRANSLATE_API_KEY
- [x] **FE-016**: Remove duplicate Google Fonts loading (removed <link> tag, kept SCSS @import)

## P3 — Medium-term Projects (multi-hour / multi-session)

- [x] **INFRA-005**: Replaced Sentry with opcodesio/log-viewer (admin-only access)
- [x] **TEST-001**: 39 feature tests covering auth, recipes, authorization, SEO, security headers, rate limiting, translation
- [x] **CICD-001**: GitHub Actions CI pipeline (.github/workflows/ci.yml)
- [x] **CQ-008**: Extracted shared RecipeCreate/Edit logic into HandlesRecipeForm trait
- [x] **SEC-010**: Fixed unescaped cache output XSS — `{!! cache('translations') !!}` → `Js::from()`, error pages escaped
- [x] **PERF-001**: Removed lodash, axios, jQuery UI — JS bundle 449KB → 337KB (-25%), replaced with native alternatives
- [x] **DEP-001/002/003** (partial): Removed lodash and axios dependencies, replaced with native JS
- [x] **ARCH-010**: Extracted image processing to ImageService, removed dead base64 mutators from Recipe model
- [x] **INFRA-012**: Created TranslateRecipeFields queue job, async translation via database queue
- [x] **PERF-004**: Switched to FontAwesome SVG core with tree-shaken imports (36 icons), removed full FA CSS/webfonts
- [x] **PERF-005**: Consolidated 6 breakpoint CSS files into styles.scss, reduced Vite entry points from 9 to 4

## P4 — Long-term / Migration Projects

- [ ] **FE-001/002/003**: Migrate Vue 2 -> 3, Bootstrap 4 -> 5, drop jQuery
- [x] **DX-008**: Replaced default Laravel README with project-specific documentation
- [x] **ARCH-011**: Already implemented — RememberLocale middleware already checks locale change before saving
- [x] **SEC-004**: Implemented MustVerifyEmail with existing user backfill migration
- [x] **A11Y-008**: Replaced display:none with visually-hidden for checkboxes (image + ingredient)
- [x] **A11Y-010/011**: Added :focus-visible styles, fixed color contrast (#888→#595959, #999/#aaa/#ccc→#767676)
