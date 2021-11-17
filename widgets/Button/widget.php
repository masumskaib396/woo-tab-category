<?php
/**
 * Button Widget.
 *
 *
 * @since 1.0.0
 */
namespace Sakib\Widgets\Elementor;

use  Elementor\Widget_Base;
use  Elementor\Controls_Manager;
use  Elementor\utils;
use  Elementor\Scheme_Color;
use  Elementor\Group_Control_Typography;
use  Elementor\Scheme_Typography;
use  Elementor\Group_Control_Box_Shadow;
use  Elementor\Group_Control_Background;
use  Elementor\Group_Control_Border;
use  Elementor\Icons_Manager;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

class Sakib_Button extends \Elementor\Widget_Base {

	public function get_name() {
		return 'sakib_btutton';
	}

	public function get_title() {
		return __( 'Button', 'sakib-addons' );
	}

	public function get_icon() {
		return 'eicon-button';
	}

	public function get_categories() {
		return [ 'sakib' ];
	}

    public function get_keywords()
    {
        return ['btn', 'button', 'link', 'widgetkit'];
    }

	protected function _register_controls() {

		$this->start_controls_section('content_section',
			[
				'label' => __( 'Butoon', 'sakib-addons' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control('button_text',
			[
				'label' => __( 'Button Text', 'sakib-addons' ),
				'type' => Controls_Manager::TEXT,
                'dynamic'    => [ 'active' => true ],
				'placeholder' => __( 'Button Text', 'sakib-addons' ),
				'default' => __( 'Awsome Button', 'sakib-addons' ),
				'label_block' => true,
			]
		);

       $this->add_control('sakib_button_link_selection',
        [
            'label'         => __('Link Type', 'sakib-addons'),
            'type'          => Controls_Manager::SELECT,
            'options'       => [
                'url'   => __('URL', 'premium-addons-for-elementor'),
                'link'  => __('Existing Page', 'sakib-addons'),
            ],
            'default'       => 'url',
            'label_block'   => true,
        ]
        );
       $this->add_control('sakib_button_link',
            [
                'label'         => __('Link', 'sakib-addons'),
                'type'          => Controls_Manager::URL,
                'default'       => [
                    'url'   => '#',
                    'is_external' => '',
                ],
                'show_external' => true,
                'placeholder'   => 'https://yourdomin.com/',
                'label_block'   => true,
                'condition'     => [
                    'sakib_button_link_selection' => 'url'
                ]
            ]
        );
        $this->add_control('sakib_button_existing_link',
            [
                'label'         => __('Existing Page', 'sakib-addons'),
                'type'          => Controls_Manager::SELECT2,
                'options'       => sakib_get_all_pages(),
                'condition'     => [
                    'sakib_button_link_selection'     => 'link',
                ],
                'multiple'      => false,
                'separator'     => 'after',
                'label_block'   => true,
            ]
        );

        $this->add_responsive_control('sakib_button_align',
			[
				'label'             => __( 'Alignment', 'sakib-addons' ),
				'type'              => Controls_Manager::CHOOSE,
				'options'           => [
					'left'    => [
						'title' => __( 'Left', 'sakib-addons' ),
						'icon'  => 'fa fa-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'sakib-addons' ),
						'icon'  => 'fa fa-align-center',
					],
					'right' => [
						'title' => __( 'Right', 'sakib-addons' ),
						'icon'  => 'fa fa-align-right',
					],
				],
                'selectors'         => [
                    '{{WRAPPER}} .sb_wraper' => 'text-align: {{VALUE}}',
                ],
				'default' => 'left',
			]
		);
		$this->add_control('sakib_button_size',
        	[
            'label'         => __('Size', 'sakib-addons'),
            'type'          => Controls_Manager::SELECT,
            'default'       => 'lg',
            'options'       => [
                    'sm'        => __('Small', 'sakib-addons'),
                    'md'        => __('Regular', 'sakib-addons'),
                    'lg'        => __('Large', 'sakib-addons'),
                    'ex'        => __('Extra Large', 'sakib-addons'),
                    'block'     => __('Block', 'sakib-addons'),
                ],
            'label_block'   => true,
            'separator'     => 'after',
            ]
        );

        $this->add_control('sakib_icon_switcher',
	        [
	            'label'         => __('Icon', 'sakib-addons'),
	            'type'          => Controls_Manager::SWITCHER,
	            'description'   => __('Enable or disable button icon','sakib-addons'),
	        ]
        );

		$this->add_control(
			'sakib_button_icon',
			[
				'label' => __( 'Icon', 'sakib-addons' ),
				'type' => Controls_Manager::ICONS,
				'label_block' => true,
				'condition'     => [
                    'sakib_icon_switcher'  => 'yes'
                ],
			]
		);
		$this->add_control(
            'sakib_button_icon_position',
            [
                'label' => __( 'Icon Position', 'sakib-addons' ),
                'type' => Controls_Manager::CHOOSE,
                'label_block' => false,
                'options' => [
                    'before' => [
                        'title' => __( 'Before', 'sakib-addons' ),
                        'icon' => 'eicon-h-align-left',
                    ],
                    'after' => [
                        'title' => __( 'After', 'sakib-addons' ),
                        'icon' => 'eicon-h-align-right',
                    ]
                ],
                'toggle' => false,
                'default' => 'after',
                'condition' => [
                    'sakib_icon_switcher' => 'yes',
                    'sakib_button_icon!' => ''
                ]
            ]
        );

        $this->add_control(
			'button_css_id',
			[
				'label' => __( 'Button ID', 'sakib-addons' ),
				'type' => Controls_Manager::TEXT,
				'default' => '',
				'title' => __( 'Add your custom id WITHOUT the Pound key. e.g: my-id', 'sakib-addons' ),
				'label_block' => false,
				'description' => __( 'Please make sure the ID is unique and not used elsewhere on the page this form is displayed. This field allows <code>A-z 0-9</code> & underscore chars without spaces.', 'themepaw-companion' ),
				'separator' => 'before',

			]
		);
		$this->end_controls_section();
		// End Content Section




		/*
		*Button Icon Style
		*/
		$this->start_controls_section(
            'icon_style',
            [
                'label' => __('Icon', 'sakib-addons'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'sakib_icon_switcher' => 'yes',
                ]
            ]
        );
        $this->add_control(
            'icon_size',
            [
                'label' => __('Icon Size', 'sakib-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', '%'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .sakib-btn-cion i' => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .sakib-btn-cion svg' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'icon_gap',
            [
                'label' => __('Icon gap', 'sakib-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', '%'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .sakib-btn-cion .icon-before' => 'margin-right: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .sakib-btn-cion .icon-after ' => 'margin-left: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        //icon hover

        //btn normal hover style
        $this->start_controls_tabs(
            'icon_style_tabs'
        );
        // normal
        $this->start_controls_tab(
            'icon_normal',
            [
                'label' => __('Normal', 'sakib-addons'),
            ]
        );

        $this->add_control(
            'icon_color',
            [
                'label' => __('Icon Color', 'sakib-addons'),
                'type' => Controls_Manager::COLOR,
                'default' => '#fff',
                'selectors' => [
                    '{{WRAPPER}} .sakib-btn-cion i' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .sakib-btn-cion path' => 'fill: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'icon_stroke_color',
            [
                'label' => __('Icon Stroke Color', 'sakib-addons'),
                'type' => Controls_Manager::COLOR,
                'default' => '#fff',
                'selectors' => [
                    '{{WRAPPER}} .sakib-btn-cion i' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .sakib-btn-cion path' => 'stroke: {{VALUE}}',
                ],
            ]
        );


        $this->end_controls_tab();

        // hover
        $this->start_controls_tab(
            'icon_hover',
            [
                'label' => __('Hover', 'sakib-addons'),
            ]
        );

        $this->add_control(
            'hover_icon_color',
            [
                'label' => __('Icon Color', 'sakib-addons'),
                'type' => Controls_Manager::COLOR,
                'default' => '#fff',
                'selectors' => [
                    '{{WRAPPER}} .sakib-button:hover i' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .sakib-button:hover path' => 'fill: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'hover_icon_color_stock_hover',
            [
                'label' => __('Icon Stroke Color', 'sakib-addons'),
                'type' => Controls_Manager::COLOR,
                'default' => '#fff',
                'selectors' => [
                    '{{WRAPPER}} .sakib-button:hover' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .sakib-button:hover path' => 'stroke: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

		/*
		*Button Style
		*/
		$this->start_controls_section('style_section',
			[
				'label' => __( 'Button Style', 'sakib-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]

		);
        $this->add_control('button_gradient_background',
	        [
	            'label'         => __('Gradient Opction', 'sakib-addons'),
	            'type'          => Controls_Manager::SWITCHER,
	            'description'   => __('Use Gradient Background','sakib-addons'),
	        ]
        );
		$this->start_controls_tabs('button_style_tabs');

		//Button Tab Normal Start
		$this->start_controls_tab('style_normal_tab',
			[
				'label' => __( 'Normal', 'sakib-addons' ),
			]
		);
		$this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'              => 'sakib_button_typo_normal',
                'scheme'            => Scheme_Typography::TYPOGRAPHY_1,
                'selector'          => '{{WRAPPER}} .sakib-button',

            ]
        );
		$this->add_control(
			'color',
			[
				'label' => __( 'Text Color', 'sakib-addons' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#1D263A',
				'selectors' => [
					'{{WRAPPER}} .sakib-button' => 'color: {{VALUE}}',
				],

			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'sakib_button_gradient_background_normal',
				'types' => [ 'gradient', 'classic' ],
				'selector' => '{{WRAPPER}} .sakib-button',
				'condition' => [
					'button_gradient_background' => 'yes'
				],
			]
		);
		$this->add_control(
			'background_color',
			[
				'label' => __( 'Background', 'sakib-addons' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#FFCD28',
				'selectors' => [
					'{{WRAPPER}} .sakib-button,
					 {{WRAPPER}} .sakib-button.sakib-button-style2-shutinhor:before,
					 {{WRAPPER}} .sakib-button.sakib-button-style2-shutinver:before,
					 {{WRAPPER}} .sakib-button.sakib-button-style3-radialin:before,
					 {{WRAPPER}} .sakib-button.sakib-button-style3-rectin:before'   => 'background-color: {{VALUE}}',
				],
				'condition' => [
					'button_gradient_background!' => 'yes'
				],
			]
		);
        $this->add_group_control(
			Group_Control_Box_Shadow::get_type(),[
				'name' => 'button_box_shadow',
				'label' => __( 'Box Shadow', 'sakib-addons' ),
				'selector' => '{{WRAPPER}} .sakib-button',
			]
		);
		$this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'          => 'border_normal',
                'selector'      => '{{WRAPPER}} .sakib-button',
            ]

        );
        $this->add_control('border_radius_normal',
            [
                'label'         => __('Border Radius', 'sakib-addons'),
                'type'          => Controls_Manager::DIMENSIONS,
                'separator' => 'before',
                'size_units'    => ['px', '%' ,'em'],
                'selectors'     => [
                    '{{WRAPPER}} .sakib-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );
		$this->add_responsive_control('padding',
			[
				'label' => __( 'Padding', 'sakib-addons' ),
				'type' => Controls_Manager::DIMENSIONS,
				'label_block' => true,
				'size_units'    => ['px', 'em', '%'],
	            'selectors'     => [
	                '{{WRAPPER}} .sakib-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	            ]

			]
		);
		$this->add_responsive_control('margin',
			[
				'label' => __( 'Margin', 'sakib-addons' ),
				'type' => Controls_Manager::DIMENSIONS,
				'label_block' => true,
				'size_units'    => ['px', 'em', '%'],
	            'selectors'     => [
	                '{{WRAPPER}} .sakib-button' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
	            ]

			]
		);
		$this->end_controls_tab();
		// Button Tab Normal End

		//Button Tab Hover Start
		$this->start_controls_tab('style_hover_tab',
			[
				'label' => __( 'Hover', 'sakib-addons' ),
			]
		);


		$this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'              => 'sakib_button_typo_hover',
                'scheme'            => Scheme_Typography::TYPOGRAPHY_1,
                'selector'          => '{{WRAPPER}} .sakib-button:hover',

            ]
        );
		$this->add_control(
			'hover_color',
			[
				'label' => __( 'Text Color', 'sakib-addons' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#fff',
				'selectors' => [
					'{{WRAPPER}} .sakib-button:hover' => 'color: {{VALUE}}',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'sakib_button_gradient_background_hover',
				'types' => [ 'gradient', 'classic' ],
				'selector' => '{{WRAPPER}} .sakib-button:hover',
				'condition' => [
					'button_gradient_background' => 'yes'
				],
			]
		);
		$this->add_control(
			'background_hover_color',
			[
				'label' => __( 'Background', 'sakib-addons' ),
				'type' => Controls_Manager::COLOR,
				'scheme'            => [
                    'type'  => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_3
                ],
				'default' => '#222831',
				'selectors' => ['
					{{WRAPPER}} .sakib-button-none:hover,
					{{WRAPPER}} .sakib-button-style1-top:before,
					{{WRAPPER}} .sakib-button-style1-right:before,
					{{WRAPPER}} .sakib-button-style1-bottom:before,
					{{WRAPPER}} .sakib-button-style1-left:before,
					{{WRAPPER}} .sakib-button-style2-shutouthor:before,
					{{WRAPPER}} .sakib-button-style2-shutoutver:before,
					{{WRAPPER}} .sakib-button-style2-shutinhor,
					{{WRAPPER}} .sakib-button-style2-shutinver,
					{{WRAPPER}} .sakib-button-style2-dshutinhor:before,
					{{WRAPPER}} .sakib-button-style2-dshutinver:before,
					{{WRAPPER}} .sakib-button-style2-scshutouthor:before,
					{{WRAPPER}} .sakib-button-style2-scshutoutver:before,
					{{WRAPPER}} .sakib-button-style3-radialin,
					{{WRAPPER}} .sakib-button-style3-radialout:before,
					{{WRAPPER}} .sakib-button-style3-rectin:before,
					{{WRAPPER}} .sakib-button-style3-rectout:before' => 'background-color: {{VALUE}}',
				],
				'condition' => [
					'button_gradient_background!' => 'yes'
				],
			]
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'button_box_shadow_hover',
				'selector' => '{{WRAPPER}} .sakib-button:hover',
			]
		);
		$this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'          => 'border_hover',
                'selector'      => '{{WRAPPER}} .sakib-button:hover',
            ]
        );


        //Animation Hover
        $this->add_control('sakib_button_hover_effect',
            [
                'label'         => __('Hover Effect', 'sakib-addons'),
                'type'          => Controls_Manager::SELECT,
                'default'       => 'none',
                'options'       => [
                    'none'          => __('None', 'sakib-addons'),
                    'style1'        => __('Slide', 'sakib-addons'),
                    'style2'        => __('Shutter', 'sakib-addons'),
                    'style3'        => __('In & Out', 'sakib-addons'),
                ],
                'label_block'   => true,
            ]
        );
		$this->add_control('sakib_button_style1_dir',
        [
            'label'         => __('Slide Direction', 'sakib-addons'),
            'type'          => Controls_Manager::SELECT,
            'default'       => 'bottom',
            'options'       => [
                'bottom'       => __('Top to Bottom', 'sakib-addons'),
                'top'          => __('Bottom to Top', 'sakib-addons'),
                'left'         => __('Right to Left', 'sakib-addons'),
                'right'        => __('Left to Right', 'sakib-addons'),
            ],
            'condition'     => [
                'sakib_button_hover_effect' => 'style1',
            ],
            'label_block'   => true,
            ]
        );
		$this->add_control('sakib_button_style2_dir',
        [
            'label'         => __('Shutter Direction', 'sakib-addons'),
            'type'          => Controls_Manager::SELECT,
            'default'       => 'shutouthor',
            'options'       => [
                'shutinhor'     => __('Shutter in Horizontal', 'sakib-addons'),
                'shutinver'     => __('Shutter in Vertical', 'sakib-addons'),
                'shutoutver'    => __('Shutter out Horizontal', 'sakib-addons'),
                'shutouthor'    => __('Shutter out Vertical', 'sakib-addons'),
                'scshutoutver'  => __('Scaled Shutter Vertical', 'sakib-addons'),
                'scshutouthor'  => __('Scaled Shutter Horizontal', 'sakib-addons'),
                'dshutinver'   => __('Tilted Left'),
                'dshutinhor'   => __('Tilted Right'),
            ],
            'condition'     => [
                'sakib_button_hover_effect' => 'style2',
            ],
            'label_block'   => true,
            ]
        );
		$this->end_controls_tabs();
		$this->end_controls_tab();
		$this->end_controls_section();

	}
	protected function render() {
		$settings = $this->get_settings_for_display();
		//Button Text And Style
		$button_text = $settings['button_text'];
		$button_size = 'sakib-button-' . $settings['sakib_button_size'];
		$button_hover = $settings['sakib_button_hover_effect'];

		//Button Hover Effect
		if ($button_hover == 'none') {
			$button_hover_style = 'sakib-button-none';
		}elseif($button_hover == 'style1'){
			$button_hover_style = 'sakib-button-style1-' . $settings['sakib_button_style1_dir'];
		}elseif ($button_hover == 'style2') {
			$button_hover_style = 'sakib-button-style2-' . $settings['sakib_button_style2_dir'];
		}elseif ($button_hover == 'style3') {
			$button_hover_style = 'sakib-button-style3-' . $settings['sakib_button_style3_dir'];
		}

		//Butoon ID
		if ( ! empty( $settings['button_css_id'] ) ) {
			$this->add_render_attribute( 'sakib_button', 'id', $settings['button_css_id'] );
		}

        if( $settings['sakib_button_link_selection'] == 'url' ){
            $button_url = $settings['sakib_button_link']['url'];
        } else {
            $button_url = get_permalink( $settings['sakib_button_existing_link'] );
        }
		//Button Class Href
		$this->add_render_attribute( 'sakib_button', [
			'class'	=> ['sakib-button', esc_attr($button_size), esc_attr($button_hover_style) ],
			'href'	=> esc_attr($button_url),
		]);


		if( $settings['sakib_button_link']['is_external'] ) {
			$this->add_render_attribute( 'sakib_button', 'target', '_blank' );
		}
		if( $settings['sakib_button_link']['nofollow'] ) {
			$this->add_render_attribute( 'sakib_button', 'rel', 'nofollow');
		}

		$this->add_render_attribute( 'sakib_button', 'data-text', esc_attr($settings['button_text'] ));

		?>
		<div  class="sb_wraper">
			<a  <?php echo $this->get_render_attribute_string( 'sakib_button' ); ?>>

			 	<?php if ( $settings['sakib_button_icon_position'] == 'before' && !empty($settings['sakib_button_icon']['value']) ) : ?>
					<span class="sakib-btn-cion icon-before"><?php Icons_Manager::render_icon($settings['sakib_button_icon'], ['aria-hidden' => 'true']) ?></span>
                <?php endif; ?>

				<span><?php echo esc_html($button_text) ?></span>

				<?php if ( $settings['sakib_button_icon_position'] === 'after' && !empty($settings['sakib_button_icon']['value'])) : ?>
                    <span class="sakib-btn-cion icon-after"><?php Icons_Manager::render_icon($settings['sakib_button_icon'], ['aria-hidden' => 'true']) ?></span>
                <?php endif; ?>
			</a>
		</div>
		<?php
	}
}
$widgets_manager->register_widget_type( new \Sakib\Widgets\Elementor\Sakib_Button() );