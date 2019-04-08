<?php

/**
 * Tweaks WordPress performance
 */

class Bowst_Press_Core_Performance {

    public function __construct() {
        add_filter('wp_revisions_to_keep', array($this, 'limit_revisions'), 10, 2);
    }

    /**
     * Limit number of post revisions kept
     */
    public function limit_revisions($num, $post) {
        $num = 5;
        return $num;
    }

}
