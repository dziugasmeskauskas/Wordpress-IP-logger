<?php

add_action( 'wp_ajax_my_action', 'insertIP' );
function insertIP(){

  $addIP = $_POST['ROUTE'];

  global $wpdb;  
  $optional = $wpdb->prefix . "optional_ips";

  $wpdb->insert($optional,
    array(
     'address' => $addIP,
      )); 

  echo $addIP;


  wp_die();

}

function deleteRow() {

  $ID = $_POST['ID'];

  echo $ID;

  global $wpdb; 
  $optional = $wpdb->prefix . "optional_ips";

  $wpdb->delete( $optional,
   array( 
    'ID' => $ID, 
    ));


  wp_die();

}

add_action('wp_ajax_deleteRow', 'deleteRow');
add_action( 'wp_ajax_nopriv_deleteRow', 'deleteRow');

add_action('wp_ajax_insertIP', 'insertIP'); 
add_action('wp_ajax_nopriv_insertIP', 'insertIP'); 

?>