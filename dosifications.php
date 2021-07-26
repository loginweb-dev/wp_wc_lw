<?php 
	
	require_once('../../../wp-load.php');
	$current_user = wp_get_current_user();
	if (!isset($current_user->display_name)) {
		header('Location: ' . '/', true);
   		die();
	}
    
?>
<!DOCTYPE HTML>
<html lang="es">
<head>
<meta charset="utf-8">
<meta http-equiv="pragma" content="no-cache" />
<meta http-equiv="cache-control" content="max-age=604800" />
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

<title>POS</title>

<link href="images/favicon.ico" rel="shortcut icon" type="image/x-icon">

<!-- jQuery -->
<script src="js/jquery-2.0.0.min.js" type="text/javascript"></script>

<!-- Bootstrap4 files-->
<script src="js/bootstrap.bundle.min.js" type="text/javascript"></script>
<link href="css/bootstrap.css" rel="stylesheet" type="text/css"/>

<!-- Font awesome 5 -->
<link href="fonts/fontawesome/css/all.min.css" type="text/css" rel="stylesheet">

<!-- custom style -->
<link href="css/ui.css" rel="stylesheet" type="text/css"/>
<link href="css/responsive.css" rel="stylesheet" media="only screen and (max-width: 1200px)" />


	<style>
    </style>
</head>
<body style="background-color: #F6F7F9;">
<header class="section-header" style="background-color: #FFFFFF;">
	<section class="header-main border-bottom">
		<div class="container-fluid">
			<div class="row align-items-center">
				<div class="col-lg-8 col-sm-12">
					<div class="form-group">
						<input type="text" class="form-control" placeholder="Buscar Productos" id="criterio_id">
					</div>
		
				</div> 
				<div class="col-lg-4 col-sm-6 col-12">
					<div class="widgets-wrap float-md-right">

						<div class="widget-header icontext">
							<a href="#" class="icon icon-sm rounded-circle border"><i class="fa fa-address-book"></i></a>
							<div class="text">
								<span class="text-muted"><div id="box_defualt" ></div></span>
								<input class="form-control" type="text" id="cod_box" hidden>
									<a href="#">Todas la Cajas</a>
								</div>
							</div>
						</div>
						<div class="widget-header icontext">
							<a href="#" class="icon icon-sm rounded-circle border"><i class="fa fa-user"></i></a>
							<div class="text">
								<span class="text-muted">Hola <?php echo $current_user->display_name ?>!</span>
								<div> 
									<a href="/"> Volver al Panel</a>
								</div>
							</div>
						</div>

					</div>
				</div>
			</div>
		</div>
	</section>
</header>

<div id="milistsearch"></div>

<!-- ========================= SECTION CONTENT ========================= -->
<section class="section-content padding-y">
<div class="container-fluid">

<div class="row">
	<main class="col-md-8">
		<div class="card">
			<div id="mitabla"></div>
		</div>
	</main>
	<aside class="col-md-4 mt-1">
		<div class="card mb-3">
			<div class="card-body">
			<form>
				<div class="form-group">
					<label>Cliente</label>
						<input id="customer_search" type="text" class="form-control" placeholder="Buscar cliente">
						<input class="form-control" type="text" id="id_customer" hidden>
						<div id="list_search_customers"></div>
				</div>
			</form>
			</div>
		</div>
		<div class="card">
			<div class="card-body">
					<dl class="dlist-align">
					  <dt>Total:</dt>
					  <dd class="text-right  h5"><div id="total_numeral"></div></dd>
					</dl>
					<div id="total_literal"></div>
					<hr>
					<dl class="dlist-align">
					  <dt>Cantidad:</dt> 
					  <dd class="text-right  h5"><div id="cant_items"></div></dd>
					</dl>
					<hr>
					<p class="text-center mb-3">
                        <button class="btn btn-light" data-toggle="modal" data-target="#exampleModal"> <i class="fa fa-money-bill-alt"></i> Pago en Efectivo</button>
					</p>
					<p class="text-center mb-3">
                        <button class="btn btn-light" data-toggle="modal" data-target="#"> <i class="fa fa-qrcode"></i> Pago con QR</button>
					</p>

			</div> 
		</div>
	</aside> 

</div> 
</section>
<!-- ========================= SECTION CONTENT END// ========================= -->


<!-- ========================= FOOTER ========================= -->
<footer class="section-footer border-top padding-y">

</footer>
<!-- ========================= FOOTER END // ========================= -->

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Detalle de la Venta</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
		<div class="form-group text-center">
			<p><u>Tipo de Venta</u></p>
			<label class="custom-control custom-radio custom-control-inline">
				<input class="custom-control-input" checked="" type="radio" id="no_estado" name="estado" value="option1">
				<span class="custom-control-label"> Recibo </span>
			</label>
			<label class="custom-control custom-radio custom-control-inline">
				<input class="custom-control-input" type="radio" id="estado" name="estado" value="option2">
				<span class="custom-control-label"> Factura </span>
			</label>
		</div>
		
		<div class="form-group text-center">
			<p><u>Opciones de Impresion</u></p>
			<label class="custom-control custom-radio custom-control-inline">
				<input class="custom-control-input" checked="" type="radio" id="volver" name="volver" value="option3">
				<span class="custom-control-label"> Volver </span>
			</label>
			<label class="custom-control custom-radio custom-control-inline">
				<input class="custom-control-input" type="radio" id="imprimir" name="volver" value="option4">
				<span class="custom-control-label"> Imprimir </span>
			</label>
		</div>
		<div class="col form-group text-center">
			<label><u>Efectivo Entregado</u></label>
			<input id="entregado" type="text" class="form-control" placeholder="" value="0" autofocus>
		</div> 
		<div class="col form-group text-center">
			<label><u>Cambio en Efectivo</u></label>
			<input id="cambio" type="text" class="form-control" placeholder="" value="0" readonly>
		</div> 
      </div>
      <div class="modal-footer">
        <button id="new_shop_order" type="button" class="btn btn-primary"><i class="fa fa-save"> </i> Finalizar </button>
      </div>
    </div>
  </div>
</div>

<!-- custom javascript -->
<script src="js/script.js" type="text/javascript"></script>
<script src="js/notify.js" type="text/javascript"></script>