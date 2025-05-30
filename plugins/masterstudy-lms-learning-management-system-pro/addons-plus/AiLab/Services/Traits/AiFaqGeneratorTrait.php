<?php

namespace MasterStudy\Lms\Pro\AddonsPlus\AiLab\Services\Traits;

use MasterStudy\Lms\Pro\AddonsPlus\AiLab\Services\OpenAi\Queries\QueryFactory;

trait AiFaqGeneratorTrait {
	private string $prompt;
	private int $words_limit;
	private int $count;
	private string $tone;

	public function generate_faq( string $prompt, array $params = array() ): array {
		$this->prompt      = $prompt;
		$this->words_limit = $params['words_limit'];
		$this->count       = $params['count'];
		$this->tone        = $params['tone'];

		try {
			$response = $this->exec(
				QueryFactory::text(
					array(
						array(
							'role'    => 'system',
							'content' => "Generate {$this->count} frequently asked questions and answers about: {$this->prompt}. Make answers clear and concise.",
						),
						array(
							'role'    => 'user',
							'content' => "Generate {$this->count} frequently asked question and answer (Words limit: {$this->words_limit}) about: {$this->prompt}"
							. "Words limit for each answer: {$this->words_limit}. Generate in language of prompt.\n"
							. "Return a JSON array where each item has keys 'question' and 'answer'. Example response:\n"
							. "[\n"
							. "  {\n"
							. "    'question': 'What is the course about?', \n"
							. "    'answer': 'This course is about ...' \n"
							. "  },\n"
							. "  ...\n"
							. ']',
						),
					),
					array(
						'max_results' => 1,
						'max_tokens'  => $this->options->get( 'generator.content.tokens' ),
					)
				)
			);

			return json_decode( $response->results[0]['message']['content'] ?? '[]', true ) ?? array();
		} catch ( \Exception $e ) {
			throw new \Exception( $e->getMessage() );
		}
	}
}
