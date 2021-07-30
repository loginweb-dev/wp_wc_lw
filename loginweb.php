<?php
/**
* Plugin Name: LoginWeb - Modulo TPV
* Plugin URI: https://loginweb.dev/
* Description: Plugins Diseñado y Desarrollado por Loginweb, para Gestionar la Facturacion Computarizada, Flujo de Caja, Compras.
* Version: 1.0
* Author: Ing. Percy Alvarez Cruz
* Author URI: https://loginweb.dev/
**/

add_action( 'woocommerce_product_options_stock_status', 'loginweb_product_options');
function loginweb_product_options(){
	global $post;

    echo '</div><div class="options_group">'; // New separated section
	woocommerce_wp_text_input( array(
		'id'      => 'lg_estante',
		'value'   => get_post_meta( get_the_ID(), 'lg_estante', true ),
		'label'   => 'Estante',
		'type'   => 'text'
	) );
	
	woocommerce_wp_text_input( array(
		'id'      => 'lg_bloque',
		'value'   => get_post_meta( get_the_ID(), 'lg_bloque', true ),
		'label'   => 'Bloque',
		'type'   => 'text'
	) );
	
	woocommerce_wp_text_input( array(
		'id'      => 'lg_date',
		'value'   => get_post_meta( get_the_ID(), 'lg_bloque', true ),
		'label'   => 'Fecha de Vencimiento',
		'type'   => 'date'
	) );
 
}
add_action( 'woocommerce_process_product_meta', 'loginweb_save_fields', 10, 2 );
function loginweb_save_fields( $id, $post ){
 
	update_post_meta( $id, 'lg_estante', $_POST['lg_estante'] );
	update_post_meta( $id, 'lg_bloque', $_POST['lg_bloque'] );
	update_post_meta( $id, 'lg_date', $_POST['lg_date'] );

}

function lw_create_setting() {
	$setting = array(
		'post_title'    => 'Post setting TPV',
		'post_status'   => 'publish',
		'post_type'   => 'pos_lw_setting',
		'meta_input' => array(
			'lw_image' => null,
			'lw_ceo' => null,
			'lw_direction' => null,
			'lw_movil' => null,
			'lw_city' => null,
			'lw_activity' => null,
			'lw_name_business' => null,
			'lw_nit' => null,
			'lw_legend' => null,
		)
	);
	wp_insert_post( $setting );
}
//. create table ----------------------------------------------------------------
// function to create the DB / Options / Defaults					
// function ss_options_install() {

//     global $wpdb;

//     $table_name = $wpdb->prefix . "lw_dosification";
//     $charset_collate = $wpdb->get_charset_collate();
//     $sql = "CREATE TABLE $table_name (
//             `id` MEDIUMINT NOT NULL AUTO_INCREMENT,
//             `autoritation` varchar(50) CHARACTER SET utf8 NOT NULL,
//             `date_limit` varchar(50) CHARACTER SET utf8 NOT NULL,
//             `lwkey` varchar(255) CHARACTER SET utf8 NOT NULL,
//             PRIMARY KEY (`id`)
//           ) $charset_collate; ";

//     require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
//     dbDelta($sql);
// }

// // run the install scripts upon plugin activation
register_activation_hook(__FILE__, 'lw_create_setting');


//menu items --------------------------------------------------------------------
add_action('admin_menu','lw_add_menu');
function lw_add_menu() {
	
	//MENU TPV
	add_menu_page('Punto de Venta', //page title
        'Punto de Venta', //menu title
        'shop_manager', //capabilities
        'terminal-punto-venta', //menu slug
        'lw_boxs_list', //function
        'dashicons-align-full-width'
	);
	
		// MENU CAJAS ---------------------------------------------
		add_submenu_page('terminal-punto-venta', //parent slug
			'Cajas', //page title
			'Cajas', //menu title
			'shop_manager', //capability
			'cajas', //menu slug
			'lw_boxs_list' //function
		);
		add_submenu_page('null', //parent slug
			'Nueva Caja', //page title
			'Nueva Caja', //menu title
			'shop_manager', //capability
			'boxs-create', //menu slug
			'lw_boxs_create' //function
		);
		add_submenu_page('null', //parent slug
			'Editar Caja', //page title
			'Editar Caja', //menu title
			'shop_manager', //capability
			'boxs-edit', //menu slug
			'lw_boxs_edit' //function
		);

	//MENU dosifications ---------------------------------------------------------------
	add_submenu_page('terminal-punto-venta', //parent slug
	'Dosificaciones', //page title
	'Dosificaciones', //menu title
	'shop_manager', //capability
	'dosifications', //menu slug
	'lw_dosifications_list'); //function

		add_submenu_page('null', //parent slug
			'Nueva Dosification', //page title
			'Nueva Dosification', //menu title
			'shop_manager', //capability
			'dosification-create', //menu slug
			'lw_dosification_create' //function
		);
		add_submenu_page('null', //parent slug
			'Editar Dosification', //page title
			'Editar Dosification', //menu title
			'shop_manager', //capability
			'dosification-edit', //menu slug
			'lw_dosification_edit' //function
		);

    //MENU Compras ---------------------------------------------------------------
	add_submenu_page('terminal-punto-venta', //parent slug
	'Compras', //page title
	'Compras', //menu title
	'shop_manager', //capability
	'compras', //menu slug
	'lw_compras_list'); //function

     //MENU Proformas ---------------------------------------------------------------
	add_submenu_page('terminal-punto-venta', //parent slug
	'Proformas', //page title
	'Proformas', //menu title
	'shop_manager', //capability
	'proformas', //menu slug
	'lw_compras_list'); //function

    //MENU Settings ---------------------------------------------------------------
	add_submenu_page('terminal-punto-venta', //parent slug
	'Configuracion', //page title
	'Configuracion', //menu title
	'shop_manager', //capability
	'setting', //menu slug
	'lw_setting'); //function
}
define('ROOTDIR', plugin_dir_path(__FILE__));
require_once(ROOTDIR . 'crud/welcome.php');

require_once(ROOTDIR . 'crud/boxs-list.php');
require_once(ROOTDIR . 'crud/boxs-create.php');
require_once(ROOTDIR . 'crud/boxs-edit.php');

require_once(ROOTDIR . 'crud/dosifications-list.php');
require_once(ROOTDIR . 'crud/dosifications-create.php');
require_once(ROOTDIR . 'crud/dosifications-edit.php');

require_once(ROOTDIR . 'crud/compras-list.php');

require_once(ROOTDIR . 'crud/setting.php');
?>

