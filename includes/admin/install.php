<?php
if (!defined('ABSPATH')) {
    exit;
}


/*
====================================
INSTALACJA WTYCZKI
====================================
*/

function dm_install()
{

    dm_create_table();

    dm_import_database();


    update_option(
        'dm_db_version',
        DM_DB_VERSION
    );

}



/*
====================================
TWORZENIE TABELI
====================================
*/

function dm_create_table()
{

    global $wpdb;


    $table = 'meditations_pl';


    $charset = $wpdb->get_charset_collate();


    $sql = "
    CREATE TABLE IF NOT EXISTS {$table} (

        id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,

        date VARCHAR(5) NOT NULL,

        med_day VARCHAR(100) DEFAULT NULL,

        med_title VARCHAR(255) DEFAULT NULL,

        med_page VARCHAR(50) DEFAULT NULL,

        meditation LONGTEXT DEFAULT NULL,

        today_note LONGTEXT DEFAULT NULL,

        PRIMARY KEY (id),

        UNIQUE KEY date (date)

    ) {$charset};
    ";


    require_once ABSPATH . 'wp-admin/includes/upgrade.php';


    dbDelta($sql);

}



/*
====================================
SPRAWDZENIE WERSJI BAZY
====================================
*/

function dm_check_database_version()
{

    $current = get_option(
        'dm_db_version',
        ''
    );


    if ($current === DM_DB_VERSION) {

        return;

    }


    dm_reset_database();


    dm_create_table();


    dm_import_database();


    update_option(
        'dm_db_version',
        DM_DB_VERSION
    );

}



/*
====================================
RESET BAZY
====================================
*/

function dm_reset_database()
{

    global $wpdb;


    $wpdb->query(
        "DROP TABLE IF EXISTS meditations_pl"
    );

}



/*
====================================
IMPORT MEDYTACJI SQL
====================================
*/

function dm_import_database()
{

    global $wpdb;


    $file = dirname(__DIR__, 2) . '/assets/database.sql';


    if (!file_exists($file)) {

        return;

    }


    $sql = file_get_contents($file);


    if (!$sql) {

        return;

    }


    /*
    Usuwamy komentarze
    */

    $sql = preg_replace(
        '/\/\*![\s\S]*?\*\//',
        '',
        $sql
    );


    $sql = preg_replace(
        '/--.*(\r\n|\n|\r)/',
        '',
        $sql
    );


    /*
    Wykonujemy tylko INSERT
    */

    $queries = explode(
        ';',
        $sql
    );


    foreach ($queries as $query) {


        $query = trim($query);


        if (!$query) {
            continue;
        }


        if (
            stripos($query, 'INSERT') !== 0
        ) {
            continue;
        }


        $wpdb->query($query);

    }

}