<?php

namespace CocoBasicElements\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\utils;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class coco_blog extends Widget_Base {

    public function get_name() {
        return 'coco-blog';
    }

    public function get_title() {
        return esc_attr__('Latest Posts', 'cocobasic-elementor');
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
                'num', [
            'label' => esc_attr__('Number of items to show', 'cocobasic-elementor'),
            'type' => Controls_Manager::TEXT,
            'label_block' => true,
            'default' => esc_attr__('5', 'cocobasic-elementor'),
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
                'line_color', [
            'label' => esc_attr__('Line Separator Color', 'cocobasic-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .home-blog-list > li + li' => 'border-color: {{VALUE}};',
            ],
                ]
        );

        $this->add_control(
                'title_color', [
            'label' => esc_attr__('Title color', 'cocobasic-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .home-blog-list li h4 a' => 'color: {{VALUE}};',
            ],
                ]
        );

        $this->add_group_control(
                Group_Control_Typography::get_type(), [
            'name' => 'title_typography',
            'label' => esc_attr__('Title Typography', 'cocobasic-elementor'),
            'selector' => '{{WRAPPER}} .home-blog-list li h4 a',
                ]
        );

        $this->add_control(
                'date_color', [
            'label' => esc_attr__('Date color', 'cocobasic-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .blog-list-info .entry-date' => 'color: {{VALUE}};',                
            ],
                ]
        );

        $this->add_group_control(
                Group_Control_Typography::get_type(), [
            'name' => 'date_typography',
            'label' => esc_attr__('Date Typography', 'cocobasic-elementor'),
            'selector' => '{{WRAPPER}} .blog-list-info .entry-date',
                ]
        );
   
        $this->add_control(
                'category_color', [
            'label' => esc_attr__('Category color', 'cocobasic-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} ul.cat-links a' => 'color: {{VALUE}};',                
            ],
                ]
        );

        $this->add_group_control(
                Group_Control_Typography::get_type(), [
            'name' => 'category_typography',
            'label' => esc_attr__('Category Typography', 'cocobasic-elementor'),
            'selector' => '{{WRAPPER}} ul.cat-links a',
                ]
        );

        $this->end_controls_section();

    }

    protected function render() {
        $settings = $this->get_settings();
        require dirname(__FILE__) . '/view.php';
    }

}

$widgets_manager->register_widget_type(new \CocoBasicElements\Widgets\coco_blog());
