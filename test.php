<?php 
require_once('../../../wp-load.php');
$dosification = get_post( array('post_status' => 'publish', 'post_type' => 'pos_dosification') );
print_r($dosification);
echo $dosification->ID;

?>