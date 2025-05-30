<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

STM_LMS_Templates::show_lms_template( 'header' );

wp_enqueue_script( 'vue-resource.js' );
wp_enqueue_script( 'vue2-datepicker' );

do_action( 'stm_lms_template_main' );

STM_LMS_Templates::show_lms_template( 'modals/preloader' );
?>
	<div class="stm-lms-wrapper stm-lms-wrapper--assignments user-account-page">
		<div class="container">
			<div id="stm_lms_statistics">
				<?php STM_LMS_Templates::show_lms_template( 'account/private/instructor_parts/statistic/main' ); ?>
			</div>
		</div>
	</div>
<?php
	STM_LMS_Templates::show_lms_template( 'footer' );
