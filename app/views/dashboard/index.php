<?php
require_once "../Clases/Cliente.php";
require_once "../Clases/Producto.php";
require_once "../Clases/Factura.php";

session_start();
if(!isset($_SESSION['email']) && !isset($_SESSION['ID'])){
    header("location: ../Login/login.php");
}

if (isset($_COOKIE['Detalle'])) {
	Producto::RestoreStock($_COOKIE['Detalle']);
	setcookie("Detalle", "", -1);
}


$contarC = Cliente::countClients();
$contarP = Producto::contarProductos();
$uVentas = Factura::ultimasVentas();
?>
<!-- Code End -->

<!DOCTYPE html>
<html lang="en">

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
		
		<!-- Edit CSS Zeht -->
		
		<style>
		    .link:hover,
            .link:active {
              /* Estilos para el enlace cuando se pasa el cursor por encima o se activa */
              /* Por ejemplo, puedes cambiar el color de fondo o el color del texto */
              background-color: rgb(241, 241, 241);
              color: black;
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
						    <a href="products.php" class="col-xxl-3 col-sm-6 col-12">
							<!-- <div class="col-xxl-3 col-sm-6 col-12"> -->
								<div class="stats-tile link">
									<div class="sale-icon shade-yellow">
										<i class="bi bi-box-seam"></i>
									</div>
									<div class="sale-details link">
										<h3 class="text-yellow"><?php echo $contarP[0]['suma']; ?></h3>
										<p>Productos</p>
									</div>
								</div>
							<!-- </div> -->
							</a>
							<a href="customers.php" class="col-xxl-3 col-sm-6 col-12">
							<!-- <div class="col-xxl-3 col-sm-6 col-12"> -->
								<div class="stats-tile link">
									<div class="sale-icon shade-blue">
										<i class="bi bi-file-person"></i>
									</div>
									<div class="sale-details link">
										<h3 class="text-blue"><?php echo $contarC[0]['suma']; ?></h3>
										<p>Clientes</p>
									</div>
								</div>
							<!-- </div> -->
							</a>
						</div>
						<!-- Row end -->

						
						<!-- Row start -->
						<div class="row">
							<div class="col-12">
								<div class="card">
									<div class="card-header">
										<div class="card-title">Ultimas Ventas</div>
									</div>
									<div class="card-body">

										<div class="table-responsive">
											<table class="table v-middle">
												<thead>
													<tr>
														<th>Codigo</th>
														<th>Cedula del Cliente</th>
														<th>Productos</th>
														<th>Total</th>
														<th>Fecha</th>
														
													</tr>
												</thead>
												<tbody>
													<?php Factura::verUltimasVentas($uVentas); ?>
												</tbody>
											</table>
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