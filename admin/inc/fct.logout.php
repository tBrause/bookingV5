<?php
################# require main.php => switsh ###
session_start();

$_SESSION = array(); // NEU
session_unset(); // NEU
session_destroy();

setcookie('PHPSESSID', '', 0);
setcookie('COOKIEID', '', 0);
setcookie('login', '', 0);
setcookie('loginattempt', '', 0);
header("Location: index.php");
die(); // NEU
