<?php
namespace WPHFP\Inc\Meta;

defined( 'ABSPATH' ) || exit;

/**
 * @package      HEADER_FOOTER_PLUS_PLUGIN
 */

use WPHFP\Inc\Base\BaseController;
use WPHFP\Inc\Utility\Utilities;
class TermMeta extends BaseController {

	public function register(): void {
		add_action( 'init', [ $this, 'generate_taxonomy_fields' ], 100 );
	}

	/**
	 * @return void
	 * Generate custom fields for desire WP terms and taxonomies.
	 */
	public function generate_taxonomy_fields(): void {
		$taxonomies = Utilities::get_taxonomies();

		if ( $taxonomies ) {
			foreach ( $taxonomies as $key => $taxonomy ) {
				add_action( $key . '_edit_form_fields', array( $this, 'render_category_fields' ) );
				add_action( 'edited_' . $key, array( $this, 'save_category_meta' ) );
			}
		}
	}

	/**
	 * @param $term
	 *
	 * @return mixed
	 * Render custom meta box field in WP terms.
	 */
	public function render_category_fields( $term ): mixed {
		wp_nonce_field( $this->plugin_basename, 'hfp_plugin_nonce' );

		$data = get_term_meta( $term->term_id, '_hfp_term_scripts', true );
		$header      = $data['hfp_tax_header'] ?? '';
		$footer      = $data['hfp_tax_footer'] ?? '';
		$hide_header = isset( $data['hfp_tax_header_hide'] ) ? sanitize_text_field( $data['hfp_tax_header_hide'] ) : '';
		$hide_footer = isset( $data['hfp_tax_footer_hide'] ) ? sanitize_text_field( $data['hfp_tax_footer_hide'] ) : '';
		$allowed_type = [
			'script' => [ 'type' => [] ],
			'style'  => [ 'type' => [] ],
		];
		
		return require_once( "$this->plugin_path/templates/term-meta-box.php" );
	}

	/**
	 * @param $term_id
	 *
	 * @return void
	 * Save category meta data in WP term meta table.
	 */
	public function save_category_meta( $term_id ): void {

		if ( ! $this->validate_access( $term_id ) ) {
			return;
		}

		$fields = [
			'hfp_tax_header'      => [ 'type' => 'textarea' ],
			'hfp_tax_footer'      => [ 'type' => 'textarea' ],
			'hfp_tax_header_hide' => [ 'type' => 'checkbox' ],
			'hfp_tax_footer_hide' => [ 'type' => 'checkbox' ],
		];

		$data = $this->generate_term_meta( $fields );

		if ( ! empty( $data ) ) {
			update_term_meta( $term_id, '_hfp_term_scripts', $data );
		} else {
			delete_term_meta( $term_id, '_hfp_term_scripts' );
		}
	}
	
	/**
	 * @param array $fields
	 *
	 * @return array
	 * Generate array of data for all terms meta box field into one array.
	 */
	private function generate_term_meta( array $fields ): array {
		$data = [];
		foreach ( $fields as $field => $config ) {
			if ( ! empty( $_POST[ $field ] ) ) {
				$value = $_POST[ $field ];
				if ( isset( $config['type'] ) ) {
					switch ( $config['type'] ) {
						case 'checkbox':
							$data[ $field ] = sanitize_text_field( $value );
							break;
						case 'textarea':
							$data[ $field ] = $value;
							break;
						default:
							continue 2;
					}
				}
			}
		}

		return $data;
	}

	/**
	 * @param int $term_id
	 *
	 * @return bool
	 * Validate access to edit or update meta box data in terms and taxonomies.
	 */
	private function validate_access( int $term_id ): bool {
		$nonce = isset( $_POST['hfp_plugin_nonce'] ) ? sanitize_text_field( $_POST['hfp_plugin_nonce'] ) : '';

		if ( ! wp_verify_nonce( $nonce, $this->plugin_basename ) ) {
			return false;
		}

		if ( ! current_user_can( 'edit_term', $term_id ) ) {
			return false;
		}

		return true;
	}

}