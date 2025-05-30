<?php

namespace AppSumo\Classes;

class Notices {
	/**
	 * Admin Notices
	 * @var array
	 */
	private static $notices;

	public static function admin_notices() {
		if ( function_exists( 'current_user_can' ) && ! current_user_can( 'manage_options' ) ) {
			return;
		}

		foreach ( self::$notices as $id => $notice ) {
			appsumo_load_template( 'admin-notice.php', $notice );
		}
	}

	public static function add_notice( $message, $title = '', $type = 'success' ) {
		if ( empty( self::$notices ) ) {
			add_action( 'admin_notices', array( self::class, 'admin_notices' ) );
		}

		self::$notices[ md5( "$title $message" ) ] = array(
			'title'   => $title,
			'message' => $message,
			'type'    => $type,
		);
	}
}
