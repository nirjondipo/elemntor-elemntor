<?php
/**
 * Elementor Mobile Menu Widget
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
 * Elementor Mobile Menu Widget.
 *
 * Elementor widget that displays a mobile menu with burger icon and slide-in panel.
 *
 * @since 1.0.0
 */
class Mobile_Menu_Widget extends Widget_Base {

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
		return 'mobile_menu';
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
		return esc_html__( 'Mobile Menu', 'elemntor-elemntor' );
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
		return 'eicon-menu-bar';
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
		return array( 'menu', 'mobile', 'navigation', 'burger', 'hamburger' );
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
		return array( 'elemntor-elemntor-mobile-menu' );
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
		return array( 'elemntor-elemntor-mobile-menu' );
	}

	/**
	 * Whether the widget has an inner wrapper.
	 *
	 * Used to determine if the widget should have an inner wrapper.
	 * This ensures the elementor-widget-container wrapper is present.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return bool Whether the widget has an inner wrapper.
	 */
	public function has_widget_inner_wrapper(): bool {
		return true;
	}

	/**
	 * Get available menus.
	 *
	 * @since 1.0.0
	 * @access private
	 * @return array Available menus.
	 */
	private function get_available_menus() {
		$menus = wp_get_nav_menus();
		$options = array();

		foreach ( $menus as $menu ) {
			$options[ $menu->term_id ] = $menu->name;
		}

		return $options;
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
				'label' => esc_html__( 'Menu Settings', 'elemntor-elemntor' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$menus = $this->get_available_menus();

		if ( ! empty( $menus ) ) {
			$menu_keys = array_keys( $menus );
			$this->add_control(
				'menu',
				array(
					'label'        => esc_html__( 'Menu', 'elemntor-elemntor' ),
					'type'         => Controls_Manager::SELECT,
					'options'      => $menus,
					'default'      => ! empty( $menu_keys ) ? $menu_keys[0] : '',
					'save_default' => true,
					'description'  => sprintf(
						/* translators: %s: Link to WordPress admin menu */
						esc_html__( 'Go to the <a href="%s" target="_blank">Menus screen</a> to manage your menus.', 'elemntor-elemntor' ),
						admin_url( 'nav-menus.php' )
					),
				)
			);
		} else {
			$this->add_control(
				'menu',
				array(
					'type'            => Controls_Manager::RAW_HTML,
					'raw'             => sprintf(
						/* translators: %s: Link to WordPress admin menu */
						esc_html__( '<strong>There are no menus in your site.</strong><br>Go to the <a href="%s" target="_blank">Menus screen</a> to create one.', 'elemntor-elemntor' ),
						admin_url( 'nav-menus.php?action=edit&menu=0' )
					),
					'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
				)
			);
		}

		$this->add_control(
			'burger_icon',
			array(
				'label'       => esc_html__( 'Burger Icon', 'elemntor-elemntor' ),
				'type'        => Controls_Manager::ICONS,
				'default'     => array(
					'value'   => 'fas fa-bars',
					'library' => 'fa-solid',
				),
			)
		);

		$this->add_control(
			'close_icon',
			array(
				'label'       => esc_html__( 'Close Icon', 'elemntor-elemntor' ),
				'type'        => Controls_Manager::ICONS,
				'default'     => array(
					'value'   => 'fas fa-times',
					'library' => 'fa-solid',
				),
			)
		);

		$this->add_control(
			'menu_width',
			array(
				'label'      => esc_html__( 'Menu Panel Width', 'elemntor-elemntor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%' ),
				'range'      => array(
					'px' => array(
						'min'  => 200,
						'max'  => 600,
						'step' => 10,
					),
					'%'  => array(
						'min' => 50,
						'max' => 100,
					),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => 400,
				),
				'selectors'  => array(
					'{{WRAPPER}} .ee-mobile-menu-panel' => 'width: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();

		// Style Section - Burger Button
		$this->start_controls_section(
			'burger_style_section',
			array(
				'label' => esc_html__( 'Burger Button', 'elemntor-elemntor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'burger_button_size',
			array(
				'label'      => esc_html__( 'Button Size', 'elemntor-elemntor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min'  => 30,
						'max'  => 100,
						'step' => 1,
					),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => 50,
				),
				'selectors'  => array(
					'{{WRAPPER}} .ee-mobile-menu-toggle' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}; min-width: {{SIZE}}{{UNIT}}; min-height: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'burger_size',
			array(
				'label'      => esc_html__( 'Icon Size', 'elemntor-elemntor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min'  => 15,
						'max'  => 50,
						'step' => 1,
					),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => 24,
				),
				'selectors'  => array(
					'{{WRAPPER}} .ee-mobile-menu-toggle i' => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .ee-mobile-menu-toggle svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'burger_color',
			array(
				'label'     => esc_html__( 'Icon Color', 'elemntor-elemntor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .ee-mobile-menu-toggle' => 'color: {{VALUE}};',
					'{{WRAPPER}} .ee-mobile-menu-toggle svg' => 'fill: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'burger_bg_color',
			array(
				'label'     => esc_html__( 'Background Color', 'elemntor-elemntor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .ee-mobile-menu-toggle' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => 'burger_border',
				'selector' => '{{WRAPPER}} .ee-mobile-menu-toggle',
			)
		);

		$this->add_control(
			'burger_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'elemntor-elemntor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%' ),
				'range'      => array(
					'px' => array(
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					),
					'%'  => array(
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					),
				),
				'default'    => array(
					'unit' => '%',
					'size' => 50,
				),
				'selectors'  => array(
					'{{WRAPPER}} .ee-mobile-menu-toggle' => 'border-radius: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'burger_padding',
			array(
				'label'      => esc_html__( 'Padding', 'elemntor-elemntor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .ee-mobile-menu-toggle' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();

		// Style Section - Menu Panel
		$this->start_controls_section(
			'panel_style_section',
			array(
				'label' => esc_html__( 'Menu Panel', 'elemntor-elemntor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'panel_theme_mode',
			array(
				'label'   => esc_html__( 'Theme Mode', 'elemntor-elemntor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'light',
				'options' => array(
					'light' => esc_html__( 'Light Mode', 'elemntor-elemntor' ),
					'dark'  => esc_html__( 'Dark Mode', 'elemntor-elemntor' ),
				),
			)
		);

		$this->add_control(
			'panel_header_height',
			array(
				'label'      => esc_html__( 'Header Height', 'elemntor-elemntor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min'  => 40,
						'max'  => 100,
						'step' => 5,
					),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => 50,
				),
				'selectors'  => array(
					'{{WRAPPER}} .ee-mobile-menu-header' => 'min-height: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'panel_bg_color',
			array(
				'label'     => esc_html__( 'Background Color (Light Mode)', 'elemntor-elemntor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => array(
					'{{WRAPPER}} .ee-mobile-menu-panel' => 'background-color: {{VALUE}};',
				),
				'condition' => array(
					'panel_theme_mode' => 'light',
				),
			)
		);

		$this->add_control(
			'panel_bg_color_dark',
			array(
				'label'     => esc_html__( 'Background Color (Dark Mode)', 'elemntor-elemntor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#1a1a1a',
				'selectors' => array(
					'{{WRAPPER}} .ee-mobile-menu-panel.ee-dark-mode' => 'background-color: {{VALUE}};',
				),
				'condition' => array(
					'panel_theme_mode' => 'dark',
				),
			)
		);

		$this->add_control(
			'panel_text_color',
			array(
				'label'     => esc_html__( 'Text Color (Light Mode)', 'elemntor-elemntor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#333333',
				'selectors' => array(
					'{{WRAPPER}} .ee-mobile-menu-panel .ee-mobile-menu ul li a' => 'color: {{VALUE}};',
				),
				'condition' => array(
					'panel_theme_mode' => 'light',
				),
			)
		);

		$this->add_control(
			'panel_text_color_dark',
			array(
				'label'     => esc_html__( 'Text Color (Dark Mode)', 'elemntor-elemntor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => array(
					'{{WRAPPER}} .ee-mobile-menu-panel.ee-dark-mode .ee-mobile-menu ul li a' => 'color: {{VALUE}};',
				),
				'condition' => array(
					'panel_theme_mode' => 'dark',
				),
			)
		);

		$this->add_control(
			'panel_header_bg',
			array(
				'label'     => esc_html__( 'Header Background (Light Mode)', 'elemntor-elemntor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => array(
					'{{WRAPPER}} .ee-mobile-menu-header' => 'background-color: {{VALUE}};',
				),
				'condition' => array(
					'panel_theme_mode' => 'light',
				),
			)
		);

		$this->add_control(
			'panel_header_bg_dark',
			array(
				'label'     => esc_html__( 'Header Background (Dark Mode)', 'elemntor-elemntor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#1a1a1a',
				'selectors' => array(
					'{{WRAPPER}} .ee-mobile-menu-panel.ee-dark-mode .ee-mobile-menu-header' => 'background-color: {{VALUE}};',
				),
				'condition' => array(
					'panel_theme_mode' => 'dark',
				),
			)
		);

		$this->add_control(
			'panel_border_color',
			array(
				'label'     => esc_html__( 'Header Border Color (Light Mode)', 'elemntor-elemntor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#e0e0e0',
				'selectors' => array(
					'{{WRAPPER}} .ee-mobile-menu-header' => 'border-bottom-color: {{VALUE}};',
				),
				'condition' => array(
					'panel_theme_mode' => 'light',
				),
			)
		);

		$this->add_control(
			'panel_border_color_dark',
			array(
				'label'     => esc_html__( 'Header Border Color (Dark Mode)', 'elemntor-elemntor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#333333',
				'selectors' => array(
					'{{WRAPPER}} .ee-mobile-menu-panel.ee-dark-mode .ee-mobile-menu-header' => 'border-bottom-color: {{VALUE}};',
				),
				'condition' => array(
					'panel_theme_mode' => 'dark',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'panel_box_shadow',
				'selector' => '{{WRAPPER}} .ee-mobile-menu-panel',
			)
		);

		$this->end_controls_section();

		// Style Section - Close Button
		$this->start_controls_section(
			'close_style_section',
			array(
				'label' => esc_html__( 'Close Button', 'elemntor-elemntor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'close_size',
			array(
				'label'      => esc_html__( 'Icon Size', 'elemntor-elemntor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min'  => 15,
						'max'  => 50,
						'step' => 1,
					),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => 24,
				),
				'selectors'  => array(
					'{{WRAPPER}} .ee-mobile-menu-close i' => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .ee-mobile-menu-close svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'close_color',
			array(
				'label'     => esc_html__( 'Icon Color', 'elemntor-elemntor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .ee-mobile-menu-close' => 'color: {{VALUE}};',
					'{{WRAPPER}} .ee-mobile-menu-close svg' => 'fill: {{VALUE}};',
				),
			)
		);

		$this->end_controls_section();

		// Style Section - Menu Items
		$this->start_controls_section(
			'menu_items_style_section',
			array(
				'label' => esc_html__( 'Menu Items', 'elemntor-elemntor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'menu_item_color',
			array(
				'label'     => esc_html__( 'Text Color', 'elemntor-elemntor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .ee-mobile-menu ul li a' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'menu_item_hover_color',
			array(
				'label'     => esc_html__( 'Hover Color', 'elemntor-elemntor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .ee-mobile-menu ul li a:hover' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'menu_item_typography',
				'selector' => '{{WRAPPER}} .ee-mobile-menu ul li a',
			)
		);

		$this->add_responsive_control(
			'menu_item_padding',
			array(
				'label'      => esc_html__( 'Padding', 'elemntor-elemntor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .ee-mobile-menu ul li a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'menu_item_border',
			array(
				'label'     => esc_html__( 'Border Bottom', 'elemntor-elemntor' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'Show', 'elemntor-elemntor' ),
				'label_off' => esc_html__( 'Hide', 'elemntor-elemntor' ),
				'default'   => 'yes',
				'selectors' => array(
					'{{WRAPPER}} .ee-mobile-menu ul li' => 'border-bottom: 1px solid #e0e0e0;',
				),
			)
		);

		$this->end_controls_section();

		// Style Section - Dropdown
		$this->start_controls_section(
			'dropdown_style_section',
			array(
				'label' => esc_html__( 'Dropdown Menu', 'elemntor-elemntor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'dropdown_bg_color',
			array(
				'label'     => esc_html__( 'Background Color', 'elemntor-elemntor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#f5f5f5',
				'selectors' => array(
					'{{WRAPPER}} .ee-mobile-menu ul li ul' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'dropdown_text_color',
			array(
				'label'     => esc_html__( 'Text Color', 'elemntor-elemntor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .ee-mobile-menu ul li ul li a' => 'color: {{VALUE}};',
				),
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

		if ( empty( $settings['menu'] ) ) {
			return;
		}

		$menu_id = $settings['menu'];
		$menu_items = wp_get_nav_menu_items( $menu_id );

		if ( empty( $menu_items ) ) {
			return;
		}

		// Build menu structure
		$menu_array = array();
		$menu_items_by_parent = array();

		foreach ( $menu_items as $item ) {
			$menu_items_by_parent[ $item->ID ] = $item;
		}

		foreach ( $menu_items as $item ) {
			if ( $item->menu_item_parent == 0 ) {
				$menu_array[ $item->ID ] = $item;
			}
		}

		$this->add_render_attribute( 'wrapper', 'class', 'ee-mobile-menu-wrapper' );
		
		// Print inline styles on frontend only (not in editor) as fallback
		if ( ! \Elementor\Plugin::$instance->editor->is_edit_mode() ) {
			$this->print_inline_css();
		}
		?>
		<div <?php $this->print_render_attribute_string( 'wrapper' ); ?>>
			<button class="ee-mobile-menu-toggle" type="button" aria-label="<?php esc_attr_e( 'Open Menu', 'elemntor-elemntor' ); ?>">
				<?php Icons_Manager::render_icon( $settings['burger_icon'], array( 'aria-hidden' => 'true' ) ); ?>
			</button>

			<div class="ee-mobile-menu-overlay"></div>

			<?php
			// Add theme mode class to panel
			$panel_class = 'ee-mobile-menu-panel';
			if ( ! empty( $settings['panel_theme_mode'] ) && $settings['panel_theme_mode'] === 'dark' ) {
				$panel_class .= ' ee-dark-mode';
			}
			?>
			<div class="<?php echo esc_attr( $panel_class ); ?>">
				<div class="ee-mobile-menu-header">
					<button class="ee-mobile-menu-back" type="button" aria-label="<?php esc_attr_e( 'Back', 'elemntor-elemntor' ); ?>" style="display: none;">
						<svg aria-hidden="true" class="e-font-icon-svg e-fas-arrow-left" viewBox="0 0 448 512" xmlns="http://www.w3.org/2000/svg"><path d="M257.5 445.1l-22.2 22.2c-9.4 9.4-24.6 9.4-33.9 0L7 273c-9.4-9.4-9.4-24.6 0-33.9L201.4 44.7c9.4-9.4 24.6-9.4 33.9 0l22.2 22.2c9.5 9.5 9.3 25-.4 34.3L136.6 216H424c13.3 0 24 10.7 24 24v32c0 13.3-10.7 24-24 24H136.6l120.5 114.8c9.8 9.3 10 24.8.4 34.3z"></path></svg>
					</button>
					<span class="ee-mobile-menu-title" style="display: none;"></span>
					<button class="ee-mobile-menu-close" type="button" aria-label="<?php esc_attr_e( 'Close Menu', 'elemntor-elemntor' ); ?>">
						<?php Icons_Manager::render_icon( $settings['close_icon'], array( 'aria-hidden' => 'true' ) ); ?>
					</button>
				</div>

				<nav class="ee-mobile-menu" role="navigation">
					<?php $this->render_menu_items( $menu_items, 0 ); ?>
				</nav>
			</div>
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
		
		// Get the wrapper class that Elementor uses - fallback if ID not available
		if ( empty( $widget_id ) ) {
			$widget_id = uniqid( 'ee-menu-' );
		}
		
		// Elementor uses: .elementor-{post_id} .elementor-element.elementor-element-{widget_id}
		// We'll use multiple selectors to cover all cases
		$widget_selector = '.elementor-element.elementor-element-' . $widget_id;
		$wrapper_class = 'elementor-element-' . $widget_id;
		
		// Try to get post ID for more specific selector
		$post_id = get_the_ID();
		$post_selector = '';
		if ( $post_id ) {
			$post_selector = '.elementor-' . $post_id . ' ' . $widget_selector;
		}
		
		// Use the most specific selector available
		$base_selector = ! empty( $post_selector ) ? $post_selector : $widget_selector;
		$css = '';
		
		// Button Size - override reset CSS
		if ( ! empty( $settings['burger_button_size']['size'] ) ) {
			$size = $settings['burger_button_size']['size'] . ( ! empty( $settings['burger_button_size']['unit'] ) ? $settings['burger_button_size']['unit'] : 'px' );
			$css .= "{$base_selector} button.ee-mobile-menu-toggle, {$base_selector} [type=button].ee-mobile-menu-toggle { width: {$size} !important; height: {$size} !important; min-width: {$size} !important; min-height: {$size} !important; }";
		}
		
		// Icon Size
		if ( ! empty( $settings['burger_size']['size'] ) ) {
			$icon_size = $settings['burger_size']['size'] . ( ! empty( $settings['burger_size']['unit'] ) ? $settings['burger_size']['unit'] : 'px' );
			$css .= "{$base_selector} .ee-mobile-menu-toggle svg { width: {$icon_size} !important; height: {$icon_size} !important; }";
			$css .= "{$base_selector} .ee-mobile-menu-toggle i { font-size: {$icon_size} !important; }";
			$css .= "{$base_selector} .ee-mobile-menu-toggle .e-font-icon-svg { width: {$icon_size} !important; height: {$icon_size} !important; }";
		}
		
		// Icon Color - override reset CSS
		if ( ! empty( $settings['burger_color'] ) ) {
			$css .= "{$base_selector} button.ee-mobile-menu-toggle, {$base_selector} [type=button].ee-mobile-menu-toggle { color: {$settings['burger_color']} !important; }";
			$css .= "{$base_selector} .ee-mobile-menu-toggle svg { fill: {$settings['burger_color']} !important; }";
			$css .= "{$base_selector} .ee-mobile-menu-toggle svg path { fill: {$settings['burger_color']} !important; }";
		}
		
		// Background Color - override reset CSS
		if ( ! empty( $settings['burger_bg_color'] ) ) {
			$css .= "{$base_selector} button.ee-mobile-menu-toggle, {$base_selector} [type=button].ee-mobile-menu-toggle { background-color: {$settings['burger_bg_color']} !important; }";
		}
		
		// Border Radius - override reset CSS
		if ( ! empty( $settings['burger_border_radius']['size'] ) ) {
			$radius = $settings['burger_border_radius']['size'] . ( ! empty( $settings['burger_border_radius']['unit'] ) ? $settings['burger_border_radius']['unit'] : '%' );
			$css .= "{$base_selector} button.ee-mobile-menu-toggle, {$base_selector} [type=button].ee-mobile-menu-toggle { border-radius: {$radius} !important; }";
		}
		
		// Border - handle Group_Control_Border structure - override reset CSS
		// Check if border is set (Elementor stores it in burger_border_border)
		if ( ! empty( $settings['burger_border_border'] ) && $settings['burger_border_border'] !== 'none' ) {
			$border_style = $settings['burger_border_border'];
			
			// Get border width - Elementor stores it as dimensions
			$border_width = '';
			if ( ! empty( $settings['burger_border_width'] ) ) {
				if ( is_array( $settings['burger_border_width'] ) ) {
					$top = ! empty( $settings['burger_border_width']['top'] ) ? $settings['burger_border_width']['top'] : '0';
					$right = ! empty( $settings['burger_border_width']['right'] ) ? $settings['burger_border_width']['right'] : $top;
					$bottom = ! empty( $settings['burger_border_width']['bottom'] ) ? $settings['burger_border_width']['bottom'] : $top;
					$left = ! empty( $settings['burger_border_width']['left'] ) ? $settings['burger_border_width']['left'] : $top;
					$unit = ! empty( $settings['burger_border_width']['unit'] ) ? $settings['burger_border_width']['unit'] : 'px';
					$border_width = "{$top}{$unit} {$right}{$unit} {$bottom}{$unit} {$left}{$unit}";
				} else {
					$border_width = $settings['burger_border_width'];
				}
			} else {
				$border_width = '1px';
			}
			
			// Get border color - handle CSS variables
			$border_color = ! empty( $settings['burger_border_color'] ) ? $settings['burger_border_color'] : '#333333';
			
			// Output border with all properties
			$css .= "{$base_selector} button.ee-mobile-menu-toggle, {$base_selector} [type=button].ee-mobile-menu-toggle { border-style: {$border_style} !important; border-width: {$border_width} !important; border-color: {$border_color} !important; }";
		}
		
		// Also handle individual border properties if they exist (Elementor sometimes stores them separately)
		if ( ! empty( $settings['burger_border_width'] ) && is_array( $settings['burger_border_width'] ) ) {
			$top = ! empty( $settings['burger_border_width']['top'] ) ? $settings['burger_border_width']['top'] : '';
			$right = ! empty( $settings['burger_border_width']['right'] ) ? $settings['burger_border_width']['right'] : '';
			$bottom = ! empty( $settings['burger_border_width']['bottom'] ) ? $settings['burger_border_width']['bottom'] : '';
			$left = ! empty( $settings['burger_border_width']['left'] ) ? $settings['burger_border_width']['left'] : '';
			$unit = ! empty( $settings['burger_border_width']['unit'] ) ? $settings['burger_border_width']['unit'] : 'px';
			
			if ( $top !== '' || $right !== '' || $bottom !== '' || $left !== '' ) {
				$top_val = $top !== '' ? $top . $unit : '0';
				$right_val = $right !== '' ? $right . $unit : '0';
				$bottom_val = $bottom !== '' ? $bottom . $unit : '0';
				$left_val = $left !== '' ? $left . $unit : '0';
				$css .= "{$base_selector} button.ee-mobile-menu-toggle, {$base_selector} [type=button].ee-mobile-menu-toggle { border-width: {$top_val} {$right_val} {$bottom_val} {$left_val} !important; }";
			}
		}
		
		// Border color separately
		if ( ! empty( $settings['burger_border_color'] ) ) {
			$css .= "{$base_selector} button.ee-mobile-menu-toggle, {$base_selector} [type=button].ee-mobile-menu-toggle { border-color: {$settings['burger_border_color']} !important; }";
		}
		
		// Border style separately
		if ( ! empty( $settings['burger_border_border'] ) && $settings['burger_border_border'] !== 'none' ) {
			$css .= "{$base_selector} button.ee-mobile-menu-toggle, {$base_selector} [type=button].ee-mobile-menu-toggle { border-style: {$settings['burger_border_border']} !important; }";
		}
		
		// Menu Panel Width
		if ( ! empty( $settings['menu_width']['size'] ) ) {
			$width = $settings['menu_width']['size'] . ( ! empty( $settings['menu_width']['unit'] ) ? $settings['menu_width']['unit'] : 'px' );
			$css .= "{$base_selector} .ee-mobile-menu-panel { width: {$width} !important; }";
		}
		
		// Panel Background
		if ( ! empty( $settings['panel_bg_color'] ) ) {
			$css .= "{$base_selector} .ee-mobile-menu-panel { background-color: {$settings['panel_bg_color']} !important; }";
		}
		
		// Menu Item Colors
		if ( ! empty( $settings['menu_item_color'] ) ) {
			$css .= "{$base_selector} .ee-mobile-menu ul li a { color: {$settings['menu_item_color']} !important; }";
		}
		
		if ( ! empty( $settings['menu_item_hover_color'] ) ) {
			$css .= "{$base_selector} .ee-mobile-menu ul li a:hover { color: {$settings['menu_item_hover_color']} !important; }";
		}
		
		// Close Button Size
		if ( ! empty( $settings['close_size']['size'] ) ) {
			$close_size = $settings['close_size']['size'] . ( ! empty( $settings['close_size']['unit'] ) ? $settings['close_size']['unit'] : 'px' );
			$css .= "{$base_selector} .ee-mobile-menu-close svg { width: {$close_size} !important; height: {$close_size} !important; }";
			$css .= "{$base_selector} .ee-mobile-menu-close i { font-size: {$close_size} !important; }";
		}
		
		// Close Button Color
		if ( ! empty( $settings['close_color'] ) ) {
			$css .= "{$base_selector} .ee-mobile-menu-close { color: {$settings['close_color']} !important; }";
			$css .= "{$base_selector} .ee-mobile-menu-close svg { fill: {$settings['close_color']} !important; }";
			$css .= "{$base_selector} .ee-mobile-menu-close svg path { fill: {$settings['close_color']} !important; }";
		}
		
		// Dropdown Background
		if ( ! empty( $settings['dropdown_bg_color'] ) ) {
			$css .= "{$base_selector} .ee-mobile-menu ul li ul { background-color: {$settings['dropdown_bg_color']} !important; }";
		}
		
		// Dropdown Text Color
		if ( ! empty( $settings['dropdown_text_color'] ) ) {
			$css .= "{$base_selector} .ee-mobile-menu ul li ul li a { color: {$settings['dropdown_text_color']} !important; }";
		}
		
		if ( ! empty( $css ) ) {
			echo '<style id="ee-mobile-menu-inline-' . esc_attr( $widget_id ) . '">' . wp_strip_all_tags( $css ) . '</style>';
		}
	}

	/**
	 * Render menu items recursively.
	 *
	 * @since 1.0.0
	 * @access private
	 * @param array $menu_items Menu items.
	 * @param int   $parent_id Parent menu item ID.
	 */
	private function render_menu_items( $menu_items, $parent_id = 0 ) {
		$children = array();

		foreach ( $menu_items as $item ) {
			if ( $item->menu_item_parent == $parent_id ) {
				$children[] = $item;
			}
		}

		if ( empty( $children ) ) {
			return;
		}

		?>
		<ul class="<?php echo $parent_id > 0 ? 'ee-submenu' : ''; ?>">
			<?php foreach ( $children as $item ) : ?>
				<?php
				$has_children = false;
				foreach ( $menu_items as $child ) {
					if ( $child->menu_item_parent == $item->ID ) {
						$has_children = true;
						break;
					}
				}
				?>
				<li class="<?php echo $has_children ? 'ee-menu-item-has-children' : ''; ?>">
					<a href="<?php echo esc_url( $item->url ); ?>" <?php echo $item->target ? 'target="' . esc_attr( $item->target ) . '"' : ''; ?>>
						<?php echo esc_html( $item->title ); ?>
					</a>
					<?php if ( $has_children ) : ?>
						<button class="ee-submenu-toggle" type="button" aria-label="<?php esc_attr_e( 'Toggle Submenu', 'elemntor-elemntor' ); ?>">
							<span class="ee-submenu-icon"></span>
						</button>
						<?php $this->render_menu_items( $menu_items, $item->ID ); ?>
					<?php endif; ?>
				</li>
			<?php endforeach; ?>
		</ul>
		<?php
	}
}

