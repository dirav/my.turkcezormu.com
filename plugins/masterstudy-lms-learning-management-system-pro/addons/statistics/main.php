<?php
new Stm_Lms_Statistics();

class Stm_Lms_Statistics {

	public function __construct() {
		if ( class_exists( '\stmLms\Classes\Models\StmStatistics' ) ) {
			$statistics = new \stmLms\Classes\Models\StmStatistics();
			$statistics->admin_menu();
			$user = new \stmLms\Classes\Models\StmUser( get_current_user_id() );
			if ( $user ) {
				$user_role = $user->getRole();
				if ( is_admin() || ! current_user_can( 'administrator' ) && STM_LMS_Instructor::is_instructor( get_current_user_id() )
					|| $user_role && 'stm_lms_instructor' === $user_role['id'] ) {
					add_filter(
						'stm_lms_menu_items',
						function ( $menus ) {
							$menus[] = array(
								'order'        => 70,
								'id'           => 'payout',
								'slug'         => 'payout',
								'lms_template' => 'stm-lms-payout-statistic',
								'menu_title'   => esc_html__( 'Payout', 'masterstudy-lms-learning-management-system-pro' ),
								'menu_icon'    => 'fa-dollar-sign',
								'menu_url'     => ms_plugin_user_account_url( 'payout' ),
								'menu_place'   => 'main',
							);

							return $menus;
						}
					);
				}
			}
		}
	}
}
