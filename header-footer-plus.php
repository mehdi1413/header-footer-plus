<?php
defined( 'ABSPATH' ) || exit;
/**
 * @package      HEADER_FOOTER_PLUS_PLUGIN
 * @copyright    Copyright (C) 2023-2025, header footer plus Plugin
 * @link         https://github.com/mehdi1413
 * @since        1.0.0
 */

/**
 * Plugin Name: Header Footer Plus
 * Plugin URI: https://github.com/mehdi1413/header-footer-plus
 * Description:  create a simple way to add js code to individual page post or custom post type header
 * and footer, in this way it enables you to add google re-marketing code to individual pages
 * Version: 1.0.0
 * Author: mehdi fani
 * Author URI: https://github.com/mehdi1413
 * License: GPLv2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 */

if ( file_exists( dirname( __FILE__ ) . '/vendor/autoload.php' ) ) {
	require_once dirname( __FILE__ ) . '/vendor/autoload.php';
}

if ( class_exists( 'WPHFP\Inc\Init' ) ) {
	WPHFP\Inc\Init::register_services();
}

/**
 * @return void
 * Activate plugin.
 */
function activate_hfp_plugin(): void {
	WPHFP\Inc\Base\Activate::activate();
}
register_activation_hook( __FILE__, 'activate_hfp_plugin' );

/**
 * @return void
 * Deactivate plugin.
 */
function deactivate_hfp_plugin(): void {
	WPHFP\Inc\Base\Deactivate::deactivate();
}
register_deactivation_hook( __FILE__, 'deactivate_hfp_plugin' );