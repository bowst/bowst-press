<?php

/**
 * Customizes the rendering of administration area elements
 */

class Bowst_Press_Core_Admin_Render {

    public function __construct() {
        add_action('wp_before_admin_bar_render', array($this, 'admin_bar_render'), 20);
        add_filter('admin_bar_menu', array($this, 'replace_howdy'));
        add_filter('admin_footer_text', array($this, 'admin_footer_text'));
        // add_action('admin_init', array($this, 'remove_dashboard_widgets'));
        add_action('admin_init', array($this, 'remove_post_metaboxes'));
        add_action('admin_init', array($this, 'remove_page_metaboxes'));
        add_filter('user_contactmethods', array($this, 'add_profile_contact_fields'));
        add_filter('wpseo_metabox_prio', array($this, 'tame_yoast_metabox'));
    }

    /**
     * Add/remove admin bar items
     */
    public function admin_bar_render() {
        global $wp_admin_bar;
        $wp_admin_bar->remove_menu('customize'); // Customizer link
        $wp_admin_bar->remove_menu('wpseo-menu'); // Yoast
        $wp_admin_bar->remove_menu('gform-forms'); // Gravity Forms
        $wp_admin_bar->remove_menu('searchwp'); // SearchWP
    }

    /**
     * Replace "Howdy" text with "Logged in as" on admin bar
     */
    public function replace_howdy($wp_admin_bar) {
        $my_account = $wp_admin_bar->get_node('my-account');
        $newtitle   = str_replace('Howdy,', 'Logged in as', $my_account->title);
        $wp_admin_bar->add_node(array(
            'id' => 'my-account',
            'title' => $newtitle,
        ));
    }

    /**
     * Customize admin footer text
     */
    public function admin_footer_text() {
        echo 'Powered by WordPress | <a href="https://www.bowst.com" target="_blank">Made by Bowst</a>';
    }

    /**
     * Remove widgets from Dashboard
     */
    public function remove_dashboard_widgets() {
        remove_action('welcome_panel', 'wp_welcome_panel'); // Welcome to WordPress
        remove_meta_box('dashboard_right_now', 'dashboard', 'core');   // At a Glance
        remove_meta_box('dashboard_primary', 'dashboard', 'normal');   // WordPress.com Blog
        remove_meta_box('dashboard_secondary', 'dashboard', 'normal'); // Other WordPress News
        remove_meta_box('dashboard_quick_press', 'dashboard', 'side'); // Quick Draft
        remove_meta_box('wpe_dify_news_feed', 'dashboard', 'normal'); // WP Engine Blog
        remove_meta_box('rg_forms_dashboard', 'dashboard', 'normal'); // Gravity Forms
    }

    /**
     * Remove post metaboxes
     */
    public function remove_post_metaboxes() {
        remove_meta_box('postcustom', 'post', 'normal');    // Custom fields
        remove_meta_box('trackbacksdiv', 'post', 'normal'); // Trackbacks
    }

    /**
     * Remove page metaboxes
     */
    public function remove_page_metaboxes() {
        remove_meta_box('postcustom', 'page', 'normal');    // Custom fields
        remove_meta_box('postexcerpt', 'page', 'normal');   // Excerpt
        remove_meta_box('trackbacksdiv', 'page', 'normal'); // Trackbacks
    }

    /**
     * Add more contact info fields to user profiles
     */
    public function add_profile_contact_fields($profile_fields) {
        $profile_fields['phone'] = 'Phone';
        $profile_fields['job_title'] = 'Job Title';
        $profile_fields['twitter'] = 'Twitter Username';
        $profile_fields['linkedin'] = 'LinkedIn Username';
        return $profile_fields;
    }

    /**
     * Keep Yoast SEO metabox on the bottom
     */
    public function tame_yoast_metabox() {
        return 'low';
    }

}
