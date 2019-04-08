<?php

/**
 * Customizes Advanced Custom Fields
 */

class Bowst_Press_Core_ACF {

    public function __construct() {
        add_action('admin_head', array($this, 'acf_svg_display'));
    }

    /**
     * Fix display of SVGs in image fields
     */
    public function acf_svg_display() {
        echo '<style>img[src$=".svg"] { max-width:150px; max-height:150px; }</style>';
    }

}
