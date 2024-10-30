<?php

/**
 * Plugin Name: Hedomi Filterable List
 * Description: The Elementor addon to create the cool filterable list with links, texts and titles.
 * Plugin URI:  https://wordpresstuts.com.br/plugin-filterable-list/
 * Version:     1.0.0
 * Author:      Hedomi
 * Author URI:  https://wordpresstuts.com.br
 * Text Domain: elementor-hefl
 * 
 *
 * Elementor tested up to:  3.7.8
 * Elementor Pro tested up to: 3.7.1
 */

if (!defined('ABSPATH')) {
  exit; // Exit if accessed directly.
}
require_once (plugin_dir_path(__FILE__)) . 'includes/tgm/required-plugins.php';

if (!function_exists('hefl_elementor')) {
  function hefl_elementor()
  {
    require_once(__DIR__ . '/includes/plugin.php');
  }
}
/**
 * Register Hedomi Filterable List Widget.
 *
 * Include widget file and register widget class.
 *
 * @since 1.0.0
 * @param \Elementor\Widgets_Manager $widgets_manager Elementor widgets manager.
 * @return void
 */

if (!function_exists('hefl_register_filterable_list')) {
  function hefl_register_filterable_list($widgets_manager)
  {

    require_once(__DIR__ . '/includes/widgets/hedomi-filterable-list-widget.php');


    $widgets_manager->register(new \Hedomi_Filterable_List_Widget());
  }
}
add_action('elementor/widgets/register', 'hefl_register_filterable_list');
if (!function_exists('hefl_add_elementor_widget_categories')) {
  function hefl_add_elementor_widget_categories($elements_manager)
  {

    $elements_manager->add_category(
      'hedomi',
      [
        'title' => esc_html__('hedomi', 'textdomain'),
        'icon' => 'fa fa-plug',
      ]
    );
  }
}


add_action('elementor/elements/categories_registered', 'hefl_add_elementor_widget_categories');
add_action('plugins_loaded', 'hefl_elementor');
