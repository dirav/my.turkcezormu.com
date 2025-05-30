<?php

use MasterStudy\Lms\Pro\addons\certificate_builder\CertificateRepository;
use MasterStudy\Lms\Pro\addons\email_manager\EmailDataCompiler;
use MasterStudy\Lms\Pro\addons\email_manager\EmailManagerSettingsPage;

add_filter( 'stm_lms_filter_email_data', array( EmailDataCompiler::class, 'compile' ), 10, 1 );
add_filter( 'wpcfto_options_page_setup', array( EmailManagerSettingsPage::class, 'setup' ), 100 );

function get_user_types() {
	return array(
		'student'    => array(
			'enable'    => 'stm_lms_reports_student_checked_enable',
			'frequency' => 'stm_lms_reports_student_checked_frequency',
			'day'       => 'stm_lms_reports_student_checked_period',
			'time'      => 'stm_lms_reports_student_checked_time',
			'event'     => 'send_student_email_digest_event',
			'callback'  => 'send_student_email_digest_callback',
			'role'      => 'student',
		),
		'instructor' => array(
			'enable'    => 'stm_lms_reports_instructor_checked_enable',
			'frequency' => 'stm_lms_reports_instructor_checked_frequency',
			'day'       => 'stm_lms_reports_instructor_checked_period',
			'time'      => 'stm_lms_reports_instructor_checked_time',
			'event'     => 'send_instructor_email_digest_event',
			'callback'  => 'send_instructor_email_digest_callback',
			'role'      => 'instructor',
		),
		'admin'      => array(
			'enable'    => 'stm_lms_reports_admin_checked_enable',
			'frequency' => 'stm_lms_reports_admin_checked_frequency',
			'day'       => 'stm_lms_reports_admin_checked_period',
			'time'      => 'stm_lms_reports_admin_checked_time',
			'event'     => 'send_admin_email_digest_event',
			'callback'  => 'send_admin_email_digest_callback',
			'role'      => 'administrator',
		),
	);
}

function custom_cron_schedules( $schedules ) {
	if ( ! isset( $schedules['weekly'] ) ) {
		$schedules['weekly'] = array(
			'interval' => WEEK_IN_SECONDS,
			'display'  => __( 'Once Weekly' ),
		);
	}
	if ( ! isset( $schedules['monthly'] ) ) {
		$schedules['monthly'] = array(
			'interval' => 30 * DAY_IN_SECONDS,
			'display'  => __( 'Once Monthly' ),
		);
	}

	return $schedules;
}
add_filter( 'cron_schedules', 'custom_cron_schedules' );

function schedule_digest_cron() {
	$user_types = get_user_types();
	$settings   = get_option( 'stm_lms_email_manager_settings', array() );

	foreach ( $user_types as $user_type => $user_settings ) {
		$event_name = $user_settings['event'];

		$scheduled_timestamp = wp_next_scheduled( $event_name );
		if ( $scheduled_timestamp ) {
			wp_unschedule_event( $scheduled_timestamp, $event_name );
		}

		if ( ! empty( $settings[ $user_settings['enable'] ] ) ) {
			$frequency = $settings[ $user_settings['frequency'] ];
			$day       = $settings[ $user_settings['day'] ];
			$time      = $settings[ $user_settings['time'] ];

			if ( ! in_array( $frequency, array( 'weekly', 'monthly' ), true ) ) {
				continue;
			}

			if ( 'monthly' === $frequency ) {
				$next_scheduled = strtotime( "first day of next month $time" );
			} else {
				$next_scheduled = strtotime( "next $day $time" );
			}

			if ( false === $next_scheduled ) {
				continue;
			}

			wp_schedule_event( $next_scheduled, $frequency, $event_name );
		}
	}
}
add_action( 'wpcfto_after_settings_saved', 'schedule_digest_cron' );

function unschedule_digest_cron() {
	$user_types = get_user_types();
	foreach ( $user_types as $user_type => $user_settings ) {
		$event_name          = $user_settings['event'];
		$scheduled_timestamp = wp_next_scheduled( $event_name );
		if ( $scheduled_timestamp ) {
			wp_unschedule_event( $scheduled_timestamp, $event_name );
		}
	}
}
register_deactivation_hook( __FILE__, 'unschedule_digest_cron' );

function process_user_emails( $role_to_check, $send_test_email = false ) {
	$number        = 20;
	$page          = 1;
	$email_subject = get_subject_by_role( $role_to_check, get_option( 'stm_lms_email_manager_settings', array() ) );

	if ( $send_test_email ) {
		add_filter( 'wp_mail_content_type', 'STM_LMS_Helpers::set_html_content_type' );
		masterstudy_lms_load_report_template( $email_subject, get_option( 'admin_email' ), $role_to_check );
		remove_filter( 'wp_mail_content_type', 'STM_LMS_Helpers::set_html_content_type' );
		die;
	}

	do {
		$user_query = new WP_User_Query(
			array(
				'number'     => $number,
				'paged'      => $page,
				'fields'     => array( 'ID', 'user_email' ),
				'meta_query' => array(
					array(
						'key'     => 'disable_report_email_notifications',
						'compare' => 'NOT EXISTS',
					),
				),
				'role'       => $role_to_check,
			)
		);

		$users = $user_query->get_results();
		add_filter( 'wp_mail_content_type', 'STM_LMS_Helpers::set_html_content_type' );

		if ( ! empty( $users ) ) {
			foreach ( $users as $user ) {
				$user_id    = $user->ID;
				$user_email = $user->user_email;
				masterstudy_lms_load_report_template( $email_subject, $user_email, $role_to_check, $user_id );
			}
		}

		remove_filter( 'wp_mail_content_type', 'STM_LMS_Helpers::set_html_content_type' );

		$page ++;

	} while ( ! empty( $users ) );
}

function masterstudy_lms_load_report_template( $email_subject, $user_email, $role_to_check, $user_id = 0 ) {
	$settings = array();

	if ( class_exists( 'STM_LMS_Email_Manager' ) ) {
		$settings = STM_LMS_Email_Manager::stm_lms_get_settings();
	}

	$message = STM_LMS_Templates::load_lms_template(
		'emails/report-template',
		array(
			'email_manager' => $settings,
			'role'          => $role_to_check,
			'user_id'       => $user_id,
		)
	);

	add_filter(
		'wp_mail_from',
		function ( $from_email ) use ( $settings ) {
			return $settings['stm_lms_email_template_header_email'] ?? $from_email;
		}
	);

	wp_mail( $user_email, $email_subject, $message );
}

// Helper function to check if a specific digest is enabled
function is_digest_enabled( $digest_key ) {
	$email_settings = get_option( 'stm_lms_email_manager_settings', array() );
	return isset( $email_settings[ $digest_key ] ) && $email_settings[ $digest_key ];
}

function send_student_email_digest_callback() {
	if ( is_digest_enabled( 'stm_lms_reports_student_checked_enable' ) ) {
		process_user_emails( 'subscriber' );
	}
}
add_action( 'send_student_email_digest_event', 'send_student_email_digest_callback' );

function send_instructor_email_digest_callback() {
	if ( is_digest_enabled( 'stm_lms_reports_instructor_checked_enable' ) ) {
		process_user_emails( 'stm_lms_instructor' );
	}
}
add_action( 'send_instructor_email_digest_event', 'send_instructor_email_digest_callback' );

function send_admin_email_digest_callback() {
	$email_settings = get_option( 'stm_lms_email_manager_settings', array() );

	if ( is_digest_enabled( 'stm_lms_reports_admin_checked_enable' ) || empty( $email_settings ) ) {
		process_user_emails( 'administrator' );
	}
}
add_action( 'send_admin_email_digest_event', 'send_admin_email_digest_callback' );

function mastertudy_plugin_send_certificate_email( $user_id, $course_id, $test_mode ) {
	if ( ! $course_id || ! $user_id ) {
		return;
	}

	$user_data = get_userdata( $user_id );
	if ( ! $user_data ) {
		return;
	}

	$manager_settings = get_option( 'stm_lms_email_manager_settings', array() );
	$email_template = $manager_settings['stm_lms_certificates_preview_checked'] ??
	'<h2>' . esc_html__( 'You have received a certificate!', 'masterstudy-lms-learning-management-system-pro' ) . '</h2>' .
	'{{date}}' .
	'{{certificate_preview}}' .
	'{{button}}';

	$student_email       = $user_data->user_email;
	$current_time        = date_i18n( 'F j, Y g:i a', current_time( 'timestamp' ) );
	$button_url          = ( new CertificateRepository() )->certificate_page_url() . "?user={$user_id}&course={$course_id}";
	$email_subject       = $manager_settings['stm_lms_certificates_preview_checked_subject'] ?? esc_html__( 'You have received a certificate!', 'masterstudy-lms-learning-management-system-pro' );
	$button_message      = esc_html__( 'View Certificate', 'masterstudy-lms-learning-management-system-pro' );
	$certificate_preview = STM_LMS_PRO_URL . '/assets/img/emails/certificate_preview.jpg';

	$replacements = array(
		'{{date}}'                => "<p><strong>{$current_time}</strong></p>",
		'{{certificate_preview}}' => "<p><img src='{$certificate_preview}' alt='Certificate Preview' style='max-width: 620px; width: auto; height: auto; display: block; margin: 0 auto;' /></p>",
		'{{button}}'              => "<p><a href='{$button_url}' class='masterstudy-button masterstudy-button_style-primary masterstudy-button_size-sm masterstudy-button_icon-left masterstudy-button_icon-upload-alt' style='display: inline-block; padding: 10px 20px; background-color: #007bff; color: white; text-decoration: none; font-size: 16px; border-radius: 5px; margin-top: 25px;'>{$button_message}</a></p>",
	);

	$email_template = str_replace( '<br>', '', $email_template ); // Remove all <br> tags
	$email_template = '<div>' . $email_template . '</div>';

	$email_template = $email_template . "<style>
		body{
		    margin-top: 40px;
		    margin-bottom: 40px;
		}
		 h2{
		  color: #333; text-align: center; margin-bottom: 20px; font-size: 24px; font-weight: bold;
		  font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol';
		 }
		 p, div{
		   text-align: center;
		   font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol';
		 }
		</style>";
	$email_body = str_replace( array_keys( $replacements ), array_values( $replacements ), $email_template );

	STM_LMS_Helpers::send_email(
		$student_email,
		$email_subject,
		$email_body,
		'stm_lms_send_email_certificate_preview',
		array(),
		true
	);
}
add_action( 'masterstudy_plugin_student_course_completion', 'mastertudy_plugin_send_certificate_email', 10, 3 );

if ( STM_LMS_Helpers::is_pro() && ! STM_LMS_Helpers::is_pro_plus() ) {
	add_filter( 'stm_lms_filter_email_data', 'masterstudy_plugin_pro_email_filter_email_data', 90, 1 );
}
function masterstudy_plugin_pro_email_filter_email_data( $data ) {

	$data['message'] = STM_LMS_Templates::load_lms_template(
		'emails/pro-template',
		array(
			'message' => $data['message'],
			'subject' => $data['subject'],
		)
	);

	return $data;
}
