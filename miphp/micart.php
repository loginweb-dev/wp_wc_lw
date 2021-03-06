<?php 

    require_once('../../../../wp-load.php');

    // Include core Cart library ------------------------------------------
    require_once 'class.Cart.php';
    $cart = new Cart([
        'cartMaxItem'      => 0,
        'itemMaxQuantity'  => 99,
        'useCookie'        => false,
    ]);

    require 'NumeroALetras.php';
    use Luecano\NumeroALetras\NumeroALetras;
    $formatter = new NumeroALetras();
    //--------------------------------------------------
    if ($_GET["add"]) {
        $item = wc_get_product( $_GET["add"] );
        $cart->add($_GET["add"], $_GET["stock"], [
            "name" => $item->name,
            "description" => $item->description, 
            "price" => $item->price,  
            "sku" => $item->sku, 
            "image" => get_the_post_thumbnail_url($item->id)
        ]);
        echo json_encode(array("message" => "Producto Agredado Correctamente."));
    } elseif ($_GET["clear"]){
        $cart->clear();
        echo json_encode(array("message" => "Carrito Vacio."));
    } elseif ($_GET["remove"]){
        $theItem = $cart->getItem($_GET["remove"]);
        $cart->remove($theItem['id'], [
            "name" => $theItem['attributes']['name'],
            "description" => $theItem['attributes']['description'], 
            "price" => $theItem['attributes']['price'], 
            "sku" => $theItem['attributes']['sku'], 
            "image" => $theItem['attributes']['image']
          ]);
          echo json_encode(array("message" => "Producto Eliminado.."));
    } elseif ($_GET["update_sum"]){
        $theItem = $cart->getItem($_GET["update_sum"]);
        $cart->update($theItem['id'], $theItem['quantity'] + 1, [
            "name" => $theItem['attributes']['name'],
            "description" => $theItem['attributes']['description'], 
            "price" => $theItem['attributes']['price'], 
            "sku" => $theItem['attributes']['sku'], 
            "image" => $theItem['attributes']['image']
        ]);
        echo json_encode(array("message" => "Producto Actualizado Correctamente."));
    }
    elseif ($_GET["update_rest"]){
        $theItem = $cart->getItem($_GET["update_rest"]);
        $cart->update($theItem['id'], $theItem['quantity'] - 1, [
            "name" => $theItem['attributes']['name'],
            "description" => $theItem['attributes']['description'], 
            "price" => $theItem['attributes']['price'], 
            "sku" => $theItem['attributes']['sku'], 
            "image" => $theItem['attributes']['image']
        ]);
        echo json_encode(array("message" => "Cantidad Reducida.."));
    }elseif ($_GET["get_totals"]){
        $json = array(
            "total_numeral" => $cart->getAttributeTotal('price'),
            "total_literal" => $formatter->toInvoice($cart->getAttributeTotal('price'), 2, 'BOB'), 
            "cant_items" => $cart->getTotalQuantity(),
        );
        echo json_encode($json);
    } else{
        $allItems = $cart->getItems();
        $json = array();
        foreach ($allItems as $items) {
            foreach ($items as $item) {
                array_push($json, array(
                    "id" => $item['id'],
                    "quantity" => $item['quantity'], 
                    "name" => $item['attributes']['name'],
                    "description" => $item['attributes']['description'], 
                    "price" => $item['attributes']['price'], 
                    "sku" => $item['attributes']['sku'], 
                    "image" => $item['attributes']['image']
                ));
            }
        }
        echo json_encode($json);
    }
?>