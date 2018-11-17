<?php

namespace UTEC;

use UTEC\Admin\Options\Options;


if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Helpful utilities functions
 */
class Utils {
	/**
	 * Write in debug log
	 *
	 * @param mixed $logs Stuff to debug in log.
	 */
	public static function debug( ...$logs ) {
		if ( true === WP_DEBUG && ! defined( 'WP_CURRENTLY_TESTING' ) ) {
			foreach ( $logs as $log ) {
				error_log( '--------------------------------- /!\ ' . __NAMESPACE__ . ' /!\ --------------------------------- ' );
				if ( is_array( $log ) || is_object( $log ) ) {
					error_log( print_r( $log, true ) );
				} else {
					error_log( $log );
				}
				error_log( '--------------------------------- /!\ ' . __NAMESPACE__ . ' /!\ --------------------------------- ' );
			}
		}
	}

	/**
	 * Locate a template file, whether it's in the theme/child-theme folder or use plugin default template
	 *
	 * @link http://jeroensormani.com/how-to-add-template-files-in-your-plugin/
	 * @param string $template_name
	 * @param string $template_path
	 * @param string $default_path
	 * @return string Path to template.
	 */
	public static function locate_template( $template_name, $template_path = '', $default_path = '' ) {
		// Set variable to search in /views/ folder of theme.
		if ( ! $template_path ) {
			$template_path = 'views/';
		}

		// Set default plugin templates path.
		if ( ! $default_path ) {
			$default_path = UTEC_DIR . 'views/';
		}

		// Search template file in theme folder.
		$template = locate_template( [
			$template_path . $template_name,
			$template_name,
		] );

		// Get plugins template file.
		if ( ! $template ) {
			$template = $default_path . $template_name;
		}

		return apply_filters( 'utec_template_locate', $template, $template_name, $template_path, $default_path );
	}


	/**
	 * Include a template file
	 *
	 * @author WooCommerce
	 * @param string Template file name.
	 * @param array $args Arguments to pass to template.
	 * @param string $template_path
	 * @param string $default_path
	 */
	public static function get_template( $template_name, $args = [], $template_path = '', $default_path = '' ) {
		if ( is_array( $args ) && isset( $args ) ) {
			extract( $args );
		}

		$located_template_file = self::locate_template( $template_name, $template_path, $default_path );

		if ( ! file_exists( $located_template_file ) ) {
			_doing_it_wrong( __FUNCTION__, sprintf( '<code>%s</code> template file does not exist.', $located_template_file ), '1.0.0' );
			return;
		}

		include $located_template_file;
	}

	/**
	 * Get Jed locale data for translation.
	 *
	 * @author Gutenberg
	 * @param string $domain
	 * @return void
	 */
	public static function get_jed_locale_data( $domain ) {
		$translations = get_translations_for_domain( $domain );

		$locale = array(
			'' => array(
				'domain' => $domain,
				'lang'   => is_admin() ? get_user_locale() : get_locale(),
			),
		);

		if ( ! empty( $translations->headers['Plural-Forms'] ) ) {
			$locale['']['plural_forms'] = $translations->headers['Plural-Forms'];
		}

		foreach ( $translations->entries as $msgid => $entry ) {
			$locale[ $msgid ] = $entry->translations;
		}

		return $locale;
	}
}
