<?php

$host = "localhost";
$user = "id22050405_zehtdesk";           //user Hosting : id22050405_zehtdesk
$password = "Python13.";          //password Hosting : Python13.
$db = "id22050405_facturacion";    //DB_Name Hosting: id22050405_facturacion

$conn = new mysqli($host,$user,$password,$db);

if($conn->connect_error){
    die("Error en la conexion a la base de datos");
}

$conn->set_charset("utf8");

// $conn -> close();

?>