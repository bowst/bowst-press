# bowst-press

Parent WordPress block theme by [Bowst](https://bowst.com). Provides shared ACF blocks, patterns, template parts, and a full SCSS/JS build pipeline. All site-specific work lives in a child theme generated from this repo.

---

## Generating a Child Theme

Run the scaffold script from inside the `bowst-press` directory:

```bash
cd wp-content/themes/bowst-press
./bin/create-child-theme.sh "Client Name" "client-slug"
```

This creates a fully wired child theme at `wp-content/themes/client-slug/` with:

- `style.css` declaring the parent/child relationship
- `functions.php` with asset enqueueing, block registration, and the ACF JSON load path filter
- `webpack.config.js` + `package.json` matching the parent build pipeline
- `src/scss/` starter partials (`client.scss`, `_variables.scss`, `_overrides.scss`, `_components.scss`)
- `src/js/app.js` entry point
- `src/data/colors.json` copied from the parent as a starting palette
- `bin/sync-colors.js` for color propagation (see below)
- `acf-json/` directory for local JSON sync
- `.gitignore` pre-configured

**After scaffolding:**

```bash
cd wp-content/themes/client-slug
npm install
npm run build
# Activate the child theme in the WordPress admin
```

---

## Build Commands

All commands run from **the child theme directory** (not the parent):

| Command | Description |
|---|---|
| `npm run dev` | Webpack in watch/development mode |
| `npm run build` | Production build (runs `sync-colors` first via `prebuild`) |
| `npm run sync-colors` | Propagate `src/data/colors.json` → `theme.json` palette + `src/scss/_theme-colors.scss` |

> The parent theme has its own independent build. Only rebuild the parent when modifying shared blocks in `bowst-press/blocks/`.

---

## Color System

Colors are defined once in `src/data/colors.json` and propagated everywhere else automatically.

### Format

```json
{
    "purple": { "name": "Purple", "color": "#8D00FF" },
    "black":  { "name": "Black",  "color": "#0F0F0F" }
}
```

Both the legacy string format (`"purple": "#8D00FF"`) and the object format above are supported. The object format is preferred because it lets you set a human-readable name.

### How propagation works

Running `npm run sync-colors` (or triggering a build) executes `bin/sync-colors.js`, which:

1. Reads `src/data/colors.json`
2. Overwrites the `settings.color.palette` array in `theme.json` — making the colors available as CSS custom properties (`--wp--preset--color--{slug}`) and in the block editor color picker
3. Regenerates `src/scss/_theme-colors.scss` — creating SCSS variables (`$purple`, `$black`, etc.) usable throughout your stylesheets

**Never edit `_theme-colors.scss` directly** — it is fully overwritten on every sync.

---

## ACF Blocks

### Parent theme blocks

Blocks in `bowst-press/blocks/` are auto-registered. The block category slug is `bowst`.

| Block | Description |
|---|---|
| `acf/accordion` | Expandable FAQ-style accordion |
| `acf/cta-banner` | Full-width call-to-action banner |
| `acf/feature-card` | Individual feature card |
| `acf/hero` | Full-width hero section |
| `acf/logo-grid` | Logo / partner grid |
| `acf/stats-counter` | Animated stat counters |
| `acf/team-member` | Team member card |
| `acf/testimonial` | Testimonial quote block |

### Child theme blocks

Add child theme blocks to `blocks/<name>/` with a `block.json` + `render.php`. They are auto-registered by `functions.php` on `init`. Block-scoped styles go in `blocks/<name>/style.scss` — webpack discovers and compiles them automatically.

### ACF local JSON

Field group JSON files are stored in `acf-json/` for version control. The child theme's `functions.php` registers **both** load paths:

```php
// Loads field groups from the parent theme so bowst-press blocks
// have their fields available in the child theme context.
add_filter( 'acf/settings/load_json', function( $paths ) {
    $paths[] = get_template_directory() . '/acf-json'; // bowst-press
    return $paths;
} );
```

New or edited field groups are always saved to the child theme's `acf-json/` directory.

---

## SCSS Architecture (Child Theme)

| File | Purpose |
|---|---|
| `src/scss/client.scss` | Main entry point — imports everything in order |
| `src/scss/_variables.scss` | Bootstrap variable overrides + custom variables |
| `src/scss/_theme-colors.scss` | **Auto-generated** — SCSS variables from `colors.json` |
| `src/scss/_overrides.scss` | Global style overrides for WP core / parent theme rules |
| `src/scss/_components.scss` | Shared site-specific component styles |
| `src/scss/_custom-buttons.scss` | Button block styles and custom block style variations |
| `blocks/<name>/style.scss` | Block-scoped styles compiled to `style.css` per block |

CSS custom properties from `theme.json` (e.g. `--wp--preset--color--purple`) are available anywhere. Use them in SCSS via `var(--wp--preset--color--purple)` rather than the `$purple` variable when you want the value to be overridable at runtime.

---

## Template Hierarchy

Block templates live in `templates/`. The child theme's templates take precedence over the parent's.

| Template | Used for |
|---|---|
| `page.html` | Default page fallback |
| `page-l1.html` | Top-level (L1) pages |
| `page-l2.html` | Second-level (L2) pages with breadcrumbs |
| `page-l3.html` | Third-level (L3) pages with breadcrumbs |

---

## Local Development

1. Copy `wp-config-local-sample.php` → `wp-config-local.php` at the repo root
2. Fill in local DB credentials and `WP_HOME` / `WP_SITEURL`
3. This file is gitignored; the Pantheon environment uses `wp-config-pantheon.php` automatically
