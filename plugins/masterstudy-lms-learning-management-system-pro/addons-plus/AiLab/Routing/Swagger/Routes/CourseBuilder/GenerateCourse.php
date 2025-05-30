<?php

namespace MasterStudy\Lms\Pro\AddonsPlus\AiLab\Routing\Swagger\Routes\CourseBuilder;

use MasterStudy\Lms\Routing\Swagger\Fields\Category;
use MasterStudy\Lms\Routing\Swagger\RequestInterface;
use MasterStudy\Lms\Routing\Swagger\ResponseInterface;
use MasterStudy\Lms\Routing\Swagger\Route;

class GenerateCourse extends Route implements RequestInterface, ResponseInterface {
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
				'type'        => 'object',
				'description' => 'Course object.',
				'properties'  => array(
					'title'             => array(
						'type'        => 'string',
						'description' => 'Course title.',
					),
					'excerpt'           => array(
						'type'        => 'string',
						'description' => 'Course excerpt.',
					),
					'content'           => array(
						'type'        => 'string',
						'description' => 'Course content.',
					),
					'image'             => array(
						'type'        => 'string',
						'description' => 'Course image.',
					),
					'basic_info'        => array(
						'type'        => 'string',
						'description' => 'Basic info. Optional.',
					),
					'requirements'      => array(
						'type'        => 'string',
						'description' => 'Requirements. Optional.',
					),
					'intended_audience' => array(
						'type'        => 'string',
						'description' => 'Intended audience. Optional.',
					),
					'categories'        => Category::as_array(),
					'faq'               => array(
						'type'        => 'array',
						'description' => 'FAQ.',
						'properties'  => array(
							'question' => array(
								'type'        => 'string',
								'description' => 'Question.',
							),
							'answer'   => array(
								'type'        => 'string',
								'description' => 'Answer.',
							),
						),
					),
				),
			),
		);
	}

	public function get_summary(): string {
		return 'Generate a course.';
	}

	public function get_description(): string {
		return 'Generate Course Details, FAQ, and Course Image.';
	}
}
