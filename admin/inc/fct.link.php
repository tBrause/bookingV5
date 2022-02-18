<?php

######## LINK ERSTELLEN
function getLink($conn, $id)
{
    $link_ausgabe = '';

    $sql = "SELECT 
    `id`, 
    `titel`   
    FROM `cms_menue` 
    WHERE id = " . $id . "";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);

    ######## DATEINAME
    $link = $row['titel'];
    $umlaute = array(" " => "-", "_" => "-", "ä" => "ae", "&auml;" => "ae", "Ä" => "Ae", "&Auml;" => "Ae", "ö" => "oe", "&ouml;" => "oe", "Ö" => "Oe", "&Ouml;" => "Oe", "ü" => "ue", "&uuml;" => "ue", "Ü" => "Ue", "&Uuml;" => "Ue", "ß" => "ss", "&szlig;" => "ss", "&" => "und", "&amp;" => "und", ":" => "", "(" => "", ")" => "");
    foreach ($umlaute as $suche => $ersetzen) {
        $link = str_replace("" . $suche . "", "" . $ersetzen . "", "" . strtolower($link) . "");
    }
    #echo $link . '-anfragen.php?lg=1&id=' . $id . '<br>';
    $link_ausgabe = $link . '-anfragen.php?lg=1&id=' . $id;
    #https://www.flora.net-booking.de/kurztrip-nach-berlin-anfragen.php?lg=1&id=20200109101255

    mysqli_free_result($result);

    return $link_ausgabe;
}


######## LINK ERSTELLEN
function getNewLink($new_id, $titel)
{
    $link_ausgabe = '';

    ######## DATEINAME
    $link = $titel;
    $umlaute = array(" " => "-", "_" => "-", "ä" => "ae", "&auml;" => "ae", "Ä" => "Ae", "&Auml;" => "Ae", "ö" => "oe", "&ouml;" => "oe", "Ö" => "Oe", "&Ouml;" => "Oe", "ü" => "ue", "&uuml;" => "ue", "Ü" => "Ue", "&Uuml;" => "Ue", "ß" => "ss", "&szlig;" => "ss", "&" => "und", "&amp;" => "und", ":" => "", "(" => "", ")" => "");
    foreach ($umlaute as $suche => $ersetzen) {
        $link = str_replace("" . $suche . "", "" . $ersetzen . "", "" . strtolower($link) . "");
    }
    $link_ausgabe = $link . '-anfragen.php?lg=1&id=' . $new_id;

    return $link_ausgabe;
}

######## DATEI ERSTELLEN
function getNewFile($titel)
{
    $link_ausgabe = '';

    ######## DATEINAME
    $link = $titel;
    $umlaute = array(" " => "-", "_" => "-", "ä" => "ae", "&auml;" => "ae", "Ä" => "Ae", "&Auml;" => "Ae", "ö" => "oe", "&ouml;" => "oe", "Ö" => "Oe", "&Ouml;" => "Oe", "ü" => "ue", "&uuml;" => "ue", "Ü" => "Ue", "&Uuml;" => "Ue", "ß" => "ss", "&szlig;" => "ss", "&" => "und", "&amp;" => "und", ":" => "", "(" => "", ")" => "");
    foreach ($umlaute as $suche => $ersetzen) {
        $link = str_replace("" . $suche . "", "" . $ersetzen . "", "" . strtolower($link) . "");
    }
    $link_ausgabe = $link . '-anfragen.php';

    return $link_ausgabe;
}
