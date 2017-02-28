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

  $lastID = $wpdb->get_var($wpdb->prepare(
    "SELECT ID FROM $optional WHERE address = %s",
    $addIP) 
     );

  $data=array("IP"=>$addIP, "ID"=>$lastID);

  echo json_encode($data);
  
  wp_die();
}

function deleteRow() {

  $ID = $_POST['ID'];

  global $wpdb; 
  $optional = $wpdb->prefix . "optional_ips";

  $wpdb->delete( $optional,
   array( 
    'ID' => $ID, 
    ));

  echo $ID;
  wp_die();
}

function whichIpToLog(){

  $logg = $_POST['logIP'];

  global $wpdb; 

  $options = $wpdb->prefix . "options";

  $amount_field_col = array('option_value' => $logg);
  $where_clause = array('option_name' => 'Which_ip_to_logg');

  $wpdb->update($options, $amount_field_col, $where_clause);

  echo $logg;
  wp_die();
}

add_action('wp_ajax_deleteRow', 'deleteRow');
add_action( 'wp_ajax_nopriv_deleteRow', 'deleteRow');

add_action('wp_ajax_insertIP', 'insertIP'); 
add_action('wp_ajax_nopriv_insertIP', 'insertIP'); 

add_action('wp_ajax_whichIpToLog', 'whichIpToLog'); 
add_action('wp_ajax_nopriv_whichIpToLog', 'whichIpToLog'); 

?>