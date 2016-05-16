<?php
//add new custom control type switch
if(class_exists( 'WP_Customize_control')):
	class Eightstore_lite_WP_Customize_Switch_Control extends WP_Customize_Control {
		public $type = 'switch';
		public function render_content() {
			?>
			<label>
				<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
				<span class="description customize-control-description"><?php echo esc_html( $this->description ); ?></span>
				<div class="switch_options">
					<span class="switch_enable"><?php _e('Yes','eightstore-lite'); ?></span>
					<span class="switch_disable"><?php _e('No','eightstore-lite'); ?></span>  
					<input type="hidden" id="switch_yes_no" <?php $this->link(); ?> value="<?php echo $this->value(); ?>" />
				</div>
			</label>
			<?php
		}
	}
	endif;

	//load js to control function of switch
	function inc_custom_admin_style($hook) {
		if ( 'customize.php' == $hook || 'widgets.php' == $hook ) {
			wp_enqueue_style( 'eightstore-control-admin-css', get_template_directory_uri() . '/inc/css/admin-control.css');
			wp_enqueue_script( 'eightstore-control-admin-js', get_template_directory_uri().'/inc/js/admin-control.js', array( 'jquery' ), '20150611', true );
		}else{
			return;
		}
	}
	add_action( 'admin_enqueue_scripts', 'inc_custom_admin_style' );