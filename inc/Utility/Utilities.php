<?php
namespace WPHFP\Inc\Utility;
defined( 'ABSPATH' ) || exit;

/**
 * @package      HEADER_FOOTER_PLUS_PLUGIN
 */

class Utilities {

	/**
	 * @return array
	 * Get All Custom post type in WP theme. prepend Category and post types to this method.
	 */
	public static function get_post_types(): array {
		$args = [
			'public'   => true,
			'_builtin' => false
		];

		$output         = 'names'; // names or objects, note names is the default
		$operator       = 'and'; // 'and' or 'or'
		$post_types     = get_post_types( $args, $output, $operator );
		$built_in_array = [ 'post' => 'post', 'page' => 'page' ];

		return array_merge( $built_in_array, array_combine( $post_types, $post_types ) );
	}

	/**
	 * @return array
	 * Get All Custom taxonomies in WP theme. prepend Category and post_tag to this method.
	 */
	public static function get_taxonomies(): array {
		$args           = [
			'public'   => true,
			'_builtin' => false
		];
		$output         = 'names'; // or objects
		$operator       = 'and'; // 'and' or 'or'
		$taxonomies     = get_taxonomies( $args, $output, $operator );
		$built_in_array = [ 'category' => 'category', 'post_tag' => 'post_tag' ];

		return array_merge( $built_in_array, array_combine( $taxonomies, $taxonomies ) );
	}

}