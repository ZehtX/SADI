<?php
require_once "../Clases/Factura.php";

session_start();
if (!isset($_SESSION['email'])) {
    header("Location: ../Login/login.php");
    exit;
}

if(Factura::deleteFactura($_GET['Codigo'])){;
        $msg = "Factura eliminado exitosamente";
        $url = urlencode($msg);
        header("Location: orders.php?msg=".$url);
}
?>