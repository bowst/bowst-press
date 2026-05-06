const fs = require('fs');
const path = require('path');

const colorsPath = path.join(__dirname, '../src/data/colors.json');
const themeJsonPath = path.join(__dirname, '../theme.json');
const scssPath = path.join(__dirname, '../src/scss/_theme-colors.scss');

const colors = JSON.parse(fs.readFileSync(colorsPath, 'utf8'));

function slugToTitle(slug) {
	return slug
		.split('-')
		.map((w) => w.charAt(0).toUpperCase() + w.slice(1))
		.join(' ');
}

/**
 * Supports:
 * - Legacy: { "purple": "#hex" }
 * - Preferred: { "purple": { "name": "Purple", "color": "#hex", "editor": true } }
 */
function normalizeEntry(slug, val) {
	if (typeof val === 'string') {
		return { slug, color: val.trim(), name: slugToTitle(slug), editor: true };
	}
	if (val && typeof val === 'object' && typeof val.color === 'string') {
		return {
			slug,
			color: val.color.trim(),
			name: (val.name && String(val.name).trim()) || slugToTitle(slug),
			editor: typeof val.editor === 'boolean' ? val.editor : true,
		};
	}
	throw new Error(`Invalid color entry for "${slug}" in colors.json`);
}

const entries = Object.keys(colors).map((slug) => normalizeEntry(slug, colors[slug]));
const editorEntries = entries.filter(({ editor }) => editor);

// Update theme.json palette (only write if content changed to avoid watch loop)
const theme = JSON.parse(fs.readFileSync(themeJsonPath, 'utf8'));
theme.settings.color.palette = editorEntries.map(({ slug, color, name }) => ({
	color,
	name,
	slug,
}));
const newThemeJson = JSON.stringify(theme, null, 4);
if (fs.readFileSync(themeJsonPath, 'utf8') !== newThemeJson) {
	fs.writeFileSync(themeJsonPath, newThemeJson);
}

// Generate SCSS token variables:
// - $token: CSS var alias for runtime theming (with hex fallback)
// - $token_hex: raw hex for Sass color functions (rgba/lighten/etc.)
const colorLines = entries
	.map(({ slug, color }) => {
		const varName = slug.replace(/-/g, '_');
		return `$${varName}: var(--wp--preset--color--${slug}, ${color});\n$${varName}_hex: ${color};`;
	})
	.join('\n');
const cssCustomProperties = entries
	.map(({ slug, color }) => `\t--wp--preset--color--${slug}: ${color};`)
	.join('\n');
const legacyAliases = `
// Legacy names (SCSS across the theme); palette is black & white only.
$base: $white_hex;
$primary: $black_hex;
$contrast: $black_hex;
$accent_1: $black_hex;
$accent_2: $black_hex;
$accent_3: $black_hex;
$accent_4: $black_hex;
$accent_5: $white_hex;
$accent_6: $black_hex;
`;
const newScss = `// Auto-generated from src/data/colors.json
// Usage:
// - :root custom properties ensure all color tokens exist at runtime, including editor:false tokens.
// - $token: runtime CSS var alias (use for normal styles and blocks)
// - $token_hex: raw hex (use only for Sass color functions like rgba/mix/lighten/darken)
:root {
${cssCustomProperties}
}

${colorLines}
${legacyAliases}
`;
if (!fs.existsSync(scssPath) || fs.readFileSync(scssPath, 'utf8') !== newScss) {
	fs.writeFileSync(scssPath, newScss);
}
