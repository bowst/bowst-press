<?php
/*
	Reveal IDs
	Based on version: 1.4.6.1

	Adds ID column to all content types. Only active when WP_DEBUG === true.

	Copyright 2008-2015 Oliver Schlöbe (email : scripts@schloebe.de)
	http://www.schloebe.de/wordpress/reveal-ids-for-wp-admin-25-plugin/

	This program is free software; you can redistribute it and/or modify
	it under the terms of the GNU General Public License as published by
	the Free Software Foundation; either version 2 of the License, or
	(at your option) any later version.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.

	You should have received a copy of the GNU General Public License
	along with this program; if not, write to the Free Software
	Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

class Bowst_Press_Core_Reveal_IDs {

	/**
 	 * Class constructor
 	 */
	function __construct() {
		add_action('admin_init', array(&$this, 'init'));
		add_action('admin_head', array(&$this, 'add_css'));
	}

	function bowst_pressCoreRevealIds() {
		$this->__construct();
	}

	/**
 	 * Initialize
 	 */
	public function init() {
		global $wpversion, $pagenow;
		if (!function_exists("add_action")) return;

		add_filter('manage_media_columns', array(&$this, 'column_add'));
		add_action('manage_media_custom_column', array(&$this, 'column_value'), 10, 2);

		add_filter('manage_link-manager_columns', array(&$this, 'column_add'));
		add_action('manage_link_custom_column', array(&$this, 'column_value'), 10, 2);

		add_action('manage_edit-link-categories_columns', array(&$this, 'column_add'));
		add_filter('manage_link_categories_custom_column', array(&$this, 'column_return_value'), 10, 3);

		foreach (get_taxonomies() as $taxonomy) {
			add_action("manage_edit-${taxonomy}_columns", array(&$this, 'column_add'));
			add_filter("manage_${taxonomy}_custom_column", array(&$this, 'column_return_value'), 10, 3);
			if (version_compare($GLOBALS['wp_version'], '3.0.999', '>'))
				add_filter("manage_edit-${taxonomy}_sortable_columns", array(&$this, 'column_add_clean'));
		}

		foreach (get_post_types() as $ptype) {
			add_action("manage_edit-${ptype}_columns", array(&$this, 'column_add'));
			add_filter("manage_${ptype}_posts_custom_column", array(&$this, 'column_value'), 10, 3);
			if (version_compare($GLOBALS['wp_version'], '3.0.999', '>'))
				add_filter("manage_edit-${ptype}_sortable_columns", array(&$this, 'column_add_clean'));
		}

		add_action('manage_users_columns', array(&$this, 'column_add'));
		add_filter('manage_users_custom_column', array(&$this, 'column_return_value'), 10, 3);
		if (version_compare($GLOBALS['wp_version'], '3.0.999', '>'))
			add_filter("manage_users_sortable_columns", array(&$this, 'column_add_clean'));

		add_action('manage_edit-comments_columns', array(&$this, 'column_add'));
		add_action('manage_comments_custom_column', array(&$this, 'column_value'), 10, 2);
		if (version_compare($GLOBALS['wp_version'], '3.0.999', '>'))
			add_filter("manage_edit-comments_sortable_columns", array(&$this, 'column_add_clean'));
	}

	/**
	 * Adds a bit of CSS
	 */
	public function add_css() {
		echo "\n" . '<style type="text/css">
	table.widefat th.column-skel_id {
		width: 70px;
	}

	table.widefat td.column-skel_id {
		word-wrap: normal;
	}
	</style>' . "\n";
	}

	/**
 	 * Add the new 'ID' column
 	 */
	public function column_add($cols) {
		$cols['skel_id'] = __('ID');
		return $cols;
	}

	/**
 	 * Add the new 'ID' column without any HTMLy clutter
 	 */
	public function column_add_clean($cols) {
		$cols['skel_id'] = __('ID');
		return $cols;
	}

	/**
 	 * Echo the ID for the column
 	 */
	public function column_value($column_name, $id) {
		if ($column_name == 'skel_id') echo $id;
	}

    /**
 	 * Return the ID for the column
 	 */
	public function column_return_value($value, $column_name, $id) {
		if ($column_name == 'skel_id') $value = $id;
		return $value;
	}

}
