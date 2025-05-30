<?php

namespace MasterStudy\Lms\Pro\AddonsPlus\AiLab\Http\Serializers;

use MasterStudy\Lms\Http\Serializers\AbstractSerializer;
use MasterStudy\Lms\Http\Serializers\CourseCategorySerializer;

final class CourseSerializer extends AbstractSerializer {
	public function toArray( $data ): array {
		$course = array(
			'title'      => $data['title'],
			'excerpt'    => $data['excerpt'] ?? '',
			'content'    => $data['content'] ?? '',
			'image'      => $data['image'],
			'categories' => ( new CourseCategorySerializer() )->collectionToArray( $data['categories'] ),
			'faq'        => $data['faq'],
		);

		if ( isset( $data['basic_info'] ) ) {
			$course['basic_info'] = $data['basic_info'];
		}

		if ( isset( $data['requirements'] ) ) {
			$course['requirements'] = $data['requirements'];
		}

		if ( isset( $data['intended_audience'] ) ) {
			$course['intended_audience'] = $data['intended_audience'];
		}

		return $course;
	}
}
