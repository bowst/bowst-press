<?php
/**
 * Customizes redirect behaviors
 */

class Bowst_Press_Core_Redirect {

    public function __construct() {
        add_action('template_redirect', array($this, 'bowst_press_redirect_attachment_page'));
        add_action('template_redirect', array($this, 'disable_author_page'));
        add_filter('author_link', array($this, 'disable_author_link'));
    }

    /**
     * Redirect/disable media attachment pages
     */
    public function bowst_press_redirect_attachment_page() {
    	if (is_attachment()) {
    		global $post;
    		if ($post && $post->post_parent) {
    			wp_redirect(esc_url(get_permalink($post->post_parent)), 301);
    			exit;
    		} else {
    			wp_redirect(esc_url(home_url('/')), 301);
    			exit;
    		}
    	}
    }

    /**
     * Disables internal author page URL
     */
    public function disable_author_link() {
        return '';
    }

    /**
     * Redirect all author page requests
     */
    public function disable_author_page() {
        if (is_author()) {
            wp_redirect(home_url(), 301);
            exit;
        }
    }

}
