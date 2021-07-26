<?php 
    require_once('../../../../wp-load.php');
    global $woocommerce;
    $current_user = wp_get_current_user();
    require_once('code-control/CodigoControlV7.php');
    require_once 'class.Cart.php';
    $cart = new Cart([
        'cartMaxItem'      => 0,
        'itemMaxQuantity'  => 99,
        'useCookie'        => false,
    ]);

    $string = file_get_contents("json/datos_factura.json");
    $json_a = json_decode($string, true);

    // $string1 = file_get_contents("json/dosification.json");
    // $json_a1 = json_decode($string1, true);

    $autoritation = "271401100500565";
    $date_limit = "2021-09-27";
    $key  = stripslashes("F@yN7mT4I\Hkg(#5%2XLRnkXY@z*#Ue9Kg*q4SPU3LeF9MD4%B@86BdD5%V4HB{u");

    $args11 = array(
    'meta_query' => array(
            'lw_dosification_key' => $key
    )
    );
    $num_factura = count(wc_get_orders( $args11 )) + 1;



    // get user -------------------------------
    $args = array(
        'role' => 'customer',
        'order' => 'ASC',
        'search' => $data['customer_id']
    );
    $query = new WP_User_Query($args);
    $users = (array) $query->results;
    $get_user = array();
    foreach ( $users as $user ) {
        $usermeta = get_user_meta($user->id);
        $get_user = array(
            "id" => $user->id,
            "user_nicename" => $user->user_nicename,
            "user_email" => $user->user_email,
            "user_login" => $user->user_login,
            "billing_first_name" => $usermeta['billing_first_name'][0],
            "billing_last_name" => $usermeta['billing_last_name'][0],
            "billing_phone" => $usermeta['billing_phone'][0],
            "billing_postcode" => $usermeta['billing_postcode'][0]
        );

    }
    
    //empezando la creaio. de la nueva orden-------------------
    if ($_GET["cod_customer"] && $_GET["cod_box"]) {

        // creando nuevo pedido con cliente -----------------------------
        $order = wc_create_order(array('customer_id'=>$_GET["cod_customer"] ));

        //Agregando productos al pedido--------------------------
        
        $allItems = $cart->getItems();
        foreach ($allItems as $items) {
            foreach ($items as $item) {
                $order->add_product( get_product($item['id']), $item['quantity']);
            }
        }

        //Agregando facturacion-------------------------------------
        // $order->set_address( $address, 'billing' );
        // $order->set_address( $address, 'shipping' );

        $order->calculate_totals();
        
        $order->update_status("wc-completed");
        update_post_meta($order->id, 'wc_pos_order_type', 'POS');
        update_post_meta($order->id, '_payment_method', 'pos_cash');
        update_post_meta($order->id, '_payment_method_title', 'Efectivo');
        update_post_meta($order->id, 'wc_pos_register_id', $_GET["cod_box"]);
        update_post_meta($order->id, 'wc_pos_served_by_name', $current_user->user_login);
        update_post_meta($order->id, 'wc_pos_amount_change', $_GET["cambio"] );
        update_post_meta($order->id, 'wc_pos_amount_pay', $_GET["entregado"] );
        update_post_meta($order->id, 'lw_pos_type_order', $_GET["tipo_venta"] );
        
        // solo para factura --------------------------------------------------------
        update_post_meta($order->id, 'lw_dosification_key', $key);
        update_post_meta($order->id, 'lw_dosification_autoritation', $autoritation);
        update_post_meta($order->id, 'lw_dosification_date_limit', $date_limit);
        update_post_meta($order->id, 'lw_number_factura', $num_factura);
        update_post_meta($order->id, 'lw_nit_busines', $json_a['nit']);
        update_post_meta($order->id, 'lw_nit_customer', $get_user['billing_postcode']);
        update_post_meta($order->id, 'lw_name_customer', $get_user['billing_first_name'].' '.$get_user['billing_last_name']);
            // Data for QR-------------------------
            $numero_autorizacion = $autoritation;
            $numero_factura = $num_factura;
            $nit_cliente = $get_user['billing_postcode'];
            $fecha_compra = $date_limit;
            $monto_compra = $order->get_total();
            $clave = $key;
            $code_control = CodigoControlV7::generar($numero_autorizacion, $numero_factura, $nit_cliente, $fecha_compra, $monto_compra, $clave);
            update_post_meta($order->id, 'lw_codigo_control', $code_control);
            
            $newcodeqr = $json_a['nit'].'|'.$num_factura.'|'.$autoritation.'|'.$order->get_total().'|'.$date_limit.'|'.$code_control.'|'.$get_user['billing_postcode'];
            update_post_meta($order->id, 'lw_codigo_qr', $newcodeqr);
        $cart->clear();

        echo json_encode(array('cod_order' => $order->id, 'text_qr' => $newcodeqr));
    } else {
        # code...
    }
    
?>