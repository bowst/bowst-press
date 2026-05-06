<?php
/**
 * Enqueue scripts and styles.
 *
 * @package bowst-press
 */

function bowst_press_scripts() {
	wp_enqueue_style( 'bowst-press-style', get_stylesheet_uri() );

	wp_enqueue_style(
		'bowst-press-global-styles',
		get_template_directory_uri() . '/assets/css/app.css',
		array(),
		filemtime( get_template_directory() . '/assets/css/app.css' ),
		'all'
	);

	wp_enqueue_script(
		'bowst-press-global-scripts',
		get_template_directory_uri() . '/assets/js/app.js',
		array(),
		filemtime( get_template_directory() . '/assets/js/app.js' ),
		true
	);
	wp_script_add_data( 'bowst-press-global-scripts', 'strategy', 'defer' );

	$site_info = array(
		'homeUrl'        => get_home_url(),
		'themeDirectory' => get_template_directory_uri(),
		'post_type'      => get_post_type(),
		'ajaxurl'        => admin_url( 'admin-ajax.php' ),
	);
	wp_localize_script( 'bowst-press-global-scripts', 'SiteInfo', $site_info );
}
add_action( 'wp_enqueue_scripts', 'bowst_press_scripts', 8 );

/**
 * Enqueue parent theme styles in the block editor so the editorStyle handle
 * referenced in parent block.json files resolves correctly.
 */
function bowst_press_editor_assets() {
	wp_enqueue_style(
		'bowst-press-global-styles',
		get_template_directory_uri() . '/assets/css/app.css',
		array(),
		filemtime( get_template_directory() . '/assets/css/app.css' ),
		'all'
	);
}
add_action( 'enqueue_block_editor_assets', 'bowst_press_editor_assets' );
