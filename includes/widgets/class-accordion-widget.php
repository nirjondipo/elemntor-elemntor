<?php
/**
 * Elementor Accordion Widget
 *
 * @package Elemntor_Elemntor
 */

namespace Elemntor_Elemntor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Icons_Manager;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Elementor Accordion Widget.
 *
 * Elementor widget that displays an accordion with icons, titles, and content.
 *
 * @since 1.0.0
 */
class Accordion_Widget extends Widget_Base {

	/**
	 * Get widget name.
	 *
	 * Retrieve widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'accordion';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Accordion', 'elemntor-elemntor' );
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve widget icon.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-accordion';
	}

	/**
	 * Get widget categories.
	 *
	 * Retrieve the list of categories the widget belongs to.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return array( 'custom-elements' );
	}

	/**
	 * Get widget keywords.
	 *
	 * Retrieve the list of keywords the widget belongs to.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return array Widget keywords.
	 */
	public function get_keywords() {
		return array( 'accordion', 'toggle', 'faq', 'collapse', 'expand' );
	}

	/**
	 * Get style dependencies.
	 *
	 * Retrieve the list of style dependencies the widget requires.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return array Widget style dependencies.
	 */
	public function get_style_depends() {
		return array( 'elemntor-elemntor-accordion' );
	}

	/**
	 * Get script dependencies.
	 *
	 * Retrieve the list of script dependencies the widget requires.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return array Widget script dependencies.
	 */
	public function get_script_depends() {
		return array( 'elemntor-elemntor-accordion' );
	}

	/**
	 * Register widget controls.
	 *
	 * Add input fields to allow the user to customize the widget settings.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function register_controls() {

		// Content Section
		$this->start_controls_section(
			'content_section',
			array(
				'label' => esc_html__( 'Accordion Items', 'elemntor-elemntor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		// Global Icon Settings
		$this->add_control(
			'enable_global_icon',
			array(
				'label'        => esc_html__( 'Enable Global Icon', 'elemntor-elemntor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'elemntor-elemntor' ),
				'label_off'    => esc_html__( 'No', 'elemntor-elemntor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			)
		);

		$this->add_control(
			'global_icon',
			array(
				'label'       => esc_html__( 'Global Icon', 'elemntor-elemntor' ),
				'type'        => Controls_Manager::ICONS,
				'default'     => array(
					'value'   => 'fas fa-circle',
					'library' => 'fa-solid',
				),
				'condition'   => array(
					'enable_global_icon' => 'yes',
				),
			)
		);

		$this->add_control(
			'global_open_icon',
			array(
				'label'       => esc_html__( 'Global Open Icon', 'elemntor-elemntor' ),
				'type'        => Controls_Manager::ICONS,
				'description' => esc_html__( 'Icon shown when accordion item is open', 'elemntor-elemntor' ),
				'default'     => array(
					'value'   => 'fas fa-minus',
					'library' => 'fa-solid',
				),
				'condition'   => array(
					'enable_global_icon' => 'yes',
				),
			)
		);

		$this->add_control(
			'global_close_icon',
			array(
				'label'       => esc_html__( 'Global Close Icon', 'elemntor-elemntor' ),
				'type'        => Controls_Manager::ICONS,
				'description' => esc_html__( 'Icon shown when accordion item is closed', 'elemntor-elemntor' ),
				'default'     => array(
					'value'   => 'fas fa-plus',
					'library' => 'fa-solid',
				),
				'condition'   => array(
					'enable_global_icon' => 'yes',
				),
			)
		);

		// Accordion Items Repeater
		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'item_title',
			array(
				'label'       => esc_html__( 'Title', 'elemntor-elemntor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Accordion Title', 'elemntor-elemntor' ),
				'label_block' => true,
			)
		);

		$repeater->add_control(
			'use_global_icon',
			array(
				'label'        => esc_html__( 'Use Global Icon', 'elemntor-elemntor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'elemntor-elemntor' ),
				'label_off'    => esc_html__( 'No', 'elemntor-elemntor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			)
		);

		$repeater->add_control(
			'item_icon',
			array(
				'label'       => esc_html__( 'Item Icon', 'elemntor-elemntor' ),
				'type'        => Controls_Manager::ICONS,
				'default'     => array(
					'value'   => 'fas fa-circle',
					'library' => 'fa-solid',
				),
				'condition'   => array(
					'use_global_icon!' => 'yes',
				),
			)
		);

		$repeater->add_control(
			'item_open_icon',
			array(
				'label'       => esc_html__( 'Item Open Icon', 'elemntor-elemntor' ),
				'type'        => Controls_Manager::ICONS,
				'description' => esc_html__( 'Icon shown when this item is open', 'elemntor-elemntor' ),
				'default'     => array(
					'value'   => 'fas fa-minus',
					'library' => 'fa-solid',
				),
				'condition'   => array(
					'use_global_icon!' => 'yes',
				),
			)
		);

		$repeater->add_control(
			'item_close_icon',
			array(
				'label'       => esc_html__( 'Item Close Icon', 'elemntor-elemntor' ),
				'type'        => Controls_Manager::ICONS,
				'description' => esc_html__( 'Icon shown when this item is closed', 'elemntor-elemntor' ),
				'default'     => array(
					'value'   => 'fas fa-plus',
					'library' => 'fa-solid',
				),
				'condition'   => array(
					'use_global_icon!' => 'yes',
				),
			)
		);

		$repeater->add_control(
			'item_content',
			array(
				'label'   => esc_html__( 'Content', 'elemntor-elemntor' ),
				'type'    => Controls_Manager::WYSIWYG,
				'default' => esc_html__( 'Accordion content goes here. You can add any HTML content.', 'elemntor-elemntor' ),
			)
		);

		$this->add_control(
			'accordion_items',
			array(
				'label'       => esc_html__( 'Accordion Items', 'elemntor-elemntor' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => array(
					array(
						'item_title'   => esc_html__( 'Accordion Item #1', 'elemntor-elemntor' ),
						'item_content' => esc_html__( 'Content for accordion item #1', 'elemntor-elemntor' ),
					),
					array(
						'item_title'   => esc_html__( 'Accordion Item #2', 'elemntor-elemntor' ),
						'item_content' => esc_html__( 'Content for accordion item #2', 'elemntor-elemntor' ),
					),
				),
				'title_field' => '{{{ item_title }}}',
			)
		);

		$this->end_controls_section();

		// Style Section - Title
		$this->start_controls_section(
			'title_style_section',
			array(
				'label' => esc_html__( 'Title', 'elemntor-elemntor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'title_typography',
				'selector' => '{{WRAPPER}} .ee-accordion-title',
			)
		);

		$this->add_control(
			'title_color',
			array(
				'label'     => esc_html__( 'Text Color', 'elemntor-elemntor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .ee-accordion-title' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'title_hover_color',
			array(
				'label'     => esc_html__( 'Text Color (Hover)', 'elemntor-elemntor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .ee-accordion-header:hover .ee-accordion-title' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'title_active_color',
			array(
				'label'     => esc_html__( 'Text Color (Active)', 'elemntor-elemntor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .ee-accordion-item.active .ee-accordion-title' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'border_indicator_color',
			array(
				'label'     => esc_html__( 'Left Border Indicator Color', 'elemntor-elemntor' ),
				'type'      => Controls_Manager::COLOR,
				'description' => esc_html__( 'Color of the left border indicator when accordion is active', 'elemntor-elemntor' ),
				'selectors' => array(
					'{{WRAPPER}} .ee-accordion-header::before' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'title_spacing',
			array(
				'label'      => esc_html__( 'Spacing', 'elemntor-elemntor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .ee-accordion-title' => 'margin: 0 {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'title_alignment',
			array(
				'label'     => esc_html__( 'Alignment', 'elemntor-elemntor' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => array(
					'left'   => array(
						'title' => esc_html__( 'Left', 'elemntor-elemntor' ),
						'icon'  => 'eicon-text-align-left',
					),
					'center' => array(
						'title' => esc_html__( 'Center', 'elemntor-elemntor' ),
						'icon'  => 'eicon-text-align-center',
					),
					'right'  => array(
						'title' => esc_html__( 'Right', 'elemntor-elemntor' ),
						'icon'  => 'eicon-text-align-right',
					),
				),
				'default'   => 'left',
				'selectors'  => array(
					'{{WRAPPER}} .ee-accordion-title' => 'text-align: {{VALUE}};',
				),
			)
		);

		$this->end_controls_section();

		// Style Section - Icon
		$this->start_controls_section(
			'icon_style_section',
			array(
				'label' => esc_html__( 'Icon', 'elemntor-elemntor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'icon_size',
			array(
				'label'      => esc_html__( 'Icon Size', 'elemntor-elemntor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min'  => 10,
						'max'  => 100,
						'step' => 1,
					),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => 24,
				),
				'selectors'  => array(
					'{{WRAPPER}} .ee-accordion-icon-left i' => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .ee-accordion-icon-left svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'icon_color',
			array(
				'label'     => esc_html__( 'Icon Color', 'elemntor-elemntor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .ee-accordion-icon-left' => 'color: {{VALUE}};',
					'{{WRAPPER}} .ee-accordion-icon-left svg' => 'fill: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'icon_spacing',
			array(
				'label'      => esc_html__( 'Icon Spacing', 'elemntor-elemntor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min'  => 0,
						'max'  => 50,
						'step' => 1,
					),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => 15,
				),
				'selectors'  => array(
					'{{WRAPPER}} .ee-accordion-icon-left' => 'margin-right: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'icon_active_filter_hue',
			array(
				'label'      => esc_html__( 'Active Icon Filter Hue Rotate', 'elemntor-elemntor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'deg' ),
				'range'      => array(
					'deg' => array(
						'min'  => 0,
						'max'  => 360,
						'step' => 1,
					),
				),
				'default'    => array(
					'unit' => 'deg',
					'size' => 81,
				),
				'description' => esc_html__( 'Hue rotation for active icon filter effect', 'elemntor-elemntor' ),
			)
		);

		$this->add_control(
			'icon_active_filter_brightness',
			array(
				'label'      => esc_html__( 'Active Icon Filter Brightness', 'elemntor-elemntor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( '%' ),
				'range'      => array(
					'%' => array(
						'min'  => 0,
						'max'  => 200,
						'step' => 1,
					),
				),
				'default'    => array(
					'unit' => '%',
					'size' => 92,
				),
				'description' => esc_html__( 'Brightness for active icon filter effect', 'elemntor-elemntor' ),
			)
		);

		$this->add_control(
			'toggle_icon_size',
			array(
				'label'      => esc_html__( 'Toggle Icon Size', 'elemntor-elemntor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min'  => 10,
						'max'  => 50,
						'step' => 1,
					),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => 16,
				),
				'selectors'  => array(
					'{{WRAPPER}} .ee-accordion-toggle-icon i' => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .ee-accordion-toggle-icon svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'toggle_icon_color',
			array(
				'label'     => esc_html__( 'Toggle Icon Color', 'elemntor-elemntor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .ee-accordion-toggle-icon' => 'color: {{VALUE}};',
					'{{WRAPPER}} .ee-accordion-toggle-icon svg' => 'fill: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'toggle_icon_open_color',
			array(
				'label'     => esc_html__( 'Toggle Icon Color (Open)', 'elemntor-elemntor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .ee-accordion-item.active .ee-accordion-toggle-icon' => 'color: {{VALUE}};',
					'{{WRAPPER}} .ee-accordion-item.active .ee-accordion-toggle-icon svg' => 'fill: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'toggle_icon_active_background',
			array(
				'label'     => esc_html__( 'Toggle Icon Background (Active)', 'elemntor-elemntor' ),
				'type'      => Controls_Manager::COLOR,
				'description' => esc_html__( 'Background color of the toggle icon when accordion is active/open', 'elemntor-elemntor' ),
				'selectors' => array(
					'{{WRAPPER}} .ee-accordion-item.active .ee-accordion-toggle-icon' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->end_controls_section();

		// Style Section - Content
		$this->start_controls_section(
			'content_style_section',
			array(
				'label' => esc_html__( 'Content', 'elemntor-elemntor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'content_typography',
				'selector' => '{{WRAPPER}} .ee-accordion-content',
			)
		);

		$this->add_control(
			'content_color',
			array(
				'label'     => esc_html__( 'Text Color', 'elemntor-elemntor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .ee-accordion-content' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'content_background',
			array(
				'label'     => esc_html__( 'Background Color', 'elemntor-elemntor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .ee-accordion-content' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_responsive_control(
			'content_padding',
			array(
				'label'      => esc_html__( 'Padding', 'elemntor-elemntor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .ee-accordion-item.active .ee-accordion-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'content_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'elemntor-elemntor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .ee-accordion-content' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();

		// Style Section - Item
		$this->start_controls_section(
			'item_style_section',
			array(
				'label' => esc_html__( 'Item', 'elemntor-elemntor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'item_spacing',
			array(
				'label'      => esc_html__( 'Item Spacing', 'elemntor-elemntor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min'  => 0,
						'max'  => 50,
						'step' => 1,
					),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => 10,
				),
				'selectors'  => array(
					'{{WRAPPER}} .ee-accordion-item + .ee-accordion-item' => 'margin-top: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'header_padding',
			array(
				'label'      => esc_html__( 'Header Padding', 'elemntor-elemntor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .ee-accordion-header' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'header_background',
			array(
				'label'     => esc_html__( 'Header Background', 'elemntor-elemntor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .ee-accordion-header' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'header_active_background',
			array(
				'label'     => esc_html__( 'Header Background (Active)', 'elemntor-elemntor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .ee-accordion-item.active .ee-accordion-header' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'header_hover_background',
			array(
				'label'     => esc_html__( 'Header Background (Hover)', 'elemntor-elemntor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .ee-accordion-header:hover' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => 'item_border',
				'selector' => '{{WRAPPER}} .ee-accordion-item',
			)
		);

		$this->add_control(
			'item_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'elemntor-elemntor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .ee-accordion-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'item_box_shadow',
				'selector' => '{{WRAPPER}} .ee-accordion-item',
			)
		);

		$this->end_controls_section();
	}

	/**
	 * Render widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();

		if ( empty( $settings['accordion_items'] ) ) {
			return;
		}

		$this->add_render_attribute( 'wrapper', 'class', 'ee-accordion' );
		
		// Print inline styles on frontend only (not in editor) as fallback
		if ( ! \Elementor\Plugin::$instance->editor->is_edit_mode() ) {
			$this->print_inline_css();
		}
		?>
		<div <?php $this->print_render_attribute_string( 'wrapper' ); ?>>
			<?php
			foreach ( $settings['accordion_items'] as $index => $item ) {
				$item_id = 'accordion-item-' . $this->get_id() . '-' . $index;
				$item_key = 'item_' . $index;

				// Determine which icons to use
				$use_global = ! empty( $item['use_global_icon'] ) && $item['use_global_icon'] === 'yes';
				$enable_global = ! empty( $settings['enable_global_icon'] ) && $settings['enable_global_icon'] === 'yes';

				if ( $use_global && $enable_global ) {
					$left_icon = ! empty( $settings['global_icon'] ) ? $settings['global_icon'] : array();
					$open_icon = ! empty( $settings['global_open_icon'] ) ? $settings['global_open_icon'] : array();
					$close_icon = ! empty( $settings['global_close_icon'] ) ? $settings['global_close_icon'] : array();
				} else {
					$left_icon = ! empty( $item['item_icon'] ) ? $item['item_icon'] : array();
					$open_icon = ! empty( $item['item_open_icon'] ) ? $item['item_open_icon'] : array();
					$close_icon = ! empty( $item['item_close_icon'] ) ? $item['item_close_icon'] : array();
				}

				$this->add_render_attribute( $item_key, 'class', 'ee-accordion-item' );
				$this->add_render_attribute( $item_key, 'data-item-index', $index );
				?>
				<div <?php $this->print_render_attribute_string( $item_key ); ?>>
					<div class="ee-accordion-header">
						<?php if ( ! empty( $left_icon ) ) : ?>
							<span class="ee-accordion-icon ee-accordion-icon-left">
								<?php Icons_Manager::render_icon( $left_icon, array( 'aria-hidden' => 'true' ) ); ?>
							</span>
						<?php endif; ?>
						
						<h3 class="ee-accordion-title"><?php echo esc_html( $item['item_title'] ); ?></h3>
						
						<span class="ee-accordion-toggle-icon ee-accordion-toggle-close">
							<?php
							if ( ! empty( $close_icon ) ) {
								Icons_Manager::render_icon( $close_icon, array( 'aria-hidden' => 'true' ) );
							}
							?>
						</span>
						<span class="ee-accordion-toggle-icon ee-accordion-toggle-open" style="display: none;">
							<?php
							if ( ! empty( $open_icon ) ) {
								Icons_Manager::render_icon( $open_icon, array( 'aria-hidden' => 'true' ) );
							}
							?>
						</span>
					</div>
					<div class="ee-accordion-content">
						<?php echo wp_kses_post( $item['item_content'] ); ?>
					</div>
				</div>
				<?php
			}
			?>
		</div>
		<?php
	}

	/**
	 * Print inline CSS for widget styles.
	 *
	 * This ensures styles are applied on frontend even if Elementor's CSS generation fails.
	 * Uses the widget's unique ID to target the specific instance.
	 *
	 * @since 1.0.0
	 * @access private
	 */
	private function print_inline_css() {
		$settings = $this->get_settings_for_display();
		$widget_id = $this->get_id();
		
		if ( empty( $widget_id ) ) {
			$widget_id = uniqid( 'ee-accordion-' );
		}
		
		$widget_selector = '.elementor-element.elementor-element-' . $widget_id;
		$post_id = get_the_ID();
		$post_selector = '';
		if ( $post_id ) {
			$post_selector = '.elementor-' . $post_id . ' ' . $widget_selector;
		}
		
		$base_selector = ! empty( $post_selector ) ? $post_selector : $widget_selector;
		$css = '';
		
		// Title Color - always output if set (even if empty, to override defaults)
		if ( isset( $settings['title_color'] ) ) {
			$color = ! empty( $settings['title_color'] ) ? $settings['title_color'] : 'inherit';
			$css .= "{$base_selector} .ee-accordion-title { color: {$color} !important; }";
		}
		
		// Title Hover Color
		if ( isset( $settings['title_hover_color'] ) ) {
			$hover_color = ! empty( $settings['title_hover_color'] ) ? $settings['title_hover_color'] : '';
			if ( $hover_color !== '' && $hover_color !== null ) {
				$css .= "{$base_selector} .ee-accordion-header:hover .ee-accordion-title { color: {$hover_color} !important; }";
			}
		}
		
		// Title Active Color - always output if set (including CSS variables)
		if ( isset( $settings['title_active_color'] ) && $settings['title_active_color'] !== '' && $settings['title_active_color'] !== null ) {
			$active_color = $settings['title_active_color'];
			$css .= "{$base_selector} .ee-accordion-item.active .ee-accordion-title { color: {$active_color} !important; }";
		}
		
		// Border Indicator Color - always output if set (including CSS variables)
		if ( isset( $settings['border_indicator_color'] ) && $settings['border_indicator_color'] !== '' && $settings['border_indicator_color'] !== null ) {
			$indicator_color = $settings['border_indicator_color'];
			$css .= "{$base_selector} .ee-accordion-header::before { background-color: {$indicator_color} !important; }";
		}
		
		// Title Spacing
		if ( isset( $settings['title_spacing']['size'] ) && $settings['title_spacing']['size'] !== '' ) {
			$spacing = $settings['title_spacing']['size'] . ( ! empty( $settings['title_spacing']['unit'] ) ? $settings['title_spacing']['unit'] : 'px' );
			$css .= "{$base_selector} .ee-accordion-title { margin: 0 {$spacing} !important; }";
		}
		
		// Icon Size
		if ( isset( $settings['icon_size']['size'] ) && $settings['icon_size']['size'] !== '' ) {
			$icon_size = $settings['icon_size']['size'] . ( ! empty( $settings['icon_size']['unit'] ) ? $settings['icon_size']['unit'] : 'px' );
			$css .= "{$base_selector} .ee-accordion-icon-left svg { width: {$icon_size} !important; height: {$icon_size} !important; }";
			$css .= "{$base_selector} .ee-accordion-icon-left i { font-size: {$icon_size} !important; }";
		}
		
		// Icon Color - always output if set
		if ( isset( $settings['icon_color'] ) ) {
			$color = ! empty( $settings['icon_color'] ) ? $settings['icon_color'] : 'inherit';
			$css .= "{$base_selector} .ee-accordion-icon-left { color: {$color} !important; }";
			$css .= "{$base_selector} .ee-accordion-icon-left svg { fill: {$color} !important; }";
		}
		
		// Icon Spacing
		if ( isset( $settings['icon_spacing']['size'] ) && $settings['icon_spacing']['size'] !== '' ) {
			$icon_spacing = $settings['icon_spacing']['size'] . ( ! empty( $settings['icon_spacing']['unit'] ) ? $settings['icon_spacing']['unit'] : 'px' );
			$css .= "{$base_selector} .ee-accordion-icon-left { margin-right: {$icon_spacing} !important; }";
		}
		
		// Active Icon Filter Effect
		$hue_rotate = isset( $settings['icon_active_filter_hue']['size'] ) ? floatval( $settings['icon_active_filter_hue']['size'] ) : 81;
		$brightness = isset( $settings['icon_active_filter_brightness']['size'] ) ? floatval( $settings['icon_active_filter_brightness']['size'] ) : 92;
		$hue_unit = isset( $settings['icon_active_filter_hue']['unit'] ) ? $settings['icon_active_filter_hue']['unit'] : 'deg';
		$brightness_unit = isset( $settings['icon_active_filter_brightness']['unit'] ) ? $settings['icon_active_filter_brightness']['unit'] : '%';
		$css .= "{$base_selector} .ee-accordion-item.active .ee-accordion-icon-left svg { filter: hue-rotate({$hue_rotate}{$hue_unit}) brightness({$brightness}{$brightness_unit}) !important; transition-duration: 0.3s; }";
		$css .= "{$base_selector} .ee-accordion-item.active .ee-accordion-icon-left svg path { filter: hue-rotate({$hue_rotate}{$hue_unit}) brightness({$brightness}{$brightness_unit}) !important; transition-duration: 0.3s; }";
		
		// Hover Icon Filter Effect
		$css .= "{$base_selector} .ee-accordion-header:hover .ee-accordion-icon-left svg { filter: hue-rotate({$hue_rotate}{$hue_unit}) brightness({$brightness}{$brightness_unit}) !important; transition-duration: 0.3s; }";
		$css .= "{$base_selector} .ee-accordion-header:hover .ee-accordion-icon-left svg path { filter: hue-rotate({$hue_rotate}{$hue_unit}) brightness({$brightness}{$brightness_unit}) !important; transition-duration: 0.3s; }";
		
		// Toggle Icon Size
		if ( ! empty( $settings['toggle_icon_size']['size'] ) ) {
			$toggle_size = $settings['toggle_icon_size']['size'] . ( ! empty( $settings['toggle_icon_size']['unit'] ) ? $settings['toggle_icon_size']['unit'] : 'px' );
			$css .= "{$base_selector} .ee-accordion-toggle-icon svg { width: {$toggle_size} !important; height: {$toggle_size} !important; }";
			$css .= "{$base_selector} .ee-accordion-toggle-icon i { font-size: {$toggle_size} !important; }";
		}
		
		// Toggle Icon Color
		if ( ! empty( $settings['toggle_icon_color'] ) ) {
			$css .= "{$base_selector} .ee-accordion-toggle-icon { color: {$settings['toggle_icon_color']} !important; }";
			$css .= "{$base_selector} .ee-accordion-toggle-icon svg { fill: {$settings['toggle_icon_color']} !important; }";
		}
		
		// Toggle Icon Color (Open)
		if ( ! empty( $settings['toggle_icon_open_color'] ) ) {
			$css .= "{$base_selector} .ee-accordion-item.active .ee-accordion-toggle-icon { color: {$settings['toggle_icon_open_color']} !important; }";
			$css .= "{$base_selector} .ee-accordion-item.active .ee-accordion-toggle-icon svg { fill: {$settings['toggle_icon_open_color']} !important; color: {$settings['toggle_icon_open_color']} !important; }";
		}
		
		// Toggle Icon Background (Active) - always output if set (including CSS variables)
		if ( isset( $settings['toggle_icon_active_background'] ) && $settings['toggle_icon_active_background'] !== '' && $settings['toggle_icon_active_background'] !== null ) {
			$active_bg = $settings['toggle_icon_active_background'];
			$css .= "{$base_selector} .ee-accordion-item.active .ee-accordion-toggle-icon { background-color: {$active_bg} !important; }";
		}
		
		// Content Color - always output if set
		if ( isset( $settings['content_color'] ) ) {
			$color = ! empty( $settings['content_color'] ) ? $settings['content_color'] : 'inherit';
			$css .= "{$base_selector} .ee-accordion-content { color: {$color} !important; }";
		}
		
		// Content Background - always output if set (including CSS variables)
		if ( isset( $settings['content_background'] ) && $settings['content_background'] !== '' && $settings['content_background'] !== null ) {
			$bg = $settings['content_background'];
			// Apply to both active and inactive states to ensure it works
			$css .= "{$base_selector} .ee-accordion-content { background-color: {$bg} !important; }";
			$css .= "{$base_selector} .ee-accordion-item.active .ee-accordion-content { background-color: {$bg} !important; }";
		}
		
		// Content Border Radius
		if ( isset( $settings['content_border_radius'] ) && is_array( $settings['content_border_radius'] ) ) {
			$top = ! empty( $settings['content_border_radius']['top'] ) ? $settings['content_border_radius']['top'] : '0';
			$right = ! empty( $settings['content_border_radius']['right'] ) ? $settings['content_border_radius']['right'] : $top;
			$bottom = ! empty( $settings['content_border_radius']['bottom'] ) ? $settings['content_border_radius']['bottom'] : $top;
			$left = ! empty( $settings['content_border_radius']['left'] ) ? $settings['content_border_radius']['left'] : $top;
			$unit = ! empty( $settings['content_border_radius']['unit'] ) ? $settings['content_border_radius']['unit'] : 'px';
			$radius = "{$top}{$unit} {$right}{$unit} {$bottom}{$unit} {$left}{$unit}";
			$css .= "{$base_selector} .ee-accordion-content { border-radius: {$radius} !important; }";
		}
		
		// Content Padding - only apply when active (closed state should have padding: 0)
		// Calculate icon offset to align content with title start
		// Icon offset = icon width + icon margin-right (if icon exists)
		$icon_offset = 0;
		$has_icon = false;
		
		// Check if global icon is enabled
		if ( ! empty( $settings['enable_global_icon'] ) && $settings['enable_global_icon'] === 'yes' ) {
			$has_icon = true;
			$icon_size = ! empty( $settings['icon_size']['size'] ) ? floatval( $settings['icon_size']['size'] ) : 24;
			$icon_spacing = ! empty( $settings['icon_spacing']['size'] ) ? floatval( $settings['icon_spacing']['size'] ) : 15;
			$icon_offset = $icon_size + $icon_spacing;
		}
		
		// Handle responsive padding (desktop, tablet, mobile)
		$breakpoints = array(
			'' => '', // Desktop
			'_tablet' => '@media (max-width: 1024px)',
			'_mobile' => '@media (max-width: 767px)'
		);
		
		foreach ( $breakpoints as $breakpoint_suffix => $media_query ) {
			$padding_key = 'content_padding' . $breakpoint_suffix;
			
			if ( ! empty( $settings[ $padding_key ] ) && is_array( $settings[ $padding_key ] ) ) {
				$top = ! empty( $settings[ $padding_key ]['top'] ) ? $settings[ $padding_key ]['top'] : '0';
				$right = ! empty( $settings[ $padding_key ]['right'] ) ? $settings[ $padding_key ]['right'] : $top;
				$bottom = ! empty( $settings[ $padding_key ]['bottom'] ) ? $settings[ $padding_key ]['bottom'] : $top;
				$left = ! empty( $settings[ $padding_key ]['left'] ) ? $settings[ $padding_key ]['left'] : $top;
				$unit = ! empty( $settings[ $padding_key ]['unit'] ) ? $settings[ $padding_key ]['unit'] : 'px';
				
				// Add icon offset to left padding to align with title start (only for desktop)
				if ( $breakpoint_suffix === '' && $has_icon && $icon_offset > 0 ) {
					$left_value = floatval( $left );
					$left_with_offset = $left_value + $icon_offset;
					$left_padding = $left_with_offset . $unit;
				} else {
					$left_padding = $left . $unit;
				}
				
				$padding = "{$top}{$unit} {$right}{$unit} {$bottom}{$unit} {$left_padding}";
				
				if ( $media_query ) {
					$css .= "{$media_query} { {$base_selector} .ee-accordion-item.active .ee-accordion-content { padding: {$padding} !important; } }";
				} else {
					// Only apply padding when accordion is active (open)
					$css .= "{$base_selector} .ee-accordion-item.active .ee-accordion-content { padding: {$padding} !important; }";
					// Ensure closed state has no padding
					$css .= "{$base_selector} .ee-accordion-content { padding: 0 !important; }";
				}
			}
		}
		
		// Fallback: If no padding is set but icon exists, still add offset for alignment (desktop only)
		if ( empty( $settings['content_padding'] ) && $has_icon && $icon_offset > 0 ) {
			$css .= "{$base_selector} .ee-accordion-item.active .ee-accordion-content { padding-left: {$icon_offset}px !important; }";
		}
		
		// Item Spacing
		if ( ! empty( $settings['item_spacing']['size'] ) ) {
			$spacing = $settings['item_spacing']['size'] . ( ! empty( $settings['item_spacing']['unit'] ) ? $settings['item_spacing']['unit'] : 'px' );
			$css .= "{$base_selector} .ee-accordion-item + .ee-accordion-item { margin-top: {$spacing} !important; }";
		}
		
		// Header Padding
		if ( ! empty( $settings['header_padding'] ) && is_array( $settings['header_padding'] ) ) {
			$top = ! empty( $settings['header_padding']['top'] ) ? $settings['header_padding']['top'] : '0';
			$right = ! empty( $settings['header_padding']['right'] ) ? $settings['header_padding']['right'] : $top;
			$bottom = ! empty( $settings['header_padding']['bottom'] ) ? $settings['header_padding']['bottom'] : $top;
			$left = ! empty( $settings['header_padding']['left'] ) ? $settings['header_padding']['left'] : $top;
			$unit = ! empty( $settings['header_padding']['unit'] ) ? $settings['header_padding']['unit'] : 'px';
			$padding = "{$top}{$unit} {$right}{$unit} {$bottom}{$unit} {$left}{$unit}";
			$css .= "{$base_selector} .ee-accordion-header { padding: {$padding} !important; }";
		}
		
		// Header Background - always output if set
		if ( isset( $settings['header_background'] ) ) {
			$bg = ! empty( $settings['header_background'] ) ? $settings['header_background'] : 'transparent';
			$css .= "{$base_selector} .ee-accordion-header { background-color: {$bg} !important; }";
		}
		
		// Header Background (Active) - always output if set
		if ( isset( $settings['header_active_background'] ) ) {
			$bg = ! empty( $settings['header_active_background'] ) ? $settings['header_active_background'] : 'transparent';
			$css .= "{$base_selector} .ee-accordion-item.active .ee-accordion-header { background-color: {$bg} !important; }";
		}
		
		// Header Background (Hover)
		if ( isset( $settings['header_hover_background'] ) ) {
			$hover_bg = ! empty( $settings['header_hover_background'] ) ? $settings['header_hover_background'] : '';
			if ( $hover_bg !== '' && $hover_bg !== null ) {
				$css .= "{$base_selector} .ee-accordion-header:hover { background-color: {$hover_bg} !important; }";
			}
		}
		
		// Border - handle all cases including "none"
		if ( isset( $settings['item_border_border'] ) ) {
			$border_style = $settings['item_border_border'];
			
			if ( $border_style === 'none' ) {
				// Explicitly set border to none
				$css .= "{$base_selector} .ee-accordion-item { border-style: none !important; border-width: 0 !important; }";
			} else if ( ! empty( $border_style ) ) {
				// Border is set to a style (solid, dashed, etc.)
				$border_width = '1px';
				if ( ! empty( $settings['item_border_width'] ) && is_array( $settings['item_border_width'] ) ) {
					$top = ! empty( $settings['item_border_width']['top'] ) ? $settings['item_border_width']['top'] : '0';
					$right = ! empty( $settings['item_border_width']['right'] ) ? $settings['item_border_width']['right'] : $top;
					$bottom = ! empty( $settings['item_border_width']['bottom'] ) ? $settings['item_border_width']['bottom'] : $top;
					$left = ! empty( $settings['item_border_width']['left'] ) ? $settings['item_border_width']['left'] : $top;
					$unit = ! empty( $settings['item_border_width']['unit'] ) ? $settings['item_border_width']['unit'] : 'px';
					$border_width = "{$top}{$unit} {$right}{$unit} {$bottom}{$unit} {$left}{$unit}";
				}
				$border_color = ! empty( $settings['item_border_color'] ) ? $settings['item_border_color'] : '#e0e0e0';
				$css .= "{$base_selector} .ee-accordion-item { border-style: {$border_style} !important; border-width: {$border_width} !important; border-color: {$border_color} !important; }";
			}
		}
		
		// Border Radius
		if ( ! empty( $settings['item_border_radius'] ) && is_array( $settings['item_border_radius'] ) ) {
			$top = ! empty( $settings['item_border_radius']['top'] ) ? $settings['item_border_radius']['top'] : '0';
			$right = ! empty( $settings['item_border_radius']['right'] ) ? $settings['item_border_radius']['right'] : $top;
			$bottom = ! empty( $settings['item_border_radius']['bottom'] ) ? $settings['item_border_radius']['bottom'] : $top;
			$left = ! empty( $settings['item_border_radius']['left'] ) ? $settings['item_border_radius']['left'] : $top;
			$unit = ! empty( $settings['item_border_radius']['unit'] ) ? $settings['item_border_radius']['unit'] : 'px';
			$radius = "{$top}{$unit} {$right}{$unit} {$bottom}{$unit} {$left}{$unit}";
			$css .= "{$base_selector} .ee-accordion-item { border-radius: {$radius} !important; }";
		}
		
		// Output CSS if we have any
		if ( ! empty( $css ) ) {
			echo '<style id="ee-accordion-' . esc_attr( $widget_id ) . '-inline-css">' . $css . '</style>';
		}
	}
}

