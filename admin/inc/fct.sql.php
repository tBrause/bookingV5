<?php
################# require main.php => SQL UPDATE & INSERT ###

# use function PHPSTORM_META\type;

/**
 * 
 * 
 * SQL für Formulare
 * 
 * 
 * 
 */

# INSERT `cms_menue` && INSERT `cms_inhalte`
if ($area === '2' && $submit_menue === 'anlegen') {

    # ID
    $new_id = date("YmdHis", time());

    # COUNT MENÜPUNKTE
    $sql_select_position = "SELECT * FROM `cms_menue` WHERE `ebene` = '1' AND `menue` = '1'"; //  AND (`template_id` = '20' OR `template_id` = '22')
    $result = mysqli_query($conn, $sql_select_position);
    $count = $result->num_rows;
    #echo $count . '<br>';

    #$sql_select_position = "SELECT MAX(position) AS p FROM `cms_menue` WHERE `ebene` = '1' AND `menue` = '1'";
    $sql_select_position = "SELECT MAX(position) AS p FROM `cms_menue`";
    $result = mysqli_query($conn, $sql_select_position);
    $row = mysqli_fetch_assoc($result);
    $count = $row['p'];

    mysqli_free_result($result);

    $sql_insert_menue = "INSERT INTO `cms_menue` 
    (`id`, 
    `template_id`, 
    `sprachen_nr`, 
    `position`, 
    `ebene`, 
    `menue`, 
    `titel`, 
    `datum`, 
    `uhrzeit`, 
    `sichtbar`, 
    `domain`, 
    `html_name`, 
    `startseite`, 
    `textextra`, 
    `icon`) 
    VALUE 
    ('" . $new_id . "',
     '20', 
     '1', 
     '" . ($count + 1) . "', 
     '1', 
     '1', 
     '" . $form_menue_titel . "', 
     '" . date("d.m.Y", time()) . "', 
     '" . date("H:i", time()) . "', 
     '" . $form_menue_freigabe . "', 
     '', 
     '" . getNewLink($new_id, $form_menue_titel) . "', 
     '0', 
     '', 
     '')";
    #echo $sql_insert_menue . '<br>';
    mysqli_query($conn, $sql_insert_menue);
    #mysqli_free_result($result);

    $sql_insert_inhalte = "INSERT INTO `cms_inhalte` 
    (`id`, 
    `menu_id`, 
    `sprachen_nr`, 
    `position`, 
    `absatztyp`, 
    `mehrfach_menu_id`, 
    `mehrfach_inhalt_id`, 
    `text1`, 
    `image_title1`, 
    `image_subline1`, 
    `linkauswahl1`, 
    `text2`, 
    `image_title2`, 
    `image_subline2`, 
    `linkauswahl2`, 
    `untertitel3`, 
    `text3`, 
    `image_title3`, 
    `image_subline3`, 
    `linkauswahl3`, 
    `untertitel4`, 
    `text4`, 
    `image_title4`, 
    `image_subline4`, 
    `linkauswahl4`, 
    `untertitel5`, 
    `text5`, 
    `image_title5`, 
    `image_subline5`, 
    `linkauswahl5`, 
    `sichtbar`, 
    `email`) 
    VALUES 
    ('" . $new_id . "', 
    '" . $new_id . "', 
    '1', 
    '01', 
    '20', 
    '', 
    '', 
    '', 
    '', 
    '', 
    '0', 
    '', 
    '', 
    '', 
    '0', 
    '', 
    '', 
    '', 
    '', 
    '0', 
    '', 
    '', 
    '', 
    '', 
    '0', 
    '', 
    '', 
    '', 
    '', 
    '0',
    '1', 
    '')";

    #echo $sql_insert_inhalte . '<br>';
    mysqli_query($conn, $sql_insert_inhalte);

    header('Location: main.php?area=' . $area . '&fct=edit&id=' . $new_id . '');
}

# UPDATE `cms_menue`
if ($area === '2' && $fct === 'edit' && $submit_menue_update === 'speichern') {

    $sql_titel = mysqli_escape_string($conn, $form_menue_titel);
    #echo $sql_titel . '<br>';

    $sql = "UPDATE `cms_menue` 
    SET 
    `titel` = '" . $sql_titel . "', 
    `sichtbar` = '" . $form_menue_freigabe . "' 
    WHERE id = '" . $id . "'";
    echo $sql . '<br>';

    $result = mysqli_query($conn, $sql);

    #mysqli_close($conn);


    ##### wechsle zur Startseite des aktuellen Breiches
    header('Location: main.php?area=' . $area . '&fct=' . $fct . '&id=' . $id . '');

    ##### beende dieses Script
    die();
}

# UPDATE `cms_inhalte`
if ($area === '2' && $fct === 'edit' && $submit_inhalt === 'speichern') {

    echo $inhalte_id . '<br>';
    echo $form_inhalt_seitentitel . '<br>';
    echo $form_inhalt_freigabe . '<br>';

    $sql_seitentitel = mysqli_escape_string($conn, $form_inhalt_seitentitel);

    $sql = "UPDATE `cms_inhalte` 
    SET 
    `seitentitel` = '" . $sql_seitentitel . "' 
    WHERE id = '" . $inhalte_id . "'";

    echo $sql . '<br>';
    $result = mysqli_query($conn, $sql);

    mysqli_close($conn);

    header('Location: main.php?area=' . $area . '&fct=' . $fct . '&id=' . $id . '');
}

# INSERT `cms_anfrage`
if ($area === '2' && $fct === 'edit' && $submit_neue_einheit === 'anlegen') {

    if (empty($form_anfrage_titel)) {
        $meldung[] = 'Bitte geben Sie einen Titel ein';
    }

    if (empty($meldung)) {

        # Position
        $new_position = getSqlAnfrageCount($conn, $id) + 1;

        $sql = "INSERT INTO `cms_anfrage` 
        (`absatz_id`, `titel`, `titel_mz`, `anzahl`, `personen`, `position`, `freigabe`) 
        VALUE 
        ('" . $id . "', 
        '" . mysqli_escape_string($conn, $form_anfrage_titel) . "', 
        '" . mysqli_escape_string($conn, $form_anfrage_titel_mz) . "', 
        '" . $form_anfrage_anzahl . "', 
        '" . $form_anfrage_personen . "', 
        '" . $new_position . "', 
        '" . $form_anfrage_freigabe . "')";
        //echo $sql . '<br>';

        mysqli_query($conn, $sql);
    }

    header('Location: main.php?area=' . $area . '&fct=' . $fct . '&id=' . $id . '');
}
# INSERT `cms_anfrage` => kopieren nach Vorlage
if ($area === '2' && $fct === 'edit' && $submit_neue_einheit === 'kopieren') {

    # Position
    $new_position = getSqlAnfrageCount($conn, $id) + 1;

    $absatz_id = $id;
    $titel = getSqlAnfrage($conn, $form_anfrage_vorlage)['titel'];
    $titel_mz = getSqlAnfrage($conn, $form_anfrage_vorlage)['titel_mz'];
    $anzahl = getSqlAnfrage($conn, $form_anfrage_vorlage)['anzahl'];
    $personen = getSqlAnfrage($conn, $form_anfrage_vorlage)['personen'];

    $sql = "INSERT INTO `cms_anfrage` 
    (`absatz_id`, `titel`, `titel_mz`, `anzahl`, `personen`, `position`, `freigabe`) 
    VALUE 
    ('" . $id . "', 
    '" . mysqli_escape_string($conn, $titel) . "', 
    '" . mysqli_escape_string($conn, $titel_mz) . "', 
    '" . $anzahl . "', 
    '" . $personen . "', 
    '" . $new_position . "', 
    '1')";
    #echo $sql . '<br>';

    mysqli_query($conn, $sql);

    header('Location: main.php?area=' . $area . '&fct=' . $fct . '&id=' . $id . '');
}

# UPDATE `cms_anfrage` => position ändern
if ($area === '2' && $fct === 'edit' && !empty($position)) {

    if ($urlection === 'up') {
        $pos_change = $position - 1;
    } else {
        $pos_change = $position + 1;
    }

    # setze die position von dem wechselnden Eintrag auf 0
    $sql_update_temp = "UPDATE `cms_anfrage` SET `position` = '0' WHERE absatz_id = '" . $id . "' AND position = '" . $pos_change . "'";
    mysqli_query($conn, $sql_update_temp);

    # setze die position von dem geklicktem auf die neu Position
    $sql_update_click = "UPDATE `cms_anfrage` SET `position` = '" . $pos_change . "' WHERE absatz_id = '" . $id . "' AND position = '" . $position . "'";
    mysqli_query($conn, $sql_update_click);

    # setze die position von dem wechselnden Eintrag von 0 auf die neu Position
    $sql_update = "UPDATE `cms_anfrage` SET `position` = '" . $position . "' WHERE absatz_id = '" . $id . "' AND position = '0'";
    mysqli_query($conn, $sql_update);

    header('Location: main.php?area=' . $area . '&fct=' . $fct . '&id=' . $id . '');
}

# UPDATE `cms_anfrage`
if ($area === '2' && $fct === 'edit' && $submit_anfrage === 'speichern') {

    $sql = "UPDATE `cms_anfrage` 
    SET 
        `titel` = '" . $form_anfrage_titel . "', 
        `titel_mz` = '" . $form_anfrage_titel_mz . "', 
        `anzahl` = '" . $form_anfrage_anzahl . "', 
        `personen` = '" . $form_anfrage_personen . "', 
        `freigabe` = '" . $form_anfrage_freigabe . "' 
    WHERE id = '" . $absatz_id . "'";
    #echo $sql . '<br>';
    mysqli_query($conn, $sql);
    mysqli_close($conn);
    header('Location: main.php?area=' . $area . '&fct=' . $fct . '&id=' . $id . '');
}

# DELETE `cms_anfrage`
if ($area === '2' && $fct === 'edit' && $loeschen_anfrage === 'Einheit löschen' && $checkdelet === '1') {

    $sql = "DELETE FROM `cms_anfrage` WHERE `id` = '" . $absatz_id . "'";
    #echo $sql . '<br>';

    mysqli_query($conn, $sql);

    header('Location: main.php?area=' . $area . '&fct=' . $fct . '&id=' . $id . '');
}

# DELETE `cms_anfrage` && DELETE `cms_inhalte` && DELETE `cms_menue`
if ($area === '2' && $fct === 'edit' && $loeschen_menue === 'Seite löschen' && $checkdelet === '1') {

    # suche absatz_id in cms_inhalte
    $sql_search_anfrage = "SELECT * FROM `cms_inhalte` WHERE menu_id = '" . $id . "'";
    #echo $sql_search_anfrage . '<br>';
    $result = mysqli_query($conn, $sql_search_anfrage);
    $row = mysqli_fetch_assoc($result);
    mysqli_free_result($result);

    # lösche alle absätze von diesem absatz
    $sql_del_anfrage = "DELETE FROM `cms_anfrage` WHERE absatz_id = '" . $row['id'] . "'";
    #echo $sql_del_anfrage . '<br>';
    mysqli_query($conn, $sql_del_anfrage);

    # lösche den absatz
    $sql_del_inhalte = "DELETE FROM `cms_inhalte` WHERE menu_id = '" . $id . "'";
    #echo $sql_del_inhalte . '<br>';
    mysqli_query($conn, $sql_del_inhalte);

    # lösche den menüpunkt
    $sql_del_menue = "DELETE FROM `cms_menue` WHERE id = '" . $id . "'";
    #echo $sql_del_menue . '<br>';
    mysqli_query($conn, $sql_del_menue);


    ##### wechsle zur Startseite des aktuellen Breiches
    header('Location: main.php?area=' . $area . '');

    ##### beende dieses Script
    die();
}



/**
 * 
 * 
 * SQL für Highlight-Navigation
 * 100%
 * 
 * 
 */

# UPDATE `bubbles`
if ($area === '3' && $fct === 'edit' && $submit_bubbles_update === 'speichern') {

    # check input
    if (empty($form_type) || $form_type === 0) {
        $meldung[] = 'Bitte wählen Sie den Typ des Buttons aus';
    }
    if (empty($form_bubble_titel)) {
        $meldung[] = 'Bitte geben Sie einen Titel ein';
    }
    if (empty($form_bubble_icon)) {
        $meldung[] = 'Bitte wählen Sie ein Icon aus';
    }
    if (empty($form_bubble_link)) {
        $meldung[] = 'Bitte geben Sie einen Link';
    }

    if (empty($meldung)) {

        ##### SQL SELECT FROM `bubbles` WHERE id
        $sql_pos_org = "SELECT `position` FROM `bubbles` WHERE id = '" . $id . "'";
        $result_pos_org = mysqli_query($conn, $sql_pos_org);
        $row_pos_org = mysqli_fetch_array($result_pos_org);
        mysqli_free_result($result_pos_org);

        ##### WENN DIE POSITION GEÄNDERT WIRD
        if ($row_pos_org['position'] != $form_bubble_position) {

            ##### IST DIE ORIGINALE POSITION KLEINER
            if ($row_pos_org['position'] <= $form_bubble_position) {

                for ($i = 1; $i <= $form_bubble_position - $row_pos_org['position']; $i++) {

                    ##### SQL SELECT FROM `bubbles` WHERE position + $i
                    $sql_pos_search = "SELECT `position`, `id` FROM `bubbles` WHERE position = '" . $row_pos_org['position'] + $i . "'";
                    $result_pos_search = mysqli_query($conn, $sql_pos_search);
                    $row_pos_search = mysqli_fetch_array($result_pos_search);

                    ##### SQL UPDATE `bubbles`
                    ##### Verschiebt betroffene Bubbles nach Oben
                    $sql_new = "UPDATE `bubbles` 
                    SET 
                    `position` = '" . $row_pos_search['position'] - 1 . "'
                    WHERE id = '" . $row_pos_search['id'] . "'";
                    #echo $sql_new . '<br>';
                    $result = mysqli_query($conn, $sql_new);
                    #mysqli_free_result($result);
                }
            } else {

                ##### IST DIE ORIGINALE POSITION GROßER
                for ($i = 1; $i <= $row_pos_org['position'] - $form_bubble_position; $i++) {

                    ##### SQL SELECT FROM `bubbles` WHERE position - $i
                    $sql_pos_search = "SELECT `position`, `id` FROM `bubbles` WHERE position = '" . $row_pos_org['position'] - $i . "'";
                    $result_pos_search = mysqli_query($conn, $sql_pos_search);
                    $row_pos_search = mysqli_fetch_array($result_pos_search);

                    ##### SQL UPDATE `bubbles`
                    ##### Verschiebt betroffene Bubbles nach Unten
                    $sql_new = "UPDATE `bubbles` 
                    SET 
                    `position` = '" . $row_pos_search['position'] + 1 . "'
                    WHERE id = '" . $row_pos_search['id'] . "'";
                    #echo $sql_new . '<br>';
                    $result = mysqli_query($conn, $sql_new);
                    #mysqli_free_result($result);
                }
            }
        }

        ##### SQL UPDATE `bubbles` WHERE id
        $sql_titel = mysqli_escape_string($conn, $form_bubble_titel);

        $sql = "UPDATE `bubbles` 
        SET 
        `type` = '" . $form_type . "', 
        `title` = '" . $sql_titel . "', 
        `icon` = '" . $form_bubble_icon . "', 
        `link` = '" . $form_bubble_link . "', 
        `position` = '" . $form_bubble_position . "'
        WHERE id = '" . $id . "'";
        echo $sql . '<br>';

        $result = mysqli_query($conn, $sql);
        #mysqli_free_result($result);
        #mysqli_close($conn);

        ##### erstelle die Highlight-Navigation neu
        require('../inc/snav.php');

        ##### wechsle zur Startseite des aktuellen Breiches
        header('Location: main.php?area=' . $area . '');

        ##### beende dieses Script
        die();
    }
}

# INSERT `bubbles``
if ($area === '3' && $fct === 'newbubble' && $submit_bubbles_insert === 'anlegen') {

    # check input
    if (empty($form_type) || $form_type === 0) {
        $meldung[] = 'Bitte wählen Sie den Typ des Buttons aus';
    }
    if (empty($form_bubble_titel)) {
        $meldung[] = 'Bitte geben Sie einen Titel ein';
    }
    if (empty($form_bubble_icon)) {
        $meldung[] = 'Bitte wählen Sie ein Icon aus';
    }
    if (empty($form_bubble_link)) {
        $meldung[] = 'Bitte geben Sie einen Link';
    }

    if (empty($meldung)) {

        $sql_bubble_count = "SELECT `position` FROM `bubbles`";
        $result_bubble_count = mysqli_query($conn, $sql_bubble_count);
        $bubble_count = $result_bubble_count->num_rows;

        $sql = "INSERT INTO `bubbles` 
        (`type`, `title`, `icon`, `link`, `position`) 
        VALUE 
        ('" . $form_type . "', '" . mysqli_escape_string($conn, $form_bubble_titel) . "', '" . $form_bubble_icon . "', '" . $form_bubble_link . "', '" . $bubble_count + 1 . "')";
        echo $sql . `<br>`;
        $result = mysqli_query($conn, $sql);

        ##### erstelle die Highlight-Navigation neu
        require('../inc/snav.php');

        ##### wechsle zur Startseite des aktuellen Breiches
        header('Location: main.php?area=' . $area . '');

        ##### beende dieses Script
        die();
    }
}

# DELETE `bubbles` + UPDATE => Position vorhandener Buttons anpassen 
if ($area === '3' && $fct === 'edit' && $submit_bubbles_delete === 'löschen') {

    ##### Wurde löschen bestätigt geklickt
    if (intval($checkdelet) === 1) {

        ##### SQL SELECT FROM `bubbles` COUNT
        ##### $count_pos zum Vergleich mit $form_bubble_position (Aktuelle Position)
        $sql_pos = "SELECT `position`, `id` FROM `bubbles` ORDER BY position";
        $result_pos = mysqli_query($conn, $sql_pos);
        $count_pos = $result_pos->num_rows;

        ##### Wenn der zu löschende Button nicht der letzte ist
        if (intval($form_bubble_position) !== $count_pos) {

            ##### SQL SELECT FROM `bubbles` > Aktuelle Position
            $sql_pos_from = "SELECT `position`, `id` FROM `bubbles` WHERE position > " . $form_bubble_position . "";
            $result_pos_from = mysqli_query($conn, $sql_pos_from);

            while ($row_pos_from = mysqli_fetch_array($result_pos_from)) {

                ##### Setze die Position für die verbleibenden Buttons 1 hoch
                $sql_update_positon = "UPDATE `bubbles` 
                SET 
                `position` = '" . $row_pos_from['position'] - 1 . "'
                WHERE id = '" . $row_pos_from['id'] . "'";
                #echo $sql_update_positon . '<br>';
                $result = mysqli_query($conn, $sql_update_positon);
            }
        }

        ##### Lösche den Button
        $sql_delete_bubble = "DELETE FROM `bubbles` WHERE id = '" . $id . "'";
        #echo $sql_delete_bubble . '<br>';
        $result = mysqli_query($conn, $sql_delete_bubble);

        ##### Erstelle die Highlight-Navigation neu
        require('../inc/snav.php');

        ##### wechsle zur Startseite des aktuellen Breiches
        header('Location: main.php?area=' . $area . '');

        ##### beende dieses Script
        die();
    }
}



/**
 * 
 * 
 * SQL für Benutzer
 * 100%
 * 
 * 
 */

# UPDATE user
if ($area === '5' && $fct === 'edit' && $button === 'speichern') {

    # check input
    if (empty($userstatus)) {
        $meldung[] = 'Bitte wählen Sie einen Status aus';
    }
    if (empty($email)) {
        $meldung[] = 'Bitte geben Sie eine E-Mail ein';
    }
    if (empty($username)) {
        $meldung[] = 'Bitte geben Sie einen Benutzername ein';
    }

    if (empty($meldung)) {
        $sql = "UPDATE `user` 
        SET 
            `departmentId` = '" . $userstatus . "', 
            `name` = '" . mysqli_escape_string($conn, $name) . "', 
            `firstname` = '" . mysqli_escape_string($conn, $firstname) . "', 
            `email` = '" . $email . "', 
            `username` = '" . mysqli_escape_string($conn, $username) . "', 
            `release` = '" . $freigabe . "' 
        WHERE id = '" . $id . "'";
        #echo $sql;
        $result = mysqli_query($conn, $sql);
        mysqli_close($conn);
        header('Location: main.php?area=' . $area . '');
    }
}

# UPDATE user password
if ($area === '5' && $fct === 'newpassword' && $button === 'speichern') {

    # check input
    if (empty($password)) {
        $meldung[] = 'Bitte geben Sie ein Passwort ein';
    }
    if (!empty($password) && strlen($password) <= 7) {
        $meldung[] = 'Das Passwort ist zu kurz';
    }
    if (empty($password_check)) {
        $meldung[] = 'Bitte wiederholen Sie das Passwort';
    }
    if (!empty($password) && !empty($password_check)) {
        if ($password != $password_check) {
            $meldung[] = 'Passwort stimmt nicht überein';
        }
    }

    if (empty($meldung)) {
        $sql = "UPDATE `user` 
        SET 
            `password` = '" . password_hash($password, PASSWORD_DEFAULT) . "' 
        WHERE id = '" . $id . "'";
        #echo $sql;
        $result = mysqli_query($conn, $sql);
        mysqli_close($conn);
        header('Location: main.php?area=' . $area . '');
    }
}

# INSERT user
if ($area === '5' && $sub === '10' && $button === 'speichern') {

    # check input
    if (empty($userstatus)) {
        $meldung[] = 'Bitte wählen Sie einen Status aus';
    }
    if (empty($email)) {
        $meldung[] = 'Bitte geben Sie eine E-Mail ein';
    }
    if (empty($username)) {
        $meldung[] = 'Bitte geben Sie einen Benutzername ein';
    }
    if (empty($password)) {
        $meldung[] = 'Bitte geben Sie ein Passwort ein';
    }
    if (empty($password_check)) {
        $meldung[] = 'Bitte wiederholen Sie das Passwort';
    }
    if (!empty($password) && !empty($password_check)) {
        if ($password != $password_check) {
            $meldung[] = 'Passwort stimmt nicht überein';
        }
    }

    if (empty($meldung)) {
        $sql = "INSERT 
        INTO `user` 
            (`departmentId`, `name`, `firstname`, `email`, `username`, `password`, `release`)
        VALUES
            ('" . $userstatus . "', '" . $name . "', '" . $firstname . "', '" . $email . "', '" . $username . "', '" . password_hash($password, PASSWORD_DEFAULT) . "', '" . $freigabe . "')";
        #echo $sql;
        $result = mysqli_query($conn, $sql);
        mysqli_close($conn);
        header('Location: main.php?area=' . $area . '');
    }
}


/**
 * 
 * 
 * SQL für Einstellungen
 * 
 * 
 * 
 */

# UPDATE config
if ($area === '13' && $submit_einstellungen === 'speichern') {

    if (empty($form_smtpHost)) {
        $meldung[] = 'Bitte geben Sie einen smtpHost ein';
    }
    if (empty($form_smtpPort)) {
        $meldung[] = 'Bitte geben Sie einen smtpPort ein';
    }
    if (empty($form_smtpUsername)) {
        $meldung[] = 'Bitte geben Sie einen smtpUsername ein';
    }
    if (empty($form_smtpPassword)) {
        $meldung[] = 'Bitte geben Sie einen smtpPassword ein';
    }
    if (empty($form_email)) {
        $meldung[] = 'Bitte geben Sie einen form_email ein';
    }
    if (empty($form_email_description)) {
        $meldung[] = 'Bitte geben Sie einen form_email_description ein';
    }

    if (empty($meldung)) {

        ##### UPDATE `config`
        $sql = "UPDATE `config` 
        SET 
            `smtpUsername` = '" . $form_smtpUsername . "', 
            `smtpPassword` = '" . $form_smtpPassword . "', 
            `smtpHost` = '" . $form_smtpHost . "', 
            `smtpPort` = '" . $form_smtpPort . "', 
            `linkImpressum` = '" . $form_linkImpressum . "', 
            `linkDatenschutz` = '" . $form_linkDatenschutz . "', 
            `email` = '" . $form_email . "', 
            `email_description` = '" . $form_email_description . "', 
            `kinder` = '" . $form_kinder . "', 
            `kinder_alter` = '" . $form_alter_kinder . "'
        WHERE id = '1'";
        #echo $sql;
        $result = mysqli_query($conn, $sql);

        ##### wechsle zur Startseite des aktuellen Breiches
        header('Location: main.php?area=' . $area . '');

        ##### beende dieses Script
        die();
    }
}
