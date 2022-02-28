<?php

/**
 * 
 * Variablen freischalten
 * 
 */
$id = @$_REQUEST['id'];

$senden = trim(substr(filter_input(INPUT_POST, 'senden'), 0, 14));
$form_einwilligung = trim(substr(filter_input(INPUT_POST, 'form_einwilligung'), 0, 1));

$form_anreise = trim(substr(filter_input(INPUT_POST, 'form_anreise'), 0, 10));
$form_abreise = trim(substr(filter_input(INPUT_POST, 'form_abreise'), 0, 10));

$form_name = trim(substr(filter_input(INPUT_POST, 'form_name'), 0, 40));
$form_email = trim(substr(filter_input(INPUT_POST, 'form_email'), 0, 40));
$form_telefon = trim(substr(filter_input(INPUT_POST, 'form_telefon'), 0, 30));
$form_strasse = trim(substr(filter_input(INPUT_POST, 'form_strasse'), 0, 100));
$form_plz = trim(substr(filter_input(INPUT_POST, 'form_plz'), 0, 50));
$form_firma = trim(substr(filter_input(INPUT_POST, 'firma'), 0, 50));
$form_ansprechpartner = trim(substr(filter_input(INPUT_POST, 'form_ansprechpartner'), 0, 40));
$form_kommentar = trim(substr(filter_input(INPUT_POST, 'form_kommentar'), 0, 180));

#echo $form_telefon . '<br>';
#echo strlen($form_telefon) . '<br>';

$form_kind1 = trim(substr(filter_input(INPUT_POST, 'form_kind1'), 0, 2));
$form_kind2 = trim(substr(filter_input(INPUT_POST, 'form_kind2'), 0, 2));
$form_kind3 = trim(substr(filter_input(INPUT_POST, 'form_kind3'), 0, 2));
$form_kind4 = trim(substr(filter_input(INPUT_POST, 'form_kind4'), 0, 2));
$form_kind5 = trim(substr(filter_input(INPUT_POST, 'form_kind5'), 0, 2));
$form_kind6 = trim(substr(filter_input(INPUT_POST, 'form_kind6'), 0, 2));
$form_kind7 = trim(substr(filter_input(INPUT_POST, 'form_kind7'), 0, 2));
$form_kind8 = trim(substr(filter_input(INPUT_POST, 'form_kind8'), 0, 2));
$form_kind9 = trim(substr(filter_input(INPUT_POST, 'form_kind9'), 0, 2));
$form_kind10 = trim(substr(filter_input(INPUT_POST, 'form_kind10'), 0, 2));

/**
 * 
 * Dynamische Variablen für die Einheiten freischalten
 * 
 */
require('einheiten.php');


/**
 * 
 * Funktionen für die Kontrolle der Versuche
 * 
 */
require('check.php');

/**
 * 
 * Verhindert, dass beim Zurück auf diese Seite
 * diese wieder dargestellt wird
 * 
 */
if (intval(selectSubmitSession($conn)['back']) === 1 && selectSubmitSession($conn)['referrer'] == '') {
    updateSubmitBackClear($conn, selectSubmitId($conn));
    header("Location: " . $url . "index.php");

    #header("Location: " . $url . "senden/index.php");
    #echo selectSubmitSession($conn)['referrer'] . ' ggg';
}



/**
 * 
 * Funktionen für Daten aus der `config`
 * 
 */
#require('fct.php');


/**
 * 
 * Anfrage senden
 * 
 */
$error_msg = [];

if ($senden == 'Anfrage senden') {

    ##### UPDATE SUBMIT attempt => check.php
    updateSubmit($conn, selectSubmitSession($conn));


    ### Kontrolle versuchte Script-Eingabe
    $all_filds = $form_anreise . $form_abreise . $form_name . $form_email . $form_telefon . $form_plz . $form_strasse . $form_kommentar;
    $bad_error = [];
    $bad_strings = ['iframe', 'src', 'href', 'script', 'include', 'php', '.html', '.js', '.pdf'];
    foreach ($bad_strings as $bad_msg) {

        if (str_contains($all_filds, $bad_msg) === true) {
            $bad_error[] = $bad_msg . '<br>';
        }
    }

    if (count($bad_error) >= 1) {

        ##### UPDATE BAD => check.php
        updateSubmitBad($conn, selectSubmitId($conn));
    }

    /*foreach ($bad_error as $bad_error_msg) {
        echo 'ERROR : ' . $bad_error_msg . '<br>';
    }*/



    ### Pflichtfelder
    if (empty($form_anreise) || strlen($form_anreise) !== 10) {
        $error_msg[] = 'Keine gültige Anreise';
    }
    if (empty($form_abreise) || strlen($form_abreise) !== 10) {
        $error_msg[] = 'Keine gültige Abreise';
    }
    if (empty($form_name) || strlen($form_name) <= 5) {
        $error_msg[] = 'Kein gültiger Name';
    }

    $count_email_error = 0;
    if (empty($form_email) || strlen($form_email) <= 5) {
        $count_email_error++;
        if (str_contains($form_email, '@') !== true) {
            $count_email_error++;
            if (str_contains($form_email, '.') !== true) {
                $count_email_error++;
            } else {
                if (strpos($form_email, '.') == strlen($form_email)) {
                    $count_email_error++;
                }
            }
        }

        if ($count_email_error >= 1) {
            $error_msg[] = 'Keine gültige E-Mail';
        }
    }
    if (empty($form_telefon) || strlen($form_telefon) <= 5) {
        $error_msg[] = 'Keine gültige Telefonnummer';
    }
    if (empty($form_einwilligung)) {
        $error_msg[] = 'Keine Einwilligung zur Beantwortung der Anfrage';
    }

    #echo count($error_msg) . '<br>';


    if (count($error_msg) === 0) {

        $html_msg = [];

        $html_msg[] = "Anreise: " . $form_anreise . "<br>";
        $html_msg[] = "Abreise: " . $form_abreise . "<br><br>";


        ####### SQL ABFRAGE in `cms_anfrage` zum Empfang und Versenden
        $selected_einheiten = [];

        $sql_einheiten_schreiben = "SELECT * FROM `cms_anfrage` WHERE freigabe = '1' ORDER BY id ASC";
        $result_einheiten_schreiben = mysqli_query($conn, $sql_einheiten_schreiben);
        $row_cnt = $result_einheiten_schreiben->num_rows;

        if ($row_cnt >= 1) {
            while ($row = mysqli_fetch_assoc($result_einheiten_schreiben)) {

                $eid = "einheit_" . $row['id'];

                if (!empty($eid)) {
                    $selected_einheiten += ['' . $eid . '' => '' . $row['id'] . ''];
                }
            }

            foreach ($selected_einheiten as $selected_einheit => $key) {

                $sql_anfrage = "SELECT * FROM `cms_anfrage` WHERE id = '" . $key . "'";
                $result_anfrage = mysqli_query($conn, $sql_anfrage);
                $row_anfrage = mysqli_fetch_assoc($result_anfrage);

                // $e_anzahl = variable Variable
                $e_anzahl = intval($$selected_einheit);

                $e_titel = $row_anfrage['titel'];
                $e_mz_titel = $row_anfrage['titel_mz'];
                $e_personen = intval($row_anfrage['personen']);
                $e_sum = $e_anzahl * $e_personen;

                mysqli_free_result($result_anfrage);

                if ($e_anzahl >= 1) {

                    $html_msg[] = $e_anzahl . ' ';

                    if (!empty($e_mz_titel) && $e_anzahl >= 2) {
                        $html_msg[] = $e_mz_titel . ' ';
                    } else {
                        $html_msg[] = $e_titel . ' ';
                    }

                    $html_msg[] = 'für ';
                    $html_msg[] = $e_sum . ' ';

                    if (intval($e_sum) <= 1) {
                        $html_msg[] = 'Person';
                    } else {
                        $html_msg[] = 'Personen';
                    }
                    $html_msg[] = "<br>";

                    #echo '<br><br>';
                }
            }
        }

        mysqli_free_result($result_einheiten_schreiben);

        /**
         * 
         * Pflichtangaben
         * 
         */

        $html_msg[] = "<br>Anrede Vorname Name: " . $form_name . "<br>";
        $html_msg[] = "E-Mail: " . $form_email . "<br>";
        $html_msg[] = "Rückrufnummer: " . $form_telefon . "<br>";

        /**
         * 
         * Kinder
         * 
         */

        if (!empty($form_kind1) || !empty($form_kind2) || !empty($form_kind3)) {
            $html_msg[] = "<br>Mitreisende Kinder<br>";
        }


        if (!empty($form_kind1)) {
            $html_msg[] = "Kind 1: " . $form_kind1 . " " . (($form_kind1 <= 1) ? "Jahr" : "Jahre") . "<br>";
        }
        if (!empty($form_kind2)) {
            $html_msg[] = "Kind 2: " . $form_kind2 . " " . (($form_kind2 <= 1) ? "Jahr" : "Jahre") . "<br>";
        }
        if (!empty($form_kind3)) {
            $html_msg[] = "Kind 3: " . $form_kind3 . " " . (($form_kind3 <= 1) ? "Jahr" : "Jahre") . "<br>";
        }
        if (!empty($form_kind4)) {
            $html_msg[] = "Kind 4: " . $form_kind4 . " " . (($form_kind4 <= 1) ? "Jahr" : "Jahre") . "<br>";
        }
        if (!empty($form_kind5)) {
            $html_msg[] = "Kind 5: " . $form_kind5 . " " . (($form_kind5 <= 1) ? "Jahr" : "Jahre") . "<br>";
        }
        if (!empty($form_kind6)) {
            $html_msg[] = "Kind 6: " . $form_kind6 . " " . (($form_kind6 <= 1) ? "Jahr" : "Jahre") . "<br>";
        }
        if (!empty($form_kind7)) {
            $html_msg[] = "Kind 7: " . $form_kind7 . " " . (($form_kind7 <= 1) ? "Jahr" : "Jahre") . "<br>";
        }
        if (!empty($form_kind8)) {
            $html_msg[] = "Kind 8: " . $form_kind8 . " " . (($form_kind8 <= 1) ? "Jahr" : "Jahre") . "<br>";
        }
        if (!empty($form_kind9)) {
            $html_msg[] = "Kind 9: " . $form_kind9 . " " . (($form_kind9 <= 1) ? "Jahr" : "Jahre") . "<br>";
        }
        if (!empty($form_kind10)) {
            $html_msg[] = "Kind 10: " . $form_kind10 . " " . (($form_kind10 <= 1) ? "Jahr" : "Jahre") . "<br>";
        }

        /**
         * 
         * Optionale Angaben
         * 
         */
        if (!empty($form_plz)) {
            $html_msg[] = "PLZ/ Ort: " . $form_plz . "<br>";
        }
        if (!empty($form_strasse)) {
            $html_msg[] = "Straße, Hausnummer: " . $form_strasse . "<br>";
        }
        if (!empty($form_kommentar)) {
            $html_msg[] = "Fragen und Wünsche: " . $form_kommentar . "<br>";
        }


        ### Inhalte der E-Mail für SQL Anweisung packen
        $email_content = "";
        foreach ($html_msg as $msg) {
            $email_content = $email_content . $msg;
        }


        ### Ziel für Location
        $go = $url . "senden/index.php";

        ##### keine böse worte

        if (count($bad_error) <= 0) {

            ###### max. 15 mal auf senden geklickt + senden == 0

            if (selectSubmitId($conn)["attempt"] <= 14 && selectSubmitId($conn)["send"] == 0) {

                ##### Sende E-Mail-Funktion
                require("mail.php");

                ##### UPDATES werden in der mail.php ausgeführt
                ##### UPDATE SEND => check.php
                ##### UPDATE BACK => check.php

            } else {

                ##### UPDATE BACK => check.php
                updateSubmitBack($conn, selectSubmitId($conn));

                ##### By By nach * Sekunden
                sleep($sleep);
                header("Location: " . $go);
                die();
            }
        }

        ##### böse worte

        else {

            ##### UPDATE BACK => check.php
            updateSubmitBack($conn, selectSubmitId($conn));

            ##### By By nach * Sekunden
            sleep($sleep);
            header("Location: " . $go);
            die();
        }
    }
}


    ### Optionale Felder
