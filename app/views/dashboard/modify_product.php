<?php
session_start();
if (!isset($_SESSION['email']) && !isset($_SESSION['ID'])) {
    header("location: ../Login/login.php");
}

require_once "../Clases/Producto.php";
require_once "../Clases/Inputs.php";

if (isset($_COOKIE['Detalle'])) {
	Producto::RestoreStock($_COOKIE['Detalle']);
	setcookie("Detalle", "", -1);
}

$errors = array();
$messages = array();

if (isset($_GET['Codigo'])) {
    $arrayProduct = Producto::searchProduct($_GET['Codigo']);

    $Codigo = valArray($arrayProduct, "Codigo");
    $Descripcion = valArray($arrayProduct, "Descripcion");
    $Categoria = valArray($arrayProduct, "Nombre");
    $Precio = valArray($arrayProduct, "Precio");
    $Stock = valArray($arrayProduct, "Cantidad");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (!empty($_POST['code']) && !empty($_POST['description']) && !empty($_POST['category']) && !empty($_POST['precio']) && !empty($_POST['stock'])) {

        $newProduct = new Producto($_POST['code'], $_POST['description'], $_POST['stock'], $_POST['precio'], $_POST['category']);

        if ((Producto::searchProduct($newProduct->getCodigo()))) {

            if ($newProduct->updateProduct()) {
                $msg = "Producto Actualizado Exitosamente";
                $url = urlencode($msg);
                header("Location: products.php?msg=" . $url);
            } else {
                $errors[] = "Ocurrio Un Error Intente Nuevamente";
            }
        } else {
            $errors[] = "El Producto no Existe";
        }
    } else {
        $errors[] = "Porfavor Llene Todos los Campos";
    }
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

    <!-- Edit for Zeht -->
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
                if (isset($errors)) {
                    greyMsg($errors);
                }
                ?>
                <!-- Content wrapper start -->
                <div class="content-wrapper">
                    <!-- Row start -->
                    <div class="row">
                        <div class="col-sm-12 col-12">
                            <div class="card">
                                <div class="card-header">
                                    <div class="card-title">Actualizar Producto</div>
                                </div>
                                <div class="card-body">

                                    <div class="row">
                                        <div class="col-sm-12 col-12">
                                            <div class="card-border">
                                                <div class="card-border-title">Informacion General</div>
                                                <div class="card-border-body">
                                                    <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
                                                        <div class="row">
                                                            <div class="col-sm-6 col-12">
                                                                <div class="mb-3">
                                                                    <label class="form-label">Codigo <span class="text-red">*</span></label>
                                                                    <input type="text" class="form-control" placeholder="Codigo del Producto" name="code" value="<?php echo $Codigo ?>" readonly>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6 col-12">
                                                                <div class="mb-3">
                                                                    <label class="form-label">Descripción <span class="text-red">*</span></label>
                                                                    <input type="text" class="form-control" placeholder="Descripción del Producto" name="description" value="<?php echo $Descripcion ?>" required>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6 col-12">
                                                                <div class="mb-3">
                                                                    <label class="form-label">Categoria<span class="text-red">*</span></label>
                                                                    <select class="form-control" name="category" required>
                                                                        <?php
                                                                        $Categorias = Producto::getAllCategory();
                                                                        foreach ($Categorias as $categoria) {

                                                                            if ($Categoria == $categoria['Nombre']) {
                                                                                echo '<option value="' . $categoria['ID'] . '" selected>' . $categoria['Nombre'] . '</option>';
                                                                            } else {
                                                                                echo '<option value="' . $categoria['ID'] . '">' . $categoria['Nombre'] . '</option>';
                                                                            }
                                                                        }
                                                                        ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6 col-12">
                                                                <div class="mb-3">
                                                                    <label class="form-label">Precio <span class="text-red">*</span></label>
                                                                    <div class="input-group">
                                                                        <span class="input-group-text">$</span>
                                                                        <input type="text" class="form-control" name="precio" value="<?php echo $Precio ?>" required>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6 col-12">
                                                                <div class=" mb-3">
                                                                    <label class="form-label">Stock <span class="text-red">*</span></label>
                                                                    <input type="number" class="form-control" placeholder="Cantidad Disponible" name="stock" min="1" max="999" value="<?php echo $Stock ?>" required>
                                                                </div>
                                                            </div>

                                                        </div>

                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-12 col-12">
                                            <div class="custom-btn-group flex-end">
                                            <a href="products.php" class="btn btn-light">Cancelar</a>
                                                <button class="btn btn-success">Actualizar Producto</button>
                                            </div>
                                            </form>
                                        </div>
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