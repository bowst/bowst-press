#!/usr/bin/env bash
#
# create-child-theme.sh - Scaffold a bowst-press child theme.
#
# Usage:
#   ./bin/create-child-theme.sh "Client Name" "client-slug"
#
# Example:
#   ./bin/create-child-theme.sh "Acme Corp" "acme-corp"
#
# This creates a child theme at ../client-slug/ relative to the
# bowst-press parent theme directory.

set -euo pipefail

if [ $# -lt 2 ]; then
    echo "Usage: $0 \"Client Name\" \"client-slug\""
    echo "Example: $0 \"Acme Corp\" \"acme-corp\""
    exit 1
fi

CLIENT_NAME="$1"
CLIENT_SLUG="$2"
PARENT_DIR="$(cd "$(dirname "$0")/.." && pwd)"
CHILD_DIR="$(dirname "$PARENT_DIR")/$CLIENT_SLUG"

if [ -d "$CHILD_DIR" ]; then
    echo "Error: Directory $CHILD_DIR already exists."
    exit 1
fi

echo "Creating child theme: $CLIENT_NAME ($CLIENT_SLUG)"
echo "Location: $CHILD_DIR"
echo ""

# Create directory structure
mkdir -p "$CHILD_DIR"/{assets/{css,js,images/source,fonts},blocks,patterns,templates,parts,acf-json,src/{scss,js,data},bin}

# --- style.css ---
cat > "$CHILD_DIR/style.css" <<STYLE
/*
Theme Name: $CLIENT_NAME
Theme URI:
Author: Bowst
Author URI: https://bowst.com
Description: Child theme for $CLIENT_NAME, built on bowst-press.
Version: 1.0.0
Template: bowst-press
Text Domain: $CLIENT_SLUG
*/
STYLE

# --- theme.json ---
cp "$PARENT_DIR/theme.json" "$CHILD_DIR/theme.json"

# --- functions.php ---
cat > "$CHILD_DIR/functions.php" <<'FUNCTIONS'
<?php
/**
 * CHILD_NAME functions and definitions.
 *
 * @package CHILD_SLUG
 */

/**
 * Enqueue child theme styles.
 */
function FUNC_PREFIX_scripts() {
	// Dequeue parent compiled CSS (child rebuilds its own).
	wp_dequeue_style( 'bowst-press-global-styles' );

	// Child compiled CSS.
	$css_path = get_stylesheet_directory() . '/assets/css/app.css';
	if ( file_exists( $css_path ) ) {
		wp_enqueue_style(
			'CHILD_SLUG-styles',
			get_stylesheet_directory_uri() . '/assets/css/app.css',
			array(),
			filemtime( $css_path ),
			'all'
		);
	}

	// Child compiled JS.
	$js_path = get_stylesheet_directory() . '/assets/js/app.js';
	if ( file_exists( $js_path ) ) {
		wp_enqueue_script(
			'CHILD_SLUG-scripts',
			get_stylesheet_directory_uri() . '/assets/js/app.js',
			array(),
			filemtime( $js_path ),
			true
		);
		wp_script_add_data( 'CHILD_SLUG-scripts', 'strategy', 'defer' );
	}
}
add_action( 'wp_enqueue_scripts', 'FUNC_PREFIX_scripts', 20 );

/**
 * Add parent theme acf-json directory to ACF's local JSON load paths so
 * field groups defined in bowst-press are recognised by the child theme.
 *
 * @param string[] $paths Existing load paths.
 * @return string[]
 */
function FUNC_PREFIX_acf_json_load_paths( $paths ) {
	$paths[] = get_template_directory() . '/acf-json';
	return $paths;
}
add_filter( 'acf/settings/load_json', 'FUNC_PREFIX_acf_json_load_paths' );

/**
 * Register child theme blocks.
 */
function FUNC_PREFIX_register_blocks() {
	$blocks_dir = get_stylesheet_directory() . '/blocks';
	if ( ! is_dir( $blocks_dir ) ) {
		return;
	}

	$block_folders = glob( $blocks_dir . '/*', GLOB_ONLYDIR );
	foreach ( $block_folders as $block_folder ) {
		$block_json = $block_folder . '/block.json';
		if ( file_exists( $block_json ) ) {
			register_block_type( $block_json );
		}
	}
}
add_action( 'init', 'FUNC_PREFIX_register_blocks' );
FUNCTIONS

# Replace placeholders in functions.php
FUNC_PREFIX=$(echo "$CLIENT_SLUG" | tr '-' '_')
sed -i '' \
    -e "s/CHILD_NAME/$CLIENT_NAME/g" \
    -e "s/CHILD_SLUG/$CLIENT_SLUG/g" \
    -e "s/FUNC_PREFIX/$FUNC_PREFIX/g" \
    "$CHILD_DIR/functions.php"

# --- package.json ---
cat > "$CHILD_DIR/package.json" <<PACKAGE
{
    "name": "$CLIENT_SLUG",
    "version": "1.0.0",
    "description": "$CLIENT_NAME child theme for bowst-press.",
    "engines": {
        "node": ">=20"
    },
    "scripts": {
        "build": "webpack --config webpack.config.js --mode production",
        "dev": "webpack --config webpack.config.js --mode development --watch",
        "sync-colors": "node bin/sync-colors.js",
        "prebuild": "npm run sync-colors"
    },
    "author": "Bowst",
    "devDependencies": {
        "@babel/core": "^7.15.0",
        "@babel/preset-env": "^7.15.0",
        "@fortawesome/fontawesome-free": "^7.1.0",
        "@popperjs/core": "^2.9.2",
        "autoprefixer": "^10.3.3",
        "babel-loader": "^8.2.2",
        "bootstrap": "^5.3.8",
        "css-loader": "^6.0.0",
        "dotenv-webpack": "^7.0.3",
        "fast-glob": "^3.2.7",
        "glob": "^7.2.0",
        "mini-css-extract-plugin": "^2.2.0",
        "sass": "^1.69.0",
        "postcss": "^8.4.0",
        "postcss-loader": "^8.1.0",
        "postcss-preset-env": "^8.4.0",
        "postcss-pxtorem": "^6.0.0",
        "sass-loader": "^12.1.0",
        "style-loader": "^3.2.1",
        "webpack": "^5.51.1",
        "webpack-cli": "^4.8.0"
    }
}
PACKAGE

# --- webpack.config.js ---
cat > "$CHILD_DIR/webpack.config.js" <<'WEBPACK'
const fs = require('fs');
const path = require('path');
const { execSync } = require('child_process');
const webpack = require('webpack');
const Dotenv = require('dotenv-webpack');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const glob = require('glob');

class SyncColorsPlugin {
    apply(compiler) {
        compiler.hooks.beforeCompile.tapAsync('SyncColorsPlugin', (params, callback) => {
            try {
                execSync('node bin/sync-colors.js', { cwd: __dirname, stdio: 'ignore' });
            } catch (e) {
                // Ignore if sync-colors fails
            }
            callback();
        });
    }
}

function getBlockStyleEntries() {
    const blocksDir = path.join(__dirname, 'blocks');
    const entries = {};
    if (!fs.existsSync(blocksDir)) return entries;
    const dirs = glob.sync(path.join(blocksDir, '*')).filter(p => fs.statSync(p).isDirectory());
    for (const blockDir of dirs) {
        const name = path.basename(blockDir);
        const scss = path.join(blockDir, 'style.scss');
        const css = path.join(blockDir, 'style.css');
        if (fs.existsSync(scss)) {
            entries[`blocks/${name}/style`] = `./blocks/${name}/style.scss`;
        } else if (fs.existsSync(css)) {
            entries[`blocks/${name}/style`] = `./blocks/${name}/style.css`;
        }
    }
    return entries;
}

const sassLoaderOptions = {
    implementation: require('sass'),
    sassOptions: { quietDeps: true },
};

const sharedCssRule = {
    test: /\.(scss|css)$/,
    use: [
        MiniCssExtractPlugin.loader,
        { loader: 'css-loader', options: { importLoaders: 2, sourceMap: true, url: false } },
        { loader: 'postcss-loader', options: { postcssOptions: { plugins: ['autoprefixer'] } } },
        { loader: 'sass-loader', options: sassLoaderOptions },
    ],
};

module.exports = [
    {
        entry: { app: './src/js/app.js' },
        output: { filename: 'js/[name].js', path: path.resolve(__dirname, './assets/') },
        devtool: 'source-map',
        module: {
            rules: [
                { test: /\.js$/, exclude: /(node_modules)/, use: { loader: 'babel-loader', options: { presets: ['@babel/preset-env'] } } },
                sharedCssRule,
            ],
        },
        plugins: [
            new SyncColorsPlugin(),
            new MiniCssExtractPlugin({ filename: 'css/[name].css', chunkFilename: '[id].css' }),
        ],
    },
    ...(function () {
        const blockStyleEntries = getBlockStyleEntries();
        if (Object.keys(blockStyleEntries).length === 0) return [];
        return [{
            entry: blockStyleEntries,
            output: { path: path.resolve(__dirname), filename: '[name].js' },
            stats: 'minimal',
            devtool: 'source-map',
            module: { rules: [sharedCssRule] },
            plugins: [
                new SyncColorsPlugin(),
                new MiniCssExtractPlugin({ filename: '[name].css' }),
            ],
        }];
    })(),
];
WEBPACK

# --- postcss.config.js ---
cp "$PARENT_DIR/postcss.config.js" "$CHILD_DIR/postcss.config.js"

# --- .babelrc ---
cp "$PARENT_DIR/.babelrc" "$CHILD_DIR/.babelrc"

# --- .gitignore ---
cat > "$CHILD_DIR/.gitignore" <<'GITIGNORE'
# Webpack emits this for the blocks CSS entry; only the CSS is used
blocks/*/style.js
blocks/*/style.js.map
node_modules/
GITIGNORE

# --- src/data/colors.json ---
cp "$PARENT_DIR/src/data/colors.json" "$CHILD_DIR/src/data/colors.json"

# --- bin/sync-colors.js ---
# Copies the parent sync script, which:
# - supports editor: true/false in colors.json
# - limits theme.json palette to editor:true colors
# - still defines --wp--preset--color--* vars for ALL tokens (including editor:false)
cp "$PARENT_DIR/bin/sync-colors.js" "$CHILD_DIR/bin/sync-colors.js"

# --- SCSS files ---
cat > "$CHILD_DIR/src/scss/client.scss" <<'SCSS'
// Client-specific variables (loaded before Bootstrap)
@import 'variables';

// Bootstrap (selective imports — add/remove as needed)
@import 'bootstrap/scss/functions';
@import 'bootstrap/scss/variables';
@import 'bootstrap/scss/variables-dark';
@import 'bootstrap/scss/maps';
@import 'bootstrap/scss/mixins';
@import 'bootstrap/scss/utilities';
@import 'bootstrap/scss/root';
@import 'bootstrap/scss/reboot';
@import 'bootstrap/scss/type';
@import 'bootstrap/scss/images';
@import 'bootstrap/scss/containers';
@import 'bootstrap/scss/grid';
@import 'bootstrap/scss/tables';
@import 'bootstrap/scss/forms';
@import 'bootstrap/scss/buttons';
@import 'bootstrap/scss/transitions';
@import 'bootstrap/scss/dropdown';
@import 'bootstrap/scss/accordion';
@import 'bootstrap/scss/button-group';
@import 'bootstrap/scss/nav';
@import 'bootstrap/scss/navbar';
@import 'bootstrap/scss/card';
@import 'bootstrap/scss/breadcrumb';
@import 'bootstrap/scss/pagination';
@import 'bootstrap/scss/badge';
@import 'bootstrap/scss/alert';
@import 'bootstrap/scss/close';
@import 'bootstrap/scss/modal';
@import 'bootstrap/scss/tooltip';
@import 'bootstrap/scss/popover';
@import 'bootstrap/scss/offcanvas';
@import 'bootstrap/scss/helpers';
@import 'bootstrap/scss/utilities/api';

// Theme colors (auto-generated)
@import 'theme-colors';

// Client overrides and components
@import 'overrides';
@import 'components';
SCSS

cat > "$CHILD_DIR/src/scss/_variables.scss" <<'SCSS'
// Client Bootstrap variable overrides
// Copy variables from the parent theme's _variables.scss and customize here.

@import 'theme-colors';

$font-family-sans-serif: var(--wp--preset--font-family--open-sans);
$font-family-base: $font-family-sans-serif;
SCSS

cat > "$CHILD_DIR/src/scss/_theme-colors.scss" <<'SCSS'
// Auto-generated from src/data/colors.json — do not edit manually.
// Run `npm run sync-colors` to regenerate.
SCSS

cat > "$CHILD_DIR/src/scss/_overrides.scss" <<'SCSS'
// Client-specific style overrides
// Add custom styles that override the parent theme here.
SCSS

cat > "$CHILD_DIR/src/scss/_components.scss" <<'SCSS'
// Client-specific components
// Add styles for custom blocks or site-specific components here.
SCSS

# --- src/js/app.js ---
cat > "$CHILD_DIR/src/js/app.js" <<'JS'
// Pull colors.json into build so webpack watches it
import '../data/colors.json';

// Client styles
import '../scss/client.scss';

// Add client-specific JS below
JS

echo ""
echo "Child theme '$CLIENT_NAME' created at:"
echo "  $CHILD_DIR"
echo ""
echo "Next steps:"
echo "  cd $CHILD_DIR"
echo "  npm install"
echo "  npm run build"
echo "  # Activate the child theme in WordPress admin"
echo ""
