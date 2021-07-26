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
// echo 'Hola mundo';
    if ($_GET["add"]) {
        $args = array(
            'post_type'      => 'product',
            'post_status'         => 'publish',
            // 'posts_per_page' => 1,
            'p' => $_GET["add"],
        );
        $json = array();
        $loop = new WP_Query( $args );
        while ( $loop->have_posts() ) : $loop->the_post(); global $product;
            // echo $product;
            $cart->add($product->id, $_GET["stock"], [
                "link" => get_permalink(), 
                "name" => $product->name,
                "description" => $product->description, 
                "price" => $product->price,  
                "sku" => $product->sku, 
                "image" => get_the_post_thumbnail_url($loop->post->ID)
            ]);
        endwhile; 
        wp_reset_query();
    } elseif ($_GET["clear"]){
        $cart->clear();
    } elseif ($_GET["remove"]){
        $theItem = $cart->getItem($_GET["remove"]);
        $cart->remove($theItem['id'], [
            "link" => $theItem['attributes']['link'], 
            "name" => $theItem['attributes']['name'],
            "description" => $theItem['attributes']['description'], 
            "price" => $theItem['attributes']['price'], 
            "sku" => $theItem['attributes']['sku'], 
            "image" => $theItem['attributes']['image']
          ]);
    } elseif ($_GET["update_sum"]){
        $theItem = $cart->getItem($_GET["update_sum"]);
        $cart->update($theItem['id'], $theItem['quantity'] + 1, [
            "link" => $theItem['attributes']['link'], 
            "name" => $theItem['attributes']['name'],
            "description" => $theItem['attributes']['description'], 
            "price" => $theItem['attributes']['price'], 
            "sku" => $theItem['attributes']['sku'], 
            "image" => $theItem['attributes']['image']
        ]);
    }
    elseif ($_GET["update_rest"]){
        $theItem = $cart->getItem($_GET["update_rest"]);
        $cart->update($theItem['id'], $theItem['quantity'] - 1, [
            "link" => $theItem['attributes']['link'], 
            "name" => $theItem['attributes']['name'],
            "description" => $theItem['attributes']['description'], 
            "price" => $theItem['attributes']['price'], 
            "sku" => $theItem['attributes']['sku'], 
            "image" => $theItem['attributes']['image']
        ]);
    }elseif ($_GET["get_totals"]){
        $json = array(
            "total_numeral" => $cart->getAttributeTotal('price'),
            "total_literal" => $formatter->toInvoice($cart->getAttributeTotal('price'), 2, 'BOB'), 
            "cant_items" => $cart->getTotalQuantity(),
        );
        echo json_encode($json);
    } else{
        // echo 'id';
        // echo $cart->getTotalQuantity();
        $allItems = $cart->getItems();
        $json = array();
        foreach ($allItems as $items) {
            foreach ($items as $item) {
                // echo 'mierda';
                array_push($json, array(
                    "id" => $item['id'],
                    "quantity" => $item['quantity'], 
                    "link" => $item['attributes']['link'], 
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
    // $cart->clear();
?>