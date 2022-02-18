<?php
################# require main.php => switsh ###

################# Einbauanleitung

function displayContentInstruction($conn, $url)
{
    echo '<h2>Einbau in die Homepage</h2>';
    echo '<p>Wenn die Formulare Bestandteil der Webseite sein sollen, sind folgende Scripte einzubinden.</p>';
    echo '<p>Das gilt auch, wenn die Highlight-Navigation eingebunden wird.</p>';
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


            echo '<h4>' . $typ . $row['titel'] . '</h4>';
            #echo '<p>Im neuen Fenster</p>';

            echo '<br>';
            echo "<pre><code>	&lt;!-- Im neuen Fenster --&gt;</code></pre>
            <pre><code>	&lt;a href=\"" . $url . $html_name . "\"&gt;Linkname&lt;/a&gt;</code></pre><br>
            <pre><code>	&lt;!-- Bei Einbau in die Homepage --&gt;</code></pre>
            <pre><code>	&lt;a href=\"#" . $row['id'] . "\" class=\"mask_" . $mask_main . "\"&gt;Linkname&lt;/a&gt;</code></pre>";

            /*
            echo "<pre><code>&lt;!-- " . $typ . $row['titel'] . " --&gt;</code></pre>
            <pre><code>	&lt;!-- Im neuen Fenster --&gt;</code></pre>
            <pre><code>	&lt;a href=\"" . $url . $html_name . "\"&gt;Linkname&lt;/a&gt;</code></pre><br>
            <pre><code>	&lt;!-- Bei Einbau in die Homepage --&gt;</code></pre>
            <pre><code>	&lt;a href=\"#" . $row['id'] . "\" class=\"mask_" . $mask_main . "\"&gt;</code></pre>";
            
            
            */
        }
    }

    echo '<pre><code>&lt;/body&gt;</code></pre>';
    echo '<br><br>';
}
