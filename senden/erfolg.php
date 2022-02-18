<?php
require("../admin/inc/ini.php");

$senden = 'Anfrage senden';
require("../inc/request.php");

/**
 * 
 * Funktionen für die Kontrolle der Versuche
 * 
 */

#require('../inc/check.php');

#session_start();
#$session_id = session_id();

#echo getSessionId();

echo 'Die Anfrage wird gesendet ...';


#require("../inc/mail.php");

$sql = "SELECT * FROM `submit` WHERE `session` = '" . session_id() . "'";
$result = mysqli_query($conn, $sql);

##### Ist der Besucher in der DB registriert
if ($result->num_rows === 1) {

    $row = mysqli_fetch_array($result);
    echo $sql . "<br>";
    echo $row['msg'] . "<br>";
    echo $row['count'] . "<br>";
    echo $row['send'] . "<br>";
    echo $row['bad'] . "<br>";

    $bad_send = 0;
    if (intval($row['bad']) >= 1) {
        $bad_send = $bad_send + 1;
    }
    if (intval($row['send']) >= 1000) {
        $bad_send = $bad_send + 1;
    }
    if (intval($row['count']) >= 300) {
        $bad_send = $bad_send + 1;
    }

    if ($bad_send === 0) {
        $email_content = $row['msg'];
        require("../inc/mail.php");
    }
}

##### Wenn nicht

else {
}
