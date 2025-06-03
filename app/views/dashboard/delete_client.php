<?php
require_once "../Clases/Cliente.php";

session_start();
if (!isset($_SESSION['email'])) {
    header("Location: ../Login/login.php");
    exit;
}

if(Cliente::deleteClient($_GET['CI'])){;
        $msg = "Cliente eliminado exitosamente";
        $url = urlencode($msg);
        header("Location: customers.php?msg=".$url);
}
?>