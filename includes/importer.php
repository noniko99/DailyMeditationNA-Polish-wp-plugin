<?php

function wpdi_import_database() {

    global $wpdb;


    if (!file_exists(WPDI_DATABASE_FILE)) {
        return;
    }


    $sql = file_get_contents(WPDI_DATABASE_FILE);


    $queries = explode(";\n", $sql);


    foreach ($queries as $query) {

        $query = trim($query);

        if ($query) {
            $wpdb->query($query);
        }

    }

}