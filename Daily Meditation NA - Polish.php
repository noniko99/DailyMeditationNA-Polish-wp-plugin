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

/* =========================
   CONSTANTS
========================= */

define('DM_PLUGIN_PATH', plugin_dir_path(__FILE__));
define('DM_PLUGIN_URL', plugin_dir_url(__FILE__));
define('DM_DB_VERSION', '1.0.8');
/* =========================
   INCLUDES
========================= */

require_once DM_PLUGIN_PATH . 'includes/admin/install.php';
require_once DM_PLUGIN_PATH . 'includes/shortcode/meditation-shortcode-pl.php';
require_once DM_PLUGIN_PATH . 'includes/admin/admin-menu.php';
require_once DM_PLUGIN_PATH . 'includes/updater.php';


new DM_JSON_Updater(
    __FILE__
);

/* =========================
   ACTIVATION
========================= */

register_activation_hook(__FILE__, 'dm_install');
add_action(
    'plugins_loaded',
    'dm_check_database_version'
);

/* =========================
   ASSETS
========================= */

function dm_enqueue_assets() {

    wp_enqueue_style(
        'dm-style',
        DM_PLUGIN_URL . 'assets/style.css',
        array(),
        '1.0.1'
    );

}

add_action('wp_enqueue_scripts', 'dm_enqueue_assets');


