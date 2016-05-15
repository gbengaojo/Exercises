<?php

class CFMViewWidget {
  ////////////////////////////////////////////////////////////////////////////////////////
  // Events                                                                             //
  ////////////////////////////////////////////////////////////////////////////////////////
  ////////////////////////////////////////////////////////////////////////////////////////
  // Constants                                                                          //
  ////////////////////////////////////////////////////////////////////////////////////////
  ////////////////////////////////////////////////////////////////////////////////////////
  // Variables                                                                          //
  ////////////////////////////////////////////////////////////////////////////////////////
  private $model;

  ////////////////////////////////////////////////////////////////////////////////////////
  // Constructor & Destructor                                                           //
  ////////////////////////////////////////////////////////////////////////////////////////
  public function __construct($model) {
    $this->model = $model;
  }
  ////////////////////////////////////////////////////////////////////////////////////////
  // Public Methods                                                                     //
  ////////////////////////////////////////////////////////////////////////////////////////

  public function display() {
  }

  function widget($args, $instance) {
    extract($args);
    $title = $instance['title'];
    $form_id = (isset($instance['form_id']) ? $instance['form_id'] : 0);
    // Before widget.
    echo $before_widget;
    // Title of widget.
    if ($title) {
      echo $before_title . $title . $after_title;
    }
    // Widget output.
    require_once(WD_CFM_DIR . '/frontend/controllers/CFMControllerForm_maker.php');
    $controller_class = 'CFMControllerForm_maker';
    $controller = new $controller_class();
    echo $controller->execute($instance['form_id']);
    // After widget.
    echo $after_widget;
  }

  // Widget Control Panel.
  function form($instance, $id_title, $name_title, $id_form_id, $name_form_id) {
     $defaults = array(
      'title' => '',
      'form_id' => 0
    );
    $instance = wp_parse_args((array)$instance, $defaults);
    global $wpdb;
    $ids_Form_Maker = $this->model->get_gallery_rows_data();
    ?>
    <p>
      <label for="<?php echo $id_title; ?>"><?php echo __("Title", "contact_form_maker"); ?>:</label>
      <input class="widefat" id="<?php echo $id_title; ?>" name="<?php echo $name_title; ?>" type="text" value="<?php echo $instance['title']; ?>" />
      <label for="<?php echo $id_form_id; ?>"><?php echo __("Select a form", "contact_form_maker"); ?>:</label>
      <select name="<?php echo $name_form_id; ?>" id="<?php echo $id_form_id; ?>" style="width: 225px; text-align: left;">
        <option value="0">- <?php echo __("Select a Form", "contact_form_maker"); ?>-</option>
        <?php
        foreach ($ids_Form_Maker as $arr_Form_Maker) {
          ?>
        <option value="<?php echo $arr_Form_Maker->id; ?>" <?php echo ($arr_Form_Maker->id == $instance['form_id']) ? 'SELECTED' : ''; ?>><?php echo $arr_Form_Maker->title; ?></option>
          <?php
        }
        ?>
      </select>
    </p>
    <?php
  }

  ////////////////////////////////////////////////////////////////////////////////////////
  // Getters & Setters                                                                  //
  ////////////////////////////////////////////////////////////////////////////////////////
  ////////////////////////////////////////////////////////////////////////////////////////
  // Private Methods                                                                    //
  ////////////////////////////////////////////////////////////////////////////////////////
  ////////////////////////////////////////////////////////////////////////////////////////
  // Listeners                                                                          //
  ////////////////////////////////////////////////////////////////////////////////////////
}