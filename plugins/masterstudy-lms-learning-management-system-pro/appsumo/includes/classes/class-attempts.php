<?php

namespace AppSumo\Classes;

class Attempts {
	private static $attempts = 'appsumo_activation_attempts';
	private static $timeout  = 'appsumo_activation_timeout';

	public static function add(): void {
		$current = intval( Transient::get( self::$attempts ) );

		Transient::set( self::$attempts, ++$current );
		Transient::set( self::$timeout, true, DAY_IN_SECONDS );
	}

	public static function allowed(): bool {
		return 3 > intval( Transient::get( self::$attempts ) );
	}

	public static function sleep(): bool {
		return Transient::get( self::$timeout );
	}

	public static function unset(): void {
		Transient::delete( self::$timeout );
	}
}
