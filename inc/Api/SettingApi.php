<?php

namespace WPHFP\Inc\Api;

defined( 'ABSPATH' ) || exit;

/**
 * @package      HEADER_FOOTER_PLUS_PLUGIN
 */

use WPHFP\Inc\Base\BaseController;

class SettingApi extends BaseController {

	public $admin_pages = [];
	public $settings = [];
	public $sections = [];
	public $fields = [];

	public function register(): void {
		if ( ! empty( $this->admin_pages ) ) {
			add_action( 'admin_menu', [ $this, 'add_admin_menu' ] );
		}

		if ( ! empty( $this->settings ) ) {
			add_action( 'admin_init', [ $this, 'registerCustomFields' ] );
		}
	}

	/**
	 * @param array $pages
	 *
	 * @return $this
	 * Add setting page.
	 */
	public function addPages( array $pages ): static {
		$this->admin_pages = $pages;

		return $this;
	}

	/**
	 * @return void
	 * Add or register plugin Setting menu.
	 */
	public function add_admin_menu(): void {
		foreach ( $this->admin_pages as $page ) {
			$suffix = add_options_page(
				$page['page_title'],
				$page['menu_title'],
				$page['capability'],
				$page['menu_slug'],
				$page['callback'],
				$page['position']
			);

			add_action( 'load-' . $suffix, [ $this, 'enqueue_assets' ] );
		}
	}

	/**
	 * @return void
	 * Register all plugin setting page fields.
	 */
	public function registerCustomFields(): void {
		foreach ( $this->settings as $setting ) {
			register_setting(
				$setting['option_group'],
				$setting['option_name'],
				( isset( $setting['callback'] ) ) ? $setting['callback'] : ''
			);
		}

		foreach ( $this->sections as $section ) {
			add_settings_section(
				$section['id'],
				$section['title'],
				( isset( $section['callback'] ) ) ? $section['callback'] : '',
				$section['page'],
			);
		}

		foreach ( $this->fields as $field ) {
			add_settings_field(
				$field['id'],
				$field['title'],
				( isset( $field['callback'] ) ) ? $field['callback'] : '',
				$field['page'],
				$field['section'],
				( isset( $field['args'] ) ) ? $field['args'] : '',
			);
		}
	}

	/**
	 * @param array $settings
	 *
	 * @return $this
	 * Set plugin setting page.
	 */
	public function setSettings( array $settings ): static {
		$this->settings = $settings;

		return $this;
	}

	/**
	 * @param array $sections
	 *
	 * @return $this
	 * Set Plugin setting page sections.
	 */
	public function setSections( array $sections ): static {
		$this->sections = $sections;

		return $this;
	}

	/**
	 * @param array $fields
	 *
	 * @return $this
	 * Set plugin setting page fields
	 */
	public function setFields( array $fields ): static {
		$this->fields = $fields;

		return $this;
	}

	/**
	 * @return void
	 * Enqueue CodeEditor in plugin setting page.
	 */
	public function enqueue_assets(): void {
		if ( ! wp_script_is( 'code-editor', 'enqueued' ) ) {
			$plugin_asset_url = $this->plugin_url . 'assets/js/setting.js';

			$args        = [
				'codemirror' => [
					'mode'        => 'htmlmixed',
					'lineNumbers' => true,
					'indentUnit'  => 4,
				],
			];
			$code_mirror = wp_enqueue_code_editor( $args );

			wp_enqueue_script( 'hpf-script', $plugin_asset_url, [ 'jquery' ], '1.1.0' );
			wp_localize_script( 'hpf-script', 'hpf_code_mirror', $code_mirror );
		}
	}

}
