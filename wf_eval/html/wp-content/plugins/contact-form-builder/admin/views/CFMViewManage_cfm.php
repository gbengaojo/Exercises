<?php

class CFMViewManage_cfm {
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
    $rows_data = $this->model->get_rows_data();
    $page_nav = $this->model->page_nav();
    $search_value = ((isset($_POST['search_value'])) ? esc_html($_POST['search_value']) : '');
    $search_select_value = ((isset($_POST['search_select_value'])) ? (int) $_POST['search_select_value'] : 0);
    $asc_or_desc = ((isset($_POST['asc_or_desc'])) ? esc_html($_POST['asc_or_desc']) : 'asc');
    $order_by = (isset($_POST['order_by']) ? esc_html($_POST['order_by']) : 'id');
    $order_class = 'manage-column column-title sorted ' . $asc_or_desc;
    $ids_string = '';
    ?>
      <div class="fm-user-manual">
			<?php echo __("This section allows you to edit forms", "contact_form_maker"); ?>.
			<a style="color: blue; text-decoration: none;" target="_blank" href="http://web-dorado.com/wordpress-contact-form-builder-guide-2.html"><?php echo __("Read More in User Manual","contact_form_maker"); ?></a>
      <p><?php echo __("There is no possibility of adding new form fields, whereas you can edit, enable/disable the current fields included in each form","contact_form_maker"); ?>.</p>
		</div>
    <div class="fm-upgrade-pro">
			<a target="_blank" href="http://web-dorado.com/files/fromContactFormBuilder.php">
				<div class="fm-upgrade-img">
					UPGRADE TO PRO VERSION 
					<span></span>
				</div>
			</a>
		</div>
		<div class="fm-clear"></div>
    <form onkeypress="spider_doNothing(event)" class="wrap" id="manage_form" method="post" action="admin.php?page=manage_cfm" >
      <?php wp_nonce_field('nonce_cfm', 'nonce_cfm'); ?>
      <div class="fm-page-banner">
				<div class="fm-logo">
				</div>
				<div class="fm-logo-title">Contact</br>Form Builder</div>
			</div>
      <div class="tablenav top">
        <?php
        WDW_CFM_Library::search(__("Title", "contact_form_maker"), $search_value, 'manage_form');
        WDW_CFM_Library::html_page_nav($page_nav['total'], $page_nav['limit'], 'manage_form');
        ?>
      </div>
      <table class="wp-list-table widefat fixed pages">
        <thead>
          <th class="manage-column column-cb check-column table_small_col"><input id="check_all" type="checkbox" style="margin:0;"/></th>
          <th class="table_small_col <?php if ($order_by == 'id') { echo $order_class; } ?>">
            <a onclick="spider_set_input_value('task', '');
              spider_set_input_value('order_by', 'id');
              spider_set_input_value('asc_or_desc', '<?php echo ((isset($_POST['asc_or_desc']) && isset($_POST['order_by']) && (esc_html($_POST['order_by']) == 'id') && esc_html($_POST['asc_or_desc']) == 'asc') ? 'desc' : 'asc'); ?>');
              spider_form_submit(event, 'manage_form')" href="">
              <span>ID</span><span class="sorting-indicator"></span></a>
          </th>
          <th class="<?php if ($order_by == 'title') { echo $order_class; } ?>">
            <a onclick="spider_set_input_value('task', '');
              spider_set_input_value('order_by', 'title');
              spider_set_input_value('asc_or_desc', '<?php echo ((isset($_POST['asc_or_desc']) && isset($_POST['order_by']) && (esc_html($_POST['order_by']) == 'title') && esc_html($_POST['asc_or_desc']) == 'asc') ? 'desc' : 'asc'); ?>');
              spider_form_submit(event, 'manage_form')" href="">
              <span><?php echo __("Title", "contact_form_maker"); ?></span><span class="sorting-indicator"></span></a>
          </th>
          <th class="<?php if ($order_by == 'mail') { echo $order_class; } ?>">
            <a onclick="spider_set_input_value('task', '');
              spider_set_input_value('order_by', 'mail');
              spider_set_input_value('asc_or_desc', '<?php echo ((isset($_POST['asc_or_desc']) && isset($_POST['order_by']) && (esc_html($_POST['order_by']) == 'mail') && esc_html($_POST['asc_or_desc']) == 'asc') ? 'desc' : 'asc'); ?>');
              spider_form_submit(event, 'manage_form')" href="">
              <span><?php echo __("Email to send submissions to", "contact_form_maker"); ?></span><span class="sorting-indicator"></span></a>
          </th>
          <th class="table_xxl_col"><?php echo __("Shortcode", "contact_form_maker"); ?></th>
          <th class="table_xxl_col">PHP <?php echo __("function", "contact_form_maker"); ?></th>
          <th class="table_medium_col"><?php echo __("Preview", "contact_form_maker"); ?></th>
          <th class="table_medium_col"><?php echo __("Edit", "contact_form_maker"); ?></th>
          <th class="table_medium_col"><a title="<?php echo __("Delete selected items", "contact_form_maker"); ?>" href="" onclick="if (confirm('<?php echo addslashes(__("Do you want to delete selected items?", "contact_form_maker")); ?>')) {
                                                       spider_set_input_value('task', 'delete_all');
                                                       spider_form_submit(event, 'manage_form');
                                                     } else {
                                                       return false;
                                                     }"><?php echo __("Delete", "contact_form_maker"); ?></a></th>
        </thead>
        <tbody id="tbody_arr">
          <?php
          if ($rows_data) {
            foreach ($rows_data as $row_data) {
              $alternate = (!isset($alternate) || $alternate == 'class="alternate"') ? '' : 'class="alternate"';
              $old = '';
              if (isset($row_data->form) && ($row_data->form != '')) {
                $old = '_old';
              }
              ?>
              <tr id="tr_<?php echo $row_data->id; ?>" <?php echo $alternate; ?>>
                <td class="table_small_col check-column">
                  <input id="check_<?php echo $row_data->id; ?>" name="check_<?php echo $row_data->id; ?>" type="checkbox"/>
                </td>
                <td class="table_small_col"><?php echo $row_data->id; ?></td>
                <td>
                  <a onclick="spider_set_input_value('task', 'edit<?php echo $old; ?>');
                              spider_set_input_value('current_id', '<?php echo $row_data->id; ?>');
                              spider_form_submit(event, 'manage_form')" href="" title="<?php echo __("Edit", "contact_form_maker"); ?>"><?php echo $row_data->title; ?></a>
                </td>
                <td><?php echo $row_data->mail; ?></td>
                <td class="table_big_col">
                  <input type="text" value='[Contact_Form_Builder id="<?php echo $row_data->id; ?>"]' onclick="spider_select_value(this)" readonly="readonly" style="padding-left: 1px; padding-right: 1px;"/>
                </td>
                <td class="table_large_col">
                 <input type="text" value='&#60;?php wd_contact_form_builder(<?php echo $row_data->id; ?>); ?&#62;' onclick="spider_select_value(this)"  readonly="readonly" style="padding-left: 1px; padding-right: 1px;"/>
                </td>
                <td class="table_medium_col">
                  <button class="fm-icon preview-icon" title="<?php echo __("Form Preview", "contact_form_maker"); ?>" onclick="tb_show('', '<?php echo add_query_arg(array('action' => 'ContactFormMakerPreview', 'form_id' => $row_data->id, 'test_theme' => $row_data->theme, 'width' => '1000', 'height' => '500', 'TB_iframe' => '1'), admin_url('admin-ajax.php')); ?>'); return false;">
                    <span></span>
						      </button>
                </td>
                <td class="table_small_col">
									<button onclick="spider_set_input_value('task', 'edit<?php echo $old; ?>');
                                   spider_set_input_value('current_id', '<?php echo $row_data->id; ?>');
                                   spider_form_submit(event, 'manage_form')" class="fm-icon edit-icon" title="<?php echo __("Edit the form", "contact_form_maker"); ?>">
										<span></span>
									</button>
								</td>
                <td class="table_small_col">
									<button onclick="spider_set_input_value('task', 'delete');
                                   spider_set_input_value('current_id', '<?php echo $row_data->id; ?>');
                                   spider_form_submit(event, 'manage_form')" class="fm-icon delete-icon" title="<?php echo __("Delete the form", "contact_form_maker"); ?>">
										<span></span>
									</button>
								</td>
              </tr>
              <?php
              $ids_string .= $row_data->id . ',';
            }
          }
          ?>
        </tbody>
      </table>
      <input id="task" name="task" type="hidden" value=""/>
      <input id="current_id" name="current_id" type="hidden" value=""/>
      <input id="ids_string" name="ids_string" type="hidden" value="<?php echo $ids_string; ?>"/>
      <input id="asc_or_desc" name="asc_or_desc" type="hidden" value="asc"/>
      <input id="order_by" name="order_by" type="hidden" value="<?php echo $order_by; ?>"/>
    </form>
    <?php
  }

  public function edit($id) {
    $row = $this->model->get_row_data($id);
    $themes = $this->model->get_theme_rows_data();
    $labels = array();
    $label_id = array();
    $label_order_original = array();
    $label_type = array();
    $label_all = explode('#****#', $row->label_order);
    $label_all = array_slice($label_all, 0, count($label_all) - 1);
    foreach ($label_all as $key => $label_each) {
      $label_id_each = explode('#**id**#', $label_each);
      array_push($label_id, $label_id_each[0]);
      $label_oder_each = explode('#**label**#', $label_id_each[1]);
      array_push($label_order_original, addslashes($label_oder_each[0]));
      array_push($label_type, $label_oder_each[1]);
    }
    $labels['id'] = '"' . implode('","', $label_id) . '"';
    $labels['label'] = '"' . implode('","', $label_order_original) . '"';
    $labels['type'] = '"' . implode('","', $label_type) . '"';
    $page_title = (($id != 0) ? __('Edit form ', 'contact_form_maker') . $row->title : __('Create new form', 'contact_form_maker'));
    ?>
    <script type="text/javascript">
      var contact_form_maker_plugin_url = "<?php echo WD_CFM_URL; ?>";
      form_view = 1;
      form_view_count = 1;
      form_view_max = 1;
      function set_preview() {
        jQuery("#preview_form").attr("onclick", "tb_show('', '<?php echo add_query_arg(array('action' => 'ContactFormMakerPreview', 'form_id' => $row->id), admin_url('admin-ajax.php')); ?>&test_theme=" + jQuery('#theme').val() + "&width=1000&height=500&TB_iframe=1'); return false;");
        jQuery("#edit_css").attr("onclick", "tb_show('', '<?php echo add_query_arg(array('action' => 'ContactFormMakerEditCSS', 'form_id' => $row->id), admin_url('admin-ajax.php')); ?>&id=" + jQuery('#theme').val() + "&width=800&height=500&TB_iframe=1'); return false;");
      }
      function submitbutton() {
        <?php
        if ($id) {
        ?>
        if (!document.getElementById('araqel') || (document.getElementById('araqel').value == '0')) {
          alert('<?php echo addslashes(__("Please wait while page loading", "contact_form_maker")); ?>.');
          return false;
        }
        <?php
        }
        ?>
        tox = '';
        form_fields = '';
        disabled_ids = '';
        l_id_array = [<?php echo $labels['id']?>];
        l_label_array = [<?php echo $labels['label']?>];
        l_type_array = [<?php echo $labels['type']?>];
        l_id_removed = [];      
        document.getElementById('take').style.display = "none";
        document.getElementById('saving').style.display = "block";
        remove_whitespace(document.getElementById('take'));
        for (x = 0; x < l_id_array.length; x++) {
          l_id_removed[l_id_array[x]] = true;
        }
        if (document.getElementById('form_id_tempform_view1')) {
          wdform_page = document.getElementById('form_id_tempform_view1');
          remove_whitespace(wdform_page);
          n = wdform_page.childNodes.length - 2;
          for (q = 0; q <= n; q++) {
            if (!wdform_page.childNodes[q].getAttribute("wdid")) {
              wdform_section = wdform_page.childNodes[q];
              for (x = 0; x < wdform_section.childNodes.length; x++) {
                wdform_column = wdform_section.childNodes[x];
                if (wdform_column.firstChild) {
                  for (y=0; y < wdform_column.childNodes.length; y++) {
                    is_in_old = false;
                    wdform_row = wdform_column.childNodes[y];
                    if (wdform_row.nodeType == 3) {
                      continue;
                    }
                    wdid = wdform_row.getAttribute("wdid");
                    if (!wdid) {
                      continue;
                    }
                    l_id = wdid;
                    l_label = document.getElementById(wdid + '_element_labelform_id_temp').innerHTML;
                    l_label = l_label.replace(/(\r\n|\n|\r)/gm," ");
                    // wdtype = wdform_row.firstChild.getAttribute('type');
                    wdtype = jQuery(wdform_row).find("div[id^=wdform_field]").eq(0).attr('type');
                    if (wdform_row.getAttribute("disabled")) {
                      if (wdtype != "type_address") {
                        disabled_ids += wdid + ',';
                      }
                      else {
                        disabled_ids += wdid + ',' + (parseInt(wdid)+1) + ','+(parseInt(wdid)+2)+ ',' +(parseInt(wdid)+3)+ ',' +(parseInt(wdid)+4)+ ','+(parseInt(wdid)+5) + ',';
                      }
                    }
                    for (z = 0; z < l_id_array.length; z++) {
                      if (l_id_array[z] == wdid) {
                        if (l_type_array[z] == "type_address") {
                          if (document.getElementById(l_id + "_mini_label_street1")) {
                            l_id_removed[l_id_array[z]] = false;
                          }
                          if (document.getElementById(l_id + "_mini_label_street2")) {
                            l_id_removed[parseInt(l_id_array[z]) + 1] = false;
                          }
                          if (document.getElementById(l_id + "_mini_label_city")) {
                            l_id_removed[parseInt(l_id_array[z]) + 2] = false;	
                          }
                          if (document.getElementById(l_id + "_mini_label_state")) {
                            l_id_removed[parseInt(l_id_array[z]) + 3] = false;
                          }
                          if (document.getElementById(l_id+"_mini_label_postal")) {
                            l_id_removed[parseInt(l_id_array[z]) + 4] = false;
                          }
                          if (document.getElementById(l_id+"_mini_label_country")) {
                            l_id_removed[parseInt(l_id_array[z]) + 5] = false;
                          }
                          z = z + 5;
                        }
                        else {
                          l_id_removed[l_id] = false;
                        }
                      }
                    }
                    if (wdtype == "type_address") {
                      addr_id = parseInt(wdid);
                      id_for_country = addr_id;
                      if (document.getElementById(id_for_country + "_mini_label_street1"))
                        tox = tox + addr_id + '#**id**#' + document.getElementById(id_for_country + "_mini_label_street1").innerHTML + '#**label**#type_address#****#';
                      addr_id++;
                      if (document.getElementById(id_for_country + "_mini_label_street2"))
                        tox = tox + addr_id + '#**id**#' + document.getElementById(id_for_country + "_mini_label_street2").innerHTML + '#**label**#type_address#****#';
                      addr_id++;
                      if (document.getElementById(id_for_country+"_mini_label_city"))
                        tox = tox + addr_id + '#**id**#' + document.getElementById(id_for_country + "_mini_label_city").innerHTML + '#**label**#type_address#****#';
                      addr_id++;
                      if (document.getElementById(id_for_country + "_mini_label_state"))
                        tox = tox + addr_id + '#**id**#' + document.getElementById(id_for_country + "_mini_label_state").innerHTML + '#**label**#type_address#****#';
                      addr_id++;
                      if (document.getElementById(id_for_country + "_mini_label_postal"))
                        tox = tox + addr_id + '#**id**#' + document.getElementById(id_for_country + "_mini_label_postal").innerHTML + '#**label**#type_address#****#';
                      addr_id++;
                      if (document.getElementById(id_for_country+"_mini_label_country")) {
                        tox=tox + addr_id + '#**id**#' + document.getElementById(id_for_country + "_mini_label_country").innerHTML + '#**label**#type_address#****#';
                      }
                    }
                    else {
                      tox = tox + wdid + '#**id**#' + l_label + '#**label**#' + wdtype + '#****#';
                    }
                    id = wdid;
                    form_fields += wdid + "*:*id*:*";
                    form_fields += wdtype + "*:*type*:*";
                    w_choices = new Array();
                    w_choices_checked = new Array();
                    w_choices_disabled = new Array();
                    w_allow_other_num = 0;
                    w_property = new Array();
                    w_property_type = new Array();
                    w_property_values = new Array();
                    w_choices_price = new Array();
                    if (document.getElementById(id+'_element_labelform_id_temp').innerHTML) {
                      w_field_label = document.getElementById(id + '_element_labelform_id_temp').innerHTML.replace(/(\r\n|\n|\r)/gm," ");
                    }
                    else {
                      w_field_label = " ";
                    }
                    if (document.getElementById(id + '_label_sectionform_id_temp')) {
                      if (document.getElementById(id + '_label_sectionform_id_temp').style.display == "block") {
                        w_field_label_pos = "top";
                      }
                      else {
                        w_field_label_pos = "left";
                      }
                    }
                    if (document.getElementById(id + "_elementform_id_temp")) {
                      s = document.getElementById(id + "_elementform_id_temp").style.width;
                      w_size=s.substring(0,s.length - 2);
                    }
                    if (document.getElementById(id + "_label_sectionform_id_temp")) {
                      s = document.getElementById(id + "_label_sectionform_id_temp").style.width;
                      w_field_label_size = s.substring(0, s.length - 2);
                    }
                    if (document.getElementById(id + "_requiredform_id_temp")) {
                      w_required = document.getElementById(id + "_requiredform_id_temp").value;
                    }
                    if (document.getElementById(id + "_uniqueform_id_temp")) {
                      w_unique = document.getElementById(id + "_uniqueform_id_temp").value;
                    }
                    if (document.getElementById(id + '_label_sectionform_id_temp')) {
                      w_class = document.getElementById(id + '_label_sectionform_id_temp').getAttribute("class");
                      if (!w_class) {
                        w_class = "";
                      }
                    }
                    gen_form_fields();
                    wdform_row.innerHTML = "%" + id + " - " + l_label + "%";
                  }
                }
              }
            }
            else {
              id = wdform_page.childNodes[q].getAttribute("wdid");
              if (wdform_page.childNodes[q].getAttribute("disabled")) {
                disabled_ids += id + ',';
              }
              w_editor = document.getElementById(id + "_element_sectionform_id_temp").innerHTML;
              form_fields += id + "*:*id*:*";
              form_fields += "type_section_break" + "*:*type*:*";
              form_fields += "custom_" + id + "*:*w_field_label*:*";
              form_fields += w_editor + "*:*w_editor*:*";
              form_fields += "*:*new_field*:*";
              wdform_page.childNodes[q].innerHTML = "%" + id + " - " + "custom_" + id + "%";
            }
          }
        }
        document.getElementById('disabled_fields').value = disabled_ids;
        document.getElementById('label_order_current').value = tox;
        for (x = 0; x < l_id_array.length; x++) {
          if (l_id_removed[l_id_array[x]]) {
            tox = tox + l_id_array[x] + '#**id**#' + l_label_array[x] + '#**label**#' + l_type_array[x] + '#****#';
          }
        }
        document.getElementById('label_order').value = tox;
        document.getElementById('form_fields').value = form_fields;
        refresh_();
        return true;
      }

      gen = <?php echo (($id != 0) ? $row->counter : 1); ?>;

      function enable() {
        if (document.getElementById('formMakerDiv').style.display == 'block') {
          jQuery('#formMakerDiv').slideToggle(200);}else{jQuery('#formMakerDiv').slideToggle(400);
        }
        if (document.getElementById('formMakerDiv').offsetWidth) {
          document.getElementById('formMakerDiv1').style.width = (document.getElementById('formMakerDiv').offsetWidth - 60) + 'px';
        }
        if (document.getElementById('formMakerDiv1').style.display == 'block') {
          jQuery('#formMakerDiv1').slideToggle(200);
        }
        else {
          jQuery('#formMakerDiv1').slideToggle(400);
        }
      }
      function enable2() {
        if (document.getElementById('formMakerDiv').style.display == 'block') {
          jQuery('#formMakerDiv').slideToggle(200);
        }
        else {
          jQuery('#formMakerDiv').slideToggle(400);
        }
        if (document.getElementById('formMakerDiv').offsetWidth) {
          document.getElementById('formMakerDiv1').style.width = (document.getElementById('formMakerDiv').offsetWidth - 60) + 'px';
        }
        if (document.getElementById('formMakerDiv1').style.display == 'block') {
          jQuery('#formMakerDiv1').slideToggle(200);
        }
        else {
          jQuery('#formMakerDiv1').slideToggle(400);
        }
      }
    </script>
    <div class="fm-user-manual">
			<?php echo __("This section allows you to enable/disable fields in your form", "contact_form_maker"); ?>.
			<a style="color: blue; text-decoration: none;" target="_blank" href="http://web-dorado.com/wordpress-contact-form-builder-guide-4.html"><?php echo __("Read More in User Manual", "contact_form_maker"); ?></a>
		</div>
    <div class="fm-upgrade-pro">
			<a target="_blank" href="http://web-dorado.com/files/fromContactFormBuilder.php">
				<div class="fm-upgrade-img">
					UPGRADE TO PRO VERSION 
					<span></span>
				</div>
			</a>
		</div>
    <div class="fm-clear"></div>
    <form class="wrap" id="manage_form" method="post" action="admin.php?page=manage_cfm">
      <?php wp_nonce_field('nonce_cfm', 'nonce_cfm'); ?>
      <h2 class="fm-h2-message"></h2>
			<div class="fm-page-header">
				<div style="float: left;">
					<div class="fm-logo-edit-page"></div>
					<div class="fm-title-edit-page">Contact<br />Form Builder</div>
				</div>
        <div class="fm-page-actions">
          <button class="fm-button save-button small" type="submit" onclick="if (spider_check_required('title', 'Form title') || !submitbutton()) {return false;}; spider_set_input_value('task', 'save')">
            <span></span>
            <?php echo __("Save", "contact_form_maker"); ?>
          </button>
          <button class="fm-button apply-button small" type="submit" onclick="if (spider_check_required('title', 'Form title') || !submitbutton()) {return false;}; spider_set_input_value('task', 'apply');">
            <span></span>
            <?php echo __("Apply", "contact_form_maker"); ?>
          </button>
          <?php
          if ($id) {
            ?>
          <button class="fm-button save-as-copy-button medium" type="submit" onclick="if (spider_check_required('title', 'Form title') || !submitbutton()) {return false;}; spider_set_input_value('task', 'save_as_copy')">
            <span></span>
            <?php echo __("Save as Copy", "contact_form_maker"); ?>
          </button>
            <?php
          }
          ?>
          <button class="fm-button cancel-button small" type="submit" onclick="spider_set_input_value('task', 'cancel')">
            <span></span>
            <?php echo __("Cancel", "contact_form_maker"); ?>
          </button>
        </div>
        <div class="fm-clear"></div>
      </div>
      <div class="fm-theme-banner">
        <div class="fm-title">
          <span><?php echo __("Title", "contact_form_maker"); ?>:&nbsp;</span>
          <input id="title" name="title" value="<?php echo $row->title; ?>" />
        </div>
        <div class="fm-page-actions">
          <button class="fm-button form-options-button medium" type="submit" onclick="if (spider_check_required('title', 'Form title') || !submitbutton()) {return false;}; spider_set_input_value('task', 'form_options');">
            <span></span>
            <?php echo __("Form Options", "contact_form_maker"); ?>
          </button>
          <button class="fm-button form-layout-button medium" type="submit" onclick="if (spider_check_required('title', 'Form title') || !submitbutton()) {return false;}; spider_set_input_value('task', 'form_layout');">
          <span></span>
            <?php echo __("Form Layout", "contact_form_maker"); ?>
          </button>
        </div>
      </div>
			<div class="fm-clear"></div>
			<div class="fm-theme-banner">
				<div class="fm-theme" style="float:left;">
					
					<span><?php echo __("Theme", "contact_form_maker"); ?>:&nbsp;</span>
					<select id="theme" name="theme">
						<?php
						foreach ($themes as $theme) {
							?>
							<option value="<?php echo $theme->id; ?>" <?php echo (($theme->id == $row->theme) ? 'selected="selected"' : ''); ?> <?php echo (($theme->id != 4) ? 'disabled="disabled" title="This theme is disabled in free version."' : ''); ?>><?php echo $theme->title; ?></option>
							<?php
						}
						?>
					</select>
           <button id="preview_form" class="fm-button preview-button small" title="<?php echo __("Form Preview", "contact_form_maker"); ?>" onclick="tb_show('', '<?php echo add_query_arg(array('action' => 'ContactFormMakerPreview', 'form_id' => $row->id, 'test_theme' => $row->theme, 'width' => '1000', 'height' => '500', 'TB_iframe' => '1'), admin_url('admin-ajax.php')); ?>'); return false;">
						    <span></span>
										<?php echo __("Preview", "contact_form_maker"); ?>
						  </button>
              <button id="edit_css" class="fm-button options-edit-button small" title="<?php echo __("Edit CSS","contact_form_maker"); ?>"  onclick="alert('<?php echo addslashes(__("This option is disabled in free version.", "contact_form_maker")); ?>'); return false;">
								<span></span>
										<?php echo __("Edit CSS", "contact_form_maker"); ?>
						  </button>
              <div class="spider_description spider_free_desc"><?php echo __("Themes are disabled in free version.","contact_form_maker"); ?></div>
				</div>
			</div>
			<div class="fm-clear"></div>
      <div id="formMakerDiv" onclick="close_window()"></div>
      <div id="formMakerDiv1">
        <table class="formMakerDiv1_table" border="0" width="100%" cellpadding="0" cellspacing="0" height="100%">
          <tr>
            <td style="padding:0px">
              <table border="0" cellpadding="0" cellspacing="0" width="100%" height="100%">
                <tr valign="top">
                  <td width="50%" height="100%" align="left">
                    <div id="edit_table" style="padding:0px; overflow-y:scroll; height:535px"></div>
                  </td>
                   <td align="center" valign="top" style="background: url("<?php echo WD_CFM_URL . '/images/border2.png'; ?>") repeat-y;">&nbsp;</td>
                   <td style="padding:15px">
                    <table border="0" cellpadding="0" cellspacing="0" width="100%" height="100%">
                      <tr>
                        <td align="right"> 
                          <button alt="ADD" title="<?php echo __("add", "contact_form_maker"); ?>" class="fm-button  field-save-button small" onClick="add(0); return false;">
															<?php echo __("save", "contact_form_maker"); ?>
															<span></span>
													</button>
													<button alt="CANCEL" title="<?php echo __("cancel", "contact_form_maker"); ?>" class="fm-button cancel-button small" onClick="close_window(); return false;">
															<?php echo __("cancel", "contact_form_maker"); ?>
															<span></span>
													</button>
                          <hr style=" margin-bottom:10px" />
                        </td>
                      </tr>
                      <tr height="100%" valign="top">
                        <td id="show_table"></td>
                      </tr>
                    </table>
                  </td>
                </tr>
              </table>
            </td>
          </tr>
        </table>
        <input type="hidden" id="old" />
        <input type="hidden" id="old_selected" />
        <input type="hidden" id="element_type" />
        <input type="hidden" id="editing_id" />
        <input type="hidden" value="<?php echo WD_CFM_URL; ?>" id="form_plugins_url" />
        <div id="main_editor" style="position: absolute; display: none; z-index: 140;">
          <?php
          if (user_can_richedit()) {
            wp_editor('', 'form_maker_editor', array('teeny' => FALSE, 'textarea_name' => 'form_maker_editor', 'media_buttons' => FALSE, 'textarea_rows' => 5));
          }
          else {
            ?>
            <textarea name="form_maker_editor" id="form_maker_editor" cols="40" rows="5" style="width: 440px; height: 350px;" class="mce_editable" aria-hidden="true"></textarea>
            <?php
          }
          ?>
        </div>
      </div>
      <?php
      if (!function_exists('the_editor')) {
        ?>
        <iframe id="tinymce" style="display: none;"></iframe>
        <?php
      }
      ?>
      <div class="fm-edit-content">	
         <div class="fm-drag-and-drop">
						<div>
							<label for="enable_sortable">Enable Drag & Drop</label>
							<button name="sortable" id="enable_sortable" class="fm-checkbox-radio-button <?php echo $row->sortable == 1 ? 'fm-yes' : 'fm-no' ?>" onclick="enable_drag(this); return false;" value="<?php echo $row->sortable; ?>">
								<span></span>
							</button>	
							<input type="hidden" name="sortable" id="sortable_hidden" value="<?php echo $row->sortable; ?>"/>					
						</div>
						<div>
							<?php echo __("You can use drag and drop to move the fields up/down for the change of the order and left/right for creating columns within the form.", "contact_form_maker"); ?>
						</div>
				</div>
      <fieldset>
        <legend><h2 style="color: #00aeef;"><?php echo __("Form", "contact_form_maker"); ?></h2></legend>
        <div id="saving" style="display: none;">
          <div id="saving_text"><?php echo __("Saving", "contact_form_maker"); ?></div>
          <div id="fadingBarsG">
            <div id="fadingBarsG_1" class="fadingBarsG"></div>
            <div id="fadingBarsG_2" class="fadingBarsG"></div>
            <div id="fadingBarsG_3" class="fadingBarsG"></div>
            <div id="fadingBarsG_4" class="fadingBarsG"></div>
            <div id="fadingBarsG_5" class="fadingBarsG"></div>
            <div id="fadingBarsG_6" class="fadingBarsG"></div>
            <div id="fadingBarsG_7" class="fadingBarsG"></div>
            <div id="fadingBarsG_8" class="fadingBarsG"></div>
          </div>
        </div>
          <?php
          if ($id) {
            ?>
            <div id="take">
              <?php
              echo $row->form_front;
              ?>
            </div>
            <?php
          }
          ?>
      </fieldset>
     </div>
      <input type="hidden" name="form_front" id="form_front" />
      <input type="hidden" name="form_fields" id="form_fields" />
      <input type="hidden" name="public_key" id="public_key" />
      <input type="hidden" name="private_key" id="private_key" />
      <input type="hidden" name="recaptcha_theme" id="recaptcha_theme" />
      <input type="hidden" id="label_order" name="label_order" value="<?php echo $row->label_order; ?>" />
      <input type="hidden" id="label_order_current" name="label_order_current" value="<?php echo $row->label_order_current; ?>" />  
      <input type="hidden" name="counter" id="counter" value="<?php echo $row->counter; ?>" />
      <input type="hidden" id="araqel" value="0" />
      <input type="hidden" name="disabled_fields" id="disabled_fields" value="<?php echo $row->disabled_fields; ?>">
      <?php
      if ($id) {
        ?>
      <script type="text/javascript">
        function formOnload() {
          for (t = 0; t < <?php echo $row->counter; ?>; t++) {
            if (document.getElementById("wdform_field" + t)) {
              if (document.getElementById("wdform_field" + t).parentNode.getAttribute("disabled")) {
                if (document.getElementById("wdform_field" + t).getAttribute("type") != 'type_section_break') {
                  document.getElementById("wdform_field" + t).style.cssText = 'display: table-cell;';
                }
                document.getElementById("disable_field" + t).checked = false;
                document.getElementById("disable_field" + t).setAttribute("title", "Enable the field");
                document.getElementById("wdform_field" + t).parentNode.style.cssText = 'opacity: 0.4;';
              }
              else {
                document.getElementById( "disable_field" + t).checked = true;
              }
            }
          }
          for (t = 0; t < <?php echo $row->counter; ?>; t++) {
            if (document.getElementById(t + "_typeform_id_temp")) {
              if (document.getElementById(t + "_typeform_id_temp").value == "type_map") {
                if_gmap_init(t);
                for (q = 0; q < 20; q++) {
                  if (document.getElementById(t + "_elementform_id_temp").getAttribute("long" + q)) {
                    w_long = parseFloat(document.getElementById(t + "_elementform_id_temp").getAttribute("long" + q));
                    w_lat = parseFloat(document.getElementById(t + "_elementform_id_temp").getAttribute("lat" + q));
                    w_info = parseFloat(document.getElementById(t + "_elementform_id_temp").getAttribute("info" + q));
                    add_marker_on_map(t, q, w_long, w_lat, w_info, false);
                  }
                }
              }
              else if (document.getElementById(t + "_typeform_id_temp").value == "type_name") {
                var myu = t;
                jQuery(document).ready(function() {
                  jQuery("#" + myu + "_mini_label_first").click(function() {
                    if (jQuery(this).children('input').length == 0) {
                      var first = "<input type='text' id='first' class='first' style='outline:none; border:none; background:none;' value=\""+jQuery(this).text()+"\">";
                      jQuery(this).html(first);
                      jQuery("input.first").focus();
                      jQuery("input.first").blur(function() {
                        var id_for_blur = document.getElementById('first').parentNode.id.split('_');
                        var value = jQuery(this).val();
                        jQuery("#" + id_for_blur[0] + "_mini_label_first").text(value);
                      });
                    }
                  });
                  jQuery("label#" + myu + "_mini_label_last").click(function() {
                    if (jQuery(this).children('input').length == 0) {
                      var last = "<input type='text' id='last' class='last'  style='outline:none; border:none; background:none;' value=\""+jQuery(this).text()+"\">";	
                      jQuery(this).html(last);			
                      jQuery("input.last").focus();					
                      jQuery("input.last").blur(function() {	
                        var id_for_blur = document.getElementById('last').parentNode.id.split('_');			
                        var value = jQuery(this).val();			
                        jQuery("#" + id_for_blur[0] + "_mini_label_last").text(value);	
                      });
                    }
                  });
                  jQuery("label#" + myu + "_mini_label_title").click(function() {
                    if (jQuery(this).children('input').length == 0) {
                      var title_ = "<input type='text' id='title_' class='title_'  style='outline:none; border:none; background:none; width:50px;' value=\""+jQuery(this).text()+"\">";	
                      jQuery(this).html(title_);
                      jQuery("input.title_").focus();
                      jQuery("input.title_").blur(function() {
                        var id_for_blur = document.getElementById('title_').parentNode.id.split('_');
                        var value = jQuery(this).val();
                        jQuery("#" + id_for_blur[0] + "_mini_label_title").text(value);
                      });	
                    }
                  });
                  jQuery("label#" + myu + "_mini_label_middle").click(function() {
                    if (jQuery(this).children('input').length == 0) {
                      var middle = "<input type='text' id='middle' class='middle'  style='outline:none; border:none; background:none;' value=\""+jQuery(this).text()+"\">";
                      jQuery(this).html(middle);
                      jQuery("input.middle").focus();
                      jQuery("input.middle").blur(function() {
                        var id_for_blur = document.getElementById('middle').parentNode.id.split('_');
                        var value = jQuery(this).val();
                        jQuery("#"+id_for_blur[0]+"_mini_label_middle").text(value);
                      });
                    }
                  });
                });
              }
              else if (document.getElementById(t + "_typeform_id_temp").value == "type_phone") {
                var myu = t;
                jQuery(document).ready(function() {
                  jQuery("label#"+myu+"_mini_label_area_code").click(function() {
                    if (jQuery(this).children('input').length == 0) {
                      var area_code = "<input type='text' id='area_code' class='area_code' size='10' style='outline:none; border:none; background:none;' value=\""+jQuery(this).text()+"\">";
                      jQuery(this).html(area_code);
                      jQuery("input.area_code").focus();
                      jQuery("input.area_code").blur(function() {
                        var id_for_blur = document.getElementById('area_code').parentNode.id.split('_');
                        var value = jQuery(this).val();
                        jQuery("#"+id_for_blur[0]+"_mini_label_area_code").text(value);
                      });
                    }
                  });
                  jQuery("label#"+myu+"_mini_label_phone_number").click(function() {
                    if (jQuery(this).children('input').length == 0) {
                      var phone_number = "<input type='text' id='phone_number' class='phone_number'  style='outline:none; border:none; background:none;' value=\""+jQuery(this).text()+"\">";
                      jQuery(this).html(phone_number);		
                      jQuery("input.phone_number").focus();
                      jQuery("input.phone_number").blur(function() {
                        var id_for_blur = document.getElementById('phone_number').parentNode.id.split('_');
                        var value = jQuery(this).val();
                        jQuery("#"+id_for_blur[0]+"_mini_label_phone_number").text(value);
                      });	
                    }	
                  });
                });
              }
              else if (document.getElementById(t+"_typeform_id_temp").value == "type_address") {
                var myu = t;
                jQuery(document).ready(function() {
                  jQuery("label#"+myu+"_mini_label_street1").click(function() {
                    if (jQuery(this).children('input').length == 0) {
                      var street1 = "<input type='text' id='street1' class='street1' style='outline:none; border:none; background:none;' value=\""+jQuery(this).text()+"\">";
                      jQuery(this).html(street1);
                      jQuery("input.street1").focus();
                      jQuery("input.street1").blur(function() {
                        var id_for_blur = document.getElementById('street1').parentNode.id.split('_');
                        var value = jQuery(this).val();
                        jQuery("#"+id_for_blur[0]+"_mini_label_street1").text(value);
                      });
                    }
                  });
                  jQuery("label#"+myu+"_mini_label_street2").click(function() {
                    if (jQuery(this).children('input').length == 0) {
                      var street2 = "<input type='text' id='street2' class='street2'  style='outline:none; border:none; background:none;' value=\""+jQuery(this).text()+"\">";
                      jQuery(this).html(street2);
                      jQuery("input.street2").focus();
                      jQuery("input.street2").blur(function() {
                        var id_for_blur = document.getElementById('street2').parentNode.id.split('_');
                        var value = jQuery(this).val();
                        jQuery("#"+id_for_blur[0]+"_mini_label_street2").text(value);
                      });
                    }
                  });
                  jQuery("label#"+myu+"_mini_label_city").click(function() {
                    if (jQuery(this).children('input').length == 0) {
                      var city = "<input type='text' id='city' class='city'  style='outline:none; border:none; background:none;' value=\""+jQuery(this).text()+"\">";
                      jQuery(this).html(city);
                      jQuery("input.city").focus();
                      jQuery("input.city").blur(function() {
                        var id_for_blur = document.getElementById('city').parentNode.id.split('_');
                        var value = jQuery(this).val();
                        jQuery("#"+id_for_blur[0]+"_mini_label_city").text(value);
                      });
                    }
                  });
                  jQuery("label#"+myu+"_mini_label_state").click(function() {
                    if (jQuery(this).children('input').length == 0) {
                      var state = "<input type='text' id='state' class='state'  style='outline:none; border:none; background:none;' value=\""+jQuery(this).text()+"\">";
                      jQuery(this).html(state);
                      jQuery("input.state").focus();
                      jQuery("input.state").blur(function() {
                        var id_for_blur = document.getElementById('state').parentNode.id.split('_');
                        var value = jQuery(this).val();
                        jQuery("#"+id_for_blur[0]+"_mini_label_state").text(value);
                      });
                    }
                  });
                  jQuery("label#"+myu+"_mini_label_postal").click(function() {
                    if (jQuery(this).children('input').length == 0) {
                      var postal = "<input type='text' id='postal' class='postal'  style='outline:none; border:none; background:none;' value=\""+jQuery(this).text()+"\">";
                      jQuery(this).html(postal);
                      jQuery("input.postal").focus();
                      jQuery("input.postal").blur(function() {
                        var id_for_blur = document.getElementById('postal').parentNode.id.split('_');
                        var value = jQuery(this).val();
                        jQuery("#"+id_for_blur[0]+"_mini_label_postal").text(value);
                      });
                    }
                  });
                  jQuery("label#"+myu+"_mini_label_country").click(function() {
                    if (jQuery(this).children('input').length == 0) {
                      var country = "<input type='country' id='country' class='country'  style='outline:none; border:none; background:none;' value=\""+jQuery(this).text()+"\">";
                      jQuery(this).html(country);
                      jQuery("input.country").focus();
                      jQuery("input.country").blur(function() {
                        var id_for_blur = document.getElementById('country').parentNode.id.split('_');
                        var value = jQuery(this).val();
                        jQuery("#"+id_for_blur[0]+"_mini_label_country").text(value);
                      });
                    }
                  });
                });
              }
            }
          }
          remove_whitespace(document.getElementById('take'));
          form_view = 1;
          form_view_count = 0;
          document.getElementById('araqel').value = 1;
        }
        jQuery(window).load(function () {
          formOnload();
        });
        jQuery(function() {
          jQuery('.wdform_section .wdform_column:last-child').each(function() {
            jQuery(this).parent().append(jQuery('<div></div>').addClass("wdform_column"));		
          });
          sortable_columns();
          if (<?php echo $row->sortable ?> == 1) {
            jQuery(".wdform_arrows").hide();
            all_sortable_events();
          }
          else {
            jQuery('.wdform_column').sortable("disable");
          }
        });
      </script>
        <?php
      }
      else {
        ?>
        <script type="text/javascript">
          jQuery(function() {
            jQuery('.wdform_section .wdform_column:last-child').each(function() {
              jQuery(this).parent().append(jQuery('<div></div>').addClass("wdform_column"));
            });
            sortable_columns();
            all_sortable_events();
          });
        </script>
      <?php
      }
      ?>
      <input type="hidden" name="id" value="<?php echo $row->id; ?>" />
      <input type="hidden" name="cid[]" value="<?php echo $row->id; ?>" />
      <input type="hidden" id="task" name="task" value=""/>
      <input type="hidden" id="current_id" name="current_id" value="<?php echo $row->id; ?>" />
    </form>
    <?php
  }

  public function form_options($id) {
    $row = $this->model->get_row_data($id);
    $themes = $this->model->get_theme_rows_data();
    $page_title = $row->title . __(' form options', 'contact_form_maker');
    $label_id = array();
    $label_label = array();
    $label_type = array();
    $label_all = explode('#****#', $row->label_order_current);
    $label_all = array_slice($label_all, 0, count($label_all) - 1);
    foreach ($label_all as $key => $label_each) {
      $label_id_each = explode('#**id**#', $label_each);
      if ($label_id_each[0] == 22) {
        $default_subject = $key;
      }
      array_push($label_id, $label_id_each[0]);
      $label_order_each = explode('#**label**#', $label_id_each[1]);
      array_push($label_label, $label_order_each[0]);
      array_push($label_type, $label_order_each[1]);
    }
    $fields = explode('*:*id*:*type_submitter_mail*:*type*:*', $row->form_fields);
    $fields_count = count($fields);
    $disabled_fields = explode(',', $row->disabled_fields);
    $disabled_fields = array_slice($disabled_fields, 0, count($disabled_fields) - 1);
    $field_exist = array();
    for ($i = 0; $i < count($label_label); $i++) {
      if ($label_type[$i] == "type_submit_reset" || $label_type[$i] == "type_editor" || $label_type[$i] == "type_map" || $label_type[$i] == "type_captcha" || $label_type[$i] == "type_recaptcha" || $label_type[$i] == "type_button" || $label_type[$i] == "type_send_copy" || in_array($label_id[$i], $disabled_fields)) {
        $field_exist[$i] = FALSE;
      }
      else {
        $field_exist[$i] = TRUE;
      }
    }
    ?>
    <script>
    
    function fm_change_radio_checkbox_text(elem) {
				var labels_array = [];
					labels_array['mail_mode'] = ['Text', 'HTML'];
					labels_array['mail_mode_user'] = ['Text', 'HTML'];
					labels_array['value'] = ['1', '0'];
				
				jQuery(elem).val(labels_array['value'][jQuery(elem).val()]);
				jQuery(elem).next().val(jQuery(elem).val());
				
				var clicked_element = labels_array[jQuery(elem).attr('name')];
				jQuery(elem).find('label').html(clicked_element[jQuery(elem).val()]);
				if(jQuery( elem ).hasClass( "fm-text-yes" )) {
					jQuery( elem ).removeClass('fm-text-yes').addClass('fm-text-no');
					jQuery(elem).find("span").animate({
						right: parseInt(jQuery( elem ).css( "width")) - 14 + 'px'
					}, 400, function() {
					}); 
				}	
				else {
					jQuery( elem ).removeClass('fm-text-no').addClass('fm-text-yes');
					jQuery(elem).find("span").animate({
						right: 0
					}, 400, function() {
					}); 
				}		
			}
      gen = "<?php echo $row->counter; ?>";
      form_view_max = 20;
      function set_preview() {
						jQuery("#preview_form").attr("onclick", "tb_show('', '<?php echo add_query_arg(array('action' => 'ContactFormMakerPreview', 'form_id' => $row->id), admin_url('admin-ajax.php')); ?>&test_theme=" + jQuery('#theme').val() + "&width=1000&height=500&TB_iframe=1'); return false;");
						jQuery("#edit_css").attr("onclick", "tb_show('', '<?php echo add_query_arg(array('action' => 'ContactFormMakerEditCSS', 'form_id' => $row->id), admin_url('admin-ajax.php')); ?>&id=" + jQuery('#theme').val() + "&width=800&height=500&TB_iframe=1'); return false;");
					}
          
          function show_verify_options(s){
				if(s){
					jQuery(".verification_div").removeAttr( "style" );
					jQuery(".expire_link").removeAttr( "style" );
						
				} else{
					jQuery(".verification_div").css( 'display', 'none' );
					jQuery(".expire_link").css( 'display', 'none' );
				}
			}
    </script>
    <div style="font-size: 14px; font-weight: bold;">
      <?php echo __("This section allows you to edit form options", "contact_form_maker"); ?>.
      <a style="color: blue; text-decoration: none;" target="_blank" href="http://web-dorado.com/wordpress-contact-form-builder-guide-3.html"><?php echo __("Read More in User Manual", "contact_form_maker"); ?></a>
    </div>
    <div class="fm-upgrade-pro">
			<a target="_blank" href="http://web-dorado.com/files/fromContactFormBuilder.php">
				<div class="fm-upgrade-img">
					UPGRADE TO PRO VERSION 
					<span></span>
				</div>
			</a>
		</div>
		<div class="fm-clear"></div>
    <form class="wrap" method="post" action="admin.php?page=manage_cfm" style="width: 99%;" name="adminForm" id="adminForm">
      <?php wp_nonce_field('nonce_cfm', 'nonce_cfm'); ?>
      <div class="fm-page-header">
				<div class="fm-page-title" style="width: inherit;">
					<?php echo $page_title; ?>
				</div>
      <div class="fm-page-actions">
        <button class="fm-button save-button small" onclick="if (spider_check_email('mailToAdd') ||
                                                                   spider_check_email('mail_from_other') ||
                                                                   spider_check_email('reply_to_other') ||
                                                                   spider_check_email('mail_cc') ||
                                                                   spider_check_email('mail_bcc') ||
                                                                   spider_check_email('mail_from_user') ||
                                                                   spider_check_email('reply_to_user') ||
                                                                   spider_check_email('mail_cc_user') ||
                                                                   spider_check_email('mail_bcc_user') ||
                                                                   spider_check_email('mail_from') ||
                                                                   spider_check_email('reply_to')) { return false; }; spider_set_input_value('task', 'save_options')"/>
          <span></span>
						<?php echo __("Save", "contact_form_maker"); ?>
				</button>                                                                                                           
        <button class="fm-button apply-button small" onclick="if (spider_check_email('mailToAdd') ||
                                                                   spider_check_email('mail_from_other') ||
                                                                   spider_check_email('reply_to_other') ||
                                                                   spider_check_email('mail_cc') ||
                                                                   spider_check_email('mail_bcc') ||
                                                                   spider_check_email('mail_from_user') ||
                                                                   spider_check_email('reply_to_user') ||
                                                                   spider_check_email('mail_cc_user') ||
                                                                   spider_check_email('mail_bcc_user') ||
                                                                   spider_check_email('mail_from') ||
                                                                   spider_check_email('reply_to')) { return false; }; spider_set_input_value('task', 'apply_options')"/>
           <span></span>
						<?php echo __("Apply", "contact_form_maker"); ?>
				</button>                                                                                                             
        <button class="fm-button cancel-button small" onclick="spider_set_input_value('task', 'cancel_options')"/>
           <span></span>
						<?php echo __("Cancel", "contact_form_maker"); ?>
			  </button>
      </div>
      <div class="fm-clear"></div>
			</div>
     <div class="fm-form-options">
       <div class="submenu-box">
         <div class="submenu-pad">
           <ul id="submenu" class="configuration">
            <li>
              <a id="general" class="fm_fieldset_tab" onclick="form_maker_options_tabs('general')" href="#"><?php echo __("General Options", "contact_form_maker"); ?></a>
            </li>
            <li>
              <a id="custom" class="fm_fieldset_tab" onclick="form_maker_options_tabs('custom')" href="#"><?php echo __("Email Options", "contact_form_maker"); ?></a>
            </li>
            <li>
              <a id="actions" class="fm_fieldset_tab" onclick="form_maker_options_tabs('actions')" href="#"><?php echo __("Actions after Submission", "contact_form_maker"); ?></a>
            </li>
          </ul>
        </div>
      </div>
      <fieldset id="general_fieldset" class="adminform fm_fieldset_deactive">
        <legend><?php echo __("General Options", "contact_form_maker"); ?></legend>
        <table class="admintable" style="float: left;">
          <tr valign="top">
            <td class="fm_options_label">
              <label><?php echo __("Published", "contact_form_maker"); ?></label>
            </td>
            <td class="fm_options_value">
									<button class="fm-checkbox-radio-button <?php echo $row->published == 1 ? 'fm-yes' : 'fm-no' ?>" onclick="fm_change_radio(this); return false;" value="<?php echo $row->published; ?>">
										<span></span>
									</button>
									<input type="hidden" name="published" value="<?php echo $row->published; ?>"/>
					 </td>
          </tr>
          <tr valign="top">
            <td class="fm_options_label">
              <label><?php echo __("Save data(to database)", "contact_form_maker"); ?></label>
            </td>
            <td class="fm_options_value">
									<button class="fm-checkbox-radio-button <?php echo $row->savedb == 1 ? 'fm-yes' : 'fm-no' ?>" onclick="fm_change_radio(this); return false;" value="<?php echo $row->savedb; ?>">
										<span></span>
									</button>
									<input type="hidden" name="savedb" value="<?php echo $row->savedb; ?>"/>
						</td>
          </tr>
          <tr valign="top">
            <td class="fm_options_label">
              <label for="theme"><?php echo __("Theme", "contact_form_maker"); ?></label>
            </td>
            <td class="fm_options_value">
              <select id="theme" name="theme" style="width:260px;">
                <?php
                foreach ($themes as $theme) {
                  ?>
                  <option value="<?php echo $theme->id; ?>" <?php echo (($theme->id == $row->theme) ? 'selected="selected"' : ''); ?> <?php echo (($theme->id != 4) ? 'disabled="disabled" title="This theme is disabled in free version."' : ''); ?>><?php echo $theme->title; ?></option>
                  <?php
                }
                ?>
              </select>
              <button id="preview_form" class="fm-button preview-button small" title="<?php echo __("Form Preview", "contact_form_maker"); ?>" onclick="tb_show('', '<?php echo add_query_arg(array('action' => 'ContactFormMakerPreview', 'form_id' => $row->id, 'test_theme' => $row->theme, 'width' => '1000', 'height' => '500', 'TB_iframe' => '1'), admin_url('admin-ajax.php')); ?>'); return false;">
						    <span></span>
										<?php echo __("Preview", "contact_form_maker"); ?>
						  </button>
              <button id="edit_css" class="fm-button options-edit-button small" title="<?php echo __("Edit CSS","contact_form_maker"); ?>"  onclick="alert('<?php echo addslashes(__("This option is disabled in free version.", "contact_form_maker")); ?>'); return false;">
								<span></span>
										<?php echo __("Edit CSS", "contact_form_maker"); ?>
						  </button>
               <div class="spider_description spider_free_desc"><?php echo __("Themes are disabled in free version.","contact_form_maker"); ?></div>
            </td>
          </tr>
          <tr valign="top">
            <td class="fm_options_label">
              <label for="requiredmark"><?php echo __("Required fields mark", "contact_form_maker"); ?></label>
            </td>
            <td class="fm_options_value">
              <input type="text" id="requiredmark" name="requiredmark" value="<?php echo $row->requiredmark; ?>" style="width: 250px;" />
            </td>
          </tr>
        </table>
      </fieldset>
      <fieldset id="custom_fieldset" class="adminform fm_fieldset_deactive">
        <legend><?php echo __("Email Options", "contact_form_maker"); ?></legend>
        <table class="admintable">
          <tr valign="top">
            <td style="width: 75px; vertical-align: middle;">
              <label><?php echo __("Send E-mail", "contact_form_maker"); ?></label>
            </td>
            <td style="padding: 15px;">
								<button class="fm-checkbox-radio-button <?php echo $row->sendemail == 1 ? 'fm-yes' : 'fm-no' ?>" onclick="fm_change_radio(this); return false;" value="<?php echo $row->sendemail; ?>">
									<span></span>
								</button>
								<input type="hidden" name="sendemail" value="<?php echo $row->sendemail; ?>"/>
					 </td>
          </tr>
          <tr>
            <td style="padding: 15px;">
              <label><?php echo __("Mailer", "contact_form_maker"); ?></label>
            </td>
            <td style="padding: 15px;">
              <input type="radio" name="wpmail" id="wpmail_yes" value="1" <?php echo ($row->wpmail) ? 'checked="checked"' : ''; ?> /><label for="wpmail_yes">wp_mail() <?php echo __('function', 'contact_form_maker'); ?></label>
              <input type="radio" name="wpmail" id="wpmail_no" value="0" <?php echo (!$row->wpmail) ? 'checked="checked"' : ''; ?> /><label for="wpmail_no">PHP mail() <?php echo __('function', 'contact_form_maker'); ?></label>
            </td>
          </tr>
        </table>
        <fieldset class="adminform fm_mail_options">
          <legend><?php echo __("Email to Administrator", "contact_form_maker"); ?></legend>
          <table class="admintable">
            <tr valign="top">
              <td class="fm_options_label">
                <label for="mailToAdd"><?php echo __("Email to send submissions to", "contact_form_maker"); ?></label>
              </td>
              <td class="fm_options_value">
                <input type="text" id="mailToAdd" name="mailToAdd" style="width: 250px;" />
                <input type="hidden" id="mail" name="mail" value="<?php echo $row->mail; ?>" />
                <img src="<?php echo WD_CFM_URL . '/images/add.png'; ?>"
                     style="vertical-align: middle; cursor: pointer;"
                     title="<?php echo __("Add more emails", "contact_form_maker"); ?>"
                     onclick="if (spider_check_email('mailToAdd')) {return false;};cfm_create_input('mail', 'mailToAdd', 'cfm_mail_div', '<?php echo WD_CFM_URL; ?>')" />
                <div id="cfm_mail_div">
                  <?php
                  $mail_array = explode(',', $row->mail);
                  foreach ($mail_array as $mail) {
                    if ($mail && $mail != ',') {
                      ?>
                      <div class="fm_mail_input">
                        <?php echo $mail; ?>
                        <img src="<?php echo WD_CFM_URL; ?>/images/delete.png" class="fm_delete_img" onclick="fm_delete_mail(this, '<?php echo $mail; ?>')" title="<?php echo __("Delete Email", "contact_form_maker"); ?>" />
                      </div>
                      <?php
                    }
                  }
                  ?>
                </div>
              </td>
            </tr>
            <tr valign="top">
              <td class="fm_options_label">
                <label for="mail_from"><?php echo __("Email From", "contact_form_maker"); ?></label>
              </td>
              <td class="fm_options_value">
                <?php 
                $is_other = TRUE;
                $field_disabled = TRUE;
                for ($i = 0; $i < $fields_count - 1; $i++) {
                  $field_id = substr($fields[$i], strrpos($fields[$i], '*:*new_field*:*') + 15, strlen($fields[$i]));
                  if (!in_array($field_id, $disabled_fields)) {
                    $field_disabled = FALSE;
                    ?>
                  <div>
                    <input type="radio" name="mail_from" id="mail_from<?php echo $i; ?>" value="<?php echo $field_id; ?>"  <?php echo ($field_id == $row->mail_from ? 'checked="checked"' : '' ); ?> onclick="wdhide('mail_from_other')" />
                    <label for="mail_from<?php echo $i; ?>"><?php echo substr($fields[$i + 1], 0, strpos($fields[$i + 1], '*:*w_field_label*:*')); ?></label>
                  </div>
                    <?php
                    if ($field_id == $row->mail_from) {
                      $is_other = FALSE;
                    }
                  }
                }
                ?>
                <div style="<?php echo ($fields_count == 1 || $field_disabled) ? 'display:none;' : ''; ?>">
                  <input type="radio" id="other" name="mail_from" value="other" <?php echo ($is_other) ? 'checked="checked"' : ''; ?> onclick="wdshow('mail_from_other')" />
                  <label for="other">Other</label>
                </div>
								<input type="text" style="width: <?php echo ($fields_count == 1 || $field_disabled) ? '250px' : '235px; margin-left: 15px' ?>; display: <?php echo ($is_other) ? 'block;' : 'none;'; ?>" id="mail_from_other" name="mail_from_other" value="<?php echo ($is_other && !$field_disabled) ? $row->mail_from : ''; ?>" />
              </td>
            </tr>
            <tr valign="top">
              <td class="fm_options_label">
                <label for="mail_from_name"><?php echo __("From Name", "contact_form_maker"); ?></label>
              </td>
              <td class="fm_options_value">
                <input type="text" id="mail_from_name" name="mail_from_name" value="<?php echo $row->mail_from_name; ?>" style="width: 250px;" />
                <img src="<?php echo WD_CFM_URL . '/images/add.png'; ?>" onclick="document.getElementById('mail_from_labels').style.display='block';" style="vertical-align: middle; display:inline-block; margin:0px; float:none; cursor: pointer;" />
								<div style="position: relative; top: -3px;">
                  <div id="mail_from_labels" class="email_labels" style="display: none;">
                    <?php
                    for ($i = 0; $i < count($label_label); $i++) {
                      if (!$field_exist[$i]) {
                        continue;
                      }
                      $param = htmlspecialchars(addslashes($label_label[$i]));
                      $fld_label = htmlspecialchars($label_label[$i]);
                      if (strlen($fld_label) > 30) {
                        $fld_label = wordwrap($fld_label, 30);
                        $fld_label = explode("\n", $fld_label);
                        $fld_label = $fld_label[0] . ' ...';
                      }
                      ?>
                      <a onClick="insertAtCursor('mail_from_name', '<?php echo $param; ?>'); document.getElementById('mail_from_labels').style.display='none';" style="display: block; text-decoration:none;"><?php echo $fld_label; ?></a>
                      <?php
                    }
                    ?>
                  </div>
                </div>
              </td>
            </tr>
            <tr valign="top">
              <td class="fm_options_label">
                <label for="reply_to"><?php echo __("Reply to", "contact_form_maker"); ?><br/>(<?php echo __("if different from 'Email From'", "contact_form_maker"); ?>) </label>
              </td>
              <td class="fm_options_value">
                <?php 
                $is_other = TRUE;
                $field_disabled = TRUE;
                for ($i = 0; $i < $fields_count - 1; $i++) {
                  $field_id = substr($fields[$i], strrpos($fields[$i], '*:*new_field*:*') + 15, strlen($fields[$i]));
                  if (!in_array($field_id, $disabled_fields)) {
                    $field_disabled = FALSE;
                    ?>
                  <div>
                    <input type="radio" name="reply_to" id="reply_to<?php echo $i; ?>" value="<?php echo $field_id; ?>"  <?php echo ($field_id == $row->reply_to ? 'checked="checked"' : ''); ?> onclick="wdhide('reply_to_other')" />
                    <label for="reply_to<?php echo $i; ?>"><?php echo substr($fields[$i + 1], 0, strpos($fields[$i + 1], '*:*w_field_label*:*')); ?></label>
                  </div>
                  <?php
                    if ($field_id == $row->reply_to) {
                      $is_other = FALSE;
                    }
                  }
								}
								?>
								<div style="<?php echo ($fields_count == 1 || $field_disabled) ? 'display: none;' : ''; ?>">
                  <input type="radio" id="other1" name="reply_to" value="other" <?php echo ($is_other) ? 'checked="checked"' : ''; ?> onclick="wdshow('reply_to_other')" />
                  <label for="other1"><?php echo __("Other","contact_form_maker"); ?></label>
                </div>
								<input type="text" style="width: <?php echo ($fields_count == 1 || $field_disabled) ? '250px' : '235px; margin-left: 15px'; ?>; display: <?php echo ($is_other) ? 'block;' : 'none;'; ?>" id="reply_to_other" name="reply_to_other" value="<?php echo ($is_other && $row->reply_to && !$field_disabled) ? $row->reply_to : ''; ?>" />
              </td>
            </tr>
            <tr valign="top">
							<td class="fm_options_label">
								<label for="mail_cc">CC: </label>
							</td>
							<td class="fm_options_value">
								<input type="text" id="mail_cc" name="mail_cc" value="<?php echo $row->mail_cc; ?>" style="width: 250px;" />
							</td>
						</tr>
						<tr valign="top">
							<td class="fm_options_label">
								<label for="mail_bcc">BCC: </label>
							</td>
							<td class="fm_options_value">
								<input type="text" id="mail_bcc" name="mail_bcc" value="<?php echo $row->mail_bcc; ?>" style="width: 250px;" />
							</td>
						</tr>
						<tr valign="top">
							<td class="fm_options_label">
								<label for="mail_subject"><?php echo __("Subject", "contact_form_maker"); ?>: </label>
							</td>
							<td class="fm_options_value">
								<input type="text" id="mail_subject" name="mail_subject" value="<?php echo (($row->mail_subject == '') && !in_array($label_id[$default_subject], $disabled_fields)) ? '%' . $label_label[$default_subject] . '%' : $row->mail_subject; ?>" style="width: 250px;" />
								<img src="<?php echo WD_CFM_URL . '/images/add.png'; ?>" onclick="document.getElementById('mail_subject_labels').style.display='block';" style="vertical-align: middle; display:inline-block; margin:0px; float:none; cursor: pointer;" />
								<div style="position: relative; top: -3px;">
                  <div id="mail_subject_labels" class="email_labels" style="display: none;" >
                    <?php
                    for ($i = 0; $i < count($label_label); $i++) {
                      if (!$field_exist[$i]) {
                        continue;
                      }
                      $param = htmlspecialchars(addslashes($label_label[$i]));
                      $fld_label = htmlspecialchars($label_label[$i]);
                      if (strlen($fld_label) > 30) {
                        $fld_label = wordwrap($fld_label, 30);
                        $fld_label = explode("\n", $fld_label);
                        $fld_label = $fld_label[0] . ' ...';
                      }
                      ?>
                      <a onClick="insertAtCursor('mail_subject', '<?php echo $param; ?>'); document.getElementById('mail_subject_labels').style.display='none';" style="display: block; text-decoration: none;"><?php echo $fld_label; ?></a>
                      <?php
                    }
                    ?>
                  </div>
                </div>
							</td>
						</tr>
						<tr valign="top">
              <td class="fm_options_label" style="vertical-align: middle;">
                <label><?php echo __("Mode", "contact_form_maker"); ?>: </label>
              </td>
              <td class="fm_options_value">
									<button name="mail_mode"class="fm-checkbox-radio-button <?php echo $row->mail_mode == 1 ? 'fm-text-yes' : 'fm-text-no' ?> medium" onclick="fm_change_radio_checkbox_text(this); return false;" value="<?php echo $row->mail_mode  ?>">
										<label><?php echo $row->mail_mode == 1 ? 'HTML' : 'Text' ?></label>
										<span></span>
									</button>
									<input type="hidden" name="mail_mode" value="<?php echo $row->mail_mode; ?>"/>
								</td>
            </tr>
            <tr>
              <td class="fm_options_label" valign="top">
                <label><?php echo __("Custom Text in Email For Administrator", "contact_form_maker"); ?></label>
              </td>
              <td class="fm_options_value">
                <div style="margin-bottom:5px">
                  <?php
                  for ($i = 0; $i < count($label_label); $i++) {
                    if (!$field_exist[$i]) {
                      continue;
                    }
                    $param = htmlspecialchars(addslashes($label_label[$i]));
                    ?>
                    <input style="border: 1px solid silver; font-size: 10px;" type="button" value="<?php echo htmlspecialchars($label_label[$i]); ?>" onClick="insertAtCursor('script_mail', '<?php echo $param; ?>')" />
                    <?php
                  }
                  ?>
                  <input style="border: 1px solid silver; font-size: 11px; font-weight: bold; display: block;" type="button" value="<?php echo __("All fields list", "contact_form_maker"); ?>" onClick="insertAtCursor('script_mail', 'all')" />
                </div>
                <?php
                if (user_can_richedit()) {
                  wp_editor($row->script_mail, 'script_mail', array('teeny' => FALSE, 'textarea_name' => 'script_mail', 'media_buttons' => FALSE, 'textarea_rows' => 5));
                }
                else {
                  ?>
                  <textarea name="script_mail" id="script_mail" cols="20" rows="10" style="width: 300px; height: 450px;"><?php echo $row->script_mail; ?></textarea>
                  <?php
                }
                ?>
              </td>
            </tr>
          </table>
        </fieldset>
        <fieldset class="fm_mail_options">
          <legend><?php echo __("Email to User", "contact_form_maker"); ?></legend>
          <table class="admintable">
            <tr valign="top">
              <td class="fm_options_label">
                <label for="mail"><?php echo __("Send to", "contact_form_maker"); ?></label>
              </td>
              <td class="fm_options_value">
                <?php 
								$fields = explode('*:*id*:*type_submitter_mail*:*type*:*', $row->form_fields);
								$fields_count = count($fields);
                if ($fields_count == 1) {
									 echo __("There is no email field", "contact_form_maker"); 
                }
								else {
                  for ($i = 0; $i < $fields_count - 1; $i++) {
                    ?>
                    <div>
                      <input type="checkbox" name="send_to<?php echo $i; ?>" id="send_to<?php echo $i; ?>" value="<?php echo substr($fields[$i], strrpos($fields[$i], '*:*new_field*:*') + 15, strlen($fields[$i])); ?>"  <?php echo (is_numeric(strpos($row->send_to, '*' . substr($fields[$i], strrpos($fields[$i], '*:*new_field*:*') + 15, strlen($fields[$i])) . '*')) ? 'checked="checked"' : '' ); ?> />
                      <label for="send_to<?php echo $i; ?>"><?php echo substr($fields[$i + 1], 0, strpos($fields[$i + 1], '*:*w_field_label*:*')); ?></label>
                    </div>
                    <?php
                  }
								}
                ?>
              </td>
            </tr>
            <tr valign="top">
              <td class="fm_options_label">
                <label for="mail_from_user"><?php echo __("Email From", "contact_form_maker"); ?></label>
              </td>
              <td class="fm_options_value">
                <input type="text" id="mail_from_user" name="mail_from_user" value="<?php echo $row->mail_from_user; ?>" style="width: 250px;" />
              </td>
            </tr>
            <tr valign="top">
              <td class="fm_options_label">
                <label for="mail_from_name_user"><?php echo __("From Name", "contact_form_maker"); ?></label>
              </td>
              <td class="fm_options_value">
                <input type="text" id="mail_from_name_user" name="mail_from_name_user" value="<?php echo $row->mail_from_name_user; ?>" style="width: 250px;"/>
                <img src="<?php echo WD_CFM_URL . '/images/add.png'; ?>" onclick="document.getElementById('mail_from_name_user_labels').style.display='block';" style="vertical-align: middle; display: inline-block; margin: 0px; float: none; cursor: pointer;" />
                <div style="position: relative; top: -3px;">
                  <div id="mail_from_name_user_labels" class="email_labels" style="display:none;">
                    <?php
                    for ($i = 0; $i < count($label_label); $i++) {
                      if (!$field_exist[$i]) {
                        continue;
                      }
                      $param = htmlspecialchars(addslashes($label_label[$i]));
                      $fld_label = htmlspecialchars($label_label[$i]);
                      if (strlen($fld_label) > 30) {
                        $fld_label = wordwrap($fld_label, 30);
                        $fld_label = explode("\n", $fld_label);
                        $fld_label = $fld_label[0] . ' ...';
                      }
                      ?>
                      <a onClick="insertAtCursor('mail_from_name_user', '<?php echo $param; ?>'); document.getElementById('mail_from_name_user_labels').style.display='none';" style="display: block; text-decoration: none;"><?php echo $fld_label; ?></a>
                      <?php
                    }
                    ?>
                  </div>
                </div>
              </td>
            </tr>
            <tr valign="top">
              <td class="fm_options_label">
                <label for="reply_to_user"><?php echo __("Reply to", "contact_form_maker"); ?><br />(<?php echo __("if different from 'Email From'", "contact_form_maker"); ?>)</label>
              </td>
              <td class="fm_options_value">
                <input type="text" id="reply_to_user" name="reply_to_user" value="<?php echo $row->reply_to_user; ?>" style="width: 250px;" />
              </td>
            </tr>
            <tr valign="top">
							<td class="fm_options_label">
								<label for="mail_cc_user">CC: </label>
							</td>
							<td class="fm_options_value">
								<input type="text" id="mail_cc_user" name="mail_cc_user" value="<?php echo $row->mail_cc_user; ?>" style="width: 250px;" />
							</td>
						</tr>
						<tr valign="top">
							<td class="fm_options_label">
								<label for="mail_bcc_user">BCC: </label>
							</td>
							<td class="fm_options_value">
								<input type="text" id="mail_bcc_user" name="mail_bcc_user" value="<?php echo $row->mail_bcc_user; ?>" style="width: 250px;" />
							</td>
						</tr>
						<tr valign="top">
							<td class="fm_options_label">
								<label for="mail_subject_user"><?php echo __("Subject", "contact_form_maker"); ?>: </label>
							</td>
							<td class="fm_options_value">
								<input type="text" id="mail_subject_user" name="mail_subject_user" value="<?php echo (($row->mail_subject_user == '') && !in_array($label_id[$default_subject], $disabled_fields)) ? '%' . $label_label[$default_subject] . '%' : $row->mail_subject_user; ?>" style="width: 250px;" />
								<img src="<?php echo WD_CFM_URL . '/images/add.png'; ?>" onclick="document.getElementById('mail_subject_user_labels').style.display='block';" style="vertical-align: middle; display: inline-block; margin: 0px; float: none; cursor: pointer;" />
								<div style="position: relative; top: -3px;">
                  <div id="mail_subject_user_labels" class="email_labels" style="display: none;">
                  <?php
                  for ($i = 0; $i < count($label_label); $i++) {
                    if (!$field_exist[$i]) {
                      continue;
                    }
                    $param = htmlspecialchars(addslashes($label_label[$i]));
                    $fld_label = htmlspecialchars($label_label[$i]);
                    if (strlen($fld_label) > 30) {
                      $fld_label = wordwrap($fld_label, 30);
                      $fld_label = explode("\n", $fld_label);
                      $fld_label = $fld_label[0] . ' ...';
                    }
                    ?>
                    <a onClick="insertAtCursor('mail_subject_user', '<?php echo $param; ?>'); document.getElementById('mail_subject_user_labels').style.display='none';" style="display: block; text-decoration: none;"><?php echo $fld_label; ?></a>
                    <?php
                  }
                  ?>
                  </div>
                </div>
							</td>
						</tr>
						<tr valign="top">
              <td class="fm_options_label" style="vertical-align: middle;">
                <label><?php echo __("Mode", "contact_form_maker"); ?>: </label>
              </td>
              <td class="fm_options_value">
									<button name="mail_mode_user"class="fm-checkbox-radio-button <?php echo $row->mail_mode_user == 1 ? 'fm-text-yes' : 'fm-text-no' ?> medium" onclick="fm_change_radio_checkbox_text(this); return false;" value="<?php echo $row->mail_mode_user  ?>">
										<label><?php echo $row->mail_mode_user == 1 ? 'HTML' : 'Text' ?></label>
										<span></span>
									</button>
									<input type="hidden" name="mail_mode_user" value="<?php echo $row->mail_mode_user; ?>"/>
								</td>
            </tr>
            <tr>
              <td class="fm_options_label" valign="top">
                <label><?php echo __("Custom Text in Email For User", "contact_form_maker"); ?></label>
              </td>
              <td class="fm_options_value">
                <div style="margin-bottom:5px">
                  <?php
                  for ($i = 0; $i < count($label_label); $i++) {
                    if (!$field_exist[$i]) {
                      continue;
                    }
                    $param = htmlspecialchars(addslashes($label_label[$i]));
                    ?>
                    <input style="border: 1px solid silver; font-size: 10px;" type="button" value="<?php echo htmlspecialchars($label_label[$i]); ?>" onClick="insertAtCursor('script_mail_user', '<?php echo $param; ?>')" />
                    <?php
                  }
                  ?>
                  <input style="border: 1px solid silver; font-size: 11px; font-weight: bold; display: block;" type="button" value="All fields list" onClick="insertAtCursor('script_mail_user', 'all')" />
                </div>
                <?php
                if (user_can_richedit()) {
                  wp_editor($row->script_mail_user, 'script_mail_user', array('teeny' => FALSE, 'textarea_name' => 'script_mail_user', 'media_buttons' => FALSE, 'textarea_rows' => 5));
                }
                else {
                  ?>
                  <textarea name="script_mail_user" id="script_mail_user" cols="20" rows="10" style="width: 300px; height: 450px;"><?php echo $row->script_mail_user; ?></textarea>
                  <?php
                }
                ?>
              </td>
            </tr>
          </table>
        </fieldset>
      </fieldset>
      <fieldset id="actions_fieldset" class="adminform fm_fieldset_deactive">
        <legend><?php echo __("Actions after submission", "contact_form_maker"); ?></legend>
        <table class="admintable">
          <tr valign="top">
            <td class="fm_options_label">
              <label><?php echo __("Action type", "contact_form_maker"); ?></label>
            </td>
            <td class="fm_options_value">
              <div><input type="radio" name="submit_text_type" id="text_type_none" onclick="set_type('none')" value="1" <?php echo ($row->submit_text_type != 2 && $row->submit_text_type != 3 && $row->submit_text_type != 4 && $row->submit_text_type != 5) ? "checked" : ""; ?> /><label for="text_type_none"><?php echo __("Stay on Form", "contact_form_maker"); ?></label></div>
              <div><input type="radio" name="submit_text_type" id="text_type_post" onclick="set_type('post')" value="2" <?php echo ($row->submit_text_type == 2) ? "checked" : ""; ?> /><label for="text_type_post"><?php echo __("Post","contact_form_maker"); ?></label></label></div>
              <div><input type="radio" name="submit_text_type" id="text_type_page" onclick="set_type('page')" value="5" <?php echo ($row->submit_text_type == 5) ? "checked" : ""; ?> /><label for="text_type_page"><?php echo __("Page","contact_form_maker"); ?></label></label></div>
              <div><input type="radio" name="submit_text_type" id="text_type_custom_text" onclick="set_type('custom_text')" value="3" <?php echo ($row->submit_text_type == 3 ) ? "checked" : ""; ?> /><label for="text_type_custom_text"><?php echo __("Custom Text","contact_form_maker"); ?></label></label></div>
              <div><input type="radio" name="submit_text_type" id="text_type_url" onclick="set_type('url')" value="4" <?php echo ($row->submit_text_type == 4) ? "checked" : ""; ?> /><label for="text_type_url">URL</div>
            </td>
          </tr>
          <tr id="none" <?php echo (($row->submit_text_type == 2 || $row->submit_text_type == 3 || $row->submit_text_type == 4 || $row->submit_text_type == 5) ? 'style="display:none"' : ''); ?>>
            <td class="fm_options_label">
              <label><?php echo __("Stay on Form", "contact_form_maker"); ?></label>
            </td>
            <td class="fm_options_value">
              <img src="<?php echo WD_CFM_URL . '/images/tick.png'; ?>" border="0">
            </td>
          </tr>
          <tr id="post" <?php echo (($row->submit_text_type != 2) ? 'style="display: none"' : ''); ?>>
            <td class="fm_options_label">
              <label for="post_name"><?php echo __("Post", "contact_form_maker"); ?></label>
            </td>
            <td class="fm_options_value">
              <select id="post_name" name="post_name" style="width: 153px; font-size: 11px;">
                <option value="0">- <?php echo __("Select Post", "contact_form_maker"); ?> -</option>
                <?php
                // The Query.
                $args = array('posts_per_page'  => 10000);
                query_posts($args);
                // The Loop.
                while (have_posts()) : the_post(); ?>
                <option value="<?php $x = get_permalink(get_the_ID()); echo $x; ?>" <?php echo (($row->article_id == $x) ? 'selected="selected"' : ''); ?>><?php the_title(); ?></option>
                <?php
                endwhile;
                // Reset Query.
                wp_reset_query();
                ?>
              </select>
            </td>
          </tr>
          <tr id="page" <?php echo (($row->submit_text_type != 5) ? 'style="display: none"' : ''); ?>>
            <td class="fm_options_label">
              <label for="page_name"><?php echo __("Page", "contact_form_maker"); ?></label>
            </td>
            <td class="fm_options_value">
              <select id="page_name" name="page_name" style="width: 153px; font-size: 11px;">
                <option value="0">- <?php echo __("Select Page", "contact_form_maker"); ?> -</option>
                <?php
                // The Query.
                $pages = get_pages();
                // The Loop.
                foreach ($pages as $page) {
                  $page_id = get_page_link($page->ID);
                  ?>
                <option value="<?php echo $page_id; ?>" <?php echo (($row->article_id == $page_id) ? 'selected="selected"' : ''); ?>><?php echo $page->post_title; ?></option>
                  <?php
                }
                // Reset Query.
                wp_reset_query();
                ?>
              </select>
            </td>
          </tr>
          <tr id="custom_text" <?php echo (($row->submit_text_type != 3) ? 'style="display: none;"' : ''); ?>>
            <td class="fm_options_label">
              <label for="submit_text"><?php echo __("Text", "contact_form_maker"); ?></label>
            </td>
            <td class="fm_options_value">
              <?php
              if (user_can_richedit()) {
                wp_editor($row->submit_text, 'submit_text', array('teeny' => FALSE, 'textarea_name' => 'submit_text', 'media_buttons' => FALSE, 'textarea_rows' => 5));
              }
              else {
                ?>
                <textarea cols="36" rows="5" id="submit_text" name="submit_text" style="resize: vertical;">
                  <?php echo $row->submit_text; ?>
                </textarea>
                <?php
              }
              ?>
            </td>
          </tr>
          <tr id="url" <?php echo (($row->submit_text_type != 4 ) ? 'style="display:none"' : ''); ?>>
            <td class="fm_options_label">
              <label for="url">URL</label>
            </td>
            <td class="fm_options_value">
              <input type="text" id="url" name="url" style="width:300px" value="<?php echo $row->url; ?>" />
            </td>
          </tr>
        </table>
      </fieldset>
    </div>
      <input type="hidden" name="fieldset_id" id="fieldset_id" value="<?php echo WDW_CFM_Library::get('fieldset_id', 'general'); ?>" />
      <input type="hidden" id="task" name="task" value=""/>
      <input type="hidden" id="current_id" name="current_id" value="<?php echo $row->id; ?>" />
    </form>
    <script>
      jQuery(window).load(function () {
        form_maker_options_tabs(jQuery("#fieldset_id").val());
        spider_popup();
        jQuery("#mail_from_labels, #mail_from_name_user_labels, #mail_subject_labels, #mail_subject_user_labels").mouseleave(function() {
          jQuery(this).hide();
        });
      });
    </script>
    <?php
  }

  public function form_layout($id) {
    $row = $this->model->get_row_data($id);
    $ids = array();
    $types = array();
    $labels = array();
    $fields = explode('*:*new_field*:*', $row->form_fields);
    $fields = array_slice($fields, 0, count($fields) - 1);
    foreach ($fields as $field) {
      $temp = explode('*:*id*:*', $field);
      array_push($ids, $temp[0]);
      $temp = explode('*:*type*:*', $temp[1]);
      array_push($types, $temp[0]);
      $temp = explode('*:*w_field_label*:*', $temp[1]);
      array_push($labels, $temp[0]);
    }
		?>
    <script>
      var form_front = '<?php echo addslashes($row->form_front);?>';
      var custom_front = '<?php echo addslashes($row->custom_front);?>';
      if (custom_front == '') {
        custom_front = form_front;
      }
      function submitbutton() {
        if (jQuery('#autogen_layout').is(':checked')) {
          jQuery('#custom_front').val(custom_front.replace(/\s+/g, ' ').replace(/> </g, '><'));
        }
        else {
          jQuery('#custom_front').val(editor.getValue().replace(/\s+/g, ' ').replace(/> </g, '><'));
        }
      }
      function insertAtCursor_form(myId, myLabel) {
        if (jQuery('#autogen_layout').is(':checked')) {
          alert('<?php echo addslashes(__("Uncheck the Auto-Generate Layout box.", "contact_form_maker")); ?>');
          return;
        }
        myValue = '<div wdid="' + myId + '" class="wdform_row">%' + myId + ' - ' + myLabel + '%</div>';
        line = editor.getCursor().line;
        ch = editor.getCursor().ch;
        text = editor.getLine(line);
        text1 = text.substr(0, ch);
        text2 = text.substr(ch);
        text = text1 + myValue + text2;
        editor.setLine(line, text);
        editor.focus();
      }
      function autogen(status) {
        if (status) {
          custom_front = editor.getValue();
          editor.setValue(form_front);
          editor.setOption('readOnly', true);
          autoFormat();
        }
        else {
          editor.setValue(custom_front);
          editor.setOption('readOnly', false);
          autoFormat();
        }
      }
      function autoFormat() {
        CodeMirror.commands["selectAll"](editor);
        editor.autoFormatRange(editor.getCursor(true), editor.getCursor(false));
        editor.scrollTo(0,0);
      }
    </script>

    <div class="fm_layout">
      <form action="admin.php?page=manage_cfm" method="post" name="adminForm" enctype="multipart/form-data">
        <?php wp_nonce_field('nonce_cfm', 'nonce_cfm'); ?>
        <div class="fm-layout-actions">
					<div class="fm-page-actions">
						<button class="fm-button save-button small" onclick="submitbutton(); spider_set_input_value('task', 'save_layout');">
							<?php echo __("Save", "contact_form_maker"); ?>
							<span></span>
						</button>
						<button class="fm-button apply-button small" onclick="submitbutton(); spider_set_input_value('task', 'apply_layout');">
							<?php echo __("Apply", "contact_form_maker"); ?>
							<span></span>
						</button>
						<button class="fm-button cancel-button small" onclick="spider_set_input_value('task', 'cancel_options');">
							<?php echo __("Cancel", "contact_form_maker"); ?>
							<span></span>
						</button>
					</div>
				</div>
				<div class="fm-layout-content">
          <h2 style="clear: both;"><?php echo __("Description", "contact_form_maker"); ?></h2>
          <p><?php echo __("To customize the layout of the form fields uncheck the Auto-Generate Layout box and edit the HTML", "contact_form_maker"); ?>.</p>
          <p><?php echo __("You can change positioning, add in-line styles and etc. Click on the provided buttons to add the corresponding field", "contact_form_maker"); ?>.<br /> <?php echo __("This will add the following line", "contact_form_maker"); ?>:
            <b><span class="cm-tag">&lt;div</span> <span class="cm-attribute">wdid</span>=<span class="cm-string">"example_id"</span> <span class="cm-attribute">class</span>=<span class="cm-string">"wdform_row"</span><span class="cm-tag">&gt;</span>%example_id - Example%<span class="cm-tag">&lt;/div&gt;</span></b>
            , <?php echo __("where", "contact_form_maker"); ?> <b><span class="cm-tag">&lt;div&gt;</span></b> <?php echo __("is used to set a row","contact_form_maker"); ?>.</p>
          <p><?php echo __("To return to the default settings you should check Auto-Generate Layout box","contact_form_maker"); ?>.</p>
          <h3 style="color:red"><?php echo __("Notice","contact_form_maker"); ?></h3>
          <p><?php echo __("Make sure not to publish the same field twice. This will cause malfunctioning of the form","contact_form_maker"); ?>.</p>
          <hr/>
          <label for="autogen_layout" style="font-size: 20px; line-height: 45px; margin-left: 10px;"><?php echo __("Auto Generate Layout", "contact_form_maker"); ?>? </label>
          <input type="checkbox" value="1" name="autogen_layout" id="autogen_layout" <?php echo (($row->autogen_layout) ? 'checked="checked"' : ''); ?> />
          <input type="hidden" name="custom_front" id="custom_front" value="" />

          <input type="hidden" id="task" name="task" value=""/>
          <input type="hidden" id="current_id" name="current_id" value="<?php echo $row->id; ?>" />
      </div>
      </form>
      <br/>
      <?php
      foreach($ids as $key => $id) {
        if ($types[$key] != "type_section_break") {
          ?>
          <button onClick="insertAtCursor_form('<?php echo $ids[$key]; ?>','<?php echo $labels[$key]; ?>')" class="fm_label_buttons" title="<?php echo $labels[$key]; ?>"><?php echo $labels[$key]; ?></button>
          <?php
        }
      }
      ?>
      <br /><br />
      <button class="fm_submit_layout button button-secondary button-hero" onclick="autoFormat()"><strong><?php echo __("Apply Source Formatting", "contact_form_maker"); ?></strong>  <em>(<?php echo __("ctrl-enter", "contact_form_maker"); ?>)</em></button>
      <textarea id="source" name="source" style="display: none;"></textarea>
    </div>
    <script>
      var editor = CodeMirror.fromTextArea(document.getElementById("source"), {
        lineNumbers: true,
        lineWrapping: true,
        mode: "htmlmixed",
        value: form_front
      });
      if (jQuery('#autogen_layout').is(':checked')) {
        editor.setOption('readOnly',  true);
        editor.setValue(form_front);
      }
      else {
        editor.setOption('readOnly',  false);
        editor.setValue(custom_front);
      }
      jQuery('#autogen_layout').click(function() {
        autogen(jQuery(this).is(':checked'));
      });
      autoFormat();
    </script>
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