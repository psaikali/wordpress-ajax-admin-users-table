<?php

namespace UTEC\Rest;

use UTEC\Common\Interfaces\Has_Hooks;
use UTEC\Admin\Request_Utils;
use UTEC\Data\Users;
use UTEC\Utils;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register the admin page and output its content.
 */
class Get_Users implements Has_Hooks {
	/**
	 * Necessary hooks
	 */
	public function hooks() {
		add_action( 'rest_api_init', [ $this, 'register_route' ] );
	}

	public function register_route() {
		$namespace = 'utec/v1';

		register_rest_route(
			$namespace,
			'get-users', 
			[
				'methods' => 'POST',
				'callback' => [ $this, 'process_request' ],
			]
		);
	}

	public function process_request( \WP_REST_Request $rest_request ) {
		$original_request = $rest_request->get_param( 'request' );
		$request          = Request_Utils::get_current_request( $original_request );
		$users_class      = Users::get_instance();
		$users            = $users_class->get_users( $request );

		$response = [
			'request'     => $request,
			'users'       => $users['users'],
			'pagination'  => [
				'current_page' => (int) $request['paged'],
				'total_pages'  => (int) $users['total_pages'],
				'total_users'  => (int) $users['total_users'],
			],
		];

		return new \WP_REST_Response( $response );
	}
}