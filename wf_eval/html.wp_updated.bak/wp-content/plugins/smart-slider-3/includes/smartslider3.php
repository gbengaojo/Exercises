<?php
define('NEXTEND_SMARTSLIDER_3_URL', plugins_url(NEXTEND_SMARTSLIDER_3_URL_PATH));

if (!class_exists('N2WP', false)) {
    require_once(dirname(NEXTEND_SMARTSLIDER_3__FILE__) . '/nextend/nextend.php');
    require_once(dirname(NEXTEND_SMARTSLIDER_3__FILE__) . '/library/smartslider/smartslider3.php');
}

class N2_SMARTSLIDER_3
{

    public static function init() {
        if (class_exists('N2Wordpress')) {
            N2_SMARTSLIDER_3::registerApplication();
        } else {
            add_action('nextend_loaded', 'N2_SMARTSLIDER_3::registerApplication');
        }
        add_action('admin_menu', 'N2_SMARTSLIDER_3::nextendAdminInit');

        add_action('network_admin_menu', 'N2_SMARTSLIDER_3::nextendNetworkAdminInit');

        register_activation_hook(NEXTEND_SMARTSLIDER_3__FILE__, 'N2_SMARTSLIDER_3::install');

        add_action('wpmu_new_blog', 'N2_SMARTSLIDER_3::install_new_blog');


        require_once dirname(NEXTEND_SMARTSLIDER_3__FILE__) . DIRECTORY_SEPARATOR . 'includes/shortcode.php';
        require_once dirname(NEXTEND_SMARTSLIDER_3__FILE__) . DIRECTORY_SEPARATOR . 'includes/widget.php';
        require_once dirname(NEXTEND_SMARTSLIDER_3__FILE__) . DIRECTORY_SEPARATOR . 'editor' . DIRECTORY_SEPARATOR . 'shortcode.php';
        
        add_action('et_builder_ready', 'N2_SMARTSLIDER_3::Divi_load_module');

        add_action('vc_after_set_mode', 'N2_SMARTSLIDER_3::initVisualComposer');
    }

    public static function registerApplication() {

        N2Base::registerApplication(dirname(NEXTEND_SMARTSLIDER_3__FILE__) . '/library/smartslider/N2SmartsliderApplicationInfo.php');
    }

    public static function nextendAdminInit() {
        $icon = NEXTEND_SMARTSLIDER_3_URL . '/icon.png';
        if (isset($_REQUEST['page']) && $_REQUEST['page'] == NEXTEND_SMARTSLIDER_3_URL_PATH) {
            $icon = NEXTEND_SMARTSLIDER_3_URL . '/icon-active.png';
        }


        add_menu_page('Smart Slider', 'Smart Slider', 'smartslider', NEXTEND_SMARTSLIDER_3_URL_PATH, 'N2_SMARTSLIDER_3::application', $icon);

        function nextend_smart_slider_admin_menu() {
            echo '<style type="text/css">#adminmenu .toplevel_page_' . NEXTEND_SMARTSLIDER_3_URL_PATH . ' .wp-menu-image img{opacity: 1;}</style>';
        }

        add_action('admin_head', 'nextend_smart_slider_admin_menu');
    }

    public static function nextendNetworkAdminInit() {
        $icon = NEXTEND_SMARTSLIDER_3_URL . '/icon.png';
        add_menu_page('Smart Slider Update', 'Smart Slider Update', 'smartslider', NEXTEND_SMARTSLIDER_3_URL_PATH, 'N2_SMARTSLIDER_3::networkUpdate', $icon);

        function nextend_smart_slider_admin_menu() {
            echo '<style type="text/css">#adminmenu .toplevel_page_' . NEXTEND_SMARTSLIDER_3_URL_PATH . '{display: none;}</style>';
        }

        add_action('admin_head', 'nextend_smart_slider_admin_menu');
    }

    public static function networkUpdate() {
        N2Base::getApplication("smartslider")
              ->getApplicationType('backend')
              ->setCurrent()
              ->render(array(
                  "controller" => 'update',
                  "action"     => 'update'
              ));
        n2_exit();
    }

    public static function application($dummy, $controller = 'sliders', $action = 'index') {
        N2Base::getApplication("smartslider")
              ->getApplicationType('backend')
              ->setCurrent()
              ->render(array(
                  "controller" => $controller,
                  "action"     => $action
              ));
        n2_exit();
    }

    public static function install($network_wide) {
        global $wpdb;

        N2WP::install($network_wide);

        if (is_multisite() && $network_wide) {
            $tmpPrefix = $wpdb->prefix;
            $blogs     = function_exists('wp_get_sites') ? wp_get_sites(array('network_id' => $wpdb->siteid)) : get_blog_list(0, 'all');
            foreach ($blogs AS $blog) {
                $wpdb->prefix = $wpdb->get_blog_prefix($blog['blog_id']);

                N2Base::getApplication("smartslider")
                      ->getApplicationType('backend')
                      ->render(array(
                          "controller" => "install",
                          "action"     => "index",
                          "useRequest" => false
                      ), array(true));
            }

            $wpdb->prefix = $tmpPrefix;
            return true;
        }

        N2Base::getApplication("smartslider")
              ->getApplicationType('backend')
              ->render(array(
                  "controller" => "install",
                  "action"     => "index",
                  "useRequest" => false
              ), array(true));
    }

    public static function install_new_blog($blog_id) {
        global $wpdb;
        N2WP::install_new_blog($blog_id);

        $tmpPrefix    = $wpdb->prefix;
        $wpdb->prefix = $wpdb->get_blog_prefix($blog_id);

        N2Base::getApplication("smartslider")
              ->getApplicationType('backend')
              ->render(array(
                  "controller" => "install",
                  "action"     => "index",
                  "useRequest" => false
              ), array(true));

        $wpdb->prefix = $tmpPrefix;
    }

    public static function Divi_load_module() {
        require_once dirname(__FILE__) . '/divi.php';
    }

    public static function initVisualComposer() {
        require_once dirname(__FILE__) . '/vc.php';
    }
}

N2_SMARTSLIDER_3::init();