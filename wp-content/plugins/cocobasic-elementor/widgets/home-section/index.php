<?php

namespace CocoBasicElements\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\utils;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class coco_home_section extends Widget_Base {

    public function get_name() {
        return 'coco-home-section';
    }

    public function get_title() {
        return esc_attr__('Home Section', 'cocobasic-elementor');
    }

    public function get_icon() {
        return 'fa fa-th';
    }

    public function get_categories() {
        return array('coco-element');
    }

    protected function register_controls() {

        $this->start_controls_section(
                'section_home_section', [
            'label' => esc_attr__('Content', 'cocobasic-elementor'),
                ]
        );

        $this->add_control(
                'home_text', [
            'label' => esc_attr__('Text', 'cocobasic-elementor'),
            'type' => Controls_Manager::TEXTAREA,
            'label_block' => true,
            'default' => '',
                ]
        );

        $this->add_control(
                'home_text_parallax', [
            'label' => esc_attr__('Text Parallax (Xpx Ypx)', 'cocobasic-elementor'),
            'type' => Controls_Manager::TEXT,
            'label_block' => true,
            'default' => '',
                ]
        );

        $this->add_control(
                'img', [
            'label' => esc_attr__('Image', 'cocobasic-elementor'),
            'type' => Controls_Manager::MEDIA,
            'default' => [
                'url' => Utils::get_placeholder_image_src(),
            ],
            'label_block' => true,
                ]
        );

        $this->add_control(
                'img_parallax', [
            'label' => esc_attr__('Image Parallax (Xpx Ypx)', 'cocobasic-elementor'),
            'type' => Controls_Manager::TEXT,
            'label_block' => true,
            'default' => '',
                ]
        );

        $this->add_control(
                'animation_img', [
            'label' => esc_attr__('Scroll Down Image', 'cocobasic-elementor'),
            'type' => Controls_Manager::MEDIA,
            'default' => [
                'url' => Utils::get_placeholder_image_src(),
            ],
            'label_block' => true,
                ]
        );

        $this->add_control(
                'url', [
            'label' => esc_attr__('Scroll Down Image Link', 'cocobasic-elementor'),
            'type' => Controls_Manager::URL,
            'label_block' => true,
            'placeholder' => esc_html__('http://your-link.com', 'cocobasic-elementor'),
                ]
        );
        
        
        $this->add_responsive_control(
                'url_width', [
            'label' => esc_attr__('Scroll Down Image Width', 'cocobasic-elementor'),
            'type' => Controls_Manager::SLIDER,
            'default' => [
                'unit' => '%',
            ],
            'tablet_default' => [
                'unit' => '%',
            ],
            'mobile_default' => [
                'unit' => '%',
            ],
            'size_units' => [ '%', 'px', 'vw'],
            'range' => [
                '%' => [
                    'min' => 1,
                    'max' => 100,
                ],
                'px' => [
                    'min' => 1,
                    'max' => 500,
                ],
                'vw' => [
                    'min' => 1,
                    'max' => 100,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .main-btn img' => 'width: {{SIZE}}{{UNIT}};'
            ],
                ]
        );

        $this->end_controls_section();


        $this->start_controls_section(
                'section_general', [
            'label' => esc_attr__('General', 'cocobasic-elementor'),
            'tab' => Controls_Manager::TAB_STYLE,
                ]
        );

        $this->add_control(
                'text_color', [
            'label' => esc_attr__('Text Color', 'cocobasic-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .entry-title' => 'color: {{VALUE}};',
            ],
                ]
        );

        $this->add_group_control(
                Group_Control_Typography::get_type(), [
            'name' => 'text_typography',
            'label' => esc_attr__('Text Typography', 'cocobasic-elementor'),
            'selector' => '{{WRAPPER}} .entry-title',
                ]
        );


        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings();
        require dirname(__FILE__) . '/view.php';
    }

}

$widgets_manager->register_widget_type(new \CocoBasicElements\Widgets\coco_home_section());
