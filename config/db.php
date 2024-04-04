<?php 
    $user = "educacon_educacon";
    $server = "localhost";
    $passWord = "De20por15te!";
    $database = "educacon_usersCCDS";
    $conexion = new mysqli($server, $user, $passWord, $database);

    if ($conexion->connect_error) {
        die("Conexión fallida: " . $conexion->connect_error);
    }
?>