<?php

/**
 * Log debug info to browser console
 */
function bowst_press_console_debug() {

    $debug_data = array();

    // Page info
    if (is_front_page() && is_home()) {
        $debug_data['Page Information']['Page Type'] = 'home blog';
    } elseif (is_front_page()) {
        $debug_data['Page Information']['Page Type'] = 'home';
    } elseif (is_home()) {
        $debug_data['Page Information']['Page Type'] = 'blog';
    } elseif (is_page()) {
        $debug_data['Page Information']['Page Type'] = 'page';
    } elseif (is_single()) {
        $debug_data['Page Information']['Page Type'] = 'post';
    } elseif (is_archive()) {
        $debug_data['Page Information']['Page Type'] = 'archive';
    } elseif (is_search()) {
        $debug_data['Page Information']['Page Type'] = 'search';
    }

    // Template info
    global $template;
    $templateFile = basename($template);
    $debug_data['Page Information']['Template'] = $templateFile;

    // Get current queried object info
    $page_object = get_queried_object();
    if (isset($page_object)) {
        foreach ($page_object as $key=>$value) {
            if ($key !== 'post_content' && $value !== '') {
                $debug_data['Queried Object'][$key] = $value;
            }
        }
    }

    // Get taxonomy info
    global $post;
    if (is_single()) {

        $post_type = $post->post_type;

        // Custom post types
        if ($post_type !== 'post') {

            $taxonomy_list = array();
            $taxonomies = get_object_taxonomies($post_type);

            foreach ($taxonomies as $tax) {

                $terms = wp_get_post_terms($post->ID, $tax);
                $term_list = array();

                foreach ($terms as $term) {
                    $term_list[] = $term->slug . '(' . $term->term_id . ')';
                }

                $debug_data['Queried Object'][$tax] = implode(', ', $term_list);

            }

        // Posts
        } else {

            $categories = wp_get_post_terms($post->ID, 'category');
            $cat_list = array();

            foreach ($categories as $cat) {
                $cat_list[] = $cat->slug . '(' . $cat->term_id . ')';
            }

            if (!empty($cat_list)) {
                $debug_data['Queried Object']['category'] = implode(', ', $cat_list);
            }

            $tags = wp_get_post_terms($post->ID, 'post_tag');
            $tag_list = array();

            foreach ($tags as $tag) {
                $tag_list[] = $tag->slug . '(' . $tag->term_id . ')';
            }

            if (!empty($tag_list)) {
                $debug_data['Queried Object']['tag'] = implode(', ', $tag_list);
            }

        }

    }

    $localized_data = wp_json_encode($debug_data);

    echo "<script>console.info(JSON.stringify($localized_data, null, '    '));</script>";

}

if (defined('WP_CONSOLE_DEBUG') || define('WP_CONSOLE_DEBUG', false)) {
    if (WP_CONSOLE_DEBUG === true) {
        add_action('wp_footer', 'bowst_press_console_debug');
    }
}

/**
 * Discourage search engines from indexing this site
 */
if (defined('WP_DEBUG') && WP_DEBUG === true) {
    add_filter('pre_option_blog_public', '__return_zero');
}

/**
 * Log passed data to the WordPress debug.log
 * @param  [mixed] $log Data to log
 */
if (!function_exists('write_log')) {
    function write_log($log)  {
        if (is_array($log) || is_object($log)) {
           error_log(print_r($log, true));
        } else {
           error_log($log);
        }
    }
}

/**
 * Plugin disabling engine class
 * Author: Mark Jaquith
 * Author URI: http://markjaquith.com/
 * Plugin URI: https://gist.github.com/markjaquith/1044546
 * Using fork: https://gist.github.com/Rarst/4402927
 */
class Bowst_Press_Disable_Plugins {
    static $instance;
    private $disabled = array();

    /**
     * Sets up the options filter, and optionally handles an array of plugins to disable
     * @param array $disables Optional array of plugin filenames to disable
     */
    public function __construct( Array $disables = NULL) {
        /**
         * Handle what was passed in
         */
        if ( is_array( $disables ) ) {
            foreach ( $disables as $disable )
                $this->disable( $disable );
        }

        /**
         * Add the filters
         */
        add_filter( 'option_active_plugins', array( $this, 'do_disabling' ) );
        add_filter( 'site_option_active_sitewide_plugins', array( $this, 'do_network_disabling' ) );

        /**
         * Allow other plugins to access this instance
         */
        self::$instance = $this;
    }

    /**
     * Adds a filename to the list of plugins to disable
     */
    public function disable( $file ) {
        $this->disabled[] = $file;
    }

    /**
     * Hooks in to the option_active_plugins filter and does the disabling
     * @param array $plugins WP-provided list of plugin filenames
     * @return array The filtered array of plugin filenames
     */
    public function do_disabling( $plugins ) {
        if ( count( $this->disabled ) ) {
            foreach ( (array) $this->disabled as $plugin ) {
                $key = array_search( $plugin, $plugins );
                if ( false !== $key )
                    unset( $plugins[$key] );
            }
        }
        return $plugins;
    }

    /**
     * Hooks in to the site_option_active_sitewide_plugins filter and does the disabling
     *
     * @param array $plugins
     *
     * @return array
     */
    public function do_network_disabling( $plugins ) {

        if ( count( $this->disabled ) ) {
            foreach ( (array) $this->disabled as $plugin ) {

                if( isset( $plugins[$plugin] ) )
                    unset( $plugins[$plugin] );
            }
        }

        return $plugins;
    }
}

// DISABLE PRODUCTION PLUGINS
if (defined('WP_DEBUG') && WP_DEBUG === true) {
    new Bowst_Press_Disable_Plugins(array(
        'w3-total-cache/w3-total-cache.php',   // W3 Total Cache
        'wordpress-https/wordpress-https.php', // WordPress HTTPS
        'wp-super-cache/wp-super-cache.php',   // WP Super Cache
        'backupbuddy/backupbuddy.php'          // BackupBuddy
    ));
}
?>
