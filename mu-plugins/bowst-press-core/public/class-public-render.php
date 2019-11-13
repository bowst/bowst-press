<?php
/**
 * Customizes the rendering of frontend elements
 */

class Bowst_Press_Core_Public_Render {

    public function __construct() {
        add_action('init', array($this, 'wp_head_tidy'));
        // add_filter('style_loader_tag', array($this, 'style_tags_tidy'));
        // add_filter('script_loader_tag', array($this, 'script_tags_tidy'));
        add_filter('body_class', array($this, 'body_classes'));
        add_filter('the_content', array($this, 'shortcode_empty_p_fix'));
        add_filter('acf_the_content', array($this, 'shortcode_empty_p_fix'));
        add_filter('embed_oembed_html', array($this, 'oembed_wrapper'));
        add_filter('the_content', array($this, 'linked_img_classes'), 100, 1);
        add_filter('acf_the_content', array($this, 'linked_img_classes'), 100, 1);
        add_filter('get_avatar', array($this, 'remove_self_closing_tags'));
        add_filter('comment_id_fields', array($this, 'remove_self_closing_tags'));
        add_filter('post_thumbnail_html', array($this, 'remove_self_closing_tags'));
        add_filter('get_bloginfo_rss', array($this, 'remove_default_description'));
        add_action('wp_head', array($this, 'disqus_comments'));
        add_filter('html_class', array($this, 'ie_html_classes'));
        add_filter('the_content', array($this, 'add_img_link_class'));
        add_filter('acf/load_value', array($this, 'add_img_link_class'));
    }

    /**
     * Clean up wp_head()
     */
    public function wp_head_tidy() {

        // Remove unnecessary links
        remove_action('wp_head', 'feed_links', 2);
        remove_action('wp_head', 'feed_links_extra', 3);
        remove_action('wp_head', 'rsd_link');
        remove_action('wp_head', 'wlwmanifest_link');
        remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
        remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);
        remove_action('wp_head', 'wp_generator');

        // Remove inline CSS used by Recent Comments widget
        global $wp_widget_factory;
        if (isset($wp_widget_factory->widgets['WP_Widget_Recent_Comments'])) {
            remove_action('wp_head', array($wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style'));
        }

    }

    /**
     * Clean up output of stylesheet link tags
     */
    public function style_tags_tidy($input) {
        preg_match_all("!<link rel='stylesheet'\s?(id='[^']+')?\s+href='(.*)' type='text/css' media='(.*)' />!", $input, $matches);
        $media = $matches[3][0] !== '' && $matches[3][0] !== 'all' ? ' media="' . $matches[3][0] . '"' : '';
        return '<link rel="stylesheet" href="' . $matches[2][0] . '"' . $media . '>' . "\n";
    }

    /**
     * Clean up output of script link tags
     */
    public function script_tags_tidy($input) {
        $input = str_replace("type='text/javascript' ", '', $input);
        return str_replace("'", '"', $input);
    }

    /**
     * Customize body element classes
     */
    public function body_classes($classes) {

        // Add post/page slug if not present and template slug
        if (is_single() || is_page() && !is_front_page()) {
            if (!in_array(basename(get_permalink()), $classes)) {
                $classes[] = basename(get_permalink());
            }
            $classes[] = str_replace('.php', '', basename(get_page_template()));
        }

        // Add post type class
        $queried_obj = get_queried_object();

        if ($queried_obj && is_post_type_archive()) {
            $classes[] = 'post-type-' . $queried_obj->name;
        }

        if ($queried_obj && is_singular()) {
            $classes[] = 'post-type-' . $queried_obj->post_type;
        }

        // Remove unnecessary classes
        $home_id_class = 'page-id-' . get_option('page_on_front');
        $remove_classes = array(
            'page-template-default',
            $home_id_class
            );

        $classes = array_diff($classes, $remove_classes);
        return $classes;
    }

    /**
     * Fix shortcode empty paragraph issue
     * http://core.trac.wordpress.org/ticket/12061
     */
    public function shortcode_empty_p_fix($content) {
        $array = array (
            '<p>['    => '[',
            ']</p>'   => ']',
            ']<br />' => ']',
            ']<br>' => ']',
            '<p></p>' => '',
            "]\r\n"   => ']',
            "\r\n["   => '['
        );
        $content = strtr($content, $array);
        return $content;
    }

    /**
     * Wrap embedded media properly
     */
    public function oembed_wrapper($cache) {
        return '<div class="entry-oembed">' . $cache . '</div>';
    }

    /**
     * Add class(es) to anchors wrapped around images in the WYSIWYG
     */
    public function linked_img_classes($html) {
        $classes = 'wp-image-link';
        $patterns = array();
        $replacements = array();
        $patterns[0] = '/<a(?![^>]*class)([^>]*)>\s*<img([^>]*)>\s*<\/a>/'; // matches img tag wrapped in anchor tag where anchor tag where anchor has no existing classes
        $replacements[0] = '<a\1 class="' . $classes . '"><img\2></a>';
        $html = preg_replace($patterns, $replacements, $html);
        return $html;
    }

    /**
     * Remove unnecessary self-closing tags
     */
    public function remove_self_closing_tags($input) {
        return str_replace(' />', '>', $input);
    }

    /**
     * Don't return the default description in the RSS feed if it hasn't been changed
     */
    public function remove_default_description($bloginfo) {
        $default_tagline = 'Just another WordPress site';
        return ($bloginfo === $default_tagline) ? '' : $bloginfo;
    }

    /**
     * Remove Disqus JavaScript except on single posts where we need it
     */
    public function disqus_comments() {
        if (is_singular(array('post')) && comments_open()) {
            return;
        }
        remove_action('loop_end', 'dsq_loop_end');
        remove_action('wp_footer', 'dsq_output_footer_comment_js');
    }

    /**
     * Add IE-conditional classes to html element
     */
    public function ie_html_classes() {
        $classes = array();

        // Detect user agents
        $ie   = (preg_match('/MSIE/', $_SERVER['HTTP_USER_AGENT'])) ? true : false;
        $ie6  = (preg_match('/MSIE 6/', $_SERVER['HTTP_USER_AGENT'])) ? true : false;
        $ie7  = (preg_match('/MSIE 7/', $_SERVER['HTTP_USER_AGENT'])) ? true : false;
        $ie8  = (preg_match('/MSIE 8/', $_SERVER['HTTP_USER_AGENT'])) ? true : false;
        $ie9  = (preg_match('/MSIE 9/', $_SERVER['HTTP_USER_AGENT'])) ? true : false;
        $ie10 = (preg_match('/MSIE 10/', $_SERVER['HTTP_USER_AGENT'])) ? true : false;

        // If IE
        if ($ie) {
            $classes[] = 'is-ie';
        }

        // If specific versions
        if ($ie6) {
            array_push($classes, 'lt-ie11', 'lt-ie10', 'lt-ie9', 'lt-ie8', 'lt-ie7');
        }
        if ($ie7) {
            array_push($classes, 'lt-ie11', 'lt-ie10', 'lt-ie9', 'lt-ie8');
        }
        if ($ie8) {
            array_push($classes, 'lt-ie11', 'lt-ie10', 'lt-ie9');
        }
        if ($ie9) {
            array_push($classes, 'lt-ie11', 'lt-ie10');
        }
        if ($ie10) {
            array_push($classes, 'lt-ie11');
        }

        return $classes;
    }

    /**
     * Add class to content image anchor links
     */
    public function add_img_link_class($content) {
    	$pattern = "/<a(.*?)href=('|\")(.*?).(bmp|gif|jpeg|jpg|png|svg)('|\")(.*?)>/i";
      	$replacement = '<a$1class="entry-img-link" href=$2$3.$4$5$6</a>';
        $content = preg_replace($pattern, $replacement, $content);
        return $content;
    }
}
