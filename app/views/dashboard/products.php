<?php
session_start();
if (!isset($_SESSION['email']) && !isset($_SESSION['ID'])) {
    header("location: ../Login/login.php");
}

require_once "../Clases/Producto.php";

/*if (isset($_COOKIE['Detalle'])) {
	Producto::RestoreStock($_COOKIE['Detalle']);
	setcookie("Detalle", "", -1);
}*/

$messages = array();

if (isset($_GET['msg'])) {
    $messages[] = $_GET['msg'];
}

if (empty($_POST['search']) && empty($_POST['code'])) {
    $products = Producto::getAllProducts();
    $btn_ini = false;
} else {
    $products = Producto::searchProduct($_POST['code']);
    $btn_ini = true;
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
                    <div class="header-actions-container">
                    <?php require_once "userOptions.php";?>
                    </div>
                    <!-- Header actions ccontainer end -->

                </div>
                <!-- Page header ends -->

                <!-- Content wrapper scroll start -->
                <div class="content-wrapper-scroll">
                    <?php
                    if (isset($messages)) {
                        blueMsg($messages);
                    }
                    ?>

                    <!-- Content wrapper start -->
                    <div class="content-wrapper">

                        <!-- Row start -->
                        <div class="row">
                            <div class="col-sm-12 col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <div class="card-title">Productos</div>
                                    </div>
                                    <!-- Search container start -->
                                    <div class="search-container barra-container"
                                        style="margin-top: 15px; margin-left: 10px;">

                                        <!-- Search input group start -->
                                        <form action="" method="post" <div class="input-group">
                                            <input type="text" class="form-control barra-busqueda"
                                                placeholder="Buscar Producto" name="code"
                                                pattern="^[0-9 a-z A-Z]{4,15}$" title="Por favor, ingrese el Codigo">
                                            <button class="btn" type="submit" value="search">
                                                <i class="bi bi-search"></i>
                                            </button>
                                    </div>
                                    </form>
                                    <!-- Search input group end -->


                                    <!-- Search container end -->
                                    <br>
                                    <div class="card-body">

                                        <div class="table-responsive">
                                            <table class="table v-middle">
                                                <thead>
                                                    <tr>
                                                        <th>Codigo</th>
                                                        <th>Descripción</th>
                                                        <th>Precio</th>
                                                        <th>Categoria</th>
                                                        <th>Stock</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                        Producto::viewDataProducts($products);
                                                    ?>

                                                </tbody>
                                            </table>
                                            <?php
                                            btnBackProduscts($btn_ini);
                                            ?>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Row end -->
                    </div>
                    <!-- Content wrapper end -->

                    <!-- App Footer start -->
                    <div class="app-footer">
                        <span>© SADI 2024</span>
                    </div>
                    <!-- App footer end -->

                </div>
                <!-- Content wrapper scroll end -->

                <!-- Modals Start -->
                <!-- Vista Modal del Cliente -->
                <div class="modal active" id="viewProduct" tabindex="-1" aria-labelledby="viewClientLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title text-muted" id="viewClientLabel">Detalles del Producto</h5>
                                <button type="button" class="btn-close text-reset" data-bs-dismiss="modal"
                                    aria-label="Cerrar">
                                    <div class="icon col-md-6">
                                        <i class="bi bi-x-lg"></i>
                                    </div>
                                </button>
                            </div>
                            <div class="modal-body justify-content-center">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label for="nombre" class="modal-label h5 mb-1">Codigo</label>
                                                <p id="vCode" class="modal-text text-muted mb-3"></p>
                                            </div>
                                            <div class="col-md-12">
                                                <label for="telefono" class="modal-label h5 mb-1">Descripción</label>
                                                <p id="vDesc" class="modal-text text-muted mb-3"></p>
                                            </div>
                                            <div class="col-md-12">
                                                <label for="cedula" class="modal-label h5 mb-1">Stock</label>
                                                <p id="vStock" class="modal-text text-muted mb-3"></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label for="cedula" class="modal-label h5 mb-1">Categoria</label>
                                                <p id="vCat" class="modal-text text-muted mb-3"></p>
                                            </div>
                                            <div class="col-md-12">
                                                <label for="direccion" class="modal-label h5 mb-1">Precio</label>
                                                <p id="vPrecio" class="modal-text text-muted mb-3"></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Cerrar</button>
                            </div>
                        </div>
                    </div>
                </div>



                <!-- Modals End -->
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

        <script>
        function imprimirValor(numero) {
            var codigo = document.getElementById("codigo" + numero).textContent;
            var descripcion = document.getElementById("descripcion" + numero).textContent;
            var precio = document.getElementById("precio" + numero).textContent;
            var categoria = document.getElementById("categoria" + numero).textContent;
            var stock = document.getElementById("stock" + numero).textContent;

            // Utiliza los valores como desees
            document.getElementById("vCode").innerHTML = codigo;
            document.getElementById("vDesc").innerHTML = descripcion;
            document.getElementById("vPrecio").innerHTML = precio;
            document.getElementById("vCat").innerHTML = categoria;
            document.getElementById("vStock").innerHTML = stock;

            // Valores par inputs
            document.getElementById("iCode").value = codigo;
            document.getElementById("iDesc").value = descripcion;
            document.getElementById("iPrecio").value = precio;
            document.getElementById("iCat").value = categoria;
            document.getElementById("iStock").value = stock;
        }
        </script>

</body>

</html>