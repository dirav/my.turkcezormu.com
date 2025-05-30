<?php

namespace AppSumo\Classes;

use AppSumo\Vendor\Setup;

class AppSumo extends Setup {
	private static $instances = array();

	public function __construct( $options ) {
		parent::__construct( $options );

		new Admin_Page( $this );
	}

	public static function instance( $options ) {
		if ( empty( $options['item'] ) ) {
			return false;
		}

		if ( ! isset( self::$instances[ $options['item'] ] ) ) {
			self::$instances[ $options['item'] ] = new AppSumo( $options );
		}

		return self::$instances[ $options['item'] ];
	}

	public function is_activated() {
		$active_status = Transient::get( Activation::get_transient_name( $this->item ) );

		if ( ! $active_status && ! empty( Token::get() ) ) {
			$active_status = Activation::verify_license( $this->item );
		}

		if ( ! $active_status ) {
			$this->activation_notice();
		}

		return $active_status;
	}

	public function activation_notice() {
		Notices::add_notice(
			sprintf(
				'- <b><a href="%s">%s</a></b>',
				$this->get_activation_url(),
				esc_html__( 'Complete Activation Now', 'appsumo' ),
			),
			$this->name
		);
	}

	public function get_activation_url() {
		return add_query_arg(
			array(
				'page' => $this->get_activation_page_slug(),
			),
			admin_url( 'admin.php', 'admin' )
		);
	}

	public function get_activation_page_slug() {
		return "{$this->item}-activation";
	}
}
