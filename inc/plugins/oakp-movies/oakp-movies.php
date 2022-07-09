<?php
/**
 * Plugin Name: OAK Filme
 * Description: Dieses Plugin wird benutzt, um die Filme fürs OAK Plaffeien auf einfache Art und Weise zu erfassen.
 * Version:     1.0.1
 * Author:      Nicolas Baeriswyl
 * Author       URI: https://baeriswyl.dev
 */

if ( ! defined('WPINC' ) ) die;

if ( ! defined( 'OAKP_MOVIES_FILE' ) ) {
    define( 'OAKP_MOVIES_FILE', __FILE__ );
}

require plugin_dir_path(__FILE__) . 'includes/class-oakp-movies.php';

function run_oakp_movies() {
    $plugin = new OAKP_Movies();
    $plugin->run();
}

run_oakp_movies();