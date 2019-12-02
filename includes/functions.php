<?php

defined('ABSPATH') or die("Bye bye");

// Shortcode añadir viaje
function swallow_shortcode_add_travel() {
    include_once(SWALLOWPATH.'/public/new_travel.php');
}
add_shortcode('swallow_new_travel', 'swallow_shortcode_add_travel');

// Shortcode listado de viajes
function swallow_shortcode_list_travels() {
    include_once(SWALLOWPATH.'/public/list_travels.php');
}
add_shortcode('swallow_travels', 'swallow_shortcode_list_travels');

// Swallow Settings
function register_my_setting() {
    $args = array(
            'type' => 'string',
            'sanitize_callback' => 'sanitize_title',
            'default' => 'travel',
            );
    register_setting( 'swallow_options_group', 'swallow_travels_slug', $args );
}
add_action( 'admin_init', 'register_my_setting' );



// Travel Post Type
// Register Custom Post Type
function swallow_travel_post_type() {

	$labels = array(
		'name'                  => 'Travels',
		'singular_name'         => 'Travel',
		'menu_name'             => 'Travels',
		'name_admin_bar'        => 'Travel',
		'archives'              => 'Item Archives',
		'attributes'            => 'Item Attributes',
		'parent_item_colon'     => 'Parent Item:',
		'all_items'             => 'All Items',
		'add_new_item'          => 'Add New Item',
		'add_new'               => 'Add New',
		'new_item'              => 'New Item',
		'edit_item'             => 'Edit Item',
		'update_item'           => 'Update Item',
		'view_item'             => 'View Item',
		'view_items'            => 'View Items',
		'search_items'          => 'Search Item',
		'not_found'             => 'Not found',
		'not_found_in_trash'    => 'Not found in Trash',
		'featured_image'        => 'Featured Image',
		'set_featured_image'    => 'Set featured image',
		'remove_featured_image' => 'Remove featured image',
		'use_featured_image'    => 'Use as featured image',
		'insert_into_item'      => 'Insert into item',
		'uploaded_to_this_item' => 'Uploaded to this item',
		'items_list'            => 'Items list',
		'items_list_navigation' => 'Items list navigation',
		'filter_items_list'     => 'Filter items list',
	);
	$rewrite = array(
		'slug'                  => get_option('swallow_travels_slug'),
		'with_front'            => true,
		'pages'                 => true,
		'feeds'                 => true,
	);
	$args = array(
		'label'                 => 'Travel',
		'description'           => 'Travel Car Sharing',
		'labels'                => $labels,
		'supports'              => array( 'title', 'comments', 'author' ),
		'taxonomies'            => array( 'category', 'post_tag' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'menu_icon'             => 'http://projects.agrogeek.es/swallow.png',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => get_option('swallow_travels_archive'),
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'rewrite'               => $rewrite,
		'capability_type'       => 'post',
		'show_in_rest'          => true,
	);
	register_post_type( 'swallow_travel', $args );

}
  add_action( 'init', 'swallow_travel_post_type', 0 );

  // Register Meta Boxes Travels
  function swallow_register_meta_boxes(){
    add_meta_box('swallow-id', 'Datos del Viaje', 'swallow_display_callback', 'swallow_travel');
  }
  add_action('add_meta_boxes', 'swallow_register_meta_boxes', 0);

  function swallow_display_callback( $post ){
    $type = get_post_meta( $post->ID, 'type', true );
  	$start_datetime = get_post_meta( $post->ID, 'start_datetime', true );
    $initial_place = get_post_meta( $post->ID, 'initial_place', true );
    $destination_place = get_post_meta( $post->ID, 'destination_place', true );
    $visibility = get_post_meta( $post->ID, 'visibility', true );
    $seats = get_post_meta( $post->ID, 'seats', true );


  	// Usaremos este nonce field más adelante cuando guardemos en twp_save_meta_box()
  	wp_nonce_field( 'swallow_meta_box_nonce', 'meta_box_nonce' );


  	echo '<p><label for="type">Tipo de viaje</label> <input type="text" name="type" id="type" value="'. $type .'" /></p>';
  	echo '<p><label for="start_datetime">Fecha del viaje</label> <input type="datetime-local" name="start_datetime" id="start_datetime" value="'. $start_datetime .'" /></p>';
  }

  // Save Meta Boxes
  function swallow_save_meta_box($post){
    // Comprobamos si es auto guardado
  	if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
  	// Comprobamos el valor nonce creado en twp_mi_display_callback()
  	if( !isset( $_POST['meta_box_nonce'] ) || !wp_verify_nonce( $_POST['meta_box_nonce'], 'mi_meta_box_nonce' ) ) return;
  	// Comprobamos si el usuario actual no puede editar el post
  	if( !current_user_can( 'edit_post' ) ) return;


  	// Guardamos...
  	if( isset( $_POST['type'] ) )
  	  update_post_meta( $post_id, 'type', wp_kses( $_POST['type'] ) );
  	if( isset( $_POST['start_datetime'] ) )
  	  update_post_meta( $post_id, 'start_datetime', wp_kses( $_POST['start_datetime'] ) );
    if( isset( $_POST['initial_place'] ) )
      update_post_meta( $post_id, 'initial_place', wp_kses( $_POST['initial_place'] ) );
    if( isset( $_POST['destination_place'] ) )
  	  update_post_meta( $post_id, 'destination_place', wp_kses( $_POST['destination_place'] ) );
    if( isset( $_POST['visibility'] ) )
  	  update_post_meta( $post_id, 'visibility', wp_kses( $_POST['visibility'] ) );
    if( isset( $_POST['seats'] ) )
      update_post_meta( $post_id, 'seats', wp_kses( $_POST['seats'] ) );
  }



  function swallow_archive_template( $template ) {
    if ( is_post_type_archive('swallow_travel') ) {
      $theme_files = array('archive-swallow_travel.php',
                           'swallow_car_sharing_wp/archive-swallow_travel.php');
      $exists_in_theme = locate_template($theme_files, false);
      if ( $exists_in_theme != '' ) {
        return $exists_in_theme;
      } else {
        $template = SWALLOWPATH . 'archive-swallow_travel.php';
      }
    }
    return $template;
  }
  add_filter('template_include', 'swallow_archive_template');

  function swallow_single_template( $template ) {
    if ( is_singular('swallow_travel') ) {
      $theme_files = array('single-swallow_travel.php',
                           'swallow_car_sharing_wp/single-swallow_travel.php');
      $exists_in_theme = locate_template($theme_files, false);
      if ( $exists_in_theme != '' ) {
        return $exists_in_theme;
      } else {
        $template = SWALLOWPATH . 'single-swallow_travel.php';
      }
    }
    return $template;
  }
  add_filter('single_template', 'swallow_single_template');

 ?>
