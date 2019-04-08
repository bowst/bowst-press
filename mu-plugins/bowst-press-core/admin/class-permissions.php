<?php

/**
 * Sets custom WordPress permissions and capabilities
 */

class Bowst_Press_Core_Permissions {

    public function __construct() {
        add_action('admin_init', array($this, 'editor_capabilities'));
    }

    /**
     * Add capabilities to Editor users
     */
    public function editor_capabilities() {
        $role = get_role('editor');
        $role->add_cap('gform_full_access');  // Gravity Forms
        $role->add_cap('edit_theme_options'); // Menus
    }

}
