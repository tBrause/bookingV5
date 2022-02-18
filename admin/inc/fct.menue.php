<?php
################# require ini.php ###

################# Zeige das Hauptmenü
function displayMainMenue($conn, $area)
{
    $sql = "SELECT * 
    FROM pages 
    WHERE `level` = '1' AND `release` = '1' AND `departmentId` >= " . $_SESSION['did'] . " 
    ORDER BY position";

    $result = mysqli_query($conn, $sql);

    echo '<div id="main_nav"><ul>';

    #echo '<li><a href="#"><i class="fas fa-bars"></i></a></li>';

    while ($row = mysqli_fetch_array($result)) {
        echo '<li' . (($area == $row['id'] or (!$area and $row['id'] == 1)) ? " class='active'" : "") . '><a href="' . $_SERVER["SCRIPT_NAME"] . '?area=' . $row['id'] . '">' . $row["name"] . '<i class="fas ' . $row["icon"] . '"></i></a></li>';
    }

    echo '</ul></div>';
    mysqli_free_result($result);
}

################# Zeige das Untermenü
function displaySubMenue($conn, $area, $sub)
{
    $sql = "SELECT * 
    FROM pages 
    WHERE `level` = '2' AND `subId` = '" . $area . "' AND `release` = '1' 
    ORDER BY position";
    $result = mysqli_query($conn, $sql);

    echo '<div id="sub_nav"><ul>';
    while ($row = mysqli_fetch_array($result)) {
        echo '<li' . (($sub == $row['id']) ? " class='active'" : "") . '><a href="' . $_SERVER["SCRIPT_NAME"] . '?area=' . $row['subId'] . '&sub=' . $row['id'] . '"><i class="fas ' . $row["icon"] . '"></i>' . $row["name"] . '</a><li>';
    }
    echo '</ul></div>';
    mysqli_free_result($result);
}
