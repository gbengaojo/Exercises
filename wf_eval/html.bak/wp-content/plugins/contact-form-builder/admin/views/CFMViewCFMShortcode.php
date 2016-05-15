<?php

class CFMViewCFMShortcode {
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
    $rows = $this->model->get_form_data();
    ?>
    <html xmlns="http://www.w3.org/1999/xhtml">
      <head>
        <title>Contact Form Builder</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <script language="javascript" type="text/javascript" src="<?php echo site_url(); ?>/wp-includes/js/tinymce/tiny_mce_popup.js"></script>
        <script language="javascript" type="text/javascript" src="<?php echo site_url(); ?>/wp-includes/js/tinymce/utils/mctabs.js"></script>
        <script language="javascript" type="text/javascript" src="<?php echo site_url(); ?>/wp-includes/js/tinymce/utils/form_utils.js"></script>

        <?php
        wp_print_scripts('jquery');
        ?>
        <base target="_self">
      </head>
      <body id="link" onLoad="tinyMCEPopup.executeOnLoad('init();');document.body.style.display='';" dir="ltr" class="forceColors">
        <div class="tabs" role="tablist" tabindex="-1">
          <ul>
            <li id="display_tab" class="current" role="tab" tabindex="0">
              <span>
                <a href="javascript:mcTabs.displayTab('display_tab','display_panel');" onMouseDown="return false;" tabindex="-1">Contact Form Builder</a>
              </span>
            </li>
          </ul>
        </div>
        <style>
          .panel_wrapper {
            height: 170px !important;
          }
        </style>
        <div class="panel_wrapper">
          <div id="display_panel" class="panel current">
            <table>
              <tr>
                <td style="vertical-align: middle; text-align: left;"><?php echo __("Select a Form", "contact_form_maker"); ?></td>
                <td style="vertical-align: middle; text-align: left;">
                  <select name="form_maker_id" id="form_maker_id" style="width: 230px; text-align: left;">
                    <option value="- Select Form -" selected="selected">-<?php echo __("Select a Form", "contact_form_maker"); ?>-</option>
                    <?php
                    foreach ($rows as $row) {
                      ?>
                    <option value="<?php echo $row->id; ?>"><?php echo $row->title; ?></option>
                      <?php
                    }
                    ?>
                  </select>
                </td>
              </tr>
            </table>
          </div>
        </div>
        <div class="mceActionPanel">
          <div style="float: left;">
            <input type="button" id="cancel" name="cancel" value="<?php echo __('Cancel', 'contact_form_maker'); ?>" onClick="tinyMCEPopup.close();"/>
          </div>
          <div style="float: right;">
            <input type="submit" id="insert" name="insert" value="<?php echo __('Insert', 'contact_form_maker'); ?>" onClick="form_maker_insert_shortcode();"/>
          </div>
        </div>
        <script type="text/javascript">
          function form_maker_insert_shortcode() {
            if (document.getElementById('form_maker_id').value == '- Select Form -') {
              tinyMCEPopup.close();
            }
            else {
              var tagtext;
              tagtext = '[Contact_Form_Builder id="' + document.getElementById('form_maker_id').value + '"]';
              window.tinyMCE.execCommand('mceInsertContent', false, tagtext);
              tinyMCEPopup.close();
            }
          }
        </script>
      </body>
    </html>
    <?php
    die();
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