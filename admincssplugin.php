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
 echo '<h2>'.__('Wordpress Wacker','menu-test').'</h2>';
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

  $username = wp_get_current_user()->user_login;

  // admin menu links nog weg doen?
  if ($username != 'admin') {
    echo '<style>
      #adminmenumain, #wpadminbar {
        display: none;
    }
  ';
  }


  $blogusers = get_users();
  shuffle($blogusers);
  // Array of WP_User objects.
  foreach ($blogusers as $user) {
    if ($user->display_name === $username) {
      continue;
    }
    //echo '<li>' . esc_html($user->display_name) . '</li>';
    echo '<style>/* admincssplugin styles van ' . $user->display_name . ' */' . wp_unslash(get_option('admincssplugin_css-'. $user->display_name)) . '</style>';

  }



  // $url = get_template_directory_uri() . "/wp-admin.css";
  // echo '<!-- Admin CSS styles -->
  //         <link rel="stylesheet" type="text/css" href="' . $url . '" />
  //         <!-- /end Admin CSS styles -->';
  //if (isset(get_option('admincss_css')) && '' !== get_option('admincss_css')) {
    echo '<style>/* admincssplugin styles van ' . $username . ' */' . wp_unslash(get_option('admincssplugin_css-'. $username)) . '</style>';
  //}

  add_filter('admin_body_class', 'my_admin_body_class');
}
add_action('admin_head', 'adminStylesCss3', 10, 2);

function my_admin_body_class($classes)
{
  $username = wp_get_current_user()->user_login;
  // Right: Add a leading space and a trailing space.
  $classes .= ' ' . $username . ' ';

  return $classes;
}
