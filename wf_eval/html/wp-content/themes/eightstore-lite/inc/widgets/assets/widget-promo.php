<?php

/**
 * Testimonial post/page widget
 *
 * @package 8Store Lite
 */
add_action('widgets_init', 'register_promo_widget');

function register_promo_widget() {
    register_widget('eightstore_lite_promo');
}

class Eightstore_lite_promo extends WP_Widget {

    /**
     * Register widget with WordPress.
     */
    public function __construct() {
        parent::__construct(
            'eightstore_lite_promo', 'ES : Promotional Banner Widget', array(
                'description' => __('A widget that Gives Promo of the object', 'eightstore-lite')
                )
            );
    }

    /**
     * Helper function that holds widget fields
     * Array is used in update and form functions
     */
    private function widget_fields() {
        $fields = array(
            'promo_title' => array(
                'eightstore_lite_widgets_name' => 'promo_title',
                'eightstore_lite_widgets_title' => __('Title', 'eightstore-lite'),
                'eightstore_lite_widgets_field_type' => 'text',
                ),
            
            'promo_image' => array(
                'eightstore_lite_widgets_name' => 'promo_image',
                'eightstore_lite_widgets_title' => __('Upload Image', 'eightstore-lite'),
                'eightstore_lite_widgets_field_type' => 'upload',
                ),
            
            'promo_desc' => array(
                'eightstore_lite_widgets_name' => 'promo_desc',
                'eightstore_lite_widgets_title' => __('Enter Promo Desc', 'eightstore-lite'),
                'eightstore_lite_widgets_field_type' => 'textarea',   
                'eightstore_lite_widgets_row' =>'4',
                ),
            
            'promo_link' => array(
                'eightstore_lite_widgets_name' => 'promo_link',
                'eightstore_lite_widgets_title' => __('Enter Promo Link', 'eightstore-lite' ),
                'eightstore_lite_widgets_field_type' => 'url'
                ),

            'promo_btn_text' => array(
                'eightstore_lite_widgets_name' => 'promo_btn_text',
                'eightstore_lite_widgets_title' => __('Enter Promo Button Text', 'eightstore-lite' ),
                'eightstore_lite_widgets_field_type' => 'text'
                ),
            
            
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

        $promo_title = $instance['promo_title'];
        $promo = $instance['promo_image'];
        if(isset($instance['promo_btn_text'])){
            $promo_btn_text = $instance['promo_btn_text'];
        }else{
            $promo_btn_text = "";
        }
        $promo_desc = $instance['promo_desc'];
        $promo_link = $instance['promo_link'];
        
        echo $before_widget; ?>
        <div class="promo-widget-wrap">
            <a href="<?php echo  $promo_link?> ">
                <div class="promo-image">
                    <?php
                    if (!empty($promo)){ ?>
                    <img src = "<?php echo $promo; ?>" />
                    <?php } ?>
                </div>
                <div class="caption">
                    <?php
                    if (!empty($promo_title)){ ?>
                    <h4 class="widget-title"><?php echo eightstore_lite_get_title($promo_title); ?></h4>
                    <?php } ?>

                    <?php
                    if (!empty($promo_desc)){ ?>
                    <div class="desc"><?php echo $promo_desc; ?></div>
                    <?php } ?>

                    <?php
                    if (!empty($promo_btn_text)){ ?>
                    <div class="promo-btn"><?php echo $promo_btn_text; ?></div>
                    <?php } ?> 
                </div>
            </a>
        </div>        
        <?php 
        echo $after_widget;
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