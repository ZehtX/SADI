<?php
session_start();
if (!isset($_SESSION['email']) && !isset($_SESSION['ID'])) {
	header("location: ../Login/login.php");
}

require_once "../Clases/Factura.php";
require_once "../Clases/Detalle.php";
require_once "../Clases/Producto.php";
require_once "../Clases/Inputs.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $CI = $_COOKIE['cedula'];
    $Total = $_POST['total'];

    $factura = new Factura(null,$CI,null,$Total);

    $factura->createFactura();

    $CodigoFactura = $factura->getCodigoFactura();

    if (Detalle::registerDetailsGroup($CodigoFactura,$_COOKIE['Detalle'])) {
        
        setcookie("cedula", "", -1);
		setcookie("Detalle", "", -1);
		setcookie("subtotal", "", -1);
        header("Location: checkout_end.php?Codigo=".$CodigoFactura);
        exit;
    }else {
        echo "No sirve";
    }
}


?>