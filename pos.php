
<?php 
	
	require_once('../../../wp-load.php');
	$current_user = wp_get_current_user();
	if (!isset($current_user->display_name)) {
		header('Location: ' . '/', true);
   		die();
	}
	require_once 'miphp/class.Cart.php';
	$cart = new Cart([
		'cartMaxItem'      => 0,
		'itemMaxQuantity'  => 99,
		'useCookie'        => false,
	]);
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
					<p class="text-center mb-3">
                        <button class="btn btn-light" data-toggle="modal" data-target="#"> <i class="fa fa-registered"></i> Pago con Tigo Money</button>
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
<script type="text/javascript">

function update_sum(product_id){
	$('#mitabla').html("<center><img class='img-sm' src='https://melo.loginweb.dev/wp-content/uploads/2021/07/reload.gif'></center>");	
		$.ajax({
			url: "https://melo.loginweb.dev/wp-content/plugins/loginweb/miphp/micart.php?update_sum="+product_id,
			success: function (response) {
				$.notify("Carrrito Actualizado Correctamente..");
				build_cart();
			}
		});
	}
	function update_rest(product_id){
		$('#mitabla').html("<center><img class='img-sm' src='https://melo.loginweb.dev/wp-content/uploads/2021/07/reload.gif'></center>");	
		$.ajax({
			url: "https://melo.loginweb.dev/wp-content/plugins/loginweb/miphp/micart.php?update_rest="+product_id,
			success: function (response) {
				$.notify("Carrrito Actualizado Correctamente..");
				build_cart();
			}
		});
	}

	function product_add (product_id){$('#milistsearch').html("");
		var stock = prompt("Cantidad a Ingresar", 1);
		if (stock) {
			$.ajax({
				url: "https://melo.loginweb.dev/wp-content/plugins/loginweb/miphp/micart.php?add="+product_id+"&stock="+stock,
				success: function (response) {
					$.notify("Producto Correctamente..");
					build_cart();
				}
			});
		}
	}

	function remove(product_id){
		$.ajax({
			url: "https://melo.loginweb.dev/wp-content/plugins/loginweb/miphp/micart.php?remove="+product_id,
			success: function (response) {
				$.notify("Item Eliminado Correctamente..");
				build_cart();
			}
		});
	}


	function clear_search_products(){
		$('#milistsearch').html("<img src='https://melo.loginweb.dev/wp-content/uploads/2021/07/reload.gif'>");	
		$('#milistsearch').html("");
		$("#criterio_id").focus();
	}

	// building cart list --------------------------------------
	function build_cart(){
		$('#mitabla').html("<center><img class='img-sm' src='https://melo.loginweb.dev/wp-content/uploads/2021/07/reload.gif'></center>");	
		get_totals();

		$.ajax({
			url: "https://melo.loginweb.dev/wp-content/plugins/loginweb/miphp/micart.php",
			dataType: "json",
			success: function (response) {
				if (response.length == 0) {
					$('#mitabla').html("<center><h2>Carrito Vacio</h2><img class='img-lg' src='https://melo.loginweb.dev/wp-content/uploads/2021/07/car.png'></center>");						
				} else {
					let table = "";
					table += "<table class='table'><thead class='text-muted'><tr class='small text-uppercase'><th scope='col'>Productos</th><th scope='col' class='text-center'>Cantidad</th><th scope='col' class='text-center'>Sub Total</th></tr></thead>";
					for(var i=0; i< response.length; i++){
						table += "<tr><td><figure class='itemside'><div class='aside'><img src="+response[i].image+
							" class='img-sm'></div><figcaption class='info'><h6>"+response[i].name+
							"</h6><p class='text-muted small'>  Precio Venta: "+response[i].price+
							"<br> ID: "+response[i].id+"<br> SKU: "+response[i].sku+"</p></figcaption></figure></td>"+
							"<td class='text-center'><div class='btn-group' role='group'><button onclick='update_rest("+response[i].id+")' type='button' class='btn btn-sm btn-light'>-</button><h5> "+response[i].quantity+" </h5><button onclick='update_sum("+response[i].id+")' type='button' class='btn btn-sm btn-light'>+</button></div></td>"+
							"<td class='text-center'><div class='price-wrap'><var class='price h5'>"+response[i].price * response[i].quantity+"</var></div><div class='btn-group' role='group'><button onclick='remove("+response[i].id+")' type='button' class='btn btn-sm btn-warning'><i class='fa fa-trash'></button></div></td></tr>";
					}	
					table += "</tbody></table>";
					table += "<div class='card-body border-top'><button onclick='cart_clear()' class='btn btn-light'>Limpiar Carrito </button></div>";
					
					$('#mitabla').html(table);
				}
			}
		});
		$("#criterio_id").focus();
	}

	function get_totals(){
		$.ajax({
			url: "https://melo.loginweb.dev/wp-content/plugins/loginweb/miphp/micart.php?get_totals=true",
			dataType: "json",
			success: function (response) {
				$('#total_numeral').html("<strong>"+response.total_numeral+"</strong>");
				$('#total_literal').html("<samll>"+response.total_literal+"</samll>");
				$('#cant_items').html("<strong>"+response.cant_items+"</strong>");
			}
		});
				
	}
	function cart_clear(){
		
		$.ajax({
			url: "https://melo.loginweb.dev/wp-content/plugins/loginweb/miphp/micart.php?clear=true",
			success: function (response) {
				$.notify("Carrrito Limpiado Correctamente..");
				build_cart();
			}
		});
	}
	
	function customer_add (customer_id){
		$('#list_search_customers').html("<center><img class='img-sm' src='https://melo.loginweb.dev/wp-content/uploads/2021/07/reload.gif'></center>");	
			$.ajax({
				url: "https://melo.loginweb.dev/wp-content/plugins/loginweb/miphp/search.php?get_customer_id="+customer_id,
				dataType: "json",
				success: function (response) {
					$.notify("Cliente Establecido..");
					let  customer = "<ul class='list-group list-group-flush'>";
						customer += "<li class='list-group-item'><span>Cliente: </span><small>"+response[0].billing_first_name+"  "+response[0].billing_last_name+"</small></li>";
						customer += "<li class='list-group-item'><span>NIT O Carnet: </span><small>"+response[0].billing_postcode+"</small></li>";
						customer += "<li class='list-group-item'><span>Correo: </span><small>"+response[0].user_email+"</small></li>";
						customer += "<li class='list-group-item'><span>Telefono: </span><small>"+response[0].billing_phone+"</small></li>";
						customer += "</ul>";
					$('#list_search_customers').html(customer);	
					$("#id_customer").val(response[0].id);
				}
			});
	}

	function build_costumer(){
		//Get Customer Default
		$('#list_search_customers').html("<center><img class='img-sm' src='https://melo.loginweb.dev/wp-content/uploads/2021/07/reload.gif'></center>");	
		$.ajax({
			url: "https://melo.loginweb.dev/wp-content/plugins/loginweb/miphp/search.php?get_customers=cliente.generico@gmail.com",
			dataType: "json",
			success: function (response) {
				let  customer = "<ul class='list-group list-group-flush'>";
					customer += "<li class='list-group-item'><span>Cliente: </span><small>"+response[0].billing_first_name+"  "+response[0].billing_last_name+"</small></li>";
					customer += "<li class='list-group-item'><span>NIT O Carnet: </span><small>"+response[0].billing_postcode+"</small></li>";
					customer += "<li class='list-group-item'><span>Correo: </span><small>"+response[0].user_email+"</small></li>";
					customer += "<li class='list-group-item'><span>Telefono: </span><small>"+response[0].billing_phone+"</small></li>";
					customer += "</ul>";
				$('#list_search_customers').html(customer);	
				$("#id_customer").val(response[0].id);
			}
		});
	}

$(document).ready(function() {
	$("#criterio_id").focus();
	$.ajax({
		url: "https://melo.loginweb.dev/wp-content/plugins/loginweb/miphp/boxs.php",
		dataType: "json",
		success: function (response) {
			
			$("#box_defualt").html(response[0].title);
			$("#cod_box").val(response[0].id);
		}
	});
	build_cart();
	build_costumer();


	


	// Create new Shop Order-------------------------------
	$("#new_shop_order").click(function (e) { 
		e.preventDefault();
		
			$('#exampleModal').modal('toggle');
			$.notify("Iniciando Proceso..");
			let id_customer = $("#id_customer").val();
			let cod_box = $("#cod_box").val();

			let entregado = $("#entregado").val();
			let cambio = $("#cambio").val();

			let tipo_venta = $("#no_estado").is(":checked") ? "recibo" : "factura";
			let opciones_print = $("#volver").is(":checked") ? false : true;
			$.ajax({
				url: "https://melo.loginweb.dev/wp-content/plugins/loginweb/miphp/orders.php?cod_customer="+id_customer+"&cod_box="+cod_box+"&entregado="+entregado+"&cambio="+cambio+"&tipo_venta="+tipo_venta,
				dataType: "json",
				success: function (response) {
					$.notify("Creando QR..");
					$.ajax({
						url: "https://melo.loginweb.dev/wp-content/plugins/loginweb/miphp/barcode.php?cod_order="+response.cod_order+"&text_qr="+response.text_qr,
						dataType: "json",
						success: function (response) {
							$.notify("Venta Generada Correctamente..");
						}
					});
					$.notify("Abriendo PDF..");
					build_cart();
					build_costumer();
					window.open('https://melo.loginweb.dev/wp-content/plugins/loginweb/miphp/print_factura.php?cod_order='+response.cod_order, '_blank', 'location=yes,height=600,width=400,scrollbars=yes,status=yes');
				}
			});

	});

	// searchs products --------------------------------------------------------------
	$("#criterio_id").on('keyup', function (e) {
		if (e.key === 'Enter' || e.keyCode === 13) {
			$('#milistsearch').html("<center><img class='img-sm' src='https://melo.loginweb.dev/wp-content/uploads/2021/07/reload.gif'></center>");	
			let criterio = $("#criterio_id").val();
			$.ajax({
				url: "https://melo.loginweb.dev/wp-content/plugins/loginweb/miphp/search.php?get_products="+criterio,
				dataType: "json",
				success: function (response) {
					if (response.length == 0) {
						$('#milistsearch').html("<p>Sin Resultados  <a href='https://melo.loginweb.dev/wp-admin/post-new.php?post_type=product' target='_blank' class='btn btn-sm btn-primary'>Crear Nuevo</a></p>");	
					} else {
						
						let table = "";
						table += "<table class='table'><tbody>";
						for(var i=0; i< response.length; i++){
							table += "<tr><td><figure class='itemside'><div class='aside'><img src="+response[i].image+
								" class='img-sm'></div><figcaption class='info'><h6>"+response[i].name+
								"</h6><p class='text-muted small'>  Precio Venta: "+response[i].regular_price+
								"<br> ID: "+response[i].id+"<br> SKU: "+response[i].sku+"</p></figcaption></figure></td>"+
								"<td><strong>Detalles</strong><br><small>Precio Compra: "+response[i].bought_price+"<br> Estante: "+response[i].lg_estante+"<br> Bloque: "+response[i].lg_bloque+"<br> Vence: "+response[i].lg_date+"</small></td>"+
								"<td><button onclick='product_add("+response[i].id+")' type='button' class='btn btn-sm btn-primary'><i class='fa fa-shopping-cart'></i></button></td></tr>";
						}	
						table += "</tbody></table>";
						table += "<p> "+response.length+" resultados para: '"+$("#criterio_id").val()+"' <a href='#' onclick='clear_search_products()' class='btn btn-sm btn-light' id='clear_search_products'>Borrar</a></p>";
						$('#milistsearch').html(table);	

					}		
				}
			});
		}
	});
	
	// searchs customer --------------------------------------------------------------
	$("#customer_search").on('keyup', function (e) {
		if (e.key === 'Enter' || e.keyCode === 13) {
			$('#list_search_customers').html("<center><img class='img-sm' src='https://melo.loginweb.dev/wp-content/uploads/2021/07/reload.gif'></center>");	
			let criterio = $("#customer_search").val();
			$.ajax({
				url: "https://melo.loginweb.dev/wp-content/plugins/loginweb/miphp/search.php?get_customers="+criterio,
				dataType: "json",
				success: function (response) {
					if (response.length == 0) {
						$('#list_search_customers').html("<p>Sin Resultados  <a href='https://melo.loginweb.dev/wp-admin/admin.php?page=wccm-add-new-customer' target='_blank' class='btn btn-sm btn-primary'>Crear Nuevo</a></p>");	
					} else {
						let table = "";
						table += "<table class='table' style='overflow:auto; border-collapse: collapse; table-layout:fixed;'><tbody>";
						for(var i=0; i< response.length; i++){
							table += "<tr><td><small>"+response[i].billing_postcode+"</small></td><td><small>"+response[i].billing_first_name+"</small></td><td><small>"+response[i].billing_last_name+"</small></td><td><button onclick='customer_add("+response[i].id+")' type='button' class='btn btn-sm btn-primary'><i class='fa fa-save'></i></button></td></tr>";
						}	
						table += "</tbody></table>";
						table += "<p>"+response.length+" Resultados </p>";
						$('#list_search_customers').html(table);	
					}		
				}
			});
		}
	});

// Venta Detalle  --------------------------------------------------------------
$("#entregado").on('keyup', function (e) {
		if (e.key === 'Enter' || e.keyCode === 13) {
		
			let entregado = $("#entregado").val();
			$('#cambio').val("trabajando...");
			$.ajax({
				url: "https://melo.loginweb.dev/wp-content/plugins/loginweb/miphp/micart.php?get_totals=true",
				dataType: "json",
				success: function (response) {
					let newcambio = entregado - response.total_numeral;
					$('#cambio').val(newcambio);	
				}
			});
		}
	});



	$("#criterio_id").change(function (e) { 
		e.preventDefault();
		
		if ($("#criterio_id").empty()) {
			$('#milistsearch').html("");
		}
	});
	
}); 
</script>
</body>
</html>

