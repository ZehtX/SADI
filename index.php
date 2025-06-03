<?php
session_start();
if(!isset($_SESSION['email'])){ 	//Agregar la direccion "/Login/login.php" para el hosting
    header("location: Login/login.php");
}else{
    header("location: Dashboard");
}
?>