<?php

namespace UTEC\Data;

use UTEC\Common\Traits\Is_Singleton;


if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register the admin page and output its content.
 */
class Users {
	use Is_Singleton;

	/**
	 * List of users for our current request.
	 *
	 * @var null|array
	 */
	protected static $users = null;

	public function get_users( $request_args ) {
		if ( is_null( self::$users ) ) {
			$args = wp_parse_args(
				$request_args, 
				[
					'orderby' => 'user_login',
					'order'   => 'ASC',
					'role'    => null,
					'number'  => 3,
					'paged'   => 1,
				]
			);

			// If order by name, add custom meta query.
			if ( 'name' === $args['orderby'] ) {
				$args['orderby']  = 'meta_value';
				$args['meta_key'] = 'last_name';
			}

			$user_query = new \WP_User_Query( $args );

			if ( count( $user_query->get_results() ) > 0 ) {
				$total_pages = ceil( (int) $user_query->get_total() / (int) $args['number'] );

				$users = [
					'users'       => self::prepare_users_data( $user_query->get_results() ),
					'total_pages' => (int) $total_pages,
					'total_users' => $user_query->get_total(),
				];
			} else {
				$users = [
					'users'       => [],
					'total_pages' => 1,
					'total_users' => 0,
				];
			}

			self::$users = $users;
		}

		return self::$users;
	}

	protected static function prepare_users_data( $users ) {
		if ( ! is_array( $users ) ) {
			return [];
		}

		$prepared_users = [];

		foreach ( $users as $user ) {
			if ( ! is_a( $user, 'WP_User' ) ) {
				continue;
			}

			if ( $user->first_name && $user->last_name ) {
				$user_name = "$user->first_name $user->last_name";
			} elseif ( $user->first_name ) {
				$user_name = $user->first_name;
			} elseif ( $user->last_name ) {
				$user_name = $user->last_name;
			} else {
				$user_name = null;
			}

			$prepared_users[] = (object) [
				'ID'         => $user->ID,
				'email'      => $user->user_email,
				'user_login' => $user->user_login,
				'name'       => $user_name,
				'avatar'     => get_avatar_url( $user->ID, [ 'size' => 96 ] ),
				'edit_link'  => get_edit_user_link( $user->ID ),
				'roles'      => self::get_readable_user_roles( $user->roles ),
			];
		}

		return $prepared_users;
	}

	protected static function get_readable_user_roles( $roles ) {
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
