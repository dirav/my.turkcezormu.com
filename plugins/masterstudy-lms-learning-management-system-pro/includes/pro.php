<?php
require_once STM_LMS_PRO_INCLUDES . '/helpers.php';

require_once STM_LMS_PRO_INCLUDES . '/hooks/templates.php';
require_once STM_LMS_PRO_INCLUDES . '/hooks/sale-price.php';
require_once STM_LMS_PRO_INCLUDES . '/hooks/routes.php';
require_once STM_LMS_PRO_INCLUDES . '/hooks/course-player.php';

require_once STM_LMS_PRO_INCLUDES . '/hooks/woocommerce.php';

if ( STM_LMS_Cart::woocommerce_checkout_enabled() ) {
	require_once STM_LMS_PRO_INCLUDES . '/classes/class-woocommerce.php';
	require_once STM_LMS_PRO_INCLUDES . '/hooks/woocommerce-orders.php';
	require_once STM_LMS_PRO_INCLUDES . '/classes/class-woocommerce-coupons.php';
	require_once STM_LMS_PRO_INCLUDES . '/classes/class-woocommerce-gla.php';
	require_once STM_LMS_PRO_INCLUDES . '/classes/class-woocommerce-fb.php';

	function stm_lms_init_woocommerce() {
		new STM_LMS_Woocommerce();
		if ( class_exists( '\Automattic\WooCommerce\GoogleListingsAndAds\PluginFactory' ) ) {
			new STM_LMS_GLA_Course_Integration();
		}
		if ( class_exists( 'WC_Facebook_Loader' ) ) {
			new STM_LMS_FB_Commerce_Course_Integration();
		}
	}

	add_action( 'init', 'stm_lms_init_woocommerce' );
}

require_once STM_LMS_PRO_INCLUDES . '/classes/class-announcements.php';
require_once STM_LMS_PRO_INCLUDES . '/classes/class-courses.php';
require_once STM_LMS_PRO_PATH . '/vendor/autoload.php';
require_once STM_LMS_PRO_INCLUDES . '/classes/class-addons.php';
require_once STM_LMS_PRO_INCLUDES . '/classes/class-certificates.php';

if ( is_admin() ) {
	require_once STM_LMS_PRO_INCLUDES . '/libraries/plugin-installer/plugin_installer.php';
	require_once STM_LMS_PRO_INCLUDES . '/libraries/announcement/item-announcements.php';
	require_once STM_LMS_PRO_INCLUDES . '/libraries/compatibility/main.php';
}

add_filter(
	'masterstudy_lms_plugin_addons',
	function ( $addons ) {
		return array_merge(
			$addons,
			array(
				new \MasterStudy\Lms\Pro\addons\assignments\Assignments(),
				new \MasterStudy\Lms\Pro\addons\certificate_builder\CertificateBuilder(),
				new \MasterStudy\Lms\Pro\addons\sequential_drip_content\DripContent(),
				new \MasterStudy\Lms\Pro\addons\email_manager\EmailManager(),
				new \MasterStudy\Lms\Pro\addons\gradebook\Gradebook(),
				new \MasterStudy\Lms\Pro\addons\live_streams\LiveStreams(),
				new \MasterStudy\Lms\Pro\addons\media_library\MediaLibrary(),
				new \MasterStudy\Lms\Pro\addons\MultiInstructors\MultiInstructors(),
				new \MasterStudy\Lms\Pro\addons\prerequisite\Prerequisite(),
				new \MasterStudy\Lms\Pro\addons\scorm\Scorm(),
				new \MasterStudy\Lms\Pro\addons\shareware\Shareware(),
				new \MasterStudy\Lms\Pro\addons\zoom_conference\ZoomConference(),
				new \MasterStudy\Lms\Pro\addons\CourseBundle\CourseBundle(),
			)
		);
	}
);

// Load LMS Plugin Files
add_action(
	'masterstudy_lms_plugin_loaded',
	function ( $plugin ) {
		// Load Pro Routes
		$plugin->get_router()->load_routes( STM_LMS_PRO_PATH . '/rest-api/Routes/Orders.php' );
	}
);
