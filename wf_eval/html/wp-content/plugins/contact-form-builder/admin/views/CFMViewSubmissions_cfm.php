<?php

class CFMViewSubmissions_cfm {
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
  public function display($form_id) {
    ?>
    <div class="fm-user-manual">
      <br />
      <?php echo __("This section allows you to view form submissions.", "contact_form_maker"); ?>
      <a style="color: blue; text-decoration: none;" target="_blank" href="http://web-dorado.com/wordpress-contact-form-builder-guide-7.html"><?php echo __("Read More in User Manual","contact_form_maker"); ?></a><br /><br />
      <span style="color: #FF0000;"><?php echo __("This feature is disabled for the non-commercial version.","contact_form_maker"); ?></span>
    </div>
    <div class="fm-upgrade-pro">
			<a target="_blank" href="http://web-dorado.com/files/fromContactFormBuilder.php">
				<div class="fm-upgrade-img">
					<?php echo __("UPGRADE TO PRO VERSION","contact_form_maker"); ?>
					<span></span>
				</div>
			</a>
		 </div>
     <div style="clear:both;">
      <img style="max-width: 100%;" src="<?php echo WD_CFM_URL . '/images/screenshots/sub.png'; ?>" />
    </div>
    <?php
  }
}

?>
