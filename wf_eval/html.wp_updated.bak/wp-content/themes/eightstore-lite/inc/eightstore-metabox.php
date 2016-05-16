<?php
add_action('add_meta_boxes', 'eightstore_lite_add_sidebar_layout_box');
function eightstore_lite_add_sidebar_layout_box()
{
    
    add_meta_box(
                 'eightstore_lite_sidebar_layout', // $id
                 'Sidebar Layout', // $title
                 'eightstore_lite_sidebar_layout_callback', // $callback
                 'page', // $page
                 'normal', // $context
                 'high' // $priority
                 ); 
    add_meta_box(
                 'eightstore_lite_post_sidebar_layout', // $id
                 'Sidebar Layout for Posts', // $title
                 'eightstore_lite_sidebar_layout_callback', // $callback
                 'post', // $page
                 'normal', // $context
                 'high' // $priority
                 );
}
$eightstore_lite_sidebar_layout = array(
    'sidebar-left' => array(
        'value'     => 'sidebar-left',
        'label'     => __( 'Left sidebar', 'eightstore-lite' ),
        'thumbnail' => get_template_directory_uri() . '/inc/images/sidebar-left.png'
        ), 
    'sidebar-right' => array(
        'value' => 'sidebar-right',
        'label' => __( 'Right sidebar (default)', 'eightstore-lite' ),
        'thumbnail' => get_template_directory_uri() . '/inc/images/sidebar-right.png'
        ),
    'sidebar-both' => array(
        'value'     => 'sidebar-both',
        'label'     => __( 'Both Sidebar', 'eightstore-lite' ),
        'thumbnail' => get_template_directory_uri() . '/inc/images/sidebar-both.png'
        ),
    
    'sidebar-no' => array(
        'value'     => 'sidebar-no',
        'label'     => __( 'No sidebar', 'eightstore-lite' ),
        'thumbnail' => get_template_directory_uri() . '/inc/images/sidebar-no.png'
        )   

    );


function eightstore_lite_sidebar_layout_callback()
{ 
    global $post , $eightstore_lite_sidebar_layout;
    wp_nonce_field( basename( __FILE__ ), 'eightstore_lite_sidebar_layout_nonce' ); 
    ?>

    <table class="form-table">
        <tr>
            <td colspan="4"><em class="f13"><?php echo __('Choose Sidebar Template','eightstore-lite');?></em></td>
        </tr>

        <tr>
            <td>
                <?php  
                foreach ($eightstore_lite_sidebar_layout as $field) {  
                    $eightstore_lite_sidebar_metalayout = get_post_meta( $post->ID, 'eightstore_lite_sidebar_layout', true ); ?>

                    <div class="radio-image-wrapper" style="float:left; margin-right:30px;">
                        <label class="description">
                            <span><img src="<?php echo esc_url( $field['thumbnail'] ); ?>" alt="" /></span></br>
                            <input type="radio" name="eightstore_lite_sidebar_layout" value="<?php echo esc_attr($field['value']); ?>" <?php checked( $field['value'], $eightstore_lite_sidebar_metalayout ); if(empty($eightstore_lite_sidebar_metalayout) && $field['value']=='sidebar-right'){ echo "checked='checked'";} ?>/>&nbsp;<?php echo esc_attr($field['label']); ?>
                        </label>
                    </div>
                <?php } // end foreach 
                ?>
                <div class="clear"></div>
            </td>
        </tr>
    </table>

    <?php } 

/**
 * save the custom metabox data
 * @hooked to save_post hook
 */
function eightstore_lite_save_sidebar_layout( $post_id ) { 
    global $eightstore_lite_sidebar_layout, $post; 

    // Verify the nonce before proceeding.
    if ( !isset( $_POST[ 'eightstore_lite_sidebar_layout_nonce' ] ) || !wp_verify_nonce( $_POST[ 'eightstore_lite_sidebar_layout_nonce' ], basename( __FILE__ ) ) )
        return;

    // Stop WP from clearing custom fields on autosave
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE)  
        return;
    
    if ('page' == $_POST['post_type']) {  
        if (!current_user_can( 'edit_page', $post_id ) )  
            return $post_id;  
    } elseif (!current_user_can( 'edit_post', $post_id ) ) {  
        return $post_id;  
    }  
    

    foreach ($eightstore_lite_sidebar_layout as $field) {  
        //Execute this saving function
        $old = get_post_meta( $post_id, 'eightstore_lite_sidebar_layout', true); 
        $new = sanitize_text_field($_POST['eightstore_lite_sidebar_layout']);
        if ($new && $new != $old) {  
            update_post_meta($post_id, 'eightstore_lite_sidebar_layout', $new);  
        } elseif ('' == $new && $old) {  
            delete_post_meta($post_id,'eightstore_lite_sidebar_layout', $old);  
        } 
     } // end foreach   
     
 }
 add_action('save_post', 'eightstore_lite_save_sidebar_layout');