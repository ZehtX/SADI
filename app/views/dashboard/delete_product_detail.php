<?php
require_once "../Clases/Producto.php";
require_once "../Clases/Detalle.php";
require_once "../Clases/Inputs.php";

session_start();
if (!isset($_SESSION['email'])) {
    header("Location: ../Login/login.php");
    exit;
}

if (isset($_GET['idDetail']) && isset($_GET['Precio'])) {
    $id = $_GET['idDetail'];
    $precio = $_GET['Precio'];
    $detalle = $_COOKIE['Detalle'];

    $array = explode("|", $detalle);

    $count = count($array) - 2;

    $detail = '';
    for ($i = 0; $i <= $count; $i++) {

        if ($i != $id) {
            $detail .= $array[$i] . "|";
        }else {
            $product = explode(",",$array[$i]);

            for ($i=0; $i < count($product); $i++) { 
                $codigo = $product[0];
                $cantidad = $product[2];
            }
        }
    }

    Producto::updateStock($codigo,$cantidad);

    $fecha = time() + 7200;

    $detail = trim($detail);

    setcookie("Detalle","", -1);
    setcookie("Detalle", $detail, $fecha);
// 
    $subtotal = $_COOKIE['subtotal'];
// 
    $subtotal -= $precio;
// 
    setcookie("subtotal","", -1);
    setcookie("subtotal", $subtotal, $fecha);
// 
    header("Location: Checkout_step2.php");
}

// $msg = "Producto eliminado exitosamente";
// $url = urlencode($msg);
// header("Location: products.php?msg=".$url);
