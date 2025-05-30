<?php
if ( ! function_exists( 'appsumo_get_domain' ) ) {
	function appsumo_get_domain() {
		$url_parts = wp_parse_url( home_url() );

		return $url_parts['host'] ?? home_url();
	}
}

if ( ! function_exists( 'appsumo_load_template' ) ) {
	function appsumo_load_template( $template, $args ) {
		load_template( APPSUMO_PATH . "/templates/$template", false, $args );
	}
}
