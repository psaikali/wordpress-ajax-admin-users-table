<?php

namespace UTEC\Data;

use UTEC\Common\Traits\Is_Singleton;
use UTEC\Admin\Request_Utils;
use UTEC\Admin\Table_Page;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register the admin page and output its content.
 */
class Roles {
	use Is_Singleton;

	/**
	 * List of roles for our current request.
	 *
	 * @var null|array
	 */
	protected static $roles = null;

	public static function get_available_roles() {
		if ( is_null( self::$roles ) ) {
			$active_role     = Request_Utils::get_current_role_filter();
			$role_links      = [];
			$wp_roles        = wp_roles();
			$url             = Table_Page::get_table_page_admin_url();
			$users_count     = count_users();
			$total_users     = $users_count['total_users'];
			$available_roles = $users_count['avail_roles'];

			$role_links[] = [
				'slug'       => 'all',
				'name'       => __( 'All', 'utec' ),
				'count'      => number_format_i18n( $total_users ),
				'active'     => ( is_null( $active_role ) ),
				'filter_url' => $url,
			];

			foreach ( $wp_roles->get_names() as $this_role => $name ) {
				if ( ! isset( $available_roles[ $this_role ] ) ) {
					continue;
				}

				$role_links[] = [
					'slug'       => $this_role,
					'name'       => translate_user_role( $name ),
					'count'      => number_format_i18n( $available_roles[$this_role] ),
					'active'     => ( $active_role == $this_role ),
					'filter_url' => add_query_arg( 'role', $this_role, $url ),
				];
			}

			if ( ! empty( $available_roles['none' ] ) ) {
				$role_links[] = [
					'slug'        => 'none',
					'name'        => __( 'None', 'utec' ),
					'count'       => number_format_i18n( $available_roles['none' ] ),
					'active'     => ( 'none' === $active_role ),
					'filter_url'  => add_query_arg( 'role', 'none', $url ),
				];
			}

			self::$roles = $role_links;
		}

		return self::$roles;
	}
}
