<?php
#phpinfo();
require("../admin/inc/ini.php");

$id = trim(substr(filter_input(INPUT_GET, 'id'), 0, 14));

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
    <title>install</title>
    <!-- CSS -->
    <link rel="stylesheet" type="text/css" href="../admin/css/default.css">
    <link rel="stylesheet" type="text/css" href="../admin/css/fonts.css">
</head>

<body>

    <?php

    /**
     * 
     * Id zur Abfrage
     * Wenn ID dann einzelne Seite erstellen
     * 
     * ELSE
     * 
     * Alle Seiten erstellen
     * 
     */

    if (!empty($id)) {

        ##### Titel der Seite
        $titel = getSqlMenue($conn, $id)['titel'];

        ##### Link der Seite
        $link_ausgabe = getNewFile($titel);

        ##### LOESCHE DIESE SEITE
        if (is_file($dir .  $link_ausgabe) === true) {

            ##### LOESCHE DIESE SEITE
            echo $dir . $link_ausgabe;
            #@unlink($dir .  $link_ausgabe;
        }

        ##### SCHREIBE ALLE EINHEITEN in die inc/einheiten.php
        fwriteEinheiten($conn, $dir);

        ##### SCHREIBE DIESE SEITE
        fwriteDatei($conn, $url, $dir, $id);
    } else {

        ##### LOESCHE ALLE SEITEN
        delSeiten($dir, $id);

        ##### SCHREIBE ALLE EINHEITEN in die inc/einheiten.php
        fwriteEinheiten($conn, $dir);

        ##### SCHREIBE ALLE SEITEN
        $id = 0;
        fwriteDatei($conn, $url, $dir, $id);
    }

    /**
     * 
     * BUBBLE SYSTEM
     * 
     * 
     */

    function snav($dir, $conn)
    {
        require('snav.php');
    }

    snav($dir, $conn);


    /**
     * 
     * Schreibt alle Einheiten
     * in die Datei inc/einheitem.php
     * 
     * Dient der Freigabe der
     * im Frontend verwendeten Variablen
     * 
     */

    function fwriteEinheiten($conn, $dir)
    {

        ##### SQL ALLE EINHEITEN
        $sql = "SELECT * FROM `cms_anfrage` WHERE freigabe = '1' ORDER BY id ASC";
        $result = mysqli_query($conn, $sql);

        if ($result->num_rows >= 1) {

            ##### DATEI ÖFFNEN
            $fp = fopen($dir . "inc/einheiten.php", "w+");

            ##### SCHREIBEN
            @fwrite($fp, "<?php\n");

            while ($row = mysqli_fetch_assoc($result)) {

                ##### EINHEITEN SCHREIBEN
                $einheit = 'einheit_' . $row['id'];
                @fwrite($fp, "$" . $einheit . " = trim(substr(filter_input(INPUT_POST, '" . $einheit . "'), 0, 6));\n");
            }

            ##### DATEI SCHLIEßEN
            @fclose($fp);
        }

        ##### SQL BEENDEN
        mysqli_free_result($result);
    }




    /**
     * 
     * Entfernt alle Seiten
     * 
     * 
     */

    function delSeiten($dir, $id)
    {
        echo '<h2>Alle Seiten entfernen</h2>';
        $dir_clear = dir($dir);
        while ($datei = $dir_clear->read()) {
            if (is_file($dir . $datei) === true) {
                #echo $dir .  $datei . 'dfdfdfds<br>';

                $file_details = pathinfo($dir .  $datei);
                $extension = $file_details['extension'];

                if ($extension === 'html' or $extension === 'php' or $extension === 'xml' or $extension === 'txt') {
                    if ($datei != 'index.php') {
                        echo $dir .  $datei . '<br>';
                        @unlink($dir .  $datei);
                    }
                }
            }
        }
        $dir_clear->close();
    }






    /**
     * 
     * Entfernt eine Seite
     * 
     * 
     */





    ####### SQL ABFRAGE in `cms_anfrage` wenn absatz_id 
    /*function getSqlAnfrage($conn, $absatz_id)
{
    $sql_anfrage = "SELECT * FROM `cms_anfrage` WHERE absatz_id = '" . $absatz_id . "'";
    $result_anfrage = mysqli_query($conn, $sql_anfrage);
    $row_anfrage = mysqli_fetch_assoc($result_anfrage);
    mysqli_free_result($result_anfrage);

    return $row_anfrage;
}*/

    /**
     * 
     * Schreibt alle Seiten
     * oder
     * eine ausgewählte Seite 
     * 
     */

    function fwriteDatei($conn, $url, $dir, $id)
    {

        ####### Seiten neu anlegen
        echo '<h2>Seiten neu anlegen</h2>';

        ####### SQL ABFRAGE in `cms_menue`

        if ($id !== 0) {
            $sql = "SELECT * FROM `cms_menue` WHERE `id` = '" . $id . "'";
        } else {
            $sql = "SELECT * FROM `cms_menue` WHERE `sichtbar` = '1' AND (`template_id` = '20' OR `template_id` = '22')";
        }

        $result = mysqli_query($conn, $sql);

        while ($row = mysqli_fetch_assoc($result)) {

            ######## VARIABLEN aus der Datenbank `cms_menue`
            $menue_id = $row['id'];
            $menue_titel = $row['titel'];
            $template_id = $row['template_id'];

            unset($einheit);
            $einheiten = [];

            echo '<ul class="install">';

            ######## DATEINAME
            $link_ausgabe = getNewFile($row['titel']);

            ######## SEITENTITEL / LINKNAME
            echo '<li>Seite erstellt: <a href="' . $url . $link_ausgabe . '?id=' . $menue_id . '" target="_blank">' . $row['titel'] . '</a></li>';
            #echo '<li>Link: <a href="' . $url . $link_ausgabe . '?id=' . $menue_id . '" target="_blank">' . $url . $link_ausgabe . '?id=' . $menue_id . '</a></li>';
            #echo '<li>DATEINAME: ' . $dir . $link_ausgabe . '</li>';

            ######## DATEI ÖFFNEN / ERSTELLEN

            #echo $dir .  $link_ausgabe . '<br>';
            #if (is_file($dir .  $link_ausgabe) === true) {

            unset($fp);
            $fp = fopen($dir . $link_ausgabe . "", "w+");

            ######## DATEI HEADER
            @fwrite($fp, "<?php\n");
            #@fwrite($fp, "header(\"Content-type: text/html; charset=utf-8\");\n");
            #@fwrite($fp, "date_default_timezone_set('Europe/Berlin');\n");
            @fwrite($fp, "require(\"admin/inc/ini.php\");\n");
            #@fwrite($fp, "require(\"inc/check.php\");\n");
            @fwrite($fp, "require(\"inc/request.php\");\n");
            @fwrite($fp, "?>\n");
            @fwrite($fp, "\n");


            unset($design_datei, $zeile);
            $zeile = 0;
            // Datei auslesen
            $design_datei = file("vorlage.html");
            #echo count($design_datei) . '</ul>';

            foreach ($design_datei as $value) {

                $stop = 0;

                    ### TITLE
                    /*$sql_inhalte = "SELECT * FROM `cms_inhalte` WHERE menu_id = '" . $menue_id . "'";
        $result_inhalte = mysqli_query($conn, $sql_inhalte);
        $row_inhalte = mysqli_fetch_assoc($result_inhalte);*/;

                ### TITLE (Meta)
                $var = "<?php echo \$var_admin_titel; ?>";
                if (str_contains($value, $var) === true) {
                    @fwrite($fp, getSqlInhalte($conn, $menue_id)['seitentitel'] . "\n");
                    echo '<li> Überschrift: ' . getSqlInhalte($conn, $menue_id)['seitentitel'] . '</li>';
                    $stop = 1;
                }

                ### HEADER CSS JS
                $var = "<?php include(\"metas_netbooking.php\"); ?>";
                if (str_contains($value, $var) === true) {

                    require("metas_netbooking.php");

                    foreach ($metas as $meta) {
                        @fwrite($fp, $meta . "\n");
                    }

                    #echo '<li>HEADER CSS JS</li>';
                    $stop = 1;
                }

                ### BODY
                $var = "<?php include(\"body.php\"); ?>";
                if (str_contains($value, $var) === true) {
                    @fwrite($fp, "<body class=\"bd_" . $row['template_id'] . "\">\n");
                    #echo '<li>Body</li>';
                    $stop = 1;
                }

                ### CONTENT
                $var = "<?php include(\"inhalt.php\"); ?>";
                if (str_contains($value, $var) === true) {
                    #echo '<li>Inhalt</li>';
                    #echo '<li>';
                    #require('anfrage.php');
                    @fwrite($fp, "<?php require('inc/templates/anfrage.php'); ?>\n");
                    #echo '</li>';
                    $stop = 1;
                }

                ### js.default
                $var = "<?php include(\"js_default.php\"); ?>";
                if (str_contains($value, $var) === true) {
                    #@fwrite($fp, "<body class=\"bd_" . $row['template_id'] . "\">\n");
                    #echo '<li>JS</li>';
                    $stop = 1;
                }


                ### Alle anderen Zeilen
                if ($stop === 0) {
                    @fwrite($fp, "" . $value . "");
                }
            }

            #echo '<li>Fertig</li>';



            ##### DATEI SCHLIEßEN
            @fclose($fp);
            #}
            echo '</ul>';
        }

        if ($id !== 0) {
            header('Location: ' . $url . $link_ausgabe . '?id=' . $id . '');
        }
    }


    /**
     * 
     * SITEMAP XML
     * 
     * 
     */

    function fwriteSitemapXml($conn, $dir, $url)
    {
        // Werte auf NULL setzen
        unset($fp);

        // Datei oeffnen, bzw. erstellt sie, wenn sie noch nicht existiert
        $fp = @fopen($dir . "sitemap.xml", "w+");

        // Daten eintragen
        @fwrite($fp, "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>\n");
        @fwrite($fp, "<urlset xmlns=\"http://www.google.com/schemas/sitemap/0.84\" xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\" xsi:schemaLocation=\"http://www.google.com/schemas/sitemap/0.84 http://www.google.com/schemas/sitemap/0.84/sitemap.xsd\">\n");
        @fwrite($fp, "<!--  Last update of sitemap " . date("Y-m-d\TH:i:s") . "+02:00 -->\n");

        @fwrite($fp, "<url>\n");
        @fwrite($fp, "<loc>" . $url . "index.html</loc>\n");
        @fwrite($fp, "<changefreq>yearly</changefreq>\n");
        @fwrite($fp, "<priority>0.2</priority>\n");
        @fwrite($fp, "</url>\n");

        $sql = "SELECT 
        *
        FROM `cms_menue`  
        WHERE template_id = 20 OR template_id = 22";
        $result = mysqli_query($conn, $sql);

        while ($row = mysqli_fetch_assoc($result)) {

            @fwrite($fp, "<url>\n");
            @fwrite($fp, "<loc>" . $url . getNewFile($row['titel']) . '?id=' . $row['id'] . "</loc>\n");
            @fwrite($fp, "<changefreq>monthly</changefreq>\n");
            @fwrite($fp, "<priority>0.5</priority>\n");
            @fwrite($fp, "</url>\n");
        }

        @fwrite($fp, "</urlset>");
        // Datei schliessen
        @fclose($fp);

        if (is_file($dir . "sitemap.xml") === true) {
            echo '<h2>sitemap.xml wurde erstellt</h2>';
        }
    }

    fwriteSitemapXml($conn, $dir, $url);



    /**
     * 
     * ROBOTS TXT
     * 
     * 
     */

    function fwriteRobotsTxt($dir)
    {
        unset($fp);

        // Datei oeffnen, bzw. erstellt sie, wenn sie noch nicht existiert
        $fp = @fopen($dir . "robots.txt", "w+");

        unset($r);
        $r[] = "# file created: " . date("Y-m-d") . "\n";
        $r[] = "User-agent: * \n";
        $r[] = "Disallow: /\n";
        /*$r[] = "Disallow: /*.exe$\n";
        $r[] = "Disallow: /*.zip$\n";
        $r[] = "Disallow: /*.rar$\n";
        $r[] = "Disallow: /*.doc$\n";
        $r[] = "Disallow: /*.xls$\n";*/

        // Werte loeschen
        unset($verzeichnis_temp, $datei, $zaehlen);
        // Alle HTML-Seiten ins Array schreiben
        $verzeichnis_temp = dir("" . $dir . "");
        while ($datei = $verzeichnis_temp->read()) {
            if ($datei != ".." && $datei != "." && @is_dir("../" . $datei . "") && ($datei == "admin" || $datei == "inc")) {
                // Eintrag ins Array
                $r[] = "Disallow: /" . $datei . "/\n";
            }
        }
        $verzeichnis_temp->close();

        $i = 0;
        while ($i < count($r)) {
            @fwrite($fp, $r[$i]);
            $i++;
        }

        // Datei schliessen
        @fclose($fp);

        if (is_file($dir . "sitemap.xml") === true) {
            echo '<h2>robots.txt wurde erstellt</h2>';
        }
    }

    fwriteRobotsTxt($dir);




    ?>
</body>

</html>