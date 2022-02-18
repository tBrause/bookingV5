<?php
################# require main.php => switsh ###
################# require inc/ini.php => main ###

################# Inhalt der Seite: Einstellungen


function displaySetting($conn, $area, $fct, $form_kinder, $form_alter_kinder)
{

    $sql = "SELECT * FROM `config`";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);

    ######## Formular => Einstellungen
    echo '<h2>Einstellungen</h2>';
    #echo '<a href="' . $url . getLink($conn, $id) . '" target="_blank">' . getLink($conn, $id) . '</a>';
    echo '<ul class="edit_settings"><li>';
    echo '<form method="post" action="' . $_SERVER['SCRIPT_NAME'] . '">';

    ######## smtpHost
    echo '<fieldset>';
    echo '<legend>SMTP Host</legend>';
    echo '<input style="font-weight:700;" name="form_smtpHost" type="text" class="textfeld" value="' . htmlspecialchars($row['smtpHost'], ENT_QUOTES) . '" placeholder="SMTP Host">';
    echo '</fieldset>';

    ######## smtpPort
    echo '<fieldset>';
    echo '<legend>SMTP Port (Standard: 587)</legend>';
    echo '<input style="font-weight:700;" name="form_smtpPort" type="number" class="textfeld" value="' . htmlspecialchars($row['smtpPort'], ENT_QUOTES) . '" placeholder="587">';
    echo '</fieldset>';

    ######## smtpUsername
    echo '<fieldset>';
    echo '<legend>SMTP Postfach</legend>';
    echo '<input style="font-weight:700;" name="form_smtpUsername" type="email" class="textfeld" value="' . htmlspecialchars($row['smtpUsername'], ENT_QUOTES) . '" placeholder="Postfach" required>';
    echo '</fieldset>';

    ######## smtpPassword
    echo '<fieldset>';
    echo '<legend>SMTP Passwort</legend>';
    echo '<input style="font-weight:700;" name="form_smtpPassword" type="password" class="textfeld" value="' . htmlspecialchars($row['smtpPassword'], ENT_QUOTES) . '" placeholder="Password" required>';
    echo '</fieldset>';

    ######## E-Mail
    echo '<fieldset>';
    echo '<legend>E-Mail-Adresse vom Kunden für den Empfang und Datenschutz</legend>';
    echo '<input style="font-weight:700;" name="form_email" type="email" class="textfeld" value="' . htmlspecialchars($row['email'], ENT_QUOTES) . '" placeholder="E-Mail-Adresse" required>';
    echo '</fieldset>';

    ######## E-Mail DESCRIPTION
    echo '<fieldset>';
    echo '<legend>E-Mail-Name vom Kunden für den Empfang</legend>';
    echo '<input style="font-weight:700;" name="form_email_description" type="text" class="textfeld" value="' . htmlspecialchars($row['email_description'], ENT_QUOTES) . '" placeholder="E-Mail-Name" required>';
    echo '</fieldset>';

    ######## Impressum
    echo '<fieldset>';
    echo '<legend>Impressum der Homepage</legend>';
    echo '<input style="font-weight:700;" name="form_linkImpressum" type="url" class="textfeld" value="' . htmlspecialchars($row['linkImpressum'], ENT_QUOTES) . '" placeholder="Link" required>';
    echo '</fieldset>';

    ######## Datenschutz
    echo '<fieldset>';
    echo '<legend>Datenschutz der Homepage</legend>';
    echo '<input style="font-weight:700;" name="form_linkDatenschutz" type="url" class="textfeld" value="' . htmlspecialchars($row['linkDatenschutz'], ENT_QUOTES) . '" placeholder="Link" required>';
    echo '</fieldset>';

    ######## Anzahl Kinder
    echo '<fieldset>';
    echo '<legend>Maximale Anzahl mitreisender Kinder</legend>';
    echo '<select name="form_kinder">';
    echo '<option value="0"' . ((intval($row['kinder']) === 0) ? " selected" : "") . '>Kein extra Bereich Kinder</option>';
    for ($i = 1; $i < 11; $i++) {
        echo '<option value="' . $i . '"' . ((intval($row['kinder']) === $i) ? " selected" : "") . '>' . $i . ' ' . (($i <= 1) ? "Kind" : "Kinder") . '</option>';
    }
    echo '</select>';
    echo '</fieldset>';

    ######## Alter Kinder
    echo '<fieldset>';
    echo '<legend>Kinder bis zum ... Lebensjahr</legend>';
    echo '<select name="form_alter_kinder">';
    echo '<option value="0"' . ((intval($row['kinder_alter']) === 0) ? " selected" : "") . '>Kein extra Bereich Kinder</option>';
    for ($i = 1; $i < 18; $i++) {
        echo '<option value="' . $i . '"' . ((intval($row['kinder_alter']) === $i) ? " selected" : "") . '>' . $i . ' ' . (($i <= 1) ? "Jahr" : "Jahre") . '</option>';
    }
    echo '</select>';
    echo '</fieldset>';

    ######## HIDDEN 
    echo '<input type="hidden" name="area" value="' . $area . '">';
    echo '<input type="hidden" name="fct" value="' . $fct . '">';

    ######## SAVE
    echo '<fieldset>';
    echo '<legend>Einstellungen</legend>';
    echo '<input name="speichern_einstellungen" type="submit" class="save_button" value="speichern" style="width:100%; height:40px; font-weight:700;">';
    echo '</fieldset>';

    echo '</form>';
    echo '</li></ul>';
}
