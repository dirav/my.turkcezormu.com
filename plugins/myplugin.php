<?php
/*
Plugin Name: My Custom Plugin
Plugin URI: https://example.com
Description: A custom plugin for WordPress.
Version: 1.0
Author: Your Name
Author URI: https://example.com
License: GPL2
*/

// Prevent direct access to the file
if (!defined('ABSPATH')) {
  exit;
}

// Add a custom action
function my_custom_action() {
  echo '<p>Hello, this is my custom plugin!</p>';
}
add_action('wp_footer', 'my_custom_action');
?>