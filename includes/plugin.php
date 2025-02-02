<?php
final class hefl_hefl_Plugin
{

  /**
   * Addon Version
   *
   * @since 1.0.0
   * @var string The addon version.
   */
  const VERSION = '1.0.0';

  /**
   * Minimum Elementor Version
   *
   * @since 1.0.0
   * @var string Minimum Elementor version required to run the addon.
   */
  const MINIMUM_ELEMENTOR_VERSION = '3.7.8';

  /**
   * Minimum PHP Version
   *
   * @since 1.0.0
   * @var string Minimum PHP version required to run the addon.
   */
  const MINIMUM_PHP_VERSION = '7.4';

  /**
   * Instance
   *
   * @since 1.0.0
   * @access private
   * @static
   * @var \Hedomi_Filterable_List\hefl_Plugin The single instance of the class.
   */
  private static $_instance = null;

  /**
   * Instance
   *
   * Ensures only one instance of the class is loaded or can be loaded.
   *
   * @since 1.0.0
   * @access public
   * @static
   * @return \Hedomi_Filterable_List\hefl_Plugin An instance of the class.
   */

  public static function instance()
  {

    if (is_null(self::$_instance)) {
      self::$_instance = new self();
    }
    return self::$_instance;
  }
  /**
   * Constructor
   *
   * Perform some compatibility checks to make sure basic requirements are meet.
   * If all compatibility checks pass, initialize the functionality.
   *
   * @since 1.0.0
   * @access public
   */
  public function __construct()
  {
    if ($this->is_compatible()) {
      add_action('elementor/init', [$this, 'init']);
    }
  }


  public function hefl_loaded_textdomain()
  {
    load_plugin_textdomain('elementor-hefl');
  }

  /**
   * Compatibility Checks
   *
   * Checks whether the site meets the addon requirement.
   *
   * @since 1.0.0
   * @access public
   */
  public function is_compatible()
  {

    // Check if Elementor installed and activated
    if (did_action('elementor/loaded')) {
      add_action('admin_notices', [$this, 'admin_notice_missing_main_plugin']);
      return false;
    }

    // Check for required Elementor version
    if (!version_compare(ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '>=')) {
      add_action('admin_notices', [$this, 'admin_notice_minimum_elementor_version']);
      return false;
    }

    // Check for required PHP version
    if (version_compare(PHP_VERSION, self::MINIMUM_PHP_VERSION, '<')) {
      add_action('admin_notices', [$this, 'admin_notice_minimum_php_version']);
      return false;
    }
    return true;
  }
  /** * Admin notice * * Warning when the site doesn't have Elementor installed or activated. * * @since 1.0.0 * @access public */ public function admin_notice_missing_main_plugin()
  {
    if (isset($_GET['activate'])) unset($_GET['activate']);
    $message = sprintf( /* translators: 1: hefl_Plugin name 2: Elementor */esc_html__('"%1$s" requires "%2$s" to be installed and activated.', 'elementor-hefl'), '<strong>' . esc_html__('Hedomi Filterable List', 'elementor-hefl') . '</strong>', '<strong>' . esc_html__('Elementor', 'elementor-hefl') . '</strong>');
    printf('<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message);
  }
  /** * Admin notice * * Warning when the site doesn't have a minimum required Elementor version. * * @since 1.0.0 * @access public */ public function admin_notice_minimum_elementor_version()
  {
    if (isset($_GET['activate'])) unset($_GET['activate']);
    $message = sprintf( /* translators: 1: hefl_Plugin name 2: Elementor 3: Required Elementor version */esc_html__('"%1$s" requires "%2$s" version %3$s or greater.', 'elementor-hefl'), '<strong>' . esc_html__('Hedomi Filterable List', 'elementor-hefl') . '</strong>', '<strong>' . esc_html__('Elementor', 'elementor-hefl') . '</strong>', self::MINIMUM_ELEMENTOR_VERSION);
    printf('<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message);
  }
  /** * Admin notice * * Warning when the site doesn't have a minimum required PHP version. * * @since 1.0.0 * @access public */
  public function admin_notice_minimum_php_version()
  {
    if (isset($_GET['activate'])) unset($_GET['activate']);
    $message = sprintf( /* translators: 1: hefl_Plugin name 2: PHP 3: Required PHP version */esc_html__('"%1$s" requires "%2$s" version %3$s or greater.', 'elementor-hefl'), '<strong>' . esc_html__('Hedomi Filterable List', 'elementor-hefl') . '</strong>', '<strong>' . esc_html__('PHP', 'elementor-hefl') . '</strong>', self::MINIMUM_PHP_VERSION);
    printf('<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message);
  }

  public function init()
  {
    add_action('elementor/widgets/register', [$this, 'register_widgets']);
  }
}
