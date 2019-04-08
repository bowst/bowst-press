<?php
/**
 * Smart Excerpt
 *
 * Returns an excerpt which is not longer than the given length and always
 * ends with a complete sentence. If first sentence is longer than length,
 * it will add the standard ellipsis…
 *
 * Usage: <?php smart_excerpt(450, 42, true); >
 *
 * http://www.distractedbysquirrels.com/blog/wordpress-improved-dynamic-excerpt
 *
 * @param  [integer] $length Length of excerpt in characters
 * @param  [integer] $postId ID of post to return content from. Defaults to current post.
 * @param  [bool] $return true will echo the result. Defaults to true.
 * @return [string]          Excerpt text
 */

function smart_excerpt($length = 300, $postId = false, $return = true) {

    if ($postId) {
        $post = get_post($postId);
        $text = $post->post_excerpt;
    } else {
        global $post;
        $text = $post->post_excerpt;
    }

    if ('' === $text) {
        if ($postId) {
            $text = $post->post_content;
        } else {
            $text = get_the_content('');
        }

        $text = preg_replace('/\[caption.*?\].*?\[\/caption\]/', '', $text);
        $text = apply_filters('the_content', $text);
        $text = str_replace(']]>', ']]>', $text);
    }
    $text = strip_shortcodes($text);
    $text = wp_strip_all_tags($text, true);
    $text = substr($text, 0, $length);
    $excerpt = bowst_press_reverse_strrchr($text, '.', 1);

    if ($excerpt) {
        $result = apply_filters('the_excerpt', $excerpt);
    } else {
        $result = apply_filters('the_excerpt', $text . '…');
    }

    if($return === true) {
        echo $result;
    } else {
        return $result;
    }

}

/**
 * Finds the first occurance of a character in a string
 * @param  [string]  $haystack The string to search in
 * @param  [mixed]   $needle   The character to search for
 * @param  [integer] $trail    Number of trailing characters to keep (1 = keep the period in smart_excerpt()).
 * @return [string]            Search results
 */
function bowst_press_reverse_strrchr($haystack, $needle, $trail) {
    return strrpos($haystack, $needle) ? substr($haystack, 0, strrpos($haystack, $needle) + $trail) : false;
}
