<?php
if (!defined('ABSPATH')) {
    exit;
}


class DM_JSON_Updater {


    private $plugin_file;
    private $plugin_slug;
    private $current_version;

    private $update_url =
    'https://raw.githubusercontent.com/noniko99/Daily.Meditation.NA.-.Polish-wp-plugin-/refs/heads/UPDATE/update.json';



    public function __construct($plugin_file)
    {

        $this->plugin_file = $plugin_file;


        if (!function_exists('get_plugin_data')) {
            require_once ABSPATH . 'wp-admin/includes/plugin.php';
        }


        $plugin_data = get_plugin_data($plugin_file);


        $this->current_version =
            $plugin_data['Version'];


        $this->plugin_slug =
            plugin_basename($plugin_file);



        add_filter(
            'pre_set_site_transient_update_plugins',
            [$this,'check_update']
        );


        add_filter(
            'plugins_api',
            [$this,'plugin_info'],
            10,
            3
        );

    }



    private function get_remote_data()
    {


        $response = wp_remote_get(
            $this->update_url,
            [
                'timeout'=>10
            ]
        );


        if(is_wp_error($response)){
            return false;
        }


        return json_decode(
            wp_remote_retrieve_body($response),
            true
        );

    }




    public function check_update($transient)
    {


        if(empty($transient->checked)){
            return $transient;
        }


        $remote =
            $this->get_remote_data();



        if(!$remote){
            return $transient;
        }



        if(
            version_compare(
                $remote['version'],
                $this->current_version,
                '>'
            )
        ){


            $transient->response[$this->plugin_slug]
            = (object)[

                'slug'=>
                    dirname($this->plugin_slug),

                'plugin'=>
                    $this->plugin_slug,

                'new_version'=>
                    $remote['version'],

                'package'=>
                    $remote['download_url']

            ];

        }


        return $transient;

    }





    public function plugin_info(
        $result,
        $action,
        $args
    ){

        if(
            $action!='plugin_information'
        ){
            return $result;
        }


        if(
            empty($args->slug)
        ){
            return $result;
        }


        if(
            $args->slug != dirname($this->plugin_slug)
        ){
            return $result;
        }



        $remote =
            $this->get_remote_data();



        if(!$remote){
            return $result;
        }



        return (object)[

            'name'=>
                $remote['name'],

            'version'=>
                $remote['version'],

            'homepage'=>
                $remote['details_url'],

            'sections'=>
                $remote['sections']

        ];

    }


}