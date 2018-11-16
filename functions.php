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
