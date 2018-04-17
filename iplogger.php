<?php
/*
Plugin Name: IP Logger
Plugin URI: https://github.com/dziugasmeskauskas/Wordpress-IP-logger
Description: Logs IP adresses of visitors.
Author: Džiugas Meškauskas
Version: 1.2
Author URI: https://github.com/dziugasmeskauskas
License: GPLv2
*/

require_once ABSPATH.'wp-config.php';
require ABSPATH.'/wp-content/plugins/Wordpress-IP-logger/createTables.php';
require ABSPATH.'/wp-content/plugins/Wordpress-IP-logger/getUserIP.php';
require ABSPATH.'/wp-content/plugins/Wordpress-IP-logger/ajaxCalls.php';
require ABSPATH.'/wp-content/plugins/Wordpress-IP-logger/frontEnd.php';

add_action('admin_menu', 'admin_actions');
add_action('init', 'create_tables');
add_action('init', 'createOption');
add_action('wp_head', 'getUserIP');

function admin_actions(){
  add_menu_page('IP logger', 'IP logger', 'manage_options', __FILE__, 'iplogger_admin');
}

wp_register_script( 'ajax','/wp-content/plugins/Wordpress-IP-logger/plugin.js', '', '', true );
wp_enqueue_script('ajax');

function iplogger_admin(){

  echo '<div class="wrap">';

  drawForm();
  drawOptional();
  drawLogged();

  echo '</div>';

  }
?>

