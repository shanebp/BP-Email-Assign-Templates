<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;


function pp_etemplates_custom_metabox(){

	add_meta_box( 'bp-etemplate', __( 'Email Template', 'bp-email-templates' ), 'pp_etemplates_template_metabox', null, 'side', 'low' );
}
add_action( 'add_meta_boxes_' . bp_get_email_post_type(), 'pp_etemplates_custom_metabox' );


function pp_etemplates_template_metabox( $obj ) {
	global $wpdb;

	$query = "SELECT * FROM {$wpdb->prefix}options WHERE option_name LIKE 'bp-email-template-_' ORDER BY option_id ASC ";

	$items = $wpdb->get_results( $query );

	if ( !empty( $items ) ) {

		wp_nonce_field(basename(__FILE__), "bp-etemplate-meta-box-nonce");

		$assigned_template = get_post_meta( $obj->ID, 'bp-etemplate', true );

		echo '<div class="categorydiv">';
		echo	'<div class="tabs-panel"><ul>';

		foreach( $items as $item ) {

			$item_data = maybe_unserialize( $item->option_value );

			$template_exists = locate_template( $item_data['fname'], false );

			$checked = '';

			if ( $item->option_name == 'bp-email-template-0' && empty( $assigned_template ) )
				$checked = ' checked';
			elseif ( $item->option_name == $assigned_template )
				$checked = ' checked';

			if ( ! empty ( $template_exists ) ) {
				echo '<br><li class="popular-category"><label class="selectit"><input value="' . $item->option_name . '" type="radio" name="bp-etemplates" ' . $checked .'>' .  $item_data['oname'] . '</label></li>';
			}
			elseif ( $item->option_name == 'bp-email-template-0' ) {
				echo '<br><li class="popular-category"><label class="selectit"><input value="bp-email-template-0" type="radio" name="bp-etemplates" checked>Default Template</label></li>';
			}
		}

		echo '</ul><br></div></div>';
	}
}


function pp_etemplates_custom_metabox_save( $post_id, $post, $update ) {

    if ( !isset( $_POST['bp-etemplate-meta-box-nonce'] ) || !wp_verify_nonce( $_POST['bp-etemplate-meta-box-nonce'], basename(__FILE__) ) )
        return $post_id;

    if ( !current_user_can('manage_options') )
        return $post_id;

    if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE )
        return $post_id;

    if ( isset( $_POST['bp-etemplates'] ) ) {

        $value = $_POST['bp-etemplates'];

        update_post_meta( $post_id, 'bp-etemplate', $value );
    }

}
add_action( 'save_post_' . bp_get_email_post_type(), 'pp_etemplates_custom_metabox_save', 21, 3 );


//  protect the custom meta box so that it does not appear in custom-fields support
function pp_etemplates_custom_metabox_protect ( $protected, $meta_key, $meta_type ){

	if ( $meta_key == 'bp-etemplate' )
		$protected = true;

	return $protected;
}
add_filter( 'is_protected_meta', 'pp_etemplates_custom_metabox_protect', 21, 3 );
