<?php

/**
 * 
 * 
 * VERWALTUNG DER
 * VERSCHIEDENEN MODIS
 * IM BEREICH
 * HIGHLIGHT NAVIGATION
 * fsdfsdfsdfds
 * 
 */

function displayBubbles($conn, $fct, $area, $url, $id, $form_type, $form_bubble_titel, $form_bubble_icon, $form_bubble_link, $form_bubble_position, $cssbutton)
{
    # Formular: 
    if ($fct === "edit") {

        # Eintrag bearbeiten
        editBubbles($conn, $id, $area, $fct);
        #
    } else if ($fct === "newbubble") {

        # Neuer Eintrag
        newBubbles($conn, $id, $area, $fct, $form_type, $form_bubble_titel, $form_bubble_icon, $form_bubble_link, $form_bubble_position);
        #
    } else {

        # Übersicht
        getBubbles($conn, $area, $url, $cssbutton);
        #
    }
}


/**
 * 
 * 
 * BEREICH ZUM
 * ERSTELLEN EINES
 * BUBBLE
 * 
 * 
 */

function newBubbles($conn, $id, $area, $fct, $form_type, $form_bubble_titel, $form_bubble_icon, $form_bubble_link, $form_bubble_position)
{

    echo '<div class="wrapp">';
    echo '<h2>Neuer Button</h2>';

    echo '<ul class="edit_settings">';
    echo '<li>';

    # Type
    echo '<fieldset>';
    echo '<legend>Bitte wählen Sie den Typ / Funktion des Buttons aus</legend>';
    echo '<select style="font-weight:700;" name="form_type">';
    echo '<option value="0">Bitte auswählen</option>';

    $sql_type = "SELECT * FROM `bubbles_typ`";
    $result_type = mysqli_query($conn, $sql_type);

    while ($row_type = mysqli_fetch_array($result_type)) {
        # code...
        echo '<option value="' . $row_type['id'] . '"' . (($row_type['id'] === $form_type) ? ' selected' : '') . '>' . $row_type['title'] . '</option>';
    }

    echo '</select>';
    echo '</fieldset>';

    # Titel
    echo '<fieldset>';
    echo '<legend>Titel (maximal. 25 Zeichen)</legend>';
    echo '<input style="font-weight:700; padding: 5px 10px; width:100%;" name="form_bubble_titel" type="text" class="textfeld" maxlenght:25; value="' . $form_bubble_titel . '" placeholder="Text neben dem Icon">';
    echo '</fieldset>';

    # Icon
    echo '<fieldset>';
    echo '<legend>Icon</legend>';
    echo '<input style="font-weight:700; padding: 5px 10px; width:100%;" name="form_bubble_icon" type="text" class="textfeld" value="' . $form_bubble_icon . '" placeholder="z.B.: fa-home">';
    echo '</fieldset>';

    # Link
    echo '<fieldset>';
    echo '<legend>Link / Wert</legend>';
    echo '<input style="font-weight:700; padding: 5px 10px; width:100%;" name="form_bubble_link" type="text" class="textfeld" value="' . $form_bubble_link . '" placeholder="Beachte: Folgende Typen stehen zur Verfügung">';
    echo '</fieldset>';

    /*
    # Position
    echo '<fieldset>';
    echo '<legend>Position</legend>';
    echo '<select style="font-weight:700;" name="form_bubble_position">';
    echo '<option value="0">Bitte auswählen</option>';

    $sql_bubble_position = "SELECT `position` FROM `bubbles`";
    $result_bubble_position = mysqli_query($conn, $sql_bubble_position);

    while ($row_bubble_position = mysqli_fetch_array($result_bubble_position)) {
        # code...
        echo '<option value="' . $row_bubble_position['position'] . '"' . (($row_bubble_position['position'] === $form_bubble_position) ? ' selected' : '') . '>' . $row_bubble_position['position'] . '</option>';
    }
    echo '</select>';

    echo '</fieldset>';
    */

    ######## HIDDEN 
    echo '<input type="hidden" name="area" value="' . $area . '">';
    echo '<input type="hidden" name="fct" value="' . $fct . '">';

    ######## SAVE
    echo '<fieldset>';
    echo '<legend>Neuen Button</legend>';
    echo '<input style="font-weight:700; padding: 5px 10px; width:100%;" class="save_button" name="submit_bubbles_insert" type="submit" value="anlegen">';
    echo '</fieldset>';

    echo '</li>';

    echo '</ul>';

    # HÄUFIG VERWENDETE ICONS
    displayIcons();

    # UMGANG MIT DEN TYPEN DER BUTTONS
    displayInfoTypen();

    echo '</div>';
}


/**
 * 
 * 
 * BEREICH FÜR
 * DIE BEARBEITUNG EINES
 * BUBBLE
 * 
 * 
 */

function editBubbles($conn, $id, $area, $fct)
{
    $sql = "SELECT * FROM `bubbles` WHERE `id` = '" . $id . "'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);

    echo '<div class="wrapp">';
    echo '<h2>Button bearbeiten</h2>';

    echo '<ul class="edit_settings">';
    echo '<li>';

    # Type
    echo '<fieldset>';
    echo '<legend>Typ/ Funktion des Buttons</legend>';
    echo '<select style="font-weight:700;" name="form_type">';
    echo '<option value="0">Bitte auswählen</option>';

    $sql_type = "SELECT * FROM `bubbles_typ`";
    $result_type = mysqli_query($conn, $sql_type);

    while ($row_type = mysqli_fetch_array($result_type)) {
        # code...
        echo '<option value="' . $row_type['id'] . '"' . (($row_type['id'] === $row['type']) ? ' selected' : '') . '>' . $row_type['title'] . '</option>';
    }

    echo '</select>';
    echo '</fieldset>';

    # Titel
    echo '<fieldset>';
    echo '<legend>Titel (steht neben dem Icon)</legend>';
    echo '<input style="font-weight:700; padding: 5px 10px; width:100%;" name="form_bubble_titel" type="text" class="textfeld" value="' . htmlspecialchars($row['title']) . '" placeholder="Einzahl">';
    echo '</fieldset>';

    # Icon
    echo '<fieldset>';
    echo '<legend>Icon</legend>';
    echo '<input style="font-weight:700; padding: 5px 10px; width:100%;" name="form_bubble_icon" type="text" class="textfeld" value="' . $row['icon'] . '" placeholder="Einzahl">';
    echo '</fieldset>';

    # Link
    echo '<fieldset>';
    echo '<legend>Link / Wert</legend>';
    echo '<input style="font-weight:700; padding: 5px 10px; width:100%;" name="form_bubble_link" type="text" class="textfeld" value="' . $row['link'] . '" placeholder="Einzahl">';
    echo '</fieldset>';

    # Position
    echo '<fieldset>';
    echo '<legend>Position</legend>';
    echo '<select style="font-weight:700;" name="form_bubble_position">';
    echo '<option value="0">Bitte auswählen</option>';

    $sql_bubble_position = "SELECT `position` FROM `bubbles` ORDER BY position";
    $result_bubble_position = mysqli_query($conn, $sql_bubble_position);

    while ($row_bubble_position = mysqli_fetch_array($result_bubble_position)) {
        # code...
        echo '<option value="' . $row_bubble_position['position'] . '"' . (($row_bubble_position['position'] === $row['position']) ? ' selected' : '') . '>' . $row_bubble_position['position'] . '</option>';
    }
    echo '</select>';

    echo '</fieldset>';

    ######## HIDDEN 
    echo '<input type="hidden" name="area" value="' . $area . '">';
    echo '<input type="hidden" name="fct" value="' . $fct . '">';
    echo '<input type="hidden" name="id" value="' . $id . '">';

    ######## SAVE
    echo '<fieldset>';
    echo '<legend>Änderung</legend>';
    echo '<input style="font-weight:700; padding: 5px 10px; width:100%;" class="save_button" name="submit_bubbles_update" type="submit" value="speichern">';
    echo '</fieldset>';

    ######## DELETE
    echo '<fieldset>';
    echo '<legend>Button: ' . htmlspecialchars($row['title']) . '</legend>';
    echo '<input title="Checkup Box - Bestätigung der Löschung" type="checkbox" style="font-weight:700; padding: 5px 10px; width:50px;" name="checkdelet" value="1">';
    echo '<input title="Einheit löschen nur mit Bestätigung der Checkup Box" style="font-weight:700; padding: 5px 10px; width:100%;" class="delete_button" name="submit_bubbles_delete" type="submit" value="löschen">';
    echo '</fieldset>';

    echo '</li>';

    echo '</ul>';

    # HÄUFIG VERWENDETE ICONS
    displayIcons();

    # UMGANG MIT DEN TYPEN DER BUTTONS
    displayInfoTypen();

    echo '</div>';
}


/**
 * 
 * 
 * INFOBEREICH FÜR
 * HÄUFIG VERWENDETE 
 * ICONS
 * 
 * 
 */

function displayIcons()
{
    echo '<h2>Häufig verwendete Icons</h2>';
    echo '<ul class="icons">';
    echo '<li><i class="fa fa-home"></i><span>fa-home</span></li>';
    echo '<li><i class="fa fa-phone"></i><span>fa-phone</span></li>';
    echo '<li><i class="fas fa-mobile-alt"></i><span>fa-mobile</span></li>';
    echo '<li><i class="fa fa-bed"></i><span>fa-bed</span></li>';
    echo '<li><i class="fa fa-paper-plane"></i><span>fa-paper-plane</span></li>';
    echo '<li><i class="fa fa-map-marker"></i><span>fa-map-marker</span></li>';
    echo '<li><i class="fa fa-gift"></i><span>fa-gift</span></li>';
    echo '<li><i class="fa fa-utensils"></i><span>fa-cutlery</span></li>';
    echo '<li><i class="far fa-image"></i><span>fa-picture-o</span></li>';
    echo '<li><i class="fas fa-camera"></i><span>fa-camera</span></li>';
    echo '<li><i class="fas fa-camera-retro"></i><span>fa-camera-retro</span></li>';
    echo '<li><i class="fas fa-video"></i><span>fa-video-camera</span></li>';
    echo '<li><i class="fab fa-facebook"></i><span>fa-facebook</span></li>';
    echo '<li><i class="fab fa-twitter"></i><span>fa-twitter</span></li>';
    echo '<li><i class="fab fa-youtube"></i><span>fa-youtube-play</span></li>';
    echo '<li><i class="fab fa-whatsapp"></i><span>fa-whatsapp</span></li>';
    echo '<li><i class="fab fa-instagram"></i><span>fa-instagram</span></li>';
    echo '<li><i class="fab fa-tripadvisor"></i><span>fa-tripadvisor</span></li>';
    echo '</ul>';
    echo '<p>Alle Icons findet Du unter: <a href="https://fontawesome.com/v4.7.0/icons/" target="_blank">https://fontawesome.com/v4.7.0/icons/</a></p>';
}


/**
 * 
 * 
 * INFOBEREICH FÜR
 * DEN UMGANG MIT DEN TYPEN
 * DER BUTTONS
 * 
 * 
 */

function displayInfoTypen()
{

    echo '<h2>Folgende Typen stehen zur Verfügung</h2>';
    echo '<ul class="info">';
    echo '<li><span class="begriff">Telefon</span><span class="erklaerung">Bei Link muss eine gülige Nummer in diesem Format eingetragen werden: +493467156990</span></li>';
    echo '<li><span class="begriff">Link im neuen Fenster</span><span class="erklaerung">Bei Link muss eine gülige URL in diesem Format eingetragen werden: https://www.domain.de</span></li>';
    echo '<li><span class="begriff">Link im gleichen Fenster</span><span class="erklaerung">Bei Link muss eine gülige URL in diesem Format eingetragen werden: https://www.domain.de</span></li>';
    echo '<li><span class="begriff">E-Mail-Adresse</span><span class="erklaerung">Bei Link muss eine gültige E-Mail-Adresse in diesem Format eingetragen werden: info@domain.de</span></li>';
    echo '<li><span class="begriff">Net-Booking Reservierung</span><span class="erklaerung">Bei Link muss die ID in diesem Format eingetragen werden: 20211019214003<br>Die Id findet man im Bereich: Einbauanleitung<br>Soll die Reservierung in einem neuen Fenster geöffnet werden, den Typ: Link im neuen Fenster verwenden.</span></li>';
    echo '<li><span class="begriff">WhatsApp Nummer</span><span class="erklaerung">Bei Link muss eine gülige Nummer in diesem Format eingetragen werden: +493467156990</span></li>';
    echo '</ul>';
}


/**
 * 
 * 
 * STARTSEITE HIGHLIGHT-NAVIGATION
 * 
 * 
 */

function getBubbles($conn, $area, $url, $cssbutton)
{
    $sql = "SELECT * FROM `bubbles` ORDER BY position";
    $result = mysqli_query($conn, $sql);
    $row_cnt = $result->num_rows;

    echo '<div class="wrapp">';
    echo '<h2>Buttons für die Highlight-Navigation</h2>';
    echo '<ul class="show_buttons">';

    if ($result->num_rows <= 4) {
        echo '<li style="width:100%; background-color: rgba(202, 202, 202, 0.6);"><a href="' . $_SERVER['SCRIPT_NAME'] . '?area=' . $area . '&fct=newbubble"><i class="fas fa-plus"></i>Neuer Bereich</a></li>';
    }

    while ($row = mysqli_fetch_array($result)) {
        echo '<li><a href="' . $_SERVER['SCRIPT_NAME'] . '?area=' . $area . '&fct=edit&id=' . $row['id'] . '">';
        echo $row['title'] . '</a></li>';
    }

    echo '</ul>';

    echo '<h2>Vorschau SmartPhone</h2>';
    echo '<iframe style="width:375px; height:450px;" src="' . $url . 'admin/inc/vorschau.html"></iframe>';

    echo '<h2>Vorschau Desktop</h2>';
    echo '<iframe style="width:100%; height:600px;" src="' . $url . 'admin/inc/vorschau.html"></iframe>';

    # CSS Upload
    echo '<h2>CSS Datei hochladen</h2>';
    $colors_css = $url . 'astrotel_connect/style.colors.css';
    echo '<p><a href="' . $colors_css . '" target="_blank">CSS-Online-Datei: ' . $colors_css . '</a></p>';
    echo '<section class="form_inline">';
    echo '<form enctype="multipart/form-data" action="' . $_SERVER['SCRIPT_NAME'] . '" method="POST">';

    # CSS Datei auswählen
    echo '<fieldset>
        <legend>style.colors.css</legend>
        <input type="file" name="userfile">
        </fieldset>';

    # Versteckte Felder
    echo '<input type="hidden" name="area" value="' . $area . '">';

    # Buttons
    echo '<button type="submit" name="cssbutton" value="cssupdate"><i class="fas fa-upload"></i>CSS Datei hochladen</button>';

    echo '</form>';
    echo '</section>';
    echo '</div>';
}
