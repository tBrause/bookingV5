<?php
# error_reporting(0);
################# Initialize access data and variables ###
require('inc/ini.php');
require('inc/fct.header.php');

################# Received form data ###
$name_form = trim(substr(filter_input(INPUT_POST, 'uname'), 0, 30));
$password_form = trim(substr(filter_input(INPUT_POST, 'pword'), 0, 60));
$button = trim(substr(filter_input(INPUT_POST, 'button'), 0, 20));

################# Check input ###
if ($button == "Login") {

    # Query database
    $sql = "SELECT * FROM `user` WHERE `release` = '1'";
    $result = mysqli_query($conn, $sql);

    $login = 0;
    while ($row = mysqli_fetch_array($result)) {
        if (password_verify($password_form, $row['password']) && $name_form == $row['username']) {
            $login = 1;
            session_start();
            $_SESSION['uid'] = $row['id'];
            $_SESSION['did'] = $row['departmentId'];
            $_SESSION['login'] = true;
            header('Location: main.php');
            die();
        }
    }
    if ($login === 0) {
        $meldung[] = 'Login nicht korrekt, oder das Konto ist gesperrt.';
    }
    setCookieId($cookie_age);
}
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
    <style>
        div#login {
            display: flex;
            width: 100vw;
            height: 90vh;
            align-items: center;
        }

        div#error {
            display: flex;
            width: 100vw;
            height: 5vh;
            align-items: center;
            justify-content: center;
        }

        div#login form {
            max-width: 500px;
            margin: auto;
        }

        form * {
            padding: 5px;
        }

        input[type="text"],
        input[type="password"],
        button[type="submit"] {
            height: auto;
            width: 100%;
            margin-bottom: 5px;
            height: 32px;
        }

        button[type="submit"] {
            margin-bottom: 6px;
            cursor: pointer;
            font-size: 1.1rem;
            text-align: center;
        }

        fieldset {
            width: 200px;
            margin-top: -20vh;
        }

        legend {
            font-weight: 700;
        }
    </style>
</head>

<body>
    <?php
    if (isset($meldung)) {
        echo '<div id="error">';
        echo implode('<br>', $meldung);
        echo '</div>';
    }
    ?>
    <div id="login">
        <form action="<?php echo $_SERVER['SCRIPT_NAME'] ?>" method="post">
            <fieldset style="display: block;">
                <legend>Login</legend>
                <input name="uname" type="text" maxlength="30" placeholder="Nutzername" required>
                <input name="pword" type="password" maxlength="60" placeholder="Passwort" required>
                <button type="submit" name="button" value="Login">Login</button>
            </fieldset>
        </form>
    </div>
</body>

</html>