<?php
new STM_LMS_Form_Builder();

class STM_LMS_Form_Builder {

	public function __construct() {
		add_action( 'admin_menu', array( $this, 'admin_menu' ), 10000 );
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_menu_scripts' ) );
		add_action( 'wp_ajax_stm_lms_save_forms', array( $this, 'save_forms' ) );
		add_action( 'wp_ajax_stm_lms_upload_form_file', array( $this, 'upload_file' ) );
		add_action( 'wp_ajax_nopriv_stm_lms_upload_form_file', array( $this, 'upload_file' ) );
		add_action( 'wp_ajax_stm_lms_delete_form_file', array( $this, 'delete_file' ) );
		add_action( 'wp_ajax_nopriv_stm_lms_delete_form_file', array( $this, 'delete_file' ) );
		add_filter( 'stm_lms_user_additional_fields', array( $this, 'profile_fields' ) );
		add_filter( 'stm_lms_email_manager_emails', array( $this, 'email_settings' ) );
		add_filter( 'stm_lms_profile_form_default_fields_info', array( $this, 'profile_form_default_fields_info' ) );
		add_action( 'show_user_profile', array( $this, 'display_fields_in_profile' ), 20 );
		add_action( 'edit_user_profile', array( $this, 'display_fields_in_profile' ), 20 );

		add_action( 'personal_options_update', array( $this, 'save_fields_in_profile' ) );
		add_action( 'edit_user_profile_update', array( $this, 'save_fields_in_profile' ) );
	}

	public function admin_menu() {
		add_submenu_page(
			'stm-lms-settings',
			esc_html__( 'Forms Editor', 'masterstudy-lms-learning-management-system-pro' ),
			esc_html__( 'Forms Editor', 'masterstudy-lms-learning-management-system-pro' ),
			'manage_options',
			'form_builder',
			array( $this, 'admin_page' ),
			80
		);
	}

	public function admin_page() {
		// phpcs:ignore WordPress.WP.EnqueuedResourceParameters.NotInFooter
		wp_enqueue_script( 'vuedraggable', STM_LMS_URL . '/assets/vendors/vuedraggable.umd.min.js', array(), stm_lms_custom_styles_v() );
		/*Forms*/
		$fields = self::get_fields();

		foreach ( $fields as $field ) {
			// phpcs:ignore WordPress.WP.EnqueuedResourceParameters.NotInFooter
			wp_enqueue_script(
				"stm_lms_forms_{$field['type']}",
				STM_LMS_URL . "/assets/js/form_builder/components/fields/{$field['type']}.js",
				array(),
				stm_lms_custom_styles_v()
			);
		}

		wp_enqueue_style( 'stm_lms_form_builder', STM_LMS_URL . '/assets/css/parts/form_builder/main.css', array(), stm_lms_custom_styles_v() );
		// phpcs:ignore WordPress.WP.EnqueuedResourceParameters.NotInFooter
		wp_enqueue_script( 'stm_lms_fields_sidebar', STM_LMS_URL . '/assets/js/form_builder/components/fields_sidebar.js', array(), stm_lms_custom_styles_v() );
		// phpcs:ignore WordPress.WP.EnqueuedResourceParameters.NotInFooter
		wp_enqueue_script( 'stm_lms_form_builder_form', STM_LMS_URL . '/assets/js/form_builder/components/form.js', array(), stm_lms_custom_styles_v() );
		// phpcs:ignore WordPress.WP.EnqueuedResourceParameters.NotInFooter
		wp_enqueue_script( 'stm_lms_form_builder_main', STM_LMS_URL . '/assets/js/form_builder/main.js', array(), stm_lms_custom_styles_v() );
		wp_localize_script( 'stm_lms_fields_sidebar', 'stm_lms_form_fields', self::get_fields() );
		wp_localize_script( 'stm_lms_form_builder_main', 'stm_lms_forms', self::get_forms() );
		require_once STM_LMS_PRO_ADDONS . '/form_builder/templates/main.php';
	}

	public function admin_menu_scripts() {
		global $pagenow;
		if ( 'user-edit.php' === $pagenow ) {
			// phpcs:ignore WordPress.WP.EnqueuedResourceParameters.NotInFooter
			wp_enqueue_script( 'stm_lms_form_builder_user', STM_LMS_URL . '/assets/js/form_builder/user_profile.js', array( 'jquery' ), stm_lms_custom_styles_v() );
		}
	}

	public static function get_forms() {
		$default = array(
			array(
				'slug'   => 'become_instructor',
				'name'   => esc_html__( 'Become Instructor Form', 'masterstudy-lms-learning-management-system-pro' ),
				'fields' => array(),
			),
			array(
				'slug'   => 'enterprise_form',
				'name'   => esc_html__( 'Enterprise Form', 'masterstudy-lms-learning-management-system-pro' ),
				'fields' => array(),
			),
			array(
				'slug'   => 'profile_form',
				'name'   => esc_html__( 'Profile Form', 'masterstudy-lms-learning-management-system-pro' ),
				'fields' => array(),
			),
		);

		$profile_form    = array(
			'first_name'  => array(),
			'last_name'   => array(),
			'position'    => array(),
			'description' => array(),
		);
		$required_fields = array(
			'become_instructor' => array(),
			'enterprise_form'   => array(),
			'profile_form'      => apply_filters( 'stm_lms_profile_form_default_fields_info', $profile_form ),
		);

		return array(
			'forms'           => get_option( 'stm_lms_form_builder_forms', $default ),
			'currentForm'     => 0,
			'required_fields' => $required_fields,
		);
	}

	public static function get_form_fields( $form_name ) {
		$forms = get_option( 'stm_lms_form_builder_forms', array() );
		$r     = array();
		if ( ! empty( $forms ) && is_array( $forms ) ) {
			foreach ( $forms as $form ) {
				if ( $form_name === $form['slug'] ) {
					$r = $form['fields'];
				}
			}
		}
		return $r;
	}

	public static function get_fields() {
		$fields = array(
			array(
				'type'       => 'text',
				'field_name' => esc_html__( 'Single Line Text', 'masterstudy-lms-learning-management-system-pro' ),
			),
			array(
				'type'       => 'email',
				'field_name' => esc_html__( 'Email', 'masterstudy-lms-learning-management-system-pro' ),
			),
			array(
				'type'       => 'select',
				'field_name' => esc_html__( 'Drop Down', 'masterstudy-lms-learning-management-system-pro' ),
			),
			array(
				'type'       => 'radio',
				'field_name' => esc_html__( 'Radio Buttons', 'masterstudy-lms-learning-management-system-pro' ),
			),
			array(
				'type'       => 'checkbox',
				'field_name' => esc_html__( 'Checkboxes', 'masterstudy-lms-learning-management-system-pro' ),
			),
			array(
				'type'       => 'tel',
				'field_name' => esc_html__( 'Phone', 'masterstudy-lms-learning-management-system-pro' ),
			),
			array(
				'type'       => 'file',
				'field_name' => esc_html__( 'File Attachment', 'masterstudy-lms-learning-management-system-pro' ),
			),
			array(
				'type'       => 'textarea',
				'field_name' => esc_html__( 'Text Area', 'masterstudy-lms-learning-management-system-pro' ),
			),
		);
		return apply_filters( 'stm_lms_form_builder_available_fields', $fields );
	}

	public function save_forms() {
		check_ajax_referer( 'stm_lms_save_forms', 'nonce' );

		$data = json_decode( file_get_contents( 'php://input' ), true );
		if ( ! empty( $data['forms'] ) && ! empty( $data['requiredFields'] ) ) {
			$forms        = $data['forms'];
			$profile_form = ! empty( $data['requiredFields']['profile_form'] ) ? $data['requiredFields']['profile_form'] : array();
			if ( ! empty( $profile_form ) ) {
				update_option( 'stm_lms_default_profile_form', $profile_form );
			}
			array_walk_recursive( $forms, 'sanitize_text_field' );
			update_option( 'stm_lms_form_builder_forms', $forms );

			$this->wpml_fields_registration( $forms );

			wp_send_json( 'ok' );
		}
	}

	public function wpml_fields_registration( $forms ) {
		if ( ! defined( 'ICL_SITEPRESS_VERSION' ) ) {
			return;
		}
		foreach ( $forms as $item ) {
			if ( ! empty( $item['fields'] ) ) {
				foreach ( $item['fields'] as $field ) {
					if ( ! empty( $field['id'] ) ) {
						$field_id = 'masterstudy_form_builder_' . $field['id'];
						do_action( 'wpml_register_single_string', 'masterstudy-lms-learning-management-system-pro', "{$field_id}_label", $field['label'] );
						do_action( 'wpml_register_single_string', 'masterstudy-lms-learning-management-system-pro', "{$field_id}_description", $field['description'] );
						if ( $field['choices'] ) {
							foreach ( $field['choices'] as $index => $choice ) {
								do_action( 'wpml_register_single_string', 'masterstudy-lms-learning-management-system-pro', "{$field_id}_choice_{$index}", $choice );
							}
						} else {
							do_action( 'wpml_register_single_string', 'masterstudy-lms-learning-management-system-pro', "{$field_id}_placeholder", $field['placeholder'] );
						}
					}
				}
			}
		}
	}

	public function delete_file() {
		check_ajax_referer( 'stm_lms_delete_form_file', 'nonce' );

		if ( empty( $_POST['file_id'] ) ) {
			return;
		}

		wp_delete_attachment( intval( $_POST['file_id'] ), true );

		return wp_send_json( 'OK' );
	}

	public function upload_file() {
		check_ajax_referer( 'stm_lms_upload_form_file', 'nonce' );
		$extensions = 'png;jpg;jpeg;mp4;pdf';
		if ( ! empty( $_POST['extensions'] ) ) {
			$extensions = sanitize_text_field( $_POST['extensions'] );
			$extensions = preg_replace( '/\s+/', '', $extensions );
			$extensions = str_replace( '.', '', $extensions );
			$extensions = str_replace( ',', ';', $extensions );
		}
		$is_valid_image = Validation::is_valid(
			$_FILES,
			array(
				'file' => 'required_file|extension,' . $extensions,
			)
		);

		if ( true !== $is_valid_image ) {
			return wp_send_json(
				array(
					'error'   => true,
					'message' => sprintf(
						/* translators: %s string */
						__( 'Field can only have one of the following extensions: %s', 'masterstudy-lms-learning-management-system-pro' ),
						esc_html( $extensions )
					),
				)
			);
		}

		require_once ABSPATH . 'wp-admin/includes/image.php';
		require_once ABSPATH . 'wp-admin/includes/file.php';
		require_once ABSPATH . 'wp-admin/includes/media.php';

		$attachment_id = media_handle_upload( 'file', 0 );

		if ( is_wp_error( $attachment_id ) ) {
			return wp_send_json(
				array(
					'error'   => true,
					'message' => $attachment_id->get_error_message(),
				)
			);
		}

		$attachment = wp_get_attachment_url( $attachment_id );

		return wp_send_json(
			array(
				'files' => $_FILES,
				'id'    => $attachment_id,
				'url'   => $attachment,
				'error' => false,
			)
		);
	}

	public function profile_fields( $additional_fields ) {
		$forms        = get_option( 'stm_lms_form_builder_forms', array() );
		$profile_form = array();
		if ( ! empty( $forms ) && is_array( $forms ) ) {
			foreach ( $forms as $form ) {
				if ( 'profile_form' === $form['slug'] ) {
					$profile_form = $form['fields'];
				}
			}
		}

		$custom_fields = array();
		foreach ( $profile_form as $field ) {
			$custom_fields[ $field['id'] ] = array(
				'label'    => ! empty( $field['label'] ) ? $field['label'] : $field['field_name'],
				'required' => ( ! empty( $field['required'] ) && 'false' !== $field['required'] ) ? true : false,
			);
		}

		if ( ! empty( $custom_fields ) ) {
			$additional_fields = array_merge( $additional_fields, $custom_fields );
		}

		return $additional_fields;
	}

	public static function profile_default_fields_for_register() {
		$default_profile_form = get_option( 'stm_lms_default_profile_form' );
		$fields               = array();
		if ( ! empty( $default_profile_form ) ) {
			foreach ( $default_profile_form as $index => $field ) {
				if ( $field['register'] && 'false' !== $field['register'] ) {
					$fields[ $index ] = $field;
				}
			}
		}
		return apply_filters( 'stm_lms_profile_form_default_fields_info', $fields );
	}

	public static function register_form_fields( $only_register = true ) {
		$forms             = get_option( 'stm_lms_form_builder_forms', array() );
		$profile_form      = array();
		$become_instructor = array();
		$register_form     = array();

		foreach ( $forms as $form ) {
			if ( 'profile_form' === $form['slug'] ) {
				$profile_form = $form['fields'];
			} elseif ( 'become_instructor' === $form['slug'] ) {
				$become_instructor = $form['fields'];
			}
		}

		foreach ( $profile_form as $field ) {

			if ( $only_register ) {
				if ( ! empty( $field['register'] ) ) {
					$register_form[] = $field;
				}
			} else {
				$register_form[] = $field;
			}
		}

		return array(
			'register'          => $register_form,
			'become_instructor' => $become_instructor,
		);
	}

	public function email_settings( $data ) {
		$profile_form_name = 'profile_form';
		$profile_form      = self::get_form_fields( $profile_form_name );
		$profile_fields    = array();

		if ( ! empty( $profile_form ) ) {
			foreach ( $profile_form as $field ) {
				if ( ! empty( $field['slug'] ) ) {
					$profile_fields[ $field['slug'] ] = ! empty( $field['label'] ) ? $field['label'] : $field['slug'];
				}
			}
		}

		if ( ! empty( $profile_fields ) ) {
			$profile_fields['blog_name']                     = esc_html__( 'Blog name', 'masterstudy-lms-learning-management-system-pro' );
			$data['stm_lms_user_registered_on_site']['vars'] = $profile_fields;
		}

		$enterprise_form_name = 'enterprise_form';
		$enterprise_form      = self::get_form_fields( $enterprise_form_name );
		$enterprise_fields    = array();

		if ( ! empty( $enterprise_form ) ) {
			foreach ( $enterprise_form as $field ) {
				if ( ! empty( $field['slug'] ) ) {
					$enterprise_fields[ $field['slug'] ] = ! empty( $field['label'] ) ? $field['label'] : $field['slug'];
				}
			}
		}

		if ( ! empty( $enterprise_fields ) ) {
			$data['stm_lms_enterprise']['vars'] = array_merge(
				$enterprise_fields,
				array(
					'date' => esc_html__( 'Submission Date', 'masterstudy-lms-learning-management-system-pro' ),
				)
			);
		}

		$become_instructor_form_name = 'become_instructor';
		$become_instructor_form      = self::get_form_fields( $become_instructor_form_name );
		$become_instructor_fields    = array();

		if ( ! empty( $become_instructor_form ) ) {
			foreach ( $become_instructor_form as $field ) {
				if ( ! empty( $field['slug'] ) ) {
					$become_instructor_fields[ $field['slug'] ] = ! empty( $field['label'] ) ? $field['label'] : $field['slug'];
				}
			}
		}

		if ( ! empty( $become_instructor_fields ) ) {
			$become_instructor_fields['user_login']          = esc_html__( 'User login', 'masterstudy-lms-learning-management-system-pro' );
			$become_instructor_fields['user_id']             = esc_html__( 'User ID', 'masterstudy-lms-learning-management-system-pro' );
			$become_instructor_fields['date']                = esc_html__( 'Application Date', 'masterstudy-lms-learning-management-system-pro' );
			$data['stm_lms_become_instructor_email']['vars'] = $become_instructor_fields;
		}

		return $data;
	}

	public function profile_form_default_fields_info( $fields ) {
		$default_labels = array(
			'first_name'  => array(
				'label'       => esc_html__( 'First Name', 'masterstudy-lms-learning-management-system-pro' ),
				'placeholder' => esc_html__( 'Enter your name', 'masterstudy-lms-learning-management-system-pro' ),
			),
			'last_name'   => array(
				'label'       => esc_html__( 'Last Name', 'masterstudy-lms-learning-management-system-pro' ),
				'placeholder' => esc_html__( 'Enter your last name', 'masterstudy-lms-learning-management-system-pro' ),
			),
			'position'    => array(
				'label'       => esc_html__( 'Position', 'masterstudy-lms-learning-management-system-pro' ),
				'placeholder' => esc_html__( 'Enter your position', 'masterstudy-lms-learning-management-system-pro' ),
			),
			'description' => array(
				'label'       => esc_html__( 'Bio', 'masterstudy-lms-learning-management-system-pro' ),
				'placeholder' => esc_html__( 'Enter your BIO', 'masterstudy-lms-learning-management-system-pro' ),
			),
		);

		$default_profile_fields = get_option( 'stm_lms_default_profile_form' );

		foreach ( $fields as $field => &$value ) {
			if ( array_key_exists( $field, $default_labels ) ) {
				$value['label']       = $default_labels[ $field ]['label'];
				$value['placeholder'] = $default_labels[ $field ]['placeholder'];
			}

			$value['register'] = $default_profile_fields[ $field ]['register'] ?? false;
			$value['required'] = $default_profile_fields[ $field ]['required'] ?? false;
			$value['value']    = '';
		}

		return $fields;
	}

	public function display_fields_in_profile( $user ) {
		require_once STM_LMS_PRO_ADDONS . '/form_builder/templates/admin_profile_fields.php';
	}

	public function save_fields_in_profile( $user_id ) {
		$fields = self::register_form_fields( false );
		if ( ! empty( $fields ) && isset( $fields['register'] ) ) {
			foreach ( $fields['register'] as $field ) {
				update_user_meta( $user_id, $field['id'], sanitize_text_field( $_POST[ $field['id'] ] ) ); // phpcs:ignore WordPress.Security.NonceVerification.Missing
			}
		}
	}
}
