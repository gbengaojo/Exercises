<?php

class CFMViewUninstall_cfm {
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
    global $wpdb;
    $prefix = $wpdb->prefix;
    ?>
    <form method="post" action="admin.php?page=uninstall_cfm" style="width:95%;">
      <?php wp_nonce_field('nonce_cfm', 'nonce_cfm'); ?>
      <div class="wrap">
        <span class="uninstall_icon"></span>
        <h2><?php echo __("Uninstall Contact Form Builder", "contact_form_maker"); ?></h2>
        <p>
          <?php echo __("Deactivating Contact Form Builder plugin does not remove any data that may have been created, such as the Forms and the Submissions. To completely remove this plugin, you can uninstall it here", "contact_form_maker"); ?>.
        </p>
        <p style="color: red;">
          <strong><?php echo __("WARNING", "contact_form_maker"); ?>:</strong>
          <?php echo __("Once uninstalled, this cannot be undone. You should use a Database Backup plugin of WordPress to back up all the data first", "contact_form_maker"); ?>.
        </p>
        <p style="color: red">
          <strong><?php echo __("The following WordPress Options/Tables will be DELETED", "contact_form_maker"); ?>:</strong>
        </p>
        <table class="widefat">
          <thead>
            <tr>
              <th><?php echo __("Database Tables", "contact_form_maker"); ?></th>
            </tr>
          </thead>
          <tr>
            <td valign="top">
              <ol>
                <li><?php echo $prefix; ?>contactformmaker</li>
                <li><?php echo $prefix; ?>contactformmaker_submits</li>
                <li><?php echo $prefix; ?>contactformmaker_themes</li>
                <li><?php echo $prefix; ?>contactformmaker_views</li>
                <li><?php echo $prefix; ?>contactformmaker_blocked</li>
              </ol>
            </td>
          </tr>
        </table>
        <p style="text-align: center;">
          <?php echo __("Do you really want to uninstall Conatct Form Builder", "contact_form_maker"); ?>?
        </p>
        <p style="text-align: center;">
          <input type="checkbox" name="Contact Form Builder" id="check_yes" value="yes" />&nbsp;<label for="check_yes"><?php echo __("Yes", "contact_form_maker"); ?></label>
        </p>
        <p style="text-align: center;">
          <input type="submit" value="<?php echo __("UNINSTALL", "contact_form_maker"); ?>" class="button-primary" onclick="if (check_yes.checked) { 
                                                                                    if (confirm('<?php echo addslashes(__('You are About to Uninstall Contact Form Builder from WordPress.\nThis Action Is Not Reversible.', 'contact_form_maker')); ?>')) {
                                                                                        spider_set_input_value('task', 'uninstall');
                                                                                    } else {
                                                                                        return false;
                                                                                    }
                                                                                  }
                                                                                  else {
                                                                                    return false;
                                                                                  }" />
        </p>
      </div>
      <input id="task" name="task" type="hidden" value="" />
    </form>
    <?php
  }

  public function uninstall() {
    $this->model->delete_db_tables();
    global $wpdb;
    $prefix = $wpdb->prefix;
    $deactivate_url = add_query_arg(array('action' => 'deactivate', 'plugin' => 'contact-form-builder/contact-form-builder.php'), admin_url('plugins.php'));
    $deactivate_url = wp_nonce_url($deactivate_url, 'deactivate-plugin_contact-form-builder/contact-form-builder.php');
    ?>
    <div id="message" class="updated fade">
      <p><?php echo __("The following Database Tables succesfully deleted", "contact_form_maker"); ?>:</p>
      <p><?php echo $prefix; ?>contactformmaker,</p>
      <p><?php echo $prefix; ?>contactformmaker_submits,</p>
      <p><?php echo $prefix; ?>contactformmaker_themes,</p>
      <p><?php echo $prefix; ?>contactformmaker_views,</p>
      <p><?php echo $prefix; ?>contactformmaker_blocked.</p>
    </div>
    <div class="wrap">
      <h2><?php echo __("Uninstall Conact Form Builder", "contact_form_maker"); ?></h2>
      <p><strong><a href="<?php echo $deactivate_url; ?>"><?php echo __("Click Here", "contact_form_maker"); ?></a> <?php echo __("To Finish the Uninstallation and Contact Form Builder will be Deactivated Automatically", "contact_form_maker"); ?>.</strong></p>
      <input id="task" name="task" type="hidden" value="" />
    </div>
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