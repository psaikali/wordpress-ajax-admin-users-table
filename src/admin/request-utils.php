<?php

namespace UTEC\Admin;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use UTEC\Data\Users;

/**
 * Some utilities functions to get data from our request.
 */
class Request_Utils {
	/**
	 * Get the current (active) role filter
	 *
	 * @return string Current role slug.
	 */
	public static function get_current_role_filter() {
		return self::get_current_request()['role'];
	}

	/**
	 * Get the current request from $_GET parameters (no-JS users) or $_POST (JS React users)
	 *
	 * @param array $reference The array to use to look for data.
	 * @return array A cleaned array.
	 */
	public static function get_current_request( $reference = null ) {
		if ( is_null( $reference ) ) {
			$reference = $_REQUEST;
		}

		// Defaults
		$request = [
			'orderby' => 'user_login',
			'order'   => 'ASC',
			'role'    => null,
			'number'  => apply_filters( 'utec_users_amount', 10 ),
			'paged'   => 1,
		];

		if ( isset( $reference['orderby'] )
			&& in_array( $reference['orderby'], [ 'user_login', 'display_name', 'name' ], true ) ) {
			$request['orderby'] = sanitize_text_field( $reference['orderby'] );
		}

		if ( isset( $reference['order'] )
			&& in_array( $reference['order'], [ 'asc', 'desc', 'ASC', 'DESC' ], true ) ) {
			$request['order'] = strtoupper( sanitize_text_field( $reference['order'] ) );
		}

		if ( isset( $reference['role'] ) && $reference['role'] !== 'all' ) {
			$request['role'] = sanitize_text_field( $reference['role'] );
		}

		if ( isset( $reference['paged'] ) && is_numeric( $reference['paged'] ) ) {
			$request['paged'] = (int) $reference['paged'];
		}

		return $request;
	}

	/**
	 * Get the users list for the current request
	 *
	 * @return array Array of prepared users objects
	 */
	public static function get_current_request_users() {
		$users_class = utec()->get_service( 'users' );
		return $users_class->get_users( self::get_current_request() );
	}
}
