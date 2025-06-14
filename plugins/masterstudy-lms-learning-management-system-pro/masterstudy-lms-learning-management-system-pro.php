<?php
/**
 * Plugin Name: MasterStudy LMS – Online Courses, eLearning PRO Plus
 * Plugin URI: http://masterstudy.stylemixthemes.com/lms-plugin/
 * Description: Create brilliant lessons with videos, graphs, images, slides and any other attachments thanks to flexible and user-friendly lesson management tool powered by WYSIWYG editor.
 * As the ultimate LMS WordPress Plugin, MasterStudy makes it simple and hassle-free to build, customize and manage your Online Education WordPress website.
 * Author: StylemixThemes
 * Author URI: https://stylemixthemes.com/
 * Text Domain: masterstudy-lms-learning-management-system-pro
 * Version: 4.7.2
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

define( 'STM_LMS_PRO_FILE', __FILE__ );
define( 'STM_LMS_PRO_PATH', dirname( STM_LMS_PRO_FILE ) );
define( 'STM_LMS_PRO_INCLUDES', STM_LMS_PRO_PATH . '/includes' );
define( 'STM_LMS_PRO_ADDONS', STM_LMS_PRO_PATH . '/addons' );
define( 'STM_LMS_PRO_PLUS_ADDONS', STM_LMS_PRO_PATH . '/addons-plus' );
define( 'STM_LMS_PRO_URL', plugin_dir_url( STM_LMS_PRO_FILE ) );
define( 'STM_LMS_PRO_VERSION', '4.7.2' );

require_once STM_LMS_PRO_PATH . '/vendor/autoload.php';
require_once STM_LMS_PRO_INCLUDES . '/init.php';
