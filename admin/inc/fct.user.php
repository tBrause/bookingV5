<?php
################# require main.php => switsh ###

################# Inhalt der Seite: Benutzer

# Welche Funktion soll ausgeführt werden
function displayContentUser($conn, $area, $sub, $id, $fct, $userstatus, $firstname, $name, $email, $username, $password, $password_check, $freigabe, $meldung)
{
    if ($fct === "edit" && empty($sub)) {

        # Formular: Benutzer bearbeiten
        displayEditUser($conn, $area, $sub, $id, $fct, $userstatus, $firstname, $name, $email, $username, $freigabe);
    } elseif (empty($fct) and $sub === '10') {

        # Formular: Benutzer hinzufügen 
        displayNewUser($conn, $area, $sub, $id, $fct, $userstatus, $firstname, $name, $email, $username, $password, $password_check, $freigabe, $meldung);
    } elseif ($fct === 'newpassword' && empty($sub)) {

        # Formular: Neues Passwort
        displayNewPassword($conn, $area, $sub, $id, $fct, $meldung);
    } elseif (empty($fct) and empty($sub)) {

        # Übersicht: Benutzer
        displayOverviewUser($conn, $area);
    }
}

################# Übersicht: Benutzer
function displayOverviewUser($conn, $area)
{
    $sql = "SELECT 
        u.id AS userid, 
        u.firstname AS firstname, 
        u.name AS name, 
        u.email AS email, 
        u.username AS username, 
        u.release AS urelease, 
        u.departmentId AS udepid, 
        d.id AS ddepid, 
        d.name AS dname  
    FROM user AS u 
    JOIN department AS d ON u.departmentId = d.id 
    ORDER BY d.id, u.name";
    #echo $sql;
    $result = mysqli_query($conn, $sql);

    echo '<h2>Übersicht Benutzer</h2>';

    #echo '<form method="post" action="' . $_SERVER["SCRIPT_NAME"] . '">';

    echo '<table class="liste">';
    echo '<tr><th>&nbsp;</th><th>Status</th><th>Vorname</th><th>Name</th><th>E-Mail</th><th>Nutzername</th><th>Freigabe</th><th>Passwort</th></tr>';

    while ($row = mysqli_fetch_array($result)) {
        echo '<tr>';
        if ($row['userid'] != '1') {
            echo '<td><a href="' . $_SERVER['SCRIPT_NAME'] . '?area=' . $area . '&id=' . $row['userid'] . '&fct=edit" title="Bearbeiten"><i class="fas fa-edit"></i></a></td>';
        } else {
            echo '<td>&nbsp;</td>';
        }
        echo '<td>' . $row['dname'] . '</td>';
        echo '<td>' . $row['firstname'] . '</td>';
        echo '<td>' . $row['name'] . '</td>';
        echo '<td>' . $row['email'] . '</td>';
        echo '<td>' . $row['username'] . '</td>';
        echo '<td class="tdcenter">' . (($row['urelease'] === '1') ? '<i class="fas fa-check"></i>' : '<i class="fas fa-times"></i>') . '</td>';

        if ($row['userid'] != '1') {
            echo '<td class="tdcenter"><a href="' . $_SERVER['SCRIPT_NAME'] . '?area=' . $area . '&id=' . $row['userid'] . '&fct=newpassword" title="Passwort ändern"><i class="fas fa-key"></i></a></td>';
        } else {
            echo '<td>&nbsp;</td>';
        }
        echo '</tr>';
    }

    echo '</table>';

    #echo '</form>';

    #echo '<div class="noresult"><a href="' . $_SERVER["SCRIPT_NAME"] . '?area=5&amp;sub=10">Neuen Benutzer anlegen</a></div>';

    echo '<ul class="show_links"><li><a href="' . $_SERVER["SCRIPT_NAME"] . '?area=5&amp;sub=10"><i class="fas fa-plus"></i>Neuen Benutzer anlegen</a></li></ul>';

    mysqli_free_result($result);
}

################# Formular: Benutzer bearbeiten
function displayEditUser($conn, $area, $sub, $id, $fct, $userstatus, $firstname, $name, $email, $username, $freigabe)
{
    # db select user
    $sql = 'SELECT * FROM user WHERE id = ' . $id;
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $uDepartmentId = $row['departmentId'];
    $name = $row['name'];
    $firstname = $row['firstname'];
    $email = $row['email'];
    $username = $row['username'];
    $freigabe = $row['release'];
    mysqli_free_result($result);

    echo '<h2>Benutzer bearbeiten</h2>';

    #echo '<form method="post" action="' . $_SERVER["SCRIPT_NAME"] . '">';

    echo '<div class="wrapper">';

    echo '<section class="form_inline">';

    # Auswahlfeld: Status
    echo '<fieldset>
    <legend>Status *</legend>
    <select name="userstatus" id="userstatus">
    <option class="form_option" value="0">Bitte auswählen</option>';
    $sql = "SELECT * FROM department ORDER BY id";
    $result = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_assoc($result)) {
        echo '<option' . (($uDepartmentId == $row['id']) ? ' selected' : '') . ' class="form_option" value="' . $row['id'] . '">' . $row['name'] . '</option>';
    }
    mysqli_free_result($result);
    echo '</select>';
    echo '</fieldset>';

    # Eingabefeld: Vor- und Zuname
    echo '<fieldset>
        <legend>Name</legend>
        <input style="width:48%" type="text" name="firstname" id="firstname" maxlength="30" value="' . htmlspecialchars($firstname, ENT_QUOTES) . '" placeholder="Vorname">
        <input style="width:48%" type="text" name="name" id="name" maxlength="30" value="' . htmlspecialchars($name, ENT_QUOTES) . '" placeholder="Name">
        </fieldset>';

    # Eingabefeld: E-Mail
    echo '<fieldset>
        <legend>E-Mail *</legend>
        <input type="text" name="email" id="email" maxlength="80" value="' . $email . '">
        </fieldset>';

    # Eingabefeld: Bentuzername
    echo '<fieldset>
        <legend>Bentuzername *</legend>
        <input type="text" name="username" id="username" maxlength="30" value="' . htmlspecialchars($username, ENT_QUOTES) . '">
        </fieldset>';

    # Eingabefeld: Freigabe
    echo '<fieldset>
        <legend>Freigabe</legend>
        <input type="radio" name="freigabe" id="freigabe" value="1"' . (($freigabe == '1') ? ' checked' : '') . '>
        <label for="freigabe">freigeben</label><span class="abstand_radio"></span>
        <input type="radio" name="freigabe" id="sperren" value="0"' . (($freigabe == '0') ? ' checked' : '') . '>
        <label for="sperren">sperren</label>
        </fieldset>';

    echo '</section>';

    # Versteckte Felder
    echo '<input type="hidden" name="area" value="' . $area . '">';
    echo '<input type="hidden" name="id" value="' . $id . '">';
    echo '<input type="hidden" name="fct" value="' . $fct . '">';

    # Buttons
    echo '<section class="form_inline">
        <button type="submit" name="button" value="speichern"><i class="fas fa-save"></i>Speichern</button>
        <button type="button" name="button" value="abbrechen" onClick="window.location.href=\'main.php?area=' . $area . '\';"><i class="fas fa-times"></i>Abbrechen</button>
    </section>';

    echo '</div>';

    #echo '</form>';
}

################# Formular: Benutzer hinzufügen
function displayNewUser($conn, $area, $sub, $id, $fct, $userstatus, $firstname, $name, $email, $username, $password, $password_check, $freigabe, $meldung)
{

    echo '<h2>Neuer Benutzer</h2>';

    #echo '<form method="post" action="' . $_SERVER["SCRIPT_NAME"] . '">';
    #echo '<form method="post" action="' . $_SERVER["PHP_SELF"] . '">';

    echo '<div class="wrapper">';

    if (isset($meldung)) {
        echo implode('<br>', $meldung);
    }

    echo '<section class="form_inline">';

    # Auswahlfeld: Status
    echo '<fieldset>
    <legend>Status *</legend>
    <select name="userstatus" id="userstatus">
    <option class="form_option" value="0">Bitte auswählen</option>';
    $sql = "SELECT * FROM department ORDER BY id";
    $result = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_assoc($result)) {
        echo '<option' . (($userstatus == $row['id']) ? ' selected' : '') . ' value="' . $row['id'] . '">' . $row['name'] . '</option>';
    }
    mysqli_free_result($result);
    echo '</select>';
    echo '</fieldset>';

    # Eingabefeld: Vor- und Zuname
    echo '<fieldset>
        <legend>Name</legend>
        <input style="width:48%" type="text" name="firstname" id="firstname" maxlength="30" value="' . htmlspecialchars($firstname, ENT_QUOTES) . '" placeholder="Vorname">
        <input style="width:48%" type="text" name="name" id="name" maxlength="30" value="' . htmlspecialchars($name, ENT_QUOTES) . '" placeholder="Name">
        </fieldset>';

    # Eingabefeld: E-Mail
    echo '<fieldset>
        <legend>E-Mail *</legend>
        <input type="text" name="email" id="email" maxlength="80" value="' . $email . '">
        </fieldset>';

    # Eingabefeld: Bentuzername
    echo '<fieldset>
        <legend>Benutzername *</legend>
        <input type="text" name="username" id="username" maxlength="30" value="' . $username . '">
        </fieldset>';

    # Eingabefeld: Passwort
    echo '<fieldset>
        <legend>Passwort *</legend>
        <input style="width:48%" type="password" name="password" id="password" maxlength="30" value="" placeholder="Passwort (mind. 7 Zeichen)">
        <input style="width:48%" type="password" name="password_check" id="passwort_check" maxlength="30" value="" placeholder="Passwort wiederholen">
        </fieldset>';

    # Eingabefeld: Freigabe
    echo '<fieldset>
        <legend>Freigabe</legend>
        <input type="radio" name="freigabe" id="freigabe" value="1"' . (($freigabe == '1' || $freigabe == '') ? ' checked' : '') . '>
        <label for="freigabe">freigeben</label><span class="abstand_radio"></span>
        <input type="radio" name="freigabe" id="sperren" value="0"' . (($freigabe == '0') ? ' checked' : '') . '>
        <label for="sperren">sperren</label>
        </fieldset>';

    echo '</section>';

    # Versteckte Felder
    echo '<input type="hidden" name="area" value="' . $area . '">';
    echo '<input type="hidden" name="sub" value="' . $sub . '">';
    #echo '<input type="hidden" name="fct" value="new">';

    # Buttons
    echo '<section class="form_inline">
        <button type="submit" name="button" value="speichern"><i class="fas fa-save"></i>Speichern</button>
        <button type="button" name="button" value="abbrechen" onClick="window.location.href=\'main.php?area=' . $area . '\';"><i class="fas fa-times"></i>Abbrechen</button>
    </section>';

    echo '</div>';

    #echo '</form>';
}

################# Formular: Neues Passwort
function displayNewPassword($conn, $area, $sub, $id, $fct, $meldung)
{
    echo '<h2>Neues Passwort</h2>';

    #echo '<form method="post" action="' . $_SERVER["SCRIPT_NAME"] . '">';

    echo '<div class="wrapper">';

    if (isset($meldung)) {
        echo implode('<br>', $meldung);
    }

    echo '<section class="form_inline">';

    # Eingabefeld: Passwort
    echo '<fieldset>
        <legend>Passwort *</legend>
        <input style="width:48%" type="password" name="password" id="password" maxlength="30" value="" placeholder="Passwort (mind. 7 Zeichen)">
        <input style="width:48%" type="password" name="password_check" id="passwort_check" maxlength="30" value="" placeholder="Passwort wiederholen">
        </fieldset>';
    echo '</section>';

    # Versteckte Felder
    echo '<input type="hidden" name="area" value="' . $area . '">';
    echo '<input type="hidden" name="id" value="' . $id . '">';
    echo '<input type="hidden" name="fct" value="' . $fct . '">';

    # Buttons
    echo '<section class="form_inline">
        <button type="submit" name="button" value="speichern"><i class="fas fa-save"></i>Speichern</button>
        <button type="button" name="button" value="abbrechen" onClick="window.location.href=\'main.php?area=' . $area . '\';"><i class="fas fa-times"></i>Abbrechen</button>
    </section>';
    echo '</div>';

    #echo '</form>';
}
