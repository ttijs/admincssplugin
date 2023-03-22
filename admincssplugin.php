<?php

/**
 * Plugin Name: Admin CSS plugin
 * Plugin URI: admincssplugin
 * Description: Hiermee kun je de CSS van de Admin-pagina aanpassen
Version: 1.0.0
Author: Thomas Tijs
Author URI: ttijs.glu.nl
License: GPL-2.0+
 */


// add_action('wp_head','myscript');
// function myscript(){
//    echo "<script>alert('Okiedokie');</script>";
// }


add_action('admin_menu', 'admincssplugin_menu');
function admincssplugin_menu(){
 add_menu_page('Wijzig tekst','Admin CSS plugin','manage_options','admincssplugin_settings_page','admincssplugin_page');
}
function admincssplugin_page(){
 echo '<h2>'.__('Admin CSS Instellingen','menu-test').'</h2>';
 include_once('admincssplugin_settings_page.php');
}

// add_action( 'wp_enqueue_scripts', 'admincss_register_plugin_styles' );
// function swp_register_plugin_styles() {
//   wp_register_style( 'admincss-style', plugins_url( 'admincss/assets/css/plugin.css' ) );
//   wp_enqueue_style( 'admincss-style' );
// }
// add_action( 'wp_print_styles', 'admincss-style' );

//wp_register_style('admincss', plugins_url( 'admincss/assets/css/plugin.css' ));
//wp_register_style('admincss', '/admincss/assets/css/plugin.css');
wp_register_style('admincss', plugin_dir_url(__FILE__) . '/assets/css/plugin.css');

wp_enqueue_style( 'admincss');




function adminStylesCss3()
{

  // $url = get_template_directory_uri() . "/wp-admin.css";
  // echo '<!-- Admin CSS styles -->
  //         <link rel="stylesheet" type="text/css" href="' . $url . '" />
  //         <!-- /end Admin CSS styles -->';
  //if (isset(get_option('admincss_css')) && '' !== get_option('admincss_css')) {
    echo '<style>/* admincssplugin styles */' . wp_unslash(get_option('admincssplugin_css')) . '</style>';
  //}
}
add_action('admin_head', 'adminStylesCss3');

