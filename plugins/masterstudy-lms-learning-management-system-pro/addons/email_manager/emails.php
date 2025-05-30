<?php

$email_templates = array(
	'stm_lms_course_added'                          => array(
		'section' => 'instructors',
		'notice'  => esc_html__( 'Send an email to the admin when the instructor has added their course', 'masterstudy-lms-learning-management-system-pro' ),
		'subject' => esc_html__( 'Course added', 'masterstudy-lms-learning-management-system-pro' ),
		'message' => esc_html__( 'Course {{course_title}} {{action}} by instructor, your ({{user_login}}). Please review this information from the admin Dashboard', 'masterstudy-lms-learning-management-system-pro' ),
		'vars'    => array(
			'action'       => esc_html__( 'Added or updated action made by instructor', 'masterstudy-lms-learning-management-system-pro' ),
			'user_login'   => esc_html__( 'Instructor login', 'masterstudy-lms-learning-management-system-pro' ),
			'course_title' => esc_html__( 'Course name', 'masterstudy-lms-learning-management-system-pro' ),
		),
	),
	'stm_lms_course_published'                      => array(
		'section' => 'instructors',
		'notice'  => esc_html__(
			'Send an email to the instructor when the course is published',
			'masterstudy-lms-learning-management-system-pro'
		),
		'subject' => esc_html__(
			'Course published',
			'masterstudy-lms-learning-management-system-pro'
		),
		'message' => esc_html__(
			'Your course - {{course_title}} was approved, and is now live on the website',
			'masterstudy-lms-learning-management-system-pro'
		),
		'vars'    => array(
			'course_title' => esc_html__(
				'Course Title',
				'masterstudy-lms-learning-management-system-pro'
			),
		),
	),
	'stm_lms_become_instructor_email'               => array(
		'section' => 'instructors',
		'notice'  => esc_html__(
			'Become an instructor',
			'masterstudy-lms-learning-management-system-pro'
		),
		'subject' => esc_html__(
			'New Instructor Application',
			'masterstudy-lms-learning-management-system-pro'
		),
		'message' => esc_html__( 'You have received a new instructor application from ', 'masterstudy-lms-learning-management-system-pro' ) . ' {{user_login}}, <br/>' . // phpcs:disable
			esc_html__( 'Here are the details:', 'masterstudy-lms-learning-management-system-pro' ) . ' <br/>' .
			'<b>' . esc_html__( 'Name: ', 'masterstudy-lms-learning-management-system-pro' ) . '</b>' . ' {{user_login}} <br>' .
			'<b>' . esc_html__( 'ID: ', 'masterstudy-lms-learning-management-system-pro' ) . '</b>' . ' {{user_id}} <br>' .
			'<b>' . esc_html__( 'Email: ', 'masterstudy-lms-learning-management-system-pro' ) . '</b>' . ' {{user_email}} <br>' .
			'<b>' . esc_html__( 'Degree: ', 'masterstudy-lms-learning-management-system-pro' ) . '</b>' . ' {{degree}} <br>' .
			'<b>' . esc_html__( 'Expertize: ', 'masterstudy-lms-learning-management-system-pro' ) . '</b>' . ' {{expertize}} <br>' .
			'<b>' . esc_html__( 'Application Date: ', 'masterstudy-lms-learning-management-system-pro' ) . '</b>' . ' {{date}} <br><br>' .
			esc_html__( 'Please review the application at your earliest convenience.', 'masterstudy-lms-learning-management-system-pro' ) . '</a> <br/><br/>', // phpcs:enable
		'vars'    => array(
			'user_login' => esc_html__(
				'User login',
				'masterstudy-lms-learning-management-system-pro'
			),
			'user_id'    => esc_html__(
				'User ID',
				'masterstudy-lms-learning-management-system-pro'
			),
			'user_email' => esc_html__(
				'User email',
				'masterstudy-lms-learning-management-system-pro'
			),
			'date'       => esc_html__(
				'Application date',
				'masterstudy-lms-learning-management-system-pro'
			),
			'degree'     => esc_html__(
				'Degree',
				'masterstudy-lms-learning-management-system-pro'
			),
			'expertize'  => esc_html__(
				'Expertize',
				'masterstudy-lms-learning-management-system-pro'
			),
		),
	),
	'stm_lms_lesson_comment'                        => array(
		'section' => 'lessons',
		'notice'  => esc_html__(
			'Q&A Message (email to instructors)',
			'masterstudy-lms-learning-management-system-pro'
		),
		'subject' => esc_html__(
			'New lesson comment',
			'masterstudy-lms-learning-management-system-pro'
		),
		'message' => '{{user_login}} commented - "{{comment_content}}" on lesson {{lesson_title}} in the course {{course_title}}',
		'vars'    => array(
			'user_login'      => esc_html__(
				'User login',
				'masterstudy-lms-learning-management-system-pro'
			),
			'comment_content' => esc_html__(
				'Comment content',
				'masterstudy-lms-learning-management-system-pro'
			),
			'lesson_title'    => esc_html__(
				'Lesson title',
				'masterstudy-lms-learning-management-system-pro'
			),
			'course_title'    => esc_html__(
				'Course title',
				'masterstudy-lms-learning-management-system-pro'
			),
		),
	),
	'stm_lms_lesson_qeustion_ask_answer'            => array(
		'section' => 'lessons',
		'notice'  => esc_html__(
			'Q&A Message Answered (email to students)',
			'masterstudy-lms-learning-management-system-pro'
		),
		'subject' => esc_html__(
			'You have received a reply to your question.',
			'masterstudy-lms-learning-management-system-pro'
		),
		'message' => '{{user_login}} has replied - "{{comment_content}}" to your question on the lesson {{lesson_title}} in the {{course_title}}',
		'vars'    => array(
			'user_login'      => esc_html__(
				'User login',
				'masterstudy-lms-learning-management-system-pro'
			),
			'comment_content' => esc_html__(
				'Comment content',
				'masterstudy-lms-learning-management-system-pro'
			),
			'lesson_title'    => esc_html__(
				'Lesson title',
				'masterstudy-lms-learning-management-system-pro'
			),
			'course_title'    => esc_html__(
				'Course title',
				'masterstudy-lms-learning-management-system-pro'
			),
		),
	),
	'stm_lms_account_premoderation'                 => array(
		'section' => 'account',
		'notice'  => esc_html__(
			'Account Premoderation',
			'masterstudy-lms-learning-management-system-pro'
		),
		'subject' => esc_html__(
			'Activate your account',
			'masterstudy-lms-learning-management-system-pro'
		),
		'message' => esc_html__( 'Hi', 'masterstudy-lms-learning-management-system-pro' ) . ' {{user_login}},<br/>' .
			esc_html__( 'Welcome to', 'masterstudy-lms-learning-management-system-pro' ) . ' {{blog_name}}! ' .
			esc_html__( 'To start using your account, please activate it by clicking the link below:', 'masterstudy-lms-learning-management-system-pro' ) . '<br/>' .
			esc_html__( 'Activation Link:', 'masterstudy-lms-learning-management-system-pro' ) . ' <a href="{{reset_url}}">' .
			esc_html__( 'Activate here', 'masterstudy-lms-learning-management-system-pro' ) . '</a> <br/><br/>' .
			esc_html__( 'We look forward to seeing you on', 'masterstudy-lms-learning-management-system-pro' ) . ' {{blog_name}}!',
		'vars'    => array(
			'blog_name'  => esc_html__(
				'Blog name',
				'masterstudy-lms-learning-management-system-pro'
			),
			'reset_url'  => esc_html__(
				'Reset URL',
				'masterstudy-lms-learning-management-system-pro'
			),
			'user_login' => esc_html__(
				'User login',
				'masterstudy-lms-learning-management-system-pro'
			),
		),
	),
	'stm_lms_user_registered_on_site'               => array(
		'section' => 'account',
		'notice'  => esc_html__(
			'Register on the website',
			'masterstudy-lms-learning-management-system-pro'
		),
		'subject' => esc_html__(
			'You have successfully registered on the website.',
			'masterstudy-lms-learning-management-system-pro'
		),
		'message' => 'Hi {{user_login}},<br> Welcome to {{blog_name}}! Your registration was successful.<br> You can now log in to your account using the following link: <br>Login URL: <a href="{{login_url}}">Login url</a> <br><br>We are thrilled to have you on board!',
		'vars'    => array(
			'blog_name'  => esc_html__(
				'Blog name',
				'masterstudy-lms-learning-management-system-pro'
			),
			'user_login' => esc_html__(
				'User login',
				'masterstudy-lms-learning-management-system-pro'
			),
			'login_url'  => esc_html__(
				'Login URL',
				'masterstudy-lms-learning-management-system-pro'
			),
		),
	),
	'stm_lms_user_added_via_manage_students'        => array(
		'section' => 'account',
		'notice'  => esc_html__(
			'Users added via Manage Students',
			'masterstudy-lms-learning-management-system-pro'
		),
		'subject' => esc_html__(
			'You have been registered on the website.',
			'masterstudy-lms-learning-management-system-pro'
		),
		'message' => 'Login: {{username}} Password {{password}} Site URL: {{site_url}}. ',
		'vars'    => array(
			'username' => esc_html__(
				'Username',
				'masterstudy-lms-learning-management-system-pro'
			),
			'password' => esc_html__(
				'Password',
				'masterstudy-lms-learning-management-system-pro'
			),
			'site_url' => esc_html__(
				'Site URL',
				'masterstudy-lms-learning-management-system-pro'
			),
		),
	),
	'stm_lms_password_change'                       => array(
		'section' => 'account',
		'notice'  => esc_html__(
			'Password changed',
			'masterstudy-lms-learning-management-system-pro'
		),
		'subject' => esc_html__(
			'Password change',
			'masterstudy-lms-learning-management-system-pro'
		),
		'message' => 'Password changed successfully.',
		'vars'    => array(),
	),
	'stm_lms_enterprise'                            => array(
		'section' => 'enterprise',
		'notice'  => esc_html__(
			'Enterprise Request',
			'masterstudy-lms-learning-management-system-pro'
		),
		'subject' => esc_html__(
			'New Enterprise Inquiry',
			'masterstudy-lms-learning-management-system-pro'
		),
		'message' => esc_html__( 'You have received a new enterprise inquiry from the "For Enterprise" form.', 'masterstudy-lms-learning-management-system-pro' ) . ' <br/>' . // phpcs:disable
			esc_html__( 'Here are the details:', 'masterstudy-lms-learning-management-system-pro' ) . ' <br/>' .
			'<b>' . esc_html__( 'Name: ', 'masterstudy-lms-learning-management-system-pro' ) . '</b>' . ' {{name}} <br>' .
			'<b>' . esc_html__( 'Email: ', 'masterstudy-lms-learning-management-system-pro' ) . '</b>' . ' {{email}} <br>' .
			'<b>' . esc_html__( 'Message: ', 'masterstudy-lms-learning-management-system-pro' ) . '</b>' . ' {{text}} <br>' .
			'<b>' . esc_html__( 'Submission Date: ', 'masterstudy-lms-learning-management-system-pro' ) . '</b>' . ' {{date}} <br><br/>' .
			esc_html__( 'Please review this inquiry and follow up as needed.', 'masterstudy-lms-learning-management-system-pro' ) . '</a> <br/>', // phpcs:enable
		'vars' => array(
			'name'  => esc_html__( 'Name', 'masterstudy-lms-learning-management-system-pro' ),
			'email' => esc_html__(
				'Email',
				'masterstudy-lms-learning-management-system-pro'
			),
			'text'  => esc_html__( 'Text', 'masterstudy-lms-learning-management-system-pro' ),
			'date'  => esc_html__( 'Submission Date', 'masterstudy-lms-learning-management-system-pro' ),
		),
	),
	'stm_lms_new_order'                             => array(
		'section'               => 'order',
		'notice'                => esc_html__(
			'Order message for Admin',
			'masterstudy-lms-learning-management-system-pro'
		),
		'title'                 => esc_html__( 'New order', 'masterstudy-lms-learning-management-system-pro' ),
		'subject'               => esc_html__(
			'New order',
			'masterstudy-lms-learning-management-system-pro'
		),
		'date_order_render'     => esc_html__( 'Date', 'masterstudy-lms-learning-management-system-pro' ),
		'order_order_render'    => esc_html__( 'Order ID', 'masterstudy-lms-learning-management-system-pro' ),
		'title_order_render'    => esc_html__( 'Title', 'masterstudy-lms-learning-management-system-pro' ),
		'items_order_render'    => esc_html__( 'Items list', 'masterstudy-lms-learning-management-system-pro' ),
		'customer_order_render' => esc_html__( 'User section', 'masterstudy-lms-learning-management-system-pro' ),
		'button_order_render'   => esc_html__( 'Button', 'masterstudy-lms-learning-management-system-pro' ),
		'message'               => 'An order has been placed on your site from the user {{user_login}}. Log in to your admin dashboard to view the sale and check your earnings.',
		'vars'                  => array(
			'user_login' => esc_html__(
				'User login',
				'masterstudy-lms-learning-management-system-pro'
			),
			'site_url'   => esc_html__(
				'Site URL',
				'masterstudy-lms-learning-management-system-pro'
			),
		),
	),
	'stm_lms_new_order_instructor'                  => array(
		'section'               => 'order',
		'notice'                => esc_html__(
			'Order message for Instructor',
			'masterstudy-lms-learning-management-system-pro'
		),
		'title'                 => esc_html__( 'You made a Sale!', 'masterstudy-lms-learning-management-system-pro' ),
		'subject'               => esc_html__(
			'You made a Sale!',
			'masterstudy-lms-learning-management-system-pro'
		),
		'date_order_render'     => esc_html__( 'Date', 'masterstudy-lms-learning-management-system-pro' ),
		'order_order_render'    => esc_html__( 'Order ID', 'masterstudy-lms-learning-management-system-pro' ),
		'title_order_render'    => esc_html__( 'Title', 'masterstudy-lms-learning-management-system-pro' ),
		'items_order_render'    => esc_html__( 'Items list', 'masterstudy-lms-learning-management-system-pro' ),
		'customer_order_render' => esc_html__( 'User section', 'masterstudy-lms-learning-management-system-pro' ),
		'button_order_render'   => esc_html__( 'Button', 'masterstudy-lms-learning-management-system-pro' ),
		'message'               => 'Congratulations! A new purchase has been made. Open your instructor dashboard to check the new Order from the user {{user_login}}.',
		'vars'                  => array(
			'user_login' => esc_html__(
				'User login',
				'masterstudy-lms-learning-management-system-pro'
			),
			'site_url'   => esc_html__(
				'Site URL',
				'masterstudy-lms-learning-management-system-pro'
			),
		),
	),
	'stm_lms_new_order_accepted'                    => array(
		'section'             => 'order',
		'notice'              => esc_html__(
			'Order message for Student',
			'masterstudy-lms-learning-management-system-pro'
		),
		'title'               => esc_html__( 'Thank you for purchase!', 'masterstudy-lms-learning-management-system-pro' ),
		'subject'             => esc_html__(
			'Thank you for purchase!',
			'masterstudy-lms-learning-management-system-pro'
		),
		'date_order_render'   => esc_html__( 'Date', 'masterstudy-lms-learning-management-system-pro' ),
		'order_order_render'  => esc_html__( 'Order ID', 'masterstudy-lms-learning-management-system-pro' ),
		'title_order_render'  => esc_html__( 'Title', 'masterstudy-lms-learning-management-system-pro' ),
		'items_order_render'  => esc_html__( 'Items list', 'masterstudy-lms-learning-management-system-pro' ),
		'button_order_render' => esc_html__( 'Button', 'masterstudy-lms-learning-management-system-pro' ),
		'message'             => 'Your access is now ready. Dive in and start your journey toward new skills and achievements today!',
		'vars'                => array(
			'user_login' => esc_html__(
				'User login',
				'masterstudy-lms-learning-management-system-pro'
			),
			'site_url'   => esc_html__(
				'Site URL',
				'masterstudy-lms-learning-management-system-pro'
			),
		),
	),
	'stm_lms_course_added_to_user'                  => array(
		'section' => 'course',
		'notice'  => esc_html__(
			'Course added to User (for admin)',
			'masterstudy-lms-learning-management-system-pro'
		),
		'subject' => esc_html__(
			'Course added to User',
			'masterstudy-lms-learning-management-system-pro'
		),
		'message' => 'Course {{course_title}} was added to {{login}}.',
		'vars'    => array(
			'course_title' => esc_html__(
				'Course title',
				'masterstudy-lms-learning-management-system-pro'
			),
			'login'        => esc_html__(
				'Login',
				'masterstudy-lms-learning-management-system-pro'
			),
		),
	),
	'stm_lms_course_available_for_user'             => array(
		'section' => 'course',
		'notice'  => esc_html__(
			'Course added to User (for user)',
			'masterstudy-lms-learning-management-system-pro'
		),
		'subject' => esc_html__(
			'Course added.',
			'masterstudy-lms-learning-management-system-pro'
		),
		'message' => 'Course {{course_title}} is now available to learn.',
		'vars'    => array(
			'course_title' => esc_html__(
				'Course title',
				'masterstudy-lms-learning-management-system-pro'
			),
		),
	),
	'stm_lms_course_quiz_completed_for_user'        => array(
		'section' => 'course',
		'notice'  => esc_html__(
			'Quiz Completed',
			'masterstudy-lms-learning-management-system-pro'
		),
		'subject' => esc_html__(
			'Quiz Completed',
			'masterstudy-lms-learning-management-system-pro'
		),
		'message' => '{{user_login}} completed the {{quiz_name}} on the course {{course_title}} with a Passing grade of {{passing_grade}} and a result of {{progress}}.',
		'vars'    => array(
			'user_login'    => esc_html__(
				'User login',
				'masterstudy-lms-learning-management-system-pro'
			),
			'course_title'  => esc_html__(
				'Course title',
				'masterstudy-lms-learning-management-system-pro'
			),
			'quiz_name'     => esc_html__(
				'Quiz name',
				'masterstudy-lms-learning-management-system-pro'
			),
			'passing_grade' => esc_html__(
				'Passing grade',
				'masterstudy-lms-learning-management-system-pro'
			),
			'progress'      => esc_html__(
				'Progress',
				'masterstudy-lms-learning-management-system-pro'
			),
		),
	),
	'stm_lms_membership_course_available_for_admin' => array(
		'section' => 'course',
		'notice'  => esc_html__( 'Course added with Membership Plan to User (for admin)', 'masterstudy-lms-learning-management-system-pro' ),
		'subject' => esc_html__( 'Course added with Membership Plan.', 'masterstudy-lms-learning-management-system-pro' ),
		'message' => 'Course {{course_title}} was added to {{login}} with {{membership_plan}}.',
		'vars'    => array(
			'course_title'    => esc_html__( 'Course title', 'masterstudy-lms-learning-management-system-pro' ),
			'membership_plan' => esc_html__( 'Plan name', 'masterstudy-lms-learning-management-system-pro' ),
		),
	),
	'stm_lms_membership_course_available_for_user'  => array(
		'section' => 'course',
		'notice'  => esc_html__( 'Course added with Membership Plan to User (for user)', 'masterstudy-lms-learning-management-system-pro' ),
		'subject' => esc_html__( 'Course added to User', 'masterstudy-lms-learning-management-system-pro' ),
		'message' => 'Course {{course_title}} is now available to learn with {{membership_plan}}.',
		'vars'    => array(
			'course_title'    => esc_html__( 'Course title', 'masterstudy-lms-learning-management-system-pro' ),
			'membership_plan' => esc_html__( 'Plan name', 'masterstudy-lms-learning-management-system-pro' ),
		),
	),
	'stm_lms_announcement_from_instructor'          => array(
		'section' => 'instructors',
		'notice'  => esc_html__(
			'Announcement from the Instructor',
			'masterstudy-lms-learning-management-system-pro'
		),
		'subject' => esc_html__(
			'Announcement from the Instructor',
			'masterstudy-lms-learning-management-system-pro'
		),
		'message' => '{{mail}}',
		'vars'    => array(
			'mail' => esc_html__(
				'Instructor message',
				'masterstudy-lms-learning-management-system-pro'
			),
		),
	),
	'stm_lms_assignment_checked'                    => array(
		'section' => 'assignment',
		'notice'  => esc_html__(
			'Assignment status change (for student)',
			'masterstudy-lms-learning-management-system-pro'
		),
		'subject' => esc_html__(
			'Assignment status change.',
			'masterstudy-lms-learning-management-system-pro'
		),
		'message' => esc_html__(
			'Your assignment has been checked',
			'masterstudy-lms-learning-management-system-pro'
		),
		'vars'    => array(),
	),
	'stm_lms_new_assignment'                        => array(
		'section' => 'assignment',
		'notice'  => esc_html__(
			'New assignment (for instructor)',
			'masterstudy-lms-learning-management-system-pro'
		),
		'subject' => esc_html__(
			'New assignment',
			'masterstudy-lms-learning-management-system-pro'
		),
		'message' => esc_html__(
			'Check the new assignment that was submitted by the student. Assignment on "{{assignment_title}}" sent by {{user_login}} in the course "{{course_title}}"',
			'masterstudy-lms-learning-management-system-pro'
		),
		'vars'    => array(
			'user_login'       => esc_html__( 'User Login', 'masterstudy-lms-learning-management-system-pro' ),
			'course_title'     => esc_html__( 'Course title', 'masterstudy-lms-learning-management-system-pro' ),
			'assignment_title' => esc_html__( 'Assignment title', 'masterstudy-lms-learning-management-system-pro' ),

		),
	),
	'stm_lms_new_group_invite'                      => array(
		'section' => 'enterprise',
		'notice'  => esc_html__(
			'New group invite',
			'masterstudy-lms-learning-management-system-pro'
		),
		'subject' => esc_html__(
			'New group invite',
			'masterstudy-lms-learning-management-system-pro'
		),
		'message' => esc_html__(
			'You were added to the group: {{site_name}}. Now you can check their new courses.',
			'masterstudy-lms-learning-management-system-pro'
		),
		'vars'    => array(
			'site_name' => esc_html__(
				'Site name',
				'masterstudy-lms-learning-management-system-pro'
			),
		),
	),
	'stm_lms_new_user_creds'                        => array(
		'section' => 'enterprise',
		'notice'  => esc_html__(
			'New user credentials for enterprise group',
			'masterstudy-lms-learning-management-system-pro'
		),
		'subject' => esc_html__(
			'New user credentials for enterprise group',
			'masterstudy-lms-learning-management-system-pro'
		),
		'message' => esc_html__(
			'Login: {{username}} Password: {{password}} Site URL: {{site_url}}',
			'masterstudy-lms-learning-management-system-pro'
		),
		'vars'    => array(
			'username' => esc_html__(
				'Username',
				'masterstudy-lms-learning-management-system-pro'
			),
			'password' => esc_html__(
				'Password',
				'masterstudy-lms-learning-management-system-pro'
			),
			'site_url' => esc_html__(
				'Site URL',
				'masterstudy-lms-learning-management-system-pro'
			),
		),
	),
	'stm_lms_enterprise_new_group_course'           => array(
		'section' => 'enterprise',
		'notice'  => esc_html__(
			'New course available for enterprise group',
			'masterstudy-lms-learning-management-system-pro'
		),
		'subject' => esc_html__(
			'New course available for enterprise group',
			'masterstudy-lms-learning-management-system-pro'
		),
		'message' => __(
		// phpcs:ignore WordPress.WP.I18n.NoHtmlWrappedStrings
			'<p>{{admin_login}} invited you to the group {{group_name}} on {{blog_name}}. You were added to the {{course_title}} course.</p>',
			'masterstudy-lms-learning-management-system-pro'
		),
		'vars'    => array(
			'admin_login'  => esc_html__(
				'Admin login',
				'masterstudy-lms-learning-management-system-pro'
			),
			'group_name'   => esc_html__(
				'Group name',
				'masterstudy-lms-learning-management-system-pro'
			),
			'blog_name'    => esc_html__(
				'Blog name',
				'masterstudy-lms-learning-management-system-pro'
			),
			'course_title' => esc_html__(
				'Course title',
				'masterstudy-lms-learning-management-system-pro'
			),
			'user_url'     => esc_html__(
				'User url',
				'masterstudy-lms-learning-management-system-pro'
			),
		),
	),
);

// Conditionally add notifications for Pro Plus users
if ( STM_LMS_Helpers::is_pro_plus() ) {
	$email_templates['stm_lms_reports_student_checked'] = array(
		'section'   => 'reports',
		'notice'    => esc_html__( 'Progress updates for students', 'masterstudy-lms-learning-management-system-pro' ),
		'frequency' => esc_html__( 'Frequency', 'masterstudy-lms-learning-management-system-pro' ),
		'period'    => esc_html__( 'Day of the week to send', 'masterstudy-lms-learning-management-system-pro' ),
		'time'      => esc_html__( 'Time', 'masterstudy-lms-learning-management-system-pro' ),
		'title'     => esc_html__( 'Your Weekly Report', 'masterstudy-lms-learning-management-system-pro' ),
		'message'   => esc_html__( 'Great job so far! Here is just a quick heads-up on your progress:', 'masterstudy-lms-learning-management-system-pro' ),
		'vars'      => array(),
	);

	$email_templates['stm_lms_reports_instructor_checked'] = array(
		'section'   => 'reports',
		'notice'    => esc_html__( 'Reports for instructors', 'masterstudy-lms-learning-management-system-pro' ),
		'frequency' => esc_html__( 'Frequency', 'masterstudy-lms-learning-management-system-pro' ),
		'period'    => esc_html__( 'Day of the week to send', 'masterstudy-lms-learning-management-system-pro' ),
		'time'      => esc_html__( 'Time', 'masterstudy-lms-learning-management-system-pro' ),
		'title'     => esc_html__( 'Your Weekly Report', 'masterstudy-lms-learning-management-system-pro' ),
		'message'   => esc_html__( 'Your dedication to creating valuable learning experiences is evident in the numbers. Here\'s your latest update on your courses:', 'masterstudy-lms-learning-management-system-pro' ),
		'vars'      => array(),
	);
	$email_templates['stm_lms_reports_admin_checked']      = array(
		'section'   => 'reports',
		'notice'    => esc_html__( 'Reports for admin', 'masterstudy-lms-learning-management-system-pro' ),
		'frequency' => esc_html__( 'Frequency', 'masterstudy-lms-learning-management-system-pro' ),
		'period'    => esc_html__( 'Day of the week to send', 'masterstudy-lms-learning-management-system-pro' ),
		'time'      => esc_html__( 'Time', 'masterstudy-lms-learning-management-system-pro' ),
		'title'     => esc_html__( 'Your Weekly Report', 'masterstudy-lms-learning-management-system-pro' ),
		'message'   => esc_html__( 'Here\'s your comprehensive report summarizing the activity across the entire LMS platform:', 'masterstudy-lms-learning-management-system-pro' ),
		'vars'      => array(),
	);
}

$email_templates['stm_lms_certificates_preview_checked'] = array(
	'section'      => 'certificates',
	'notice'       => esc_html__( 'Certificate for students', 'masterstudy-lms-learning-management-system-pro' ),
	'subject'      => esc_html__( 'You have received a certificate!', 'masterstudy-lms-learning-management-system-pro' ),
	'message'      => wp_kses_post( '<h2>You have received a certificate!</h2>{{date}}<br>{{certificate_preview}}<br>{{button}}' ),
	'vars'         => array(
		'date'                => esc_html__( 'Date', 'masterstudy-lms-learning-management-system-pro' ),
		'certificate_preview' => esc_html__( 'Certificate preview', 'masterstudy-lms-learning-management-system-pro' ),
		'button'              => esc_html__( 'Button ', 'masterstudy-lms-learning-management-system-pro' ),
	),
	'notice_setup' => esc_html__( 'To receive certificates, make sure the certificate page is set up properly.', 'masterstudy-lms-learning-management-system-pro' ),
);


return $email_templates;
