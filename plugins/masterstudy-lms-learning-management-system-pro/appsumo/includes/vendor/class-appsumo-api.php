<?php

namespace AppSumo\Vendor;

class AppSumo_API extends API {
	protected static $api_url = 'https://microservices.stylemixthemes.com/appsumo-api/';

	protected static function api_url( $path ) {
		return self::$api_url . $path;
	}

	protected static function request_args( $args ) : array {
		$defaults = parent::request_args( $args );
		$token    = base64_encode( // phpcs:ignore WordPress.PHP.DiscouragedPHPFunctions
			gmdate( 'Y-m-d;' ) .
			gmdate( 'Y;' ) .
			gmdate( 'm;' ) .
			gmdate( 'd' )
		);

		$defaults['headers'] = wp_parse_args(
			array(
				'Authorization' => "Bearer $token",
			),
			$defaults['headers'] ?? array()
		);

		return $defaults;
	}

	protected static function is_success( $response ) {
		return isset( $response['success'] ) && $response['success'] && ! empty( $response['token'] );
	}
}
