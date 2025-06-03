<?php
session_start();
if (!isset($_SESSION['email']) && !isset($_SESSION['ID'])) {
	header("location: ../Login/login.php");
}

require_once "../Clases/Factura.php";
require_once "../Clases/Detalle.php";
require_once "../Clases/Producto.php";
require_once "../Clases/Inputs.php";

$errors = array();

if (empty($_COOKIE['cedula'])) {
	$msg = "Cedula No Ingresada";
	$url = urlencode($msg);
	header("Location: checkout.php?err=" . $url);
}

// echo $_COOKIE['Detalle'];

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['code']) && isset($_POST['cantidad'])) {
	$product = Producto::searchProduct($_POST['code']);

	if ($product) {
		$cantidad = intval($_POST['cantidad']);
		$stock = intval(valArray($product, "Cantidad"));

		if (($cantidad <= $stock) && !($stock == 0)) {
			$subtotal = valArray($product, "Precio") * $cantidad;
			$newDetail = new Detalle(null, valArray($product, "Codigo"), valArray($product, "Descripcion"), $cantidad, $subtotal);
			$newitem = $newDetail->addDetail();
			Producto::updateStock($newDetail->getCodigoProducto(),($cantidad * (-1)));
			$fecha = time() + (7200 * 24);
			if (empty($_COOKIE['Detalle'])) {
				
				setcookie("Detalle", $newitem, $fecha);
				setcookie("subtotal", $subtotal, $fecha);
				header("Location: Checkout_step2.php");
				// header("Refresh: ".(0.00001));
			} elseif (isset($_COOKIE['Detalle'])) {
				$detalle = $_COOKIE['Detalle'] . $newitem;
				setcookie("Detalle", "", -1);
				setcookie("Detalle", $detalle, $fecha);
				$sub = floatval($_COOKIE['subtotal']) + $subtotal;
				setcookie("subtotal", "", -1);
				setcookie("subtotal", $sub, $fecha);
				
				header("Location: Checkout_step2.php");
			}

			// $newDetail->addDetail();
			// $cant = abs(intval($newDetail->getCantidad() - valArray($product, "Cantidad")));
			// Producto::updateStock($newDetail->getCodigoProducto(), $cant);
			// header("Location: checkout_End.php");
		} else {
			$code_input = $_POST['code'];
			$errors[] = "<em>Stock: " . $stock . "</em> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;La cantidad del producto excede el stock.";
		}
	} else {
		$errors[] = "El Producto no existe";
	}
}


if (isset($_COOKIE['Detalle'])) {
	$listDetails = $_COOKIE['Detalle'];
}

if (!empty($_POST['deleteFactura'])) {
	if ($_POST['deleteFactura'] == true or $_POST['deleteFactura'] == 'true') {
		setcookie("cedula", "", -1);
		Producto::RestoreStock($_COOKIE['Detalle']);
		setcookie("Detalle", "", -1);
		setcookie("subtotal", "", -1);
		header("Location: checkout.php");
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
	<!-- <div id="loading-wrapper">
			<div class="spinner">
				<div class="line1"></div>
				<div class="line2"></div>
				<div class="line3"></div>
				<div class="line4"></div>
				<div class="line5"></div>
				<div class="line6"></div>
			</div>
		</div> -->
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
				<?php
				// if (isset($messages)) {
				//     blueMsg($messages);
				// }
				if (isset($errors)) {
					greyMsg($errors);
				}
				?>

				<!-- Content wrapper start -->
				<div class="content-wrapper">

					<!-- Row Start -->
					<div class="row">
						<div class="col-sm-12 col-12">
							<div class="card">
								<div class="card-header">
									<div class="card-title">Facturar</div>
									<div class="cardtitle"><?php echo "V-".$_COOKIE['cedula']; ?></div>
								</div>
								<div class="card-body">

									<div class="row">
										<div class="col-sm-4 col-12">
											<div class="card-border">
												<div class="card-border-title">Producto</div>
												<div class="card-border-body">

													<div class="row">
														<div class="col-sm-10 col-12">
															<div class="mb-3">
																<form action="" method="post">
																	<div class="input-group">
																		<label class="form-label">Codigo de Producto
																			<span class="text-red"> *</span></label>
																		<input type="text" class="form-control" placeholder="CN012" name="code" value="<?php if (isset($code_input)) {
																																							echo $code_input;
																																						} ?>" required>
																	</div>
															</div>
														</div>
													</div>
													<div class="row">
														<div class="col-sm-10 col-12">
															<div class=" mb-3">
																<label class="form-label">Stock <span class="text-red">*</span></label>
																<input type="number" class="form-control" placeholder="Cantidad" name="cantidad" min="1" max="200" required>
															</div>
														</div>
													</div>
													<button class="btn btn-success">Añadir</button></form>
												</div>
											</div>
										</div>
										<div class="col-sm-8 col-12">
											<div class="card-border">
												<div class="card-border-body">

													<div class="row">
														<div class="card-body">

															<div class="table-responsive">
																<table class="table v-middle">
																	<thead>
																		<tr>
																			<th class="col">Codigo</th>
																			<th class="col">Descripción</th>
																			<th class="col">Cantidad</th>
																			<th class="col">Precio</th>
																		</tr>
																	</thead>
																	<tbody>
																		<?php
																		if (!empty($listDetails)) {
																			Detalle::viewCookieDetails($listDetails);
																			$btns = true;
																		} else {
																			$btns = false;
																		}
																		?>
																	</tbody>
																	<tfoot>

																		<?php
																		if ($btns) { ?>
																			<tr>
																				<td></td>
																				<td></td>
																				<td><u>Subtotal:</u></td>

																				<?php $sub = ($_COOKIE['subtotal']);
																				echo '<td>' . $sub . '$</td>'; ?>

																			</tr>
																			<tr>
																				<td></td>
																				<td></td>
																				<td><u>IVA:</u></td>

																				<?php $iva = Factura::viewIVA($sub);
																				echo '<td>' . $iva . '$</td>'; ?>

																			</tr>
																			<tr>
																				<td></td>
																				<td></td>
																				<td><u>Total:</u></td>

																				<?php $total = Factura::viewTotal($sub);
																				echo '<td>' . $total . '$</td>'; ?>

																			</tr>
																		<?php } ?>


																	</tfoot>
																</table>

																<?php

																?>
																<form action="" method="post">
																	<div class="custom-btn-group flex-end">
																		<button class="btn btn-light" name="deleteFactura" value="true">Cancelar</button></form>
																		<form action="newFactura.php" method="post">
																		<?php
																		if ($btns) { ?>
																			<input type="text" hidden name="total" value="<?php echo $total ?>">
																			<button class="btn btn-success" name="facturar" value="true">Facturar</button>
																		<?php }
																		?>
																	</div>
																</form>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>

										<!-- <div class="col-sm-12 col-12">
											<div class="custom-btn-group flex-end">
												<button type="button" class="btn btn-light">Cancelar</button>
												<a href="products.html" class="btn btn-success">Siguiente</a>
											</div>
										</div> -->
									</div>

								</div>
							</div>
						</div>
					</div>
					<!-- Row End -->

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