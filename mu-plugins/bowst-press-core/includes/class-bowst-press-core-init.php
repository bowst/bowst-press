<?php

/**
 * Main Init Class
 */

class Bowst_Press_Core_Init {

	public function __construct() {

		$bowst_press_core_acf                = new Bowst_Press_Core_ACF();
		$bowst_press_core_admin_render       = new Bowst_Press_Core_Admin_Render();
		$bowst_press_core_admin_widgets      = new Bowst_Press_Core_Admin_Widgets();
		$bowst_press_core_media_library      = new Bowst_Press_Core_Media_Library();
		$bowst_press_core_performance        = new Bowst_Press_Core_Performance();
		$bowst_press_core_permissions        = new Bowst_Press_Core_Permissions();
		$bowst_press_core_public_render      = new Bowst_Press_Core_Public_Render();
		$bowst_press_core_redirect           = new Bowst_Press_Core_Redirect();
		$bowst_press_core_pretty_search_urls = new Bowst_Press_Core_Search();
		$bowst_press_core_theme_setup        = new Bowst_Press_Core_Theme_Setup();

		if ((defined('WP_DEBUG') && WP_DEBUG === true) && is_admin() ) {
			$bowst_press_core_reveal_ids = new Bowst_Press_Core_Reveal_IDs();
		}

	}

}
