<?php
session_start();
if (!isset($_SESSION['email']) && !isset($_SESSION['ID'])) {
    header("location: ../Login/login.php");
}

require_once "../Clases/Factura.php";
require_once "../Clases/Detalle.php";
require_once "../Clases/Producto.php";
require_once "../Clases/Inputs.php";

if ($_GET['Codigo']) {
    $CodigoFactura = $_GET['Codigo'];

    $factura = Factura::searchFactura2($CodigoFactura);
    $ListDetails = Detalle::getListProducts($CodigoFactura);
}



?>
<!-- Code End -->

<!DOCTYPE html>
<html lang="es">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Meta -->
    <meta name="author" content="Zeht" />
    <link rel="canonical" href="https://ZehtX.github.io/">
    <!-- HTML Meta Tags -->
    <title>SADI | Sistema de Administración Inteligente</title>
    <meta name="description" content="Optimiza tu inventario y factura de manera ágil y eficiente.">

    <!-- Facebook Meta Tags -->
    <meta property="og:url" content="https://zehtx.github.io/Login-Project/">
    <meta property="og:type" content="website">
    <meta property="og:title" content="SADI | Sistema de Administración Inteligente">
    <meta property="og:description" content="Optimiza tu inventario y factura de manera ágil y eficiente.">
    <meta property="og:image" content="https://zehtx.github.io/Login-Project/assets/img/Sadi.png">

    <!-- Twitter Meta Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta property="twitter:domain" content="zehtx.github.io">
    <meta property="twitter:url" content="https://zehtx.github.io/Login-Project/">
    <meta name="twitter:title" content="SADI | Sistema de Administración Inteligente">
    <meta name="twitter:description" content="Optimiza tu inventario y factura de manera ágil y eficiente.">
    <meta name="twitter:image" content="https://zehtx.github.io/Login-Project/assets/img/Sadi.png">

    <!-- Meta Tags Generated via https://www.opengraph.xyz -->
    <meta property="og:site_name" content="SADI">
    <link rel="shortcut icon" href="assets/images/icon/favicon-16x16.png">


    <!-- *************
			************ Common Css Files *************
		************ -->

    <!-- Edits-for-Zeht -->
    <link rel="stylesheet" href="assets/css/edit-Zeht.css">

    <!-- Animated css -->
    <link rel="stylesheet" href="assets/css/animate.css">

    <!-- Bootstrap font icons css -->
    <link rel="stylesheet" href="assets/fonts/bootstrap/bootstrap-icons.css">

    <!-- Main css -->
    <link rel="stylesheet" href="assets/css/main.min.css">


    <!-- *************
			************ Vendor Css Files *************
		************ -->

    <!-- Scrollbar CSS -->
    <link rel="stylesheet" href="assets/vendor/overlay-scroll/OverlayScrollbars.min.css">


    <style>
        .company-name {
            font-size: 30px;
        }

        .tfoot-right {
            text-align: right;
        }
    </style>
</head>

<body>

    <!-- Loading wrapper start -->
    <div id="loading-wrapper">
			<div class="spinner">
				<div class="line1"></div>
				<div class="line2"></div>
				<div class="line3"></div>
				<div class="line4"></div>
				<div class="line5"></div>
				<div class="line6"></div>
			</div>
		</div>
    <!-- Loading wrapper end -->

    <!-- Page wrapper start -->
    <div class="page-wrapper">

        <!-- Sidebar wrapper start -->
        <?php require_once('sidebar.php'); ?> 
        <!-- Sidebar wrapper end -->

        <!-- *************
				************ Main container start *************
			************* -->
        <div class="main-container">

            <!-- Page header starts -->
            <div class="page-header">

                <div class="toggle-sidebar" id="toggle-sidebar"><i class="bi bi-list"></i></div>


                <!-- Header actions ccontainer start -->
                <?php require_once "userOptions.php";?>
                <!-- Header actions ccontainer end -->

            </div>
            <!-- Page header ends -->

            <!-- Content wrapper scroll start -->
            <div class="content-wrapper-scroll">

                <!-- Content wrapper start -->
                <div class="content-wrapper">

                    <div class="container">
                        <div class="text-center">
                            <h1 class="company-name">Vics Marie</h1>
                        </div>
                        <div class="text-center">
                            <p>RIF: J-0012342</p>
                        </div>
                        <div class="text-center">
                            <p>Cédula del Cliente: &nbsp;V-<?php echo valArray($factura,"CI_Cliente") ?></p>
                        </div>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Código</th>
                                    <th scope="col">Descripción</th>
                                    <th scope="col">Cantidad</th>
                                    <th scope="col">Precio</th>
                                </tr>
                            </thead>
                            <tbody>
                               <?php
                                Detalle::viewDetails($ListDetails);
                               ?>
                            </tbody>
                            <tfoot>
                            <tr>
                                    <td colspan="3" class="tfoot-right"><strong>Subtotal:</strong></td>
                                    <td><?php echo Detalle::viewSubtotal($CodigoFactura); ?>$</td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="tfoot-right"><strong>Total:</strong></td>
                                    <td><?php echo valArray($factura,"Total") ?>$</td>
                                </tr>
                            </tfoot>
                        </table>
                        <div class="text-center">
                            <a href="checkout.php" class="btn btn-primary">Volver</a>
                        </div>
                    </div>

                </div>
                <!-- Content wrapper end -->
            </div>

            <!-- App Footer start -->
            <div class="app-footer">
                <span>© SADI 2024</span>
            </div>
            <!-- App footer end -->

        </div>
        <!-- Content wrapper scroll end -->

    </div>
    <!-- *************
				************ Main container end *************
			************* -->

    </div>
    <!-- Page wrapper end -->

    <!-- *************
			************ Required JavaScript Files *************
		************* -->
    <!-- Required jQuery first, then Bootstrap Bundle JS -->
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/modernizr.js"></script>
    <script src="assets/js/moment.js"></script>

    <!-- *************
			************ Vendor Js Files *************
		************* -->

    <!-- Overlay Scroll JS -->
    <script src="assets/vendor/overlay-scroll/jquery.overlayScrollbars.min.js"></script>
    <script src="assets/vendor/overlay-scroll/custom-scrollbar.js"></script>

    <!-- Apex Charts -->
    <script src="assets/vendor/apex/apexcharts.min.js"></script>
    <script src="assets/vendor/apex/custom/sales/salesGraph.js"></script>
    <script src="assets/vendor/apex/custom/sales/revenueGraph.js"></script>
    <script src="assets/vendor/apex/custom/sales/taskGraph.js"></script>

    <!-- Main Js Required -->
    <script src="assets/js/main.js"></script>

</body>

</html>