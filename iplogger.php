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


require_once ABSPATH.'wp-config.php';
require ABSPATH.'/wp-content/plugins/Wordpress-IP-logger/createTables.php';
require ABSPATH.'/wp-content/plugins/Wordpress-IP-logger/getUserIP.php';
require ABSPATH.'/wp-content/plugins/Wordpress-IP-logger/insertOptionalIPs.php';
require ABSPATH.'/wp-content/plugins/Wordpress-IP-logger/drawForm.php';
require ABSPATH.'/wp-content/plugins/Wordpress-IP-logger/drawOptional.php';
require ABSPATH.'/wp-content/plugins/Wordpress-IP-logger/drawLogged.php';

add_action('admin_menu', 'admin_actions');
add_action('init', 'create_tables');
add_action('wp_head', 'getUserIP');
add_action( 'admin_footer', 'ajaxCall' ); 

function admin_actions(){
  add_menu_page('IP logger', 'IP logger', 'manage_options', __FILE__, 'iplogger_admin');
}

function ajaxCall() { ?>
  <script type="text/javascript" >

  jQuery(document).ready(function($) {
    $("#addAddress").on("submit", function(e) {
    var IP = jQuery("#dname").val()
    e.preventDefault();
    var data = {
              'action': 'insertIP',
              'ROUTE': IP
               };

    jQuery.post(ajaxurl, data, function(response) {
      drawOptional();

    });


    });

});
  </script> <?php
}



function iplogger_admin(){
  ?>
   <div class="wrap">
   <?php
   drawForm();
   drawOptional();
   drawLogged();

  }



?>
