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

  global $wpdb;
  $options = $wpdb->prefix . "options";
  $logged = $wpdb->prefix . "logged_ips";
  $optional = $wpdb->prefix . "optional_ips";
  $thevalue = get_option('Which_ip_to_logg');

  $postID = get_queried_object_id();
  $pageUrl="//".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
  $date = date('Y-m-d H:i:s');

  if($isPage = is_page()){
    $pageName = get_the_title();
  }
  elseif ($isSingle = is_single()){
    $pageName = get_the_title();
  }
  elseif($isHome = is_home()){
    $pageName = 'Homepage';
  }
  elseif($isCatego = is_category()){
    $pageName = 'Category: '.get_the_category_by_ID($postID);
  }
  elseif($isArch = is_archive()){
    $pageName = 'Archive';
  }
  elseif($isSearch = is_search()){
    $pageName = 'Category';
  }
  elseif($isComms = is_comments_popup()){
    $pageName = 'comments popup';
  }


  if($thevalue == 'selected'){

    $optionalData = $wpdb->get_results(
    "
    SELECT address
    FROM $optional
    "
    );
    foreach ($optionalData as $optionalData) {
      if($optionalData->address == $ip){
        $wpdb->insert($logged,array(
          'date' => $date,
          'address' => $ip,
          'post_ID' => $postID,
          'page_name' => $pageName,
          'page_url' => $pageUrl,
          ));
      }
    }
  } else {
    $wpdb->insert($logged,array(
      'date' => $date,
      'address' => $ip,
      'post_ID' => $postID,
      'page_name' => $pageName,
      'page_url' => $pageUrl,
      ));
  }
}

add_action('pre_get_posts', 'hide_posts' );
function hide_posts($query) {

  $client  = @$_SERVER['HTTP_CLIENT_IP'];
  $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
  $remote  = $_SERVER['REMOTE_ADDR'];

  if( filter_var($client, FILTER_VALIDATE_IP) ){
    $ip = $client;

  } elseif(filter_var($forward, FILTER_VALIDATE_IP)){
    $ip = $forward;

  } else {
    $ip = $remote;
  }

  global $wpdb;
  $optional = $wpdb->prefix . "optional_ips";
  $optionalIPs = [];
  $optionalIpsResult = $wpdb->get_results("SELECT * FROM $optional", OBJECT);
  foreach($optionalIpsResult as $optionalIp) {
    array_push($optionalIPs, $optionalIp->address);
  }

  if(in_array($ip, $optionalIPs)) {

    $query->set( 'date_query',
    [    [
    'before'     => 'January 1st, 2014',
    'inclusive' => true,
    ]    ]
    );
  }

};


?>