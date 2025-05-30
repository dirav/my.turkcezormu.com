<?php

namespace MasterStudy\Lms\Pro\AddonsPlus\AiLab\Routing\Swagger\Routes\CourseBuilder;

use MasterStudy\Lms\Routing\Swagger\RequestInterface;
use MasterStudy\Lms\Routing\Swagger\ResponseInterface;
use MasterStudy\Lms\Routing\Swagger\Route;

class GenerateImage extends Route implements RequestInterface, ResponseInterface {
	public function request(): array {
		return array(
			'prompt' => array(
				'type'        => 'string',
				'description' => 'Prompt message for image generation.',
			),
			'style'  => array(
				'type'        => 'string',
				'description' => 'Style of the image.',
			),
			'count'  => array(
				'type'        => 'integer',
				'description' => 'Optional. Number of images to generate. Default is from settings.',
			),
		);
	}

	public function response(): array {
		return array(
			'data' => array(
				'type'        => 'array',
				'description' => 'List of image URLs.',
			),
		);
	}

	public function get_summary(): string {
		return 'Generate image';
	}

	public function get_description(): string {
		return 'Generate image via OpenAI API';
	}
}
