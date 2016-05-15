<?php

class Nextend_ET_Builder_Module_Smart_Slider extends ET_Builder_Module {

    function init() {
        $this->name = 'Smart Slider 3';
        $this->slug = 'et_pb_nextend_smart_slider_3';

        $this->whitelisted_fields = array(
            'slider',
        );

        $this->fields_defaults = array();

        $this->advanced_options = array();

        add_action('admin_footer', 'Nextend_ET_Builder_Module_Smart_Slider::add_admin_icon');
    }

    public static function add_admin_icon() {
        ?>
        <style type="text/css">
            .et-pb-all-modules .et_pb_nextend_smart_slider_3::before,
            .et-pb-all-modules .et_pb_nextend_smart_slider_3_fullwidth::before {
                content: 'S';
            }
        </style>
        <?php
    }

    function get_fields() {
        global $wpdb;

        $res     = $wpdb->get_results('SELECT id, title FROM ' . $wpdb->prefix . 'nextend2_smartslider3_sliders');
        $options = array();
        foreach ($res AS $r) {
            $options[$r->id] = $r->title;
        }
        $fields = array(
            'slider' => array(
                'label'           => 'Slider',
                'type'            => 'select',
                'option_category' => 'basic_option',
                'options'         => $options
            )
        );

        return $fields;
    }

    function shortcode_callback($atts, $content = null, $function_name) {
        $sliderId     = $this->shortcode_atts['slider'];
        $module_class = '';
        $module_class = ET_Builder_Element::add_module_order_class($module_class, $function_name);

        return '<div class="et_pb_module et-waypoint ' . $module_class . ' et_pb_animation_off">' . N2SS3Shortcode::render(array('slider' => $sliderId), 'Divi module') . '</div>';
    }
}

class Nextend_ET_Builder_Module_Smart_Slider_Fullwidth extends Nextend_ET_Builder_Module_Smart_Slider {

    function init() {
        parent::init();
        $this->fullwidth = true;
        $this->slug      = 'et_pb_nextend_smart_slider_3_fullwidth';
    }
}

function Nextend_et_builder_get_child_modules_fix($child_modules){
    if($child_modules === ''){
        $child_modules = array();
    }
    return $child_modules;
}

add_filter( 'et_builder_get_child_modules', 'Nextend_et_builder_get_child_modules_fix');

new Nextend_ET_Builder_Module_Smart_Slider;
new Nextend_ET_Builder_Module_Smart_Slider_Fullwidth;