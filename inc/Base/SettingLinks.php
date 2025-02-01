<?php
namespace WPHFP\Inc\Base;

defined( 'ABSPATH' ) || exit;

/**
 * @package      HEADER_FOOTER_PLUS_PLUGIN
 */

use WPHFP\Inc\Base\BaseController;

class SettingLinks extends BaseController {

	public function register(): void {
		add_filter( "plugin_action_links_$this->plugin_basename", [ $this, 'settings_link' ], );
	}

	public function settings_link( $links ) {
		// add custom setting links
		$setting_links = '<a href="options-general.php?page=hfp-settings">settings</a>';
		$links[]       = $setting_links;

		return $links;
	}
}