<?php

namespace UTEC;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use UTEC\Common\Interfaces\Has_Hooks;
use UTEC\Common\Traits\Is_Singleton;
use UTEC\Admin\Table_Page;
use UTEC\Data\Roles;
use UTEC\Data\Users;

/**
 * Our plugin main class.
 */
class Plugin {
	use Is_Singleton;

	/**
	 * Array to store our services
	 *
	 * @var null|array
	 */
	protected $services = null;

	/**
	 * Fire our plugin: load hooks, localize language files, register assets
	 *
	 * @return void
	 */
	public function fire() {
		$this->hooks();
		$this->set_services();
		$hooks = new Setup\Register_Hooks( __NAMESPACE__ );
	}

	/**
	 * Sett globally available services.
	 */
	protected function set_services() {
		$this->services = [
			'roles' => new Roles(),
			'users' => new Users(),
		];
	}

	/**
	 * Get a specific service
	 *
	 * @param string $service The service we need.
	 * @return object|Exception
	 */
	public function get_service( $service ) {
		if ( isset( $this->services[ $service ] ) ) {
			return $this->services[ $service ];
		}

		throw new \Exception( sprintf( 'Service is not available: "%1$s" ).', $service ) );
	}

	/**
	 * Register required hooks.
	 */
	public function hooks() {
		add_filter( 'plugin_action_links_' . UTEC_BASENAME, [ $this, 'plugin_settings_link' ] );
	}

	/**
	 * Output the Settings link on the Plugins admin page
	 *
	 * @param array $links A list of existing links.
	 * @return array A new list of links.
	 */
	public function plugin_settings_link( $links ) {
		$settings_url = Table_Page::get_table_page_admin_url();

		$settings_link_tag = sprintf(
			'<a href="%1$s">%2$s</a>',
			esc_url( $settings_url ),
			__( 'See in action', 'utec' )
		);

		array_unshift( $links, $settings_link_tag );

		return $links;
	}

	/**
	 * Used only to reveal JS strings to POEdit in order to translate them.
	 */
	public static function translate_js_strings() {
		$to_translate = [
			__( 'Previous', 'utec' ),
			__( 'Page %1$d of %2$d', 'utec' ),
			__( 'Next', 'utec' ),
			__( 'Username', 'utec' ),
			__( 'Name', 'utec' ),
			__( 'E-mail address', 'utec' ),
			__( 'Role(s)', 'utec' ),
			__( 'Profile picture for user %1$s', 'utec' ),
		];
	}

	/**
	 * Executed when plugin is activated.
	 */
	public static function activate() {}

	/**
	 * Executed when plugin is de-activated.
	 */
	public static function deactivate() {}
}
