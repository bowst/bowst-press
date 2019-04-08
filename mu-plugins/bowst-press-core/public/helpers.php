<?php

/**
 * Frequently-used Helper Functions
 */

/**
 * Get inline SVG markup
 * @param  string  $file  File name (if ending in /{something}.svg, use that for full path instead of concatenating)
 * @param  boolean $echo  Echo SVG file contents or return if false
 * @param  string  $path  Path of image directory relative to theme's root
 * @return string         Markup of SVG file
 */
function get_inline_svg($file, $echo = true, $path = 'public/img') {
    if (preg_match('/^(.*?)\/(.*?)\.svg$/i', $file)) {
        $file_path = $file;
    } else {
        $file_path = get_template_directory() . '/' . $path . '/' . $file;
    }

    if (file_exists($file_path)) {
        if ($echo === true) {
            echo file_get_contents($file_path);
        } else {
            return file_get_contents($file_path);
        }
    }
}

/**
 * Get inline SVG from file URL
 * @param  string  $file  URL of SVG
 * @param  boolean $echo  Echo SVG file contents or return if false
 * @return string         Markup of SVG file
 */
function get_url_inline_svg($file, $echo = true) {
    $headers = @get_headers($file);
    $response = substr($headers[0], 9, 3);
    if (!$headers || $response !== '200') {
        return false;
    } else {
        if ($echo === true) {
            echo file_get_contents($file);
        } else {
            return file_get_contents($file);
        }
    }
}

/**
 * Returns actual disk path of asset from
 * given absolute URI
 * @param  string $uri Absolute URI
 * @return string      Disk path
 */
function get_local_image_path($uri = false) {
    if ($uri) {
        return ABSPATH . preg_replace('/.*\/\/(.*?)\/(.*?)/', '\2', $uri);
    }
}

/**
 * Create web-friendly slug from any string
 * @param  string $text String to convert
 * @return string       Web-friendly slug
 */
function create_slug($text) {
    // Lower case everything
    $text = strtolower($text);
    // Make alphanumeric (removes all other characters)
    $text = preg_replace("/[^a-z0-9_\s-]/", "", $text);
    // Clean up multiple dashes or whitespaces
    $text = preg_replace("/[\s-]+/", " ", $text);
    // Convert whitespaces and underscore to dash
    $text = preg_replace("/[\s_]/", "-", $text);

    return $text;
}

/**
 * Test if current post is an ancestor of given post ID
 * @param  integer $pid Post ID of parent
 * @return boolean
 */
function is_tree($pid) {
    global $post;
    if (is_page($pid))
        return true;
    $anc = get_post_ancestors($post->ID);
    foreach ($anc as $ancestor) {
        if (is_page() && $ancestor == $pid) {
            return true;
        }
    }
    return false;
}

/**
 * Return post ID of the topmost parent of the current post
 * @return integer Post ID
 */
function get_post_top_ancestor_id() {
    global $post;
    if ($post->post_parent) {
        $ancestors = array_reverse(get_post_ancestors($post->ID));
        return $ancestors[0];
    }
    return $post->ID;
}

/**
 * Display the classes for the html element
 * @param string|array $class One or more classes to add to the class list.
 */
function html_class($class = '') {
    echo 'class="no-js ' . join(' ', get_html_class($class)) . '"';
}

/**
 * Retrieve the classes for the html element as an array
 * @param string|array $class One or more classes to add to the class list.
 * @return array Array of classes.
 */
function get_html_class($class = '') {
    $classes = array();

    if (!empty($class)) {
        if (!is_array($class)) {
            $class = preg_split('#\s+#', $class);
        }
        $classes = array_merge($classes, $class);
    } else {
        $class = array();
    }

    $classes = array_map('esc_attr', $classes);

    $classes = apply_filters('html_class', $classes, $class);

	return array_unique($classes);
}

/**
 * Filter YouTube video ID from video URL
 * @param  [string] $url Video page URL
 * @return [string]      Video ID
 */
function get_youtube_id($url) {
    $pattern =
        '%^# Match any youtube URL
        (?:https?://)?  # Optional scheme. Either http or https
        (?:www\.)?      # Optional www subdomain
        (?:             # Group host alternatives
          youtu\.be/    # Either youtu.be,
        | youtube\.com  # or youtube.com
          (?:           # Group path alternatives
            /embed/     # Either /embed/
          | /v/         # or /v/
          | /watch\?v=  # or /watch\?v=
          )             # End path alternatives.
        )               # End host alternatives.
        ([\w-]{10,12})  # Allow 10-12 for 11 char youtube id.
        $%x'
        ;

    $result = preg_match($pattern, $url, $matches);

    if (false !== $result) {
        return $matches[1];
    }

    return false;
}

/**
 * Returns the current active post type
 */
function get_current_post_type() {
    global $post, $typenow, $current_screen;

    // Get from current post
    if ($post && $post->post_type) {
        return $post->post_type;
    }
    // Get from $typenow global for wp-admin pages
    elseif ($typenow) {
        return $typenow;
    }
    // Get from $current_screen global for wp-admin pages
    elseif ($current_screen && $current_screen->post_type) {
        return $current_screen->post_type;
    }
    // Get from the post_type query string
    elseif (isset($_REQUEST['post_type'])) {
        return sanitize_key($_REQUEST['post_type']);
    }
    // Get via current post ID
    elseif (isset($_REQUEST['post'])) {
        return get_post_type($_REQUEST['post']);
    }

    return null;
}
