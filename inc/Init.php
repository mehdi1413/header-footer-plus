<?php
namespace WPHFP\Inc;

defined( 'ABSPATH' ) || exit;

/**
 * @package      HEADER_FOOTER_PLUS_PLUGIN
 */

final class Init {
	/**
	 * store all the classes inside in array
	 * @return array full list of classes
	 */
	public static function get_services(): array {
		return [
			Pages\Admin::class,
			Base\SettingLinks::class,
			Meta\PostMeta::class,
			Meta\TermMeta::class,
			Meta\ScriptManager::class,
		];
	}

	/**
	 * @return void
	 */
	public static function register_services(): void {
		foreach ( self::get_services() as $class ) {
			$service = self::instantiate( $class );
			if ( method_exists( $service, 'register' ) ) {
				$service->register();
			}
		}
	}

	/**
	 * initialize the class
	 *
	 * @param $class
	 *
	 * @return mixed
	 */
	private static function instantiate( $class ): mixed {
		return new $class();
	}
}