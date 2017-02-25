<?php
/*
Plugin Name: IP Logger
Plugin URI: 
Description: Logs IP adresses of visitors.
Author: 
Version: 1.0
Author URI: 
License: GPLv2
*/


require_once(ABSPATH.'wp-config.php');
add_action('admin_menu', 'admin_actions');

function create_stats(){
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
 
//add to front and backend inits
add_action('init', 'create_stats');


function admin_actions(){

  add_options_page('IP logger', 'IP logger', 'manage_options', __FILE__, 'iplogger_admin');

}

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

  $wpdb->insert('ips',array(
      'date' => $date,
      'address' => $ip,
      'post_ID' => $postID,
      'page_name' => $pageName,
      'page_url' => $pageUrl,
      )); 
}

add_action('wp_head', 'getUserIP');


function iplogger_admin(){

  global $wpdb;
  $displayData = $wpdb->get_results(
    "
    SELECT ID, date, address, post_ID, page_name, page_url
    FROM `ips`
    "
    );

?>
  <div class="wrap">
    <h4>IP logger</h4> <input type="text" required pattern="((^|\.)((25[0-5])|(2[0-4]\d)|(1\d\d)|([1-9]?\d))){4}$">
    <table class="widefat">
      <thead>
        <tr>
          <th>#</th>
          <th>IP adress</th>
          <th>Date</th>
          <th>Post ID</th>
          <th>Post Name</th>
          <th>Post Link</th>
        </tr>
      </thead>
        <tfoot>
        <tr>
          <th>#</th>
          <th>IP adress</th>
          <th>Date</th>
          <th>Post ID</th>
          <th>Post Name</th>
          <th>Post Link</th>
        </tr>
        </tfoot>
        <tbody>
        <?php
          foreach ($displayData as $displayData) {
        ?>
          <tr>
        <?php
          echo "<td>".$displayData->ID."</td>";
          echo"<td>".$displayData->address."</td>";
          echo"<td>".$displayData->date."</td>";
          echo "<td>".$displayData->post_ID."</td>";
          echo "<td>".$displayData->page_name."</td>";
          echo "<td> <a href='".$displayData->page_url."'>Link</a></td>";
        ?>
          <tr>
        <?php
          }
        ?>
        </tbody>
      </table>
  </div>
<?php
  }
?>