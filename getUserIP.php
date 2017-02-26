<?php
function getUserIP(){

  $client  = @$_SERVER['HTTP_CLIENT_IP'];
  $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
  $remote  = $_SERVER['REMOTE_ADDR'];

  if(filter_var($client, FILTER_VALIDATE_IP)){
      $ip = $client;

  }elseif(filter_var($forward, FILTER_VALIDATE_IP)){
      $ip = $forward;

  }else{
      $ip = $remote;

  } 

  $postID = get_the_ID();
  $pageName = get_the_title($postID);
  $pageUrl = get_post_permalink($postID);
  
  global $wpdb;
  $date = date('Y-m-d H:i:s');

  $logged = $wpdb->prefix . "logged_ips";

  $wpdb->insert($logged,array(
      'date' => $date,
      'address' => $ip,
      'post_ID' => $postID,
      'page_name' => $pageName,
      'page_url' => $pageUrl,
      )); 
}
?>