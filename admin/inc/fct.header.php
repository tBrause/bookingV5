<?php
################# require ini.php ###

$message = array();
$cookie_age = (2 * 24 * 60 * 60);

function init($cookie_age)
{
    setSessionId();
    checkSession();
    setCookieId($cookie_age);
}

init($cookie_age);

# Starte SESSION und Setze SESSION ID
function setSessionId()
{
    session_start();
}

# Überprüfe, ob SESSION funktioniert
function checkSession()
{
    if (!$_SESSION) {
        $message[] = 'Keine Sessions erlaubt';
    }
}

# Setze COOKIE und zähle die Loginversuche
function setCookieId($cookie_age)
{
    setcookie('COOKIEID', session_id(), time() + $cookie_age);
    setcookie('login', time(), time() + $cookie_age);
    if (!isset($_COOKIE['loginattempt'])) {
        $loginversuch = 0;
    } else {
        $loginversuch = $_COOKIE['loginattempt'] + 1;

        #stop login
        if ($_COOKIE['loginattempt'] >= 4) {
            #die('Bitte wenden Sie sich an den Administrator');
        }
    }
    setcookie('loginattempt', $loginversuch, time() + $cookie_age);
}
