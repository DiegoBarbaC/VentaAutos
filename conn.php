<?php

$db_host ="localhost";
$db_username = "sysadmin";
$db_password = "Ogeid-01";
$db_database = "venta_autos";

$db = new mysqli($db_host, $db_username, $db_password, $db_database);
mysqli_query($db, "SET NAMES 'utf8'");

if($db->connect_errno > 0){
    die("No es posible conectarse a la base de datos [". $db->connect_error ."]");
}