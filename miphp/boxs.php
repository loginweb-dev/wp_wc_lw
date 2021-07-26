<?php 
	
	require_once('../../../../wp-load.php');
    // global $wpdb;
    global $post;
    $args = array(
        'orderby'          => 'date',
        'order'            => 'DESC',
        'post_type'        => 'pos_register',
    );
    // $get_boxs = new WP_Query( $args );
    $get_boxs = new WP_query($args);
    $json_boxs = array();
    if ( $get_boxs->have_posts() ) {
        
        while ( $get_boxs->have_posts() ) {
            $get_boxs->the_post();
            array_push($json_boxs, array(
                "id" => get_the_id(),
                "title" => get_the_title()
            ));
        }
        
    } else {
        // no posts found
    }
    wp_reset_postdata(); // VERY VERY IMPORTANT
    echo json_encode($json_boxs);
?>