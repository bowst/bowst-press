<?php
class Bowst_Press_Core_Search {

    public function __construct() {
        add_action('template_redirect', array($this, 'pretty_search_urls'));
        add_action('pre_get_posts', array($this, 'empty_search_queries'));
    }

    /**
     * Pretty Search URLs
     *
     * Rewrites search URLs from /?s=query to /search/query/ and converts %20 to +
     * http://txfx.net/wordpress-plugins/nice-search
     *
     */
	public function pretty_search_urls() {

	    global $wp_rewrite;

	    if (!isset($wp_rewrite) || !is_object($wp_rewrite) || !$wp_rewrite->using_permalinks()) {
	        return;
	    }

	    $search_base = $wp_rewrite->search_base;

	    if (is_search() && !is_admin() && strpos($_SERVER['REQUEST_URI'], "/{$search_base}/") === false) {
	        wp_redirect(home_url("/{$search_base}/" . urlencode(get_query_var('s')) . "/"));
	        exit();
	    }
	}

    /**
     * Prevent 404 on empty search queries
     */
    function empty_search_queries($query) {
        global $wp_query;
        if (isset($_GET['s']) && $_GET['s'] === '') {
            $wp_query->set('s', ' ');
            $wp_query->is_search=true;
        }
        return $query;
    }

}
