<?php
namespace WPHFP\Inc\Meta;

defined( 'ABSPATH' ) || exit;

/**
 * @package      HEADER_FOOTER_PLUS_PLUGIN
 */

class ScriptManager {
	private $hfp_option = [];
	private ?int $id = null;

	public function __construct() {
		add_action( 'wp', [ $this, 'initialize_data' ] );
	}

	/**
	 * @return void
	 *  use wp_head & wp_footer to add script output to page source.
	 */
	public function register(): void {
		add_action( 'wp_head', [ $this, 'add_header_script' ] );
		add_action( 'wp_footer', [ $this, 'add_footer_script' ] );
	}

	/**
	 * @return void
	 * This method get and initialized plugin setting data in wp action hook.
	 */
	public function initialize_data(): void {
		$this->id = $this->get_current_page_id();

		if ( $this->id ) {
			$this->hfp_option = get_option( 'hfp_plugin_options' );
		}
	}

	/**
	 * @return void
	 * This method add footer script in page header source.
	 */
	public function add_header_script(): void {
		$this->render_script( 'header' );
	}

	/**
	 * @return void
	 * This method add footer script in page footer source.
	 */
	public function add_footer_script(): void {
		$this->render_script( 'footer' );
	}

	/**
	 * @param string $type
	 *
	 * @return void
	 * This method use to render script output.
	 */
	private function render_script( string $type ): void {
		if ( ! $this->id ) {
			return;
		}
		$output  = '';
		$param   = ( $type === 'header' ) ? 'hl_type' : 'fl_type';
		$generic = $this->hide_script( $param );

		if ( is_tax() || is_category() || is_tag() ) {
			$data   = get_term_meta( $this->id, '_hfp_term_scripts', true );
			$hide   = isset( $data["hfp_tax_{$type}_hide"] ) && $data["hfp_tax_{$type}_hide"] === 'on';
			$output = $data["hfp_tax_{$type}"] ?? '';
		} else {
			$data   = get_post_meta( $this->id, '_hfp_scripts', true );
			$hide   = isset( $data["hfp_{$type}_hide"] ) && $data["hfp_{$type}_hide"] === 'on';
			$output = $data["hfp_{$type}"] ?? '';
		}

		if ( $hide || $generic ) {
			return;
		}

		$hfp_options = $this->hfp_option;
		if ( isset( $hfp_options[ $type ] ) ) {
			$output .= $hfp_options[ $type ];
		}

		echo stripslashes( $output );

	}

	/**
	 * @param $param
	 *
	 * @return bool
	 * this method check is hide header or footer in plugin setting page.
	 */
	private function hide_script( $param ): bool {
		$hide = $this->hfp_option;
		if ( isset( $hide[ $param ] ) ) {
			return in_array( get_post_type(), $hide[ $param ] );
		}

		return false; // if not set - hide on all
	}

	/**
	 * @return int
	 * This method return current page id in WP.
	 */
	private function get_current_page_id(): int {
		global $post;

		if ( class_exists( 'WooCommerce' ) && is_shop() ) {
			return wc_get_page_id( 'shop' );
		}

		if ( is_category() || is_tag() || is_tax() ) {
			$term = get_queried_object();

			return $term->term_id ?? 0;
		}

		return ! empty( $post->ID ) && is_singular() ? (int) $post->ID : 0;
	}
}