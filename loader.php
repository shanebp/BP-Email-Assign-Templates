<?php
/*
Plugin Name: BP Email Assign Templates
Description: Assign Templates to BuddyPress Emails
Version: 1.0
Author: shanebp
Author URI: http://philopress.com/
Text Domain: bp-email-templates
Domain Path: /languages
License: GPLv2 or later
*/

if ( !defined( 'ABSPATH' ) ) exit;

function pp_etemplates_init() {

	$vcheck = pp_etemplates_version_check();

	if( $vcheck ) {

		load_plugin_textdomain( 'bp-email-templates', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );

		if ( is_admin() || is_network_admin() ) {
			require( dirname( __FILE__ ) . '/pp-email-templates-admin.php' );
			require( dirname( __FILE__ ) . '/pp-email-templates-admin-metabox.php' );
		}

	}
}
add_action( 'bp_include', 'pp_etemplates_init' );



function pp_etemplates_activation() {

	$vcheck = pp_etemplates_version_check();

	if( $vcheck ) {

		pp_etemplates_options_default();

	}
}
register_activation_hook(__FILE__, 'pp_etemplates_activation');


function pp_etemplates_options_default() {

	add_option( 'bp_email_templates_count', 0, NULL, false );

	$option_name = 'bp-email-template-0';

	$option_value = array(
			'oname' => 'Default Template',
			'fname' => 'single-bp-email.php',
		);

	add_option( 'bp-email-template-0', $option_value, NULL, false );

}

function pp_etemplates_deactivation () {
	// to do
}
register_deactivation_hook(__FILE__, 'pp_etemplates_deactivation');


function pp_etemplates_uninstall () {
	// to do
}
register_uninstall_hook( __FILE__, 'pp_etemplates_uninstall');


function pp_etemplates_version_check() {

	if ( ! defined( 'BP_VERSION' ) )
		return false;

	if( version_compare( BP_VERSION, '2.5.1', '>=' ) )
		return true;
	else {
		echo '<div id="message" class="error">BP Email Templates requires at least version 2.5.1 of BuddyPress.</div>';
		return false;
	}
}

function pp_etemplates_bp_check() {

	if ( !class_exists('BuddyPress') )
		add_action( 'admin_notices', 'pp_etemplates_install_buddypress_notice' );

}
add_action('plugins_loaded', 'pp_etemplates_bp_check', 999);

function pp_etemplates_install_buddypress_notice() {
	echo '<div id="message" class="error fade"><p style="line-height: 150%">';
	_e('<strong>BP Email Templates</strong></a> requires the BuddyPress plugin. Please <a href="http://buddypress.org/download">install BuddyPress</a> first, or <a href="plugins.php">deactivate BP Email Templates</a>.');
	echo '</p></div>';
}



// filter the template used by bp_mail if a specific template has been assigned
function pp_etemplates_template( $templates, $obj )  {

	$value = get_post_meta( $obj->ID, 'bp-etemplate', true );

    if ( empty( $value ) || $value == 'bp-email-template-0' ) {
        return $templates;
	}
	else {

		$option = get_option( $value );

		if ( ! $option ) {

			// option does not exist, so get rid of post_meta and use another template
			delete_post_meta( $obj->ID, 'bp-etemplate' );

			return $templates;

		}
		else {

			$filename = $option['fname'];

			array_unshift( $templates , $filename );

			return $templates;
		}
	}
}
add_filter( 'bp_email_get_template', 'pp_etemplates_template', 21, 2 );
