<?php

namespace MasterStudy\Lms\Pro\AddonsPlus\AiLab\Http\Controllers\CourseBuilder;

use MasterStudy\Lms\Pro\AddonsPlus\AiLab\Http\Controllers\Controller;
use MasterStudy\Lms\Http\WpResponseFactory;
use MasterStudy\Lms\Pro\AddonsPlus\AiLab\Services\OpenAi\Model;
use MasterStudy\Lms\Pro\AddonsPlus\AiLab\Services\OpenAi\Queries\QueryFactory;
use MasterStudy\Lms\Validation\Validator;

class GenerateImageController extends Controller {
	public function __invoke( \WP_REST_Request $request ) {
		$validator = new Validator(
			$request->get_params(),
			array(
				'prompt' => 'required|string',
				'style'  => 'required|string',
				'count'  => 'nullable|integer|min,1|max,10',
			)
		);

		if ( $validator->fails() ) {
			return WpResponseFactory::validation_failed( $validator->get_errors_array() );
		}

		$validated_data = $validator->get_validated();
		$prompt         = 'None' === $validated_data['style']
			? $validated_data['prompt']
			: sprintf(
				$this->options->get( 'generator.image.prompt', '%s %s' ),
				$validated_data['prompt'],
				$validated_data['style']
			);

		try {
			$max_results = ! empty( $validated_data['count'] )
				? $validated_data['count']
				: $this->options->get( 'results.image' );
			$model       = ( 1 === intval( $max_results ) )
				? Model::DALL_E_3
				: Model::DALL_E;
			$size        = Model::DALL_E_3 === $model
				? $this->options->get( 'generator.image.size' )
				: '1024x1024';

			$response = $this->ai->exec(
				QueryFactory::image(
					$prompt,
					array(
						'max_results' => $max_results,
						'model'       => $model,
						'size'        => $size,
					)
				)
			);

			return new \WP_REST_Response(
				$response->results
			);
		} catch ( \Exception $e ) {
			return WpResponseFactory::error( $e->getMessage() );
		}
	}
}
