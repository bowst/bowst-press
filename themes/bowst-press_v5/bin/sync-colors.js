const fs = require('fs');
const path = require('path');

const colorsPath = path.join(__dirname, '../src/data/colors.json');
const themeJsonPath = path.join(__dirname, '../theme.json');
const scssPath = path.join(__dirname, '../src/scss/_theme-colors.scss');

const colors = JSON.parse(fs.readFileSync(colorsPath, 'utf8'));
const slugs = {
    base: 'Base',
    primary: 'Primary',
    contrast: 'Contrast',
    'accent-1': 'Accent 1',
    'accent-2': 'Accent 2',
    'accent-3': 'Accent 3',
    'accent-4': 'Accent 4',
    'accent-5': 'Accent 5',
};

// Update theme.json palette (only write if content changed to avoid watch loop)
const theme = JSON.parse(fs.readFileSync(themeJsonPath, 'utf8'));
theme.settings.color.palette = Object.entries(colors).map(([slug, color]) => ({
    color,
    name: slugs[slug] || slug,
    slug: slug,
}));
const newThemeJson = JSON.stringify(theme, null, 4);
if (fs.readFileSync(themeJsonPath, 'utf8') !== newThemeJson) {
    fs.writeFileSync(themeJsonPath, newThemeJson);
}

// Generate SCSS (only write if content changed to avoid watch loop)
const scss = Object.entries(colors)
    .map(([k, v]) => `$${k.replace('-', '_')}: ${v};`)
    .join('\n');
const newScss = `// Auto-generated from src/data/colors.json\n${scss}\n`;
if (!fs.existsSync(scssPath) || fs.readFileSync(scssPath, 'utf8') !== newScss) {
    fs.writeFileSync(scssPath, newScss);
}
