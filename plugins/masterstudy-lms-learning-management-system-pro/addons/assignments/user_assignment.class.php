<?php

use MasterStudy\Lms\Plugin\PostType;
use MasterStudy\Lms\Pro\addons\assignments\Repositories\AssignmentStudentRepository;

new STM_LMS_User_Assignment();

class STM_LMS_User_Assignment {

	public function __construct() {
		add_action( 'wp_ajax_stm_lms_get_enrolled_assignments', array( $this, 'enrolled_assignments' ) );

		add_filter( 'stm_lms_course_passed_items', array( $this, 'essay_passed' ), 10, 3 );

		add_filter(
			'stm_lms_menu_items',
			function ( $menus ) {
				$menus[] = array(
					'order'        => 135,
					'id'           => 'my_assignments',
					'slug'         => 'enrolled-assignments',
					'lms_template' => 'stm-lms-enrolled-assignments',
					'menu_title'   => esc_html__( 'My Assignments', 'masterstudy-lms-learning-management-system-pro' ),
					'menu_icon'    => 'fa-pen-nib',
					'menu_url'     => ms_plugin_user_account_url( 'enrolled-assignments' ),
					'badge_count'  => STM_LMS_User_Assignment::my_assignments_statuses( get_current_user_id() ),
					'menu_place'   => 'learning',
				);

				return $menus;
			}
		);
	}

	public static function is_my_assignment( $assignment_id, $author_id ) {
		$editor_id = intval( get_post_field( 'post_author', get_post_meta( $assignment_id, 'assignment_id', true ) ) );
		return $editor_id === $author_id;
	}

	public static function get_assignment( $assignment_id ) {
		$editor_id = STM_LMS_User::get_current_user();

		if ( empty( $editor_id ) ) {
			$answer = array(
				'message' => 'Failed',
			);
			return $answer;
		}
		$editor_id = $editor_id['id'];

		if ( ! self::is_my_assignment( $assignment_id, $editor_id ) ) {
			STM_LMS_User::js_redirect( ms_plugin_user_account_url( 'assignments' ) );
			$answer = array(
				'message' => 'Failed',
			);
			return $answer;
		}

		$args = array(
			'post_type'   => 'stm-user-assignment',
			'post_status' => array( 'pending', 'publish' ),
			'post__in'    => array( $assignment_id ),
		);

		$q = new WP_Query( $args );

		$answer = array();

		if ( $q->have_posts() ) {
			while ( $q->have_posts() ) {
				$q->the_post();

				$answer['title']            = get_the_title();
				$answer['status']           = ( new AssignmentStudentRepository() )->get_status( $assignment_id );
				$answer['content']          = get_the_content();
				$answer['assignment_title'] = get_the_title( get_post_meta( $assignment_id, 'assignment_id', true ) );

				$answer['files'] = STM_LMS_Assignments::get_draft_attachments( $assignment_id, 'student_attachments' );
			}
		}

		wp_reset_postdata();

		return $answer;
	}

	private static function per_page() {
		return 6;
	}

	public function essay_passed( $passed_items, $course_materials, $user_id ) {
		foreach ( $course_materials as $material_id ) {
			if ( get_post_type( $material_id ) !== PostType::ASSIGNMENT ) {
				continue;
			}

			if ( ( new AssignmentStudentRepository() )->has_passed_assignment( $material_id, $user_id ) ) {
				++$passed_items;
			}
		}

		return $passed_items;
	}

	public static function my_assignments( $user_id, $page = null ) {
		$args = array(
			'post_type'      => PostType::USER_ASSIGNMENT,
			'posts_per_page' => self::per_page(),
			'offset'         => ( $page * self::per_page() ) - self::per_page(),
			'post_status'    => array( 'pending', 'publish' ),
			'meta_query'     => array(
				'relation' => 'AND',
				array(
					'key'     => 'student_id',
					'value'   => $user_id,
					'compare' => '=',
				),
			),
		);

		if ( ! empty( $_GET['status'] ) && 'undefined' !== $_GET['status'] ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
			$args['meta_query'][] = array(
				'key'     => 'status',
				'value'   => sanitize_text_field( $_GET['status'] ), // phpcs:ignore WordPress.Security.NonceVerification.Recommended
				'compare' => '=',
			);
		}

		if ( ! empty( $_GET['s'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
			$args['s'] = sanitize_text_field( $_GET['s'] ); // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		}

		$q = new WP_Query( $args );

		$posts = array();
		if ( $q->have_posts() ) {
			while ( $q->have_posts() ) {
				$q->the_post();
				$id            = get_the_ID();
				$course_id     = get_post_meta( $id, 'course_id', true );
				$assignment_id = get_post_meta( $id, 'assignment_id', true );
				$who_view      = get_post_meta( $id, 'who_view', true );

				$posts[] = array(
					'assignment_title' => get_the_title( $assignment_id ),
					'course_title'     => get_the_title( $course_id ),
					'updated_at'       => stm_lms_time_elapsed_string( gmdate( 'Y-m-d H:i:s', get_post_timestamp() ) ),
					'status'           => self::statuses( ( new AssignmentStudentRepository() )->get_status( $id ) ),
					'instructor'       => STM_LMS_User::get_current_user( get_post_field( 'post_author', $course_id ) ),
					'url'              => STM_LMS_Lesson::get_lesson_url( $course_id, $assignment_id ),
					'who_view'         => $who_view,
					'pages'            => ceil( $q->found_posts / self::per_page() ),
				);

			}
		}
		return $posts;
	}

	public static function my_assignments_statuses( $user_id ) {
		$args = array(
			'post_type'      => 'stm-user-assignment',
			'posts_per_page' => 1,
			'post_status'    => array( 'publish' ),
			'meta_query'     => array(
				'relation' => 'AND',
				array(
					'key'     => 'student_id',
					'value'   => $user_id,
					'compare' => '=',
				),
				array(
					'key'     => 'who_view',
					'value'   => 0,
					'compare' => '=',
				),
			),
		);

		$q = new WP_Query( $args );

		return $q->found_posts;
	}

	public static function statuses( $status ) {
		$status_labels = array(
			'pending'    => esc_html__( 'Pending...', 'masterstudy-lms-learning-management-system-pro' ),
			'draft'      => esc_html__( 'Draft', 'masterstudy-lms-learning-management-system-pro' ),
			'passed'     => esc_html__( 'Approved', 'masterstudy-lms-learning-management-system-pro' ),
			'not_passed' => esc_html__( 'Declined', 'masterstudy-lms-learning-management-system-pro' ),
		);

		if ( array_key_exists( $status, $status_labels ) ) {
			return array(
				'status' => $status,
				'label'  => $status_labels[ $status ],
			);
		}
	}

	public function enrolled_assignments() {
		check_ajax_referer( 'stm_lms_get_enrolled_assingments', 'nonce' );
		$page = intval( $_GET['page'] );
		$user = STM_LMS_User::get_current_user();
		wp_send_json( self::my_assignments( $user['id'], $page ) );
	}
}
