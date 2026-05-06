<?php
/**
 * bowst-press functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package bowst-press
 */

if ( ! function_exists( 'bowst_press_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 */
	function bowst_press_setup() {
		load_theme_textdomain( 'bowst-press', get_template_directory() . '/languages' );

		add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' ) );
		add_theme_support( 'automatic-feed-links' );
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'responsive-images' );
		add_theme_support( 'editor-styles' );
		add_theme_support( 'wp-block-styles' );
		add_theme_support( 'align-wide' );

		if ( function_exists( 'add_image_size' ) ) {
			add_image_size( 'hero', 2000, 800, true );
		}

		register_nav_menus(
			array(
				'primary' => esc_html__( 'Primary', 'bowst-press' ),
				'footer'  => esc_html__( 'Footer', 'bowst-press' ),
			)
		);
	}
endif;
add_action( 'after_setup_theme', 'bowst_press_setup' );

/**
 * Enqueue scripts and styles.
 */
require get_template_directory() . '/inc/enqueue.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Gutenberg blocks and patterns.
 */
require get_template_directory() . '/inc/gutenberg.php';

/**
 * ACF Options Page.
 */
if ( function_exists( 'acf_add_options_page' ) ) {
	acf_add_options_page(
		array(
			'page_title' => 'Theme General Settings',
			'menu_title' => 'Theme Settings',
			'menu_slug'  => 'theme-general-settings',
			'capability' => 'edit_posts',
			'redirect'   => false,
		)
	);
}

/**
 * Remove "Category:" from category title.
 */
function prefix_category_title( $title ) {
	if ( is_category() || is_tax() ) {
		$title = single_cat_title( '', false );
	}
	return $title;
}
add_filter( 'get_the_archive_title', 'prefix_category_title' );
