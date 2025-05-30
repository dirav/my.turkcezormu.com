<?php

add_filter(
	'stm_lms_custom_routes_config',
	function ( $routes ) {
		$routes['user_url']['sub_pages']['gradebook'] = array(
			'template'         => 'stm-lms-gradebook',
			'protected'        => true,
			'instructors_only' => true,
			'url'              => 'gradebook',
		);

		$routes['user_url']['sub_pages']['enterprise_groups'] = array(
			'template'  => 'stm-lms-enterprise-groups',
			'protected' => true,
			'url'       => 'enterprise-groups',
			'sub_pages' => array(
				'enterprise_group' => array(
					'template'  => 'stm-lms-enterprise-group',
					'protected' => true,
					'var'       => 'group_id',
				),
			),
		);

		$routes['user_url']['sub_pages']['google_meets'] = array(
			'template'  => 'stm-lms-google-meets',
			'protected' => true,
			'url'       => 'google-meets',
		);

		$routes['user_url']['sub_pages']['assignments'] = array(
			'template'  => 'stm-lms-assignments',
			'protected' => true,
			'url'       => 'assignments',
			'sub_pages' => array(
				'assignment' => array(
					'template'  => 'stm-lms-assignment',
					'protected' => true,
					'var'       => 'assignment_id',
				),
			),
		);

		$routes['user_url']['sub_pages']['enrolled_assignments'] = array(
			'template'  => 'stm-lms-enrolled-assignments',
			'protected' => true,
			'url'       => 'enrolled-assignments',
		);

		$routes['user_url']['sub_pages']['user_assignment'] = array(
			'template'  => 'stm-lms-user-assignment',
			'protected' => true,
			'url'       => 'user-assignment',
			'sub_pages' => array(
				'assignment' => array(
					'template'  => 'stm-lms-user-assignment',
					'protected' => true,
					'var'       => 'assignment_id',
				),
			),
		);

		$routes['user_url']['sub_pages']['points_history'] = array(
			'template'  => 'stm-lms-user-points-history',
			'protected' => true,
			'url'       => 'points-history',
		);

		$routes['user_url']['sub_pages']['points_distribution'] = array(
			'template'  => 'stm-lms-user-points-distribution',
			'protected' => true,
			'url'       => 'points-distribution',
		);

		$routes['user_url']['sub_pages']['bundles'] = array(
			'template'  => 'stm-lms-user-bundles',
			'protected' => true,
			'url'       => 'bundles',
			'sub_pages' => array(
				'bundle' => array(
					'template'  => 'stm-lms-user-bundle',
					'protected' => true,
					'var'       => 'bundle_id',
				),
			),
		);

		$routes['user_url']['sub_pages']['payout_statistic'] = array(
			'template'  => 'stm-lms-payout-statistic',
			'protected' => true,
			'url'       => 'payout',
		);

		$routes['user_url']['sub_pages']['manage_google_meet'] = array(
			'template'         => 'course-builder',
			'protected'        => true,
			'instructors_only' => true,
			'url'              => 'edit-google-meet',
			'sub_pages'        => array(
				'edit_course' => array(
					'template'  => 'course-builder',
					'protected' => true,
					'var'       => 'google_meet_id',
				),
			),
		);

		$routes['user_url']['sub_pages']['analytics'] = array(
			'title'            => esc_html__( 'Analytics', 'masterstudy-lms-learning-management-system-pro' ),
			'template'         => 'analytics/revenue',
			'protected'        => true,
			'instructors_only' => true,
			'url'              => 'analytics',
			'sub_pages'        => array(
				'engagement' => array(
					'template'         => 'analytics/engagement',
					'url'              => 'engagement',
					'instructors_only' => true,
					'protected'        => true,
				),
				'students'   => array(
					'template'         => 'analytics/instructor-students',
					'url'              => 'instructor-students',
					'instructors_only' => true,
					'protected'        => true,
				),
				'reviews'    => array(
					'template'         => 'analytics/reviews',
					'url'              => 'reviews',
					'instructors_only' => true,
					'protected'        => true,
				),
				'course'     => array(
					'template'         => 'analytics/course',
					'url'              => 'course',
					'instructors_only' => true,
					'protected'        => true,
				),
				'bundle'     => array(
					'template'         => 'analytics/bundle',
					'url'              => 'bundle',
					'instructors_only' => true,
					'protected'        => true,
				),
				'student'    => array(
					'template'         => 'analytics/student',
					'url'              => 'student',
					'instructors_only' => true,
					'protected'        => true,
				),
			),
		);

		if ( is_ms_lms_addon_enabled( 'grades' ) ) {
			$routes['user_url']['sub_pages']['grades'] = array(
				'title'            => esc_html__( 'Grades', 'masterstudy-lms-learning-management-system-pro' ),
				'template'         => 'grades/instructor',
				'protected'        => true,
				'instructors_only' => true,
				'url'              => 'grades',
			);

			$routes['user_url']['sub_pages']['my-grades'] = array(
				'title'     => esc_html__( 'My grades', 'masterstudy-lms-learning-management-system-pro' ),
				'template'  => 'grades/student',
				'url'       => 'my-grades',
				'protected' => true,
			);
		}

		if ( is_ms_lms_addon_enabled( 'certificate_builder' ) ) {
			$routes['certificate_page_url'] = array(
				'title'    => esc_html__( 'Certificate Page', 'masterstudy-lms-learning-management-system-pro' ),
				'template' => 'stm-lms-certificate',
			);
		}

		$routes['user_url']['sub_pages']['sales'] = array(
			'title'            => esc_html__( 'My Sales', 'masterstudy-lms-learning-management-system-pro' ),
			'template'         => 'analytics/sales',
			'protected'        => true,
			'instructors_only' => true,
			'url'              => 'sales',
			'sub_pages'        => array(),
		);

		return $routes;
	}
);
