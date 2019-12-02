<?php

defined('ABSPATH') or die("Bye bye");

/* Admin Menu Settings */
function swallow_admin_menu(){
    $slug_top = SWALLOWPATH.'/admin/settings.php';
    add_menu_page('Swallow - Configuración General', 'Swallow', 'manage_options', $slug_top, null, '', 26);

    add_submenu_page($slug_top, 'Swallow - Créditos', 'Créditos', 'manage_options', SWALLOWPATH.'/admin/credits.php');
}
add_action('admin_menu', 'swallow_admin_menu');


 ?>
