<?php
#require("../admin/inc/ini.php");
#require("request.php");

### Aufruf der Klasse : PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'class/Exception.php';
require 'class/PHPMailer.php';
require 'class/SMTP.php';

### Start der Klasse : PHPMailer
$mail = new PHPMailer;
$mail->isSMTP();

### Fehlerbehandlung
$mail->SMTPDebug = 0; // 0 = off (for production use) - 1 = client messages - 2 = client and server messages

### CharSet für E-Mail
$mail->CharSet   = 'UTF-8';
$mail->Encoding  = 'base64';

### SQL SELECT `config`
$sql = "SELECT * FROM `config` WHERE `id` = '1'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);

### HOST
$mail->Host = $row['smtpHost'];

### PORT
$mail->Port = $row['smtpPort']; // TLS only

### SECURE
#$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
$mail->SMTPSecure = 'tls'; // ssl is depracated
$mail->SMTPAuth = true;

### Verbindungsdaten Postfach
$mail->Username = $row['smtpUsername'];
$mail->Password = $row['smtpPassword'];

### E-Mail Informationen gesendet AN
$mail->addAddress($row['email'], $row['email_description']);

### E-Mail Informationen gesendet VON
$emailTo = 'brause.torsten@gmail.com';
$emailToName = 'Torsten Brause';
$mail->setFrom($emailTo, $emailToName);


### Subject der E-Mail
$mail->Subject = getSqlInhalte($conn, $id)['seitentitel'];

#$email_content = 'Body';
### Inhalt der E-Mail
#$mail->msgHTML("test body"); //$mail->msgHTML(file_get_contents('contents.html'), __DIR__); //Read an HTML message body from an external file, convert referenced images to embedded,
$mail->AltBody = 'HTML messaging not supported';
$mail->Body = $email_content;
// $mail->addAttachment('images/phpmailer_mini.png'); //Attach an image file

if (!$mail->send()) {
    #echo "Mailer Error: " . $mail->ErrorInfo;
} else {

    ##### UPDATE SEND => check.php
    updateSubmitSend($conn, selectSubmitId($conn));
    updateSubmitBack($conn, selectSubmitId($conn));

    ### wechsle zur SENDEN Seite
    $go = $url . "senden/index.php";
    header("Location: " . $go);
    die();

    #header("Location: " . $_SERVER['REQUEST_URI'] . "");
    #echo "Message sent!";
    #echo '<div id="erfolg">Ihre Anfrage wurde erfolgreich gesendet!<br>Vielen Dank. Wir setzen uns umgehend mit Ihnen in Verbindung.</div>';

    #header("Location: " . $_SERVER['HTTP_REFERER'] . "");
    #header("Location: " . $_SERVER['HTTP_HOST'] . "/booking-online-version/senden/index.php");

    /*
    $time = 10; //seconds to wait
    sleep($time);
    header("Location: " . $_SERVER['HTTP_REFERER'] . "");
    exit;
    */
}
