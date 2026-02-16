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
- [ ] **INFRA-011**: Add Category model observer to clear cache on change
- [x] **CQ-010**: Remove unused imports (ContactFormMessage from ContactController, Response from RecipeController)
- [x] **CQ-011/012**: Remove empty destroy() and dead route for update()
- [ ] **CQ-015**: Fix Category::recipes() to belongsToMany, delete CategoryRecipe model

## P2 — Important Improvements (1-3 hours each)

- [x] **SEO-002**: Add JSON-LD Recipe structured data to show page (+ Organization, WebSite, Breadcrumb schemas)
- [ ] **ARCH-004**: Add migration for indexes on slug, published, featured, recipe_id, user_id
- [ ] **ARCH-002**: Remove appends from Recipe, use withCount() in controllers
- [ ] **ARCH-003**: Remove global $with from Recipe, eager-load explicitly
- [ ] **ARCH-014**: Add caching to home page queries
- [ ] **ARCH-008**: Optimize RecipeSearchBox to single aggregate query
- [x] **CQ-019**: Replace detach()+loop attach() with sync()
- [ ] **ARCH-005**: Create RecipePolicy for authorization
- [ ] **ARCH-007**: Add try/catch + fallback to translate() helper
- [ ] **SEC-018**: Configure TrustProxies with specific proxy IPs
- [ ] **CQ-022**: Fix ProfileController search orWhere scoping
- [ ] **DX-007**: Update .env.example for SQLite + required vars
- [ ] **INFRA-005**: Integrate Sentry error tracking
- [x] **FE-016**: Remove duplicate Google Fonts loading (removed <link> tag, kept SCSS @import)

## P3 — Medium-term Projects (multi-hour / multi-session)

- [ ] **TEST-001**: Write feature tests for auth, recipe CRUD, translate
- [ ] **CICD-001**: Set up GitHub Actions CI pipeline
- [ ] **CQ-008**: Extract shared RecipeCreate/Edit logic into trait
- [ ] **ARCH-010**: Extract image processing from Recipe model to service
- [ ] **INFRA-012**: Make Google Translate async (queue jobs)
- [ ] **PERF-001**: Reduce JS bundle (drop lodash, jQuery-UI)
- [ ] **PERF-004**: Subset FontAwesome to only used icons
- [ ] **PERF-005**: Consolidate breakpoint CSS files
- [ ] **SEC-010**: Fix unescaped cache output XSS risk

## P4 — Long-term / Migration Projects

- [ ] **FE-001/002/003**: Migrate Vue 2 -> 3, Bootstrap 4 -> 5, drop jQuery
- [ ] **DEP-001/002/003**: Update axios, lodash (or replace with native)
- [ ] **DX-008**: Write proper README
- [ ] **ARCH-011**: Only persist locale on explicit language switch
- [ ] **SEC-004**: Implement MustVerifyEmail
- [ ] **A11Y-008**: Fix hidden checkboxes accessibility
- [ ] **A11Y-010/011**: Fix focus styles and color contrast
