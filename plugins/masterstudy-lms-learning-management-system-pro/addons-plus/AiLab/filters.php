<?php

use MasterStudy\Lms\Pro\AddonsPlus\AiLab\Utility\Options;

// Instructor Access field
add_filter(
	'wpcfto_field_instructor-access',
	function () {
		return STM_LMS_PRO_PLUS_ADDONS . '/AiLab/templates/settings/instructor-access.php';
	}
);

// AI Usage field
add_filter(
	'wpcfto_field_ai-usage',
	function () {
		return STM_LMS_PRO_PLUS_ADDONS . '/AiLab/templates/settings/ai-usage.php';
	}
);

// Add AI options to course options
add_filter(
	'masterstudy_lms_course_options',
	function ( $options ) {
		$options_helper = new Options();
		$options['ai']  = array(
			'image_styles'   => $options_helper->get( 'generator.image.styles', array() ),
			'tones'          => $options_helper->get( 'generator.content.tones', array() ),
			'is_ai_enabled'  => method_exists( \STM_LMS_Instructor::class, 'has_ai_access' )
				&& \STM_LMS_Instructor::has_ai_access( get_current_user_id() ),
			'has_ai_api_key' => ! empty( \STM_LMS_Options::get_option( 'openai_api_key' ) ),
		);

		return $options;
	}
);
