<?php

class testimonial_rotator_theme_updater
{
	var $theme_slug;
	var $version;
	var $basename;
	
	function __construct( $slug, $version, $basename )
	{
		$this->theme_slug 	= $slug;
		$this->version 		= $version;
		$this->basename 	= $basename;

		add_filter('pre_set_site_transient_update_plugins', array($this, 'check_update'));
		add_filter('plugins_api', array($this, 'check_info'), 10, 3);
	}

	private function get_remote()
	{
		$updater_email = get_option('testimonial-rotator-theme-license-email');
		if( !$updater_email AND defined('TESTIMONIAL_ROTATOR_THEME_LICENSE') ) $updater_email = TESTIMONIAL_ROTATOR_THEME_LICENSE;
		
        $info = false;
		$ping_url = "https://halgatewood.com/?edd_au_check_plugin=true";
		$ping_url .= "&email=" . urlencode( $updater_email );
		$ping_url .= "&version=" . urlencode( $this->version );
		$ping_url .= "&slug=" . urlencode( $this->theme_slug );
		
        $request = wp_remote_post( $ping_url );
        if( !is_wp_error($request) || wp_remote_retrieve_response_code($request) === 200)
        {
            $info = @unserialize($request['body']);
        }

        return $info;
	}
	
	public function check_update( $transient )
	{
	    if( empty($transient->checked) ) return $transient;
        
        $info = $this->get_remote();
        if( !$info ) return $transient;
        if( version_compare($info->version, $this->version, '<=') ) return $transient;
        
        $obj = new stdClass();
        $obj->slug 				= $this->theme_slug;
        $obj->plugin			= $this->basename;
        
        $obj->new_version 		= $info->version;
        $obj->url 				= $info->homepage;
        $obj->package 			= $info->download_link;
        $transient->response[ $this->basename ] = $obj;

        return $transient;
	}
	
    public function check_info( $result, $action, $args )
    {
	    if( isset($args->slug) && $args->slug == $this->theme_slug ) 
	    {
			return $this->get_remote();
	    }
        return $result;
    }
}
