<?php
################# require main.php => switsh ###


################# Inhalt der Seite: Formulare

function displayMenue($conn, $area, $id, $fct, $url)
{
    # Formular: Bearbeiten
    if ($fct === "edit" && empty($sub)) {

        displayEditFormular($conn, $area, $id, $fct, $url);
    }

    # Formular: Neu
    elseif ($fct === "newform" && empty($sub)) {

        displayNewFormular($conn, $area, $id, $fct, $url);
    }

    # Formular: Zeigen
    else {
        displayMenueMain($conn, $area, $id, $fct);
    }
}

function displayNewFormular($conn, $area, $id, $fct, $url)
{

    ######## Formular / Form Start
    echo '<h2>Neues Formular erstellen</h2>';
    #echo '<a href="' . $url . getLink($conn, $id) . '" target="_blank">' . getLink($conn, $id) . '</a>';
    echo '<ul class="edit_einheit"><li>';
    echo '<form class="zeile_inhalte" method="post" action="' . $_SERVER['SCRIPT_NAME'] . '">';

    ######## Name der Seite / Link
    echo '<fieldset class="input_seitentitel">';
    echo '<legend>Name der Seite / Link</legend>';
    echo '<input style="font-weight:700;" name="form_menue_titel" type="text" class="textfeld" value="">';
    echo '</fieldset>';

    ######## VIEW
    echo '<fieldset class="input_freigabe">';
    echo '<legend>Sichtbar</legend>';
    echo '<span class="jn">Ja</span>';
    echo '<input type="radio" name="form_menue_freigabe" value="1" checked="checked">';
    echo '<br><span class="jn">Nein</span>';
    echo '<input type="radio" name="form_menue_freigabe" value="0">';
    echo '</fieldset>';

    ######## HIDDEN 
    echo '<input type="hidden" name="area" value="' . $area . '">';
    echo '<input type="hidden" name="fct" value="' . $fct . '">';
    echo '<input type="hidden" name="id" value="' . $id . '">';
    #echo '<input type="hidden" name="menue_id" value="' . $row['id'] . '">';

    ######## SAVE
    echo '<fieldset class="input_save">';
    echo '<legend>Formular</legend>';
    echo '<input class="save_button" name="speichern_menue_neu" type="submit" value="anlegen">';
    echo '</fieldset>';

    echo '</form>';
    echo '</li></ul>';
}

function displayEditFormular($conn, $area, $id, $fct, $url)
{


    /**
     * Bereich für Daten in der Tabelle: cms_inhalte
     */

    ######## SQL Anweisung INHALT
    $sql = "SELECT 
    id, 
    menu_id, 
    seitentitel, 
    sichtbar, 
    text1 
    FROM `cms_inhalte` 
    WHERE menu_id = " . $id . "";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);

    ######## Überschrift
    echo '<h2>Überschrift</h2>';
    echo '<ul class="edit_einheit"><li class="color1">';
    echo '<form class="zeile_inhalte" method="post" action="' . $_SERVER['SCRIPT_NAME'] . '">';

    ######## Seitentitel
    echo '<fieldset class="input_seitentitel">';
    echo '<legend>Überschrift und Betreff in der E-Mail</legend>';
    echo '<input style="font-weight:700;" name="form_inhalt_seitentitel" type="text" class="textfeld" value="' . $row['seitentitel'] . '">';
    echo '</fieldset>';

    ######## HIDDEN 
    echo '<input type="hidden" name="area" value="' . $area . '">';
    echo '<input type="hidden" name="fct" value="' . $fct . '">';
    echo '<input type="hidden" name="id" value="' . $id . '">';
    echo '<input type="hidden" name="inhalte_id" value="' . $row['id'] . '">';

    ######## SAVE
    echo '<fieldset class="input_save">';
    echo '<legend>Änderung</legend>';
    echo '<input class="save_button" name="speichern_inhalt" type="submit" value="speichern">';
    echo '</fieldset>';

    echo '</form>';
    echo '</li></ul>';

    mysqli_free_result($result);

    /**
     * 
     * 
     * Bereich für Daten in der Tabelle: cms_anfrage
     * 
     * Einheiten
     * 
     */

    ######## Überschrift / Form Start
    echo '<h2>Einheiten</h2>';


    ######## SQL Anweisung
    $sql = "SELECT 
    m.template_id, 
    i.menu_id AS Inhalt, 
    i.id AS inhaltId, 
    a.id AS aId,
    a.position AS aPosition, 
    a.titel AS aTitel,
    a.titel_mz AS aTitelMz,
    a.anzahl AS aAnzahl,  
    a.personen AS aPersonen, 
    a.freigabe AS aFreigabe  
    FROM `cms_menue` AS m 
    JOIN `cms_inhalte` AS i ON i.menu_id = m.id  
    JOIN `cms_anfrage` AS a ON a.absatz_id = m.id 
    WHERE m.id = '" . $id . "' 
    ORDER BY aPosition";
    #echo $sql . '<br>';

    $result = mysqli_query($conn, $sql);

    if ($result->num_rows >= 1) {

        echo '<ul class="edit_einheit">';

        while ($row = mysqli_fetch_assoc($result)) {
            echo '<li class="color1 pos_nav">';
            echo '<form class="zeile_anfrage" method="post" action="' . $_SERVER['SCRIPT_NAME'] . '">';

            ######## Titel / Name
            echo '<fieldset class="input_title" style="display:block;">';
            echo '<legend>Einheit</legend>';
            echo '<input style="font-weight:700; margin-bottom:10px;" name="form_anfrage_titel" type="text" class="textfeld" value="' . htmlspecialchars($row['aTitel'], ENT_QUOTES) . '" placeholder="Einzahl">';
            echo '<input style="font-weight:700;" name="form_anfrage_titel_mz" type="text" class="textfeld" value="' . htmlspecialchars($row['aTitelMz'], ENT_QUOTES) . '" placeholder="Mehrzahl (nur bei Bedarf)">';
            echo '</fieldset>';

            ######## Anzahl
            echo '<fieldset style="width:100px;">';
            echo '<legend>Anzahl</legend>';
            echo '<input name="form_anfrage_anzahl" type="number" min="1" class="date" value="' . $row['aAnzahl'] . '">';
            echo '</fieldset>';

            ######## Personen
            echo '<fieldset style="width:120px;">';
            echo '<legend>Personen</legend>';
            echo '<input name="form_anfrage_personen" type="number" min="0" class="date" value="' . $row['aPersonen'] . '">';
            echo '</fieldset>';

            ######## VIEW
            echo '<fieldset class="input_freigabe">';
            echo '<legend>Sichtbar</legend>';
            echo '<span class="jn">Ja</span>';
            echo '<input type="radio" name="form_anfrage_freigabe" value="1"' . (($row['aFreigabe'] == "1") ? " checked=\"checked\"" : "") . '>';
            echo '<span class="jn">Nein</span>';
            echo '<input type="radio" name="form_anfrage_freigabe" value="0"' . (($row['aFreigabe'] == "0") ? " checked=\"checked\"" : "") . '>';
            echo '</fieldset>';

            ######## DELETE
            echo '<fieldset class="input_delete">';
            echo '<legend>Löschen</legend>';
            echo '<input title="Checkup Box - Bestätigung der Löschung" type="checkbox" name="checkdelet" value="1">';
            echo '<input title="Einheit löschen nur mit Bestätigung der Checkup Box" name="loeschen_anfrage" type="submit" value="Einheit löschen" style="width:120px; height:28px; font-weight:100;">';
            echo '</fieldset>';

            ######## HIDDEN 
            echo '<input type="hidden" name="area" value="' . $area . '">';
            echo '<input type="hidden" name="fct" value="' . $fct . '">';
            echo '<input type="hidden" name="id" value="' . $id . '">';
            echo '<input type="hidden" name="absatz_id" value="' . $row['aId'] . '">';

            ######## SAVE
            echo '<fieldset class="input_save">';
            echo '<legend>Änderung</legend>';
            echo '<input class="save_button" name="speichern_anfrage" type="submit" value="speichern">';
            echo '</fieldset>';

            echo '</form>';

            ######## Position ändern
            if ($row['aPosition'] != '1') {
                echo '<a href="' . $_SERVER['SCRIPT_NAME'] . '?area=' . $area . '&amp;fct=' . $fct . '&amp;id=' . $id . '&amp;position=' . $row['aPosition'] . '&amp;direction=up"><i class="fas fa-chevron-up"></i></a>';
            }
            if ($row['aPosition'] != $result->num_rows) {
                echo '<a href="' . $_SERVER['SCRIPT_NAME'] . '?area=' . $area . '&amp;fct=' . $fct . '&amp;id=' . $id . '&amp;position=' . $row['aPosition'] . '&amp;direction=down"><i class="fas fa-chevron-down"></i></a>';
            }
            echo '</li>';
        }
        echo '</ul>';
    } else {
        echo '<div class="noresult">Es wurden noch keine Einheit angelegt.</div>';
    }


    mysqli_free_result($result);

    /**
     * 
     * Bereich für neue Daten in die Tabelle: cms_anfrage
     * 
     */

    ######## Neue Einheit
    echo '<h2 style="margin-top:80px;">Neue Einheit</h2>';
    echo '<ul class="edit_einheit">';

    echo '<li>';
    echo '<form class="zeile_anfrage" method="post" action="' . $_SERVER['SCRIPT_NAME'] . '">';

    ######## Titel / Name
    echo '<fieldset class="input_title" style="display:block;">';
    echo '<legend>Einheit</legend>';
    echo '<input style="font-weight:700; margin-bottom:10px;" name="form_anfrage_titel" type="text" class="textfeld" value="" placeholder="Einzahl">';
    echo '<input style="font-weight:700;" name="form_anfrage_titel_mz" type="text" class="textfeld" value="" placeholder="Mehrzahl (nur bei Bedarf)">';
    echo '</fieldset>';

    ######## Anzahl
    echo '<fieldset style="width:100px;">';
    echo '<legend>Anzahl</legend>';
    echo '<input name="form_anfrage_anzahl" type="number" min="1" class="date" value="1">';
    echo '</fieldset>';

    ######## Personen
    echo '<fieldset style="width:120px;">';
    echo '<legend>Personen</legend>';
    echo '<input name="form_anfrage_personen" type="number" min="0" class="date" value="1">';
    echo '</fieldset>';

    ######## VIEW
    echo '<fieldset class="input_freigabe">';
    echo '<legend>Sichtbar</legend>';
    echo '<span class="jn">Ja</span>';
    echo '<input type="radio" name="form_anfrage_freigabe" value="1" checked="checked">';
    echo '<span class="jn">Nein</span>';
    echo '<input type="radio" name="form_anfrage_freigabe" value="0">';
    echo '</fieldset>';

    ######## HIDDEN 
    echo '<input type="hidden" name="area" value="' . $area . '">';
    echo '<input type="hidden" name="fct" value="' . $fct . '">';
    echo '<input type="hidden" name="id" value="' . $id . '">';

    ######## SAVE
    echo '<fieldset class="input_save">';
    echo '<legend>Einheit</legend>';
    echo '<input class="save_button" name="speichern_neue_einheit" type="submit" value="anlegen">';
    echo '</fieldset>';

    echo '</form>';

    echo '</ul>';


    ######## Neue Einheit mit Vorlage
    echo '<h2>Neue Einheit nach Vorlage</h2>';
    echo '<ul class="edit_einheit">';

    echo '<li>';
    echo '<form class="zeile_anfrage" method="post" action="' . $_SERVER['SCRIPT_NAME'] . '">';

    ######## Titel / Name
    echo '<fieldset class="input_title" style="width:51%;">';
    echo '<legend>Einheit</legend>';
    echo '<select name="form_anfrage_vorlage" style="width:100%;">';


    ######## SQL Neue Einheit aus Tabelle: cms_anfrage
    ### ORDER BY id wählt die zu erst erstellte Einheit (parent)
    $sql = "SELECT * FROM `cms_anfrage` GROUP BY titel ORDER BY id"; // WHERE freigabe = 1 ????
    $result = mysqli_query($conn, $sql);

    while ($row = mysqli_fetch_assoc($result)) {
        echo '<option value="' . $row['id'] . '">Einheit: ' . $row['titel'] . ' ' . $row['id'] . ' | Anzahl: ' . $row['anzahl'] . ' | Personen:  ' . $row['personen'] . '</option>';
    }
    echo '</select>';
    echo '</fieldset>';

    ######## HIDDEN 
    echo '<input type="hidden" name="area" value="' . $area . '">';
    echo '<input type="hidden" name="fct" value="' . $fct . '">';
    echo '<input type="hidden" name="id" value="' . $id . '">';

    ######## SAVE
    echo '<fieldset class="input_save">';
    echo '<legend>Einheit</legend>';
    echo '<input class="save_button" name="speichern_neue_einheit" type="submit" value="kopieren">';
    echo '</fieldset>';

    echo '</form>';
    echo '</ul>';


    /**
     * 
     * 
     * Bereich für Daten aus der Tabelle: cms_menue
     * 
     * Name der Formularseite
     * 
     */

    ######## SQL Anweisung MENUE
    $sql = "SELECT 
    *  
    FROM `cms_menue` 
    WHERE id = " . $id . "";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);

    ######## Formular / Form Start
    echo '<h2 style="margin-top:80px;">Formular</h2>';

    echo '<ul class="edit_einheit"><li>';
    echo '<form class="zeile_inhalte" method="post" action="' . $_SERVER['SCRIPT_NAME'] . '">';

    ######## Name der Seite / Link
    echo '<fieldset class="input_seitentitel">';
    echo '<legend>Name der Seite / Link</legend>';
    echo '<input style="font-weight:700;" name="form_menue_titel" type="text" class="textfeld" value="' . htmlspecialchars($row['titel'], ENT_QUOTES) . '">';
    echo '</fieldset>';

    ######## VIEW
    echo '<fieldset class="input_freigabe">';
    echo '<legend>Sichtbar</legend>';
    echo '<span class="jn">Ja</span>';
    echo '<input type="radio" name="form_menue_freigabe" value="1"' . (($row['sichtbar'] == "1") ? " checked=\"checked\"" : "") . '>';
    echo '<br><span class="jn">Nein</span>';
    echo '<input type="radio" name="form_menue_freigabe" value="0"' . (($row['sichtbar'] == "0") ? " checked=\"checked\"" : "") . '>';
    echo '</fieldset>';

    ######## DELETE
    echo '<fieldset class="input_delete">';
    echo '<legend>Löschen</legend>';
    echo '<input title="Checkup Box - Bestätigung der Löschung" type="checkbox" name="checkdelet" value="1">';
    echo '<input title="Einheit löschen nur mit Bestätigung der Checkup Box" name="loeschen_menue" type="submit" value="Seite löschen" style="width:120px; height:28px; font-weight:100;">';
    echo '</fieldset>';

    ######## HIDDEN 
    echo '<input type="hidden" name="area" value="' . $area . '">';
    echo '<input type="hidden" name="fct" value="' . $fct . '">';
    echo '<input type="hidden" name="id" value="' . $id . '">';
    echo '<input type="hidden" name="menue_id" value="' . $row['id'] . '">';

    ######## SAVE
    echo '<fieldset class="input_save">';
    echo '<legend>Änderung</legend>';
    echo '<input class="save_button" name="speichern_menue_update" type="submit" value="speichern">';
    echo '</fieldset>';

    echo '</form>';
    echo '</li></ul>';

    ######## LINK
    #echo '<div class="noresult"><a href="' . $url . getLink($conn, $id) . '" target="_blank">Formular neu laden und ansehen</a></div>';
    #echo '<div class="noresult"><a href="' . $url . 'inc/install.php?id=' . $row['id'] . '" target="_blank">Formular neu laden und ansehen</a></div>';

    echo '<ul class="show_links"><li><a href="' . $url . 'inc/install.php?id=' . $row['id'] . '" target="_blank"><i class="fas fa-clipboard-list"></i>Formular neu laden und ansehen</a></li></ul>';


    mysqli_free_result($result);
}

function displayMenueMain($conn, $area, $id, $fct)
{
    $sql = "SELECT 
    *
    FROM `cms_menue`  
    WHERE template_id = 20 OR template_id = 22";

    echo '<h2>Ihre Formulare für Reservierungen und Angebote</h2>';
    echo '<ul class="show_links">';
    echo '<li>';
    echo '<a href="' . $_SERVER['SCRIPT_NAME'] . '?area=' . $area . '&fct=newform"><i class="fas fa-plus"></i>Neues Formular</a>';
    echo '</li>';

    $result = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_assoc($result)) {
        echo '<li>';
        #echo '<span>' . (($row['template_id'] == '22') ? 'Angebot: ' : 'Reservierung: ') . '</span><a href="' . $_SERVER['SCRIPT_NAME'] . '?area=' . $area . '&fct=edit&id=' . $row['id'] . '">' . $row['titel'] . '</a><br>';
        echo '<a href="' . $_SERVER['SCRIPT_NAME'] . '?area=' . $area . '&fct=edit&id=' . $row['id'] . '">' . $row['titel'] . '</a>';
        echo '</li>';
    }

    echo '</ul>';
}
