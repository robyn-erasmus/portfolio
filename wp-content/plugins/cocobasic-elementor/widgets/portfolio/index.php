<?php

namespace CocoBasicElements\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\utils;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class coco_portfolio extends Widget_Base {

    public function get_name() {
        return 'coco-portfolio';
    }

    public function get_title() {
        return esc_attr__('Portfolio', 'cocobasic-elementor');
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
            'label' => esc_attr__('Number of items to show before "Load More"', 'cocobasic-elementor'),
            'type' => Controls_Manager::TEXT,
            'label_block' => true,
            'default' => esc_attr__('4', 'cocobasic-elementor'),
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
                'overlay_color', [
            'label' => esc_attr__('Item overlay color', 'cocobasic-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .portfolio-text-holder' => 'background-color: {{VALUE}};',
            ],
                ]
        );

        $this->add_control(
                'title_color', [
            'label' => esc_attr__('Title color', 'cocobasic-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .portfolio-text' => 'color: {{VALUE}};',
            ],
                ]
        );

        $this->add_group_control(
                Group_Control_Typography::get_type(), [
            'name' => 'title_typography',
            'label' => esc_attr__('Text Typography', 'cocobasic-elementor'),
            'selector' => '{{WRAPPER}} .portfolio-text',
                ]
        );

        $this->add_control(
                'category_color', [
            'label' => esc_attr__('Category color', 'cocobasic-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .portfolio-cat' => 'color: {{VALUE}};',
                '{{WRAPPER}} .portfolio-cat:before' => 'background-color: {{VALUE}};',
            ],
                ]
        );

        $this->add_group_control(
                Group_Control_Typography::get_type(), [
            'name' => 'category_typography',
            'label' => esc_attr__('Category Typography', 'cocobasic-elementor'),
            'selector' => '{{WRAPPER}} .portfolio-cat',
                ]
        );

        $this->end_controls_section();


        $this->start_controls_section(
                'section_loadmore_button', [
            'label' => esc_attr__('Load More Button', 'cocobasic-elementor'),
            'tab' => Controls_Manager::TAB_STYLE,
                ]
        );

        $this->add_control(
                'loadmore_text', [
            'label' => esc_attr__('Load More text', 'cocobasic-elementor'),
            'type' => Controls_Manager::TEXT,
            'label_block' => true,
            'default' => 'LOAD MORE',
                ]
        );

        $this->add_control(
                'loadmore_loading_text', [
            'label' => esc_attr__('Loading text', 'cocobasic-elementor'),
            'type' => Controls_Manager::TEXT,
            'label_block' => true,
            'default' => 'LOADING',
                ]
        );

        $this->add_control(
                'loadmore_nomore_text', [
            'label' => esc_attr__('No more text', 'cocobasic-elementor'),
            'type' => Controls_Manager::TEXT,
            'label_block' => true,
            'default' => 'NO MORE',
                ]
        );

        $this->add_control(
                'loadmore_text_color', [
            'label' => esc_attr__('Load more text color', 'cocobasic-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .more-posts-portfolio' => 'color: {{VALUE}};',
                '{{WRAPPER}} .more-posts-portfolio:before' => 'background-color: {{VALUE}};',
                '{{WRAPPER}} .no-more-posts-portfolio' => 'color: {{VALUE}};',
                '{{WRAPPER}} .more-posts-portfolio-loading' => 'color: {{VALUE}};',                
            ],
                ]
        );

        $this->add_control(
                'loadmore_text_hover_color', [
            'label' => esc_attr__('Load more text hover color', 'cocobasic-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .more-posts-portfolio:hover' => 'color: {{VALUE}};',
            ],
                ]
        );

        $this->add_group_control(
                Group_Control_Typography::get_type(), [
            'name' => 'loadmore_text_typography',
            'label' => esc_attr__('Load More Typography', 'cocobasic-elementor'),
            'selector' => 
                '{{WRAPPER}} .more-posts-portfolio',
                '{{WRAPPER}} .no-more-posts-portfolio',
                '{{WRAPPER}} .more-posts-portfolio-loading',            
                ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings();
        require dirname(__FILE__) . '/view.php';
    }

}

$widgets_manager->register_widget_type(new \CocoBasicElements\Widgets\coco_portfolio());
