<?php

namespace MasterStudy\Lms\Pro\AddonsPlus\AiLab\Services\Traits;

use MasterStudy\Lms\Enums\LessonType;
use MasterStudy\Lms\Plugin\Taxonomy;
use MasterStudy\Lms\Pro\AddonsPlus\AiLab\Services\OpenAi\Queries\QueryFactory;
use STM_LMS_Options;

trait AiCourseGenerator {
	private string $prompt;
	private string $title;
	private string $language;

	public function generate_course( string $prompt ): array {
		try {
			$this->prompt   = $prompt;
			$this->language = $this->detect_language_of_prompt();
			$this->title    = $this->generate_course_title();

			$course               = $this->generate_course_details();
			$course['title']      = $this->title;
			$course['categories'] = $this->select_course_categories();
			$course['image']      = $this->generate_course_image();
			$course['faq']        = $this->generate_faq(
				$this->title,
				array(
					'count'       => 5,
					'words_limit' => 100,
					'tone'        => $this->options->get( 'generator.content.tones.Formal' ),
				)
			);

			return $course;
		} catch ( \Exception $e ) {
			throw new \Exception( $e->getMessage() );
		}
	}

	public function detect_language_of_prompt(): string {
		try {
			$response = $this->exec(
				QueryFactory::text(
					array(
						array(
							'role'    => 'system',
							'content' => 'You are a language detection assistant. '
										. 'Given a piece of text, respond with only the two-letter ISO 639-1 language code (e.g. "en", "fr", "es").',
						),
						array(
							'role'    => 'user',
							'content' => "Detect the language of this text: {$this->prompt}",
						),
					),
					array(
						'max_results' => 1,
						'max_tokens'  => $this->options->get( 'generator.title.tokens' ),
					)
				)
			);

			return $response->results[0]['message']['content'] ?? 'en';
		} catch ( \Exception $e ) {
			throw new \Exception( $e->getMessage() );
		}
	}

	public function generate_course_title(): string {
		try {
			$response = $this->exec(
				QueryFactory::text(
					array(
						array(
							'role'    => 'system',
							'content' => 'You are a LMS course builder. Respond with just the title, no additional text or formatting. Please ignore all previous conversation history.',
						),
						array(
							'role'    => 'user',
							'content' => "Generate a Course Title for the prompt: {$this->prompt}\n"
										. "Words limit: 10. Language: {$this->language}. Create clear Title without marking 'Title:', etc.",
						),
					),
					array(
						'max_results' => 1,
						'max_tokens'  => $this->options->get( 'generator.title.tokens' ),
					)
				)
			);

			return trim( $response->results[0]['message']['content'] ?? '', '"' );
		} catch ( \Exception $e ) {
			throw new \Exception( $e->getMessage() );
		}
	}

	public function generate_course_details(): array {
		try {
			$user_message = "Generate a course details in language {$this->language} for the course: {$this->title}. "
						. "Return a JSON object (without marking ```json) where each object has keys:\n"
						. "– excerpt: string (Small description, max 100 words)\n"
						. "– content: string (Full description, max 500 words)\n";

			if ( STM_LMS_Options::get_option( 'course_allow_basic_info' ) ) {
				$user_message .= "– basic_info: array (Basic info, 3-5 items)\n";
			}

			if ( STM_LMS_Options::get_option( 'course_allow_requirements_info' ) ) {
				$user_message .= "– requirements: array (Course requirements, 3-5 items)\n";
			}

			if ( STM_LMS_Options::get_option( 'course_allow_intended_audience' ) ) {
				$user_message .= "– intended_audience: array (Intended audience, 3-5 items)\n";
			}

			$response = $this->exec(
				QueryFactory::text(
					array(
						array(
							'role'    => 'system',
							'content' => "You are a LMS course builder. Generate a course details for the course: {$this->title}",
						),
						array(
							'role'    => 'user',
							'content' => $user_message,
						),
					),
					array(
						'max_results' => 1,
						'max_tokens'  => $this->options->get( 'generator.content.tokens' ),
					)
				)
			);

			$json = $response->results[0]['message']['content'] ?? '[]';

			return json_decode( $json, true ) ?? array();
		} catch ( \Exception $e ) {
			throw new \Exception( $e->getMessage() );
		}
	}

	public function select_course_categories(): array {
		$categories = Taxonomy::all_categories();

		try {
			$user_message = "Select 1-3 most suitable course categories for the prompt: {$this->prompt}. "
						. 'Return a JSON array of category IDs (without marking ```json). '
						. "Available categories:\n";

			foreach ( $categories as $category ) {
				$user_message .= "- {$category->name} (ID: {$category->term_id})\n";
			}

			$response = $this->exec(
				QueryFactory::text(
					array(
						array(
							'role'    => 'system',
							'content' => "You are a LMS course builder. Select suitable categories for the prompt: {$this->prompt}",
						),
						array(
							'role'    => 'user',
							'content' => $user_message,
						),
					),
					array(
						'max_results' => 1,
						'max_tokens'  => $this->options->get( 'generator.content.tokens' ),
					)
				)
			);

			$json         = $response->results[0]['message']['content'] ?? '[]';
			$selected_ids = array_map( 'intval', json_decode( $json, true ) ?? array() );

			$selected_categories = array_values(
				array_filter(
					$categories,
					function ( $category ) use ( $selected_ids ) {
						return in_array( $category->term_id, $selected_ids, true );
					}
				)
			);

			return $selected_categories;
		} catch ( \Exception $e ) {
			throw new \Exception( $e->getMessage() );
		}
	}

	public function generate_course_curriculum( string $prompt ): array {
		try {
			$lesson_types = apply_filters( 'masterstudy_lms_lesson_types', array_map( 'strval', LessonType::cases() ) );

			// Unset Zoom Conference
			$lesson_types = array_diff( $lesson_types, array( 'zoom_conference' ) );

			$response = $this->exec(
				QueryFactory::text(
					array(
						array(
							'role'    => 'system',
							'content' => "You are a LMS course builder. Generate a course curriculum for the prompt: {$prompt}",
						),
						array(
							'role'    => 'user',
							'content' => "Generate a course curriculum for the prompt: {$prompt}. About 3-4 sections, each section has 3-5 materials. "
										. 'Generate Curriculum in language of the prompt. '
										. "Return a JSON array (Array of sections, without marking ```json) where each object has keys:\n"
										. "– section: object (Each section has keys title, materials):\n"
										. "– title: string\n"
										. "– materials: array (Array of materials, each material has keys title, post_type, lesson_type):\n"
										. "– title: string\n"
										. "– post_type: string (stm-lessons, stm-quizzes, stm-assignments.)\n"
										. '– lesson_type: string. Only for post_type "stm-lessons" (' . implode( ', ', $lesson_types ) . ')',
						),
					),
					array(
						'max_results' => 1,
						'max_tokens'  => $this->options->get( 'generator.content.tokens' ),
					)
				)
			);

			$json = $response->results[0]['message']['content'] ?? '[]';

			return json_decode( $json, true );
		} catch ( \Exception $e ) {
			throw new \Exception( $e->getMessage() );
		}
	}

	public function generate_course_image(): string {
		try {
			$response = $this->exec(
				QueryFactory::image(
					$this->prompt,
					array(
						'max_results' => 1,
						'size'        => $this->options->get( 'generator.image.size' ),
					)
				)
			);

			return $response->results[0];
		} catch ( \Exception $e ) {
			throw new \Exception( $e->getMessage() );
		}
	}
}
