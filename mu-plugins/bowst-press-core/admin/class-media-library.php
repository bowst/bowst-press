<?php

/**
 * Customizes the WordPress media library
 */

class Bowst_Press_Core_Media_Library {

    public function __construct() {
        add_filter('upload_mimes', array($this, 'add_mime_types'));
        add_filter('post_mime_types', array($this, 'mime_types_sort'));
        add_filter('wp_handle_upload_prefilter', array($this, 'handle_upload_prefilter'));
        add_filter('media_view_settings', array($this, 'gallery_default_links'));
    }

    /**
     *  Allowed file types
     */
    public function add_mime_types($mimes) {
        $mimes['svg'] = 'image/svg+xml';
        return $mimes;
    }

    /**
     * Add PDF option to type filter dropdown in Media Library
     */
    public function mime_types_sort($post_mime_types) {
        $post_mime_types['application/pdf'] = array(__('PDF'), __('Manage PDF'), _n_noop('PDF <span class="count">(%s)</span>', 'PDF <span class="count">(%s)</span>'));
        return $post_mime_types;
    }

    /**
     * Validate Image Uploads
     *
     * Enforce a maximum file size of 1MB, a maximum image size of 2000px,
     * and only JPG, SVG, GIF, and PNG files.
     */
    public function handle_upload_prefilter($file) {

        $file_dims      = getimagesize($file['tmp_name']);
        $file_width     = $file_dims[0];
        $file_height    = $file_dims[1];
        $max_dims       = array('width' => '2000', 'height' => '2000');

        $file_size      = $file['size'];
        $file_size_mb   = number_format($file_size / (1<<20), 2);

        $file_type      = $file['type'];
        $allowed_images = array('image/jpeg',
                                'image/svg+xml',
                                'image/gif',
                                'image/png');

        // Only process image files
        if (in_array($file_type, $allowed_images)) {

            // No images files larger than 1MB
            if ($file_size > 1000 * 1024)
                return array("error" => "Image size is too large. Maximum image size is 1MB. Uploaded image size is {$file_size_mb}MB.");

            // No images bigger than 2000x2000px
            elseif ($file_width > $max_dims['width'])
                return array("error" => "Image dimensions are too large. Maximum width is {$max_dims['width']}px. Uploaded image width is {$file_width}px.");

            elseif ($file_height > $max_dims['height'])
                return array("error" => "Image dimensions are too large. Maximum height is {$max_dims['height']}px. Uploaded image height is {$file_height}px.");

            else
                return $file;

        } else {

                return $file;

        }

    }

    /**
     * Force gallery images to link to file
     */
    public function gallery_default_links($settings) {
        $settings['galleryDefaults']['link'] = 'file';
        return $settings;
    }

}

/**
 * Adds file size column to attachments list
 */
function bowst_press_media_filesize_column( $cols ) {
    $cols['filesize'] = 'File Size';
    return $cols;
}

add_filter('manage_media_columns', 'bowst_press_media_filesize_column');

/**
 * Adds content to attachments list file size column and
 * colors the value depending on how big the file size is
 */
function bowst_press_media_filesize_column_content($name, $id) {

    switch ($name) {
        case 'filesize':

            $color = 'black';
            $weight = 'normal';
            $img_mimes = array('image/jpeg', 'image/gif', 'image/png');

            $filesize = filesize(get_attached_file($id));
            $size = array('B','KB','MB','GB','TB','PB','EB','ZB','YB');
            $factor = floor((strlen($filesize) - 1) / 3);
            $output = sprintf("%.0f", $filesize / pow(1024, $factor)) . @$size[$factor];

            $mimetype = get_post_mime_type($id);

            // If attachment is an image and is 100-199KB
            if (in_array($mimetype, $img_mimes) && (100000 <= $filesize) && ($filesize <= 199999)) {
                $color = '#F1C600';
                $weight = 'bold';

            // If attachment is an image and is 200KB or more
            } elseif (in_array($mimetype, $img_mimes) && $filesize >= 200000) {
                $color = 'red';
                $weight = 'bold';
            }

            echo "<span style='color:{$color}; font-weight:{$weight};'>{$output}</span>";
    }
}

add_action('manage_media_custom_column', 'bowst_press_media_filesize_column_content', 10, 2);
