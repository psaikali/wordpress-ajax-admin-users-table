<?php

namespace UTEC\Setup;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use UTEC\Common\Interfaces\Has_Hooks;
use UTEC\Admin\Table_Page;

/**
 * The central place to list our classes triggering hooks.
 */
class Enqueue_Assets implements Has_Hooks {
	/**
	 * Necessary hooks
	 */
	public function hooks() {
		add_action( 'admin_enqueue_scripts', [ $this, 'register_scripts_and_styles' ] );
	}

	public function register_scripts_and_styles() {
		$plugin_admin_page_id = 'users_page_' . Table_Page::SLUG;

		if ( is_null( get_current_screen() ) || $plugin_admin_page_id !== get_current_screen()->id ) {
			return;
		}

		$request = \UTEC\Admin\Request_Utils::get_current_request();
		$users   = \UTEC\Admin\Request_Utils::get_current_request_users();

		wp_enqueue_style( 'utec-admin-style', UTEC_ASSETS_URL . '/admin/styles/admin.css', [], UTEC_VERSION );

		// wp_enqueue_script( 'utec-react', UTEC_ASSETS_URL . '/admin/scripts/lib/react.min.js', [], UTEC_VERSION, true );
		// wp_enqueue_script( 'utec-react-dom', UTEC_ASSETS_URL . '/admin/scripts/lib/react-dom.min.js', [], UTEC_VERSION, true );
		wp_enqueue_script( 'utec-admin-script', UTEC_ASSETS_URL . '/admin/scripts/admin.js', [], UTEC_VERSION, true );

		wp_localize_script(
			'utec-admin-script',
			'utec',
			[
				'api' => [
					'rest_url' => esc_url_raw( rest_url() ),
					'nonce' => wp_create_nonce( 'wp_rest' ),
				],
				'admin_url'  => \UTEC\Admin\Table_Page::get_table_page_admin_url(),
				'roles'      => \UTEC\Data\Roles::get_available_roles(),
				'request'    => $request,
				'users'      => $users['users'],
				'pagination' => [
					'current_page' => $request['paged'],
					'total_pages'  => $users['total_pages'],
					'total_users'  => $users['total_users'],
				],
			]
		);
	}
}
