<?php

class CFMControllerManage_cfm {
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
  public function execute() {
    $task = WDW_CFM_Library::get('task');
    $id = WDW_CFM_Library::get('current_id', 0);
    $message = WDW_CFM_Library::get('message');
    echo WDW_CFM_Library::message_id($message);
    if (method_exists($this, $task)) {
      check_admin_referer('nonce_cfm', 'nonce_cfm');
      $this->$task($id);
    }
    else {
      $this->display();
    }
  }

  public function display() {
    require_once WD_CFM_DIR . "/admin/models/CFMModelManage_cfm.php";
    $model = new CFMModelManage_cfm();

    require_once WD_CFM_DIR . "/admin/views/CFMViewManage_cfm.php";
    $view = new CFMViewManage_cfm($model);
    $view->display();
  }

  public function add() {
    require_once WD_CFM_DIR . "/admin/models/CFMModelManage_cfm.php";
    $model = new CFMModelManage_cfm();

    require_once WD_CFM_DIR . "/admin/views/CFMViewManage_cfm.php";
    $view = new CFMViewManage_cfm($model);
    $view->edit(0);
  }

  public function edit() {
    require_once WD_CFM_DIR . "/admin/models/CFMModelManage_cfm.php";
    $model = new CFMModelManage_cfm();

    require_once WD_CFM_DIR . "/admin/views/CFMViewManage_cfm.php";
    $view = new CFMViewManage_cfm($model);
    $id = WDW_CFM_Library::get('current_id', 0);
    $view->edit($id);
  }

  public function form_layout() {
    if (!isset($_GET['task'])) {
      $this->save_db();
    }
    require_once WD_CFM_DIR . "/admin/models/CFMModelManage_cfm.php";
    $model = new CFMModelManage_cfm();

    require_once WD_CFM_DIR . "/admin/views/CFMViewManage_cfm.php";
    $view = new CFMViewManage_cfm($model);
    global $wpdb;
    $id = WDW_CFM_Library::get('current_id', $wpdb->get_var("SELECT MAX(id) FROM " . $wpdb->prefix . "contactformmaker"));
    $view->form_layout($id);
  }

  public function save_layout() {
    $message = $this->save_db_layout();
    $page = WDW_CFM_Library::get('page');
    $current_id = WDW_CFM_Library::get('current_id', 0);
    WDW_CFM_Library::spider_redirect(add_query_arg(array('page' => $page, 'task' => 'edit', 'current_id' => $current_id, 'message' => $message), admin_url('admin.php')));
  }

  public function apply_layout() {
    $message = $this->save_db_layout();
    require_once WD_CFM_DIR . "/admin/models/CFMModelManage_cfm.php";
    $model = new CFMModelManage_cfm();

    require_once WD_CFM_DIR . "/admin/views/CFMViewManage_cfm.php";
    $view = new CFMViewManage_cfm($model);
    $page = WDW_CFM_Library::get('page');
    $current_id = WDW_CFM_Library::get('current_id', 0);
    WDW_CFM_Library::spider_redirect(add_query_arg(array('page' => $page, 'task' => 'form_layout', 'current_id' => $current_id, 'message' => $message), admin_url('admin.php')));
  }

  public function save_db_layout() {
    global $wpdb;
    $id = WDW_CFM_Library::get('current_id', 0);
    $custom_front = (isset($_POST['custom_front']) ? stripslashes($_POST['custom_front']) : '');
    $autogen_layout = (isset($_POST['autogen_layout']) ? 1 : 0);
    $save = $wpdb->update($wpdb->prefix . 'contactformmaker', array(
      'custom_front' => $custom_front,
      'autogen_layout' => $autogen_layout
    ), array('id' => $id));
    if ($save !== FALSE) {
      return 1;
    }
    else {
      return 2;
    }
  }

  public function form_options() {
    if (!isset($_GET['task'])) {
      $this->save_db();
    }
    require_once WD_CFM_DIR . "/admin/models/CFMModelManage_cfm.php";
    $model = new CFMModelManage_cfm();

    require_once WD_CFM_DIR . "/admin/views/CFMViewManage_cfm.php";
    $view = new CFMViewManage_cfm($model);
    global $wpdb;
    $id = WDW_CFM_Library::get('current_id', $wpdb->get_var("SELECT MAX(id) FROM " . $wpdb->prefix . "contactformmaker"));
    $view->form_options($id);
  }

  public function save_options() {
    $message = $this->save_db_options();
    $page = WDW_CFM_Library::get('page');
    $current_id = WDW_CFM_Library::get('current_id', 0);
    WDW_CFM_Library::spider_redirect(add_query_arg(array('page' => $page, 'task' => 'edit', 'current_id' => $current_id, 'message' => $message), admin_url('admin.php')));
  }

  public function apply_options() {
    $message = $this->save_db_options();
    require_once WD_CFM_DIR . "/admin/models/CFMModelManage_cfm.php";
    $model = new CFMModelManage_cfm();

    require_once WD_CFM_DIR . "/admin/views/CFMViewManage_cfm.php";
    $view = new CFMViewManage_cfm($model);
    $page = WDW_CFM_Library::get('page');
    $current_id = WDW_CFM_Library::get('current_id', 0);
    $fieldset_id = WDW_CFM_Library::get('fieldset_id', 'general');
    WDW_CFM_Library::spider_redirect(add_query_arg(array('page' => $page, 'task' => 'form_options', 'current_id' => $current_id, 'message' => $message, 'fieldset_id' => $fieldset_id), admin_url('admin.php')));
  }

  public function cancel_options() {
    $this->edit();
  }

  public function save_db_options() {
    global $wpdb;
    $id = WDW_CFM_Library::get('current_id', 0);
    $mail = (isset($_POST['mail']) ? esc_html(stripslashes($_POST['mail'])) : '');
    if (isset($_POST['mailToAdd']) && esc_html(stripslashes($_POST['mailToAdd'])) != '') {
      $mail .= esc_html(stripslashes($_POST['mailToAdd'])) . ',';
    }
    $submit_text = (isset($_POST['submit_text']) ? stripslashes($_POST['submit_text']) : '');
    $article_id = (isset($_POST['article_id']) ? stripslashes($_POST['article_id']) : '');
    $url = (isset($_POST['url']) ? esc_html(stripslashes($_POST['url'])) : '');
    $script_mail = (isset($_POST['script_mail']) ? stripslashes($_POST['script_mail']) : '%all%');
    $script_mail_user = (isset($_POST['script_mail_user']) ? stripslashes($_POST['script_mail_user']) : '%all%');
    $published = (isset($_POST['published']) ? esc_html(stripslashes($_POST['published'])) : 1);
    $savedb = (isset($_POST['savedb']) ? esc_html(stripslashes($_POST['savedb'])) : 1);
    $sendemail = (isset($_POST['sendemail']) ? esc_html(stripslashes($_POST['sendemail'])) : 1);
    $requiredmark = (isset($_POST['requiredmark']) ? esc_html(stripslashes($_POST['requiredmark'])) : '*');
    $mail_from = (isset($_POST['mail_from']) ? esc_html(stripslashes($_POST['mail_from'])) : '');
    $mail_from_name = (isset($_POST['mail_from_name']) ? esc_html(stripslashes($_POST['mail_from_name'])) : '');
    $reply_to = (isset($_POST['reply_to']) ? esc_html(stripslashes($_POST['reply_to'])) : '');
    $wpmail = (isset($_POST['wpmail']) ? esc_html(stripslashes($_POST['wpmail'])) : 1);
    if ($mail_from == "other") {
      $mail_from = (isset($_POST['mail_from_other']) ? esc_html(stripslashes($_POST['mail_from_other'])) : '');
    }
    if ($reply_to == "other") {
      $reply_to = (isset($_POST['reply_to_other']) ? esc_html(stripslashes($_POST['reply_to_other'])) : '');
    }
    $mail_from_user = (isset($_POST['mail_from_user']) ? esc_html(stripslashes($_POST['mail_from_user'])) : '');
    $mail_from_name_user = (isset($_POST['mail_from_name_user']) ? esc_html(stripslashes($_POST['mail_from_name_user'])) : '');
    $reply_to_user = (isset($_POST['reply_to_user']) ? esc_html(stripslashes($_POST['reply_to_user'])) : '');
    $send_to = '';
    for ($i = 0; $i < 20; $i++) {
      if (isset($_POST['send_to' . $i])) {
        $send_to .= '*' . esc_html(stripslashes($_POST['send_to' . $i])) . '*';
      }
    }
    if (isset($_POST['submit_text_type'])) {
      $submit_text_type = esc_html(stripslashes($_POST['submit_text_type']));
      if ($submit_text_type == 5) {
        $article_id = (isset($_POST['page_name']) ? stripslashes($_POST['page_name']) : 0);
      }
      else {
        $article_id = (isset($_POST['post_name']) ? stripslashes($_POST['post_name']) : 0);
      }
    }
    else {
      $submit_text_type = 0;
      $article_id = '';
    }
    $mail_cc = (isset($_POST['mail_cc']) ? esc_html(stripslashes($_POST['mail_cc'])) : '');
    $mail_cc_user = (isset($_POST['mail_cc_user']) ? esc_html(stripslashes($_POST['mail_cc_user'])) : '');
    $mail_bcc = (isset($_POST['mail_bcc']) ? esc_html(stripslashes($_POST['mail_bcc'])) : '');
    $mail_bcc_user = (isset($_POST['mail_bcc_user']) ? esc_html(stripslashes($_POST['mail_bcc_user'])) : '');
    $mail_subject = (isset($_POST['mail_subject']) ? esc_html(stripslashes($_POST['mail_subject'])) : '');
    $mail_subject_user = (isset($_POST['mail_subject_user']) ? esc_html(stripslashes($_POST['mail_subject_user'])) : '');
    $mail_mode = (isset($_POST['mail_mode']) ? esc_html(stripslashes($_POST['mail_mode'])) : 1);
    $mail_mode_user = (isset($_POST['mail_mode_user']) ? esc_html(stripslashes($_POST['mail_mode_user'])) : 1);
    $save = $wpdb->update($wpdb->prefix . 'contactformmaker', array(
      'mail' => $mail,
      'submit_text' => $submit_text,
      'url' => $url,
      'submit_text_type' => $submit_text_type,
      'article_id' => $article_id,
      'script_mail' => $script_mail,
      'script_mail_user' => $script_mail_user,
      'published' => $published,
      'savedb' => $savedb,
      'sendemail' => $sendemail,
      'requiredmark' => $requiredmark,
      'mail_from' => $mail_from,
      'mail_from_name' => $mail_from_name,
      'reply_to' => $reply_to,
      'send_to' => $send_to,
      'mail_from_user' => $mail_from_user,
      'mail_from_name_user' => $mail_from_name_user,
      'reply_to_user' => $reply_to_user,
      'mail_cc' => $mail_cc,
      'mail_cc_user' => $mail_cc_user,
      'mail_bcc' => $mail_bcc,
      'mail_bcc_user' => $mail_bcc_user,
      'mail_subject' => $mail_subject,
      'mail_subject_user' => $mail_subject_user,
      'mail_mode' => $mail_mode,
      'mail_mode_user' => $mail_mode_user,
      'wpmail' => $wpmail,
    ), array('id' => $id));
    if ($save !== FALSE) {
      return 8;
    }
    else {
      return 2;
    }
  }

  public function save_as_copy() {
    $message = $this->save_db_as_copy();
    $page = WDW_CFM_Library::get('page');
    WDW_CFM_Library::spider_redirect(add_query_arg(array('page' => $page, 'task' => 'display', 'message' => $message), admin_url('admin.php')));
  }

  public function save() {
    $message = $this->save_db();
    $page = WDW_CFM_Library::get('page');
    WDW_CFM_Library::spider_redirect(add_query_arg(array('page' => $page, 'task' => 'display', 'message' => $message), admin_url('admin.php')));
  }

  public function apply() {
    $message = $this->save_db();
    global $wpdb;
    $id = (int) $wpdb->get_var("SELECT MAX(id) FROM " . $wpdb->prefix . "contactformmaker");
    $current_id = WDW_CFM_Library::get('current_id', $id);
    $page = WDW_CFM_Library::get('page');
    WDW_CFM_Library::spider_redirect(add_query_arg(array('page' => $page, 'task' => 'edit', 'current_id' => $current_id, 'message' => $message), admin_url('admin.php')));
  }

  public function save_db() {
    global $wpdb;
    $id = WDW_CFM_Library::get('current_id', 0);
    $title = (isset($_POST['title']) ? esc_html(stripslashes($_POST['title'])) : '');
    $form_front = (isset($_POST['form_front']) ? stripslashes($_POST['form_front']) : '');
    $counter = (isset($_POST['counter']) ? (int) stripslashes($_POST['counter']) : 0);
    $label_order = (isset($_POST['label_order']) ? stripslashes($_POST['label_order']) : '');
    $label_order_current = (isset($_POST['label_order_current']) ? stripslashes($_POST['label_order_current']) : '');
    $public_key = (isset($_POST['public_key']) ? esc_html(stripslashes($_POST['public_key'])) : '');
    $private_key = (isset($_POST['private_key']) ? esc_html(stripslashes($_POST['private_key'])) : '');
    $recaptcha_theme = (isset($_POST['recaptcha_theme']) ? esc_html(stripslashes($_POST['recaptcha_theme'])) : '');
    $form_fields = (isset($_POST['form_fields']) ? stripslashes($_POST['form_fields']) : '');
    $disabled_fields = (isset($_POST['disabled_fields']) ? stripslashes($_POST['disabled_fields']) : '');
    $sortable = (isset($_POST['sortable']) ? esc_html(stripslashes($_POST['sortable'])) : 0);
    $label_id = array();
    $label_label = array();
    $label_all = explode('#****#', $label_order_current);
    $label_all = array_slice($label_all, 0, count($label_all) - 1);
    foreach ($label_all as $key => $label_each) {
      $label_id_each = explode('#**id**#', $label_each);
      if ($label_id_each[0] == 22) {
        $default_subject = $key;
      }
      array_push($label_id, $label_id_each[0]);
      $label_order_each = explode('#**label**#', $label_id_each[1]);
      array_push($label_label, $label_order_each[0]);
    }
    $disabled_fields_array = explode(',', $disabled_fields);
    $disabled_fields_array = array_slice($disabled_fields_array, 0, count($disabled_fields_array) - 1);
    $subject = $wpdb->get_row($wpdb->prepare('SELECT mail_subject,mail_subject_user FROM ' . $wpdb->prefix . 'contactformmaker WHERE id="%d"', $id));
    if (!in_array($label_id[$default_subject], $disabled_fields_array)) {
      $mail_subject = ($subject->mail_subject == '') ? '%' . $label_label[$default_subject] . '%' : $subject->mail_subject;
      $mail_subject_user = ($subject->mail_subject_user == '') ? '%' . $label_label[$default_subject] . '%' : $subject->mail_subject_user;
    }
    else {
      $mail_subject = $subject->mail_subject;
      $mail_subject_user = $subject->mail_subject_user;
    }

    if ($id != 0) {
      $save = $wpdb->update($wpdb->prefix . 'contactformmaker', array(
        'title' => $title,
        'form_front' => $form_front,
        'counter' => $counter,
        'label_order' => $label_order,
        'label_order_current' => $label_order_current,
        'public_key' => $public_key,
        'private_key' => $private_key,
        'recaptcha_theme' => $recaptcha_theme,
        'form_fields' => $form_fields,
        'disabled_fields' => $disabled_fields,
        'mail_subject' => $mail_subject,
        'mail_subject_user' => $mail_subject_user,
        'sortable' => $sortable,
      ), array('id' => $id));
    }
    else {
      $save = $wpdb->insert($wpdb->prefix . 'contactformmaker', array(
        'title' => $title,
        'mail' => '',
        'form_front' => $form_front,
        'theme' => 0,
        'submit_text' => '',
        'url' => '',
        'submit_text_type' => 0,
        'script_mail' => '',
        'script_mail_user' => '',
        'counter' => $counter,
        'published' => 1,
        'label_order' => $label_order,
        'label_order_current' => $label_order_current,
        'public_key' => $public_key,
        'private_key' => $private_key,
        'recaptcha_theme' => $recaptcha_theme,
        'form_fields' => $form_fields,
        'savedb' => 1,
        'sendemail' => 1,
        'requiredmark' => '*',
        'mail_from' => '',
        'mail_from_name' => '',
        'reply_to' => '',
        'send_to' => '',
        'autogen_layout' => 1,
        'custom_front' => '',
        'mail_from_user' => '',
        'mail_from_name_user' => '',
        'reply_to_user' => '',
        'disabled_fields' => $disabled_fields,
        'mail_cc' => '',
        'mail_cc_user' => '',
        'mail_bcc' => '',
        'mail_bcc_user' => '',
        'mail_subject' => '',
        'mail_subject_user' => '',
        'mail_mode' => 1,
        'mail_mode_user' => 1,
        'wpmail' => 1,
        'sortable' => $sortable,
      ), array(
				'%s',
        '%s',
        '%s',
        '%d',
        '%s',
        '%s',
        '%d',
        '%s',
        '%s',
        '%d',
        '%d',
        '%s',
        '%s',
        '%s',
        '%s',
        '%s',
        '%s',
        '%d',
        '%d',
        '%s',
        '%s',
        '%s',
        '%s',
        '%s',
        '%d',
        '%s',
        '%s',
        '%s',
        '%s',
        '%s',
        '%s',
        '%s',
        '%s',
        '%s',
        '%s',
        '%s',
        '%d',
        '%d',
        '%d',
        '%d',
      ));
      $id = $wpdb->get_var("SELECT MAX(id) FROM " . $wpdb->prefix . "contactformmaker");
      $wpdb->insert($wpdb->prefix . 'contactformmaker_views', array(
        'form_id' => $id,
        'views' => 0
        ), array(
          '%d',
          '%d'
      ));
    }
    if ($save !== FALSE) {
      return 1;
    }
    else {
      return 2;
    }
  }

  public function save_db_as_copy() {
    global $wpdb;
    $id = WDW_CFM_Library::get('current_id', 0);
    $row = $wpdb->get_row($wpdb->prepare('SELECT * FROM ' . $wpdb->prefix . 'contactformmaker WHERE id="%d"', $id));
    $title = (isset($_POST['title']) ? esc_html(stripslashes($_POST['title'])) : '');
    $form_front = (isset($_POST['form_front']) ? stripslashes($_POST['form_front']) : '');
    $counter = (isset($_POST['counter']) ? (int) stripslashes($_POST['counter']) : 0);
    $label_order = (isset($_POST['label_order']) ? esc_html(stripslashes($_POST['label_order'])) : '');
    $label_order_current = (isset($_POST['label_order_current']) ? esc_html(stripslashes($_POST['label_order_current'])) : '');
    $public_key = (isset($_POST['public_key']) ? esc_html(stripslashes($_POST['public_key'])) : '');
    $private_key = (isset($_POST['private_key']) ? esc_html(stripslashes($_POST['private_key'])) : '');
    $recaptcha_theme = (isset($_POST['recaptcha_theme']) ? esc_html(stripslashes($_POST['recaptcha_theme'])) : '');
    $form_fields = (isset($_POST['form_fields']) ? stripslashes($_POST['form_fields']) : '');
    $disabled_fields = (isset($_POST['disabled_fields']) ? stripslashes($_POST['disabled_fields']) : '');
    $sortable = (isset($_POST['sortable']) ? esc_html(stripslashes($_POST['sortable'])) : 0);

    $save = $wpdb->insert($wpdb->prefix . 'contactformmaker', array(
      'title' => $title,
      'mail' => $row->mail,
      'form_front' => $form_front,
      'theme' => $row->theme,
      'submit_text' => $row->submit_text,
      'url' => $row->url,
      'submit_text_type' => $row->submit_text_type,
      'script_mail' => $row->script_mail,
      'script_mail_user' => $row->script_mail_user,
      'counter' => $counter,
      'published' => $row->published,
      'label_order' => $label_order,
      'label_order_current' => $label_order_current,
      'article_id' => $row->article_id,
      'public_key' => $public_key,
      'private_key' => $private_key,
      'recaptcha_theme' => $recaptcha_theme,
      'form_fields' => $form_fields,
      'savedb' => $row->savedb,
      'sendemail' => $row->sendemail,
      'requiredmark' => $row->requiredmark,
      'mail_from' => $row->mail_from,
      'mail_from_name' => $row->mail_from_name,
      'reply_to' => $row->reply_to,
      'send_to' => $row->send_to,
      'autogen_layout' => $row->autogen_layout,
      'custom_front' => $row->custom_front,
      'mail_from_user' => $row->mail_from_user,
      'mail_from_name_user' => $row->mail_from_name_user,
      'reply_to_user' => $row->reply_to_user,
      'disabled_fields' => $disabled_fields,
      'mail_cc' => $row->mail_cc,
      'mail_cc_user' => $row->mail_cc_user,
      'mail_bcc' => $row->mail_bcc,
      'mail_bcc_user' => $row->mail_bcc_user,
      'mail_subject' => $row->mail_subject,
      'mail_subject_user' => $row->mail_subject_user,
      'mail_mode' => $row->mail_mode,
      'mail_mode_user' => $row->mail_mode_user,
      'wpmail' => $row->wpmail,
      'sortable' => $sortable,
    ), array(
      '%s',
      '%s',
      '%s',
      '%d',
      '%s',
      '%s',
      '%d',
      '%s',
      '%s',
      '%d',
      '%d',
      '%s',
      '%s',
      '%s',
      '%s',
      '%s',
      '%s',
      '%s',
      '%d',
      '%d',
      '%s',
      '%s',
      '%s',
      '%s',
      '%s',
      '%d',
      '%s',
      '%s',
      '%s',
      '%s',
      '%s',
      '%s',
      '%s',
      '%s',
      '%s',
      '%s',
      '%s',
      '%d',
      '%d',
      '%d',
      '%d',
    ));
    $id = $wpdb->get_var("SELECT MAX(id) FROM " . $wpdb->prefix . "contactformmaker");
    $wpdb->insert($wpdb->prefix . 'contactformmaker_views', array(
      'form_id' => $id,
      'views' => 0
      ), array(
        '%d',
        '%d'
    ));
    if ($save !== FALSE) {
      return 1;
    }
    else {
      return 2;
    }
  }

  public function delete($id) {
    global $wpdb;
    $query = $wpdb->prepare('DELETE FROM ' . $wpdb->prefix . 'contactformmaker WHERE id="%d"', $id);
    if ($wpdb->query($query)) {
      $wpdb->query($wpdb->prepare('DELETE FROM ' . $wpdb->prefix . 'contactformmaker_views WHERE form_id="%d"', $id));
      $wpdb->query($wpdb->prepare('DELETE FROM ' . $wpdb->prefix . 'contactformmaker_submits WHERE form_id="%d"', $id));
      $message = 3;
    }
    else {
      $message = 2;
    }
    $page = WDW_CFM_Library::get('page');
    WDW_CFM_Library::spider_redirect(add_query_arg(array('page' => $page, 'task' => 'display', 'message' => $message), admin_url('admin.php')));
  }
  
  public function delete_all() {
    global $wpdb;
    $flag = FALSE;
    $isDefault = FALSE;
    $form_ids_col = $wpdb->get_col('SELECT id FROM ' . $wpdb->prefix . 'contactformmaker');
    foreach ($form_ids_col as $form_id) {
      if (isset($_POST['check_' . $form_id])) {
        $flag = TRUE;
        $wpdb->query($wpdb->prepare('DELETE FROM ' . $wpdb->prefix . 'contactformmaker WHERE id="%d"', $form_id));
        $wpdb->query($wpdb->prepare('DELETE FROM ' . $wpdb->prefix . 'contactformmaker_views WHERE form_id="%d"', $form_id));
        $wpdb->query($wpdb->prepare('DELETE FROM ' . $wpdb->prefix . 'contactformmaker_submits WHERE form_id="%d"', $form_id));
      }
    }
    if ($flag) {
      $message = 5;
    }
    else {
      $message = 6;
    }
    $page = WDW_CFM_Library::get('page');
    WDW_CFM_Library::spider_redirect(add_query_arg(array('page' => $page, 'task' => 'display', 'message' => $message), admin_url('admin.php')));
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