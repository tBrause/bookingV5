<?php

/**
 * 
 * Template für die Formulare
 * 
 */
echo '<div id="main_booking">';


/**
 * 
 * JavaScript Bereich
 * 
 * 
 */
echo '<div id="js" class="hinweis">Diese Seite verwendet JavaScript.<br>Bitte aktivieren Sie JavaScript</div>';


/**
 * 
 * Cookie Bereich
 * 
 * 
 */
echo '<div id="cookie" class="hinweis">Diese Seite verwendet einen technischen Cookie.<br>Bitte aktivieren Sie Cookies</div>';


/**
 * 
 * Abfrage
 * 
 * 
 */
if ($senden === '' || ($senden == 'Anfrage senden' && count($error_msg) >= 1)) { // && count($bad_error) == 0

    /**
     * 
     * SQL Abfragen
     * `cms_menue` + `cms_inhalte`
     * 
     */

    ####### SQL ABFRAGE in `cms_menue`
    $sql = "SELECT * FROM `cms_menue` WHERE `id` = '" . $id . "' AND `sichtbar` = '1'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    $menue_id = $id;
    $menue_titel = $row['titel'];

    ####### SQL ABFRAGE in `cms_inhalte`
    $seitentitel = getSqlInhalte($conn, $menue_id)['seitentitel'];
    $absatz_id = getSqlInhalte($conn, $menue_id)['id'];

    /**
     * 
     * Seitentitel
     * 
     * 
     */
    echo '<div id="ranfrage"><h2>' . $seitentitel . '</h2></div>' . "\n";

    /**
     * 
     * FORM START
     * 
     * 
     */
    echo '<form style="font-family: \'Open Sans\', Arial, Helvetica, sans-serif;" name="Formular" method="post" action="' . getNewLink($id, $menue_titel) . '">';

    /**
     * 
     * Fehlermeldung
     * 
     * 
     */
    echo '<p class="small_info">Die mit * markierten Felder sind Pflichtfelder.</p>';
    if (count($error_msg) >= 1) {
        echo '<ul id="err_msg">';
        foreach ($error_msg as $emsg) {
            echo '<li>';
            echo $emsg . '';
            echo '</li>';
        }
        echo '</ul>';
    }

    /**
     * 
     * Auswahl des Zeitraum
     * 
     * 
     */
    echo '<div id="zeitraum">';
    echo '<div id="anreise" title="Anreise"><input id="input_anreise" name="form_anreise" class="datepicker input_booking" type="text" value="' . $form_anreise . '" placeholder="* Anreise"></div>';
    echo '<div id="abreise" title="Abreise"><input id="input_abreise" name="form_abreise" class="datepicker input_booking" type="text" value="' . $form_abreise . '" placeholder="* Abreise"></div>';
    echo '<div class="clbo">&nbsp;</div>';
    echo '</div>';


    /**
     * 
     * Auswahl der Einheiten
     * 
     * 
     */
    echo '<div id="einheiten">';

    ####### SQL ABFRAGE in `cms_anfrage` mit ID
    $sql_einheiten = "SELECT * FROM `cms_anfrage` WHERE absatz_id = '" . $menue_id . "' AND freigabe = '1' ORDER BY position ASC";
    $result_einheiten = mysqli_query($conn, $sql_einheiten);

    if ($result_einheiten->num_rows >= 1) {

        $einheit_count = 1;

        while ($row = mysqli_fetch_assoc($result_einheiten)) {

            $einheit = 'einheit_' . $row['id'];
            $einheit_value = ${"einheit_" . $row['id']};

            ##### Auswahlfeld Einheit
            echo '<select class="select_booking" name="' . $einheit . '">';
            echo '<option class="option_booking" value="0">' . $row['titel'] . '</option>';

            ### Option => Zeilen schreiben
            for ($i = 0; $i < $row['anzahl']; $i++) {

                $option_id = $i + 1;
                $personen = $row['personen'] * ($i + 1);

                ### Überprüfe ob die Einheit ausgewählt wurde
                if ($option_id == $einheit_value) {
                    $selected = " selected='selected'";
                } else {
                    $selected = "";
                }

                ### Gibt es eine Mehrzahl der Einheit
                if ($row['titel_mz'] != "" && $option_id > 1) {
                    $einheiten_ausgabe = $row['titel_mz'];
                } else {
                    $einheiten_ausgabe = $row['titel'];
                }

                $ausgabe_personen = '';
                if ($personen !== 0) {
                    $ausgabe_personen = ' für ' . $personen  . ' ' . (($personen > 1) ? 'Personen' : 'Person') . '';
                }
                echo '<option class="option_booking" value="' . $option_id . '"' . $selected . '> ' . ($i + 1) . $einheiten_ausgabe . $ausgabe_personen . '</option>';
            }

            echo '</select>';
        }
    }

    echo '<div class="clbo">&nbsp;</div>';
    echo '</div>';


    /**
     * 
     * PFLICHTFELDER
     * 
     * 
     */
    echo '<div id="pflichtfelder">';

    # Anrede Vorname Name
    $not_sel_name = '';
    if ($senden == 'Anfrage senden' && (empty($form_name) || strlen($form_name) <= 10)) {
        $not_sel_name = ' not_selected';
    }
    echo '<div id="name"><input class="inputfeld input_booking' . $not_sel_name . '" name="form_name" type="text" value="' . htmlspecialchars($form_name, ENT_QUOTES) . '" maxlength="40" placeholder="* Anrede Vorname Name"></div>';

    # E-Mail
    $not_sel_email = '';
    if ($senden == 'Anfrage senden' && (empty($form_email) || strlen($form_email) <= 10)) {
        $not_sel_email = ' not_selected';
    }
    echo '<div id="email"><input class="inputfeld input_booking' . $not_sel_email . '" name="form_email" type="text" value="' . htmlspecialchars($form_email, ENT_QUOTES) . '" maxlength="40" placeholder="* E-Mail Adresse"></div>';

    # Telefon als Pflichtfeld
    $not_sel_telefon = '';
    if ($senden == 'Anfrage senden' && (empty($form_telefon) || strlen($form_telefon) <= 10)) {
        $not_sel_telefon = ' not_selected';
    }
    echo ' <div class="div_input_booking" id="opt_kontakt_telefon"><input class="inputfeld input_booking' . $not_sel_telefon . '" name="form_telefon" type="text" value="' . htmlspecialchars($form_telefon, ENT_QUOTES) . '" maxlength="100" placeholder="* R&uuml;ckrufnummer"></div>';

    echo '<div class="clbo">&nbsp;</div>';
    echo '</div>';


    /**
     * 
     * KINDER
     * 
     * 
     */
    $kinder = intval(getConfig($conn)['kinder']);
    $kinder_alter = intval(getConfig($conn)['kinder_alter']);

    if ($kinder !== 0) {

        ### KINDER öffnen
        echo '<div id="kinder_link" class="kextra"><span class="icons_booking fa-child"></span><span class="kinder_span">Mitreisende Kinder</span></div>';
        echo '<div id="kinder_div">';

        echo '<ul id="alter_kinder">';

        for ($i = 1; $i < ($kinder + 1); $i++) {

            $kind = 'form_kind' . $i . '';

            echo '<li>';
            echo '<select name="form_kind' . $i . '">';

            echo '<option value="0"' . ((intval($$kind) === 0) ? " selected" : "") . '>Kind ' . $i . '</option>';

            for ($ii = 1; $ii <= $kinder_alter; $ii++) {
                echo '<option value="' . $ii . '"' . ((intval($$kind) === $ii) ? " selected" : "") . '>' . $ii . ' Jahre</option>';
            }

            echo '</select>';
            echo '</li>';
        }

        echo '</ul>';

        echo '<div class="clbo">&nbsp;</div>';
        echo '</div>';
    }


    /**
     * 
     * Optionen
     * 
     * 
     */
    ### Optionen öffnen
    echo '<div id="option_link"><a href="#open_opt_kontakt" class="icons_booking fa-angle-double-down"><span class="option_link_span">Optionale Angaben</span></a></div>';
    echo '<div id="option_div">';

    ### OPTIONEN
    ### Telefon optional
    //echo '<div class="div_input_booking" id="opt_kontakt_telefon"><input class="inputfeld input_booking" name="form_telefon" type="text" value="' . $form_telefon . '" maxlength="100" placeholder="R&uuml;ckrufnummer"></div>';
    echo '<div class="div_input_booking" id="opt_kontakt_strasse"><input class="inputfeld input_booking" name="form_strasse" type="text" value="' . htmlspecialchars($form_strasse, ENT_QUOTES) . '" maxlength="100" placeholder="Stra&szlig;e, Hausnummer (optional)"></div>';
    echo '<div class="div_input_booking" id="opt_kontakt_ort"><input class="inputfeld input_booking" name="form_plz" type="text" value="' . htmlspecialchars($form_plz, ENT_QUOTES) . '" maxlength="100" placeholder="PLZ/ Ort (optional)"></div>';

    #echo '<div class="div_input_booking" id="opt_kontakt_firma"><input class="inputfeld input_booking" name="form_firma" type="text" value="' . htmlspecialchars($form_firma, ENT_QUOTES) . '" maxlength="100" placeholder="Firma"></div>';
    #echo '<div class="div_input_booking" id="opt_kontakt_ansprechpartner"><input class="inputfeld input_booking" name="form_ansprechpartner" type="text" value="' . htmlspecialchars($form_ansprechpartner, ENT_QUOTES) . '" maxlength="100" placeholder="Ansprechpartner"></div>';
    echo '<div id="nachricht"><textarea id="kommentar" name="form_kommentar" rows="5" placeholder="Ihre Fragen und W&uuml;nsche">' . htmlspecialchars($form_kommentar, ENT_QUOTES) . '</textarea></div>';

    echo '<div class="clbo">&nbsp;</div>';
    echo '</div>';


    /**
     * 
     * Einwilligung
     * 
     * 
     */
    echo '<div id="einwilligung">';
    echo '<div style="display:inline-block;">';
    echo '<label>';
    echo '<div id="einwilligung_checkbox" style="background-color:#fff;"><input name="form_einwilligung" type="checkbox" value="1"' . (($form_einwilligung === "1") ? ' checked' : '') . '></div>';
    echo '<div id="einwilligung_text"> * 
Ich stimme hiermit ausdr&uuml;cklich zu, dass meine Daten zur Beantwortung meiner Anfrage elektronisch erhoben und gespeichert werden. Ich bin &uuml;ber 18 Jahre alt. Hinweis: Diese Daten werden nicht an Dritte weitergegeben und ausschlie&szlig;lich zur Bearbeitung Ihrer Anfrage genutzt. Sie k&ouml;nnen Ihre Einwilligung jederzeit f&uuml;r die Zukunft per E-Mail an <a href="mailto:' . htmlspecialchars(getConfig($conn)['email'], ENT_QUOTES) . '">' . htmlspecialchars(getConfig($conn)['email'], ENT_QUOTES) . '</a> widerrufen.
</div>';
    echo '</label>';
    echo '<div class="clbo">&nbsp;</div>';
    echo '</div>';
    echo '</div>';


    /**
     * 
     * Verstecktes Feld
     * Anfrage senden
     * 
     * 
     */
    echo '<div id="sicherheit">';

    echo '<div id="submit_booking"><input type="hidden" name="template_id" value="' . $id . '">';
    echo '<input id="submit_booking_input" name="senden" type="submit" value="Anfrage senden"></div>';

    echo '<div class="clbo">&nbsp;</div>';
    echo '</div>';


    /**
     * 
     * FORM ENDE
     * 
     * 
     */
    echo '</form>';
}

/**
 * 
 * Wenn Anfrage senden gecklickt wurde
 * wird mit JS dieser Bereich eingeblendet
 * 
 * 
 */
echo '<div id="send">Ihre Anfrage wird gesendet</div>';


/**
 * 
 * Impressum & Datenschutz
 * 
 */
echo '<ul id="impdata">';
echo '<li><a href="' . htmlspecialchars(getConfig($conn)['linkImpressum'], ENT_QUOTES) . '" target="_blank">Impressum</a></li>';
echo '<li><a href="' . htmlspecialchars(getConfig($conn)['linkDatenschutz'], ENT_QUOTES) . '" target="_blank">Datenschutz</a></li>';
echo '</ul>';


/**
 * 
 * Template für die Formulare ENDE
 * 
 */
echo '<div class="clbo">&nbsp;</div>';
echo '</div>';
