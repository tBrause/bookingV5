<?php
function fctInitConf($conn)
{
    getConfig($conn);
}

fctInitConf($conn);



function getConfig($conn)
{
    $sql = "SELECT * FROM `config`";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);

    ##### RETURN
    return $row;
}
