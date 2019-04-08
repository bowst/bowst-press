<?php

/**
 * Customizes widget editor
 */

class Bowst_Press_Core_Admin_Widgets {

    public function __construct() {
        add_filter('widget_form_callback', array($this, 'widget_form_extend'), 10, 2);
        add_filter('widget_update_callback', array($this, 'widget_update'), 10, 2);
        add_filter('dynamic_sidebar_params', array($this, 'dynamic_sidebar_params'));
    }

    /**
     * Adds a class field to widgets
     * http://kucrut.org/add-custom-classes-to-any-widget
     */
    public function widget_form_extend($instance, $widget) {
        if (!isset($instance['classes']))
            $instance['classes'] = null;
        $row = "<p>\n";
        $row .= "\t<label for='widget-{$widget->id_base}-{$widget->number}-classes'>Additional Classes <small>(separate with spaces)</small></label>\n";
        $row .= "\t<input type='text' name='widget-{$widget->id_base}[{$widget->number}][classes]' id='widget-{$widget->id_base}-{$widget->number}-classes' class='widefat' value='{$instance['classes']}'/>\n";
        $row .= "</p>\n";

        echo $row;
        return $instance;
    }

    public function widget_update($instance, $new_instance) {
        $instance['classes'] = $new_instance['classes'];
        return $instance;
    }

    public function dynamic_sidebar_params($params) {
        global $wp_registered_widgets;
        $widget_id  = $params[0]['widget_id'];
        $widget_obj = $wp_registered_widgets[$widget_id];
        $widget_opt = get_option($widget_obj['callback'][0]->option_name);
        $widget_num = $widget_obj['params'][0]['number'];

        if (isset($widget_opt[$widget_num]['classes']) && !empty($widget_opt[$widget_num]['classes']))
            $params[0]['before_widget'] = preg_replace('/class="/', "class=\"{$widget_opt[$widget_num]['classes']} ", $params[0]['before_widget'], 1);

        return $params;
    }

}
