<?php

namespace MasterStudy\Lms\Pro\AddonsPlus\AiLab\Services\Traits;

use MasterStudy\Lms\Pro\AddonsPlus\AiLab\Services\OpenAi\Queries\QueryFactory;

trait AiLessonGeneratorTrait {
	private string $prompt;
	private int $words_limit;
	private string $tone;
	private int $images_limit;
	private string $title;

	public function generate_lesson( string $prompt, array $params = array() ): array {
		$this->prompt       = $prompt;
		$this->words_limit  = $params['words_limit'];
		$this->tone         = $params['tone'];
		$this->images_limit = $params['images_limit'];

		try {
			$this->title = $this->generate_lesson_title();
			$content     = $this->generate_lesson_content();

			return array(
				'title'         => $this->title,
				'description'   => $this->generate_lesson_description(),
				'content'       => $this->replace_image_placeholders( $content['content'] ),
				'image_prompts' => $content['image_prompts'] ?? array(),
			);
		} catch ( \Exception $e ) {
			throw new \Exception( $e->getMessage() );
		}
	}

	private function generate_lesson_title(): string {
		$response = $this->exec(
			QueryFactory::text(
				array(
					array(
						'role'    => 'system',
						'content' => "You are an educational content creator. Create a clear, engaging, and concise title for a lesson. Please ignore all previous conversation history.\n"
									. 'Respond with just the title, no additional text or formatting. Generate title in language of the prompt.',
					),
					array(
						'role'    => 'user',
						'content' => "Create a title for a lesson about: {$this->prompt}\n"
									. 'Note: Generate title in language of the prompt.',
					),
				),
				array(
					'max_results' => 1,
					'max_tokens'  => $this->options->get( 'generator.title.tokens' ),
				)
			)
		);

		return trim( $response->results[0]['message']['content'] ?? '', '"' );
	}

	private function generate_lesson_description(): string {
		$response = $this->exec(
			QueryFactory::text(
				array(
					array(
						'role'    => 'system',
						'content' => 'Create a concise 2-3 sentence description that outlines the main learning objectives of this lesson. The description should be engaging and informative.',
					),
					array(
						'role'    => 'user',
						'content' => "Create a description for a lesson with the following details:\n" .
									"Title: {$this->title}\n" .
									"Topic: {$this->prompt}\n" .
									'Note: The description should explain what students will learn. Generate description in language of the prompt.',
					),
				),
				array(
					'max_results' => 1,
					'max_tokens'  => $this->options->get( 'generator.text.tokens' ),
				)
			)
		);

		return trim( $response->results[0]['message']['content'] ?? '' );
	}

	private function generate_lesson_content(): array {
		$response = $this->exec(
			QueryFactory::text(
				array(
					array(
						'role'    => 'system',
						'content' => "You are an educational content creator. Create the main content for a lesson.\n" .
									"Respond with TinyMCE Editor format without comments. Use [image][/image] wrapping detailed description of image to insert images.\n" .
									"Image example: [image]A diagram showing the REST API structure[/image]\n" .
									"Create engaging, educational content that fulfills the description's promises.",
					),
					array(
						'role'    => 'user',
						'content' => "Create the main content for a lesson with these details:\n" .
									"Title: {$this->title}\n" .
									"Prompt: {$this->prompt}\n\n" .
									"Approximate words count: {$this->words_limit}\n" .
									"Images count: {$this->images_limit}\n" .
									"Tone: {$this->tone}\n" .
									'Note: Do not add Title at the beginning of the content. Generate content in language of the prompt. ' .
									"Create engaging, educational content that fulfills the description's promises.",
					),
				),
				array(
					'max_results' => 1,
					'max_tokens'  => $this->options->get( 'generator.content.tokens' ),
				)
			)
		);

		return $this->parse_content_response( $response->results[0]['message']['content'] ?? '' );
	}
}
