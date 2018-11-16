<?php

namespace UTEC\Common\Traits;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Magic getter that will trigger a ->get_$field() method when trying to access ->$field directly.
 */
trait Magic_Getter {
	/**
	 * Magic getter when trying to directly access some values.
	 *
	 * @param  string $field Field to get.
	 * @throws Exception     Throws an exception if the field is invalid.
	 * @return mixed         Value of the field.
	 */
	public function __get( $field ) {
		$method_name = strtolower( "get_{$field}" );

		if ( method_exists( $this, $method_name ) ) {
			return $this->$method_name();
		}

		throw new \Exception( sprintf( 'Forbidden direct access to property (accessing "%1$s" property).', $field ) );
	}
}