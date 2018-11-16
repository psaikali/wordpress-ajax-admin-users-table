<?php

namespace UTEC\Common\Interfaces;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * A contract for classes that have logic triggered by hooks.
 */
interface Has_Hooks {
	/**
	 * Necessary method to register the hooks.
	 */
	public function hooks();
}
