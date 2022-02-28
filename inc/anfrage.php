<?php

require('request.php');
#phpinfo();
// ### Ausgabe   
$einheiten[] = '<div id="main_booking">';

#echo 'Menu Id: ' . $menue_id . '<br>';

$seitentitel = getSqlInhalte($conn, $menue_id)['seitentitel'];
$absatz_id = getSqlInhalte($conn, $menue_id)['id'];

#echo 'ÜBERSCHRIFT: ' . $seitentitel . '<br>';
#echo 'Absatz Id: ' . $absatz_id . '<br>';

# Überschrift
$var_betreff = $seitentitel;
if ($var_betreff == "") $var_betreff = "Anfrage";
#echo $var_betreff . '<br>';

// ### Ausgabe
$einheiten[] = '<div id="ranfrage"><h2>' . $var_betreff . '</h2></div>' . "\n";

$einheiten[] = $einheit_1 . ' einheit_1 ' . "\n";

# START FORM
$einheiten[] = '<form style="font-family: \'Open Sans\', Arial, Helvetica, sans-serif;" name="Formular" method="post" action="' . $link_ausgabe . '?lg=1&id=' . $menue_id . '">';
#$einheiten[] = '<form style="font-family: \'Open Sans\', Arial, Helvetica, sans-serif;" name="Formular" method="post" action="' . $url . $link_ausgabe . '?lg=1&id=' . $menue_id . '">';
#$einheiten[] = '<form style="font-family: \'Open Sans\', Arial, Helvetica, sans-serif;" name="Formular" method="post" action="/reservierungsanfrage-anfragen.php?lg=1&amp;id=20200108122221">';

$einheiten[] = '<!-- Fehlermeldung -->
<p class="small_info">Die mit * markierten Felder sind Pflichtfelder.</p>';


$einheiten[] = '<!-- Auswahl des Zeitraum -->
<div id="zeitraum">
    <div id="anreise" title="Anreise"><input id="input_anreise" name="form_anreise" class="datepicker input_booking" type="text" value="<?php echo $form_anreise; ?>" placeholder="* Anreise" required></div>
    <div id="abreise" title="Abreise"><input id="input_abreise" name="form_abreise" class="datepicker input_booking" type="text" value="<?php echo $form_abreise; ?>" placeholder="* Abreise" required></div>
    <div class="clbo">&nbsp;</div>
</div>';

$einheiten[] = '<!-- Auswahl der Einheiten -->
<div id="einheiten">';

# Einheiten von einem ausgewählten Formular
$sql_anzahl_einheiten = "SELECT * FROM " . $TabAnfrage . " WHERE absatz_id = '" . $menue_id . "' AND freigabe = '1' ORDER BY position ASC";
$result_anzahl_einheiten = mysqli_query($conn, $sql_anzahl_einheiten);
$num_anzahl_einheiten = mysqli_num_rows($result_anzahl_einheiten);
echo $num_anzahl_einheiten . '<br>';
echo $sql_anzahl_einheiten . '<br>';




$einheit_count = 1;
$count_select = 1;
while ($row = mysqli_fetch_assoc($result_anzahl_einheiten)) {
    echo $row['titel'] . '<br>';
    // ### Ausgabe
    $einheiten[] = '<select class="select_booking" name="einheit_' . $einheit_count . '">';

    for ($i = 0; $i < $row['anzahl']; $i++) {

        /*$option_value = $i . "_" . $row['id'];
        if (isset(${"einheit_" . $i})) {
            $var_var = ${"einheit_" . $i};
        } else {
            $var_var = "einheit_0";
        }
        if (isset(${"einheit_" . $count_select})) {
            $var_var_select = ${"einheit_" . $count_select};
        } else {
            $var_var_select = "einheit_0";
        }

        #$var_var = ${einheit_.${i}};

        if ($var_var_select == $option_value) {
            $selected = " selected='selected'";
        } else {
            $selected = "";
        }

        #$var_var = ${"einheit_" . $i};*/
        #$einheiten[] = $einheit_1;
        #$einheiten[] = 'option class="option_booking" value="' . ($i + 1) . '_' . $row['id'] . '" ' . ($i + 1) . ' ' . $row['titel'] . ' für ' . $row['personen'] * ($i + 1)  . ' ' . (($row['personen'] * ($i + 1) > 1) ? 'Personen' : 'Person') . '/option';

        $ausgabe_personen = '';
        if ($row['personen'] !== 0) {
            $ausgabe_personen = ' für ' . $row['personen'] * ($i + 1)  . ' ' . (($row['personen'] * ($i + 1) > 1) ? 'Personen' : 'Person') . '';
        }


        //$einheiten[] = '<option class="option_booking" value="' . ($i + 1) . '_' . $row['id'] . '"> ' . ($i + 1) . ' ' . $row['titel'] . ' für ' . $row['personen'] * ($i + 1)  . ' ' . (($row['personen'] * ($i + 1) > 1) ? 'Personen' : 'Person') . ' ' . $einheit_1 . '</option>';
        $einheiten[] = '<option class="option_booking" value="' . ($i + 1) . '_' . $row['id'] . '"> ' . ($i + 1) . ' ' . $row['titel'] . '' . $ausgabe_personen . '</option>';
    }

    $einheit_count++;
    $count_select++;

    $einheiten[] = '</select>';
}


$einheiten[] = '<div class="clbo">&nbsp;</div>
</div>';

# Template Id
#$var_template = $row['template_id'];
#echo $var_template . '<br>';

$einheiten[] = '<input id="submit_booking_input" name="schalter" type="submit" value="Anfrage senden">';

// ### Ausgabe
$einheiten[] = '</form>';
$einheiten[] = '<div class="clbo">&nbsp;</div>';
$einheiten[] = '</div>';

##### Ausgabe schreiben
foreach ($einheiten as $einheit) {
    #echo $einheit . ' fff<br>';

    @fwrite($fp, "" . $einheit . "\n");
}
