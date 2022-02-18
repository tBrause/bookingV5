<?php

/**
 * 
 * 
 * Initialize access data and variables
 * 
 * 
 * 
 */
require("../admin/inc/ini.php");
#phpinfo();

?>
<!doctype html>
<html lang="de">

<head>
    <meta http-equiv="Access-Control-Allow-Origin" content="*">
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="shortcut icon" type="image/x-icon" href="fav.ico">
    <meta name="robots" content="noindex, nofollow">
    <!--<meta http-equiv="refresh" content="5; URL=<?php echo $_SERVER['HTTP_REFERER']; ?>">-->
    <title>E-Mail-Versand</title>
    <!-- CSS + Fonts -->
    <link href="<?php echo $url; ?>style.css" rel="stylesheet" type="text/css">
    <link href="<?php echo $url; ?>libs/awesome/css/font-awesome.css" rel="stylesheet" type="text/css">

</head>

<body class="bd_20">

    <!-- INHALT -->
    <main id="inhalt">
        <div id="main_booking">
            <div id="erfolg">Ihre Anfrage wurde erfolgreich gesendet!<br>Vielen Dank. Wir setzen uns umgehend mit Ihnen in Verbindung.</div>
            <div id="links"><a href="<?php echo $url; ?>">Zur Übersicht</a></div>
        </div>
    </main>

</body>

</html>