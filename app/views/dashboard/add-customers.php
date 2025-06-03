<?php
session_start();
if(!isset($_SESSION['email']) && !isset($_SESSION['ID'])){
    header("location: ../Login/login.php");
}

require_once "../Clases/Cliente.php";
require_once "../Clases/Inputs.php";
require_once "../Clases/Producto.php";

if (isset($_COOKIE['Detalle'])) {
	Producto::RestoreStock($_COOKIE['Detalle']);
	setcookie("Detalle", "", -1);
}

$errors = array();
$messages = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	if (!empty($_POST['name']) && !empty($_POST['tel-operador']) && !empty($_POST['tel'])) {
		
		$dir = (empty($_POST['dir'])) ? "Desconocida" : $_POST['dir'] ;
		$tel = $_POST['tel-operador'].'-'.$_POST['tel'];

		$newClient = new Cliente($_POST['ci'], $_POST['name'],$tel , $dir);
		
		if (!(Cliente::searchClient($newClient->getCI()))) {
			
			if ($newClient->register()) {
				$messages[] = "Cliente Registrado Exitosamente";
			}
		}else {
			$errors[] = "El Cliente Existe. Cedula no Disponible";
		}

	}else{
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
				<?php require_once "userOptions.php";?>
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
									<div class="card-title">Registrar Cliente</div>
								</div>
								<div class="card-body">
								<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
									<div class="row">
										<div class="col-sm-12 col-12">
											<div class="card-border">
												<div class="card-border-title">Datos Personales</div>
												<div class="card-border-body">

													<div class="row">
														<div class="col-sm-6 col-12">
															<div class="mb-3">
																<label class="form-label">Nombre Apellido <span class="text-red">*</span></label>
																<input type="text" class="form-control" placeholder="Nombre Apellido" name="name" required>
															</div>
														</div>
														<div class="col-sm-6 col-12">
															<div class="mb-3">
																<label class="form-label">Telefono<span class="text-red">*</span></label>
																<div class="input-group">
																	<select class="form-select telefono-selector" name="tel-operador" required>
																		<option value="0412">0412</option>
																		<option value="0414">0414</option>
																		<option value="0424">0424</option>
																		<option value="0416">0416</option>
																		</ul>
																		<input type="text" class="form-control" aria-label="Text input with dropdown button" name="tel" pattern="^[0-9]{7}$" title="Por favor, ingresa solo 7 números" required>
																</div>
															</div>
														</div>
														<div class="col-sm-6 col-12">
															<div class="mb-3">
																<label class="form-label">Cedula <span class="text-red">*</span></label>
																<div class="input-group">
																	<span class="input-group-text">V-</span>
																	<input type="text" class="form-control ci" name="ci" pattern="^[0-9]{7,8}$" title="Por favor, ingresa solo 7 u 8 números" required>
																</div>
															</div>
														</div>
														<div class="col-sm-6 col-12">
															<div class=" mb-3">
																<label class="form-label">Dirección</label>
																<input type="text" class="form-control" placeholder="Urb. xxx calle xx" name="dir">
															</div>
														</div>

													</div>

												</div>
											</div>
										</div>

										<div class="col-sm-12 col-12">
											<div class="custom-btn-group flex-end">
												<a href="customers.php" class="btn btn-light">Cancelar</a>
												<button class="btn btn-success">Añadir Cliente</button>
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

	<!-- +++++++++++++++++++++++++++++++++++++++++ -->

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