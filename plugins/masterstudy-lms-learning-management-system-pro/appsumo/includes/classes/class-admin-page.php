<?php

namespace AppSumo\Classes;

class Admin_Page {
	/**
	 * AppSumo Object
	 * @var object AppSumo\Classes\AppSumo
	 */
	private $appsumo;

	public function __construct( $appsumo ) {
		$this->appsumo = $appsumo;

		if ( ! $this->appsumo->is_activated() ) {
			register_activation_hook( $this->appsumo->get_option( 'main_file' ), array( $this, 'activate_event_hook' ) );

			add_action( 'admin_init', array( $this, 'admin_init_actions' ) );
			add_action( 'admin_menu', array( $this, 'add_admin_menu' ) );
		}
	}

	public function admin_init_actions() {
		if ( Transient::get( $this->get_activation_transient_name() ) ) {
			Transient::delete( $this->get_activation_transient_name() );

			wp_safe_redirect( $this->appsumo->get_activation_url() );
			exit;
		}
	}

	public function add_admin_menu() {
		$hook = add_submenu_page(
			null,
			$this->appsumo->get_option( 'name' ),
			$this->appsumo->get_option( 'name' ),
			'manage_options',
			$this->appsumo->get_activation_page_slug(),
			array( $this, 'render_activation_page' )
		);

		add_action( "load-$hook", array( $this, 'remove_all_actions' ) );
	}

	public function render_activation_page() {
		wp_enqueue_style( 'appsumo-activation', "{$this->appsumo->get_root_url()}/assets/css/activation.css", array(), APPSUMO_VERSION );
		wp_enqueue_script( 'appsumo-activation', "{$this->appsumo->get_root_url()}/assets/js/activation.js", array( 'jquery' ), APPSUMO_VERSION, true );

		appsumo_load_template( 'activation.php', $this->appsumo->get_options() );
	}

	public function remove_all_actions() {
		remove_all_actions( 'admin_notices' );
		remove_all_actions( 'network_admin_notices' );
		remove_all_actions( 'all_admin_notices' );
		remove_all_actions( 'user_admin_notices' );
	}

	public function activate_event_hook() {
		Transient::set( $this->get_activation_transient_name() );
	}

	private function get_activation_transient_name() {
		return "appsumo_item_{$this->appsumo->get_option( 'item' )}_activated";
	}
}
