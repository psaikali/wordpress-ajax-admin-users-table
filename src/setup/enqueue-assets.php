<?php

namespace UTEC\Setup;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use UTEC\Common\Interfaces\Has_Hooks;
use UTEC\Admin\Table_Page;
use UTEC\Utils;

/**
 * Enqueue plugin assets
 */
class Enqueue_Assets implements Has_Hooks {
	/**
	 * Necessary hooks
	 */
	public function hooks() {
		add_action( 'admin_enqueue_scripts', [ $this, 'register_scripts_and_styles' ] );
	}

	/**
	 * Register plugin scripts and styles
	 *
	 * @return void
	 */
	public function register_scripts_and_styles() {
		$plugin_admin_page_id = 'users_page_' . Table_Page::SLUG;

		if ( is_null( get_current_screen() ) || $plugin_admin_page_id !== get_current_screen()->id ) {
			return;
		}

		// CSS styling.
		wp_enqueue_style( 'utec-admin-style', UTEC_ASSETS_URL . '/admin/styles/admin.css', [], UTEC_VERSION );

		// Javascript React app.
		wp_enqueue_script( 'utec-admin-script', UTEC_ASSETS_URL . '/admin/scripts/admin.js', [], UTEC_VERSION, true );

		// Send vital data to React JS app.
		$request = \UTEC\Admin\Request_Utils::get_current_request();
		$users   = \UTEC\Admin\Request_Utils::get_current_request_users();

		wp_localize_script(
			'utec-admin-script',
			'utec',
			[
				'api' => [
					'rest_url' => esc_url_raw( rest_url() ),
					'nonce' => wp_create_nonce( 'wp_rest' ),
				],
				'admin_url'  => \UTEC\Admin\Table_Page::get_table_page_admin_url(),
				'roles'      => utec()->get_service( 'roles' )->get_available_roles(),
				'request'    => $request,
				'users'      => $users['users'],
				'pagination' => [
					'current_page' => $request['paged'],
					'total_pages'  => $users['total_pages'],
					'total_users'  => $users['total_users'],
				],
				'translation' => Utils::get_jed_locale_data( 'utec' ),
			]
		);
	}
}
