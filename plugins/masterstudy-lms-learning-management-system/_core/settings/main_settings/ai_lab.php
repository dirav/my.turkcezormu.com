<?php

use MasterStudy\Lms\Plugin\Addons;

function stm_lms_settings_ai_lab_section() {
	$is_ai_enabled      = is_ms_lms_addon_enabled( Addons::AI_LAB );
	$is_pro_plus        = STM_LMS_Helpers::is_pro_plus();
	$ai_settings_fields = array(
		'name'   => esc_html__( 'AI Lab', 'masterstudy-lms-learning-management-system' ),
		'label'  => esc_html__( 'AI Lab Settings', 'masterstudy-lms-learning-management-system' ),
		'icon'   => 'fas fa-wand-magic-sparkles',
		'fields' => array(
			'openai_api_key'           => array(
				'type'        => 'text',
				'label'       => esc_html__( 'Insert OpenAI API Key', 'masterstudy-lms-learning-management-system' ),
				'description' => sprintf(
					// Translators: %1$s: Open Link for account api key, %2$s: Close Link for account api key
					esc_html__( 'You can obtain your API key from your %1$sOpenAI Account%2$s.', 'masterstudy-lms-learning-management-system' ),
					'<a href="https://platform.openai.com/api-keys/" target="_blank" rel="nofollow">',
					'</a>'
				),
				'placeholder' => 'Enter your OpenAI API key (starts with sk-...)',
			),
			'openai_text_suggestions'  => array(
				'type'        => 'select',
				'label'       => esc_html__( 'Number of Text Suggestions', 'masterstudy-lms-learning-management-system' ),
				'description' => esc_html__( 'How many variations of text AI should generate.', 'masterstudy-lms-learning-management-system' ),
				'options'     => array(
					1  => 1,
					2  => 2,
					3  => 3,
					4  => 4,
					5  => 5,
					6  => 6,
					7  => 7,
					8  => 8,
					9  => 9,
					10 => 10,
				),
				'value'       => 3,
			),
			'openai_image_suggestions' => array(
				'type'        => 'select',
				'label'       => esc_html__( 'Number of Image Suggestions', 'masterstudy-lms-learning-management-system' ),
				'description' => esc_html__( 'Choose how many images you want to generate. If you select 1, the image will be created with the DALL·E 3 model for higher quality.', 'masterstudy-lms-learning-management-system' ),
				'options'     => array(
					1  => 1,
					2  => 2,
					3  => 3,
					4  => 4,
					5  => 5,
					6  => 6,
					7  => 7,
					8  => 8,
					9  => 9,
					10 => 10,
				),
				'value'       => 1,
			),
			'instructor_access'        => array(
				'type'  => 'instructor-access',
				'value' => $is_ai_enabled,
			),
			'openai_usage'             => array(
				'type'  => 'ai-usage',
				'value' => $is_ai_enabled,
			),
		),
	);

	if ( ! $is_pro_plus || ! $is_ai_enabled ) {
		$ai_settings_fields = array(
			'name'   => esc_html__( 'AI Lab', 'masterstudy-lms-learning-management-system' ),
			'label'  => esc_html__( 'AI Lab Settings', 'masterstudy-lms-learning-management-system' ),
			'icon'   => 'fas fa-wand-magic-sparkles',
			'fields' => array(
				'pro_banner_ai_lab' => array(
					'type'        => 'pro_banner',
					'label'       => esc_html__( 'AI Lab', 'masterstudy-lms-learning-management-system' ),
					'img'         => STM_LMS_URL . 'assets/img/pro-features/addons/ai-lab.png',
					'desc'        => esc_html__( 'Generate your entire course in a click! AI instantly creates lessons, quizzes, and assignments based on your description—ready for you to edit and customize.', 'masterstudy-lms-learning-management-system' ),
					'hint'        => esc_html__( 'Unlock', 'masterstudy-lms-learning-management-system' ),
					'is_enable'   => $is_pro_plus && ! $is_ai_enabled,
					'is_pro_plus' => true,
					'search'      => esc_html__( 'AI Lab', 'masterstudy-lms-learning-management-system' ),
					'utm_url'     => 'https://stylemixthemes.com/wordpress-lms-plugin/pricing/?utm_source=mswpadmin&utm_medium=ai_lab&utm_campaign=masterstudy-plugin',
				),
			),
		);
	}

	return $ai_settings_fields;
}
