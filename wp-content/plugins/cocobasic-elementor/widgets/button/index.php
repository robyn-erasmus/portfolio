<?php

namespace CocoBasicElements\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\utils;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class coco_button extends Widget_Base {

    public function get_name() {
        return 'coco-button';
    }

    public function get_title() {
        return esc_attr__('Coco Button', 'cocobasic-elementor');
    }

    public function get_icon() {
        return 'fa fa-th';
    }

    public function get_categories() {
        return array('coco-element');
    }

    protected function register_controls() {

        $this->start_controls_section(
                'section_process_1', [
            'label' => esc_attr__('Content', 'cocobasic-elementor'),
                ]
        );

        $this->add_control(
                'title', [
            'label' => esc_attr__('Button', 'cocobasic-elementor'),
            'type' => Controls_Manager::TEXT,
            'label_block' => true,
            'default' => esc_attr__('Button', 'cocobasic-elementor'),
                ]
        );

        $this->add_control(
                'url', [
            'label' => esc_attr__('Button Link (optional)', 'cocobasic-elementor'),
            'type' => Controls_Manager::URL,
            'placeholder' => 'http://your-link.com',
            'default' => [
                'url' => '#',
            ],
                ]
        );

        $this->add_responsive_control(
                'text_align', [
            'label' => esc_attr__('Alignment', 'cocobasic-elementor'),
            'type' => \Elementor\Controls_Manager::CHOOSE,
            'options' => [
                'left' => [
                    'title' => esc_attr__('Left', 'cocobasic-elementor'),
                    'icon' => 'fa fa-align-left',
                ],
                'center' => [
                    'title' => esc_attr__('Center', 'cocobasic-elementor'),
                    'icon' => 'fa fa-align-center',
                ],
                'right' => [
                    'title' => esc_attr__('Right', 'cocobasic-elementor'),
                    'icon' => 'fa fa-align-right',
                ],                
            ],
            'default' => '',
            'selectors' => [
                '{{WRAPPER}}' => 'text-align: {{VALUE}};',
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
                '{{WRAPPER}} a.service-link' => 'color: {{VALUE}};',
                '{{WRAPPER}} a.service-link:before' => 'background-color: {{VALUE}};',
            ],
                ]
        );
        
        $this->add_control(
                'text_color_hover', [
            'label' => esc_attr__('Text Hover Color', 'cocobasic-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} a.service-link:hover' => 'color: {{VALUE}};',
            ],
                ]
        );

        $this->add_group_control(
                Group_Control_Typography::get_type(), [
            'name' => 'text_typography',
            'label' => esc_attr__('Text Typography', 'cocobasic-elementor'),
            'selector' => '{{WRAPPER}} a.service-link',
                ]
        );
        
         $this->add_responsive_control(
                'borderwidth', [
            'label' => esc_attr__('Border Height', 'cocobasic-elementor'),
            'type' => Controls_Manager::SLIDER,
            'default' => [
                'unit' => 'px',
            ],
            'tablet_default' => [
                'unit' => 'px',
            ],
            'mobile_default' => [
                'unit' => 'px',
            ],
            'size_units' => [ 'px'],
            'range' => [
                'px' => [
                    'min' => 0,
                    'max' => 100,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} a.service-link:before' => 'height: {{SIZE}}{{UNIT}};',
            ],
                ]
        );


        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings();
        require dirname(__FILE__) . '/view.php';
    }

}

$widgets_manager->register_widget_type(new \CocoBasicElements\Widgets\coco_button());
