<?php
function create_tables(){

  global $wpdb;
  require_once(ABSPATH . 'wp-admin/upgrade-functions.php');

  $logged = $wpdb->prefix . "logged_ips";
  $optional = $wpdb->prefix . "optional_ips";

  $sql =  "CREATE TABLE IF NOT EXISTS ". $logged . " (
           ID int(11) NOT NULL AUTO_INCREMENT,
           date text,
           address text NOT NULL, 
           post_ID int(11) NOT NULL,
           page_name text NOT NULL,
           page_url text NOT NULL,
           UNIQUE KEY ID (ID));";

  dbDelta($sql);


  $sql =  "CREATE TABLE IF NOT EXISTS ". $optional . " (
           ID int(11) NOT NULL AUTO_INCREMENT,
           address text NOT NULL, 
           UNIQUE KEY ID (ID));";

  dbDelta($sql);

 

 
  if (!isset($wpdb->logged_ips)) {

    $wpdb->logged_ips = $logged; 
    $wpdb->optional_ips = $optional; 
    $wpdb->tables[] = str_replace($wpdb->prefix, '', $logged); 
    $wpdb->tables[] = str_replace($wpdb->prefix, '', $optional); 
  }
}

function createOption () {

  global $wpdb; 
  $options = $wpdb->prefix . "options";

  $option_name = 'Which_ip_to_logg';

  $count = $wpdb->get_var($wpdb->prepare(
    "SELECT COUNT(*) FROM $options WHERE option_value = %s",
    'Which_ip_to_logg') 
     );

  if($count <= 0){

      $wpdb->insert( $options,
      array( 
        'option_name' => 'Which_ip_to_logg', 
        'option_value' => 'all',
        'autoload'=>'yes',
      ));
    } 
}
?>

