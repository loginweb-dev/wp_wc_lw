<?php 

    require_once('../../../../wp-load.php');
    require('pdf/fpdf.php');
    $QR_BASEDIR = dirname(__FILE__).DIRECTORY_SEPARATOR;

    require 'NumeroALetras.php';
    use Luecano\NumeroALetras\NumeroALetras;
    $formatter = new NumeroALetras();

    // get data of facturas y dosification--------------------------
    $string = file_get_contents("json/datos_factura.json");
    $json_a = json_decode($string, true);

    // get order ------------------------------------
    $cod_order = $_GET["cod_order"];
    $order = wc_get_order( $cod_order );
    $items = $order->get_items();
    $data = $order->get_data();


    // creating PDF-------------------------------------------------
    $border = 0;
    $position = 2;
    $aling = 'C';
    $higth = 3;
    $size_font = 6;
    $type_font = 'Arial';

    $pdf = new FPDF('P','mm',array(40,160));
    $pdf->SetMargins(1, 8, 1);
    $pdf->SetFont($type_font, '', $size_font);
    $pdf->AddPage();
        // Encabezado------------------------------------------
        $pdf->Image('https://melo.loginweb.dev/wp-content/uploads/2021/07/logo_businness.png',13,0,15,15,'PNG');
        $pdf->Ln(6);
        $pdf->Cell(0, $higth, 'De: '.$json_a['name_business'], $border, $position, $aling);
        $pdf->Cell(0, $higth, $json_a['direction'], $border, $position, $aling);
        $pdf->Cell(0, $higth, 'Cel: '.$json_a['movil'], $border, $position, $aling);
        $pdf->Cell(0, $higth, $json_a['city'], $border, $position, $aling);
        $pdf->SetFont($type_font, '', $size_font - 2);
        $pdf->MultiCell(0, $higth, $json_a['activity'], $border, $aling);
    $pdf->Cell(0, 0, '', 1 , 1, 'C');
        // datos de factura------------------------------------------
        $pdf->SetFont($type_font, '', $size_font);
        $pdf->Cell(0, $higth, 'FACTURA', $border , $position, $aling);
        $pdf->SetFont($type_font, '', $size_font -1);
        $pdf->Cell(0, $higth, 'NIT: '.$json_a['nit'], $border , $position, $aling);
        $pdf->Cell(0, $higth, 'AUTORIZACION: '.$order->get_meta('lw_dosification_autoritation'), $border , $position, $aling);
        $pdf->Cell(0, $higth, 'FACTURA Nro: '.$order->get_meta('lw_number_factura'), $border , $position, $aling);
        $pdf->Cell(0, $higth, 'FECHA: '.$data['date_created']->date('Y-m-d H:i:s'), $border , $position, $aling);
    $pdf->Cell(0, 0, '', 1 , 1, 'C');
        //Cliente ------------------------------------------------------
        $pdf->SetFont($type_font, '', $size_font);  
        $pdf->Cell(0, $higth, 'CLIENTE', $border , $position, $aling);
        $pdf->SetFont($type_font, '', $size_font -1);
        $pdf->Cell(0, $higth, 'RAZON SOCIAL: '.$order->get_meta('lw_name_customer'), $border , $position, $aling);
        $pdf->Cell(0, $higth, 'NIT/CI: '.$order->get_meta('lw_nit_customer'), $border , $position, $aling);
        
    $pdf->Cell(0, 0, '', 1 , 1, 'C');
        //Detalle de la Venta ------------------------------------------------------
        $pdf->SetFont($type_font, '', $size_font);  
        $pdf->Cell(0, $higth, 'DETALLE DE COMPRA:', 0 , 1, 'L');
        $pdf->SetFont($type_font, '', $size_font-2);  
        $pdf->Cell(24, $higth, 'PRODUCTO', 0);
        $pdf->Cell(8, $higth, 'CANT', 0);
        $pdf->Cell(8, $higth, 'IMP', 0, 1, 'C');
        foreach ( $items as $item ) {
            $pdf->Cell(24, $higth, $item['name'], 0);
            $pdf->Cell(8, $higth, $item['quantity'], 0);
            $pdf->Cell(8, $higth, $item['subtotal'], 0, 1, 'C');
        }
    $pdf->Cell(0, 0, '', 1 , 1, 'C');
        // Total de la Venta---------------------------------------------
        $pdf->Cell(20, $higth, '', 0);
        $pdf->Cell(10, $higth, 'SUB TOTAL: ', 0);
        $pdf->Cell(10, $higth, $order->get_subtotal(), 0, 1, 'C');
        $pdf->Cell(20, $higth, '', 0);
        $pdf->Cell(10, $higth, 'DESCUENTO: ', 0);
        $pdf->Cell(10, $higth, $order->get_discount_total(), 0, 1, 'C');
        $pdf->Cell(20, $higth, '', 0);
        $pdf->Cell(10, $higth, 'TOTAL: ', 0);
        $pdf->Cell(10, $higth, $order->get_total(), 0, 1, 'C');

        $pdf->Cell(0, $higth, 'SON '.$order->get_total().' ('.$formatter->toInvoice($order->get_total(), 2, 'BOLIVIANOS').')', 0, 1, 'L');

    $pdf->Cell(0, 0, '', 1 , 1, 'C');
        // datos QR y dosificacion-------------------------------
        $pdf->Cell(25, $higth, 'FECHA LIMITE DE EMISION: ', 0);
        $pdf->Cell(15, $higth, $order->get_meta('lw_dosification_date_limit'), 0);
        $pdf->Ln();
        $pdf->Cell(25, $higth, 'CODIGO DE CONTROL: ', 0);
        $pdf->Cell(15, $higth, $order->get_meta('lw_codigo_control'), 0);
        
        $pdf->Image($QR_BASEDIR.'qrcode/temp/'.$order->id.'.jpg',11,90,20,20,'JPG');
        $pdf->Ln(26);
        $pdf->MultiCell(0, $higth, $json_a['legend'], $border, $aling);
    $pdf->Cell(0, 0, '', 1 , 1, 'C');
        $pdf->Cell(0, $higth, 'ATENDIDO POR: '.$order->get_meta('wc_pos_served_by_name'), 0, 1, 'L');
        
    $pdf->Output();
?>