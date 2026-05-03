<?php

/*
 * Plugin Name:       API Development
 * Plugin URI:        https://wordpress.org/plugins/api-development
 * Description:       Handle the basics of API development
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Shemanta Bhowmik
 * Author URI:        https://shemantabhowmik.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       apidev
 * Domain Path:       /languages
 */

defined('ABSPATH') or exit;

// define constants
define('APIDEV_URL', plugin_dir_url(__FILE__));
define('APIDEV_PATH', plugin_dir_path(__FILE__));
define('APIDEV_VERSION', '1.0.0');

// inclue files 
if (file_exists(APIDEV_PATH . 'includes/class-api-dev.php')) {
    include_once APIDEV_PATH . 'includes/class-api-dev.php';
}

new APIDEV();