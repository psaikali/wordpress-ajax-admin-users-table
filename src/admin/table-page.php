<?php

namespace UTEC\Admin;

use UTEC\Common\Interfaces\Has_Hooks;
use UTEC\Utils;
use UTEC\Data\Users;
use UTEC\Data\Roles;


if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register the admin page and output its content.
 */
class Table_Page implements Has_Hooks {
	/**
	 * User capability required to see the page.
	 */
	const CAPABILITY = 'list_users';

	/**
	 * The slug of our admin page.
	 */
	const SLUG = 'utec-list-table';

	/**
	 * Necessary hooks
	 */
	public function hooks() {
		add_action( 'admin_menu', [ $this, 'add_admin_user_menu_subpage' ] );
	}

	/**
	 * Add admin subpage
	 */
	public function add_admin_user_menu_subpage() {
		add_submenu_page( 'users.php', __( 'Custom Codeable.io users table', 'utec' ), __( 'Custom table', 'utec' ), apply_filters( 'utec_admin_table_capability', self::CAPABILITY ), self::SLUG, [ $this, 'render_admin_page' ] );
	}

	/**
	 * Render our admin subpage
	 */
	public function render_admin_page() {
		Utils::get_template( 'admin-list-table.php', $this->prepare_data_for_table_page() );
	}

	/**
	 * Prepare data for our table page
	 *
	 * @return array $data
	 */
	private function prepare_data_for_table_page() {
		$request = Request_Utils::get_current_request();
		$users   = Request_Utils::get_current_request_users();

		$data = [
			'page_title'  => __( 'Custom Codeable.io users table', 'utec' ),
			'admin_url'   => self::get_table_page_admin_url(),
			'roles'       => Roles::get_available_roles(),
			'request'     => $request,
			'users'       => $users['users'],
			'pagination'  => [
				'current_page' => $request['paged'],
				'total_pages'  => $users['total_pages'],
				'total_users'  => $users['total_users'],
			],
		];

		return $data;
	}

	/**
	 * Get our admin page URL
	 *
	 * @return string The admin page URL.
	 */
	public static function get_table_page_admin_url() {
		return add_query_arg( [ 'page' => self::SLUG ], admin_url( 'users.php' ) );
	}
}
