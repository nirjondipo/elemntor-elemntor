<?php
/**
 * Elementor Elemntor Widget
 *
 * @package Elemntor_Elemntor
 */

namespace Elemntor_Elemntor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Utils;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Elementor Elemntor Widget.
 *
 * Elementor widget that displays custom content.
 *
 * @since 1.0.0
 */
class Elemntor_Widget extends Widget_Base {

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
		return 'elemntor_widget';
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
		return esc_html__( 'Elemntor Widget', 'elemntor-elemntor' );
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
		return 'eicon-code';
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
		return array( 'general' );
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
		return array( 'elemntor', 'custom', 'widget' );
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
				'label' => esc_html__( 'Content', 'elemntor-elemntor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'title',
			array(
				'label'       => esc_html__( 'Title', 'elemntor-elemntor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Default title', 'elemntor-elemntor' ),
				'placeholder' => esc_html__( 'Type your title here', 'elemntor-elemntor' ),
			)
		);

		$this->add_control(
			'description',
			array(
				'label'       => esc_html__( 'Description', 'elemntor-elemntor' ),
				'type'        => Controls_Manager::TEXTAREA,
				'rows'        => 10,
				'default'     => esc_html__( 'Default description', 'elemntor-elemntor' ),
				'placeholder' => esc_html__( 'Type your description here', 'elemntor-elemntor' ),
			)
		);

		$this->end_controls_section();

		// Style Section
		$this->start_controls_section(
			'style_section',
			array(
				'label' => esc_html__( 'Style', 'elemntor-elemntor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'title_color',
			array(
				'label'     => esc_html__( 'Title Color', 'elemntor-elemntor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .elemntor-widget-title' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'     => 'title_typography',
				'selector' => '{{WRAPPER}} .elemntor-widget-title',
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

		?>
		<div class="elemntor-widget-wrapper">
			<?php if ( ! empty( $settings['title'] ) ) : ?>
				<h2 class="elemntor-widget-title"><?php echo esc_html( $settings['title'] ); ?></h2>
			<?php endif; ?>
			
			<?php if ( ! empty( $settings['description'] ) ) : ?>
				<div class="elemntor-widget-description"><?php echo wp_kses_post( $settings['description'] ); ?></div>
			<?php endif; ?>
		</div>
		<?php
	}

	/**
	 * Render widget output in the editor.
	 *
	 * Written as a Backbone JavaScript template and used to generate the live preview.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function content_template() {
		?>
		<#
		var title = settings.title;
		var description = settings.description;
		#>
		<div class="elemntor-widget-wrapper">
			<# if ( title ) { #>
				<h2 class="elemntor-widget-title">{{{ title }}}</h2>
			<# } #>
			
			<# if ( description ) { #>
				<div class="elemntor-widget-description">{{{ description }}}</div>
			<# } #>
		</div>
		<?php
	}
}

