<?php

namespace AppSumo\Classes;

class Transient {
	public static function set( $name, $value = true, $expiration = WEEK_IN_SECONDS ): void {
		set_transient( $name, $value, $expiration );
	}

	public static function get( $name ) {
		return get_transient( $name );
	}

	public static function delete( $name ): void {
		delete_transient( $name );
	}
}
