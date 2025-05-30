<?php
/**
 * @var $assignment_id
 */

wp_enqueue_style( 'instructor-assignments-table' );
stm_lms_pro_register_script( 'assignments/student-assignments-list' );
wp_localize_script(
	'stm-lms-assignments/student-assignments-list',
	'stm_lms_assignment',
	array(
		'assignment_id' => $assignment_id,
	)
);

$theads = array(
	'student_name' => array(
		'title'    => esc_html__( 'Student name', 'masterstudy-lms-learning-management-system-pro' ),
		'position' => 'start',
		'hidden'   => false,
		'grow'     => 'masterstudy-tcell_is-grow',
	),
	'course'       => array(
		'title'    => esc_html__( 'Course', 'masterstudy-lms-learning-management-system-pro' ),
		'position' => 'start',
		'hidden'   => false,
		'grow'     => 'masterstudy-tcell_is-grow',
	),
	'date'         => array(
		'title'    => esc_html__( 'Date', 'masterstudy-lms-learning-management-system-pro' ),
		'position' => 'start',
		'sort'     => 'date',
		'hidden'   => false,
	),
	'try_num'      => array(
		'title'    => esc_html__( 'Attempt number', 'masterstudy-lms-learning-management-system-pro' ),
		'position' => 'start',
		'sort'     => 'try_num',
		'hidden'   => false,
		'grow'     => 'masterstudy-tcell_is-grow',
	),
	'status'       => array(
		'title'    => esc_html__( 'Status', 'masterstudy-lms-learning-management-system-pro' ),
		'position' => 'start',
		'sort'     => 'status',
		'hidden'   => false,
	),
);

if ( is_ms_lms_addon_enabled( 'grades' ) ) {
	// add item before status
	$theads = array_merge(
		array_slice( $theads, 0, 4, true ),
		array(
			'grade' => array(
				'title'    => esc_html__( 'Grade', 'masterstudy-lms-learning-management-system-pro' ),
				'position' => 'start',
				'hidden'   => false,
			),
		),
		array_slice( $theads, 4, count( $theads ) - 1, true )
	);
}
?>
<div class="masterstudy-table">
	<div class="masterstudy-table__toolbar">
		<div class="masterstudy-table__toolbar-header">
			<?php
			STM_LMS_Templates::show_lms_template(
				'components/back-link',
				array(
					'id'  => 'masterstudy-course-player-back',
					'url' => ms_plugin_user_account_url( 'assignments' ),
				)
			);
			?>
			<h3 class="masterstudy-table__title">
				<?php echo esc_html__( 'Student assignments', 'masterstudy-lms-learning-management-system-pro' ); ?>
			</h3>
		</div>

		<div class="masterstudy-table__filters">
			<?php
			STM_LMS_Templates::show_lms_template(
				'components/search',
				array(
					'is_queryable' => false,
					'placeholder'  => esc_html__( 'Search by name', 'masterstudy-lms-learning-management-system-pro' ),
				)
			);
			STM_LMS_Templates::show_lms_template(
				'components/select',
				array(
					'select_name'  => 'status',
					'placeholder'  => esc_html__( 'Status: all', 'masterstudy-lms-learning-management-system-pro' ),
					'select_width' => '160px',
					'is_queryable' => false,
					'options'      => array(
						'pending'    => esc_html__( 'Pending', 'masterstudy-lms-learning-management-system-pro' ),
						'passed'     => esc_html__( 'Passed', 'masterstudy-lms-learning-management-system-pro' ),
						'not_passed' => esc_html__( 'Non-passed', 'masterstudy-lms-learning-management-system-pro' ),
					),
				)
			);
			?>
		</div>
	</div>
	<div class="masterstudy-table__wrapper">
		<div class="masterstudy-thead">
			<?php foreach ( $theads as $thead ) : ?>
				<?php
				if ( isset( $thead['hidden'] ) && $thead['hidden'] ) {
					continue;
				}
				?>
				<div class="masterstudy-tcell masterstudy-tcell_is-<?php echo esc_attr( ( $thead['position'] ?? 'center' ) . ' ' . ( $thead['grow'] ?? '' ) ); ?>">
					<div class="masterstudy-tcell__header" data-sort="<?php echo esc_attr( $thead['sort'] ?? 'none' ); ?>">
						<span class="masterstudy-tcell__title"><?php echo esc_html( $thead['title'] ?? '' ); ?></span>
						<?php
						if ( isset( $thead['sort'] ) ) {
							STM_LMS_Templates::show_lms_template( 'components/sort-indicator' );
						}
						?>
					</div>
				</div>
			<?php endforeach; ?>
			<div class="masterstudy-tcell masterstudy-tcell_is-center masterstudy-tcell_is-hidden-md"></div>
		</div>
		<div class="masterstudy-tbody">
			<div class="masterstudy-table__item masterstudy-table__item--hidden masterstudy-table__item--clone">
				<div class="masterstudy-tcell masterstudy-tcell_is-grow" data-th="<?php echo esc_html__( 'Assigments', 'masterstudy-lms-learning-management-system-pro' ); ?>:" data-th-inlined="false">
					<span class="masterstudy-tcell__title masterstudy-tcell__data" data-key="title" data-value=""></span>
				</div>
				<div class="masterstudy-tcell masterstudy-tcell_is-grow" data-th="<?php echo esc_html__( 'In course', 'masterstudy-lms-learning-management-system-pro' ); ?>:" data-th-inlined="false">
					<ul class="masterstudy-table__list">
						<li>
							<a href="" class="masterstudy-tcell__data" data-key="course"></a>
							<span class="masterstudy-table__list-no-course">
								<?php echo esc_html__( 'No linked courses', 'masterstudy-lms-learning-management-system-pro' ); ?>
							</span>
						</li>
					</ul>
				</div>
				<div class="masterstudy-tcell masterstudy-tcell_is-start masterstudy-tcell_is-sm-space-between masterstudy-tcell_is-sm-border-bottom" data-th="<?php echo esc_html( $theads['date']['title'] ?? '' ); ?>:"  data-th-inlined="true"> 
					<span class="masterstudy-tcell__item masterstudy-tcell__item-mobile"><?php echo esc_html( $theads['date']['title'] ?? '' ); ?>:&nbsp;</span>
					<span class="masterstudy-tcell__data" data-key="date" data-value=""></span>
				</div>
				<div class="masterstudy-tcell masterstudy-tcell_is-grow masterstudy-tcell_is-start masterstudy-tcell_is-sm-space-between masterstudy-tcell_is-sm-border-bottom" data-th="<?php echo esc_html( $theads['try_num']['title'] ?? '' ); ?>:" data-th-inlined="true">
					<span class="masterstudy-tcell__item masterstudy-tcell__item-mobile"><?php echo esc_html( $theads['try_num']['title'] ?? '' ); ?>:&nbsp;</span>
					<span class="masterstudy-tcell__data" data-key="try_num" data-value=""></span>
				</div>
				<?php if ( is_ms_lms_addon_enabled( 'grades' ) ) : ?>
					<div class="masterstudy-tcell masterstudy-tcell_is-start masterstudy-tcell_is-sm-space-between masterstudy-tcell_is-sm-border-bottom" data-th="<?php echo esc_html( $theads['grade']['title'] ?? '' ); ?>:" data-th-inlined="true">
						<span class="masterstudy-tcell__item masterstudy-tcell__item-mobile"><?php echo esc_html( $theads['grade']['title'] ?? '' ); ?>:&nbsp;</span>
						<span class="masterstudy-tcell__data" data-key="grade" data-value=""></span>
					</div>
				<?php endif; ?>
				<div class="masterstudy-tcell masterstudy-tcell_is-start masterstudy-tcell_is-sm-space-between" data-th="<?php echo esc_html( $theads['status']['title'] ?? '' ); ?>:" data-th-inlined="true">
					<span><i class=""></i>&nbsp;</span>
					<span class="masterstudy-tcell__data" data-key="status" data-value=""></span>
				</div>
				<div class="masterstudy-tcell">
					<span class="masterstudy-table__component masterstudy-tcell__data" data-key="review_link">
					<?php
						STM_LMS_Templates::show_lms_template(
							'components/button',
							array(
								'title'         => esc_html__( 'Review', 'masterstudy-lms-learning-management-system-pro' ),
								'style'         => 'secondary',
								'size'          => 'sm',
								'link'          => '',
								'id'            => 'student-assignment-review',
								'icon_position' => '',
								'icon_name'     => '',
							)
						);
						?>
					</span>
				</div>
			</div>
			<div class="masterstudy-table__item masterstudy-table__item--hidden masterstudy-table__item--clone">
				<div class="masterstudy-tcell masterstudy-tcell_is-empty">
					<?php echo esc_html__( 'No Assignments found.', 'masterstudy-lms-learning-management-system-pro' ); ?>
				</div>
			</div>
		</div>
		<div class="masterstudy-tfooter masterstudy-tfooter--hidden">
			<div class="masterstudy-tcell masterstudy-tcell_is-space-between">
				<span class="masterstudy-assignment__pagination">
					<?php
					STM_LMS_Templates::show_lms_template(
						'components/pagination',
						array(
							'max_visible_pages' => 3,
							'total_pages'       => 1,
							'dark_mode'         => false,
							'current_page'      => 1,
							'is_queryable'      => false,
							'done_indicator'    => false,
							'is_ajax'           => true,
						)
					);
					?>
				</span>				
			</div>
			<div class="masterstudy-tcell masterstudy-tcell_is-space-between">
				<span>
				<?php
				STM_LMS_Templates::show_lms_template(
					'components/select',
					array(
						'select_id'    => 'assignments-per-page',
						'select_width' => '170px',
						'select_name'  => 'per_page',
						'placeholder'  => __( '10 per page', 'masterstudy-lms-learning-management-system-pro' ),
						'default'      => 10,
						'is_queryable' => false,
						'options'      => array(
							'25'  => esc_html__( '25 per page', 'masterstudy-lms-learning-management-system-pro' ),
							'50'  => esc_html__( '50 per page', 'masterstudy-lms-learning-management-system-pro' ),
							'75'  => esc_html__( '75 per page', 'masterstudy-lms-learning-management-system-pro' ),
							'100' => esc_html__( '100 per page', 'masterstudy-lms-learning-management-system-pro' ),
						),
					)
				);
				?>
				</span>
			</div>
		</div>
	</div>
	<?php
	STM_LMS_Templates::show_lms_template(
		'components/loader',
		array(
			'dark_mode' => false,
			'is_local'  => true,
		)
	);
	?>
</div>
