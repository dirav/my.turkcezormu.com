<?php
/**
 * Name: AppSumo Activation
 * Description: AppSumo Activation Submodule for PRO Plugins
 * Author: StylemixThemes
 * Author URI: https://stylemixthemes.com/
 * Version: 1.0.0
 */

if ( ! defined( 'APPSUMO_VERSION' ) ) {
	define( 'APPSUMO_VERSION', '1.1.0' );
	define( 'APPSUMO_FILE', __FILE__ );
	define( 'APPSUMO_PATH', dirname( APPSUMO_FILE ) );
	define( 'APPSUMO_INCLUDES_PATH', APPSUMO_PATH . '/includes' );

	/**
	 * Init Includes
	 */
	require_once APPSUMO_INCLUDES_PATH . '/init.php';

	function appsumo_init( $options ) {
		return \AppSumo\Classes\AppSumo::instance( $options );
	}
}
