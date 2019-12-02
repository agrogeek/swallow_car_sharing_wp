<?php

defined('ABSPATH') or die("Bye bye");
if (! current_user_can ('manage_options')) wp_die (__ ('No tienes suficientes permisos para acceder a esta página.'));

?>
<div class="wrap">
  <h1>Swallow</h1>
  <form class="" action="options.php" method="post">
    <?php settings_fields( 'swallow_options_group' ); ?>
    <?php do_settings_sections( 'swallow_options_group' ); ?>
    <labels for="swallow_travels_slug">Slug para listado de viajes</label>
    <input type="text" id="swallow_travels_slug" name="swallow_travels_slug" value="<?php echo esc_attr(get_option('swallow_travels_slug')); ?>" />
    <?php submit_button(); ?>
  </form>
</div>
