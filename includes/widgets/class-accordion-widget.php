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

		$this->add_control(
			'content_padding',
			array(
				'label'      => esc_html__( 'Padding', 'elemntor-elemntor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .ee-accordion-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
}

