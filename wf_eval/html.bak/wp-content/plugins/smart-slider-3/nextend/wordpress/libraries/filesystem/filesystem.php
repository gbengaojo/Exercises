<?php

/**
 * Class N2Filesystem
 */
class N2Filesystem extends N2FilesystemAbstract
{

    public function __construct() {
        $this->_basepath    = realpath(WP_CONTENT_DIR);
        $this->_librarypath = str_replace($this->_basepath, '', N2LIBRARY);
    }

    public static function getImagesFolder() {
        return N2Platform::getPublicDir();
    }

    public static function getWebCachePath() {
        if(!NEXTEND_CUSTOM_CACHE) {
            self::check(self::getBasePath(), 'cache');
        }
        if (is_multisite()) {
            return self::getBasePath() . NEXTEND_RELATIVE_CACHE_WEB . get_current_blog_id();
        }
        return self::getBasePath() . NEXTEND_RELATIVE_CACHE_WEB;
    }

    public static function getNotWebCachePath() {
        if (is_multisite()) {
            return self::getBasePath() . NEXTEND_RELATIVE_CACHE_NOTWEB . get_current_blog_id();
        }
        return self::getBasePath() . NEXTEND_RELATIVE_CACHE_NOTWEB;
    }
}