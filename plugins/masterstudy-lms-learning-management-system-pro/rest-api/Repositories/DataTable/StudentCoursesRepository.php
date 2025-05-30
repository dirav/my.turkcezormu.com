<?php

namespace MasterStudy\Lms\Pro\RestApi\Repositories\DataTable;

class StudentCoursesRepository extends DataTableAbstractRepository {

	public function get_student_course_progress_data( $student_id, $columns = array(), $order = array() ): array {
		$this->apply_sort( $order, $columns, 'name' );

		$instructor_join = '';
		if ( $this->is_current_user_instructor() ) {
			$instructor_join = $this->db->prepare(
				"INNER JOIN {$this->db->posts} c ON c.post_type = 'stm-courses' AND c.post_status IN ('publish') AND c.post_author = %d AND uc.course_id = c.ID",
				$this->current_instructor_id
			);
		}

		$query = "SELECT 
                DISTINCT p.ID AS course_id,
                p.post_title AS name,
                pm_duration.meta_value AS duration,
                uc.start_time AS started,
                uc.progress_percent AS progress
            FROM {$this->db->prefix}stm_lms_user_courses uc
            INNER JOIN {$this->db->posts} p ON uc.course_id = p.ID
            LEFT JOIN {$this->db->postmeta} pm_duration ON p.ID = pm_duration.post_id AND pm_duration.meta_key = 'duration_info'
            {$instructor_join}
            WHERE uc.user_id = %d
            GROUP BY p.ID, p.post_title, pm_duration.meta_value, uc.start_time, uc.progress_percent
            ORDER BY {$this->sort_by} {$this->sort_dir}
            LIMIT {$this->limit} OFFSET {$this->start}";

		return $this->db->get_results(
			$this->db->prepare( $query, $student_id ),
			ARRAY_A
		);
	}

	public function get_student_membership_data( $student_id, $columns = array(), $order = array() ): array {
		$this->apply_sort( $order, $columns, 'startdate', 'desc' );

		$membership_users_table  = $this->db->prefix . 'pmpro_memberships_users';
		$membership_levels_table = $this->db->prefix . 'pmpro_membership_levels';

		$sort_map = array(
			'price'           => 'initial_payment',
			'name'            => 'membership_name',
			'date_subscribed' => 'startdate',
			'date_canceled'   => 'enddate',
		);

		if ( isset( $sort_map[ $this->sort_by ] ) ) {
			$this->sort_by = $sort_map[ $this->sort_by ];
		}

		return $this->db->get_results(
			$this->db->prepare(
				"SELECT mu.membership_id, ml.name AS membership_name, mu.initial_payment, mu.status, mu.startdate, mu.enddate
				FROM {$membership_users_table} mu
				INNER JOIN {$membership_levels_table} ml ON mu.membership_id = ml.id
				WHERE mu.user_id = {$student_id}
				AND mu.startdate BETWEEN %s AND %s
				ORDER BY {$this->sort_by} {$this->sort_dir}
            	LIMIT {$this->limit} OFFSET {$this->start}",
				$this->date_from,
				$this->date_to,
			)
		);
	}

	public function get_total_membership_count( $user_id ) {
		$table_prefix = $this->db->prefix . 'pmpro_memberships_users';

		// Query to count rows for the given user_id and date range
		return $this->db->get_var(
			$this->db->prepare(
				"SELECT COUNT(*) FROM {$table_prefix} WHERE user_id = %d AND startdate BETWEEN %s AND %s",
				$user_id,
				$this->date_from,
				$this->date_to
			)
		);
	}
	public function get_total_student_courses( $student_id ) {
		return $this->db->get_var(
			$this->db->prepare(
				"SELECT COUNT(DISTINCT course_id) FROM {$this->db->prefix}stm_lms_user_courses uc WHERE uc.user_id = %d",
				$student_id
			)
		);
	}
}
