<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use UTEC\Plugin;

/**
 * Access our plugin singleton
 *
 * @return UTEC\Plugin A plugin instance.
 */
function utec() {
	return Plugin::get_instance();
}

/**
 * Apply same users per page settings as the native Users table.
 *
 * @param int $amount Original number of users to display in the list.
 * @return $amount New number of users.
 */
function utec_change_number_users_per_page( $amount ) {
	$per_page = (int) get_user_option( 'users_per_page' );
	return ( empty( $per_page ) || $per_page < 1 ) ? $amount : $per_page;
}
add_action( 'utec_users_amount', 'utec_change_number_users_per_page' );
