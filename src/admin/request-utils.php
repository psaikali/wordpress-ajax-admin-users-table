<?php

namespace UTEC\Admin;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use UTEC\Data\Users;

/**
 * Register the admin page and output its content.
 */
class Request_Utils {
	public static function get_current_role_filter() {
		return self::get_current_request()['role'];
	}

	public static function get_current_request( $reference = null ) {
		if ( is_null( $reference ) ) {
			$reference = $_REQUEST;
		}

		// Defaults
		$request = [
			'orderby' => 'user_login',
			'order'   => 'ASC',
			'role'    => null,
			'number'  => 10,
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

	public static function get_current_request_users() {
		$users_class = Users::get_instance();
		return $users_class->get_users( self::get_current_request() );
	}
}
