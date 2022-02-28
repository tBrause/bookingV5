<?php
require("admin/inc/ini.php");

/**
 * 
 * Funktionen für die Kontrolle der Versuche 
 * 
 */
$senden = '';
require("inc/check.php");
?>
<!doctype html>
<html lang="de">

<head>
    <meta http-equiv="Access-Control-Allow-Origin" content="*">
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="shortcut icon" type="image/x-icon" href="fav.ico">
    <meta name="robots" content="noindex, nofollow">
    <title>Reservierungen und Angebote</title>
    <link href="default.css" rel="stylesheet" type="text/css">
</head>

<body>

    <!-- INHALT -->
    <main id="inhalt">
        <div class="wrapper">
            <h1>Anfragen für Reservierungen und Angebote</h1>
            <div>
                <ul class="show_links">
                    <?php
                    /**
                     * 
                     * Alle Formulare
                     * auf dem SEElld
                     * 
                     */
                    $sql = "SELECT * FROM `cms_menue` WHERE (template_id = '20' OR template_id = '22') AND sichtbar = '1' ORDER BY titel";
                    $result = mysqli_query($conn, $sql);

                    while ($row = mysqli_fetch_array($result)) {
                        echo '<li>';
                        echo '<a href="' . $url . getNewLink($row['id'], $row['titel']) . '">' . $row['titel'] . '</a>';
                        echo '</li>';
                    }
                    ?>
                </ul>
            </div>

            <?php
            /**
             * 
             * Impressum & Datenschutz
             * 
             */
            echo '<ul id="impdata">';
            echo '<li><a href="' . htmlspecialchars(getConfig($conn)['linkImpressum'], ENT_QUOTES) . '" target="_blank">Impressum</a></li>';
            echo '<li><a href="' . htmlspecialchars(getConfig($conn)['linkDatenschutz'], ENT_QUOTES) . '" target="_blank">Datenschutz</a></li>';
            echo '</ul>';
            ?>
        </div>
    </main>
</body>

</html>