<?php

namespace UTEC\Data;

use UTEC\Common\Traits\Is_Singleton;
use UTEC\Admin\Request_Utils;
use UTEC\Admin\Table_Page;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Everything related to roles data.
 */
class Roles {
	use Is_Singleton;

	/**
	 * List of roles for our current request.
	 *
	 * @var null|array
	 */
	protected static $roles = null;

	/**
	 * Get all WP available roles
	 *
	 * @return array $roles_array Array of roles
	 */
	public static function get_available_roles() {
		if ( is_null( self::$roles ) ) {
			$active_role     = Request_Utils::get_current_role_filter();
			$roles_array     = [];
			$wp_roles        = wp_roles();
			$url             = Table_Page::get_table_page_admin_url();
			$users_count     = count_users();
			$total_users     = $users_count['total_users'];
			$available_roles = $users_count['avail_roles'];

			$roles_array[] = [
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

				$roles_array[] = [
					'slug'       => $this_role,
					'name'       => translate_user_role( $name ),
					'count'      => number_format_i18n( $available_roles[$this_role] ),
					'active'     => ( $active_role == $this_role ),
					'filter_url' => add_query_arg( 'role', $this_role, $url ),
				];
			}

			if ( ! empty( $available_roles['none' ] ) ) {
				$roles_array[] = [
					'slug'        => 'none',
					'name'        => __( 'None', 'utec' ),
					'count'       => number_format_i18n( $available_roles['none' ] ),
					'active'     => ( 'none' === $active_role ),
					'filter_url'  => add_query_arg( 'role', 'none', $url ),
				];
			}

			self::$roles = $roles_array;
		}

		return self::$roles;
	}

	/**
	 * Get a readable version of $roles array
	 *
	 * @param array $roles Array of roles
	 * @return array $role_list Array of strings
	 */
	public static function get_readable_user_roles( $roles ) {
		$wp_roles  = wp_roles();
		$role_list = [];

		foreach ( $roles as $role ) {
			if ( isset( $wp_roles->role_names[ $role ] ) ) {
				$role_list[ $role ] = translate_user_role( $wp_roles->role_names[ $role ] );
			}
		}

		if ( empty( $role_list ) ) {
			$role_list['none'] = _x( 'None', 'no user roles' );
		}

		return $role_list;
	}
}
