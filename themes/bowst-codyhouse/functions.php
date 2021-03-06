<?php
/**
 * bowst-codyhouse functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package bowst-codyhouse
 */

if ( ! function_exists( 'bowst_codyhouse_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function bowst_codyhouse_setup() {
		/*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		* If you're building a theme based on bowst-codyhouse, use a find and replace
		* to change 'bowst-codyhouse' to the name of your theme in all the template files.
		*/
		load_theme_textdomain( 'bowst-codyhouse', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		* Enable support for Post Thumbnails on posts and pages.
		*
		* @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		*/
		add_theme_support( 'post-thumbnails' );

		// Load globals stylesheet in TinyMCE.
		add_editor_style(
			array(
				// 'https://fonts.googleapis.com/css?family=Open+Sans:400%2C600', // You must encode the commas in Google Font URLs!
				'public/css/globals.css',
			)
		);

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus(
			array(
				'primary' => esc_html__( 'Primary', 'bowst-codyhouse' ),
				'footer'  => esc_html__( 'Footer', 'bowst-codyhouse' ),
			)
		);

		// Set up the WordPress core custom background feature.
		add_theme_support(
			'custom-background',
			apply_filters(
				'bowst_codyhouse_custom_background_args',
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
add_action( 'after_setup_theme', 'bowst_codyhouse_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function bowst_codyhouse_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'bowst_codyhouse_content_width', 640 );
}
add_action( 'after_setup_theme', 'bowst_codyhouse_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function bowst_codyhouse_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'bowst-codyhouse' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'bowst-codyhouse' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'bowst_codyhouse_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function bowst_codyhouse_scripts() {
	/* Underscore Theme */
	wp_enqueue_style( 'bowst-codyhouse-style', get_stylesheet_uri() );
	wp_enqueue_script( 'bowst-codyhouse-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20151215', true );
	wp_enqueue_script( 'bowst-codyhouse-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true );

	/* Modernizr & Polyfills */
	wp_enqueue_script( 'modernizr', get_template_directory_uri() . '/public/js/libraries/modernizr-custom.js', false, filemtime( get_template_directory() . '/public/js/libraries/modernizr-custom.js' ), false );

	/* Custom */
	wp_enqueue_style( 'bowst-codyhouse-global-styles', get_template_directory_uri() . '/public/css/globals.css', false, filemtime( get_template_directory() . '/public/css/globals.css' ), 'all' );
	wp_enqueue_script( 'bowst-codyhouse-global-scripts', get_template_directory_uri() . '/public/js/app.js', array( 'jquery' ), filemtime( get_template_directory() . '/public/js/app.js' ), true );

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
	wp_localize_script( 'bowst-codyhouse-global-scripts', 'SiteInfo', $site_info );
}
add_action( 'wp_enqueue_scripts', 'bowst_codyhouse_scripts' );

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
add_action( 'admin_bar_menu', __NAMESPACE__ . '\\environment_warning', 20 );

function env_warning_highlight() {
	if ( \ServerEnv::isnt( 'live' ) ) {
		echo '<style>.env-warning{background:#ffdc28!important}.env-warning>div{color:#23282d!important}.env-warning:hover{background:#ffdc28!important}.env-warning:hover>div{color:#23282d!important;background:none!important}</style>';
	}
}
add_action( 'wp_head', __NAMESPACE__ . '\\env_warning_highlight' );
add_action( 'login_head', __NAMESPACE__ . '\\env_warning_highlight' );
add_action( 'admin_head', __NAMESPACE__ . '\\env_warning_highlight' );

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
