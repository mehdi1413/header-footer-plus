<?php
namespace WPHFP\Inc\Api\Callbacks;

defined( 'ABSPATH' ) || exit;

/**
 * @package      HEADER_FOOTER_PLUS_PLUGIN
 */

use WPHFP\Inc\Base\BaseController;
use WPHFP\Inc\Utility\Utilities;
class AdminCallbacks extends BaseController {

	/**
	 * @return mixed
	 * Render a main template view for show plugin setting page.
	 */
	public function adminDashboard(): mixed {
		return require_once( "$this->plugin_path/templates/admin.php" );
	}

	/**
	 * @param $input
	 *
	 * @return array
	 * Manage all data when update/save plugin setting page.
	 */
	public function optionGroup( $input ): array {
		$new_input = [];

		if ( ! empty( $input['hl_type'] ) ) {
			$new_input['hl_type'] = $this->sanitizeCheckbox( $input['hl_type'] );
		}

		if ( ! empty( $header = $input['header'] ) ) {
			$new_input['header'] = $this->sanitizeTextArea( $input['header'] );
		}

		if ( ! empty( $input['fl_type'] ) ) {
			$new_input['fl_type'] = $this->sanitizeCheckbox( $input['fl_type'] );
		}

		if ( ! empty( $footer = $input['footer'] ) ) {
			$new_input['footer'] = $this->sanitizeTextArea( $input['footer'] );
		}

		return $new_input;
	}

	/**
	 * @return void
	 * Render a paragraph html tag to display plugin setting page.
	 */
	public function optionDescription(): void {
		echo "For individual pages please go to the page itself and use the Header Footer script section there";
	}

	/**
	 * @return void
	 * Render a textarea field for header script code.
	 */
	public function headerTextArea(): void {
		$data  = $this->options;
		$value = isset( $data['header'] ) ? esc_html( $data['header'] ) : '';

		echo '<textarea style="margin:0; width: 730px; height: 211px;" id="hfp_header_textarea" name="hfp_plugin_options[header]">' . wp_kses( $value, $this->allowedHtml() ) . '</textarea>';
	}

	/**
	 * @return void
	 * Render a textarea field for footer script code.
	 */
	public function footerTextArea(): void {
		$data  = $this->options;
		$value = isset( $data['footer'] ) ? esc_html( $data['footer'] ) : '';

		echo '<textarea style="margin:0; width: 730px; height: 211px;" id="hfp_footer_textarea" name="hfp_plugin_options[footer]">' . wp_kses( $value, $this->allowedHtml() ) . '</textarea>';
	}

	/**
	 * @return void
	 * Generate a list of checkbox for hide or show header script from source for desire post type.
	 */
	public function headerLimiter(): void {
		echo '<div style="display:flex;align-items:flex-end">';
		$this->limiter( 'hfp_header_post_types' );
		echo '</div>';
	}

	/**
	 * @return void
	 * Generate a list of checkbox for hide or show footer script from source for desire post type.
	 */
	public function footerLimiter(): void {
		echo '<div style="display:flex;align-items:flex-end">';
		$this->limiter( 'hfp_footer_post_types' );
		echo '</div>';
	}

	/**
	 * @param string $name
	 *
	 * @return void
	 * Generate a list of checkbox by desire post types.
	 */
	private function limiter( string $name ): void {
		$post_types = Utilities::get_post_types();
		$prefix     = 'txt';
		( $name === 'hfp_header_post_types' ) ? $prefix = 'hl' : ( ( $name === 'hfp_footer_post_types' ) ? $prefix = 'fl' : 'text' );
		$field = $prefix . '_type';

		$selected = $this->options[ $field ] ?? [];
		foreach ( $post_types as $key => $post_type ) {
			$checked = ( in_array( $post_type, $selected ) ) ? 'checked="checked"' : '';
			$id      = $prefix . '_' . $key;
			echo '<input value="' . $post_type . '" type="checkbox" name="hfp_plugin_options[' . $field . '][]" id="' . $id . '" ' . $checked . '/><label style="margin-left:7px" for="' . $id . '">' . $post_type . '</label>';
		}
	}

	/**
	 * @param $input
	 *
	 * @return bool
	 * Check the value of checkbox is valid or not.
	 */
	private function allowCheckboxValue( $input ): bool {
		if ( in_array( $input, Utilities::get_post_types() ) ) {
			return true;
		}

		return false;
	}

	/**
	 * @param $values
	 *
	 * @return array
	 * Sanitize checkbox value.
	 */
	private function sanitizeCheckbox( $values ): array {
		$valid_values = [];
		foreach ( $values as $value ) {
			if ( $this->allowCheckboxValue( $value ) ) {
				$valid_values[] = $value;
			}
		}

		return $valid_values;
	}

	/**
	 * @param $value
	 *
	 * @return string
	 * Use to Clear and sanitize input scripts.
	 */
	private function sanitizeTextArea( $value ): string {
		return wp_kses( $value, $this->allowedHtml() );
	}

	/**
	 * @return array[]
	 * Select Allowed Html use in wp_kses method.
	 */
	private function allowedHtml(): array {
		return [
			'script' => [
				'type' => []
			],
			'style'  => [
				'type' => [],
			],
		];
	}
	
}