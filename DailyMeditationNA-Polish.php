<?php
/*
Plugin Name: Daily Meditation NA - Polish
Description: Wyświetla codzienną medytację z bazy SQL.
Version: 1.0.1
Author: Noniko99
*/

if (!defined('ABSPATH')) {
    exit;
}


define('WPDI_PATH', plugin_dir_path(__FILE__));
define('WPDI_URL', plugin_dir_url(__FILE__));


// Pliki pluginu
require_once WPDI_PATH . 'includes/install/config.php';
require_once WPDI_PATH . 'includes/install/importer.php';
require_once WPDI_PATH . 'includes/shortcode/meditation_pl.php';
require_once WPDI_PATH . 'includes/admin/admin.php';
require_once WPDI_PATH . 'includes/install/update.php';


// Import bazy przy aktywacji pluginu
function wpdi_activate_plugin() {

    if (function_exists('wpdi_import_database')) {

        wpdi_import_database();

    }

}

register_activation_hook(
    __FILE__,
    'wpdi_activate_plugin'
);


// Ładowanie CSS
function wpdi_enqueue_styles() {

    wp_enqueue_style(
        'daily-meditation-style',
        WPDI_URL . 'assets/css/style.css',
        array(),
        '1.0.0'
    );

}

add_action(
    'wp_enqueue_scripts',
    'wpdi_enqueue_styles'
);


// Aktualizator JSON
new DM_JSON_Updater(__FILE__);