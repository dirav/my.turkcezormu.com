<?php
namespace StmLmsElementor\Widgets\Course;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Border;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class MsLmsCourseStatus extends Widget_Base {

	public function get_name() {
		return 'ms_lms_course_status';
	}

	public function get_title() {
		return esc_html__( 'Status', 'masterstudy-lms-learning-management-system' );
	}

	public function get_icon() {
		return 'stmlms-course-check lms-course-icon';
	}

	public function get_categories() {
		return array( 'stm_lms_course' );
	}

	public function get_style_depends() {
		return array(
			'masterstudy-single-course-components',
		);
	}

	protected function register_controls() {
		$courses = \STM_LMS_Courses::get_all_courses_for_options();

		$this->start_controls_section(
			'section',
			array(
				'label' => esc_html__( 'Content', 'masterstudy-lms-learning-management-system' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);
		$this->add_control(
			'course',
			array(
				'label'              => esc_html__( 'Course', 'masterstudy-lms-learning-management-system' ),
				'type'               => Controls_Manager::SELECT2,
				'label_block'        => true,
				'multiple'           => false,
				'options'            => $courses,
				'default'            => ! empty( $courses ) ? key( $courses ) : '',
				'frontend_available' => true,
			)
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'styles_section',
			array(
				'label' => esc_html__( 'Status', 'masterstudy-lms-learning-management-system' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'typography',
				'selector' => '{{WRAPPER}} span.masterstudy-single-course-status',
			)
		);
		$this->add_control(
			'color',
			array(
				'label'     => esc_html__( 'Color', 'masterstudy-lms-learning-management-system' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} span.masterstudy-single-course-status' => 'color: {{VALUE}}',
				),
			)
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'     => 'background',
				'types'    => array( 'classic', 'gradient' ),
				'selector' => '{{WRAPPER}} span.masterstudy-single-course-status',
			)
		);
		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => 'border',
				'selector' => '{{WRAPPER}} span.masterstudy-single-course-status',
			)
		);
		$this->add_control(
			'border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'masterstudy-lms-learning-management-system' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} span.masterstudy-single-course-status' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);
		$this->add_responsive_control(
			'width',
			array(
				'label'      => esc_html__( 'Width', 'masterstudy-lms-learning-management-system' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'selectors'  => array(
					'{{WRAPPER}} span.masterstudy-single-course-status' => 'width: {{SIZE}}{{UNIT}};',
				),
			)
		);
		$this->add_responsive_control(
			'height',
			array(
				'label'      => esc_html__( 'Height', 'masterstudy-lms-learning-management-system' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'selectors'  => array(
					'{{WRAPPER}} span.masterstudy-single-course-status' => 'height: {{SIZE}}{{UNIT}};',
				),
			)
		);
		$this->end_controls_section();
	}

	protected function render() {
		$settings    = $this->get_settings_for_display();
		$course_id   = $settings['course'] ?? null;
		$course_data = masterstudy_get_elementor_course_data( intval( $course_id ) );

		if ( empty( $course_data ) || ! isset( $course_data['course'] ) ) {
			return;
		}

		\STM_LMS_Templates::show_lms_template(
			'components/course/status',
			array(
				'course' => $course_data['course'],
			)
		);
	}
}
