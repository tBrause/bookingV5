<?php
################# require main.php => switsh ###

################# Inhalt der Startseite
/*
function displayContentMain($conn)
{
    # Schlüssel = Datenbankname # Wert = Angezeigter Wert
    $dashboard = array(
        "film" => "Filme,fa-film",
        "genre" => "Genres,fa-hat-cowboy",
        "filmgesellschaft" => "Filmgesellschaften,fa-building",
        "rooms" => "Räume,fa-door-open",
        "user" => "Mitarbeiter,fa-users",
        "program" => "Filme im Programm,fa-calendar-alt",
        "hauptdarsteller" => "Hauptdarsteller,fa-user"
    );

    #

    echo '<div class="wrapper_home">';
    #echo '<h1>Übersicht</h1>';
    echo '<ul class="dashboard">';

    # Gibt den Namen des Bereichs und entsprechende Anzahl aus
    foreach ($dashboard as $db => $view) {
        $view_split = explode(",", $view);
        #$view_txt =
        $sql = "SELECT * FROM " . $db . "";
        $result = mysqli_query($conn, $sql);
        echo '<li><i class="fas ' . $view_split[1] . '"></i>' . $result->num_rows . ' ' . $view_split[0] . '</li>';
    }
    mysqli_free_result($result);
    echo "<ul>";
    echo '</div>';
}
*/

function displayContentMain($conn, $url)
{
    echo '<h2>Willkommen</h2>';
    echo '<h3>In Ihrem Net-Booking-System für Reservierungsanfragen und Hightlight-Navigation.</h3>';
    echo '<p>Bei Fragen oder Problemen sind von Montag bis Freitag von 9:00 bis 16:00 Uhr telefonisch unter: 030 643 898 38 zu erreichen.</p>';
    echo '<p>Das Team der Astrotel Internetmarketing GmbH.</p>';

    echo '<h2>Hightlight-Navigation: Vorschau SmartPhone</h2>';
    echo '<iframe style="width:375px; height:450px;" src="inc/vorschau.html"></iframe>';

    echo '<h2>Hightlight-Navigation: Vorschau Desktop</h2>';
    echo '<iframe style="width:100%; height:600px;" src="inc/vorschau.html"></iframe>';
    /*
    echo '<br>';
    echo '<h3>Headbereich der HTML-Datei</h3>';
    echo '<br>';

    echo '<pre><code>&lt;head&gt;</code></pre>';
    echo '<br>';
    echo '<pre><code>&lt;!-- PFLICHT --&gt;</code></pre>';
    #echo '<br>';
    echo '<pre><code>&lt;link rel="stylesheet" type="text/css" href="' . $url . 'astrotel_connect/style.connect.css" /&gt;</code></pre>';
    echo '<br>';
    echo '<pre><code>&lt;!-- OPTIONAL: Wenn die Icons von Font Awesome in der Version 4.7.0 nicht vorhanden sind --&gt;</code></pre>';
    echo '<pre><code>&lt;link rel="stylesheet" type="text/css" href="' . $url . 'libs/awesome/css/font-awesome.css" /&gt;</code></pre>';
    echo '<br>';
    echo '<pre><code>&lt;!-- OPTIONAL: Wenn jQuery nicht vorhanden, oder kleiner als Version 1.5.1 ist --&gt;</code></pre>';
    echo '<pre><code>&lt;script src="' . $url . 'libs/jquery/jquery-3.3.1.min.js"&gt;&lt;/script&gt;</code></pre>';
    echo '<br>';
    echo '<pre><code>&lt;!-- OPTIONAL: Wenn die Fonts: Lato 900 und Roboto Condensed 400 nicht vorhanden sind --&gt;</code></pre>';
    echo '<pre><code>&lt;link rel="stylesheet" type="text/css" href="' . $url . 'libs/font.css" /&gt;</code></pre>';
    echo '<br>';
    #echo '<pre><code>&lt;!-- PFLICHT --&gt;</code></pre>';
    #echo '<pre><code>&lt;script defer src="' . $url . 'astrotel_connect/libraries/js.astrotel.js"&gt;&lt;/script&gt;</code></pre>';
    #echo '<br>';
    echo '<pre><code>&lt;/head&gt;</code></pre>';
    echo '<br>';

    echo '<h3>Vor dem schließenden Body-Tag</h3>';
    echo '<br>';
    echo '<pre><code>&lt;body&gt;</code></pre>';
    echo '...<br>...';
    echo '<pre><code>&lt;!-- PFLICHT --&gt;</code></pre>';
    echo '<pre><code>&lt;script src="' . $url . 'astrotel_connect/libraries/js.astrotel.js"&gt;&lt;/script&gt;</code></pre>';
    echo '<pre><code>&lt;/body&gt;</code></pre>';
    echo '<br>';




    echo '<h3>Links der Formulare zum Einbau in die Webseite und öffen in einem neuen Fenster</h3>';
    echo '<br>';
    echo '<pre><code>&lt;body&gt;</code></pre>';

    $sql = "SELECT * FROM `cms_menue` ORDER BY template_id asc";
    $result = mysqli_query($conn, $sql);

    while ($row = mysqli_fetch_assoc($result)) {


        $template = $row['template_id'];
        $html_name = $row['html_name'];

        if ($template == 20 || $template == 22) {
            #echo $row['html_name'] . '<br>';

            if ($template == 20) {
                $typ = "Reservierung: ";
                $mask_main = "main";
            }
            if ($template == 22) {
                $typ = "Angebot: ";
                $mask_main = "arr";
            }

            echo '<br>';


            echo '<p>' . $typ . $row['titel'] . '</p>';
            #echo '<p>Im neuen Fenster</p>';

            echo '<br>';
            echo "<pre><code>	&lt;!-- Im neuen Fenster --&gt;</code></pre>
            <pre><code>	&lt;a href=\"" . $url . $html_name . "\"&gt;Linkname&lt;/a&gt;</code></pre><br>
            <pre><code>	&lt;!-- Bei Einbau in die Homepage --&gt;</code></pre>
            <pre><code>	&lt;a href=\"#" . $row['id'] . "\" class=\"mask_" . $mask_main . "\"&gt;Linkname&lt;/a&gt;</code></pre>";

        }
    }

    echo '<pre><code>&lt;/body&gt;</code></pre>';
    echo '<br><br>';
    */
}
