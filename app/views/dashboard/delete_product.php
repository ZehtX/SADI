<?php
require_once "../Clases/Producto.php";

session_start();
if (!isset($_SESSION['email'])) {
    header("Location: ../Login/login.php");
    exit;
}

if(Producto::deleteProduct($_GET['Codigo'])){;
        $msg = "Producto eliminado exitosamente";
        $url = urlencode($msg);
        header("Location: products.php?msg=".$url);
}
?>