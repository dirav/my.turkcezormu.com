<?php
/** @var Router $router */

use MasterStudy\Lms\Routing\Router;

// OpenAI Routes
$router->group(
	array(
		'middleware' => array(
			\MasterStudy\Lms\Routing\Middleware\Authentication::class,
			\MasterStudy\Lms\Pro\AddonsPlus\AiLab\Routing\Middleware\HasAiAccess::class,
		),
		'prefix'     => '/ai',
	),
	function ( Router $router ) {
		$router->post(
			'/generate/text',
			\MasterStudy\Lms\Pro\AddonsPlus\AiLab\Http\Controllers\CourseBuilder\GenerateTextController::class,
			\MasterStudy\Lms\Pro\AddonsPlus\AiLab\Routing\Swagger\Routes\CourseBuilder\GenerateText::class,
		);
		$router->post(
			'/generate/image',
			\MasterStudy\Lms\Pro\AddonsPlus\AiLab\Http\Controllers\CourseBuilder\GenerateImageController::class,
			\MasterStudy\Lms\Pro\AddonsPlus\AiLab\Routing\Swagger\Routes\CourseBuilder\GenerateImage::class,
		);
		$router->post(
			'/upload-image',
			\MasterStudy\Lms\Pro\AddonsPlus\AiLab\Http\Controllers\CourseBuilder\UploadImageController::class,
			\MasterStudy\Lms\Pro\AddonsPlus\AiLab\Routing\Swagger\Routes\CourseBuilder\UploadImage::class,
		);
		$router->post(
			'/generate/lesson',
			\MasterStudy\Lms\Pro\AddonsPlus\AiLab\Http\Controllers\CourseBuilder\GenerateLessonController::class,
			\MasterStudy\Lms\Pro\AddonsPlus\AiLab\Routing\Swagger\Routes\CourseBuilder\GenerateLesson::class,
		);
		$router->post(
			'/generate/assignment',
			\MasterStudy\Lms\Pro\AddonsPlus\AiLab\Http\Controllers\CourseBuilder\GenerateAssignmentController::class,
			\MasterStudy\Lms\Pro\AddonsPlus\AiLab\Routing\Swagger\Routes\CourseBuilder\GenerateAssignment::class,
		);
		$router->post(
			'/generate/questions',
			\MasterStudy\Lms\Pro\AddonsPlus\AiLab\Http\Controllers\CourseBuilder\GenerateQuestionsController::class,
			\MasterStudy\Lms\Pro\AddonsPlus\AiLab\Routing\Swagger\Routes\CourseBuilder\GenerateQuestions::class,
		);
		$router->post(
			'/generate/faq',
			\MasterStudy\Lms\Pro\AddonsPlus\AiLab\Http\Controllers\CourseBuilder\GenerateFaqController::class,
			\MasterStudy\Lms\Pro\AddonsPlus\AiLab\Routing\Swagger\Routes\CourseBuilder\GenerateFaq::class,
		);
		$router->post(
			'/generate/course',
			\MasterStudy\Lms\Pro\AddonsPlus\AiLab\Http\Controllers\CourseBuilder\GenerateCourseController::class,
			\MasterStudy\Lms\Pro\AddonsPlus\AiLab\Routing\Swagger\Routes\CourseBuilder\GenerateCourse::class,
		);
		$router->post(
			'/generate/course-curriculum',
			\MasterStudy\Lms\Pro\AddonsPlus\AiLab\Http\Controllers\CourseBuilder\GenerateCourseCurriculumController::class,
			\MasterStudy\Lms\Pro\AddonsPlus\AiLab\Routing\Swagger\Routes\CourseBuilder\GenerateCourseCurriculum::class,
		);
		$router->post(
			'/course',
			\MasterStudy\Lms\Pro\AddonsPlus\AiLab\Http\Controllers\CourseBuilder\CreateCourseController::class,
			\MasterStudy\Lms\Pro\AddonsPlus\AiLab\Routing\Swagger\Routes\CourseBuilder\CreateCourse::class,
		);
	}
);
