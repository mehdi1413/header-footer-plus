<?php
namespace WPHFP\Inc\Base;

defined( 'ABSPATH' ) || exit;

/**
 * @package      HEADER_FOOTER_PLUS_PLUGIN
 */
class BaseController {
	public $plugin_basename;
	public $plugin_url;
	public $plugin_path;
	public $options;

	public function __construct() {
		$this->plugin_path     = plugin_dir_path( dirname( __FILE__, 2 ) );
		$this->plugin_url      = plugin_dir_url( dirname( __FILE__, 2 ) );
		$this->plugin_basename = plugin_basename( dirname( __FILE__, 3 ) ) . '/header-footer-plus.php';
		$this->options = get_option('hfp_plugin_options');
	}

}