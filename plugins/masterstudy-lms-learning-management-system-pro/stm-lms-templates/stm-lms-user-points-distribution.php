<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

STM_LMS_Templates::show_lms_template( 'header' );

do_action( 'stm_lms_template_main' );
?>

<?php STM_LMS_Templates::show_lms_template( 'modals/preloader' ); ?>

	<div class="stm-lms-wrapper stm-lms-wrapper--assignments user-account-page">

		<div class="container">

			<?php do_action( 'stm_lms_admin_after_wrapper_start', STM_LMS_User::get_current_user() ); ?>

			<div class="stm-lms-wrapper--gradebook_header">

				<a href="<?php echo esc_url( ms_plugin_user_account_url() ); ?>">
					<i class="stmlms-arrow-left"></i>
					<?php esc_html_e( 'Back to Account', 'masterstudy-lms-learning-management-system-pro' ); ?>
				</a>

			</div>

			<div id="stm_lms_user_assignment">
				<?php STM_LMS_Templates::show_lms_template( 'points/distribution' ); ?>
			</div>

		</div>

	</div>

<?php
	STM_LMS_Templates::show_lms_template( 'footer' );
