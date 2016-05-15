<?php

class CFMViewBlocked_ips_cfm {
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
    $search_value = ((isset($_POST['search_value'])) ? esc_html(stripslashes($_POST['search_value'])) : '');
    $asc_or_desc = ((isset($_POST['asc_or_desc'])) ? esc_html(stripslashes($_POST['asc_or_desc'])) : 'desc');
    $order_by = (isset($_POST['order_by']) ? esc_html(stripslashes($_POST['order_by'])) : 'id');
    $order_class = 'manage-column column-title sorted ' . $asc_or_desc;
    $ids_string = '';
    ?>
    <div id="fm_blocked_ips_message" style="width: 99%; display: none;"></div>
    <div class="fm-user-manual">
      <?php echo __("This section allows you to block IPs.", "contact_form_maker"); ?>
      <a style="color: blue; text-decoration: none;" target="_blank" href="http://web-dorado.com/wordpress-contact-form-builder-guide-6.html"><?php echo __("Read More in User Manual","contact_form_maker"); ?></a>
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
    <form onkeypress="spider_doNothing(event)" class="wrap" id="blocked_ips" method="post" action="admin.php?page=blocked_ips_cfm" style="width:99%;">
      <?php wp_nonce_field('nonce_cfm', 'nonce_cfm'); ?>
      	<div class="fm-page-banner blocked-ips-banner">
				<div class="block_icon">
				</div>
				<div class="fm-logo-title"><?php echo __("Blocked IPs", "contact_form_maker"); ?></div>
				<div class="fm-page-actions">
					<button class="fm-button save-button small" onclick="spider_set_input_value('task', 'save_all');">
						<span></span>
						<?php echo __("Save", "contact_form_maker"); ?>
					</button>
					<button class="fm-button delete-button small" onclick="if (confirm('<?php echo addslashes(__('Do you want to unblock selected IPs?', 'contact_form_maker')); ?>')) {
                                                                      spider_set_input_value('task', 'delete_all');
                                                                    } else {
                                                                      return false;
                                                                    }">
						<span></span>
						<?php echo __("Delete", "contact_form_maker"); ?>
					</button>
				</div>
			</div>	
      <div class="fm-clear"></div>
      <div class="tablenav top">
        <?php
        WDW_CFM_Library::search('IP', $search_value, 'blocked_ips');
        WDW_CFM_Library::html_page_nav($page_nav['total'], $page_nav['limit'], 'blocked_ips');
        ?>
      </div>
      <table class="wp-list-table widefat fixed pages fm-block-ip">
        <thead>
          <tr>
            <th class="manage-column column-cb check-column table_small_col"><input id="check_all" type="checkbox" style="margin: 0;" /></th>
            <th class="table_small_col <?php if ($order_by == 'id') {echo $order_class;} ?>">
              <a onclick="spider_set_input_value('task', '');
                          spider_set_input_value('order_by', 'id');
                          spider_set_input_value('asc_or_desc', '<?php echo ((isset($_POST['asc_or_desc']) && isset($_POST['order_by']) && (esc_html(stripslashes($_POST['order_by'])) == 'id') && esc_html(stripslashes($_POST['asc_or_desc'])) == 'asc') ? 'desc' : 'asc'); ?>');
                          spider_form_submit(event, 'blocked_ips')" href="">
                <span>ID</span><span class="sorting-indicator"></span></th>
              </a>
            <th class="<?php if ($order_by == 'ip') {echo $order_class;} ?>">
              <a onclick="spider_set_input_value('task', '');
                          spider_set_input_value('order_by', 'ip');
                          spider_set_input_value('asc_or_desc', '<?php echo ((isset($_POST['asc_or_desc']) && isset($_POST['order_by']) && (esc_html(stripslashes($_POST['order_by'])) == 'ip') && esc_html(stripslashes($_POST['asc_or_desc'])) == 'asc') ? 'desc' : 'asc'); ?>');
                          spider_form_submit(event, 'blocked_ips')" href="">
                <span>IP</span><span class="sorting-indicator"></span>
              </a>
            </th>
            <th class="table_small_col"><?php echo __("Edit", "contact_form_maker"); ?></th>
            <th class="table_small_col"><?php echo __("Delete", "contact_form_maker"); ?></th>
          </tr>		  
          <tr id="tr" style="background-color: #f9f9f9;">
            <th></th>
            <th></th>
            <th>
							<input type="text" class="input_th" id="ip" name="ip" onkeypress="return spider_check_isnum(event)">
							<button class="fm-button add-button small" onclick="if (spider_check_required('ip', 'IP')) {return false;}
                                                                                spider_set_input_value('task', 'save');
                                                                                spider_set_input_value('current_id', '');
                                                                                spider_form_submit(event, 'blocked_ips')">
								<?php echo __("Add IP", "contact_form_maker"); ?>
								<span></span>
							</button>
						</th>
						<th>
							
						</th>
						<th></th>
          </tr>
        </thead>
        <tbody id="tbody_arr">
          <?php
          if ($rows_data) {
            foreach ($rows_data as $row_data) {
              $alternate = (!isset($alternate) || $alternate == 'class="alternate"') ? '' : 'class="alternate"';
              ?>
              <tr id="tr_<?php echo $row_data->id; ?>" <?php echo $alternate; ?>>
                <td class="table_small_col check-column" id="td_check_<?php echo $row_data->id; ?>" >
                  <input id="check_<?php echo $row_data->id; ?>" name="check_<?php echo $row_data->id; ?>" type="checkbox" />
                </td>
                <td class="table_small_col" id="td_id_<?php echo $row_data->id; ?>" ><?php echo $row_data->id; ?></td>
                <td id="td_ip_<?php echo $row_data->id; ?>" >
                  <a class="pointer" id="ip<?php echo $row_data->id; ?>"
                     onclick="spider_edit_ip(<?php echo $row_data->id; ?>)" 
                     title="Edit"><?php echo $row_data->ip; ?></a>
                </td>
                <td class="table_small_col" id="td_edit_<?php echo $row_data->id; ?>">
								  <button class="fm-icon edit-icon" onclick="spider_edit_ip(<?php echo $row_data->id; ?>)">
									 <span></span>
								  </button>
						  	</td>
							  <td class="table_small_col" id="td_delete_<?php echo $row_data->id; ?>">
								  <button class="fm-icon delete-icon" onclick="spider_set_input_value('task', 'delete');
                              spider_set_input_value('current_id', <?php echo $row_data->id; ?>);
                              spider_form_submit(event, 'blocked_ips')">
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
      <input id="task" name="task" type="hidden" value="" />
      <input id="current_id" name="current_id" type="hidden" value="" />
      <input id="ids_string" name="ids_string" type="hidden" value="<?php echo $ids_string; ?>" />
      <input id="asc_or_desc" name="asc_or_desc" type="hidden" value="<?php echo $asc_or_desc; ?>" />
      <input id="order_by" name="order_by" type="hidden" value="<?php echo $order_by; ?>" />
    </form>
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