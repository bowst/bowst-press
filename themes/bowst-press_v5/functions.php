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
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function bowst_press_setup() {
		/*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		* If you're building a theme based on bowst-press, use a find and replace
		* to change 'bowst-press' to the name of your theme in all the template files.
		*/
		load_theme_textdomain( 'bowst-press', get_template_directory() . '/languages' );

		add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' ) );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		* Enable support for Post Thumbnails on posts and pages.
		*
		* @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		*/
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'responsive-images' );

		if ( function_exists( 'add_image_size' ) ) {
			add_image_size( 'hero', 2000, 800, true );
		}

		// Load global stylesheet in TinyMCE.
		add_editor_style(
			array(
				// 'https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&display=swap',
				'assets/css/app.css',
			)
		);
		add_theme_support( 'editor-styles' );
		add_theme_support( 'wp-block-styles' );
		add_theme_support( 'align-wide' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus(
			array(
				'primary' => esc_html__( 'Primary', 'bowst-press' ),
				'footer'  => esc_html__( 'Footer', 'bowst-press' ),
			)
		);

		// Set up the WordPress core custom background feature.
		add_theme_support(
			'custom-background',
			apply_filters(
				'bowst_press_custom_background_args',
				array(
					'default-color' => 'ffffff',
					'default-image' => '',
				)
			)
		);

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );
	}
endif;
add_action( 'after_setup_theme', 'bowst_press_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function bowst_press_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'bowst_press_content_width', 640 );
}
add_action( 'after_setup_theme', 'bowst_press_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function bowst_press_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'bowst-press' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'bowst-press' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'bowst_press_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function bowst_press_scripts() {
	$theme_version = wp_get_theme()->get( 'Version' );

	/* Underscore Theme */
	wp_enqueue_style( 'bowst-press-style', get_stylesheet_uri() );

	/*
	Fonts */
	// wp_enqueue_script( 'bowst-press-font-awesome', 'https://kit.fontawesome.com/cf33371a1a.js', array(), $theme_version, false );

	/* Custom */
	wp_enqueue_style( 'bowst-press-global-styles', get_template_directory_uri() . '/assets/css/app.css', false, filemtime( get_template_directory() . '/assets/css/app.css' ), 'all' );
	wp_enqueue_script( 'bowst-press-global-scripts', get_template_directory_uri() . '/assets/js/app.js', array( 'jquery' ), filemtime( get_template_directory() . '/assets/js/app.js' ), true );
	wp_script_add_data( 'bowst-press-global-scripts', 'strategy', 'defer' );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	/**
	 * Localize site URLs for use in JavaScripts
	 * Usage: SiteInfo.theme_directory + '/scripts/widget.js'
	 */
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
 * Server environment warning.
 */
function environment_warning( $wp_admin_bar ) {
	if ( \ServerEnv::isnt( 'live' ) ) {
		$env = \ServerEnv::get();

		$args = array(
			'id'    => 'pantheon_env',
			'title' => 'ENV: ' . $env,
			'meta'  => array( 'class' => 'env-warning' ),
		);

		$wp_admin_bar->add_node( $args );
	}
}
// add_action( 'admin_bar_menu', __NAMESPACE__ . '\\environment_warning', 20 );

function env_warning_highlight() {
	if ( \ServerEnv::isnt( 'live' ) ) {
		echo '<style>.env-warning{background:#ffdc28!important}.env-warning>div{color:#23282d!important}.env-warning:hover{background:#ffdc28!important}.env-warning:hover>div{color:#23282d!important;background:none!important}</style>';
	}
}
// add_action( 'wp_head', __NAMESPACE__ . '\\env_warning_highlight' );
// add_action( 'login_head', __NAMESPACE__ . '\\env_warning_highlight' );
// add_action( 'admin_head', __NAMESPACE__ . '\\env_warning_highlight' );

/**
 * Register Custom Navigation Walker.
 */
require_once get_template_directory() . '/inc/class-wp-bootstrap-navwalker.php';

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';

/**
 * Gutenberg blocks and patterns
 */
require get_template_directory() . '/inc/gutenberg.php';

/**
 * ACF Options Page
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
 * Remove "Category:" from category title
 */
function prefix_category_title( $title ) {
	if ( is_category() || is_tax() ) {
		$title = single_cat_title( '', false );
	}
	return $title;
}
add_filter( 'get_the_archive_title', 'prefix_category_title' );
