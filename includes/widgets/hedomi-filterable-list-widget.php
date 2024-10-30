<?php
if (!defined('ABSPATH')) {
  exit; // Exit if accessed directly.
}

/**
 * Elementor oEmbed Widget.
 *
 * Elementor widget that inserts an embbedable content into the page, from any given URL.
 *
 * @since 1.0.0
 */
class Hedomi_Filterable_List_Widget extends \Elementor\Widget_Base
{

  public function __construct($data = [], $args = null)
  {
    parent::__construct($data, $args);
    wp_register_script('script-handle-isotop', plugins_url('/assets/js/isotope.pkgd.min.js', __FILE__), ['elementor-frontend'], '1.0.0', true);
    wp_register_script('script-handle', plugins_url('/assets/js/main.js', __FILE__), ['elementor-frontend'], '1.0.0', true);
    wp_register_style('style-handle', plugins_url('/assets/css/main.css', __FILE__),);
  }


  public function get_script_depends()
  {
    return ['script-handle-isotop', 'script-handle'];
  }
  public function get_style_depends()
  {
    return ['style-handle'];
  }

  /**
   * Get widget name.
   *
   * Retrieve oEmbed widget name.
   *
   * @since 1.0.0
   * @access public
   * @return string Widget name.
   */
  public function get_name()
  {
    return 'hedomi-filterable-gallary';
  }

  /**
   * Get widget title.
   *
   * Retrieve oEmbed widget title.
   *
   * @since 1.0.0
   * @access public
   * @return string Widget title.
   */
  public function get_title()
  {
    return esc_html__('Filterable List', 'elementor-hefl');
  }

  /**
   * Get widget icon.
   *
   * Retrieve oEmbed widget icon.
   *
   * @since 1.0.0
   * @access public
   * @return string Widget icon.
   */
  public function get_icon()
  {
    return 'eicon-posts-group';
  }

  /**
   * Get custom help URL.
   *
   * Retrieve a URL where the user can get more information about the widget.
   *
   * @since 1.0.0
   * @access public
   * @return string Widget help URL.
   */
  public function get_custom_help_url()
  {
    return 'https://developers.elementor.com/docs/widgets/';
  }
  /**
   * Get widget categories.
   *
   * Retrieve the list of categories the oEmbed widget belongs to.
   *
   * @since 1.0.0
   * @access public
   * @return array Widget categories.
   */
  public function get_categories()
  {
    return ['hedomi'];
  }

  /**
   * Get widget keywords.
   *
   * Retrieve the list of keywords the oEmbed widget belongs to.
   *
   * @since 1.0.0
   * @access public
   * @return array Widget keywords.
   */
  public function get_keywords()
  {
    return ['post gallery', 'filter', 'link'];
  }

  /**
   * Register oEmbed widget controls.
   *
   * Add input fields to allow the user to customize the widget settings.
   *
   * @since 1.0.0
   * @access protected
   */
  protected function register_controls()
  {

    $this->start_controls_section(
      'content_section',
      [
        'label' => esc_html__('Elements', 'elementor-hefl'),
        'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
      ]
    );

    $this->add_control(
      'all_title',
      [
        'label' => esc_html__('All title', 'elementor-hefl'),
        'type' => \Elementor\Controls_Manager::TEXT,
        'default' => esc_html__('All', 'elementor-hefl'),
        'placeholder' => esc_html__('All, todos, alles etc.', 'elementor-hefl'),

      ]
    );


    $repeater = new \Elementor\Repeater();

    $repeater->add_control(
      'filter_title',
      [
        'label' => esc_html__('Filter title', 'elementor-hefl'),
        'type' => \Elementor\Controls_Manager::TEXT,
        'default' => 'Filter title',
        'label_block' => true,

      ]
    );

    $repeater->add_control(
      'filter_id',
      [
        'label' => esc_html__('Filer id', 'elementor-hefl'),
        'type' => \Elementor\Controls_Manager::TEXT,
        'default' => 'filter_title',
        'label_block' => true,
      ]
    );

    $this->add_control(
      'list_filters',
      [
        'label' => esc_html__('Filters', 'elementor-hefl'),
        'type' => \Elementor\Controls_Manager::REPEATER,
        'fields' => $repeater->get_controls(),
        'default' => [
          [
            'filter_title' => esc_html__('Filter 1', 'elementor-hefl'),
            'filter_id' => 'filter_id'

          ],
          [
            'filter_title' => esc_html__('Filter 2', 'elementor-hefl'),
            'filter_id' => 'filter_id'
          ],

        ],
        'title_field' => '{{{ filter_title }}}',
      ]
    );

    $repeaterlist = new \Elementor\Repeater();

    $repeaterlist->add_control(
      'list_image',
      [
        'label' => esc_html__('Elemento Image', 'elementor-hefl'),
        'type' => \Elementor\Controls_Manager::MEDIA,
        'default' => [
          'url' => \Elementor\Utils::get_placeholder_image_src(),
        ]
      ],

    );


    $repeaterlist->add_control(
      'list_title',
      [

        'label' => esc_html__('Title', 'elementor-hefl'),
        'type' => \Elementor\Controls_Manager::TEXT,
        'default' => esc_html__("Item's Title", 'elementor-hefl'),
        'label_block' => true,
      ]

    );

    $repeaterlist->add_control(
      'list_content',
      [

        'label' => esc_html__('Content', 'elementor-hefl'),
        'type' => \Elementor\Controls_Manager::TEXTAREA,
        'default' => esc_html__('List Content', 'elementor-hefl'),
        'show_label' => true,
      ]

    );


    $repeaterlist->add_control(
      'list_url',
      [

        'label' => esc_html__('The block URL', 'elementor-hefl'),
        'type' => \Elementor\Controls_Manager::URL,
        'show_label' => true,
      ]

    );

    $repeaterlist->add_control(
      'list_filter',
      [

        'label' => esc_html__('Category filter', 'elementor-hefl'),
        'type' => \Elementor\Controls_Manager::TEXT,
        'default' => esc_html__('filter_title', 'elementor-hefl'),
        'show_label' => true,
      ]

    );

    $this->add_control(
      'list_items',
      [
        'label' => esc_html__('Items', 'elementor-hefl'),
        'type' => \Elementor\Controls_Manager::REPEATER,
        'fields' => $repeaterlist->get_controls(),

        'default' => [
          [
            'list_title' => esc_html__('Case 1', 'elementor-hefl'),
            'list_content' => esc_html__('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque viverra quam a justo imperdiet, et consectetur neque scelerisque. Integer quis odio elit. Donec tristique enim sed erat mattis, pellentesque viverra elit sagittis. Donec a pulvinar velit, vel luctus nunc. ', 'elementor-hefl'),
            'list_filter' => 'filter_id'


          ],
          [
            'list_title' => esc_html__('Case 2', 'elementor-hefl'),
            'list_content' => esc_html__('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque viverra quam a justo imperdiet, et consectetur neque scelerisque. Integer quis odio elit. Donec tristique enim sed erat mattis, pellentesque viverra elit sagittis. Donec a pulvinar velit, vel luctus nunc. ', 'elementor-hefl'),
            'list_filter' => 'filter_id'

          ],

        ],

        'title_field' => '{{{ list_title }}}',
      ]
    );

    $this->end_controls_section();
    /////////////////////////////////////////
    // Tab filters styles
    /////////////////////////////////////////
    $this->start_controls_section(
      'filter_style',
      [
        'label' => esc_html__('Filters', 'elementor-hefl'),
        'tab' => \Elementor\Controls_Manager::TAB_STYLE,
      ]
    );

    $this->add_control(
      'filter_text_color',
      [
        'label' => esc_html__('Filter Text Color', 'elementor-hefl'),
        'type' => \Elementor\Controls_Manager::COLOR,
        'default' => '#2E393A',
        'selectors' => [
          '{{WRAPPER}} .filter__link' => 'color: {{VALUE}}',

        ],


      ]
    );

    $this->add_control(
      'filter_bg_color',
      [
        'label' => esc_html__('Filter Background Color', 'elementor-hefl'),
        'type' => \Elementor\Controls_Manager::COLOR,
        'default' => '#67EDBD',
        'selectors' => [
          '{{WRAPPER}} .filter__item' => 'background-color: {{VALUE}}',
        ],


      ]
    );

    $this->add_group_control(
      \Elementor\Group_Control_Border::get_type(),
      [
        'name' => 'filter-border',
        'selector' => '{{WRAPPER}} .filter__item',
        'devices' => ['desktop', 'tablet', 'mobile'],
      ]
    );

    $this->add_group_control(
      \Elementor\Group_Control_Typography::get_type(),
      [
        'name' => 'content_typography',
        'selector' => '{{WRAPPER}} .filter__link',

      ]
    );

    $this->add_group_control(
      \Elementor\Group_Control_Box_Shadow::get_type(),
      [
        'name' => 'box_shadow_filter',
        'selector' => '{{WRAPPER}} .filter__item',

      ]
    );


    $this->add_responsive_control(
      'filter-margin',
      [
        'label' => esc_html__('Filter Margin', 'elementor-hefl'),
        'type' => \Elementor\Controls_Manager::DIMENSIONS,
        'size_units' => ['px', '%', 'em', 'custom'],
        'selectors' => [
          '{{WRAPPER}} .filter__item' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',

        ],


      ]
    );

    $this->add_responsive_control(
      'filter-padding',
      [
        'label' => esc_html__('Filter Padding', 'elementor-hefl'),
        'type' => \Elementor\Controls_Manager::DIMENSIONS,
        'size_units' => ['px', '%', 'em', 'custom'],
        'selectors' => [
          '{{WRAPPER}} .filter__item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',

        ],
        'default' => [
          'top' => '3',
          'right' => '12',
          'bottom' => '3',
          'left' => '12',
          'unit' => 'px',
          'isLinked' => '',
        ]

      ]
    );

    $this->add_responsive_control(
      'filter-border-radius',
      [
        'label' => esc_html__('Border radius', 'elementor-hefl'),
        'type' => \Elementor\Controls_Manager::DIMENSIONS,
        'size_units' => ['px', '%', 'em', 'custom'],
        'selectors' => [
          '{{WRAPPER}} .filter__item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',

        ],

      ]
    );

    $this->add_control(
      'active_filter_options',
      [
        'label' => esc_html__('Active Filter', 'elementor-hefl'),
        'type' => \Elementor\Controls_Manager::HEADING,
        'separator' => 'before',
      ]
    );

    $this->add_control(
      'active_filter_color',
      [
        'label' => esc_html__('Filter Color', 'elementor-hefl'),
        'type' => \Elementor\Controls_Manager::COLOR,
        'default' => '#2E393A',
        'selectors' => [
          '{{WRAPPER}} .filter__item--active .filter__link' => 'color: {{VALUE}}',

        ],
      ]
    );

    $this->add_control(
      'active_bg_color',
      [
        'label' => esc_html__('Filter Background Color', 'elementor-hefl'),
        'type' => \Elementor\Controls_Manager::COLOR,
        'default' => '#f8f8f8',
        'selectors' => [
          '{{WRAPPER}} .filter__item--active.filter__item' => 'background-color: {{VALUE}}',


        ],


      ]
    );

    $this->add_group_control(
      \Elementor\Group_Control_Border::get_type(),
      [
        'name' => 'active_filter-border',
        'selector' => '{{WRAPPER}} .filter__item--active',
        'devices' => ['desktop', 'tablet', 'mobile'],
      ]
    );




    $this->end_controls_section();

    ////////////////////////////////////////
    // Tab items styles
    ////////////////////////////////////////

    $this->start_controls_section(
      'items_style',
      [
        'label' => esc_html__('Items', 'elementor-hefl'),
        'tab' => \Elementor\Controls_Manager::TAB_STYLE,
      ]
    );

    $this->add_control(
      'item_bg_color',
      [
        'label' => esc_html__('Item Background Color', 'elementor-hefl'),
        'type' => \Elementor\Controls_Manager::COLOR,
        'default' => '#2E393A',
        'selectors' => [
          '{{WRAPPER}} .items__item' => 'background-color: {{VALUE}}',
        ],

      ]
    );

    $this->add_group_control(
      \Elementor\Group_Control_Border::get_type(),
      [
        'name' => 'item-border',
        'selector' => '{{WRAPPER}} .items__item',
        'devices' => ['desktop', 'tablet', 'mobile'],
      ]
    );

    $this->add_group_control(
      \Elementor\Group_Control_Box_Shadow::get_type(),
      [
        'name' => 'box_shadow_item',
        'selector' => '{{WRAPPER}} .items__item',

      ]
    );

    $this->add_responsive_control(
      'items-padding',
      [
        'label' => esc_html__('Item Padding', 'elementor-hefl'),
        'type' => \Elementor\Controls_Manager::DIMENSIONS,
        'size_units' => ['px', '%', 'em', 'custom'],
        'selectors' => [
          '{{WRAPPER}} .items__item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
        'default' => [
          'top' => '25',
          'right' => '25',
          'bottom' => '25',
          'left' => '25',
          'unit' => 'px',
          'isLinked' => '',
        ]

      ]
    );

    $this->add_responsive_control(
      'items-border-radius',
      [
        'label' => esc_html__('Border radius Item', 'elementor-hefl'),
        'type' => \Elementor\Controls_Manager::DIMENSIONS,
        'size_units' => ['px', '%', 'em', 'custom'],
        'selectors' => [
          '{{WRAPPER}} .items__item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',

        ],

      ]
    );

    $this->add_responsive_control(
      'item-height',
      [
        'label' => esc_html__('Item height', 'elementor-hefl'),
        'type' => \Elementor\Controls_Manager::NUMBER,
        'min' => 50,
        'max' => 1055,
        'step' => 5,
        'default' => 275,
        'selectors' => [
          '{{WRAPPER}} .items__item' => 'height: {{VALUE}}px',
        ],

      ]

    );

    $this->add_responsive_control(
      'item-width',
      [
        'label' => esc_html__('Width', 'elementor-hefl'),
        'type' => \Elementor\Controls_Manager::SLIDER,
        'size_units' => ['px', '%'],
        'range' => [
          'px' => [
            'min' => 0,
            'max' => 1000,
            'step' => 5,
          ],
          '%' => [
            'min' => 0,
            'max' => 100,
          ],
        ],
        'default' => [
          'unit' => '%',
          'size' => 32,
        ],
        'selectors' => [
          '{{WRAPPER}} .items__item' => 'width: {{SIZE}}{{UNIT}};',
        ],
      ]
    );

    $this->add_control(
      'apply',
      [
        'label' => esc_html__('Apply changes', 'elementor-hefl'),
        'type' => \Elementor\Controls_Manager::SWITCHER,
        'label_on' => esc_html__('Apply', 'elementor-hefl'),
        'label_off' => esc_html__('Apply', 'elementor-hefl'),
        'return_value' => 'yes',
        'default' => 'yes',

      ]
    );

    $this->add_responsive_control(
      'text_align',
      [
        'label' => esc_html__('Alignment', 'elementor-hefl'),
        'type' => \Elementor\Controls_Manager::CHOOSE,
        'options' => [
          'left' => [
            'title' => esc_html__('Left', 'elementor-hefl'),
            'icon' => 'eicon-text-align-left',
          ],
          'center' => [
            'title' => esc_html__('Center', 'elementor-hefl'),
            'icon' => 'eicon-text-align-center',
          ],
          'right' => [
            'title' => esc_html__('Right', 'elementor-hefl'),
            'icon' => 'eicon-text-align-right',
          ],
        ],
        'default' => 'left',
        'toggle' => true,
        'selectors' => [
          '{{WRAPPER}} .items__title' => 'text-align: {{VALUE}};',
          '{{WRAPPER}} .items__content' => 'text-align: {{VALUE}};',
        ],
      ]
    );

    $this->add_control(
      'show_overlay',
      [
        'label' => esc_html__('Show Dark Overlay', 'elementor-hefl'),
        'type' => \Elementor\Controls_Manager::SWITCHER,
        'label_on' => esc_html__('Show', 'elementor-hefl'),
        'label_off' => esc_html__('Hide', 'elementor-hefl'),
        'return_value' => 'yes',
        'default' => 'yes',
        'condition' => [
          'layout_style' => ['layout1', 'layout2', 'layout3'],
        ],
      ]
    );


    $this->add_control(
      'image_options',
      [
        'label' => esc_html__('Image options', 'elementor-hefl'),
        'type' => \Elementor\Controls_Manager::HEADING,
        'separator' => 'before',
        'condition' => [
          'layout_style' => ['layout4', 'layout5'],
        ],
      ]
    );

    $this->add_responsive_control(
      'image-height',
      [
        'label' => esc_html__('Image height', 'elementor-hefl'),
        'type' => \Elementor\Controls_Manager::NUMBER,
        'min' => 50,
        'max' => 1055,
        'step' => 5,
        'default' => 50,
        'selectors' => [
          '{{WRAPPER}} .layout4-image' => 'height: {{VALUE}}px',
          '{{WRAPPER}} .layout5-image' => 'height: {{VALUE}}px',
        ],
        'condition' => [
          'layout_style' => ['layout4', 'layout5'],
        ],

      ]

    );

    $this->add_control(
      'image-width',
      [
        'label' => esc_html__('Image Width', 'elementor-hefl'),
        'type' => \Elementor\Controls_Manager::SLIDER,
        'size_units' => ['px', '%', 'custom'],
        'range' => [
          'px' => [
            'min' => 0,
            'max' => 1000,
            'step' => 5,
          ],
          '%' => [
            'min' => 0,
            'max' => 100,
          ],
        ],
        'default' => [
          'unit' => 'px',
          'size' => 50,
        ],
        'selectors' => [
          '{{WRAPPER}} .layout4-image' => 'width: {{SIZE}}{{UNIT}};',
          '{{WRAPPER}} .layout5-image' => 'width: {{SIZE}}{{UNIT}};',
        ],
        'condition' => [
          'layout_style' => ['layout4', 'layout5'],
        ],
      ]
    );

    $this->add_responsive_control(
      'image-border-radius',
      [
        'label' => esc_html__('Border radius Item', 'elementor-hefl'),
        'type' => \Elementor\Controls_Manager::DIMENSIONS,
        'size_units' => ['px', '%', 'em', 'custom'],
        'selectors' => [
          '{{WRAPPER}} .layout5-image' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
          '{{WRAPPER}} .layout4-image' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
        'condition' => [
          'layout_style' => ['layout4', 'layout5'],
        ],

      ]
    );

    $this->add_control(
      'text_title_options',
      [
        'label' => esc_html__('Title options', 'elementor-hefl'),
        'type' => \Elementor\Controls_Manager::HEADING,
        'separator' => 'before',
      ]
    );

    $this->add_control(
      'items_title_color',
      [
        'label' => esc_html__('Item Title Color', 'elementor-hefl'),
        'type' => \Elementor\Controls_Manager::COLOR,
        'default' => '#2E393A',
        'selectors' => [
          '{{WRAPPER}} .items__title' => 'color: {{VALUE}}',
          '{{WRAPPER}} .hfg-deliner' => 'background-color: {{VALUE}}',
          '{{WRAPPER}} .hfg-flex' => 'color: {{VALUE}}',
          '{{WRAPPER}} .hfg-flex a' => 'color: {{VALUE}}',
          '{{WRAPPER}} .layout5-btn' => 'color: {{VALUE}}',

        ],
      ]
    );


    $this->add_group_control(
      \Elementor\Group_Control_Typography::get_type(),
      [
        'name' => 'items_typography',
        'selector' => '{{WRAPPER}} .items__title',
        'label' => esc_html__('Title Typography', 'elementor-hefl'),
      ]
    );



    $this->add_control(
      'text_content_options',
      [
        'label' => esc_html__('Text content options', 'elementor-hefl'),
        'type' => \Elementor\Controls_Manager::HEADING,
        'separator' => 'before',
      ]
    );

    $this->add_control(
      'items_text_color',
      [
        'label' => esc_html__('Item Text Content Color', 'elementor-hefl'),
        'type' => \Elementor\Controls_Manager::COLOR,
        'default' => '#2E393A',
        'selectors' => [
          '{{WRAPPER}} .items__content' => 'color: {{VALUE}}',
        ],
      ]
    );

    $this->add_group_control(
      \Elementor\Group_Control_Typography::get_type(),
      [
        'name' => 'content_text_typography',
        'selector' => '{{WRAPPER}} .items__content',
        'label' => esc_html__('Content Typography', 'elementor-hefl'),
      ]
    );

    $this->end_controls_section();



    $this->start_controls_section(
      'items_layout',
      [
        'label' => esc_html__('Layouts', 'elementor-hefl'),
        'tab' => \Elementor\Controls_Manager::TAB_STYLE,
      ]
    );


    $this->add_control(
      'layout_style',
      [
        'label' => esc_html__('Choose the layout', 'elementor-hefl'),
        'type' => \Elementor\Controls_Manager::SELECT,
        'default' => 'layout1',
        'options' => [
          'layout1' => esc_html__('Layout1', 'elementor-hefl'),
          'layout2' => esc_html__('Layout2', 'elementor-hefl'),
          'layout3'  => esc_html__('Layout3', 'elementor-hefl'),
          'layout4' => esc_html__('Layout4', 'elementor-hefl'),
          'layout5' => esc_html__('Layout5', 'elementor-hefl'),
        ],
      ]
    );

    $this->end_controls_section();
  }

  /**
   * Render oEmbed widget output on the frontend.
   *
   * Written in PHP and used to generate the final HTML.
   *
   * @since 1.0.0
   * @access protected
   */
  protected function render()
  {

    $settings = $this->get_settings_for_display();

    if ($settings['list_filters']) {

      echo '<div class="filter-list">';
      if ($settings['all_title']) :
        echo '<div class="filter__item filter__item--active"><a href=""  data-filter="items__item" class="filter__link">' . esc_attr($settings['all_title']) . '</a></div>';
      endif;

      foreach ($settings['list_filters'] as $item) { ?>

        <div class="filter__item">
          <a href="" data-filter="<?php echo esc_attr($item['filter_id']); ?>" class="filter__link"><?php echo esc_attr($item['filter_title']); ?></a>
        </div>

        <?php
      }
      echo '</div>';

      if ('yes' === $settings['show_overlay']) {
        $itemoverlay = 'show_overlay';
      } else {
        $itemoverlay = '';
      }

      if ($settings['layout_style'] == 'layout4') {
        echo '<div class="items__list">';
        foreach ($settings['list_items'] as $item) {
          if ($item['list_url']['url']) : ?>
            <a href="<?php echo esc_attr($item['list_url']['url']); ?>" class="items__item <?php echo esc_attr($item['list_filter']); ?>" target="_blank">
            <?php else : ?>
              <div class="items__item <?php echo esc_attr($item['list_filter']); ?>">
              <?php endif; ?>
              <img src="<?php echo esc_attr($item['list_image']['url']); ?>" alt="<?php echo esc_attr($item['list_image']['alt']); ?>" class="layout4-image" />
              <p class="items__title"><?php echo esc_attr($item['list_title']); ?></p>
              <p class="items__content"><?php echo esc_attr($item['list_content']); ?></p>

              <?php if (esc_attr($item['list_url']['url'])) : ?>
            </a>
          <?php else : ?>
            </div>
          <?php endif;
            }
            echo '</div>';
          } else if ($settings['layout_style'] == 'layout5') {
            echo '<div class="items__list">';
            foreach ($settings['list_items'] as $item) {
              if ($item['list_url']['url']) : ?>
            <a href="<?php echo esc_attr($item['list_url']['url']); ?>" class="items__item <?php echo esc_attr($item['list_filter']); ?>" target="_blank">
            <?php else : ?>
              <div class="items__item <?php echo esc_attr($item['list_filter']); ?>">
              <?php endif; ?>
              <div class="layout5-flex">
                <img src="<?php echo esc_attr($item['list_image']['url']); ?>" alt="<?php echo esc_attr($item['list_image']['alt']); ?>" class="layout5-image" />
                <p class="items__title"><?php echo esc_attr($item['list_title']); ?></p>
              </div>
              <p class="items__content"><?php echo esc_attr($item['list_content']); ?></p>

              <?php if (esc_attr($item['list_url']['url'])) : ?>
            </a>
          <?php else : ?>
            </div>
          <?php endif;
            }
            echo '</div>';
          } else {
            echo '<div class="items__list">';
            foreach ($settings['list_items'] as $item) {
              if ($item['list_url']['url']) : ?>
            <a href="<?php echo esc_attr($item['list_url']['url']); ?>" class="items__item <?php echo esc_attr($item['list_filter']) . ' ' . esc_attr($settings['layout_style']); ?> <?php echo ' ' . esc_attr($itemoverlay); ?>" style="background-image:url('<?php echo esc_attr($item['list_image']['url']); ?>')" target="_blank">

            <?php else : ?>
              <div class="items__item <?php echo esc_attr($item['list_filter']) . ' ' . esc_attr($settings['layout_style']); ?> <?php echo ' ' . esc_attr($itemoverlay); ?>" style="background-image:url('<?php echo esc_attr($item['list_image']['url']); ?>')" target="_blank">
              <?php endif; ?>
              <p class="items__title"><?php echo esc_attr($item['list_title']); ?></p>
              <?php if ($settings['layout_style'] == 'layout2') : ?>
                <div class="hfg-deliner <?php echo esc_attr($settings['text_align']); ?>"></div>
              <?php endif; ?>
              <?php if ($settings['layout_style'] == 'layout3') :
                if ($item['list_url']['url']) :
                  echo '<div class="hfg-flex">' . esc_attr($item['list_url']['url']) . ' <svg className="w-6 h-6" fill="none" stroke="currentColor" width="20" height="20" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" /></svg></div>';
                endif; ?>
              <?php endif; ?>
              <p class="items__content"><?php echo esc_attr($item['list_content']); ?></p>
              <?php if ($item['list_url']['url']) : ?>
            </a>
          <?php else : ?>
            </div>
          <?php endif; ?>
<?php
            }
            echo '</div>';
          }
        }
      }
    }
