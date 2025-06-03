<?php
session_start();
require_once "../Clases/Producto.php";

if (isset($_COOKIE['Detalle'])) {
	Producto::RestoreStock($_COOKIE['Detalle']);
	setcookie("Detalle", "", -1);
}
session_destroy();

header("Location: index.php");
exit;

?>