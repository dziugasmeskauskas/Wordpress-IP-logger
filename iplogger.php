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
   
  
  global $wpdb;

  $date = date('Y-m-d H:i:s');
  $wpdb->insert('ips',array(
      'date' => $date,
      'address' => $ip,
      )); 
}

add_action('wp_head', 'getUserIP');


function iplogger_admin(){

  global $wpdb;
  $displayData = $wpdb->get_results(
    "
    SELECT ID, Date, Address
    FROM `ips`
    "
    );

?>
  <div class="wrap">
    <h4>IP logger</h4>

    <table class="widefat">
      <thead>
        <tr>
          <th>#</th>
          <th>IP adress</th>
          <th>Date</th>
        </tr>
      </thead>
        <tfoot>
        <tr>
          <th>#</th>
          <th>IP adress</th>
          <th>Date</th>
        </tr>
        </tfoot>
        <tbody>
<?php
          foreach ($displayData as $displayData) {
?>
          <tr>
<?php
            echo "<td>".$displayData->ID."</td>";
            echo"<td>".$displayData->Address."</td>";
            echo "<td>".$displayData->Date."</td>";
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