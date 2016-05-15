<?php

class CFMModelForm_maker {
  ////////////////////////////////////////////////////////////////////////////////////////
  // Events                                                                             //
  ////////////////////////////////////////////////////////////////////////////////////////
  ////////////////////////////////////////////////////////////////////////////////////////
  // Constants                                                                          //
  ////////////////////////////////////////////////////////////////////////////////////////
  ////////////////////////////////////////////////////////////////////////////////////////
  // Variables                                                                          //
  ////////////////////////////////////////////////////////////////////////////////////////
  ////////////////////////////////////////////////////////////////////////////////////////
  // Constructor & Destructor                                                           //
  ////////////////////////////////////////////////////////////////////////////////////////
  public function __construct() {
  }
  ////////////////////////////////////////////////////////////////////////////////////////
  // Public Methods                                                                     //
  ////////////////////////////////////////////////////////////////////////////////////////
  public function showform($id) {
    global $wpdb;
    $row = $wpdb->get_row($wpdb->prepare('SELECT * FROM ' . $wpdb->prefix . 'contactformmaker WHERE id="%d"', $id));
    if (!$row || !$row->published) {
      return FALSE;
    }
    if (isset($_GET['test_theme']) && (esc_html(stripslashes($_GET['test_theme'])) != '')) {
      /* From preview.*/
      $theme_id = esc_html(stripslashes($_GET['test_theme']));
    }
    else {
      $theme_id = $row->theme;
    }
    $form_theme = $wpdb->get_var($wpdb->prepare('SELECT css FROM ' . $wpdb->prefix . 'contactformmaker_themes WHERE id="%d"', $theme_id));
    if (!$form_theme) {
      $form_theme = $wpdb->get_var('SELECT css FROM ' . $wpdb->prefix . 'contactformmaker_themes');
      if (!$form_theme) {
        return FALSE;
      }
    }
    $pattern = '/\/\/(.+)(\r\n|\r|\n)/';
    $form_theme = preg_replace($pattern, ' ', $form_theme);
    $form_theme = str_replace('//', ' ', $form_theme);
    $label_id = array();
    $label_type = array();
    $label_all = explode('#****#', $row->label_order);
    $label_all = array_slice($label_all, 0, count($label_all) - 1);
    foreach ($label_all as $key => $label_each) {
      $label_id_each = explode('#**id**#', $label_each);
      array_push($label_id, $label_id_each[0]);
      $label_order_each = explode('#**label**#', $label_id_each[1]);
      array_push($label_type, $label_order_each[1]);
    }
    return array(
      $row,
      1,
      $label_id,
      $label_type,
      $form_theme
    );
  }

  public function savedata($form, $id) {
    $all_files = array();
    $correct = FALSE;
    $id_for_old = $id;
    if (!$form->form_front) {
      $id = '';
    }
    if (isset($_POST["counter" . $id])) {
      $counter = esc_html($_POST["counter" . $id]);
      if (isset($_POST["captcha_input"])) {
        $captcha_input = esc_html($_POST["captcha_input"]);
        $session_wd_captcha_code = isset($_SESSION[$id . '_wd_captcha_code']) ? $_SESSION[$id . '_wd_captcha_code'] : '-';
        if ($captcha_input == $session_wd_captcha_code) {
          $correct = TRUE;
        }
        else {
          ?>
          <script>alert("<?php echo addslashes(__('Error, incorrect Security code.', 'contact_form_maker')); ?>");</script>
          <?php
        }
      }
      elseif (isset($_POST["recaptcha_response_field"])) {
        $recaptcha_response_field = esc_html($_POST["recaptcha_response_field"]);
        $privatekey = $form->private_key;
        $recaptcha_challenge_field = ((isset($_POST['recaptcha_challenge_field'])) ? esc_html($_POST['recaptcha_challenge_field']) : '');
        require_once(WD_CFM_DIR . '/recaptchalib.php');
        $resp = recaptcha_check_answer($privatekey, $_SERVER["REMOTE_ADDR"], $recaptcha_challenge_field, $recaptcha_response_field);
        if ($resp->is_valid) {
          $correct = TRUE;
        }
        else {
          ?>
          <script>alert("<?php echo addslashes(__('Error, incorrect Security code.', 'contact_form_maker')); ?>");</script>
          <?php
        }
      }
      elseif (isset($_POST["g-recaptcha-response"])) {
        $privatekey = $form->private_key;
        $w = stream_get_wrappers();
        if (in_array('https', $w)) {
          $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=" . $privatekey . "&response=" . $_POST['g-recaptcha-response']);
          $response = json_decode($response, true);
          if ($response["success"] === true) {
            $correct = TRUE;
          }
          else {
            ?>
            <script>alert("<?php echo addslashes(__('Error, incorrect Security code.', 'contact_form_maker')); ?>");</script>
            <?php
          }
        }
        else {
          ?>
          <script>alert("<?php echo addslashes(__('`php_openssl` extension is not enabled.', 'contact_form_maker')); ?>");</script>
          <?php
        }
      }
      else {
        $correct = TRUE;
      }
      if ($correct) {
        $ip = $_SERVER['REMOTE_ADDR'];
        global $wpdb;
        $blocked_ip = $wpdb->get_var($wpdb->prepare('SELECT * FROM ' . $wpdb->prefix . 'contactformmaker_blocked WHERE ip="%s"', $ip));
        if ($blocked_ip) {
          $_SESSION['cfm_massage_after_submit' . $id] = addslashes(__('Your ip is blacklisted. Please contact the website administrator.', 'contact_form_maker'));
          wp_redirect($_SERVER["REQUEST_URI"]);
          exit;
        }
        
        $all_files = $this->save_db($counter, $id_for_old);
        if (is_numeric($all_files)) {
          $this->remove($all_files, $id_for_old);
        }
        elseif (isset($counter)) {
          $this->gen_mail($counter, $all_files, $id_for_old);
        }
      }
      return $all_files;
    }
    return $all_files;
  }
  
  public function save_db($counter, $id) {
    global $wpdb;
    $chgnac = TRUE;
    $all_files = array();
    $form = $wpdb->get_row($wpdb->prepare("SELECT * FROM " . $wpdb->prefix . "contactformmaker WHERE id= %d", $id));
    $id_old = $id;
    if (!$form->form_front) {
      $id = '';
    }
    $label_id = array();
    $label_label = array();
    $label_type = array();
    $label_all	= explode('#****#',$form->label_order_current);		
    $label_all = array_slice($label_all, 0, count($label_all) - 1);
    foreach ($label_all as $key => $label_each) {
      $label_id_each = explode('#**id**#', $label_each);
      array_push($label_id, $label_id_each[0]);
      $label_order_each = explode('#**label**#', $label_id_each[1]);
      array_push($label_label, $label_order_each[0]);
      array_push($label_type, $label_order_each[1]);
    }
    $disabled_fields = explode(',', $form->disabled_fields);
		$disabled_fields = array_slice($disabled_fields, 0, count($disabled_fields) - 1);
    $max = $wpdb->get_var("SELECT MAX( group_id ) FROM " . $wpdb->prefix . "contactformmaker_submits");
    foreach ($label_type as $key => $type) {
      $value = '';
      if ($type == "type_submit_reset" or $type == "type_map" or $type == "type_editor" or  $type == "type_captcha" or  $type == "type_recaptcha" or $type == "type_send_copy") {
        continue;
      }
      $i = $label_id[$key];
      if (!in_array($i, $disabled_fields)) {
        switch ($type) {
          case 'type_text':
          case 'type_password':
          case 'type_textarea':
          case "type_submitter_mail":
          case "type_own_select":					
          case "type_number": {
            $value = isset($_POST['wdform_'.$i."_element".$id]) ? esc_html($_POST['wdform_'.$i."_element".$id]) : "";
            break;
          }
          case "type_phone": {
            $value = (isset($_POST['wdform_'.$i."_element_first".$id]) ? esc_html($_POST['wdform_'.$i."_element_first".$id]) : "") . ' ' . (isset($_POST['wdform_'.$i."_element_last".$id]) ? esc_html($_POST['wdform_'.$i."_element_last".$id]) : "");							
            break;
          }		
          case "type_name": {				
            $element_title = isset($_POST['wdform_'.$i."_element_title".$id]) ? esc_html($_POST['wdform_'.$i."_element_title".$id]) : NULL;
            if (isset($element_title)) {
              $value = (isset($_POST['wdform_'.$i."_element_title".$id]) ? esc_html($_POST['wdform_'.$i."_element_title".$id]) : "") . '@@@' . (isset($_POST['wdform_'.$i."_element_first".$id]) ? esc_html($_POST['wdform_'.$i."_element_first".$id]) : "") . '@@@' . (isset($_POST['wdform_'.$i."_element_last".$id]) ? esc_html($_POST['wdform_'.$i."_element_last".$id]) : "") . '@@@' . (isset($_POST['wdform_'.$i."_element_middle".$id]) ? esc_html($_POST['wdform_'.$i."_element_middle".$id]) : "");
            }
            else {
              $value = (isset($_POST['wdform_'.$i."_element_first".$id]) ? esc_html($_POST['wdform_'.$i."_element_first".$id]) : "") . '@@@' . (isset($_POST['wdform_'.$i."_element_last".$id]) ? esc_html($_POST['wdform_'.$i."_element_last".$id]) : "");
            }
            break;
          }		
          case 'type_address': {
            $value = '*#*#*#';
            $element = isset($_POST['wdform_'.$i."_street1".$id]) ? esc_html($_POST['wdform_'.$i."_street1".$id]) : NULL;
            if (isset($element)) {
              $value = $element;
              break;
            }
            
            $element = isset($_POST['wdform_'.$i."_street2".$id]) ? esc_html($_POST['wdform_'.$i."_street2".$id]) : NULL;
            if (isset($element)) {
              $value = $element;
              break;
            }
            
            $element = isset($_POST['wdform_'.$i."_city".$id]) ? esc_html($_POST['wdform_'.$i."_city".$id]) : NULL;
            if(isset($element)) {
              $value = $element;
              break;
            }
            
            $element = isset($_POST['wdform_'.$i."_state".$id]) ? esc_html($_POST['wdform_'.$i."_state".$id]) : NULL;
            if(isset($element)) {
              $value = $element;
              break;
            }
            
            $element = isset($_POST['wdform_'.$i."_postal".$id]) ? esc_html($_POST['wdform_'.$i."_postal".$id]) : NULL;
            if(isset($element)) {
              $value = $element;
              break;
            }
            
            $element = isset($_POST['wdform_'.$i."_country".$id]) ? esc_html($_POST['wdform_'.$i."_country".$id]) : NULL;
            if(isset($element)) {
              $value = $element;
              break;
            }						
            break;
          }
          case "type_radio": {
            $element = isset($_POST['wdform_'.$i."_other_input".$id]) ? esc_html($_POST['wdform_'.$i."_other_input".$id]) : NULL;
            if(isset($element)) {
              $value = $element;	
              break;
            }						
            $value = isset($_POST['wdform_'.$i."_element".$id]) ? esc_html($_POST['wdform_'.$i."_element".$id]) : "";
            break;
          }
          case "type_checkbox": {
            $start = -1;
            $value = '';
            for($j = 0; $j < 100; $j++) {						
              $element = isset($_POST['wdform_'.$i."_element".$id.$j]) ? esc_html($_POST['wdform_'.$i."_element".$id.$j]) : NULL;
              if(isset($element)) {
                $start = $j;
                break;
              }
            }
              
            $other_element_id = -1;
            $is_other = isset($_POST['wdform_'.$i."_allow_other".$id]) ? esc_html($_POST['wdform_'.$i."_allow_other".$id]) : "";
            if($is_other == "yes") {
              $other_element_id = isset($_POST['wdform_'.$i."_allow_other_num".$id]) ? esc_html($_POST['wdform_'.$i."_allow_other_num".$id]) : "";
            }
            
            if($start != -1) {
              for($j = $start; $j < 100; $j++) {
                $element = isset($_POST['wdform_'.$i."_element".$id.$j]) ? esc_html($_POST['wdform_'.$i."_element".$id.$j]) : NULL;
                if(isset($element)) {
                  if($j == $other_element_id) {
                    $value = $value . (isset($_POST['wdform_'.$i."_other_input".$id]) ? esc_html($_POST['wdform_'.$i."_other_input".$id]) : "") . '***br***';
                  }
                  else {								
                    $value = $value . (isset($_POST['wdform_'.$i."_element".$id.$j]) ? esc_html($_POST['wdform_'.$i."_element".$id.$j]) : "") . '***br***';
                  }
                }
              }
            }						
            break;
          }
        }
        if ($type == "type_address") {
          if(	$value == '*#*#*#') {
            continue;
          }
        }
        if ($type == "type_text" or $type == "type_password" or $type == "type_textarea" or $type == "type_name" or $type == "type_submitter_mail" or $type == "type_number" or $type == "type_phone") {
          $untilupload = $form->form_fields;
          $untilupload = substr($untilupload, strpos($untilupload, $i.'*:*id*:*'.$type), -1);
          $untilupload = substr($untilupload, 0, strpos($untilupload, '*:*new_field*:'));
          $untilupload = explode('*:*w_required*:*', $untilupload);
          $untilupload = $untilupload[1];
          $untilupload = explode('*:*w_unique*:*', $untilupload);
          $unique_element = $untilupload[0];
          if ($unique_element == 'yes') {						
            $unique = $wpdb->get_col($wpdb->prepare("SELECT id FROM " . $wpdb->prefix . "contactformmaker_submits WHERE form_id= %d  and element_label= %s and element_value= %s", $id, $i, addslashes($value)));
            if ($unique) {
              echo "<script> alert('" . addslashes(__('This field %s requires a unique entry and this value was already submitted.', 'contact_form_maker')) . "'.replace('%s','" . $label_label[$key] . "'));</script>";
              return array($max + 1);
            }
          }
        }
        if ($form->savedb) {
          $save_or_no = $wpdb->insert($wpdb->prefix . "contactformmaker_submits", array(
            'form_id' => $id,
            'element_label' => $i,
            'element_value' => stripslashes($value),
            'group_id' => ($max + 1),
            'date' => date('Y-m-d H:i:s'),
            'ip' => $_SERVER['REMOTE_ADDR'],
          ), array(
            '%d',
            '%s',
            '%s',
            '%d',
            '%s',
            '%s'
          ));
        }
        if (!$save_or_no) {
          return FALSE;
        }
        $chgnac = FALSE;
      }
    }
    if ($chgnac) {
      global $wpdb;
      if ($form->submit_text_type != 4) {
        $_SESSION['cfm_massage_after_submit' . $id] = addslashes(addslashes(__('Nothing was submitted.', 'contact_form_maker')));
      }
      $_SESSION['cfm_error_or_no' . $id] = 1;
      $_SESSION['cfm_form_submit_type' . $id] = $form->submit_text_type . "," . $form->id;
      wp_redirect($_SERVER["REQUEST_URI"]);
      exit;
    }
    return array($all_files);
  }

  public function remove($group_id) {
    global $wpdb;
    $wpdb->query($wpdb->prepare('DELETE FROM ' . $wpdb->prefix . 'contactformmaker_submits WHERE group_id= %d', $group_id));
  }

  public function get_after_submission_text($form_id) {
    global $wpdb;
    return $wpdb->get_var("SELECT submit_text FROM " . $wpdb->prefix . "contactformmaker WHERE id='" . $form_id . "'");
  }

  public function increment_views_count($id) {
    global $wpdb;
    $vives_form = $wpdb->get_var($wpdb->prepare("SELECT views FROM " . $wpdb->prefix . "contactformmaker_views WHERE form_id=%d", $id));
    if (isset($vives_form)) {
    $vives_form = $vives_form + 1;
    $wpdb->update($wpdb->prefix . "contactformmaker_views", array(
        'views' => $vives_form,
      ), array('form_id' => $id), array(
        '%d',
      ), array('%d'));
    }
    else {
      $wpdb->insert($wpdb->prefix . 'contactformmaker_views', array(
        'form_id' => $id,
        'views' => 1
        ), array(
          '%d',
          '%d'
      ));
    }
  }

  public function gen_mail($counter, $all_files, $id) {
    global $wpdb;
    $row = $wpdb->get_row($wpdb->prepare("SELECT * FROM " . $wpdb->prefix . "contactformmaker WHERE id=%d", $id));
    if (!$row->form_front) {
      $id = '';
    }
    $ip = $_SERVER['REMOTE_ADDR'];
    $replyto = '';
    $label_order_original = array();
    $label_order_ids = array();
    $label_label = array();
    $label_type = array();
		$cc = array();
    $row_mail_one_time = 1;
    $label_type = array();
		$label_all = explode('#****#', $row->label_order_current);
    $label_all = array_slice($label_all, 0, count($label_all) - 1);
    foreach ($label_all as $key => $label_each) {
      $label_id_each = explode('#**id**#', $label_each);
      $label_id = $label_id_each[0];
      array_push($label_order_ids, $label_id);
      $label_order_each = explode('#**label**#', $label_id_each[1]);
      $label_order_original[$label_id] = $label_order_each[0];
      $label_type[$label_id] = $label_order_each[1];
      array_push($label_label, $label_order_each[0]);
      array_push($label_type, $label_order_each[1]);
    }
    $disabled_fields = explode(',', $row->disabled_fields);
		$disabled_fields = array_slice($disabled_fields, 0, count($disabled_fields) - 1);
    $list = '<table border="1" cellpadding="3" cellspacing="0" style="width:600px;">';
    $list_text_mode = '';
    foreach ($label_order_ids as $key => $label_order_id) {
      $i = $label_order_id;
      $type = $label_type[$i];
      if ($type != "type_map" and  $type != "type_submit_reset" and  $type != "type_editor" and  $type != "type_captcha" and  $type != "type_recaptcha" and  $type != "type_send_copy") {
        $element_label = $label_order_original[$i];
        if (!in_array($i, $disabled_fields)) {
          switch ($type) {
            case 'type_text':
            case 'type_password':
            case 'type_textarea':
            case "type_own_select":		
            case "type_number": {
              $element = isset($_POST['wdform_'.$i."_element".$id]) ? $_POST['wdform_'.$i."_element".$id] : NULL;
              if (isset($element)) {
                $list = $list . '<tr valign="top"><td >' . $element_label . '</td><td><pre style="font-family:inherit; margin:0px; padding:0px">' . $element . '</pre></td></tr>';
                $list_text_mode .= $element_label . ' - ' . $element . "\r\n";
              }
              break;
            }
            case "type_submitter_mail": {
              $element = isset($_POST['wdform_'.$i."_element".$id]) ? $_POST['wdform_'.$i."_element".$id] : NULL;
              if (isset($element)) {
                $list = $list . '<tr valign="top"><td >' . $element_label . '</td><td ><pre style="font-family:inherit; margin:0px; padding:0px">' . $element . '</pre></td></tr>';		
                $list_text_mode .= $element_label . ' - ' . $element . "\r\n";
              }
              break;		
            }						
            case "type_phone": {
              $element_first = isset($_POST['wdform_'.$i."_element_first".$id]) ? $_POST['wdform_'.$i."_element_first".$id] : NULL;
              if (isset($element_first)) {
                $list = $list . '<tr valign="top"><td >' . $element_label . '</td><td >' . $element_first . ' ' . (isset($_POST['wdform_'.$i."_element_last".$id]) ? $_POST['wdform_'.$i."_element_last".$id] : "") . '</td></tr>';
                $list_text_mode .= $element_label . ' - ' . $element_first . ' ' . (isset($_POST['wdform_' . $i . "_element_last" . $id]) ? $_POST['wdform_' . $i . "_element_last" . $id] : "") . "\r\n";
              }	
              break;
            }
            case "type_name": {
              $element_first = isset($_POST['wdform_'.$i."_element_first".$id]) ? $_POST['wdform_'.$i."_element_first".$id] : NULL;
              if (isset($element_first)) {
                $element_title = isset($_POST['wdform_'.$i."_element_title".$id]) ? $_POST['wdform_'.$i."_element_title".$id] : NULL;
                if (isset($element_title)) {
                  $list = $list . '<tr valign="top"><td >' . $element_label . '</td><td >' . $element_title . ' ' . $element_first . ' ' . (isset($_POST['wdform_'.$i."_element_last".$id]) ? $_POST['wdform_'.$i."_element_last".$id] : "") . ' ' . (isset($_POST['wdform_'.$i."_element_middle".$id]) ? $_POST['wdform_'.$i."_element_middle".$id] : "") . '</td></tr>';
                  $list_text_mode .= $element_label . ' - ' . $element_title . ' ' . $element_first . ' ' . (isset($_POST['wdform_' . $i . "_element_last" . $id]) ? $_POST['wdform_' . $i . "_element_last" . $id] : "") . ' ' . (isset($_POST['wdform_' . $i . "_element_middle" . $id]) ? $_POST['wdform_' . $i . "_element_middle" . $id] : "") . "\r\n";
                }
                else {
                  $list = $list . '<tr valign="top"><td >' . $element_label . '</td><td >' . $element_first . ' ' . (isset($_POST['wdform_'.$i."_element_last".$id]) ? $_POST['wdform_'.$i."_element_last".$id] : "") . '</td></tr>';
                  $list_text_mode .= $element_label . ' - ' . $element_first . ' ' . (isset($_POST['wdform_' . $i . "_element_last" . $id]) ? $_POST['wdform_' . $i . "_element_last" . $id] : "") . "\r\n";
                }
              }	   
              break;		
            }
            case "type_address": {
              $element = isset($_POST['wdform_'.$i."_street1".$id]) ? $_POST['wdform_'.$i."_street1".$id] : NULL;
              if (isset($element)) {
                $list = $list . '<tr valign="top"><td >' . $label_order_original[$i] . '</td><td >' . $element . '</td></tr>';
                $list_text_mode .= $label_order_original[$i] . ' - ' . $element . "\r\n";
                break;
              }
              $element = isset($_POST['wdform_'.$i."_street2".$id]) ? $_POST['wdform_'.$i."_street2".$id] : NULL;
              if (isset($element)) {
                $list = $list . '<tr valign="top"><td >' . $label_order_original[$i] . '</td><td >' . $element . '</td></tr>';
                $list_text_mode .= $label_order_original[$i] . ' - ' . $element . "\r\n";
                break;
              }
              $element = isset($_POST['wdform_'.$i."_city".$id]) ? $_POST['wdform_'.$i."_city".$id] : NULL;
              if (isset($element)) {
                $list = $list . '<tr valign="top"><td >' . $label_order_original[$i] . '</td><td >' . $element . '</td></tr>';
                $list_text_mode .= $label_order_original[$i] . ' - ' . $element . "\r\n";
                break;
              }
              $element = isset($_POST['wdform_'.$i."_state".$id]) ? $_POST['wdform_'.$i."_state".$id] : NULL;
              if (isset($element)) {
                $list = $list . '<tr valign="top"><td >' . $label_order_original[$i] . '</td><td >' . $element . '</td></tr>';
                $list_text_mode .= $label_order_original[$i] . ' - ' . $element . "\r\n";
                break;
              }
              $element = isset($_POST['wdform_'.$i."_postal".$id]) ? $_POST['wdform_'.$i."_postal".$id] : NULL;
              if (isset($element)) {
                $list = $list . '<tr valign="top"><td >' . $label_order_original[$i] . '</td><td >' . $element . '</td></tr>';
                $list_text_mode .= $label_order_original[$i] . ' - ' . $element . "\r\n";
                break;
              }
              $element = isset($_POST['wdform_'.$i."_country".$id]) ? $_POST['wdform_'.$i."_country".$id] : NULL;
              if (isset($element)) {
                $list = $list . '<tr valign="top"><td >' . $label_order_original[$i] . '</td><td >' . $element . '</td></tr>';
                $list_text_mode .= $label_order_original[$i] . ' - ' . $element . "\r\n";
                break;
              }
              break;							
            }			
            case "type_radio": {
              $element = isset($_POST['wdform_'.$i."_other_input".$id]) ? $_POST['wdform_'.$i."_other_input".$id] : NULL;
              if (isset($element)) {
                $list = $list . '<tr valign="top"><td >' . $element_label . '</td><td >' . $element . '</td></tr>';
                $list_text_mode .= $element_label . ' - ' . $element . "\r\n";
                break;
              }								
              $element = isset($_POST['wdform_'.$i."_element".$id]) ? $_POST['wdform_'.$i."_element".$id] : NULL;
              if(isset($element)) {
                $list = $list . '<tr valign="top"><td >' . $element_label . '</td><td ><pre style="font-family:inherit; margin:0px; padding:0px">' . $element . '</pre></td></tr>';
                $list_text_mode .= $element_label . ' - ' . $element . "\r\n";
              }
              break;	
            }						
            case "type_checkbox": {
              $list = $list . '<tr valign="top"><td >' . $element_label . '</td><td >';
              $list_text_mode .= $element_label . ' - ';
              $start = -1;
              for ($j = 0; $j < 100; $j++) {
                $element = isset($_POST['wdform_'.$i."_element".$id.$j]) ? $_POST['wdform_'.$i."_element".$id.$j] : NULL;
                if (isset($element)) {
                  $start = $j;
                  break;
                }
              }								
              $other_element_id = -1;
              $is_other = isset($_POST['wdform_'.$i."_allow_other".$id]) ? $_POST['wdform_'.$i."_allow_other".$id] : "";
              if ($is_other == "yes") {
                $other_element_id = isset($_POST['wdform_'.$i."_allow_other_num".$id]) ? $_POST['wdform_'.$i."_allow_other_num".$id] : "";
              }
              if ($start != -1) {
                for ($j = $start; $j < 100; $j++) {									
                  $element = isset($_POST['wdform_'.$i."_element".$id.$j]) ? $_POST['wdform_'.$i."_element".$id.$j] : NULL;
                  if (isset($element)) {
                    if ($j == $other_element_id) {
                      $list = $list . (isset($_POST['wdform_'.$i."_other_input".$id]) ? $_POST['wdform_'.$i."_other_input".$id] : "") . '<br>';
                      $list_text_mode .= (isset($_POST['wdform_' . $i . "_other_input" . $id]) ? $_POST['wdform_' . $i . "_other_input" . $id] : "") . ', ';
                    }
                    else {									
                      $list = $list . (isset($_POST['wdform_'.$i."_element".$id.$j]) ? $_POST['wdform_'.$i."_element".$id.$j] : "") . '<br>';
                      $list_text_mode .= (isset($_POST['wdform_' . $i . "_element" . $id . $j]) ? $_POST['wdform_' . $i . "_element" . $id . $j] : "") . ', ';
                    }
                  }
                }
                $list = $list . '</td></tr>';
              }
              break;
            }	
            default: break;
          }
        }
      }				
    }
    $list = $list . '</table>';
    // $list = wordwrap($list, 70, "\n", TRUE);
   

    if ($row->sendemail) {
      if ($row->send_to) {
        $fromname = $row->mail_from_name_user;
        if ($row->mail_subject_user) {
          $subject = $row->mail_subject_user;
        }
        else {
          $subject = $row->title;
        }
        /*if (isset($_REQUEST['wdform_22_element' . $id])) {
          $subject = ($row->title) . ' : ' . $_REQUEST['wdform_22_element' . $id];
        }
        else {
          $subject = $row->title;
        }*/
        if ($row->reply_to_user) {
          $replyto = $row->reply_to_user;
        }
        if ($row->mail_mode_user) {
          $content_type = "text/html";
          $list_user = wordwrap($list, 70, "\n", TRUE);
          $new_script = $row->script_mail_user;
        }
        else {
          $content_type = "text/plain";
          $list_user = wordwrap($list_text_mode, 1000, "\n", TRUE);
          $new_script = str_replace(array('<p>', '</p>'), '', $row->script_mail_user);
        }
        foreach ($label_order_original as $key => $label_each) {
          $type = $label_type[$key];
          if (strpos($row->script_mail_user, "%" . $label_each . "%") !== FALSE && !in_array($key,$disabled_fields)) {
            $new_value = $this->custom_fields_mail($type, $key, $id);
            $new_script = str_replace("%" . $label_each . "%", $new_value, $new_script);
          }
          if (strpos($fromname, "%" . $label_each . "%") !== FALSE && !in_array($key,$disabled_fields)) {
            $new_value = str_replace('<br>', ', ', $this->custom_fields_mail($type, $key, $id));
            if (substr($new_value, -2) == ', ') {
              $new_value = substr($new_value, 0, -2);
            }
            $fromname = str_replace("%" . $label_each . "%", $new_value, $fromname);
          }
          if (strpos($subject, "%" . $label_each . "%") > -1) {
            $new_value = str_replace('<br>', ', ', $this->custom_fields_mail($type, $key, $id));
            if (substr($new_value, -2) == ', ') {
              $new_value = substr($new_value, 0, -2);
            }
            $subject = str_replace("%" . $label_each . "%", $new_value, $subject);
          }
        }
        $recipient = '';
        $cca = $row->mail_cc_user;
        $bcc = $row->mail_bcc_user;
        $send_tos = explode('**', $row->send_to);
        if ($row->mail_from_user != '') {
          if ($row->mail_from_name_user != '') {
            $from = "From: '" . htmlspecialchars_decode($row->mail_from_name_user, ENT_QUOTES) . "' <" . $row->mail_from_user . ">" . "\r\n";
          }
          else {
            $from = "From: '" . $row->mail_from_user . "' <" . $row->mail_from_user . ">" . "\r\n";
          }
        }
        else {
          $from = '';
        }

        $headers  = ''; //'MIME-Version: 1.0' . "\r\n";
        $headers .= $from;
        $headers .= 'Content-type: ' . $content_type . '; charset="' . get_option('blog_charset') . '"' . "\r\n";

        if ($replyto) {
          $headers .= "Reply-To: <" . $replyto . ">\r\n";
        }
        if ($cca) {
          $headers .= "Cc: " . $cca . "\r\n";
        }
        if ($bcc) {
          $headers .= "Bcc: " . $bcc . "\r\n";
        }
        if (strpos($new_script, "%ip%") > -1) {
          $new_script = str_replace("%ip%", $ip, $new_script);	
        }
        if (strpos($new_script, "%all%") > -1) {
          $new_script = str_replace("%all%", $list_user, $new_script);	
        }
        $body = $new_script;
        $send_copy = isset($_POST["wdform_send_copy_".$id]) ? $_POST["wdform_send_copy_".$id] : NULL;
        if (isset($send_copy)) {
          $send = TRUE;
        }
        else {
          foreach ($send_tos as $send_to) {
            $recipient = isset($_POST['wdform_'.str_replace('*', '', $send_to)."_element".$id]) ? $_POST['wdform_'.str_replace('*', '', $send_to)."_element".$id] : NULL;
            if ($recipient) {
              if ($row->wpmail) {
                $send = wp_mail(str_replace(' ', '', $recipient), $subject, stripslashes($body), $headers);
              }
              else {
                $send = mail(str_replace(' ', '', $recipient), $subject, stripslashes($body), $headers);
              }
            }
          }
        }
      }
    }

    if ($row->sendemail) {
      if ($row->mail) {
        if ($row->reply_to) {
          $replyto = isset($_POST['wdform_'.$row->reply_to."_element".$id]) ? $_POST['wdform_'.$row->reply_to."_element".$id] : NULL;
          if (!isset($replyto)) {
            $replyto = $row->reply_to;
          }
        }
        $recipient = $row->mail;
        /*if (isset($_REQUEST['wdform_22_element' . $id])) {
          $subject 	= $row->title . ' : ' . $_REQUEST['wdform_22_element' . $id];
        }
        else {
          $subject = $row->title;
        }*/
        if ($row->mail_subject) {
          $subject = $row->mail_subject;
        }
        else {
          $subject = $row->title;
        }
        if ($row->mail_from_name) {
          $fromname = $row->mail_from_name;
        }
        else {
          $fromname = '';
        }
        if ($row->mail_mode) {
          $content_type = "text/html";
          $list = wordwrap($list, 70, "\n", TRUE);
          $new_script = $row->script_mail;
        }
        else {
          $content_type = "text/plain";
          $list = $list_text_mode;
          $list = wordwrap($list, 1000, "\n", TRUE);
          $new_script = str_replace(array('<p>', '</p>'), '', $row->script_mail);
        }
        foreach ($label_order_original as $key => $label_each) {
          $type = $label_type[$key];
          if (strpos($row->script_mail, "%" . $label_each . "%") !== FALSE && !in_array($key,$disabled_fields)) {
            $new_value = $this->custom_fields_mail($type, $key, $id);
            $new_script = str_replace("%" . $label_each . "%", $new_value, $new_script);
          }
          if (strpos($fromname, "%" . $label_each . "%") !== FALSE && !in_array($key,$disabled_fields)) {
            $new_value = str_replace('<br>',', ',$this->custom_fields_mail($type, $key, $id));
            if (substr($new_value, -2) == ', ') {
              $new_value = substr($new_value, 0, -2);
            }
            $fromname = str_replace("%".$label_each."%", $new_value, $fromname);
          }
          if (strpos($subject, "%" . $label_each . "%") > -1) {
            $new_value = str_replace('<br>', ', ', $this->custom_fields_mail($type, $key, $id));
            if (substr($new_value, -2) == ', ') {
              $new_value = substr($new_value, 0, -2);
            }
            $subject = str_replace("%" . $label_each . "%", $new_value, $subject);
          }
        }
        if ($row->mail_from) {
          $from = isset($_POST['wdform_' . $row->mail_from . "_element" . $id]) ? $_POST['wdform_' . $row->mail_from . "_element" . $id] : NULL;
          if (!isset($from)) {
            $from = $row->mail_from;
          }
          $from = "From: '" . htmlspecialchars_decode($fromname, ENT_QUOTES) . "' <" . $from . ">" . "\r\n";
        }
        else {
          $from = "";
        }

        $headers  = ''; //'MIME-Version: 1.0' . "\r\n";
        $headers .= $from;
        $headers .= 'Content-type: ' . $content_type . '; charset="' . get_option('blog_charset') . '"' . "\r\n";

        if ($replyto) {
          $headers .= "Reply-To: <" . $replyto . ">\r\n";
        }
        $cca = $row->mail_cc;
        $bcc = $row->mail_bcc;
        if ($cca) {
          $headers .= "Cc: " . $cca . "\r\n";
        }
        if ($bcc) {
          $headers .= "Bcc: " . $bcc . "\r\n";
        }
        if (strpos($new_script, "%ip%") > -1) {
          $new_script = str_replace("%ip%", $ip, $new_script);
        }
        if (strpos($new_script, "%all%") > -1) {
          $new_script = str_replace("%all%", $list, $new_script);
        }
        $body = $new_script;
        if ($row->sendemail) {
          if ($row->wpmail) {
            $send = wp_mail(str_replace(' ', '', $recipient), $subject, stripslashes($body), $headers);
          }
          else {
            $send = mail(str_replace(' ', '', $recipient), $subject, stripslashes($body), $headers);
          }
        }
      }
    }

    $_SESSION['cfm_error_or_no' . $id] = 0;
    $msg = addslashes(__('Your form was successfully submitted.', 'contact_form_maker'));
    $succes = 1;

    if ($row->sendemail) {
      if ($row->mail || $row->send_to) {
        if ($send) {
          if ($send !== TRUE) {
            $_SESSION['cfm_error_or_no' . $id] = 1;
            $msg = addslashes(__('Error, email was not sent.', 'contact_form_maker'));
            $succes = 0;
          }
          else {
            $_SESSION['cfm_error_or_no' . $id] = 0;
            $msg = addslashes(__('Your form was successfully submitted.', 'contact_form_maker'));
          }
        }
      }
    }

    $https = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') ? 'https://' : 'http://');
    switch ($row->submit_text_type) {
      case "2":
      case "5": {
        if ($row->submit_text_type != 4) {
          $_SESSION['cfm_massage_after_submit' . $id] = $msg;
        }
        $_SESSION['cfm_form_submit_type' . $id] = $row->submit_text_type . "," . $row->id;
        if ($row->article_id) {
          $redirect_url = $row->article_id;
        }
        else {
          $redirect_url = $https . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
        }
        break;
      }
      case "3": {
        if ($row->submit_text_type != 4) {
          $_SESSION['cfm_massage_after_submit' . $id] = $msg;
        }
        $_SESSION['cfm_form_submit_type' . $id] = $row->submit_text_type . "," . $row->id;
        $redirect_url = $https . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
        break;
      }
      case "4": {
        if ($row->submit_text_type != 4) {
          $_SESSION['cfm_massage_after_submit' . $id] = $msg;
        }
        $_SESSION['cfm_form_submit_type' . $id] = $row->submit_text_type . "," . $row->id;
        $redirect_url = $row->url;
        break;
      }
      default: {
        if ($row->submit_text_type != 4) {
          $_SESSION['cfm_massage_after_submit' . $id] = $msg;
        }
        $_SESSION['cfm_form_submit_type' . $id] = $row->submit_text_type . "," . $row->id;
        $redirect_url = $https . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
        break;
      }
    }
    wp_redirect($redirect_url);
    exit;
  }

  public function custom_fields_mail($type, $key, $id) {
    $new_value = "";
    if ($type != "type_submit_reset" or $type != "type_map" or $type != "type_editor" or  $type != "type_captcha" or  $type != "type_recaptcha" or  $type != "type_button") {
      switch ($type) {
        case 'type_text':
        case 'type_password':
        case 'type_textarea':
        case 'type_own_select':
        case 'type_number': {
          if (isset($_POST['wdform_' . $key . "_element" . $id])) {
            $new_value = $_POST['wdform_'.$key."_element".$id];					
          }
          break;
        }
        case "type_submitter_mail": {
          if (isset($_POST['wdform_' . $key . "_element" . $id])) {
            $new_value = $_POST['wdform_' . $key . "_element" . $id];
          }
          break;		
        }
        case "type_phone": {
          if (isset($_POST['wdform_' . $key . "_element_first" . $id])) {
            $new_value = $_POST['wdform_'.$key."_element_first".$id] . ' ' . (isset($_POST['wdform_'.$key."_element_last".$id]) ? $_POST['wdform_'.$key."_element_last".$id] : "");
          }	
          break;
        }								
        case "type_name": {
          $element_first = isset($_POST['wdform_'.$key."_element_first".$id]) ? $_POST['wdform_'.$key."_element_first".$id] : NULL;
          if (isset($element_first)) {
            $element_title = isset($_POST['wdform_'.$key."_element_title".$id]) ? $_POST['wdform_'.$key."_element_title".$id] : NULL;
            if (isset($element_title)) {
              $new_value = $element_title . ' ' . $element_first . ' ' . (isset($_POST['wdform_'.$key."_element_last".$id]) ? $_POST['wdform_'.$key."_element_last".$id] : "") . ' ' . (isset($_POST['wdform_'.$key."_element_middle".$id]) ? $_POST['wdform_'.$key."_element_middle".$id] : "");
            }
            else {
              $new_value = $element_first . ' ' . (isset($_POST['wdform_'.$key."_element_last".$id]) ? $_POST['wdform_'.$key."_element_last".$id] : "");
            }
          }	   
          break;		
        }								
        case "type_address": {
          $street1 = isset($_POST['wdform_'.$key."_street1".$id]) ? $_POST['wdform_'.$key."_street1".$id] : NULL;
          if (isset($street1)) {
            $new_value = $street1;
            break;
          }                  
          $street2 = isset($_POST['wdform_'.$key."_street2".$id]) ? $_POST['wdform_'.$key."_street2".$id] : NULL;
          if (isset($street2)) {
            $new_value = $street2;
            break;
          }
          $city = isset($_POST['wdform_'.$key."_city".$id]) ? $_POST['wdform_'.$key."_city".$id] : NULL;
          if (isset($city)) {
            $new_value = $city;
            break;
          }                  
          $state = isset($_POST['wdform_'.$key."_state".$id]) ? $_POST['wdform_'.$key."_state".$id] : NULL;
          if (isset($state)) {
            $new_value = $state;
            break;
          }
          $postal = isset($_POST['wdform_'.$key."_postal".$id]) ? $_POST['wdform_'.$key."_postal".$id] : NULL;
          if (isset($postal)) {
            $new_value = $postal;
            break;
          }
          $country = isset($_POST['wdform_'.$key."_country".$id]) ? $_POST['wdform_'.$key."_country".$id] : NULL;
          if (isset($country)) {
            $new_value = $country;
            break;
          }
          break;
        }
        case "type_radio": {
          $element = isset($_POST['wdform_'.$key."_other_input".$id]) ? $_POST['wdform_'.$key."_other_input".$id] : NULL;
          if (isset($element)) {
            $new_value = $element;
            break;
          }									
          $element = isset($_POST['wdform_'.$key."_element".$id]) ? $_POST['wdform_'.$key."_element".$id] : NULL;
          if(isset($element)) {
            $new_value = $element;					
          }
          break;	
        }								
        case "type_checkbox": {
          $start = -1;
          for ($j = 0; $j < 100; $j++) {
            $element = isset($_POST['wdform_'.$key."_element".$id.$j]) ? $_POST['wdform_'.$key."_element".$id.$j] : NULL;
            if (isset($element)) {
              $start = $j;
              break;
            }
          }									
          $other_element_id = -1;
          $is_other = isset($_POST['wdform_'.$key."_allow_other".$id]) ? $_POST['wdform_'.$key."_allow_other".$id] : "";
          if ($is_other == "yes") {
            $other_element_id = isset($_POST['wdform_'.$key."_allow_other_num".$id]) ? $_POST['wdform_'.$key."_allow_other_num".$id] : "";
          }
          if ($start != -1) {
            for ($j = $start; $j < 100; $j++) {											
              $element = isset($_POST['wdform_'.$key."_element".$id.$j]) ? $_POST['wdform_'.$key."_element".$id.$j] : NULL;
              if (isset($element)) {
                if ($j == $other_element_id) {
                  $new_value = $new_value . (isset($_POST['wdform_'.$key."_other_input".$id]) ? $_POST['wdform_'.$key."_other_input".$id] : "") . '<br>';
                }
                else {											
                  $new_value = $new_value . $element . '<br>';
                }
              }
            }										
          }
          break;
        }
        default: break;
      }
    }
    return $new_value;
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