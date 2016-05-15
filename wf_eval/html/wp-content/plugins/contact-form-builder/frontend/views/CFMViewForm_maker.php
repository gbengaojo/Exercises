<?php

class CFMViewForm_maker {
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
  public function display($id) {
    wp_enqueue_style('jquery-ui');
    wp_enqueue_style('contact_form_maker_frontend');
    wp_enqueue_script('gmap_form_api');
    wp_enqueue_script('gmap_form');
    wp_enqueue_script('cfm_main_front_end');
    $form_maker_front_end = "";
    $result = $this->model->showform($id);
    if (!$result) {
      return;
    }
    $ok = $this->model->savedata($result[0], $id);
    if (is_numeric($ok)) {
      $this->model->remove($ok);
    }
    $row = $result[0];
    $label_id = $result[2];
    $label_type = $result[3];
    $form_theme = $result[4];
    if (isset($_SESSION['cfm_form_submit_type' . $id])) {
      $type_and_id = $_SESSION['cfm_form_submit_type' . $id];
      $type_and_id = explode(',', $type_and_id);
      $form_get_type = $type_and_id[0];
      $form_get_id = isset($type_and_id[1]) ? $type_and_id[1] : '';
      $_SESSION['cfm_form_submit_type' . $id] = 0;
      if ($form_get_type == 3) {
        $_SESSION['cfm_massage_after_submit' . $id] = "";
        $after_submission_text = $this->model->get_after_submission_text($form_get_id);
        require_once(WD_CFM_DIR . '/framework/WDW_CFM_Library.php');
        $form_maker_front_end .=  WDW_CFM_Library::message(wpautop(html_entity_decode($after_submission_text)), 'warning', $id);
        return $form_maker_front_end;
      }
    }
    if (isset($_SESSION['cfm_massage_after_submit' . $id]) && $_SESSION['cfm_massage_after_submit' . $id] != "") {
      $message = $_SESSION['cfm_massage_after_submit' . $id];
      $_SESSION['cfm_massage_after_submit' . $id] = "";
      if ($_SESSION['cfm_error_or_no' . $id]) {
        $error = 'error';
      }
      else {
        $error = 'warning';
      }
      require_once(WD_CFM_DIR . '/framework/WDW_CFM_Library.php');
      $form_maker_front_end .=  WDW_CFM_Library::message($message, $error, $id);
    }
    if (isset($_SESSION['show_submit_text' . $id])) {
      if ($_SESSION['show_submit_text' . $id] == 1) {
        $_SESSION['show_submit_text' . $id] = 0;
        $form_maker_front_end .= $row->submit_text;
        return;
      }
    }
    $this->model->increment_views_count($id);
    $new_form_theme = explode('{', $form_theme);
    $count_after_explod_theme = count($new_form_theme);
    for ($i = 0; $i < $count_after_explod_theme; $i++) {
      $body_or_classes[$i] = explode('}', $new_form_theme[$i]);
    }
    for ($i = 0; $i < $count_after_explod_theme; $i++) {
      if ($i == 0) {
        $body_or_classes[$i][0] = ".contactform" . $id . ' ' . str_replace(',', ", .contactform" . $id, $body_or_classes[$i][0]);
      }
      else {
        $body_or_classes[$i][1] = ".contactform" . $id . ' ' . str_replace(',', ", .contactform" . $id, $body_or_classes[$i][1]);
      }
    }
    for ($i = 0; $i < $count_after_explod_theme; $i++) {
      $body_or_classes_implode[$i] = implode('}', $body_or_classes[$i]);
    }
    $form_theme = implode('{', $body_or_classes_implode);
    $form_maker_front_end .= '<style class="cfm_style">' . str_replace('[SITE_ROOT]', WD_CFM_URL, $form_theme) . '</style>';
    $check_js = '';
    $onload_js = '';
    $onsubmit_js = '';
    $form_maker_front_end .= '<form name="contactform' . $id . '" action="' . $_SERVER['REQUEST_URI'] . '" method="post" id="contactform' . $id . '" class="contactform' . $id . '" enctype="multipart/form-data" onsubmit="check_required(\'submit\', \'' . $id . '\'); return false;">
      <input type="hidden" id="counter' . $id . '" value="' . $row->counter . '" name="counter' . $id . '" />
      <input type="hidden" id="Itemid' . $id . '" value="" name="Itemid' . $id . '" />';
    $is_type = array();
    $id1s = array();
    $types = array();
    $labels = array();
    $paramss = array();
    $required_sym = $row->requiredmark;
    $fields = explode('*:*new_field*:*', $row->form_fields);
    $fields = array_slice($fields,0, count($fields) - 1);
    $disabled_fields = explode(',', $row->disabled_fields);
    $disabled_fields = array_slice($disabled_fields, 0, count($disabled_fields) - 1);
    foreach ($fields as $field) {
      $temp = explode('*:*id*:*', $field);
      array_push($id1s, $temp[0]);
      $temp = explode('*:*type*:*', $temp[1]);
      array_push($types, $temp[0]);
      $temp = explode('*:*w_field_label*:*', $temp[1]);
      array_push($labels, $temp[0]);
      array_push($paramss, $temp[1]);
    }
    $form_id = $id;	
    if ($row->autogen_layout == 0) {
      $form = $row->custom_front;
    }
    else {
      $form = $row->form_front;
    }
    foreach ($id1s as $id1s_key => $id1) {
      $label = $labels[$id1s_key];
      $type = $types[$id1s_key];
      $params = $paramss[$id1s_key];
      if (strpos($form, '%' . $id1 . ' - ' . $label . '%') || strpos($form, '%' . $id1 . ' -' . $label . '%')) {
        $rep = '';
        $required = FALSE;
        $param = array();
        $param['attributes'] = '';
        $is_type[$type] = TRUE;
        if (!in_array($id1, $disabled_fields)) {
          switch ($type) {
            case 'type_section_break': {
              $params_names = array('w_editor');
              $temp = $params;
              foreach ($params_names as $params_name ) {
                $temp = explode('*:*' . $params_name . '*:*', $temp);
                $param[$params_name] = $temp[0];
                $temp = $temp[1];
              }
              $rep = '<div type="type_section_break" class="wdform-field-section-break"><div class="wdform_section_break">' . html_entity_decode($param['w_editor']) . '</div></div>';
              break;
            }
            case 'type_editor': {
              $params_names = array('w_editor');
              $temp = $params;
              foreach ($params_names as $params_name ) {
                $temp = explode('*:*' . $params_name . '*:*', $temp);
                $param[$params_name] = $temp[0];
                $temp = $temp[1];
              }
              $rep = '<div type="type_editor" class="wdform-field">' . html_entity_decode($param['w_editor']) . '</div>';
              break;
            }
            case 'type_send_copy': {
              $params_names = array('w_field_label_size', 'w_field_label_pos', 'w_first_val', 'w_required');
              $temp = $params;
              foreach ($params_names as $params_name ) {
                $temp = explode('*:*' . $params_name . '*:*', $temp);
                $param[$params_name] = $temp[0];
                $temp = $temp[1];
              }
              if ($temp) {
                $temp	= explode('*:*w_attr_name*:*', $temp);
                $attrs = array_slice($temp, 0, count($temp) - 1);
                foreach($attrs as $attr) {
                  $param['attributes'] = $param['attributes'] . ' ' . $attr;
                }
              }              
              $input_active = ($param['w_first_val'] == 'true' ? "checked='checked'" : "");	
              $post_value = isset($_POST["counter".$form_id]) ? $_POST["counter".$form_id] : NULL;
              if (isset($post_value)) {
                $post_temp = isset($_POST['wdform_'.$id1.'_element'.$form_id]) ? $_POST['wdform_'.$id1.'_element'.$form_id] : NULL;
                $input_active = (isset($post_temp) ? "checked='checked'" : "");	
              }              
              $param['w_field_label_pos1'] = ($param['w_field_label_pos'] == "left" ? "float: left;" : "");	
              $param['w_field_label_pos2'] = ($param['w_field_label_pos'] == "left" ? "" : "display: block;");              
              $required = ($param['w_required'] == "yes" ? TRUE : FALSE);	              
              $rep = '<div type="type_send_copy" class="wdform-field"><div class="wdform-label-section" style="'.$param['w_field_label_pos1'].' width: '.$param['w_field_label_size'].'px;"><span class="wdform-label"><label for="wdform_'.$id1.'_element'.$form_id.'">'.$label.'</label></span>';
              if ($required) {
                $rep .= '<span class="wdform-required">'.$required_sym.'</span>';
              }
              $rep .= '</div>
              <div class="wdform-element-section" style="min-width:inherit !important; '.$param['w_field_label_pos2'].'" >
                <div class="checkbox-div" style="left:3px">
                <input type="checkbox" id="wdform_'.$id1.'_element'.$form_id.'" name="wdform_'.$id1.'_element'.$form_id.'" '.$input_active.' '.$param['attributes'].'/>
                <label for="wdform_'.$id1.'_element'.$form_id.'"></label>
                </div>
              </div></div>';

              $onsubmit_js .= '
              if (!jQuery("#wdform_'.$id1.'_element'.$form_id.'").is(":checked")) {
                jQuery("<input type=\"hidden\" name=\"wdform_send_copy_'.$form_id.'\" value = \"1\" />").appendTo("#contactform'.$form_id.'");
              }';
              if ($required) {
                $check_js .= '
                if (x.find(jQuery("div[wdid='.$id1.']")).length != 0) {
                  if (x.find(jQuery("div[wdid='.$id1.'] input:checked")).length == 0) {
                    alert("' .addslashes($label. ' ' . __('field is required.', 'contact_form_maker')) . '");
                    old_bg=x.find(jQuery("div[wdid='.$id1.']")).css("background-color");
                    x.find(jQuery("div[wdid='.$id1.']")).effect( "shake", {}, 500 ).css("background-color","#FF8F8B").animate({backgroundColor: old_bg}, {duration: 500, queue: false });
                    return false;
                  }						
                }';
              }
              break;
            }
            case 'type_text': {
              $params_names = array('w_field_label_size', 'w_field_label_pos', 'w_size', 'w_first_val', 'w_title', 'w_required', 'w_unique');
              $temp = $params;
              if (strpos($temp, 'w_regExp_status') > -1) {
				        $params_names = array('w_field_label_size', 'w_field_label_pos', 'w_size', 'w_first_val', 'w_title', 'w_required', 'w_regExp_status', 'w_regExp_value', 'w_regExp_common', 'w_regExp_arg', 'w_regExp_alert', 'w_unique');
              }
              foreach($params_names as $params_name ) {
                $temp = explode('*:*' . $params_name . '*:*', $temp);
                $param[$params_name] = $temp[0];
                $temp = $temp[1];
              }
              if ($temp) {	
                $temp	= explode('*:*w_attr_name*:*', $temp);
                $attrs = array_slice($temp, 0, count($temp) - 1);
                foreach ($attrs as $attr) {
                  $param['attributes'] = $param['attributes'] . ' ' . $attr;
                }
              }
              $param['w_first_val'] = (isset($_POST['wdform_'.$id1.'_element'.$form_id]) ? $_POST['wdform_'.$id1.'_element'.$form_id] : $param['w_first_val']);
              $wdformfieldsize = ($param['w_field_label_pos'] == "left" ? $param['w_field_label_size']+$param['w_size'] + 10 : max($param['w_field_label_size'],$param['w_size']));	
              $param['w_field_label_pos1'] = ($param['w_field_label_pos'] == "left" ? "float: left;" : "");	
              $param['w_field_label_pos2'] = ($param['w_field_label_pos'] == "left" ? "" : "display: block;");
              $input_active = ($param['w_first_val'] == $param['w_title'] ? "input_deactive" : "input_active");	
              $required = ($param['w_required'] == "yes" ? TRUE : FALSE);
              $param['w_regExp_status'] = (isset($param['w_regExp_status']) ? $param['w_regExp_status'] : "no");
              $rep = '<div type="type_text" class="wdform-field" style="width:'.$wdformfieldsize.'px"><div class="wdform-label-section" style="'.$param['w_field_label_pos1'].' width: '.$param['w_field_label_size'].'px;"><span class="wdform-label">'.$label.'</span>';
              if ($required) {
                $rep .= '<span class="wdform-required">' . $required_sym . '</span>';
              }
              $rep .= '</div><div class="wdform-element-section" style="'.$param['w_field_label_pos2'].' width: '.$param['w_size'].'px;"  ><input type="text" class="'.$input_active.'" id="wdform_'.$id1.'_element'.$form_id.'" name="wdform_'.$id1.'_element'.$form_id.'" value="'.$param['w_first_val'].'" title="'.$param['w_title'].'"  style="width: 100%;" '.$param['attributes'].'></div></div>';
              if ($required) {
                $check_js .= '
                if (x.find(jQuery("div[wdid='.$id1.']")).length != 0) {
                  if (jQuery("#wdform_'.$id1.'_element'.$form_id.'").val()=="'.$param['w_title'].'" || jQuery("#wdform_'.$id1.'_element'.$form_id.'").val()=="") {
                    alert("' .addslashes($label. ' ' . __('field is required.', 'contact_form_maker')) . '");
                    jQuery("#wdform_'.$id1.'_element'.$form_id.'").addClass( "form-error" );
                    old_bg=x.find(jQuery("div[wdid='.$id1.']")).css("background-color");
                    x.find(jQuery("div[wdid='.$id1.']")).effect( "shake", {}, 500 ).css("background-color","#FF8F8B").animate({backgroundColor: old_bg}, {duration: 500, queue: false });
                    jQuery("#wdform_'.$id1.'_element'.$form_id.'").focus();
                    jQuery("#wdform_'.$id1.'_element'.$form_id.'").change(function() { if( jQuery(this).val()!="" ) jQuery(this).removeClass("form-error"); else jQuery(this).addClass("form-error");});
                    return false;
                  }
                }';
              }
              if ($param['w_regExp_status'] == 'yes') {
                $check_js .= '
				       	  var RegExpression = "";
					        var rules = unescape("' . $param["w_regExp_value"] . '");
  		      	    ("'.$param["w_regExp_arg"].'".length <= 0) ?  RegExpression = new RegExp(rules) : RegExpression = new RegExp(rules' . ', "' . $param["w_regExp_arg"] . '");
			        	  if (jQuery("#wdform_' . $id1 . '_element' . $form_id . '").val().length > 0) {
                    if (RegExpression.test(jQuery("#wdform_' . $id1 . '_element' . $form_id . '").val()) != true) {
                      alert(" '.$param["w_regExp_alert"].' ");
                      old_bg = x.find(jQuery("div[wdid=' . $id1 . ']")).css("background-color");
                      x.find(jQuery("div[wdid=' . $id1 . ']")).effect( "shake", {}, 500 ).css("background-color","#FF8F8B").animate({backgroundColor: old_bg}, {duration: 500, queue: false });
                      jQuery("#wdform_' . $id1 . '_element' . $form_id . '").addClass("form-error");
                      jQuery("#wdform_' . $id1 . '_element' . $form_id . '").focus();
                      jQuery("#wdform_' . $id1 . '_element' . $form_id . '").change(function() { if( jQuery(this).val()!="" ) jQuery(this).removeClass("form-error"); else jQuery(this).addClass("form-error");});
                      return false;
                    }
                  }';
			          }
              break;              
            }
            case 'type_number': {
              $params_names = array('w_field_label_size', 'w_field_label_pos', 'w_size', 'w_first_val', 'w_title', 'w_required', 'w_unique', 'w_class');
              $temp = $params;
              foreach ($params_names as $params_name) {
                $temp = explode('*:*' . $params_name . '*:*', $temp);
                $param[$params_name] = $temp[0];
                $temp = $temp[1];
              }
              if ($temp) {
                $temp	= explode('*:*w_attr_name*:*', $temp);
                $attrs = array_slice($temp, 0, count($temp) - 1);   
                foreach ($attrs as $attr) {
                  $param['attributes'] = $param['attributes'].' '.$attr;
                }
              }
              $param['w_first_val']=(isset($_POST['wdform_'.$id1.'_element'.$form_id]) ? $_POST['wdform_'.$id1.'_element'.$form_id] : $param['w_first_val']);
              $wdformfieldsize = ($param['w_field_label_pos'] == "left" ? $param['w_field_label_size']+$param['w_size'] + 10 : max($param['w_field_label_size'],$param['w_size']));	
              $param['w_field_label_pos1'] = ($param['w_field_label_pos'] == "left" ? "float: left;" : "");
              $param['w_field_label_pos2'] = ($param['w_field_label_pos'] == "left" ? "" : "display:block;");
              $input_active = ($param['w_first_val'] == $param['w_title'] ? "input_deactive" : "input_active");
              $required = ($param['w_required'] == "yes" ? TRUE : FALSE);
              $rep = '<div type="type_number" class="wdform-field" style="width:'.$wdformfieldsize.'px"><div class="wdform-label-section"  class="'.$param['w_class'].'" style="'.$param['w_field_label_pos1'].' width: '.$param['w_field_label_size'].'px;"><span class="wdform-label">'.$label.'</span>';
              if ($required) {
                $rep .= '<span class="wdform-required">' . $required_sym . '</span>';
              }
              $rep .= '</div><div class="wdform-element-section '.$param['w_class'].'" style="'.$param['w_field_label_pos2'].' width: '.$param['w_size'].'px;"><input type="text" class="'.$input_active.'" id="wdform_'.$id1.'_element'.$form_id.'" name="wdform_'.$id1.'_element'.$form_id.'" value="'.$param['w_first_val'].'" title="'.$param['w_title'].'" style="width: 100%;" '.$param['attributes'].'></div></div>';
              if ($required) {
                $check_js .= '
                if (x.find(jQuery("div[wdid='.$id1.']")).length != 0) {
                  if (jQuery("#wdform_'.$id1.'_element'.$form_id.'").val()=="'.$param['w_title'].'" || jQuery("#wdform_'.$id1.'_element'.$form_id.'").val()=="") {
                    alert("' .addslashes($label. ' ' . __('field is required.', 'contact_form_maker')) . '");
                    jQuery("#wdform_'.$id1.'_element'.$form_id.'").addClass( "form-error" );
                    old_bg=x.find(jQuery("div[wdid='.$id1.']")).css("background-color");
                    x.find(jQuery("div[wdid='.$id1.']")).effect( "shake", {}, 500 ).css("background-color","#FF8F8B").animate({backgroundColor: old_bg}, {duration: 500, queue: false });
                    jQuery("#wdform_'.$id1.'_element'.$form_id.'").focus();
                    jQuery("#wdform_'.$id1.'_element'.$form_id.'").change(function() { if( jQuery(this).val()!="" ) jQuery(this).removeClass("form-error"); else jQuery(this).addClass("form-error");});
                    return false;
                  }
                }';
              }
              break;
            }
            case 'type_password': {
              $params_names = array('w_field_label_size', 'w_field_label_pos', 'w_size', 'w_required', 'w_unique', 'w_class');
              $temp = $params;
              foreach ($params_names as $params_name) {
                $temp = explode('*:*' . $params_name . '*:*', $temp);
                $param[$params_name] = $temp[0];
                $temp = $temp[1];
              }
              if ($temp) {
                $temp	= explode('*:*w_attr_name*:*', $temp);
                $attrs = array_slice($temp, 0, count($temp) - 1);
                foreach ($attrs as $attr) {
                  $param['attributes'] = $param['attributes'].' '.$attr;
                }
              }
              $wdformfieldsize = ($param['w_field_label_pos'] == "left" ? $param['w_field_label_size']+$param['w_size'] + 10 : max($param['w_field_label_size'],$param['w_size']));	
              $param['w_field_label_pos1'] = ($param['w_field_label_pos'] == "left" ? "float: left;" : "");	
              $param['w_field_label_pos2'] = ($param['w_field_label_pos'] == "left" ? "" : "display: block;");
              $required = ($param['w_required'] == "yes" ? TRUE : FALSE);	
              $rep = '<div type="type_password" class="wdform-field" style="width:'.$wdformfieldsize.'px"><div class="wdform-label-section"  class="'.$param['w_class'].'" style="'.$param['w_field_label_pos1'].'; width: '.$param['w_field_label_size'].'px;"><span class="wdform-label">'.$label.'</span>';
              if ($required) {
                $rep .= '<span class="wdform-required">'.$required_sym.'</span>';
              }
              $rep .= '</div><div class="wdform-element-section '.$param['w_class'].'" style="'.$param['w_field_label_pos2'].' width: '.$param['w_size'].'px;"><input type="password" id="wdform_'.$id1.'_element'.$form_id.'" name="wdform_'.$id1.'_element'.$form_id.'" style="width: 100%;" '.$param['attributes'].'></div></div>';
              if ($required) {
                $check_js .= '
                if (x.find(jQuery("div[wdid='.$id1.']")).length != 0) {
                  if (jQuery("#wdform_'.$id1.'_element'.$form_id.'").val()=="") {
                    alert("' .addslashes($label. ' ' . __('field is required.', 'contact_form_maker')) . '");
                    jQuery("#wdform_'.$id1.'_element'.$form_id.'").addClass( "form-error" );
                    old_bg=x.find(jQuery("div[wdid='.$id1.']")).css("background-color");
                    x.find(jQuery("div[wdid='.$id1.']")).effect( "shake", {}, 500 ).css("background-color","#FF8F8B").animate({backgroundColor: old_bg}, {duration: 500, queue: false });
                    jQuery("#wdform_'.$id1.'_element'.$form_id.'").focus();
                    jQuery("#wdform_'.$id1.'_element'.$form_id.'").change(function() { if( jQuery(this).val()!="" ) jQuery(this).removeClass("form-error"); else jQuery(this).addClass("form-error");});
                    return false;
                  }
                }';
              }
              break;
            }
            case 'type_textarea': {
              $params_names = array('w_field_label_size', 'w_field_label_pos', 'w_size_w', 'w_size_h', 'w_first_val', 'w_title', 'w_required', 'w_unique', 'w_class');
              $temp = $params;
              foreach ($params_names as $params_name ) {
                $temp = explode('*:*' . $params_name . '*:*', $temp);
                $param[$params_name] = $temp[0];
                $temp = $temp[1];
              }
              if ($temp) {
                $temp	= explode('*:*w_attr_name*:*', $temp);
                $attrs = array_slice($temp, 0, count($temp) - 1);
                foreach ($attrs as $attr) {
                  $param['attributes'] = $param['attributes'].' '.$attr;
                }
              }
              $param['w_first_val'] = (isset($_POST['wdform_'.$id1.'_element'.$form_id]) ? $_POST['wdform_'.$id1.'_element'.$form_id] : $param['w_first_val']);			
              $wdformfieldsize = ($param['w_field_label_pos'] == "left" ? $param['w_field_label_size']+$param['w_size_w'] + 10 : max($param['w_field_label_size'],$param['w_size_w']));	
              $param['w_field_label_pos1'] = ($param['w_field_label_pos'] == "left" ? "float: left;" : "");
              $param['w_field_label_pos2'] = ($param['w_field_label_pos'] == "left" ? "" : "display:block;");
              $input_active = ($param['w_first_val'] == $param['w_title'] ? "input_deactive" : "input_active");
              $required = ($param['w_required'] == "yes" ? TRUE : FALSE);	
              $rep ='<div type="type_textarea" class="wdform-field"  style="width:'.$wdformfieldsize.'px"><div class="wdform-label-section" style="'.$param['w_field_label_pos1'].'; width: '.$param['w_field_label_size'].'px;"><span class="wdform-label">'.$label.'</span>';
              if ($required) {
                $rep .= '<span class="wdform-required">' . $required_sym . '</span>';
              }
              $rep .= '</div><div class="wdform-element-section '.$param['w_class'].'" style="'.$param['w_field_label_pos2'].' width: '.$param['w_size_w'].'px"><textarea class="'.$input_active.'" id="wdform_'.$id1.'_element'.$form_id.'" name="wdform_'.$id1.'_element'.$form_id.'" title="'.$param['w_title'].'"  style="width: 100%; height: '.$param['w_size_h'].'px;" '.$param['attributes'].'>'.$param['w_first_val'].'</textarea></div></div>';
              if ($required) {
                $check_js .= '
                if (x.find(jQuery("div[wdid='.$id1.']")).length != 0) {
                  if (jQuery("#wdform_'.$id1.'_element'.$form_id.'").val()=="'.$param['w_title'].'" || jQuery("#wdform_'.$id1.'_element'.$form_id.'").val()=="") {
                    alert("' .addslashes($label. ' ' . __('field is required.', 'contact_form_maker')) . '");
                    jQuery("#wdform_'.$id1.'_element'.$form_id.'").addClass( "form-error" );
                    old_bg=x.find(jQuery("div[wdid='.$id1.']")).css("background-color");
                    x.find(jQuery("div[wdid='.$id1.']")).effect( "shake", {}, 500 ).css("background-color","#FF8F8B").animate({backgroundColor: old_bg}, {duration: 500, queue: false });
                    jQuery("#wdform_'.$id1.'_element'.$form_id.'").focus();
                    jQuery("#wdform_'.$id1.'_element'.$form_id.'").change(function() { if( jQuery(this).val()!="" ) jQuery(this).removeClass("form-error"); else jQuery(this).addClass("form-error");});
                    return false;
                  }
                }';
              }
              break;
            }
            case 'type_wdeditor': {
              $params_names = array('w_field_label_size', 'w_field_label_pos', 'w_size_w', 'w_size_h', 'w_title', 'w_required', 'w_class');
              $temp = $params;
              foreach ($params_names as $params_name ) {
                $temp = explode('*:*' . $params_name . '*:*', $temp);
                $param[$params_name] = $temp[0];
                $temp = $temp[1];
              }
              if ($temp) {
                $temp	= explode('*:*w_attr_name*:*', $temp);
                $attrs = array_slice($temp, 0, count($temp) - 1);   
                foreach($attrs as $attr) {
                  $param['attributes'] = $param['attributes'].' '.$attr;
                }
              }
              $wdformfieldsize = ($param['w_field_label_pos'] == "left" ? $param['w_field_label_size']+$param['w_size_w']+10 : max($param['w_field_label_size'],$param['w_size_w']));	
              $param['w_field_label_pos1'] = ($param['w_field_label_pos'] == "left" ? "float: left;" : "");	
              $param['w_field_label_pos2'] = ($param['w_field_label_pos'] == "left" ? "" : "display: block;");
              $required = ($param['w_required'] == "yes" ? TRUE : FALSE);
              $rep = '<div type="type_wdeditor" class="wdform-field"  style="width:'.$wdformfieldsize.'px"><div class="wdform-label-section" style="'.$param['w_field_label_pos1'].'; width: '.$param['w_field_label_size'].'px;"><span class="wdform-label">'.$label.'</span>';
              if ($required) {
                $rep .= '<span class="wdform-required">' . $required_sym . '</span>';
              }
              $rep .= '</div><div class="wdform-element-section '.$param['w_class'].'" style="'.$param['w_field_label_pos2'].' width: '.$param['w_size_w'].'px">';
              if (user_can_richedit()) {
                ob_start();
                wp_editor($param['w_title'], 'wdform_'.$id1.'_wd_editor'.$form_id, array('teeny' => FALSE, 'media_buttons' => FALSE, 'textarea_rows' => 5));
                $wd_editor = ob_get_clean();
              }
              else {
                $wd_editor = '<textarea  class="'.$param['w_class'].'" name="wdform_'.$id1.'_wd_editor'.$form_id.'" id="wdform_'.$id1.'_wd_editor'.$form_id.'" style="width: '.$param['w_size_w'].'px; height: '.$param['w_size_h'].'px; " class="mce_editable" aria-hidden="true">'.$param['w_title'].'</textarea>';
              }
              $rep .= $wd_editor . '</div></div>';
              if ($required) {
                $check_js .= '
                if (x.find(jQuery("div[wdid='.$id1.']")).length != 0) {
                  if (tinyMCE.get("wdform_'.$id1.'_wd_editor'.$form_id.'").getContent()=="") {
                    alert("' .addslashes($label. ' ' . __('field is required.', 'contact_form_maker')) . '");
                    jQuery("#wdform_'.$id1.'_wd_editor'.$form_id.'").addClass( "form-error" );
                    old_bg=x.find(jQuery("div[wdid='.$id1.']")).css("background-color");
                    x.find(jQuery("div[wdid='.$id1.']")).effect( "shake", {}, 500 ).css("background-color","#FF8F8B").animate({backgroundColor: old_bg}, {duration: 500, queue: false });
                    jQuery("#wdform_'.$id1.'_wd_editor'.$form_id.'").focus();
                    jQuery("#wdform_'.$id1.'_wd_editor'.$form_id.'").change(function() { if( jQuery(this).val()!="" ) jQuery(this).removeClass("form-error"); else jQuery(this).addClass("form-error");});
                    return false;
                  }
                }';
              }             
              break;
            }
            case 'type_phone': {
              $params_names = array('w_field_label_size', 'w_field_label_pos', 'w_size', 'w_first_val', 'w_title', 'w_mini_labels', 'w_required', 'w_unique', 'w_class');
              $temp = $params;
              foreach ($params_names as $params_name ) {
                $temp = explode('*:*' . $params_name . '*:*', $temp);
                $param[$params_name] = $temp[0];
                $temp = $temp[1];
              }
              if ($temp) {
                $temp	= explode('*:*w_attr_name*:*', $temp);
                $attrs = array_slice($temp, 0, count($temp) - 1);   
                foreach($attrs as $attr) {
                  $param['attributes'] = $param['attributes'] . ' ' . $attr;
                }
              }
              $w_first_val = explode('***', $param['w_first_val']);
              $w_title = explode('***', $param['w_title']);
              $param['w_first_val'] = (isset($_POST['wdform_'.$id1.'_element_first'.$form_id]) ? $_POST['wdform_'.$id1.'_element_first'.$form_id] : $w_first_val[0]).'***'.(isset($_POST['wdform_'.$id1.'_element_last'.$form_id]) ? $_POST['wdform_'.$id1.'_element_last'.$form_id] : $w_first_val[1]);
              $wdformfieldsize = ($param['w_field_label_pos'] == "left" ? ($param['w_field_label_size']+$param['w_size']+65) : max($param['w_field_label_size'],($param['w_size']+65)));	
              $param['w_field_label_pos1'] = ($param['w_field_label_pos']=="left" ? "float: left;" : "");	
              $param['w_field_label_pos2'] = ($param['w_field_label_pos']=="left" ? "" : "display:block;");
              $input_active = ($param['w_first_val'] == $param['w_title'] ? "input_deactive" : "input_active");	
              $required = $param['w_required'] == "yes" ? TRUE : FALSE;
              $w_first_val = explode('***',$param['w_first_val']);
              $w_title = explode('***', $param['w_title']);
              $w_mini_labels = explode('***', $param['w_mini_labels']);
              $rep = '<div type="type_phone" class="wdform-field" style="width:'.$wdformfieldsize.'px"><div class="wdform-label-section '.$param['w_class'].'" style="'.$param['w_field_label_pos1'].'; width: '.$param['w_field_label_size'].'px;"><span class="wdform-label" >'.$label.'</span>';
              if ($required) {
                $rep .= '<span class="wdform-required">' . $required_sym . '</span>';
              }
              $rep .= '
              </div>
              <div class="wdform-element-section '.$param['w_class'].'" style="'.$param['w_field_label_pos2'].' width: '.($param['w_size']+65).'px;">
                <div style="display: table-cell;vertical-align: middle;">
                  <div><input type="text" class="'.$input_active.'" id="wdform_'.$id1.'_element_first'.$form_id.'" name="wdform_'.$id1.'_element_first'.$form_id.'" value="'.$w_first_val[0].'" title="'.$w_title[0].'" style="width: 50px;" '.$param['attributes'].'></div>
                  <div><label class="mini_label">'.$w_mini_labels[0].'</label></div>
                </div>
                <div style="display: table-cell;vertical-align: middle;">
                  <div class="wdform_line" style="margin: 0px 4px 10px 4px; padding: 0px;">-</div>
                </div>
                <div style="display: table-cell;vertical-align: middle; width:100%;">
                  <div><input type="text" class="'.$input_active.'" id="wdform_'.$id1.'_element_last'.$form_id.'" name="wdform_'.$id1.'_element_last'.$form_id.'" value="'.$w_first_val[1].'" title="'.$w_title[1].'" style="width: 100%;" '.$param['attributes'].'></div>
                  <div><label class="mini_label">'.$w_mini_labels[1].'</label></div>
                </div>
              </div>
              </div>';
              if ($required) {
                $check_js .= '
                if (x.find(jQuery("div[wdid='.$id1.']")).length != 0) {
                  if (jQuery("#wdform_'.$id1.'_element_first'.$form_id.'").val()=="'.$w_title[0].'" || jQuery("#wdform_'.$id1.'_element_first'.$form_id.'").val()=="" || jQuery("#wdform_'.$id1.'_element_last'.$form_id.'").val()=="'.$w_title[1].'" || jQuery("#wdform_'.$id1.'_element_last'.$form_id.'").val()=="") {
                    alert("' .addslashes($label. ' ' . __('field is required.', 'contact_form_maker')) . '");
                    old_bg=x.find(jQuery("div[wdid='.$id1.']")).css("background-color");
                    x.find(jQuery("div[wdid='.$id1.']")).effect( "shake", {}, 500 ).css("background-color","#FF8F8B").animate({backgroundColor: old_bg}, {duration: 500, queue: false });
                    jQuery("#wdform_'.$id1.'_element_first'.$form_id.'").focus();
                    return false;
                  }
                }';
              }
              break;
            }
            case 'type_name': {
              $params_names = array('w_field_label_size', 'w_field_label_pos', 'w_first_val', 'w_title', 'w_mini_labels', 'w_size', 'w_name_format', 'w_required', 'w_unique', 'w_class');
              $temp = $params;
              foreach ($params_names as $params_name) {
                $temp = explode('*:*'.$params_name.'*:*', $temp);
                $param[$params_name] = $temp[0];
                $temp = $temp[1];
              }
              if ($temp) {	
                $temp	= explode('*:*w_attr_name*:*', $temp);
                $attrs	= array_slice($temp, 0, count($temp) - 1);   
                foreach($attrs as $attr) {
                  $param['attributes'] = $param['attributes'].' '.$attr;
                }
              }
              $w_first_val = explode('***', $param['w_first_val']);
              $w_title = explode('***', $param['w_title']);
              $w_mini_labels = explode('***', $param['w_mini_labels']);
              $element_title = isset($_POST['wdform_'.$id1.'_element_title'.$form_id]) ? $_POST['wdform_'.$id1.'_element_title'.$form_id] : NULL;
              $element_first = isset($_POST['wdform_'.$id1.'_element_first'.$form_id]) ? $_POST['wdform_'.$id1.'_element_first'.$form_id] : NULL;
              if (isset($element_title)) {
                $param['w_first_val'] = (isset($_POST['wdform_'.$id1.'_element_title'.$form_id]) ? $_POST['wdform_'.$id1.'_element_title'.$form_id] : $w_first_val[0]).'***'.(isset($_POST['wdform_'.$id1.'_element_first'.$form_id]) ? $_POST['wdform_'.$id1.'_element_first'.$form_id] : $w_first_val[1]).'***'.(isset($_POST['wdform_'.$id1.'_element_last'.$form_id]) ? $_POST['wdform_'.$id1.'_element_last'.$form_id] : $w_first_val[2]).'***'.(isset($_POST['wdform_'.$id1.'_element_middle'.$form_id]) ? $_POST['wdform_'.$id1.'_element_middle'.$form_id] : $w_first_val[3]);
              }
              else {
                if (isset($element_first)) {
                  $param['w_first_val'] = (isset($_POST['wdform_'.$id1.'_element_first'.$form_id]) ? $_POST['wdform_'.$id1.'_element_first'.$form_id] : $w_first_val[0]).'***'.(isset($_POST['wdform_'.$id1.'_element_last'.$form_id]) ? $_POST['wdform_'.$id1.'_element_last'.$form_id] : $w_first_val[1]);
                }
              }
              $input_active = ($param['w_first_val'] == $param['w_title'] ? "input_deactive" : "input_active");
              $required = ($param['w_required'] == "yes" ? TRUE : FALSE);	
              $w_first_val = explode('***', $param['w_first_val']);
              $w_title = explode('***', $param['w_title']);
              if ($param['w_name_format'] == 'normal') {
                $w_name_format = '
                <div style="display: table-cell; width:50%">
                  <div><input type="text" class="'.$input_active.'" id="wdform_'.$id1.'_element_first'.$form_id.'" name="wdform_'.$id1.'_element_first'.$form_id.'" value="'.$w_first_val[0].'" title="'.$w_title[0].'"  style="width: 100%;"'.$param['attributes'].'></div>
                  <div><label class="mini_label">'.$w_mini_labels[1].'</label></div>
                </div>
                <div style="display:table-cell;"><div style="margin: 0px 8px; padding: 0px;"></div></div>
                <div  style="display: table-cell; width:50%">
                  <div><input type="text" class="'.$input_active.'" id="wdform_'.$id1.'_element_last'.$form_id.'" name="wdform_'.$id1.'_element_last'.$form_id.'" value="'.$w_first_val[1].'" title="'.$w_title[1].'" style="width: 100%;" '.$param['attributes'].'></div>
                  <div><label class="mini_label">'.$w_mini_labels[2].'</label></div>
                </div>';
                $w_size = 2 * $param['w_size'];
              }
              else {
                $w_name_format = '
                <div style="display: table-cell;">
                  <div><input type="text" class="'.$input_active.'" id="wdform_'.$id1.'_element_title'.$form_id.'" name="wdform_'.$id1.'_element_title'.$form_id.'" value="'.$w_first_val[0].'" title="'.$w_title[0].'" style="width: 40px;"></div>
                  <div><label class="mini_label">'.$w_mini_labels[0].'</label></div>
                </div>
                <div style="display:table-cell;"><div style="margin: 0px 1px; padding: 0px;"></div></div>
                <div style="display: table-cell; width:30%">
                  <div><input type="text" class="'.$input_active.'" id="wdform_'.$id1.'_element_first'.$form_id.'" name="wdform_'.$id1.'_element_first'.$form_id.'" value="'.$w_first_val[1].'" title="'.$w_title[1].'" style="width:100%;"></div>
                  <div><label class="mini_label">'.$w_mini_labels[1].'</label></div>
                </div>
                <div style="display:table-cell;"><div style="margin: 0px 4px; padding: 0px;"></div></div>
                <div style="display: table-cell; width:30%">
                  <div><input type="text" class="'.$input_active.'" id="wdform_'.$id1.'_element_last'.$form_id.'" name="wdform_'.$id1.'_element_last'.$form_id.'" value="'.$w_first_val[2].'" title="'.$w_title[2].'" style="width:  100%;"></div>
                  <div><label class="mini_label">'.$w_mini_labels[2].'</label></div>
                </div>
                <div style="display:table-cell;"><div style="margin: 0px 4px; padding: 0px;"></div></div>
                <div style="display: table-cell; width:30%">
                  <div><input type="text" class="'.$input_active.'" id="wdform_'.$id1.'_element_middle'.$form_id.'" name="wdform_'.$id1.'_element_middle'.$form_id.'" value="'.$w_first_val[3].'" title="'.$w_title[3].'" style="width: 100%;"></div>
                  <div><label class="mini_label">'.$w_mini_labels[3].'</label></div>
                </div>';
                $w_size = 3 * $param['w_size'] + 80;
              }
              $wdformfieldsize = ($param['w_field_label_pos'] == "left" ? ($param['w_field_label_size']+$w_size) : max($param['w_field_label_size'],$w_size));	
              $param['w_field_label_pos1'] = ($param['w_field_label_pos'] == "left" ? "float: left;" : "");	
              $param['w_field_label_pos2'] = ($param['w_field_label_pos'] == "left" ? "" : "display: block;");
              $rep = '<div type="type_name" class="wdform-field"  style="width:'.$wdformfieldsize.'px"><div class="wdform-label-section" style="'.$param['w_field_label_pos1'].'; width: '.$param['w_field_label_size'].'px;"><span class="wdform-label">'.$label.'</span>';
              if ($required) {
                $rep .= '<span class="wdform-required">' . $required_sym . '</span>';
              }
              $rep .= '</div>
              <div class="wdform-element-section '.$param['w_class'].'" style="'.$param['w_field_label_pos2'].' width: '.$w_size.'px;">'.$w_name_format.'</div></div>';
              if ($required) {
                if ($param['w_name_format'] == 'normal') {
                  $check_js .= '
                  if (x.find(jQuery("div[wdid='.$id1.']")).length != 0) {
                    if (jQuery("#wdform_'.$id1.'_element_first'.$form_id.'").val()=="'.$w_title[0].'" || jQuery("#wdform_'.$id1.'_element_first'.$form_id.'").val()=="" || jQuery("#wdform_'.$id1.'_element_last'.$form_id.'").val()=="'.$w_title[1].'" || jQuery("#wdform_'.$id1.'_element_last'.$form_id.'").val()=="") {
                      alert("' .addslashes($label. ' ' . __('field is required.', 'contact_form_maker')) . '");
                      old_bg=x.find(jQuery("div[wdid='.$id1.']")).css("background-color");
                      x.find(jQuery("div[wdid='.$id1.']")).effect( "shake", {}, 500 ).css("background-color","#FF8F8B").animate({backgroundColor: old_bg}, {duration: 500, queue: false });
                      jQuery("#wdform_'.$id1.'_element_first'.$form_id.'").focus();
                      return false;
                    }
                  }';	
                }
                else {
                  $check_js .= '
                  if (x.find(jQuery("div[wdid='.$id1.']")).length != 0) {
                    if (jQuery("#wdform_'.$id1.'_element_title'.$form_id.'").val()=="'.$w_title[0].'" || jQuery("#wdform_'.$id1.'_element_title'.$form_id.'").val()=="" || jQuery("#wdform_'.$id1.'_element_first'.$form_id.'").val()=="'.$w_title[1].'" || jQuery("#wdform_'.$id1.'_element_first'.$form_id.'").val()=="" || jQuery("#wdform_'.$id1.'_element_last'.$form_id.'").val()=="'.$w_title[2].'" || jQuery("#wdform_'.$id1.'_element_last'.$form_id.'").val()=="" || jQuery("#wdform_'.$id1.'_element_middle'.$form_id.'").val()=="'.$w_title[3].'" || jQuery("#wdform_'.$id1.'_element_middle'.$form_id.'").val()=="") {
                      alert("' .addslashes($label. ' ' . __('field is required.', 'contact_form_maker')) . '");
                      old_bg=x.find(jQuery("div[wdid='.$id1.']")).css("background-color");
                      x.find(jQuery("div[wdid='.$id1.']")).effect( "shake", {}, 500 ).css("background-color","#FF8F8B").animate({backgroundColor: old_bg}, {duration: 500, queue: false });
                      jQuery("#wdform_'.$id1.'_element_first'.$form_id.'").focus();
                      return false;
                    }
                  }';		
                }
              }
              break;
            }
            case 'type_address': {
              $params_names = array('w_field_label_size', 'w_field_label_pos', 'w_size', 'w_mini_labels', 'w_disabled_fields', 'w_required', 'w_class');
              $temp = $params;
              foreach ($params_names as $params_name ) {
                $temp = explode('*:*' . $params_name . '*:*', $temp);
                $param[$params_name] = $temp[0];
                $temp = $temp[1];
              }
              if ($temp) {
                $temp	= explode('*:*w_attr_name*:*', $temp);
                $attrs = array_slice($temp, 0, count($temp) - 1);   
                foreach($attrs as $attr) {
                  $param['attributes'] = $param['attributes'] . ' ' . $attr;
                }
              }
              $wdformfieldsize = ($param['w_field_label_pos'] == "left" ? ($param['w_field_label_size']+$param['w_size']) : max($param['w_field_label_size'], $param['w_size']));	
              $param['w_field_label_pos1'] = ($param['w_field_label_pos']=="left" ? "float: left;" : "");	
              $param['w_field_label_pos2'] = ($param['w_field_label_pos']=="left" ? "" : "display: block;");
              $required = ($param['w_required'] == "yes" ? TRUE : FALSE);
              $w_mini_labels = explode('***', $param['w_mini_labels']);
              $w_disabled_fields = explode('***', $param['w_disabled_fields']);
              $rep = '<div type="type_address" class="wdform-field"  style="width:'.$wdformfieldsize.'px"><div class="wdform-label-section" style="'.$param['w_field_label_pos1'].'; width: '.$param['w_field_label_size'].'px;"><span class="wdform-label">'.$label.'</span>';
              if ($required) {
                $rep .= '<span class="wdform-required">'.$required_sym.'</span>';
              }
              $address_fields = '';
              $g = 0;
              if (isset($w_disabled_fields[0]) && $w_disabled_fields[0] == 'no') {
                $g += 2;
                $address_fields .= '<span style="float: left; width: 100%; padding-bottom: 8px; display: block;"><input type="text" id="wdform_'.$id1.'_street1'.$form_id.'" name="wdform_'.$id1.'_street1'.$form_id.'" value="'.(isset($_POST['wdform_'.$id1.'_street1'.$form_id]) ? $_POST['wdform_'.$id1.'_street1'.$form_id] : "").'" style="width: 100%;" '.$param['attributes'].'><label class="mini_label" >'.$w_mini_labels[0].'</label></span>';
              }
              if (isset($w_disabled_fields[1]) && $w_disabled_fields[1] == 'no') {
                $g += 2;
                $address_fields .= '<span style="float: left; width: 100%; padding-bottom: 8px; display: block;"><input type="text" id="wdform_'.$id1.'_street2'.$form_id.'" name="wdform_'.($id1+1).'_street2'.$form_id.'" value="'.(isset($_POST['wdform_'.($id1+1).'_street2'.$form_id]) ? $_POST['wdform_'.($id1+1).'_street2'.$form_id] : "").'" style="width: 100%;" '.$param['attributes'].'><label class="mini_label" >'.$w_mini_labels[1].'</label></span>';
              }
              if (isset($w_disabled_fields[2]) && $w_disabled_fields[2]=='no') {
                $g++;
                $address_fields .= '<span style="float: left; width: 48%; padding-bottom: 8px;"><input type="text" id="wdform_'.$id1.'_city'.$form_id.'" name="wdform_'.($id1+2).'_city'.$form_id.'" value="'.(isset($_POST['wdform_'.($id1+2).'_city'.$form_id]) ? $_POST['wdform_'.($id1+2).'_city'.$form_id] : "").'" style="width: 100%;" '.$param['attributes'].'><label class="mini_label" >'.$w_mini_labels[2].'</label></span>';
              }
              if (isset($w_disabled_fields[3]) && $w_disabled_fields[3] == 'no') {
                $g++;
                $w_states = array("", "Alabama", "Alaska", "Arizona", "Arkansas", "California", "Colorado", "Connecticut", "Delaware","District Of Columbia","Florida","Georgia","Hawaii","Idaho","Illinois","Indiana","Iowa","Kansas","Kentucky","Louisiana","Maine","Maryland","Massachusetts","Michigan","Minnesota","Mississippi","Missouri","Montana","Nebraska","Nevada","New Hampshire","New Jersey","New Mexico","New York","North Carolina","North Dakota","Ohio","Oklahoma","Oregon","Pennsylvania","Rhode Island","South Carolina","South Dakota","Tennessee","Texas","Utah","Vermont","Virginia","Washington","West Virginia","Wisconsin","Wyoming");	
                $w_state_options = '';
                $post_state = isset($_POST['wdform_'.($id1+3).'_state'.$form_id]) ? $_POST['wdform_'.($id1+3).'_state'.$form_id] : "";
                foreach ($w_states as $w_state) {
                  if ($w_state == $post_state) {
                    $selected = 'selected="selected"';
                  }
                  else {
                    $selected = '';
                  }
                  $w_state_options .= '<option value="'.$w_state.'" '.$selected.'>'.$w_state.'</option>';
                }
                if (isset($w_disabled_fields[5]) && $w_disabled_fields[5] == 'yes' && isset($w_disabled_fields[6]) && $w_disabled_fields[6] == 'yes') {
                  $address_fields .= '<span style="float: '.(($g%2==0) ? 'right' : 'left').'; width: 48%; padding-bottom: 8px;"><select type="text" id="wdform_'.$id1.'_state'.$form_id.'" name="wdform_'.($id1+3).'_state'.$form_id.'" style="width: 100%;" '.$param['attributes'].'>'.$w_state_options.'</select><label class="mini_label" style="display: block;" id="'.$id1.'_mini_label_state">'.$w_mini_labels[3].'</label></span>';
                }
                else {
                  $address_fields .= '<span style="float: '.(($g%2==0) ? 'right' : 'left').'; width: 48%; padding-bottom: 8px;"><input type="text" id="wdform_'.$id1.'_state'.$form_id.'" name="wdform_'.($id1+3).'_state'.$form_id.'" value="'.(isset($_POST['wdform_'.($id1+3).'_state'.$form_id]) ? $_POST['wdform_'.($id1+3).'_state'.$form_id] : "").'" style="width: 100%;" '.$param['attributes'].'><label class="mini_label">'.$w_mini_labels[3].'</label></span>';
                }
              }
              if (isset($w_disabled_fields[4]) && $w_disabled_fields[4]=='no') {
                $g++;
                $address_fields .= '<span style="float: '.(($g%2==0) ? 'right' : 'left').'; width: 48%; padding-bottom: 8px;"><input type="text" id="wdform_'.$id1.'_postal'.$form_id.'" name="wdform_'.($id1+4).'_postal'.$form_id.'" value="'.(isset($_POST['wdform_'.($id1+4).'_postal'.$form_id]) ? $_POST['wdform_'.($id1+4).'_postal'.$form_id] : "").'" style="width: 100%;" '.$param['attributes'].'><label class="mini_label">'.$w_mini_labels[4].'</label></span>';
              }
              $w_countries = array("","Afghanistan","Albania","Algeria","Andorra","Angola","Antigua and Barbuda","Argentina","Armenia","Australia","Austria","Azerbaijan","Bahamas","Bahrain","Bangladesh","Barbados","Belarus","Belgium","Belize","Benin","Bhutan","Bolivia","Bosnia and Herzegovina","Botswana","Brazil","Brunei","Bulgaria","Burkina Faso","Burundi","Cambodia","Cameroon","Canada","Cape Verde","Central African Republic","Chad","Chile","China","Colombi","Comoros","Congo (Brazzaville)","Congo","Costa Rica","Cote d'Ivoire","Croatia","Cuba","Cyprus","Czech Republic","Denmark","Djibouti","Dominica","Dominican Republic","East Timor (Timor Timur)","Ecuador","Egypt","El Salvador","Equatorial Guinea","Eritrea","Estonia","Ethiopia","Fiji","Finland","France","Gabon","Gambia, The","Georgia","Germany","Ghana","Greece","Grenada","Guatemala","Guinea","Guinea-Bissau","Guyana","Haiti","Honduras","Hungary","Iceland","India","Indonesia","Iran","Iraq","Ireland","Israel","Italy","Jamaica","Japan","Jordan","Kazakhstan","Kenya","Kiribati","Korea, North","Korea, South","Kuwait","Kyrgyzstan","Laos","Latvia","Lebanon","Lesotho","Liberia","Libya","Liechtenstein","Lithuania","Luxembourg","Macedonia","Madagascar","Malawi","Malaysia","Maldives","Mali","Malta","Marshall Islands","Mauritania","Mauritius","Mexico","Micronesia","Moldova","Monaco","Mongolia","Morocco","Mozambique","Myanmar","Namibia","Nauru","Nepa","Netherlands","New Zealand","Nicaragua","Niger","Nigeria","Norway","Oman","Pakistan","Palau","Panama","Papua New Guinea","Paraguay","Peru","Philippines","Poland","Portugal","Qatar","Romania","Russia","Rwanda","Saint Kitts and Nevis","Saint Lucia","Saint Vincent","Samoa","San Marino","Sao Tome and Principe","Saudi Arabia","Senegal","Serbia and Montenegro","Seychelles","Sierra Leone","Singapore","Slovakia","Slovenia","Solomon Islands","Somalia","South Africa","Spain","Sri Lanka","Sudan","Suriname","Swaziland","Sweden","Switzerland","Syria","Taiwan","Tajikistan","Tanzania","Thailand","Togo","Tonga","Trinidad and Tobago","Tunisia","Turkey","Turkmenistan","Tuvalu","Uganda","Ukraine","United Arab Emirates","United Kingdom","United States","Uruguay","Uzbekistan","Vanuatu","Vatican City","Venezuela","Vietnam","Yemen","Zambia","Zimbabwe");	
              $w_options = '';
              $post_country = isset($_POST['wdform_'.($id1+5).'_country'.$form_id]) ? $_POST['wdform_'.($id1+5).'_country'.$form_id] : "";
              foreach ($w_countries as $w_country) {              
                if ($w_country == $post_country) {
                  $selected = 'selected="selected"';
                }
                else {
                  $selected = '';
                }
                $w_options .= '<option value="'.$w_country.'" '.$selected.'>'.$w_country.'</option>';
              }
              if (isset($w_disabled_fields[5]) && $w_disabled_fields[5] == 'no') {
                $g++;
                $address_fields .= '<span style="float: '.(($g % 2 == 0) ? 'right' : 'left').'; width: 48%; padding-bottom: 8px;display: inline-block;"><select type="text" id="wdform_'.$id1.'_country'.$form_id.'" name="wdform_'.($id1+5).'_country'.$form_id.'" style="width:100%" '.$param['attributes'].'>'.$w_options.'</select><label class="mini_label">'.$w_mini_labels[5].'</label></span>';
              }				
              $rep .= '</div><div class="wdform-element-section '.$param['w_class'].'" style="'.$param['w_field_label_pos2'].' width: '.$param['w_size'].'px;"><div>
              '.$address_fields.'</div></div></div>';
              if ($required) {
                $check_js .= '
                if (x.find(jQuery("div[wdid='.$id1.']")).length != 0) {
                  if (jQuery("#wdform_'.$id1.'_street1'.$form_id.'").val()=="" || jQuery("#wdform_'.$id1.'_street2'.$form_id.'").val()=="" || jQuery("#wdform_'.$id1.'_city'.$form_id.'").val()=="" || jQuery("#wdform_'.$id1.'_state'.$form_id.'").val()=="" || jQuery("#wdform_'.$id1.'_postal'.$form_id.'").val()=="" || jQuery("#wdform_'.$id1.'_country'.$form_id.'").val()=="") {
                    alert("' .addslashes($label. ' ' . __('field is required.', 'contact_form_maker')) . '");
                    old_bg=x.find(jQuery("div[wdid='.$id1.']")).css("background-color");
                    x.find(jQuery("div[wdid='.$id1.']")).effect( "shake", {}, 500 ).css("background-color","#FF8F8B").animate({backgroundColor: old_bg}, {duration: 500, queue: false });
                    jQuery("#wdform_'.$id1.'_street1'.$form_id.'").focus();
                    return false;
                  }
                }';
              }
              $post = isset($_POST['wdform_'.($id1+5).'_country'.$form_id]) ? $_POST['wdform_'.($id1+5).'_country'.$form_id] : NULL;
              if (isset($post)) {
                $onload_js .= ' jQuery("#wdform_'.$id1.'_country'.$form_id.'").val("'.(isset($_POST['wdform_'.($id1+5)."_country".$form_id]) ? $_POST['wdform_'.($id1+5)."_country".$form_id] : '').'");';
              }
              if (isset($w_disabled_fields[6]) && $w_disabled_fields[6]=='yes') {
                $onload_js .= ' jQuery("#wdform_'.$id1.'_country'.$form_id.'").change(function() { 
                if (jQuery(this).val()=="United States") {
                  jQuery("#wdform_'.$id1.'_state'.$form_id.'").parent().height("50px");
                  jQuery("#wdform_'.$id1.'_state'.$form_id.'").parent().append("<select type=\"text\" id=\"wdform_'.$id1.'_state'.$form_id.'\" name=\"wdform_'.($id1+3).'_state'.$form_id.'\" style=\"width: 100%; \" '.$param['attributes'].'>'.addslashes($w_state_options).'</select><label class=\"mini_label\" style=\"display: block;\" id=\"'.$id1.'_mini_label_state\">'.$w_mini_labels[3].'</label>");
                  jQuery("#wdform_'.$id1.'_state'.$form_id.'").parent().children("input:first, label:first").remove();
                }
                else {
                  if (jQuery("#wdform_'.$id1.'_state'.$form_id.'").prop("tagName")=="SELECT") {
                    jQuery("#wdform_'.$id1.'_state'.$form_id.'").parent().append("<input type=\"text\" id=\"wdform_'.$id1.'_state'.$form_id.'\" name=\"wdform_'.($id1+3).'_state'.$form_id.'\" value=\"'.(isset($_POST['wdform_'.($id1+3).'_state'.$form_id]) ? $_POST['wdform_'.($id1+3).'_state'.$form_id] : "").'\" style=\"width: 100%;\" '.$param['attributes'].'><label class=\"mini_label\">'.$w_mini_labels[3].'</label>");
                    jQuery("#wdform_'.$id1.'_state'.$form_id.'").parent().children("select:first, label:first").remove();	
                  }
                }
              });';
              }
              break;
            }
            case 'type_submitter_mail': {
              $params_names = array('w_field_label_size', 'w_field_label_pos', 'w_size', 'w_first_val', 'w_title', 'w_required', 'w_unique', 'w_class');
              $temp = $params;
              foreach ($params_names as $params_name ) {
                $temp = explode('*:*' . $params_name . '*:*', $temp);
                $param[$params_name] = $temp[0];
                $temp = $temp[1];
              }
              if ($temp) {	
                $temp	= explode('*:*w_attr_name*:*', $temp);
                $attrs = array_slice($temp, 0, count($temp) - 1);
                foreach ($attrs as $attr) {
                  $param['attributes'] = $param['attributes'].' '.$attr;
                }
              }
              $param['w_first_val']=(isset($_POST['wdform_'.$id1.'_element'.$form_id]) ? $_POST['wdform_'.$id1.'_element'.$form_id] : $param['w_first_val']);
              $wdformfieldsize = ($param['w_field_label_pos']=="left" ? ($param['w_field_label_size']+$param['w_size']) : max($param['w_field_label_size'], $param['w_size']));	
              $param['w_field_label_pos1'] = ($param['w_field_label_pos'] == "left" ? "float: left;" : "");	
              $param['w_field_label_pos2'] = ($param['w_field_label_pos'] == "left" ? "" : "display: block;");
              $input_active = ($param['w_first_val'] == $param['w_title'] ? "input_deactive" : "input_active");	
              $required = ($param['w_required'] == "yes" ? TRUE : FALSE);	
              $rep = '<div type="type_submitter_mail" class="wdform-field"  style="width:'.$wdformfieldsize.'px"><div class="wdform-label-section" style="'.$param['w_field_label_pos1'].'; width: '.$param['w_field_label_size'].'px;"><span class="wdform-label">'.$label.'</span>';
              if ($required) {
                $rep .= '<span class="wdform-required">'.$required_sym.'</span>';
              }
              $rep .= '</div><div class="wdform-element-section '.$param['w_class'].'" style="'.$param['w_field_label_pos2'].' width: '.$param['w_size'].'px;"><input type="text" class="'.$input_active.'" id="wdform_'.$id1.'_element'.$form_id.'" name="wdform_'.$id1.'_element'.$form_id.'" value="'.$param['w_first_val'].'" title="'.$param['w_title'].'"  style="width: 100%;" '.$param['attributes'].'></div></div>';
              if ($required) {
                $check_js .= '
                if (x.find(jQuery("div[wdid='.$id1.']")).length != 0) {
                  if (jQuery("#wdform_'.$id1.'_element'.$form_id.'").val()=="'.$param['w_title'].'" || jQuery("#wdform_'.$id1.'_element'.$form_id.'").val()=="") {
                    alert("' .addslashes($label. ' ' . __('field is required.', 'contact_form_maker')) . '");
                    jQuery("#wdform_'.$id1.'_element'.$form_id.'").addClass( "form-error" );
                    old_bg=x.find(jQuery("div[wdid='.$id1.']")).css("background-color");
                    x.find(jQuery("div[wdid='.$id1.']")).effect( "shake", {}, 500 ).css("background-color","#FF8F8B").animate({backgroundColor: old_bg}, {duration: 500, queue: false });
                    jQuery("#wdform_'.$id1.'_element'.$form_id.'").focus();
                    jQuery("#wdform_'.$id1.'_element'.$form_id.'").change(function() { if( jQuery(this).val()!="" ) jQuery(this).removeClass("form-error"); else jQuery(this).addClass("form-error");});
                    return false;
                  }
                }';
              }
              $check_js .= '
              if (x.find(jQuery("div[wdid='.$id1.']")).length != 0) {
                if (jQuery("#wdform_'.$id1.'_element'.$form_id.'").val() != "") {
                  if (jQuery("#wdform_'.$id1.'_element'.$form_id.'").val().search(/^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z0-9]+$/) == -1) {
                    alert("' . addslashes(__("This is not a valid email address.", 'contact_form_maker')) . '");
                    old_bg=x.find(jQuery("div[wdid='.$id1.']")).css("background-color");
                    x.find(jQuery("div[wdid='.$id1.']")).effect( "shake", {}, 500 ).css("background-color","#FF8F8B").animate({backgroundColor: old_bg}, {duration: 500, queue: false });
                    jQuery("#wdform_'.$id1.'_element'.$form_id.'").focus();
                    return false;
                  }
                }
              }';		
              break;
            }
            case 'type_checkbox': {
              $params_names = array('w_field_label_size', 'w_field_label_pos', 'w_flow', 'w_choices', 'w_choices_checked', 'w_rowcol', 'w_required', 'w_randomize', 'w_allow_other', 'w_allow_other_num', 'w_class');
              $temp = $params;
              foreach ($params_names as $params_name) {
                $temp = explode('*:*' . $params_name . '*:*', $temp);
                $param[$params_name] = $temp[0];
                $temp = $temp[1];
              }
              if ($temp) {
                $temp	= explode('*:*w_attr_name*:*', $temp);
                $attrs	= array_slice($temp, 0, count($temp) - 1);
                foreach ($attrs as $attr) {
                  $param['attributes'] = $param['attributes'] . ' ' . $attr;
                }
              }
              $param['w_field_label_pos1'] = ($param['w_field_label_pos'] == "left" ? "float: left;" : "");
              $param['w_field_label_pos2'] = ($param['w_field_label_pos'] == "left" ? "" : "display: block;");
              $required = ($param['w_required'] == "yes" ? TRUE : FALSE);
              $param['w_choices']	= explode('***', $param['w_choices']);
              $param['w_choices_checked']	= explode('***', $param['w_choices_checked']);
              $post_value = isset($_POST["counter".$form_id]) ? $_POST["counter".$form_id] : NULL;
              $is_other = FALSE;
              if (isset($post_value)) {
                if($param['w_allow_other'] == "yes") {
                  $is_other = FALSE;
                  $other_element = isset($_POST['wdform_'.$id1."_other_input".$form_id]) ? $_POST['wdform_'.$id1."_other_input".$form_id] : NULL;
                  if (isset($other_element)) {
                    $is_other = TRUE;
                  }
                }
              }
              else {
                $is_other=($param['w_allow_other']=="yes" && $param['w_choices_checked'][$param['w_allow_other_num']]=='true') ;
              }
              $rep='<div type="type_checkbox" class="wdform-field"><div class="wdform-label-section" style="'.$param['w_field_label_pos1'].'; width: '.$param['w_field_label_size'].'px;"><span class="wdform-label">'.$label.'</span>';
              if($required) {
                $rep.='<span class="wdform-required">'.$required_sym.'</span>';
              }
              $rep.='</div><div class="wdform-element-section '.$param['w_class'].'" style="'.$param['w_field_label_pos2'].';">';
            
              $rep.='<div style="display: '.($param['w_flow']=='hor' ? 'inline-block' : 'table-row' ).'; vertical-align:top">';

              foreach ($param['w_choices'] as $key => $choice) {
                if ($key%$param['w_rowcol']==0 && $key>0) {
                  $rep .= '</div><div style="display: '.($param['w_flow'] == 'hor' ? 'inline-block' : 'table-row' ).';  vertical-align:top">';
                }
                if (!isset($post_value)) {
                  $param['w_choices_checked'][$key]=($param['w_choices_checked'][$key]=='true' ? 'checked="checked"' : '');
                }
                else {
                  $post_valuetemp = isset($_POST['wdform_'.$id1."_element".$form_id.$key]) ? $_POST['wdform_'.$id1."_element".$form_id.$key] : NULL;
                  $param['w_choices_checked'][$key] = (isset($post_valuetemp) ? 'checked="checked"' : '');
                }
                $rep .= '<div style="display: '.($param['w_flow']!='hor' ? 'table-cell' : 'table-row' ).';"><label class="wdform-ch-rad-label" for="wdform_'.$id1.'_element'.$form_id.''.$key.'">'.$choice.'</label><div class="checkbox-div forlabs"><input type="checkbox" '.(($param['w_allow_other']=="yes" && $param['w_allow_other_num']==$key) ? 'other="1"' : ''	).' id="wdform_'.$id1.'_element'.$form_id.''.$key.'" name="wdform_'.$id1.'_element'.$form_id.''.$key.'" value="'.htmlspecialchars($choice).'" '.(($param['w_allow_other']=="yes" && $param['w_allow_other_num']==$key) ? 'onclick="if(set_checked(&quot;wdform_'.$id1.'&quot;,&quot;'.$key.'&quot;,&quot;'.$form_id.'&quot;)) show_other_input(&quot;wdform_'.$id1.'&quot;,&quot;'.$form_id.'&quot;);"' : '').' '.$param['w_choices_checked'][$key].' '.$param['attributes'].'><label for="wdform_'.$id1.'_element'.$form_id.''.$key.'"></label></div></div>';
              }
              $rep .= '</div>';
              $rep .= '</div></div>';
              if ($required) {
                $check_js .= '
                if (x.find(jQuery("div[wdid='.$id1.']")).length != 0) {
                  if (x.find(jQuery("div[wdid='.$id1.'] input:checked")).length == 0) {
                    alert("' .addslashes($label. ' ' . __('field is required.', 'contact_form_maker')) . '");
                    old_bg = x.find(jQuery("div[wdid='.$id1.']")).css("background-color");
                    x.find(jQuery("div[wdid='.$id1.']")).effect( "shake", {}, 500 ).css("background-color","#FF8F8B").animate({backgroundColor: old_bg}, {duration: 500, queue: false });
                    return false;
                  }
                }';
              }
              if ($is_other) {
                $onload_js .= 'show_other_input("wdform_'.$id1.'","'.$form_id.'"); jQuery("#wdform_'.$id1.'_other_input'.$form_id.'").val("'.(isset($_POST['wdform_'.$id1."_other_input".$form_id]) ? $_POST['wdform_'.$id1."_other_input".$form_id] : '').'");';
              }
              $onsubmit_js .= '
                jQuery("<input type=\"hidden\" name=\"wdform_'.$id1.'_allow_other'.$form_id.'\" value = \"'.$param['w_allow_other'].'\" />").appendTo("#contactform'.$form_id.'");
                jQuery("<input type=\"hidden\" name=\"wdform_'.$id1.'_allow_other_num'.$form_id.'\" value = \"'.$param['w_allow_other_num'].'\" />").appendTo("#contactform'.$form_id.'");';
              break;
            }
            case 'type_radio': {
              $params_names = array('w_field_label_size','w_field_label_pos','w_flow','w_choices','w_choices_checked','w_rowcol', 'w_required','w_randomize','w_allow_other','w_allow_other_num','w_class');
              $temp = $params;
              foreach ($params_names as $params_name) {
                $temp = explode('*:*' . $params_name . '*:*', $temp);
                $param[$params_name] = $temp[0];
                $temp = $temp[1];
              }
              if ($temp) {
                $temp	= explode('*:*w_attr_name*:*', $temp);
                $attrs = array_slice($temp,0, count($temp) - 1);
                foreach ($attrs as $attr) {
                  $param['attributes'] = $param['attributes'] . ' ' . $attr;
                }
              }
              $param['w_field_label_pos1'] = ($param['w_field_label_pos'] == "left" ? "float: left;" : "");	
              $param['w_field_label_pos2'] = ($param['w_field_label_pos'] == "left" ? "" : "display:block;");
              $required = ($param['w_required'] == "yes" ? TRUE : FALSE);	
              $param['w_choices']	= explode('***', $param['w_choices']);
              $param['w_choices_checked']	= explode('***', $param['w_choices_checked']);
              $post_value = isset($_POST["counter".$form_id]) ? $_POST["counter".$form_id] : NULL;
              $is_other = FALSE;
              if (isset($post_value)) {
                if ($param['w_allow_other'] == "yes") {
                  $is_other = FALSE;
                  $other_element = isset($_POST['wdform_'.$id1."_other_input".$form_id]) ? $_POST['wdform_'.$id1."_other_input".$form_id] : "";
                  if (isset($other_element)) {
                    $is_other = TRUE;
                  }
                }
              }
              else {
                $is_other = ($param['w_allow_other'] == "yes" && $param['w_choices_checked'][$param['w_allow_other_num']] == 'true') ;
              }
              $rep = '<div type="type_radio" class="wdform-field"><div class="wdform-label-section" style="'.$param['w_field_label_pos1'].'; width: '.$param['w_field_label_size'].'px;"><span class="wdform-label">'.$label.'</span>';
              if ($required) {
                $rep .= '<span class="wdform-required">'.$required_sym.'</span>';
              }
              $rep .= '</div><div class="wdform-element-section '.$param['w_class'].'" style="'.$param['w_field_label_pos2'].';">';
              $rep .= '<div style="display: '.($param['w_flow']=='hor' ? 'inline-block' : 'table-row' ).'; vertical-align: top;">';
              foreach ($param['w_choices'] as $key => $choice) {
                if ($key % $param['w_rowcol'] == 0 && $key > 0) {
                  $rep .= '</div><div style="display: '.($param['w_flow']=='hor' ? 'inline-block' : 'table-row' ).';  vertical-align:top">';
                }
                if (!isset($post_value)) {
                  $param['w_choices_checked'][$key] = ($param['w_choices_checked'][$key]=='true' ? 'checked="checked"' : '');
                }
                else {
                  $param['w_choices_checked'][$key] = (htmlspecialchars($choice) == htmlspecialchars(isset($_POST['wdform_'.$id1."_element".$form_id]) ? $_POST['wdform_'.$id1."_element".$form_id] : "") ? 'checked="checked"' : '');
                }
                $rep .= '<div style="display: '.($param['w_flow']!='hor' ? 'table-cell' : 'table-row' ).';"><label class="wdform-ch-rad-label" for="wdform_'.$id1.'_element'.$form_id.''.$key.'">'.$choice.'</label><div class="radio-div forlabs"><input type="radio" '.(($param['w_allow_other']=="yes" && $param['w_allow_other_num']==$key) ? 'other="1"' : ''	).' id="wdform_'.$id1.'_element'.$form_id.''.$key.'" name="wdform_'.$id1.'_element'.$form_id.'" value="'.htmlspecialchars($choice).'" onclick="set_default(&quot;wdform_'.$id1.'&quot;,&quot;'.$key.'&quot;,&quot;'.$form_id.'&quot;); '.(($param['w_allow_other']=="yes" && $param['w_allow_other_num']==$key) ? 'show_other_input(&quot;wdform_'.$id1.'&quot;,&quot;'.$form_id.'&quot;);' : '').'" '.$param['w_choices_checked'][$key].' '.$param['attributes'].'><label for="wdform_'.$id1.'_element'.$form_id.''.$key.'"></label></div></div>';
              }
              $rep .= '</div></div></div>';
              if ($required) {
                $check_js .= '
                if (x.find(jQuery("div[wdid='.$id1.']")).length != 0) {
                  if (x.find(jQuery("div[wdid='.$id1.'] input:checked")).length == 0 || jQuery("#wdform_'.$id1.'_other_input'.$form_id.'").val() == "") {
                    alert("' .addslashes($label. ' ' . __('field is required.', 'contact_form_maker')) . '");
                    old_bg=x.find(jQuery("div[wdid='.$id1.']")).css("background-color");
                    x.find(jQuery("div[wdid='.$id1.']")).effect( "shake", {}, 500 ).css("background-color","#FF8F8B").animate({backgroundColor: old_bg}, {duration: 500, queue: false });
                    return false;
                  }						
                }';
              }
              if ($is_other) {
                $onload_js .= 'show_other_input("wdform_'.$id1.'","'.$form_id.'"); jQuery("#wdform_'.$id1.'_other_input'.$form_id.'").val("'.(isset($_POST['wdform_'.$id1."_other_input".$form_id]) ? $_POST['wdform_'.$id1."_other_input".$form_id] : '').'");';
              }
              $onsubmit_js .= '
                jQuery("<input type=\"hidden\" name=\"wdform_'.$id1.'_allow_other'.$form_id.'\" value = \"'.$param['w_allow_other'].'\" />").appendTo("#contactform'.$form_id.'");
                jQuery("<input type=\"hidden\" name=\"wdform_'.$id1.'_allow_other_num'.$form_id.'\" value = \"'.$param['w_allow_other_num'].'\" />").appendTo("#contactform'.$form_id.'");';
              break;
            }
            case 'type_own_select': {
              $params_names = array('w_field_label_size', 'w_field_label_pos', 'w_size', 'w_choices', 'w_choices_checked', 'w_choices_disabled', 'w_required', 'w_class');
              $temp = $params;
              foreach ($params_names as $params_name ) {
                $temp = explode('*:*'.$params_name.'*:*', $temp);
                $param[$params_name] = $temp[0];
                $temp = $temp[1];
              }
              if ($temp) {
                $temp	= explode('*:*w_attr_name*:*', $temp);
                $attrs = array_slice($temp, 0, count($temp) - 1);
                foreach ($attrs as $attr) {
                  $param['attributes'] = $param['attributes'] . ' ' . $attr;
                }
              }
              $wdformfieldsize = ($param['w_field_label_pos'] == "left" ? ($param['w_field_label_size'] + $param['w_size']) : max($param['w_field_label_size'], $param['w_size']));	
              $param['w_field_label_pos1'] = ($param['w_field_label_pos'] == "left" ? "float: left;" : "");
              $param['w_field_label_pos2'] = ($param['w_field_label_pos'] == "left" ? "" : "display: block;");
              $required = ($param['w_required'] == "yes" ? TRUE : FALSE);	
              $param['w_choices']	= explode('***', $param['w_choices']);
              $param['w_choices_checked']	= explode('***', $param['w_choices_checked']);
              $param['w_choices_disabled'] = explode('***', $param['w_choices_disabled']);
              $post_value = isset($_POST["counter".$form_id]) ? $_POST["counter".$form_id] : NULL;
              $rep = '<div type="type_own_select" class="wdform-field"  style="width:'.$wdformfieldsize.'px"><div class="wdform-label-section" style="'.$param['w_field_label_pos1'].'; width: '.$param['w_field_label_size'].'px;"><span class="wdform-label">'.$label.'</span>';
              if ($required) {
                $rep .= '<span class="wdform-required">'.$required_sym.'</span>';
              }
              $rep .= '</div><div class="wdform-element-section '.$param['w_class'].'" style="'.$param['w_field_label_pos2'].' width: '.($param['w_size']).'px; "><select id="wdform_'.$id1.'_element'.$form_id.'" name="wdform_'.$id1.'_element'.$form_id.'" style="width: 100%"  '.$param['attributes'].'>';
              foreach ($param['w_choices'] as $key => $choice) {
                if (!isset($post_value)) {
                  $param['w_choices_checked'][$key]=($param['w_choices_checked'][$key]=='true' ? 'selected="selected"' : '');
                }
                else {
                  $param['w_choices_checked'][$key] = (htmlspecialchars($choice) == htmlspecialchars(isset($_POST['wdform_'.$id1."_element".$form_id]) ? $_POST['wdform_'.$id1."_element".$form_id] : "") ? 'selected="selected"' : '');
                }
                if ($param['w_choices_disabled'][$key] == "true") {
                  $choice_value = '';
                }
                else {
                  $choice_value = $choice;
                }
                $rep.='<option id="wdform_'.$id1.'_option'.$key.'" value="'.htmlspecialchars($choice_value).'" '.$param['w_choices_checked'][$key].'>'.$choice.'</option>';
              }
              $rep .= '</select></div></div>';
              if ($required) {
                $check_js .= '
                if (x.find(jQuery("div[wdid='.$id1.']")).length != 0) {
                  if (jQuery("#wdform_'.$id1.'_element'.$form_id.'").val()=="") {
                      alert("' .addslashes($label. ' ' . __('field is required.', 'contact_form_maker')) . '");
                      jQuery("#wdform_'.$id1.'_element'.$form_id.'").addClass( "form-error" );
                      old_bg=x.find(jQuery("div[wdid='.$id1.']")).css("background-color");
                      x.find(jQuery("div[wdid='.$id1.']")).effect( "shake", {}, 500 ).css("background-color","#FF8F8B").animate({backgroundColor: old_bg}, {duration: 500, queue: false });
                      jQuery("#wdform_'.$id1.'_element'.$form_id.'").focus();
                      jQuery("#wdform_'.$id1.'_element'.$form_id.'").change(function() { if( jQuery(this).val()!="" ) jQuery(this).removeClass("form-error"); else jQuery(this).addClass("form-error");});
                      return false;
                    }
                }';		
              }
              break;
            }
            case 'type_captcha': {
              $params_names = array('w_field_label_size', 'w_field_label_pos', 'w_digit', 'w_class');
              $temp = $params;
              foreach ($params_names as $params_name) {
                $temp = explode('*:*' . $params_name . '*:*', $temp);
                $param[$params_name] = $temp[0];
                $temp = $temp[1];
              }
              if ($temp) {
                $temp	= explode('*:*w_attr_name*:*', $temp);
                $attrs = array_slice($temp, 0, count($temp) - 1);
                foreach ($attrs as $attr) {
                  $param['attributes'] = $param['attributes'] . ' ' . $attr;
                }
              }
              $param['w_field_label_pos1'] = ($param['w_field_label_pos'] == "left" ? "float: left;" : "");
              $param['w_field_label_pos2'] = ($param['w_field_label_pos'] == "left" ? "" : "display: block;");
              $rep = '<div type="type_captcha" class="wdform-field"><div class="wdform-label-section" style="'.$param['w_field_label_pos1'].' width: '.$param['w_field_label_size'].'px;"><span class="wdform-label">'.$label.'</span></div><div class="wdform-element-section '.$param['w_class'].'" style="'.$param['w_field_label_pos2'].'"><div style="display: table;"><div style="display: table-cell;vertical-align: middle;"><div valign="middle" style="display: table-cell; text-align: center;"><img type="captcha" digit="'.$param['w_digit'].'" src=" ' . add_query_arg(array('action' => 'ContactFormmakerwdcaptcha', 'digit' => $param['w_digit'], 'i' => $form_id), admin_url('admin-ajax.php')) . '" id="wd_captcha'.$form_id.'" class="captcha_img" style="display:none" '.$param['attributes'].'></div><div valign="middle" style="display: table-cell;"><div class="captcha_refresh" id="_element_refresh'.$form_id.'" '.$param['attributes'].'></div></div></div><div style="display: table-cell;vertical-align: middle;"><div style="display: table-cell;"><input type="text" class="captcha_input" id="wd_captcha_input'.$form_id.'" name="captcha_input" style="width: '.($param['w_digit']*10+15).'px;" '.$param['attributes'].'></div></div></div></div></div>';
              $onload_js .= 'jQuery("#wd_captcha'.$form_id.'").click(function() {captcha_refresh("wd_captcha","'.$form_id.'")});';
              $onload_js .= 'jQuery("#_element_refresh'.$form_id.'").click(function() {captcha_refresh("wd_captcha","'.$form_id.'")});';
              $check_js.= '
              if (x.find(jQuery("div[wdid='.$id1.']")).length != 0) {
                if (jQuery("#wd_captcha_input'.$form_id.'").val()=="") {
                  alert("' .addslashes($label. ' ' . __('field is required.', 'contact_form_maker')) . '");
                  old_bg=x.find(jQuery("div[wdid='.$id1.']")).css("background-color");
                  x.find(jQuery("div[wdid='.$id1.']")).effect( "shake", {}, 500 ).css("background-color","#FF8F8B").animate({backgroundColor: old_bg}, {duration: 500, queue: false });
                  jQuery("#wd_captcha_input'.$form_id.'").focus();
                  return false;
                }
              }';
              $onload_js .= 'captcha_refresh("wd_captcha", "' . $form_id . '");';
              break;
            }
            case 'type_recaptcha': {
              $params_names = array('w_field_label_size', 'w_field_label_pos', 'w_public', 'w_private', 'w_theme', 'w_class');
              $temp = $params;
              foreach ($params_names as $params_name) {
                $temp = explode('*:*' . $params_name . '*:*', $temp);
                $param[$params_name] = $temp[0];
                $temp = $temp[1];
              }
              if ($temp) {	
                $temp	= explode('*:*w_attr_name*:*', $temp);
                $attrs = array_slice($temp, 0, count($temp) - 1);   
                foreach ($attrs as $attr) {
                  $param['attributes'] = $param['attributes'] . ' ' . $attr;
                }
              }
              $param['w_field_label_pos1'] = ($param['w_field_label_pos'] == "left" ? "float: left;" : "");
              $param['w_field_label_pos2'] = ($param['w_field_label_pos'] == "left" ? "" : "display: block;");
              $publickey = $row->public_key ? $row->public_key : '0';

              $rep =' <script src="https://www.google.com/recaptcha/api.js"></script><div type="type_recaptcha" class="wdform-field"><div class="wdform-label-section" style="'.$param['w_field_label_pos1'].'; width: '.$param['w_field_label_size'].'px;"><span class="wdform-label">'.$label.'</span></div><div class="wdform-element-section '.$param['w_class'].'" style="'.$param['w_field_label_pos2'].';"><div class="g-recaptcha" data-sitekey="'.$publickey.'"></div></div></div>';
              break;
            }
            case 'type_map': {
              $params_names = array('w_center_x', 'w_center_y', 'w_long', 'w_lat', 'w_zoom', 'w_width', 'w_height', 'w_info', 'w_class');
              $temp = $params;
              foreach ($params_names as $params_name) {
                $temp = explode('*:*'.$params_name.'*:*', $temp);
                $param[$params_name] = $temp[0];
                $temp = $temp[1];
              }
              if ($temp) {	
                $temp	= explode('*:*w_attr_name*:*', $temp);
                $attrs = array_slice($temp, 0, count($temp) - 1);   
                foreach ($attrs as $attr) {
                  $param['attributes'] = $param['attributes'] . ' ' . $attr;
                }
              }
              $marker = '';
              $param['w_long'] = explode('***', $param['w_long']);
              $param['w_lat']	= explode('***', $param['w_lat']);
              $param['w_info'] = explode('***', $param['w_info']);
              foreach ($param['w_long'] as $key => $w_long ) {
                $marker .= 'long'.$key.'="'.$w_long.'" lat'.$key.'="'.$param['w_lat'][$key].'" info'.$key.'="'.str_replace(array("\r\n", "\n", "\r"), '<br />', $param['w_info'][$key]).'"';
              }

              $rep ='<div type="type_map" class="wdform-field"  style="width:'.($param['w_width']).'px"><div class="wdform-label-section" style="display: table-cell;"><span id="wdform_'.$id1.'_element_label'.$form_id.'" style="display: none;">'.$label.'</span></div><div class="wdform-element-section '.$param['w_class'].'" style="width: '.$param['w_width'].'px;"><div id="wdform_'.$id1.'_element'.$form_id.'" zoom="'.$param['w_zoom'].'" center_x="'.$param['w_center_x'].'" center_y="'.$param['w_center_y'].'" style="width: 100%; height: '.$param['w_height'].'px;" '.$marker.' '.$param['attributes'].'></div></div></div>';
              $onload_js .= 'if_gmap_init("wdform_' . $id1 . '", ' . $form_id . ');';
              foreach ($param['w_long'] as $key => $w_long) {
                $onload_js .= 'add_marker_on_map("wdform_'.$id1.'",'.$key.', "'.$w_long.'", "'.$param['w_lat'][$key].'", "'.str_replace(array("\r\n", "\n", "\r"), '<br />', $param['w_info'][$key]).'", '.$form_id.',false);';
              }
              break;
            }
            case 'type_submit_reset': {              
              $params_names = array('w_submit_title', 'w_reset_title', 'w_class', 'w_act');
              $temp = $params;
              foreach ($params_names as $params_name ) {
                $temp = explode('*:*' . $params_name . '*:*', $temp);
                $param[$params_name] = $temp[0];
                $temp = $temp[1];
              }
              if ($temp) {	
                $temp	= explode('*:*w_attr_name*:*', $temp);
                $attrs = array_slice($temp, 0, count($temp) - 1);   
                foreach ($attrs as $attr) {
                  $param['attributes'] = $param['attributes'].' '.$attr;
                }
              }
              $param['w_act'] = ($param['w_act'] == "false" ? 'style="display: none;"' : "");	              
              $rep = '<div type="type_submit_reset" class="wdform-field"><div class="wdform-label-section" style="display: table-cell;"></div><div class="wdform-element-section '.$param['w_class'].'" style="display: table-cell;"><button type="button" class="button-submit" onclick="check_required'.$form_id.'(&quot;submit&quot;, &quot;'.$form_id.'&quot;);" '.$param['attributes'].'>'.$param['w_submit_title'].'</button><button type="button" class="button-reset" onclick="check_required'.$form_id.'(&quot;reset&quot;);" '.$param['w_act'].' '.$param['attributes'].'>'.$param['w_reset_title'].'</button></div></div>';            
              break;
            }
          }
        }
        $form = str_replace('%' . $id1 . ' - ' . $labels[$id1s_key] . '%', $rep, $form);
        $form = str_replace('%' . $id1 . ' -' . $labels[$id1s_key] . '%', $rep, $form);
      }
    }
    $rep1 = array('form_id_temp');
    $rep2 = array($id . 'contact');
    $form = str_replace($rep1, $rep2, $form);
    $form_maker_front_end .= $form;
    $form_maker_front_end .= '<div class="wdform_preload"></div>';
    $form_maker_front_end .= '</form>';
    ?>
    <script type="text/javascript">
      function contactformOnload<?php echo $id; ?>() {
        if (navigator.userAgent.toLowerCase().indexOf('msie') != -1) {
          if (parseInt(navigator.userAgent.toLowerCase().split('msie')[1]) === 8) {
            jQuery("#contactform<?php echo $id; ?>").find(jQuery("input[type='radio']")).click(function() {jQuery("input[type='radio']+label").removeClass('if-ie-div-label'); jQuery("input[type='radio']:checked+label").addClass('if-ie-div-label')});	
            jQuery("#contactform<?php echo $id; ?>").find(jQuery("input[type='radio']:checked+label")).addClass('if-ie-div-label');
            jQuery("#contactform<?php echo $id; ?>").find(jQuery("input[type='checkbox']")).click(function() {jQuery("input[type='checkbox']+label").removeClass('if-ie-div-label'); jQuery("input[type='checkbox']:checked+label").addClass('if-ie-div-label')});	
            jQuery("#contactform<?php echo $id; ?>").find(jQuery("input[type='checkbox']:checked+label")).addClass('if-ie-div-label');
          }
        }
        jQuery("div[type='type_text'] input, div[type='type_number'] input, div[type='type_phone'] input, div[type='type_name'] input, div[type='type_submitter_mail'] input, div[type='type_textarea'] textarea").focus(function() {delete_value(this)}).blur(function() {return_value(this)});
        jQuery("div[type='type_number'] input, div[type='type_phone'] input").keypress(function(evt) {return check_isnum(evt)});

        jQuery('.wdform-element-section').each(function() {
          if (!jQuery(this).parent()[0].style.width) {
            if (parseInt(jQuery(this).width()) != 0) {
              if (jQuery(this).css('display') == "table-cell") {
                if (jQuery(this).parent().attr('type') != "type_captcha") {
                  jQuery(this).parent().css('width', parseInt(jQuery(this).width()) + parseInt(jQuery(this).parent().find(jQuery(".wdform-label-section"))[0].style.width)+15);
                }
                else {
                  jQuery(this).parent().css('width', (parseInt(jQuery(this).parent().find(jQuery(".captcha_input"))[0].style.width)*2+50) + parseInt(jQuery(this).parent().find(jQuery(".wdform-label-section"))[0].style.width)+15);
                }
              }
            }
          }
          if(parseInt(jQuery(this)[0].style.width.replace('px', '')) < parseInt(jQuery(this).css('min-width').replace('px', '')))
            jQuery(this).css('min-width', parseInt(jQuery(this)[0].style.width.replace('px', ''))-10);
        });	
        
        jQuery('.wdform-label').each(function() {
          if(parseInt(jQuery(this).height()) >= 2*parseInt(jQuery(this).css('line-height').replace('px', '')))
          {
            jQuery(this).parent().css('max-width',jQuery(this).parent().width());
            jQuery(this).parent().css('width','');
          }
        });
        if (jQuery(".cfm_style").parent().prop("tagName") == "P") {
          jQuery(".cfm_style").parent().css({padding: 0, margin: 0});
        }
        <?php echo $onload_js; ?>
      }

      jQuery(window).load(function () {
        contactformOnload<?php echo $id ?>();
      });

      form_view_count<?php echo $id ?> = 0;
      jQuery(document).ready(function () {
        if (document.getElementById(<?php echo $id ?>+'contactform_view1')) {
          wdform_page = document.getElementById(<?php echo $id ?>+'contactform_view1');
          remove_whitespace(wdform_page);
          n = wdform_page.childNodes.length - 2;
          for (z = 0; z <= n; z++) {
            if (wdform_page.childNodes[z]) {
              if (wdform_page.childNodes[z].getAttribute("disabled")) {
                var wdform_section_break = wdform_page.childNodes[z];
                move = wdform_section_break.nextSibling;
                to = wdform_section_break.previousSibling;
                l = move.childNodes.length;
                for (k = 0; k < l; k++) {
                  if (to.childNodes[k]) {
                    while (move.childNodes[k].firstChild) {
                      to.childNodes[k].appendChild(move.childNodes[k].firstChild);
                    }
                  }
                  else {
                    to.appendChild(move.childNodes[k]);
                  }
                }
                wdform_section_break.parentNode.removeChild(wdform_section_break.nextSibling);
                wdform_section_break.parentNode.removeChild(wdform_section_break);
              }
            }
          }
        }
      });
      function check_required<?php echo $form_id ?>(but_type) {
        if (but_type == 'reset') {
          window.location = "<?php echo $_SERVER['REQUEST_URI'] ?>";
          return;
        }
        x = jQuery("#contactform<?php echo $form_id; ?>");
        <?php echo $check_js; ?>;
        var a = [];
        if (typeof a[<?php echo $form_id ?>] !== 'undefined') {
          if (a[<?php echo $form_id ?>] == 1) {
            return;
          }
        }
        <?php echo $onsubmit_js; ?>;
        a[<?php echo $form_id ?>] = 1;
        document.getElementById("contactform"+<?php echo $form_id ?>).submit();
      }
    </script>
    <?php
    return $form_maker_front_end;
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