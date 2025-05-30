<?php

namespace AppSumo\Vendor;

abstract class API {
	protected static function request( $url = '', $method = 'GET', $args = array() ): ?array {
		$args    = wp_parse_args( $args, array( 'method' => $method ) );
		$request = wp_remote_request( static::api_url( $url ), static::request_args( $args ) );

		return static::response( $request );
	}

	protected static function response( $request ): ?array {
		if ( is_array( $request ) && ! is_wp_error( $request ) ) {
			return json_decode( $request['body'] ?? '', true );
		}

		return array();
	}

	protected static function request_args( $args ): array {
		$defaults = array(
			'headers'   => array(
				'Content-Type' => 'application/x-www-form-urlencoded',
				'Accept'       => 'application/json',
			),
			'sslverify' => false,
			'timeout'   => 30,
		);

		return wp_parse_args( $args, $defaults );
	}

	protected static function api_url( $url ) {
		return $url;
	}

	protected static function compact( $data, $key = 'body' ): array {
		return array( $key => $data );
	}

	protected function get_post_data( $field = null ) {
		return ! empty( $field )
			? $_POST[ $field ] ?? null // phpcs:ignore WordPress.Security.NonceVerification.Missing
			: $_POST; // phpcs:ignore WordPress.Security.NonceVerification.Missing
	}
}
