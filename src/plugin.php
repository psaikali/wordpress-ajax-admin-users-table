<?php

namespace UTEC;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use UTEC\Common\Interfaces\Has_Hooks;
use UTEC\Common\Traits\Is_Singleton;

/**
 * Our plugin loader, in charge of high-level stuff.
 */
class Plugin {
	use Is_Singleton;

	/**
	 * Fire our plugin: load hooks, localize language files, register assets
	 *
	 * @return void
	 */
	public function fire() {
		//$this->hooks();
		$hooks = new Setup\Register_Hooks( __NAMESPACE__ );
	}

	/**
	 * Register required hooks.
	 */
	public function hooks() {
		
	}

	/**
	 * Executed when plugin is activated.
	 */
	public static function activate() {
		
	}

	/**
	 * Executed when plugin is de-activated.
	 */
	public static function deactivate() {
		
	}
}
