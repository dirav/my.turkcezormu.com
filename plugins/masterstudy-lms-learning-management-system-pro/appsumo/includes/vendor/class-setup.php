<?php

namespace AppSumo\Vendor;

abstract class Setup {
	/**
	 * Plugin or Theme Slug
	 * @var string
	 */
	protected $item;

	/**
	 * Plugin or Theme Name
	 * @var string
	 */
	protected $name;

	/**
	 * SDK Options
	 * @var array
	 */
	protected $options;

	/**
	 * Required Fields for validation
	 * @var array
	 */
	private $required_fields = array(
		'item',
		'name',
		'main_file',
	);

	public function __construct( $options ) {
		$this->options = $options;

		$this->validate();
		$this->set_options();
	}

	private function validate() {
		foreach ( $this->required_fields as $field ) {
			if ( empty( $this->get_option( $field ) ) ) {
				throw new \Exception( 'SDK is not implemented because of Validation Errors.' );
			}
		}
	}

	private function set_options() {
		$this->item = $this->get_option( 'item' );
		$this->name = $this->get_option( 'name' );
	}

	public function get_options() {
		return $this->options;
	}

	public function get_option( $field ) {
		return $this->options[ $field ] ?? null;
	}

	public function get_root_url() {
		return plugin_dir_url( APPSUMO_FILE );
	}
}
