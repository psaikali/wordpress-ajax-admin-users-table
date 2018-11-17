<?php

namespace UTEC;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Our UTEC plugin autoloader.
 * No "class-" will be used in our filenames, because reasons.
 *
 * @link https://carlalexander.ca/organizing-files-object-oriented-wordpress-plugin/
 */
class Autoloader {
	private static $namespace = 'UTEC';
	private static $folder    = 'src';

	/**
	 * Registers UTEC\Autoloader as an SPL autoloader.
	 *
	 * @param string $folder The folder where our source code is located.
	 * @param string $namespace The base namespace to be used.
	 */
	public static function register() {
		spl_autoload_register( [ new self(), 'autoload' ], true );
	}

	/**
	 * Handles autoloading of MyPlugin classes.
	 *
	 * @param string $class The class we're trying to instantiate.
	 */
	public static function autoload( $class ) {
		if ( 0 !== strpos( $class, self::$namespace ) ) {
			return;
		}

		$file      = self::get_filepath_from_class( $class );
		$file_path = dirname( __FILE__ ) . DIRECTORY_SEPARATOR . self::$folder . DIRECTORY_SEPARATOR . $file;

		if ( is_file( $file_path ) ) {
			require_once $file_path;
		}
	}

	/**
	 * Get proper file path from a class name
	 *
	 * @param string $class
	 * @return string The full file path.
	 */
	private static function get_filepath_from_class( $class ) {
		$parts = explode( '\\', $class );
		array_shift( $parts );
		$path = implode( DIRECTORY_SEPARATOR, $parts );
		$folder = self::$folder;

		return strtolower( str_replace( array( '_', "\0" ), array( '-', '' ), $path ) . '.php' );
	}
}
