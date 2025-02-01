<?php
defined( 'ABSPATH' ) || exit;

/**
 * Trigger this file when plugin uninstall
 * @package      HEADER_FOOTER_PLUS_PLUGIN
 */

// if uninstall.php is not called by WordPress, die
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	die;
}

global $wpdb;
delete_option( 'hfp_plugin_options' );
// remove all post meta data.
$wpdb->query( "DELETE FROM {$wpdb->postmeta} WHERE meta_key LIKE '%_hfp_scripts%'" );
// remove all term meta data.
$wpdb->query( "DELETE FROM {$wpdb->termmeta} WHERE meta_key LIKE '%_hfp_term_scripts%'" );