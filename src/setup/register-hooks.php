<?php

namespace UTEC\Setup;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use UTEC\Common\Interfaces\Has_Hooks;
use UTEC\Utils;

/**
 * The central place to list our classes triggering hooks.
 */
class Register_Hooks {
	/**
	 * The list of classes that will trigger hooks.
	 *
	 * @var array
	 */
	private $classes = [
		'Admin\Table_Page',
		'Setup\Enqueue_Assets',
		'Rest\Get_Users',
	];

	/**
	 * The global namespace to be used to load classes.
	 *
	 * @var string
	 */
	private $namespace = '';

	/**
	 * Set the classes and register the hooks
	 *
	 * @param string $namespace The global namespace to be used.
	 */
	public function __construct( $namespace ) {
		$this->set_namespace( $namespace );
		$this->register_hooks();
	}

	/**
	 * Setter method to save our global namespace.
	 *
	 * @param string $namespace
	 */
	private function set_namespace( $namespace ) {
		$this->namespace = $namespace;
	}

	/**
	 * Getter method to retrieve our hooking classes.
	 *
	 * @return array $classes The list of our hooking classes.
	 */
	private function get_hooking_classes() {
		return $this->classes;
	}

	/**
	 * Hooks registration logic that will call `hooks()` method
	 * on a hooking class (if existing).
	 *
	 * @return void
	 */
	private function register_hooks() {
		foreach ( $this->get_hooking_classes() as $class ) {
			$full_class_name    = ( $this->namespace . '\\' . $class );
			$reflection      = new \ReflectionClass( $full_class_name );

			if ( $reflection->implementsInterface( 'UTEC\Common\Interfaces\Has_Hooks' ) ) {
				( new $full_class_name() )->hooks();
			}
		}
	}
}
