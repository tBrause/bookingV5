<?php
################# require ini.php ###


function init($conn, $senden)
{
    setSessionId();
    checkSession($senden);
    selectSubmit($conn);
    checkNewSite($conn);
}

init($conn, $senden);

##### Starte SESSION und Setze SESSION ID
function setSessionId()
{
    session_start();
}

##### Lies SESSION ID
function getSessionId()
{
    $session_id = session_id();
    return $session_id;
}

##### Überprüfe, ob SESSION funktioniert
function checkSession($senden)
{
    if ($senden == 'Anfrage senden' && !$_COOKIE) {
        header("Location: " . $_SERVER['REQUEST_URI'] . "");
        die();
    }
}

function checkNewSite($conn)
{
    $referrer = selectSubmitSession($conn)['referrer'];
    $akt_site = $_SERVER['REQUEST_URI'];

    if ($referrer != $akt_site) {
        $sql = "UPDATE `submit` SET `attempt` = '0', `send` = '0', `referrer` = '" . $akt_site . "' WHERE session = '" . selectSubmitSession($conn)['session'] . "'";
        #echo $sql . '<br>';
        $result = mysqli_query($conn, $sql);
    }
}

function selectSubmitSession($conn)
{
    $sql = "SELECT * FROM `submit` WHERE session = '" . getSessionId() . "'";
    $result = mysqli_query($conn, $sql);

    if ($result->num_rows >= 1) {
        $row = mysqli_fetch_assoc($result);

        ##### RETURN
        return $row;
    }

    mysqli_free_result($result);
}

function selectSubmitId($conn)
{
    $sql = "SELECT * FROM `submit` WHERE id = '" . selectSubmitSession($conn)['id'] . "'";
    #echo $sql . '<br>';
    $result = mysqli_query($conn, $sql);

    if ($result->num_rows >= 1) {
        $row = mysqli_fetch_assoc($result);
        ##### RETURN
        return $row;
    }

    mysqli_free_result($result);
}

function selectSubmit($conn)
{
    $sql = "SELECT * FROM `submit` WHERE session = '" . getSessionId() . "'";
    $result = mysqli_query($conn, $sql);

    if ($result->num_rows >= 1) {
        $row = mysqli_fetch_assoc($result);

        ##### UPDATE COUNT
        updateSubmit($conn, $row);
    } else {

        ##### INSERT NEW USER
        insertSubmit($conn);
        #echo 'Neuer Eintrag';
    }
}

function updateSubmit($conn, $row)
{
    $sql = "UPDATE `submit` SET `attempt` = '" . ($row['attempt'] + 1) . "' WHERE id = '" . $row['id'] . "'";
    #echo $sql . "<br>";
    $result = mysqli_query($conn, $sql);
}

function updateSubmitSend($conn, $row)
{
    $sql = "UPDATE `submit` SET `send` = '" . ($row['send'] + 1) . "' WHERE id = '" . $row['id'] . "'";
    #echo $sql . "<br>";
    $result = mysqli_query($conn, $sql);
}

function updateSubmitBad($conn, $row)
{
    $sql = "UPDATE `submit` SET `bad` = '" . ($row['bad'] + 1) . "' WHERE id = '" . $row['id'] . "'";
    #echo $sql . "<br>";
    $result = mysqli_query($conn, $sql);
}

function updateSubmitBack($conn, $row)
{
    $sql = "UPDATE `submit` SET `back` = '1' WHERE id = '" . $row['id'] . "'";
    #echo $sql . "<br>";
    $result = mysqli_query($conn, $sql);
}

/**
 * 
 * Neuer Eintrag
 * 
 * 
 */
function insertSubmit($conn)
{

    if (session_valid_id(getSessionId()) == 1) {

        $sql = "INSERT INTO `submit` (`session`, `datetime`, `attempt`, `send`, `back`, `referrer`) VALUE ('" . getSessionId() . "', '" . date('Y-m-d H:i:s') . "', '0', '0', '0', '" . $_SERVER['REQUEST_URI'] . "')";
        #echo $sql . "<br>";
        $result = mysqli_query($conn, $sql);
    } else {
        #echo "abbruch<br>";
        die();
    }
}

/**
 * 
 * Überprüfung, ob die SESSION ID konform ist
 * 
 */
function session_valid_id($session_id)
{
    return preg_match('/^[-,a-zA-Z0-9]{1,128}$/', $session_id) > 0;
}
