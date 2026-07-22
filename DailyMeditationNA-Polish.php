<?php
/*
Plugin Name: Daily Meditation NA - Polish
Description: Wyświetla codzienną medytację z bazy SQL.
Version: 1.0.0
Author: Noniko99
*/
if (!defined('ABSPATH')) {
    exit;
}


define('WPDI_PATH', plugin_dir_path(__FILE__));
define('WPDI_URL', plugin_dir_url(__FILE__));


require_once WPDI_PATH . 'includes/config.php';
require_once WPDI_PATH . 'includes/importer.php';
require_once WPDI_PATH . 'includes/meditation_pl.php';
require_once WPDI_PATH . 'includes/admin.php';
require_once WPDI_PATH . 'includes/update.php';


function wpdi_activate_plugin() {

    if (function_exists('wpdi_import_database')) {
        wpdi_import_database();
    }

}


register_activation_hook(
    __FILE__,
    'wpdi_activate_plugin'
);

new DM_JSON_Updater(__FILE__);