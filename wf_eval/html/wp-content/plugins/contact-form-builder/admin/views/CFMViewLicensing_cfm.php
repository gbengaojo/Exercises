<?php

class CFMViewLicensing_cfm {
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
    ?>
    <div style="text-align:center; float: left;">
      <table class="data-bordered">
        <thead>
          <tr>
            <th class="top first" nowrap="nowrap" scope="col"><?php echo __("Features of the Contact form builder","contact_form_maker"); ?></th>
            <th class="top notranslate" nowrap="nowrap" scope="col"><?php echo __("Free","contact_form_maker"); ?></th>
            <th class="top notranslate" nowrap="nowrap" scope="col"><?php echo __("Pro Version","contact_form_maker"); ?></th>
          </tr>
        </thead>
        <tbody>
          <tr class="alt">
            <td><?php echo __("Responsive design and layout","contact_form_maker"); ?></td>
            <td class="icon-replace yes"><?php echo __("yes","contact_form_maker"); ?></td>
            <td class="icon-replace yes"><?php echo __("yes","contact_form_maker"); ?></td>
          </tr>
          <tr>
            <td><?php echo __("Email Options","contact_form_maker"); ?></td>
            <td class="icon-replace yes"><?php echo __("yes","contact_form_maker"); ?></td>
            <td class="icon-replace yes"><?php echo __("yes","contact_form_maker"); ?></td>
          </tr>
          <tr class="alt">
            <td><?php echo __("Customizable labels and attributes","contact_form_maker"); ?></td>
            <td class="icon-replace yes"><?php echo __("yes","contact_form_maker"); ?></td>
            <td class="icon-replace yes"><?php echo __("yes","contact_form_maker"); ?></td>
          </tr>
          <tr>
            <td><?php echo __("Custom HTML field","contact_form_maker"); ?></td>
            <td class="icon-replace yes"><?php echo __("yes","contact_form_maker"); ?></td>
            <td class="icon-replace yes"><?php echo __("yes","contact_form_maker"); ?></td>
          </tr>
          <tr class="alt">
            <td><?php echo __("Possibility to send a copy of message to user","contact_form_maker"); ?></td>
            <td class="icon-replace yes"><?php echo __("yes","contact_form_maker"); ?></td>
            <td class="icon-replace yes"><?php echo __("yes","contact_form_maker"); ?></td>
          </tr>
          <tr>
            <td><?php echo __("Activation/deactivation of fields","contact_form_maker"); ?></td>
            <td class="icon-replace yes"><?php echo __("yes","contact_form_maker"); ?></td>
            <td class="icon-replace yes"><?php echo __("yes","contact_form_maker"); ?></td>
          </tr>
          <tr class="alt">
            <td><?php echo __("Customizable form layout","contact_form_maker"); ?></td>
            <td class="icon-replace yes"><?php echo __("yes","contact_form_maker"); ?></td>
            <td class="icon-replace yes"><?php echo __("yes","contact_form_maker"); ?></td>
          </tr>
          <tr>
            <td><?php echo __("Captcha/Repatcha protection","contact_form_maker"); ?></td>
            <td class="icon-replace yes"><?php echo __("yes","contact_form_maker"); ?></td>
            <td class="icon-replace yes"><?php echo __("yes","contact_form_maker"); ?></td>
          </tr>
          <tr class="alt">
            <td><?php echo __("Blocking IPs","contact_form_maker"); ?></td>
            <td class="icon-replace yes"><?php echo __("yes","contact_form_maker"); ?></td>
            <td class="icon-replace yes"><?php echo __("yes","contact_form_maker"); ?></td>
          </tr>
          <tr>
            <td><?php echo __("Sample Forms","contact_form_maker"); ?></td>
            <td style="text-align:center;">10</td>
            <td style="text-align:center;">10</td>
          </tr>
          <tr class="alt">
            <td><?php echo __("Possibility to create new forms based on the samples","contact_form_maker"); ?></td>
            <td class="icon-replace yes"><?php echo __("yes","contact_form_maker"); ?></td>
            <td class="icon-replace yes"><?php echo __("yes","contact_form_maker"); ?></td>
          </tr>
          <tr>
            <td><?php echo __("Google Map Integration","contact_form_maker"); ?></td>
            <td class="icon-replace yes"><?php echo __("yes","contact_form_maker"); ?></td>
            <td class="icon-replace yes"><?php echo __("yes","contact_form_maker"); ?></td>
          </tr>
          <tr class="alt">
            <td><?php echo __("Themes","contact_form_maker"); ?></td>
            <td class="icon-replace yes">1</td>
            <td class="icon-replace yes">37</td>
          </tr>
          <tr class="alt">
            <td><?php echo __("Possibility to add themes","contact_form_maker"); ?></td>
            <td class="icon-replace no"><?php echo __("no","contact_form_maker"); ?></td>
            <td class="icon-replace yes"><?php echo __("yes","contact_form_maker"); ?></td>
          </tr>
          <tr>
            <td><?php echo __("Submissions page","contact_form_maker"); ?></td>
            <td class="icon-replace no"><?php echo __("no","contact_form_maker"); ?></td>
            <td class="icon-replace yes"><?php echo __("yes","contact_form_maker"); ?></td>
          </tr>
          <tr class="alt">
            <td><?php echo __("Statistical Data","contact_form_maker"); ?></td>
            <td class="icon-replace no"><?php echo __("no","contact_form_maker"); ?></td>
            <td class="icon-replace yes"><?php echo __("yes","contact_form_maker"); ?></td>
          </tr>
          <tr>
            <td><?php echo __("Data Import in CSV/XML","contact_form_maker"); ?></td>
            <td class="icon-replace no"><?php echo __("no","contact_form_maker"); ?></td>
            <td class="icon-replace yes"><?php echo __("yes","contact_form_maker"); ?></td>
          </tr>
        </tbody>
      </table>
    </div>
    <div class="fm-upgrade-pro">
			<a target="_blank" href="http://web-dorado.com/files/fromContactFormBuilder.php">
				<div class="fm-upgrade-img">
					UPGRADE TO PRO VERSION 
					<span></span>
				</div>
			</a>
		 </div>
    <div style="float: left; clear: both;">
      <p><?php echo __("After the purchasing the commercial version follow this steps:","contact_form_maker"); ?></p>
      <ol>
        <li><?php echo __("Deactivate Contact Form Builder Plugin.","contact_form_maker"); ?></li>
        <li><?php echo __("Delete Contact Form Builder Plugin.","contact_form_maker"); ?></li>
        <li><?php echo __("Install the downloaded commercial version of the plugin.","contact_form_maker"); ?></li>
      </ol>
      <br/>
      <p><?php echo __("If you enjoy using Contact Form Builder and find it useful, please consider making a donation. Your donation will help encourage and support the plugin's continued development and better user support.","contact_form_maker"); ?></p>
      <br/>
       <a href="https://web-dorado.com/files/donate_redirect.php" target="_blank">
	       <div class="fm-get-pro"></div>
	    </a>
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