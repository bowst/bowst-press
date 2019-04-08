<?php

/**
 * The core plugin class.
 */
if ( ! class_exists( 'Bowst_Press_Core' ) ) {

	class Bowst_Press_Core {

		private static $instance;

		/**
		 * Instance of the plugin
		 */
		public static function instance() {
			if ( ! isset( self::$instance ) && ! ( self::$instance instanceof Bowst_Press_Core ) ) {
				self::$instance = new Bowst_Press_Core();
				self::$instance->includes();
				self::$instance->init = new Bowst_Press_Core_Init();
			}
			return self::$instance;
		}

		/**
		 * Load required files
		 */
		private function includes() {
			$plugin_path = plugin_dir_path(__FILE__);

			// Classes
			require $plugin_path . 'includes/class-development.php';
			require $plugin_path . 'includes/class-theme-setup.php';
			require $plugin_path . 'includes/class-acf.php';
			require $plugin_path . 'includes/class-yoast.php';
			require $plugin_path . 'admin/class-admin-render.php';
			require $plugin_path . 'admin/class-media-library.php';
			require $plugin_path . 'admin/class-performance.php';
			require $plugin_path . 'admin/class-permissions.php';
			require $plugin_path . 'admin/class-reveal-ids.php';
			require $plugin_path . 'admin/class-widgets.php';
			require $plugin_path . 'public/class-public-render.php';
			require $plugin_path . 'public/class-redirect.php';
			require $plugin_path . 'public/class-search.php';
			require $plugin_path . 'public/rot13-encode-decode/rot13-encode-decode.php';

			// Initialize classes
			require $plugin_path . 'includes/class-bowst-press-core-init.php';

			// Global functions
			require $plugin_path . 'public/helpers.php';
			require $plugin_path . 'public/pagination.php';
			require $plugin_path . 'public/smart-excerpt.php';

		}

	}

}
/**
 * Return the instance
 */
function Bowst_Press_Core_Run() {
	return Bowst_Press_Core::instance();
}
Bowst_Press_Core_Run();
