<?php
if (!defined('ABSPATH')) {
    exit;
}

function dm_shortcode()
{
    global $wpdb;

    $table = 'meditations_pl';
    $date  = current_time('m-d');

    $row = $wpdb->get_row(
        $wpdb->prepare(
            "SELECT * FROM {$table} WHERE date=%s LIMIT 1",
            $date
        )
    );

    if (!$row) {
        return '<div class="dm-error">Brak medytacji na dziś.</div>';
    }

    ob_start();
    ?>

    <div class="daily-meditation">

        <div class="med-date">
            <?php echo esc_html(date_i18n('j F Y', current_time('timestamp'))); ?>
        </div>

        <div class="med-title">

            <h1><?php echo esc_html($row->med_title); ?></h1>

            

        </div>

        <div class="meditation">
            <?php echo wpautop(wp_kses_post($row->meditation)); ?>
        </div>

        <div class="today-note">

            <h3>Właśnie dzisiaj</h3>

            <?php echo wpautop(wp_kses_post($row->today_note)); ?>

        </div>

        <div class="dm-footer">

            <p>
                Daily Meditation NA – Polish
            </p>

            <p>

                <a href="https://github.com/noniko99/DailyMeditationNA-Polish-wp-plugin" target="_blank" rel="noopener">
                    GitHub
                </a>

                •

                <a href="mailto:noniko9901@gmail.com">
                    Kontakt
                </a>

            </p>

        </div>

    </div>

    <?php
    return ob_get_clean();
}

add_shortcode('daily_meditation_pl', 'dm_shortcode');