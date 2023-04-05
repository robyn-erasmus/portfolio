<?php

namespace CocoBasicElements\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\utils;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class coco_skills_lines extends Widget_Base {

    public function get_name() {
        return 'coco-skills-lines';
    }

    public function get_title() {
        return esc_attr__('Skills Lines', 'cocobasic-elementor');
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

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
                'title', [
            'label' => esc_attr__('Title', 'cocobasic-elementor'),
            'type' => Controls_Manager::TEXT,
            'label_block' => true,
            'default' => esc_attr__('Design', 'cocobasic-elementor'),
                ]
        );

        $repeater->add_control(
                'value', [
            'label' => esc_attr__('Percent', 'cocobasic-elementor'),
            'type' => Controls_Manager::TEXT,
            'label_block' => true,
            'default' => esc_attr__('57%', 'cocobasic-elementor'),
                ]
        );

        $this->add_control(
                'items', [
            'type' => Controls_Manager::REPEATER,
            'fields' => $repeater->get_controls(),
            'prevent_empty' => false,
            'default' => [
                [
                    'title' => esc_attr__('Design', 'cocobasic-elementor'),
                ]
            ],
            'title_field' => '{{{ title }}}',
                ]
        );

        $this->end_controls_section();


        $this->start_controls_section(
                'section_general', [
            'label' => esc_attr__('General', 'cocobasic-elementor'),
            'tab' => Controls_Manager::TAB_STYLE,
                ]
        );
       
        $this->add_group_control(
                Group_Control_Typography::get_type(), [
            'name' => 'title_typography',
            'label' => esc_attr__('Text Typography', 'cocobasic-elementor'),
            'selector' => '{{WRAPPER}} .skill-text',
                ]
        );

        $this->add_control(
                'text_color', [
            'label' => esc_attr__('Text color', 'cocobasic-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .skill-text' => 'color: {{VALUE}};',
            ],
                ]
        );

        $this->add_control(
                'fill_color', [
            'label' => esc_attr__('Fill color', 'cocobasic-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .skill-fill' => 'background-color: {{VALUE}};',
            ],
                ]
        );

        $this->add_control(
                'empty_fill_color', [
            'label' => esc_attr__('Empty fill color', 'cocobasic-elementor'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .skill' => 'background-color: {{VALUE}};',
            ],
                ]
        );
        
        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings();
        require dirname(__FILE__) . '/view.php';
    }

    private function content($content) {
        $out = '';

        foreach ($content as $item) {

            $title = $item['title'] ? $item['title'] : '';
            $value = $item['value'] ? $item['value'] : '50%';

            $out .= '
                <div class="skill-holder">
                        <div class="skill-text">' . $title . '</div>
                        <div class="skill">
                           <div class="skill-fill global-background-color" data-fill="' . $value . '"></div>                                                    
                        </div>                                  
                </div>                
            ';
        }

        return $out;
    }

}

$widgets_manager->register_widget_type(new \CocoBasicElements\Widgets\coco_skills_lines());
