# Parent Theme Updates

## 2026-05-06

### Color Token + Sync Improvements

- Upgraded `bin/sync-colors.js` to support object-based color tokens with optional `editor: true|false`.
- `theme.json` palette generation now includes only tokens with `editor: true`, allowing a curated Gutenberg editor palette.
- SCSS token generation now emits two variables per color:
  - `$token` for runtime CSS var usage (`var(--wp--preset--color--slug, #hex)`)
  - `$token_hex` for Sass color math (`rgba`, `mix`, `lighten`, `darken`, etc.)
- Added clearer generated-file usage guidance in the `_theme-colors.scss` header comments.

### Generated Token Output Update

- Regenerated `src/scss/_theme-colors.scss` to use CSS-var aliases plus `_hex` companion tokens.
- Updated legacy aliases (`$base`, `$primary`, `$contrast`, `$accent_*`) to point to `_hex` values for backward-compatible Sass behavior.

### ACF Metadata Adjustment

- Updated `acf-json/group_bowst_cta_banner.json` button style select metadata:
  - `"create_options": 0`
  - `"save_options": 0`
- No intentional structural field changes to the CTA banner group.

### Practical Impact

- Parent theme token handling now matches the more flexible child-theme strategy.
- Editor-visible palette can be narrowed without losing internal design tokens.
- Existing Sass styles remain stable where color functions depend on raw hex values.
