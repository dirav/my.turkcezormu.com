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

class MsLmsCoursePopularCourses extends Widget_Base {

	public function get_name() {
		return 'ms_lms_course_popular_courses';
	}

	public function get_title() {
		return esc_html__( 'Popular courses', 'masterstudy-lms-learning-management-system' );
	}

	public function get_icon() {
		return 'stmlms-course-application lms-course-icon';
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
		$this->add_control(
			'preset',
			array(
				'label'              => esc_html__( 'Preset', 'masterstudy-lms-learning-management-system' ),
				'type'               => Controls_Manager::SELECT,
				'default'            => 'vertical',
				'frontend_available' => true,
				'options'            => array(
					'horizontal' => esc_html__( 'Horizontal', 'masterstudy-lms-learning-management-system' ),
					'vertical'   => esc_html__( 'Vertical', 'masterstudy-lms-learning-management-system' ),
				),
			)
		);
		$this->add_control(
			'courses_per_page',
			array(
				'label'   => esc_html__( 'Number of Courses', 'masterstudy-lms-learning-management-system' ),
				'type'    => Controls_Manager::NUMBER,
				'min'     => 0,
				'max'     => 100,
				'step'    => 1,
				'default' => 4,
			)
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'title_section',
			array(
				'label' => esc_html__( 'Title', 'masterstudy-lms-learning-management-system' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'title_typography',
				'selector' => '{{WRAPPER}} .masterstudy-popular-courses__title',
			)
		);
		$this->add_control(
			'title_color',
			array(
				'label'     => esc_html__( 'Color', 'masterstudy-lms-learning-management-system' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .masterstudy-popular-courses__title' => 'color: {{VALUE}}',
				),
			)
		);
		$this->add_responsive_control(
			'title_margin',
			array(
				'label'      => esc_html__( 'Margin', 'masterstudy-lms-learning-management-system' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .masterstudy-popular-courses__title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'course_title_section',
			array(
				'label' => esc_html__( 'Course Name', 'masterstudy-lms-learning-management-system' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'course_title_typography',
				'selector' => '{{WRAPPER}} a.masterstudy-popular-courses__item-title',
			)
		);
		$this->add_control(
			'course_title_color',
			array(
				'label'     => esc_html__( 'Color', 'masterstudy-lms-learning-management-system' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} a.masterstudy-popular-courses__item-title' => 'color: {{VALUE}}',
				),
			)
		);
		$this->add_control(
			'course_title_hover_color',
			array(
				'label'     => esc_html__( 'Hover Color', 'masterstudy-lms-learning-management-system' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} a.masterstudy-popular-courses__item-title:hover' => 'color: {{VALUE}}',
				),
			)
		);
		$this->add_responsive_control(
			'course_title_margin',
			array(
				'label'      => esc_html__( 'Margin', 'masterstudy-lms-learning-management-system' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} a.masterstudy-popular-courses__item-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'stars_section',
			array(
				'label' => esc_html__( 'Star Rating', 'masterstudy-lms-learning-management-system' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);
		$this->add_control(
			'stars_color',
			array(
				'label'     => esc_html__( 'Color', 'masterstudy-lms-learning-management-system' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .masterstudy-popular-courses__rating-star::before' => 'color: {{VALUE}}',
				),
			)
		);
		$this->add_control(
			'stars_filled_color',
			array(
				'label'     => esc_html__( 'Filled Color', 'masterstudy-lms-learning-management-system' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .masterstudy-popular-courses__rating-star_filled::before' => 'color: {{VALUE}}',
				),
			)
		);
		$this->add_control(
			'stars_size',
			array(
				'label'      => esc_html__( 'Size', 'masterstudy-lms-learning-management-system' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'selectors'  => array(
					'{{WRAPPER}} .masterstudy-popular-courses__rating-star, {{WRAPPER}} .masterstudy-popular-courses__rating-star_filled' => 'font-size: {{SIZE}}{{UNIT}};',
				),
			)
		);
		$this->add_responsive_control(
			'stars_margin',
			array(
				'label'      => esc_html__( 'Margin', 'masterstudy-lms-learning-management-system' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .masterstudy-popular-courses__rating-star, {{WRAPPER}} .masterstudy-popular-courses__rating-star_filled' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'instructor_section',
			array(
				'label' => esc_html__( 'Instructor Name', 'masterstudy-lms-learning-management-system' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'instructor_typography',
				'selector' => '{{WRAPPER}} a.masterstudy-popular-courses__instructor',
			)
		);
		$this->add_control(
			'instructor_color',
			array(
				'label'     => esc_html__( 'Color', 'masterstudy-lms-learning-management-system' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} a.masterstudy-popular-courses__instructor' => 'color: {{VALUE}}',
				),
			)
		);
		$this->add_control(
			'instructor_hover_color',
			array(
				'label'     => esc_html__( 'Hover Color', 'masterstudy-lms-learning-management-system' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} a.masterstudy-popular-courses__instructor:hover' => 'color: {{VALUE}}',
				),
			)
		);
		$this->add_responsive_control(
			'instructor_margin',
			array(
				'label'      => esc_html__( 'Margin', 'masterstudy-lms-learning-management-system' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} a.masterstudy-popular-courses__instructor' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'status_section',
			array(
				'label' => esc_html__( 'Course Status', 'masterstudy-lms-learning-management-system' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'status_typography',
				'selector' => '{{WRAPPER}} span.masterstudy-popular-courses__item-status',
			)
		);
		$this->add_control(
			'status_color',
			array(
				'label'     => esc_html__( 'Color', 'masterstudy-lms-learning-management-system' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} span.masterstudy-popular-courses__item-status' => 'color: {{VALUE}}',
				),
			)
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'     => 'status_background',
				'types'    => array( 'classic', 'gradient' ),
				'selector' => '{{WRAPPER}} span.masterstudy-popular-courses__item-status',
			)
		);
		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => 'status_border',
				'selector' => '{{WRAPPER}} span.masterstudy-popular-courses__item-status',
			)
		);
		$this->add_control(
			'status_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'masterstudy-lms-learning-management-system' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} span.masterstudy-popular-courses__item-status' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'image_section',
			array(
				'label' => esc_html__( 'Course Image', 'masterstudy-lms-learning-management-system' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);
		$this->add_responsive_control(
			'image_width',
			array(
				'label'      => esc_html__( 'Width', 'masterstudy-lms-learning-management-system' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'selectors'  => array(
					'{{WRAPPER}} img.masterstudy-popular-courses__image' => 'width: {{SIZE}}{{UNIT}};',
				),
			)
		);
		$this->add_responsive_control(
			'image_height',
			array(
				'label'      => esc_html__( 'Height', 'masterstudy-lms-learning-management-system' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'selectors'  => array(
					'{{WRAPPER}} img.masterstudy-popular-courses__image' => 'height: {{SIZE}}{{UNIT}};',
				),
			)
		);
		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => 'image_border',
				'selector' => '{{WRAPPER}} img.masterstudy-popular-courses__image',
			)
		);
		$this->add_control(
			'image_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'masterstudy-lms-learning-management-system' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} img.masterstudy-popular-courses__image' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);
		$this->add_responsive_control(
			'image_margin',
			array(
				'label'      => esc_html__( 'Margin', 'masterstudy-lms-learning-management-system' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px' ),
				'selectors'  => array(
					'{{WRAPPER}} img.masterstudy-popular-courses__image' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'subs_section',
			array(
				'label' => esc_html__( 'Members-Only Access', 'masterstudy-lms-learning-management-system' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'subs_typography',
				'selector' => '{{WRAPPER}} .masterstudy-popular-courses__subscription-title',
			)
		);
		$this->add_control(
			'subs_color',
			array(
				'label'     => esc_html__( 'Color', 'masterstudy-lms-learning-management-system' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .masterstudy-popular-courses__subscription-title' => 'color: {{VALUE}}',
				),
			)
		);
		$this->add_responsive_control(
			'subs_margin',
			array(
				'label'      => esc_html__( 'Margin', 'masterstudy-lms-learning-management-system' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .masterstudy-popular-courses__subscription-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'subs_icon_section',
			array(
				'label' => esc_html__( '"Members Only" Icon', 'masterstudy-lms-learning-management-system' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);
		$this->add_responsive_control(
			'subs_icon_width',
			array(
				'label'      => esc_html__( 'Width', 'masterstudy-lms-learning-management-system' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'selectors'  => array(
					'{{WRAPPER}} .masterstudy-popular-courses__subscription img' => 'width: {{SIZE}}{{UNIT}};',
				),
			)
		);
		$this->add_responsive_control(
			'subs_icon_height',
			array(
				'label'      => esc_html__( 'Height', 'masterstudy-lms-learning-management-system' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'selectors'  => array(
					'{{WRAPPER}} .masterstudy-popular-courses__subscription img' => 'height: {{SIZE}}{{UNIT}};',
				),
			)
		);
		$this->add_responsive_control(
			'subs_icon_margin',
			array(
				'label'      => esc_html__( 'Margin', 'masterstudy-lms-learning-management-system' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px' ),
				'selectors'  => array(
					'{{WRAPPER}} .masterstudy-popular-courses__subscription img' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'price_section',
			array(
				'label' => esc_html__( 'Regular Price', 'masterstudy-lms-learning-management-system' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'price_typography',
				'selector' => '{{WRAPPER}} .masterstudy-popular-courses__price',
			)
		);
		$this->add_control(
			'price_color',
			array(
				'label'     => esc_html__( 'Color', 'masterstudy-lms-learning-management-system' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .masterstudy-popular-courses__price' => 'color: {{VALUE}}',
				),
			)
		);
		$this->add_responsive_control(
			'price_margin',
			array(
				'label'      => esc_html__( 'Margin', 'masterstudy-lms-learning-management-system' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .masterstudy-popular-courses__price' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'sale_section',
			array(
				'label' => esc_html__( 'Sale Price', 'masterstudy-lms-learning-management-system' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'sale_typography',
				'selector' => '{{WRAPPER}} .masterstudy-popular-courses__price-sale',
			)
		);
		$this->add_control(
			'sale_color',
			array(
				'label'     => esc_html__( 'Color', 'masterstudy-lms-learning-management-system' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .masterstudy-popular-courses__price-sale' => 'color: {{VALUE}}',
				),
			)
		);
		$this->add_responsive_control(
			'sale_margin',
			array(
				'label'      => esc_html__( 'Margin', 'masterstudy-lms-learning-management-system' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .masterstudy-popular-courses__price-sale' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'separator_section',
			array(
				'label' => esc_html__( 'Divider Line', 'masterstudy-lms-learning-management-system' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);
		$this->add_control(
			'separator_color',
			array(
				'label'     => esc_html__( 'Color', 'masterstudy-lms-learning-management-system' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .masterstudy-popular-courses__title, {{WRAPPER}} .masterstudy-popular-courses__item' => 'border-color: {{VALUE}}',
				),
			)
		);
		$this->end_controls_section();
	}

	protected function render() {
		$settings         = $this->get_settings_for_display();
		$course_id        = $settings['course'] ?? null;
		$courses_per_page = $settings['courses_per_page'] ?? 4;
		$course_data      = masterstudy_get_elementor_course_data( intval( $course_id ) );

		if ( empty( $course_data ) || ! isset( $course_data['course'] ) ) {
			return;
		}

		\STM_LMS_Templates::show_lms_template(
			'components/course/popular-courses',
			array(
				'course'           => $course_data['course'],
				'courses_per_page' => $courses_per_page,
				'style'            => $settings['preset'] ?? '',
			)
		);
	}
}
