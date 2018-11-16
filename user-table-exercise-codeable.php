<?php
/**
 * Plugin Name: User Table Exercise for Codeable
 * Description: Full-stack developer exercise for Codeable.io
 * Author: Pierre Saïkali
 * Author URI: https://saika.li
 * Text Domain: utec
 * Domain Path: /languages/
 * Version: 1.0.0
 * Namespace: UTEC (for User Table Exercise for Codeable)
 */

namespace UTEC;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Define plugin constants
 */
define( 'UTEC_VERSION', '1.0.0' );
define( 'UTEC_MIN_PHP_VERSION', '5.6' );
define( 'UTEC_URL', plugin_dir_url( __FILE__ ) );
define( 'UTEC_DIR', plugin_dir_path( __FILE__ ) );
define( 'UTEC_PLUGIN_DIRNAME', basename( rtrim( dirname( __FILE__ ), '/' ) ) );
define( 'UTEC_BASENAME', plugin_basename( __FILE__ ) );
define( 'UTEC_ASSETS_URL', UTEC_URL . 'assets' );

/**
 * Register our autoloader logic.
 */
require_once UTEC_DIR . DIRECTORY_SEPARATOR . 'autoloader.php';
Autoloader::register();

/**
 * Include our globally usable functions.
 */
require_once __DIR__ . DIRECTORY_SEPARATOR . 'functions.php';

/**
 * Load translation
 */
load_plugin_textdomain( 'utec', false, UTEC_PLUGIN_DIRNAME . '/languages/' );

/**
 * Activation and de-activation hooks
 */
register_activation_hook( __FILE__, array( utec(), 'activate' ) );
register_deactivation_hook( __FILE__, array( utec(), 'deactivate' ) );

/**
 * Fire the fun stuff!
 */
add_action( 'plugins_loaded', array( utec(), 'fire' ) );
