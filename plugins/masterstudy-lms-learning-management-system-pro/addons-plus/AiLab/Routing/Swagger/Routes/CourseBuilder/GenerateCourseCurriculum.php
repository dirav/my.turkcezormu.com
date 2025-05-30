<?php

namespace MasterStudy\Lms\Pro\AddonsPlus\AiLab\Routing\Swagger\Routes\CourseBuilder;

use MasterStudy\Lms\Routing\Swagger\RequestInterface;
use MasterStudy\Lms\Routing\Swagger\ResponseInterface;
use MasterStudy\Lms\Routing\Swagger\Route;

class GenerateCourseCurriculum extends Route implements RequestInterface, ResponseInterface {
	public function request(): array {
		return array(
			'prompt' => array(
				'type'        => 'string',
				'description' => 'Prompt message for course generation.',
			),
		);
	}

	public function response(): array {
		return array(
			'data' => array(
				'type'        => 'array',
				'description' => 'Course curriculum.',
				'properties'  => array(
					'title'     => array(
						'type'        => 'string',
						'description' => 'Section title.',
					),
					'materials' => array(
						'type'        => 'array',
						'description' => 'Materials.',
						'properties'  => array(
							'title'       => array(
								'type'        => 'string',
								'description' => 'Material title.',
							),
							'post_type'   => array(
								'type'        => 'string',
								'description' => 'Material post type.',
							),
							'lesson_type' => array(
								'type'        => 'string',
								'description' => 'Material lesson type.',
							),
						),
					),
				),
			),
		);
	}

	public function get_summary(): string {
		return 'Generate a course curriculum.';
	}

	public function get_description(): string {
		return 'Generate Course Curriculum.';
	}
}
