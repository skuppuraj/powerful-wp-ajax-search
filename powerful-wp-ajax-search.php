<?php
/**
 * Plugin Name: Powerful WP Ajax Search
 * Plugin URI: https://wordpress.org/plugins/powerful-wp-ajax-search/
 * Description: Replacement of default WordPress search
 * Version: 0.9.0
 * Author: Kuppuraj
 * Author URI: https://github.com/skuppuraj
 */

if(!defined( 'ABSPATH' )){ exit;}

define( 'PWAS_VERSION', '0.9.0' );
define( 'PWAS_MAIN_FILE', __FILE__ );
define( 'PWAS_PATH', plugin_dir_path( PWAS_MAIN_FILE ) );

use PWAS\Main;

require_once PWAS_PATH . 'vendor/autoload.php';

function pwas_plugin_init() {
	global $pwas;
	$pwas = new Main();
}

pwas_plugin_init();