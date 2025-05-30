<?php

namespace AppSumo\Classes;

class Token {
	private static $option_name = 'appsumo_activation_token';

	public static function set( $token ): void {
		update_option( self::$option_name, $token );
	}

	public static function get() {
		return get_option( self::$option_name );
	}

	public static function delete(): void {
		delete_option( self::$option_name );
	}
}
