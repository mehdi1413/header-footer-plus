<?php
namespace WPHFP\Inc\Meta;

defined( 'ABSPATH' ) || exit;

/**
 * @package      HEADER_FOOTER_PLUS_PLUGIN
 */

use WPHFP\Inc\Base\BaseController;
use WPHFP\Inc\Utility\Utilities;
class PostMeta extends BaseController {
	
	public function register(): void {
		add_action( 'add_meta_boxes', [ $this, 'add_custom_box' ] );
		add_action( 'save_post', [ $this, 'save_meta_box' ] );
	}

	/**
	 * @return void
	 * Add and register custom meta box field in post types.
	 */
	public function add_custom_box(): void {
		$screens = Utilities::get_post_types();

		foreach ( $screens as $screen ) {
			add_meta_box(
				'hfp_plugin_box_id',
				'Custom Header & Footer',
				[ $this, 'render_meta_box' ],
				$screen
			);
		}
	}

	/**
	 * @param \WP_Post $post
	 *
	 * @return mixed
	 * Render custom meta box html structure.
	 */
	public function render_meta_box( \WP_Post $post ): mixed {
		wp_nonce_field( $this->plugin_basename, 'hfp_plugin_nonce' );
		$data        = get_post_meta( $post->ID, '_hfp_scripts', true );
		$header      = $data['hfp_header'] ?? '';
		$footer      = $data['hfp_footer'] ?? '';
		$hide_header = isset( $data['hfp_header_hide'] ) ? esc_attr( $data['hfp_header_hide'] ) : '';
		$hide_footer = isset( $data['hfp_footer_hide'] ) ? esc_attr( $data['hfp_footer_hide'] ) : '';
		$allowed_type = [
			'script' => [ 'type' => [] ],
			'style'  => [ 'type' => [] ],
		];
		
		return require_once( "$this->plugin_path/templates/post-meta-box.php" );
	}

	/**
	 * @param int $post_id
	 *
	 * @return void
	 * Save plugin custom meta box field to wp post meta table.
	 */
	public function save_meta_box( int $post_id ): void {

		if ( ! $this->validate_access( $post_id ) ) {
			return;
		}

		$fields = [
			'hfp_header'      => [ 'type' => 'textarea' ],
			'hfp_footer'      => [ 'type' => 'textarea' ],
			'hfp_header_hide' => [ 'type' => 'checkbox' ],
			'hfp_footer_hide' => [ 'type' => 'checkbox' ],
		];

		$data = $this->generate_post_meta( $fields );

		if ( ! empty( $data ) ) {
			update_post_meta( $post_id, '_hfp_scripts', $data );
		} else {
			delete_post_meta( $post_id, '_hfp_scripts' );
		}
	}

	/**
	 * @param array $fields
	 *
	 * @return array
	 * Generate array of data for all meta box field into one array.
	 */
	private function generate_post_meta( array $fields ): array {
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
	 * @param int $post_id
	 *
	 * @return bool
	 * Validate access to edit or update meta box data.
	 */
	private function validate_access( int $post_id ): bool {
		$nonce = isset( $_POST['hfp_plugin_nonce'] ) ? sanitize_text_field( $_POST['hfp_plugin_nonce'] ) : '';

		if ( ! wp_verify_nonce( $nonce, $this->plugin_basename ) ) {
			return false;
		}

		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return false;
		}

		if ( wp_doing_ajax() ) {
			return false;
		}

		return true;
	}
}