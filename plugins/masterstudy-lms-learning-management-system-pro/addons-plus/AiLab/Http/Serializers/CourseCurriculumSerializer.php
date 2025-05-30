<?php

namespace MasterStudy\Lms\Pro\AddonsPlus\AiLab\Http\Serializers;

use MasterStudy\Lms\Enums\LessonType;
use MasterStudy\Lms\Http\Serializers\AbstractSerializer;
use MasterStudy\Lms\Plugin\PostType;

final class CourseCurriculumSerializer extends AbstractSerializer {
	public function toArray( $data ): array {
		$section = ! empty( $data['section'] ) ? $data['section'] : $data;

		return array(
			'title'     => $section['title'] ?? 'Section',
			'materials' => array_map(
				function( $material ) {
					return array(
						'title'       => $material['title'] ?? '',
						'post_type'   => $material['post_type'] ?? PostType::LESSON,
						'lesson_type' => $material['lesson_type'] ?? LessonType::TEXT,
					);
				},
				$section['materials'] ?? array()
			),
		);
	}
}
