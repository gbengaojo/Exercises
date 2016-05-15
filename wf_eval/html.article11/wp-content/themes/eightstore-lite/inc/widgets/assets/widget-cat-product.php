<?php
/**
* Widget Product 1
* 
* 
* @package 8Store Lite
*/
if(is_woocommerce_available()):
  add_action('widgets_init', 'register_cat_product_widget');

  function register_cat_product_widget(){ //functions start from here
    register_widget('eightstore_lite_cat_product');
  }

  class Eightstore_lite_cat_product extends WP_Widget {
  /**
  * Register Widget with Wordpress
  * 
  */
  public function __construct() {
    parent::__construct(
      'eightstore_lite_cat_product', 'ES: WC Category & Product', array(
        'description' => __('This widgets show the Category Image,Description and Product of that Category', 'eightstore-lite')
        )
      );
  }

  /**
  * Helper function that holds widget fields
  * Array is used in update and form functions
  */
  private function widget_fields() {

    $prod_type = array(
      'right_align' => __('Right Align With Category Image', 'eightstore-lite'),
      'left_align' => __('Left Align With Category Image', 'eightstore-lite'),
      );
    $taxonomy     = 'product_cat';
    $empty        = 1;
    $orderby      = 'name';  
    $show_count   = 0;      // 1 for yes, 0 for no
    $pad_counts   = 0;      // 1 for yes, 0 for no
    $hierarchical = 1;      // 1 for yes, 0 for no  
    $title        = '';  
    $empty        = 0;
    $args = array(
      'taxonomy'     => $taxonomy,
      'orderby'      => $orderby,
      'show_count'   => $show_count,
      'pad_counts'   => $pad_counts,
      'hierarchical' => $hierarchical,
      'title_li'     => $title,
      'hide_empty'   => $empty

      );
    $woocommerce_categories = array();
    $woocommerce_categories_obj = get_categories($args);
    $woocommerce_categories[''] = 'Select Product Category:';
    foreach ($woocommerce_categories_obj as $category) {
      $woocommerce_categories[$category->term_id] = $category->name;
    }

    $fields = array(
      'product_type' => array(
        'eightstore_lite_widgets_name' => 'product_alignment',
        'eightstore_lite_widgets_title' => __('Select the Display Style (Image Alignment)', 'eightstore-lite'),
        'eightstore_lite_widgets_field_type' => 'select',
        'eightstore_lite_widgets_field_options' => $prod_type

        ),
      'product_category' => array(
        'eightstore_lite_widgets_name' => 'product_category',
        'eightstore_lite_widgets_title' => __('Select Product Category', 'eightstore-lite'),
        'eightstore_lite_widgets_field_type' => 'select',
        'eightstore_lite_widgets_field_options' => $woocommerce_categories

        ),


      );
    return $fields;
  }

  public function widget($args, $instance){
    extract($args);
    if($instance){
      $product_alignment       =   $instance['product_alignment'];
      $product_category   =   $instance['product_category'];
      $product_args =  array(
        'post_type' => 'product',
        'tax_query' => array(array('taxonomy'  => 'product_cat',
          'field'     => 'id', 
          'terms'     => $product_category                                                                 
          )),
        'posts_per_page' => '6'
        );

        ?>
        <section class="category_product">
          <div class="store-wrapper">
            <?php
            echo $before_widget;
            ?>
            <div class="feature-cat-product-wrap">
              <?php 
              $woo_cat_id_int = (int)$product_category;
              $terms_link = get_term_link($woo_cat_id_int,'product_cat');
              ?>
              <a href="<?php echo esc_url( $terms_link ); ?>">
                <div class="feature-cat-image">
                  <?php 
                  $thumbnail_id = get_woocommerce_term_meta($product_category, 'thumbnail_id', true);
                  if (!empty($thumbnail_id)) {
                    $image = wp_get_attachment_image_src($thumbnail_id, 'prod-cat-size');
                    echo '<img src="' . esc_url($image[0]) . '" alt="'.esc_attr__('Category Image','eightstore-lite').'"  />';
                  }
                  else{ 
                    ?>
                    <img src="<?php echo get_template_directory_uri().'../images/dummy-cat.jpg'?>"/>
                    <?php 
                  } ?>
                  <div class="product-cat-desc">
                    <?php 
                    $taxonomy = 'product_cat';
                    $terms = term_description( $product_category, $taxonomy );
                    $terms_name = get_term( $product_category, $taxonomy );
                    ?>
                    <h3><?php echo $terms_name->name ?></h3>
                    <div class="cat_desc">  
                      <?php echo $terms; ?>   
                    </div>  
                  </div>
                </div>
              </a>
              <ul class="feature-cat-product">
                <?php 
                $prod_args = array(
                  'post_type' => 'product',
                  'tax_query' => array(array('taxonomy'  => 'product_cat',
                    'field'     => 'id', 
                    'terms'     => $product_category                                                                 
                    )),
                  'posts_per_page' => '6'
                  );
                $product_query = new WP_Query($prod_args);
                if($product_query->have_posts()):
                  $count = 1;
                while($product_query->have_posts()):$product_query->the_post();
                $image_id = get_post_thumbnail_id();
                $image = wp_get_attachment_image_src($image_id, 'thumbnail', 'true');
                ?>
                <?php woocommerce_get_template_part( 'content', 'product' ); ?>
                <?php
                $count+=0.5;
                endwhile;
                endif;
                ?>
              </ul>
            </div>
            <?php
            echo $after_widget;
            ?>
          </div>
        </section>
        <?php
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
  endif;