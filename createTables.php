<?php
function create_tables(){
  global $wpdb;

  $logged = $wpdb->prefix . "logged_ips";
  $optional = $wpdb->prefix . "optional_ips";

  if($wpdb->get_var("show tables like '$logged'") !== $logged) {

    $sql =  "CREATE TABLE ". $logged . " (
            ID int(11) NOT NULL AUTO_INCREMENT,
            date text,
            address text NOT NULL, 
            post_ID int(11) NOT NULL,
            page_name text NOT NULL,
            page_url text NOT NULL,
            UNIQUE KEY ID (ID));";
  }

    if($wpdb->get_var("show tables like '$optional'") !== $optional) {

    $sql =  "CREATE TABLE ". $optional . " (
            ID int(11) NOT NULL AUTO_INCREMENT,
            address text NOT NULL, 
            UNIQUE KEY ID (ID));";
  }
 
  require_once(ABSPATH . 'wp-admin/upgrade-functions.php');
  dbDelta($sql);
 
  if (!isset($wpdb->logged_ips)) {

    $wpdb->logged_ips = $logged; 
    $wpdb->optional_ips = $optional; 
    $wpdb->tables[] = str_replace($wpdb->prefix, '', $logged); 
    $wpdb->tables[] = str_replace($wpdb->prefix, '', $optional); 
  }
}
?>