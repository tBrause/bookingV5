<?php
require('inc/ini.php');

$sql = "SELECT * FROM `submit` WHERE `datetime` < '" . date('Y-m-d H:i:s', time() - (3600 * 24)) . "'";
#echo $sql . '<br>';
$result = mysqli_query($conn, $sql);

while ($row = mysqli_fetch_array($result)) {

    $sql_del = "DELETE FROM `submit` WHERE id = '" . $row['id'] . "'";
    #echo $sql_del . '<br>';
    $result_del = mysqli_query($conn, $sql_del);
}

mysqli_free_result($result);
