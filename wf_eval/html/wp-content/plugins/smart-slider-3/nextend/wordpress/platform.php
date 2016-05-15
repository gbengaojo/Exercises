<?php

class N2Platform
{

    public static $isAdmin = false;

    public static $hasPosts = true, $isJoomla = false, $isWordpress = false, $isMagento = false, $isNative = false;

    public static $name;

    public static function init() {
        self::$isWordpress = get_bloginfo('version');
        if (basename($_SERVER['PHP_SELF']) == 'admin.php') {
            self::$isAdmin = true;
        }
    }

    public static function getPlatform() {
        return 'wordpress';
    }

    public static function getPlatformName() {
        return 'Wordpress';
    }

    public static function getDate() {
        return current_time('mysql');
    }

    public static function getTime() {
        return current_time('timestamp');
    }

    public static function getPublicDir() {
        $upload_dir = wp_upload_dir();
        return $upload_dir['basedir'];
    }

    public static function adminHideCSS() {
        echo '
            html {
                background: #ffffff;
            }

            html.wp-toolbar {
                padding: 0;
            }

            #wpadminbar,
            #adminmenuwrap,
            #adminmenuback,
            .update-nag{
                display: none !important;
            }

            #wpcontent {
                margin: 0 !important;
                padding-left: 0;
            }
        ';
    }

    public static function updateFromZip($fileRaw, $updateInfo) {
        N2Loader::import('libraries.zip.zip_read');

        $tmpHandle = tmpfile();
        fwrite($tmpHandle, $fileRaw);
        $metaData    = stream_get_meta_data($tmpHandle);
        $tmpFilename = $metaData['uri'];

        $_GET['plugins'] = $updateInfo['plugin'];
        include_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
        $upgrader = new Plugin_Upgrader(new Plugin_Upgrader_Skin(compact('title', 'nonce', 'url', 'plugin')));

        $upgrader->init();
        $upgrader->upgrade_strings();

        add_filter('upgrader_pre_install', array(
            $upgrader,
            'deactivate_plugin_before_upgrade'
        ), 10, 2);
        add_filter('upgrader_clear_destination', array(
            $upgrader,
            'delete_old_plugin'
        ), 10, 4);

        $upgrader->run(array(
            'package'           => $tmpFilename,
            'destination'       => WP_PLUGIN_DIR,
            'clear_destination' => true,
            'clear_working'     => true,
            'hook_extra'        => array(
                'plugin' => $updateInfo['plugin'],
                'type'   => 'plugin',
                'action' => 'update',
            ),
        ));

        // Cleanup our hooks, in case something else does a upgrade on this connection.
        remove_filter('upgrader_pre_install', array(
            $upgrader,
            'deactivate_plugin_before_upgrade'
        ));
        remove_filter('upgrader_clear_destination', array(
            $upgrader,
            'delete_old_plugin'
        ));

        // Force refresh of plugin update information
        wp_clean_plugins_cache(true);
        fclose($tmpHandle);

        include(ABSPATH . 'wp-admin/admin-footer.php');

        return true;
    }

}

N2Platform::init();
