<?php

namespace AppSumo\Classes;

use AppSumo\Vendor\AppSumo_API;

class Activation extends AppSumo_API {
	public function __construct() {
		add_action( 'wp_ajax_appsumo_activate_license', array( $this, 'activate_license' ) );
	}

	public function activate_license() {
		$body = array(
			'domain'  => appsumo_get_domain(),
			'license' => $this->get_post_data( 'license' ),
		);

		$response = self::request( 'activate-license', 'POST', self::compact( $body ) );

		if ( self::is_success( $response ) ) {
			self::activate( $response['item'], $response['token'] );

			wp_send_json(
				array(
					'success'     => true,
					'message'     => esc_html__( 'License activated successfully!', 'appsumo' ),
					'redirect_to' => admin_url( 'plugins.php' ),
				)
			);
		} else {
			wp_send_json(
				array(
					'success' => false,
					'message' => $response['message'] ?? esc_html__( 'License activating failed. Please check your License!', 'appsumo' ),
				)
			);
		}

		wp_die();
	}

	public static function verify_license( $item ): bool {
		if ( Attempts::sleep() ) {
			return true;
		}

		$body = array(
			'domain' => appsumo_get_domain(),
			'token'  => Token::get(),
		);

		$response   = self::request( 'verify-license', 'POST', self::compact( $body ) );
		$is_success = self::is_success( $response );

		if ( $is_success ) {
			self::activate( $item, $response['token'] );
		} else {
			if ( Attempts::allowed() ) {
				Attempts::add();
				$is_success = true;
			} else {
				Token::delete();
			}
		}

		return $is_success;
	}

	private static function activate( $item, $token ): void {
		Token::set( $token );
		Transient::set( self::get_transient_name( $item ) );
		Attempts::unset();
	}

	public static function get_transient_name( $item ): string {
		return "appsumo_activated_{$item}";
	}
}
