<?php
if (!defined('ABSPATH')) {
    exit;
}
function dm_admin_menu() {

    add_menu_page(
        'Daily Meditation',      // Tytuł strony
        'Daily Meditation',      // Nazwa w menu
        'manage_options',        // Uprawnienia
        'daily-meditation',      // Slug
        'dm_dashboard_page',     // Funkcja wyświetlająca stronę
        'dashicons-book-alt',    // Ikona
        30                       // Pozycja
    );

}

add_action('admin_menu', 'dm_admin_menu');

function dm_dashboard_page() {
    ?>
    <div class="wrap">

        <h1>Daily Meditation NA - Polish</h1>

         <h1>Informacje</h1>

        <p>Ta wtyczka wyświetla codzienną medytację z bazy danych.</p>

        <hr><br>

        <h1>Konfiguracja</h1>

        <ol>
            <li>Zainstaluj i aktywuj wtyczkę.</li>
            <li>Podczas aktywacji zostanie automatycznie utworzona baza danych z medytacjami.</li>
            <li>Wstaw shortcode na dowolnej stronie lub we wpisie.</li>
        </ol>

        <h2>Shortcode</h2>

        <p>Użyj poniższego shortcode:</p>

        <input
            type="text"
            class="regular-text code"
            readonly
            value="[meditation_today_pl]"
            onclick="this.select();">

        <p>lub</p>

        <pre><code>[meditation_today_pl]</code></pre>

        <hr>

        <h2>Opis</h2>

        <p>
            Wtyczka automatycznie wyświetla medytację odpowiadającą
            bieżącej dacie. Dane pobierane są z tabeli
            <code>meditations_pl</code>.
        </p>

        <hr>

        <h2>Wsparcie</h2>

        <p>
            Jeśli napotkasz problem z działaniem wtyczki,
            sprawdź czy wtyczka została poprawnie aktywowana
            oraz czy tabela bazy danych została utworzona.
        </p>

    </div>
    <?php
}

