<?php
if (!defined('ABSPATH')) {
    exit;
}


function dm_shortcode()
{

    global $wpdb;


    $table = 'meditations_pl';


    $date = current_time('m-d');



    $row = $wpdb->get_row(

        $wpdb->prepare(

            "
            SELECT *
            FROM {$table}
            WHERE date=%s
            LIMIT 1
            ",

            $date

        )

    );



    if (!$row) {

        return '<p>Brak medytacji na dziś.</p>';

    }



    ob_start();

    ?>

    <div class="daily-meditation">


        <div class="med-header">

            <div>

                <h2>

                    <?php

                    echo esc_html(

                        date_i18n(
                            'F j, Y',
                            current_time('timestamp')
                        )

                    );

                    ?>

                </h2>

            </div>

        </div>



        <div class="med-title">

            <h1>

                <?php

                echo esc_html(
                    $row->med_title
                );

                ?>

            </h1>

        </div>




        <div class="meditation">

            <?php

            echo wpautop(

                wp_kses_post(
                    $row->meditation
                )

            );

            ?>

        </div>




        <div class="today-note">

            <strong>
                Właśnie dzisiaj:
            </strong>


            <br><br>


            <?php

            echo wpautop(

                wp_kses_post(
                    $row->today_note
                )

            );

            ?>


        </div>




        <div class="dm-footer">


            Medytacja wyświetlana przez plugin WordPress


            <a 
                href="https://github.com/noniko99/DailyMeditationNA-Polish-wp-plugin"
                target="_blank"
                rel="noopener noreferrer"
            >

                Daily Meditation NA - Polish

            </a>



            <br>



            Znalazłeś błąd lub masz sugestię?


            <a href="mailto:noniko9901@gmail.com">

                noniko9901@gmail.com

            </a>


        </div>



    </div>


    <?php


    return ob_get_clean();


}



add_shortcode(

    'daily_meditation_pl',

    'dm_shortcode'

);