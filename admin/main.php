<?php

/**
 * 
 * 
 * Initialize access data and variables
 * 
 * 
 * 
 */
require("inc/ini.php");

/**
 * 
 * 
 * Überprüft den Login anhand
 * der SESSION 
 * 
 * 
 */

session_start();
if (@$_SESSION['login'] !== true) {
    die('Bitte anmelden');
}


/**
 * 
 * 
 * Alle REQUEST, INPUT_POST und INPUT_GET
 * Variablen
 * 
 * 
 */

# generally variables
$area = @$_REQUEST['area'];
//echo $area;
$sub = @$_REQUEST['sub'];
$fct = @$_REQUEST['fct'];
$id = @$_REQUEST['id'];
$button = trim(substr(filter_input(INPUT_POST, 'button'), 0, 10));
$freigabe = trim(substr(filter_input(INPUT_POST, 'freigabe'), 0, 1));
$name = trim(substr(filter_input(INPUT_POST, 'name'), 0, 30));
$datum = trim(substr(filter_input(INPUT_POST, 'datum'), 0, 30));

# user variables
$userstatus = trim(substr(filter_input(INPUT_POST, 'userstatus'), 0, 2));
#$name = trim(substr(filter_input(INPUT_POST, 'name'), 0, 30));
$firstname = trim(substr(filter_input(INPUT_POST, 'firstname'), 0, 30));
$email = trim(substr(filter_input(INPUT_POST, 'email'), 0, 80));
$username = trim(substr(filter_input(INPUT_POST, 'username'), 0, 30));
$password = trim(substr(filter_input(INPUT_POST, 'password'), 0, 30));
$password_check = trim(substr(filter_input(INPUT_POST, 'password_check'), 0, 30));

# booking fomulare
$absatz_id = @$_REQUEST['absatz_id'];
$inhalte_id = @$_REQUEST['inhalte_id'];

$checkdelet = trim(substr(filter_input(INPUT_POST, 'checkdelet'), 0, 1));


$submit_inhalt = trim(substr(filter_input(INPUT_POST, 'speichern_inhalt'), 0, 14));
$submit_anfrage = trim(substr(filter_input(INPUT_POST, 'speichern_anfrage'), 0, 14));
$submit_menue = trim(substr(filter_input(INPUT_POST, 'speichern_menue_neu'), 0, 14));
$submit_menue_update = trim(substr(filter_input(INPUT_POST, 'speichern_menue_update'), 0, 14));
$submit_neue_einheit = trim(substr(filter_input(INPUT_POST, 'speichern_neue_einheit'), 0, 14));
$submit_einstellungen = trim(substr(filter_input(INPUT_POST, 'speichern_einstellungen'), 0, 14));
$submit_bubbles_update = trim(substr(filter_input(INPUT_POST, 'submit_bubbles_update'), 0, 14));
$submit_bubbles_insert = trim(substr(filter_input(INPUT_POST, 'submit_bubbles_insert'), 0, 14));
$submit_bubbles_delete = trim(substr(filter_input(INPUT_POST, 'submit_bubbles_delete'), 0, 14));


$position = trim(substr(filter_input(INPUT_GET, 'position'), 0, 2));
$urlection = trim(substr(filter_input(INPUT_GET, 'direction'), 0, 5));

$form_inhalt_seitentitel = trim(substr(filter_input(INPUT_POST, 'form_inhalt_seitentitel'), 0, 160));
$form_inhalt_freigabe = trim(substr(filter_input(INPUT_POST, 'form_inhalt_freigabe'), 0, 1));


$form_menue_titel = trim(substr(filter_input(INPUT_POST, 'form_menue_titel'), 0, 160));
$form_menue_freigabe = trim(substr(filter_input(INPUT_POST, 'form_menue_freigabe'), 0, 1));

$loeschen_menue = trim(substr(filter_input(INPUT_POST, 'loeschen_menue'), 0, 80));
$loeschen_anfrage = trim(substr(filter_input(INPUT_POST, 'loeschen_anfrage'), 0, 80));


#$loeschen_menue = trim(substr(filter_input(INPUT_POST, 'loeschen_menue'), 0, 1));

$form_anfrage_titel = trim(substr(filter_input(INPUT_POST, 'form_anfrage_titel'), 0, 160));
$form_anfrage_titel_mz = trim(substr(filter_input(INPUT_POST, 'form_anfrage_titel_mz'), 0, 160));
$form_anfrage_anzahl = trim(substr(filter_input(INPUT_POST, 'form_anfrage_anzahl'), 0, 2));
$form_anfrage_personen = trim(substr(filter_input(INPUT_POST, 'form_anfrage_personen'), 0, 2));
$form_anfrage_freigabe = trim(substr(filter_input(INPUT_POST, 'form_anfrage_freigabe'), 0, 1));

$form_anfrage_vorlage = trim(substr(filter_input(INPUT_POST, 'form_anfrage_vorlage'), 0, 14));

# SETTINGS
$form_smtpUsername = trim(substr(filter_input(INPUT_POST, 'form_smtpUsername'), 0, 80));
$form_smtpPassword = trim(substr(filter_input(INPUT_POST, 'form_smtpPassword'), 0, 20));
$form_smtpHost = trim(substr(filter_input(INPUT_POST, 'form_smtpHost'), 0, 100));
$form_smtpPort = trim(substr(filter_input(INPUT_POST, 'form_smtpPort'), 0, 4));
$form_linkImpressum = trim(substr(filter_input(INPUT_POST, 'form_linkImpressum'), 0, 255));
$form_linkDatenschutz = trim(substr(filter_input(INPUT_POST, 'form_linkDatenschutz'), 0, 255));
$form_email = trim(substr(filter_input(INPUT_POST, 'form_email'), 0, 100));
$form_email_description = trim(substr(filter_input(INPUT_POST, 'form_email_description'), 0, 120));
$form_kinder = trim(substr(filter_input(INPUT_POST, 'form_kinder'), 0, 2));
$form_alter_kinder = trim(substr(filter_input(INPUT_POST, 'form_alter_kinder'), 0, 2));


# HEIGHLIGHT NAVIGATION
$form_type = trim(substr(filter_input(INPUT_POST, 'form_type'), 0, 2));
$form_bubble_titel = trim(substr(filter_input(INPUT_POST, 'form_bubble_titel'), 0, 25));
$form_bubble_icon = trim(substr(filter_input(INPUT_POST, 'form_bubble_icon'), 0, 20));
$form_bubble_link = trim(substr(filter_input(INPUT_POST, 'form_bubble_link'), 0, 255));
$form_bubble_position = trim(substr(filter_input(INPUT_POST, 'form_bubble_position'), 0, 20));

$cssbutton = trim(substr(filter_input(INPUT_POST, 'cssbutton'), 0, 20));




/**
 * 
 * 
 * Alle UPDATE & INSERT Anweisungen
 * 
 * 
 */

require('inc/fct.sql.php');


/**
 * 
 * 
 * Wähle die ensprechende Datei
 * mit den Funktionen eines Bereich (Menüpunkt($area))
 * 
 * 
 */
function switchArea($area)
{
    switch ($area) {
        case '2':
            # Bereich: Formulare
            require("inc/fct.formulare.php");
            break;
        case '3':
            # Bereich: Mobile Navigation
            require("inc/fct.bubbles.php");
            break;
        case '4':
            # Bereich: Einbauanleitung
            require("inc/fct.instructions.php");
            break;
        case '5':
            # Bereich: Benutzer
            require("inc/fct.user.php");
            break;
        case '6':
            # Bereich: Logout
            require("inc/fct.logout.php");
            break;
        case '13':
            # Bereich: Einstellungen
            require("inc/fct.setting.php");
            break;
        default:
            # Bereich: Home
            require("inc/fct.main.php");
            break;
    }
}
switchArea($area);
?>
<!DOCTYPE html>
<html lang="de">

<head>
    <!-- METAS -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex,nofollow">
    <meta name="siteinfo" content="/robots.txt">

    <!-- TITLE -->
    <title>Adminbereich</title>

    <!-- FAVICON -->
    <link rel="shortcut icon" type="image/x-icon" href="favicon.ico">

    <!-- CSS -->
    <link rel="stylesheet" type="text/css" href="css/default.css">
    <link rel="stylesheet" type="text/css" href="css/fonts.css">
    <link rel="stylesheet" type="text/css" href="../fonts/font-awesome/all.min.css">

    <?php
    if ($area == 7) {
        echo '<script src="js/iframe.js"></script>';
    }
    ?>
</head>

<body>
    <!-- MAIN NAV -->
    <?php
    ################# Zeige das Hautmenü => inc/ini.php => inc/fct.menue.php
    displayMainMenue($conn, $area);
    ?>

    <!-- CONTENT -->
    <section id="content">

        <?php

        ################# Form für alle Formulare, ausser im Breiech "Formulare" / "Bearbeiten"
        if (intval($area) !== 2) {
            if (intval($area) === 3 && empty($fct)) {
                # Nichts
            } else {
                echo '<form method="post" action="' . $_SERVER['SCRIPT_NAME'] . '">';
            }
        }

        ################# Wähle die Funktionen zur Ausgabe für den entsprechenden Bereich (Menüpunkt)

        echo '<div class="wrapp">';

        if ($area == '2') {
            #
            # Bereich: Formulare

            displayMenue($conn, $area, $id, $fct, $url);
            #
            #
            #
        } elseif ($area == '3') {
            #
            # Bereich: Heighlight Navigation

            displayBubbles($conn, $fct, $area, $url, $id, $form_type, $form_bubble_titel, $form_bubble_icon, $form_bubble_link, $form_bubble_position, $cssbutton);
            #
            #
            #
        } elseif ($area == '4') {
            #
            # Bereich: Einbauanleitung

            displayContentInstruction($conn, $url);
            #
            #
            #
        } elseif ($area == '5') {
            #
            # Bereich: Benutzer

            displayContentUser($conn, $area, $sub, $id, $fct, $userstatus, $firstname, $name, $email, $username, $password, $password_check, $freigabe, $meldung);
            #
            #
            #
        } elseif ($area == '13') {
            #
            # Bereich: Einstellungen

            displaySetting($conn, $area, $fct, $form_kinder, $form_alter_kinder);
            #
            #
            #
        } elseif ($area == '7') {
            #
            # Bereich: Neu laden

            echo '<iframe scrolling="no" class="ergebnis" id="install" src="../inc/install.php"></iframe>';
            #
            #
            #
        } elseif ($area == '1' || empty($area)) {
            #
            # Bereich: Home
            displayContentMain($conn, $url);
            #
            #
            #
        }

        echo '</div>';

        if (intval($area) !== 2) {
            if (intval($area) === 3 && empty($fct)) {
                # Nichts
            } else {
                echo '</form>';
            }
        }

        ?>

    </section>

</body>

</html>