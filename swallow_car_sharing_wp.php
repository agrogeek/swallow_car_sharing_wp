<?php
/*
Plugin Name:    Swallow Car sharing
Plugin URI:     https://swallow.agrogeek.es
Description:    Crea una comunidad en tu WordPress para compartir viajes entre personas de una comunidad rural.
Version:        0.1
Author:         Sebas M. Grande-Caballero
Author URI:     https://agrogeek.es
License:        GPL2
License URI:    https://www.gnu.org/licenses/gpl-2.0.html
Text Domain:    swallow-car-sharing-wp
*/

defined('ABSPATH') or die("Bye bye");

define('SWALLOWPATH',plugin_dir_path(__FILE__));

function swallow_activation(){
  //TODO iniciar valores
}
register_activation_hook(__FILE__, 'swallow_activation');



function swallow_deactivation(){
  //TODO eliminar valores
}
register_deactivation_hook(__FILE__, 'swallow_deactivation');

include_once(SWALLOWPATH . '/includes/functions.php');
include_once(SWALLOWPATH . '/includes/menu-page.php');
 ?>
