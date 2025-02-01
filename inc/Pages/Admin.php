<?php
namespace WPHFP\Inc\Pages;

defined( 'ABSPATH' ) || exit;

/**
 * @package      HEADER_FOOTER_PLUS_PLUGIN
 */

use WPHFP\Inc\Api\SettingApi;
use WPHFP\Inc\Base\BaseController;
use WPHFP\Inc\Api\Callbacks\AdminCallbacks;

class Admin extends BaseController {
	public $settings;
	public $pages = [];
	public $callbacks;

	public function register(): void {
		$this->settings  = new SettingApi();
		$this->callbacks = new AdminCallbacks();

		$this->setPages();

		$this->setSettings();
		$this->setSections();
		$this->setFields();

		$this->settings->addPages( $this->pages )->register();
	}

	/**
	 * @return void
	 * Set Admin Setting Page data
	 */
	public function setPages(): void {
		$this->pages = [
			[
				'page_title' => 'Header Footer Settings',
				'menu_title' => 'Custom scripts',
				'capability' => 'manage_options',
				'menu_slug'  => 'hfp-settings',
				'callback'   => [ $this->callbacks, 'adminDashboard' ],
				'position'   => 10,
			]
		];
	}

	/**
	 * @return void
	 * Add Settings.
	 */
	public function setSettings(): void {
		$args = [
			[
				'option_group' => 'hfp_option_group',
				'option_name'  => 'hfp_plugin_options',
				'callback'     => [ $this->callbacks, 'optionGroup' ],
			]
		];

		$this->settings->setSettings( $args );
	}

	/**
	 * @return void
	 * Add Setting Section.
	 */
	public function setSections(): void {
		$args = [
			[
				'id'       => 'hfp_main_section',
				'title'    => '',
				'callback' => [ $this->callbacks, 'optionDescription' ],
				'page'     => 'hfp-settings',
			],
		];

		$this->settings->setSections( $args );
	}

	/**
	 * @return void
	 * Add Setting Fields.
	 */
	public function setFields(): void {
		$args = [
			[
				'id'       => 'hfp_header_post_types',
				'title'    => 'Limit Header From:',
				'callback' => [ $this->callbacks, 'headerLimiter' ],
				'page'     => 'hfp-settings',
				'section'  => 'hfp_main_section',
				'args'     => [
					'label_for' => 'hfp_header_post_types',
				],
			],
			[
				'id'       => 'hfp_header_textarea',
				'title'    => 'Header Script:',
				'callback' => [ $this->callbacks, 'headerTextArea' ],
				'page'     => 'hfp-settings',
				'section'  => 'hfp_main_section',
				'args'     => [
					'label_for' => 'hfp_header_textarea',
				],
			],
			[
				'id'       => 'hfp_footer_post_types',
				'title'    => 'Limit Footer From:',
				'callback' => [ $this->callbacks, 'footerLimiter' ],
				'page'     => 'hfp-settings',
				'section'  => 'hfp_main_section',
				'args'     => [
					'label_for' => 'hfp_footer_post_types',
				],
			],
			[
				'id'       => 'hfp_footer_textarea',
				'title'    => 'Header Script:',
				'callback' => [ $this->callbacks, 'footerTextArea' ],
				'page'     => 'hfp-settings',
				'section'  => 'hfp_main_section',
				'args'     => [
					'label_for' => 'hfp_footer_textarea',
				],
			],
		];

		$this->settings->setFields( $args );
	}

}