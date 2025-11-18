<?php 
/**
 * Plugin Name: Awesome Resource
 * Description: Awesome resource CPT for WordPress.
 * Plugin Author: Purshottam Nepal
 * Version: 0.1.0
 * License: GPLv2
 * Text domain: awesome-resource
 */
defined( 'ABSPATH' ) || exit;

define('ASMR_PLUGIN_VERSION', '0.1.0');
define('ASMR_PLUGIN_PATH', plugin_dir_path(__FILE__));
define('ASMR_PLUGIN_URL', plugin_dir_url(__FILE__));

require_once ASMR_PLUGIN_PATH . "vendor/autoload.php";

add_action('plugins_loaded', function() {
    return ASMR\Resource::instance();
});

/**
 * Global helper function to singleton instance.
 */
if ( ! function_exists('ASMR') ) {
    function ASMR() {
        return ASMR\Resource::instance();
    }
}