<?php

class Bowst_Press_Core_Theme_Setup {

    public function __construct() {
        add_action('after_setup_theme', array($this, 'theme_setup'));
        add_action('wp_head', array($this, 'add_meta_tags'), 0);
        add_action('wp_head', array($this, 'add_rss_feed_tag'), 1);
        add_filter('jpeg_quality', array($this, 'increase_jpg_compression'));
    }

    /**
     * Setup core theme defaults and features
     */
    public function theme_setup() {

        // Switch default core markup for search form, comment form, and comments
        // to output valid HTML5.
        add_theme_support('html5', array(
            'search-form', 'comment-form', 'comment-list', 'gallery', 'caption',
        ));

        // Let WordPress manage the <title> tag
        add_theme_support('title-tag');

    }

    /**
     * Add required meta tags to wp_head
     */
    public function add_meta_tags() {
        echo '<meta charset="' . get_bloginfo('charset') . '">' . "\n";
        echo '<meta name="viewport" content="width=device-width, initial-scale=1">' . "\n";
    }

    /**
     * Add RSS feed tag to wp_head
     */
    public function add_rss_feed_tag() {
        echo '<link rel="alternate" type="application/rss+xml" title="' . get_bloginfo('name') . ' Feed" href="' . get_bloginfo('rss2_url') . '">' . "\n";
    }

    /**
     * Increase JPG compression (default is 90)
     */
    function increase_jpg_compression($quality) {
        return 80;
    }

}
