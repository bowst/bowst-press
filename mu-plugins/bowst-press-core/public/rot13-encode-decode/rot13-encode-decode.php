<?php
/*
    A combination of PHP and JavaScript to encode and automatically decode
    strings in ROT-13. Useful for masking sensitive content that must be displayed in
    plain-text, like an email address, from evil spambots. Not bulletproof, but
    better than nothing!

    USAGE:

    1. Echo your string using the rot13_encode() function:

    <?php echo rot13_encode('secret-email-address@example.com'); ?>

    2. Enqueued JavaScript looks for all span.rot13-encoded elements
    and automatically decodes the text values.
*/

/**
 * Enqueue required assets
 */
function rot13_enqueue_script() {

    wp_enqueue_script(
	    'rot13_encode_decode',
	    plugin_dir_url(__FILE__) . 'rot13-encode-decode.js',
	    false,
	    '1.0',
	    true
	);

}

add_action('wp_enqueue_scripts', 'rot13_enqueue_script');

/**
 * Encode email address using ROT-13
 * @param  string $email   Email address
 * @param  string $classes List of classes for anchor element, space separated
 * @param  string $id      ID for anchor element
 * @param  array  $data    Array of data attributes. Key is data name, value is data value.
 *                         Each key/value pair becomes a single data attribute.
 *                         array('foo' => 'bar') becomes data-foo=bar.
 * @return string          ROT-13 encoded text string
 */
function rot13_encode_email($email = '', $classes = '', $id = '', $data = array()) {
    if (!empty($email)) {

        $link = "<a href='mailto:{$email}'";

        if (!empty($id)) {
            $link .= " id='{$id}'";
        }

        if (!empty($classes)) {
            $link .= " class='{$classes}'";
        }

        if (!empty($data) && is_array($data)) {
            $data_attrs = '';
            foreach ($data as $key => $value) {
                $data_attrs .= " data-{$key}='{$value}'";
            }
            $link .= $data_attrs;
        }

        $link .= ">$email</a>";

        $output = '<span class="rot13-encoded">' . str_rot13($link) . '</span>';

        return $output;
    }
}
