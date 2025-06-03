<?php
session_start();
if (!isset($_SESSION['email']) && !isset($_SESSION['ID'])) {
	header("location: ../Login/login.php");
}

require_once "../Clases/Factura.php";
require_once "../Clases/Producto.php";

if (isset($_COOKIE['Detalle'])) {
	Producto::RestoreStock($_COOKIE['Detalle']);
	setcookie("Detalle", "", -1);
}


if (empty($_POST['search']) && empty($_POST['Codigo_Factura'])) {
	$facturas = Factura::getAllFactura();
	$btn_ini = false;
} else {

	$inputValue = $_POST['Codigo_Factura'];

	if (preg_match('/^\d{7,8}$/', $inputValue)) {
		
		$facturas = Factura::searchFacturaByCed($inputValue);
		$btn_ini = true;
		
	}elseif (preg_match('/^\d{4}$/', $inputValue)) {
		$facturas = Factura::searchFacturaByCode($inputValue);
		$btn_ini = true;
	}
	
	
}


?>
<!doctype html>
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

				<!-- Content wrapper start -->
				<div class="content-wrapper">
					<!-- Row start -->
					<div class="row">
						<div class="col-sm-12 col-12">
							<div class="card">
								<div class="card-header">
									<div class="card-title">Historial de Ventas</div>
								</div>
								<!-- Search container start -->
								<div class="search-container barra-container" style="margin-top: 15px; margin-left: 10px;">
									<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
										<!-- Search input group start -->
										<div class="input-group">
											<input type="text" class="form-control barra-busqueda" placeholder="Buscar Factura" name="Codigo_Factura" pattern="^\d{4}$|^\d{7,8}$">
											<button class="btn" type="submit">
												<i class="bi bi-search"></i>
											</button>
										</div>
										<!-- Search input group end -->
									</form>
								</div>
								<!-- Search container end -->
								<br>
								<div class="card-body">

									<div class="table-responsive">
										<table class="table v-middle">
											<thead>
												<tr>
													<th>Codigo</th>
													<th>Cedula</th>
													<th>Nombre Apellido</th>
													<th>Total</th>
													<th>Fecha</th>
												</tr>
											</thead>
											<tbody>
												<?php
												Factura::viewDataFactura($facturas);
												?>
											</tbody>
										</table>
										<?php
										btnBackOrders($btn_ini);
										?>
									</div>

								</div>
							</div>
						</div>
					</div>
					<!-- Row end -->
				</div>
				<!-- Vista Modal del Cliente -->

				<!-- End Modal View Client -->
				<!-- Modals End -->

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

	<script>
		function imprimirValor(numero) {
			/*var Codigo_Factura = document.getElementById("cod" + numero).textContent;
            var Cedula_Cliente = document.getElementById("cedula" + numero).textContent;
            var Descripcion = document.getElementById("des" + numero).textContent;
            var Cantidad = document.getElementById("can" + numero).textContent;
            var Total = document.getElementById("total" + numero).textContent;
			var Fecha = document.getElementById("fecha" + numero).textContent;*/

			// Utiliza los valores como desees
			/*document.getElementById("vCod").innerHTML = Codigo_Factura;
            document.getElementById("vCed").innerHTML = Cedula_Cliente;
			document.getElementById("vDes").innerHTML = Descripcion;
            document.getElementById("vCan").innerHTML = Cantidad;
            document.getElementById("vTot").innerHTML = Total;
			document.getElementById("vFec").innerHTML = Fecha;*/

			// Valores par inputs
			/*document.getElementById("iCod").value = Codigo_Factura;
            document.getElementById("iCed").value = Cedula_Cliente;
            /*document.getElementById("iDes").value = Descripcion;
            document.getElementById("iCan").value = Cantidad;
            document.getElementById("iTot").value = Total;
			document.getElementById("iFec").value = Fecha;*/
		}
	</script>

</body>

</html>