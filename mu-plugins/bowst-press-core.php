<?php
/*
Plugin Name: Bowst-Press Core Functions
Description: Core functions, helpers, and customizations
Author: Bowst
Version: 1.0
Author URI: https://www.bowst.com/
*/

// If this file is called directly, abort
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The core plugin class
 */
require plugin_dir_path( __FILE__ ) . 'bowst-press-core/bowst-press-core.php';
