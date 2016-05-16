<?php

/**
 * Testimonial post/page widget
 *
 * @package 8Store Lite
 */
add_action('widgets_init', 'register_cta_video_widget');

function register_cta_video_widget() {
    register_widget('eightstore_lite_cta_video');
}

class Eightstore_lite_cta_video extends WP_Widget {

    /**
     * Register widget with WordPress.
     */
    public function __construct() {
        parent::__construct(
            'eightstore_lite_cta_video', 'ES : Call to Action with Video', array(
                'description' => __('A widget that shows Call to Action with Video', 'eightstore-lite')
                )
            );
    }

    /**
     * Helper function that holds widget fields
     * Array is used in update and form functions
     */
    private function widget_fields() {
        $fields = array(
            'cta_video_title' => array(
                'eightstore_lite_widgets_name' => 'cta_video_title',
                'eightstore_lite_widgets_title' => __('Title', 'eightstore-lite'),
                'eightstore_lite_widgets_field_type' => 'title',
                ),
            'cta_video_phone' => array(
                'eightstore_lite_widgets_name' => 'cta_video_desc',
                'eightstore_lite_widgets_title' => __('Description', 'eightstore-lite'),
                'eightstore_lite_widgets_field_type' => 'textarea',
                'eightstore_lite_widgets_row' => '4'
                ),
            'cta_video_bkg' => array(
                'eightstore_lite_widgets_name' => 'cta_video_bkg',
                'eightstore_lite_widgets_title' => __('Upload Background Image', 'eightstore-lite'),
                'eightstore_lite_widgets_field_type' => 'upload',
                ),
            'cta_video_iframe' => array(
                'eightstore_lite_widgets_name' => 'cta_video_iframe',
                'eightstore_lite_widgets_title' => __('Video Iframe Url only without tags', 'eightstore-lite'),
                'eightstore_lite_widgets_field_type' => 'iframe_textarea',
                'eightstore_lite_widgets_row' => '4'
                )
            // 'cta_video_website' => array(
            //     'eightstore_lite_widgets_name' => 'cta_video_btn_text',
            //     'eightstore_lite_widgets_title' => __('Button Text', 'eightstore-lite'),
            //     'eightstore_lite_widgets_field_type' => 'text',
            //     ),
            // 'cta_video_address' => array(
            //     'eightstore_lite_widgets_name' => 'cta_video_btn_url',
            //     'eightstore_lite_widgets_title' => __('Button Url', 'eightstore-lite'),
            //     'eightstore_lite_widgets_field_type' => 'text'

            //     )
            
            );

return $fields;
}

    /**
     * Front-end display of widget.
     *
     * @see WP_Widget::widget()
     *
     * @param array $args     Widget arguments.
     * @param array $instance Saved values from database.
     */
    public function widget($args, $instance) {
        extract($args);
        if($instance){
            $allow_tag = array(
                'iframe'=>array(
                    'height'=>array(),
                    'width'=>array(),
                    'src'=>array(),
                    'frameborder'=>array()));
            $cta_video_title = $instance['cta_video_title'];
            $cta_video_desc = $instance['cta_video_desc'];
            $cta_video_iframe = wp_kses($instance['cta_video_iframe'], $allow_tag);
            $cta_video_bkg = $instance['cta_video_bkg'];
        //$cta_video_btn_text = $instance['cta_video_btn_text'];
        //$cta_video_btn_url = $instance['cta_video_btn_url'];
            

            echo $before_widget; ?>
            <div class="cta-video clearfix">
                <a href='<?php echo $cta_video_iframe; ?>' class="various iframe">
                    <figure class="video-bkg-img">
                        <?php if (!empty($cta_video_bkg)): ?>
                            <img src = "<?php echo esc_url($cta_video_bkg); ?>" alt="<?php echo esc_attr($cta_video_title);?>" />
                        <?php endif; ?>
                    </figure>
                    <div class="store-wrapper clear">
                        <h1 class="cta-title main-title wow bounceInLeft" data-wow-delay="0.5s"><?php echo $cta_video_title;?></h1>
                        <i class="fa fa-play"></i>
                        <div class="cta-desc wow bounceInRight" data-wow-delay="1.5s"><?php echo $cta_video_desc;  ?></div>
                    </div>
                </a>
                <!-- <div id="iframe-video"><?php echo $cta_video_iframe; ?></div> -->
            </div>
            <?php 
            echo $after_widget;
        }
    }

    /**
     * Sanitize widget form values as they are saved.
     *
     * @see WP_Widget::update()
     *
     * @param	array	$new_instance	Values just sent to be saved.
     * @param	array	$old_instance	Previously saved values from database.
     *
     * @uses	eightstore_lite_widgets_updated_field_value()		defined in widget-fields.php
     *
     * @return	array Updated safe values to be saved.
     */
    public function update($new_instance, $old_instance) {
        $instance = $old_instance;

        $widget_fields = $this->widget_fields();

        // Loop through fields
        foreach ($widget_fields as $widget_field) {

            extract($widget_field);

            // Use helper function to get updated field values
            $instance[$eightstore_lite_widgets_name] = eightstore_lite_widgets_updated_field_value($widget_field, $new_instance[$eightstore_lite_widgets_name]);
        }

        return $instance;
    }

    /**
     * Back-end widget form.
     *
     * @see WP_Widget::form()
     *
     * @param	array $instance Previously saved values from database.
     *
     * @uses	eightstore_lite_widgets_show_widget_field()		defined in widget-fields.php
     */
    public function form($instance) {
        $widget_fields = $this->widget_fields();

        // Loop through fields
        foreach ($widget_fields as $widget_field) {

            // Make array elements available as variables
            extract($widget_field);
            $eightstore_lite_widgets_field_value = !empty($instance[$eightstore_lite_widgets_name]) ? esc_attr($instance[$eightstore_lite_widgets_name]) : '';
            eightstore_lite_widgets_show_widget_field($this, $widget_field, $eightstore_lite_widgets_field_value);
        }
    }

}
