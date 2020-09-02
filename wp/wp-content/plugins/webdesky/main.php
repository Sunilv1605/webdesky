<?php
/*
Plugin Name: Webdesky - Custom Post
Plugin URI: http://google.com
description: Machine Test -> Create a custom post type with its meta data
Version: 1.0
Author: Sunil Vishwakarma
Author URI: http://google.com
License: GPL2
*/

require_once( ABSPATH . "wp-includes/pluggable.php" );
require_once( ABSPATH . "wp-load.php" );
define('SUNPLUGIN_FOLDER', plugin_basename(dirname(__FILE__)));
define('SUNPLUGIN_DIR', WP_PLUGIN_DIR . '/' . SUNPLUGIN_FOLDER);
define('DS', DIRECTORY_SEPARATOR);
define('SUNPLUGINTMP', "/".SUNPLUGIN_FOLDER);
define('SUNPLUGINPATH', plugins_url(SUNPLUGINTMP));

add_action('init', 'sun1991_enque_scripts');
function sun1991_enque_scripts(){
  wp_enqueue_style('sun-bootstrap_01', 'https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css', false, '4.5.2', 'all');
}
/*
* include all required files
*/
add_shortcode('product_listing' ,'sun1994_product_listing' );
function sun1994_product_listing(){

  if(isset($_GET['task']) && $_GET['task']=='add_to_cart' && isset($_GET['id'])){
    $p_id = base64_decode($_GET['id']);
    // wp_redirect();
    echo "Working on it";
    exit();
  }

  $wpb_all_query = new WP_Query(array('post_type'=>'products', 'post_status'=>'publish', 'posts_per_page'=>15));
 
  $txt = '
  <div class="row">';
  if ( $wpb_all_query->have_posts() ){

    while ( $wpb_all_query->have_posts() ) : $wpb_all_query->the_post();
      global $post;
      $prod_price = (isset($post->regular_price) && $post->regular_price!='')?$post->regular_price:$post->sale_price;
      $image_url = (has_post_thumbnail( $post->ID ) ) ? wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'thumbnail', false ): 'https://thumbs.dreamstime.com/b/no-image-available-icon-flat-vector-illustration-132483587.jpg';
      if(is_array($image_url)){
        $image_url = $image_url[0];
      }
      $add_to_cart = get_permalink(20).'?task=add_to_cart&id='.base64_encode($post->ID);
      $detail_page = get_permalink(29).'?task=red&id='.base64_encode($post->ID);
      $txt .='
        <div class="col-4">
          <div class="card">
            <div class="card-body text-center">
              <a href="'.$detail_page.'">
              <div style="width: 100%;height: 300px;background-image: url('.$image_url.');background-size:contain;background-repeat-x:no-repeat;background-position: center;" class="product-image"></div>
              </a>
            </div>
            <h6 class="p-0 m-0 pl-4">'.get_the_title().'</h6>
            <p class="p-0 m-0 pl-4"><label>Price: RS '.$prod_price.'/-</label></p>
            <div class="card-footer">
              <a href="'.$add_to_cart.'" class="btn btn-primary btn-lg btn-block">Add to Cart</a>
            </div>
          </div>
        </div>
      ';
    endwhile;
    wp_reset_postdata();
  }
  else{
    //Their are no products
  }
  $txt .= "
    </div>
  ";
  return $txt; 
}


add_shortcode('single_product', 'sun1994_display_single_product');
function sun1994_display_single_product(){
  $txt = '<div class="container">
  <div class="row">';
  if(isset($_GET['id'])){
    $product_id = base64_decode($_GET['id']);
    $prod = get_post($product_id);

    $prod_price = (isset($prod->regular_price) && $prod->regular_price!='')?$prod->regular_price:$prod->sale_price;
    $image_url = (has_post_thumbnail( $prod->ID ) ) ? wp_get_attachment_image_src( get_post_thumbnail_id( $prod->ID ), 'thumbnail', false ): 'https://thumbs.dreamstime.com/b/no-image-available-icon-flat-vector-illustration-132483587.jpg';
    if(is_array($image_url)){
      $image_url = $image_url[0];
    }
    $txt .= '
      <div class="col-5">
        <img src="'.$image_url.'" />
      </div>
      <div class="col-7">
        <h6>'.get_the_title($prod->ID).'</h6>   
        <p>Price: Rs'.$prod_price.'/-</p>
        <p>'.$prod->full_description.'</p>
        <p>'.$prod->short_description.'</p>
        <a class="btn btn-primary btn-lg" href="javascript:void(0);">Add to Cart</a>
      </div>
    ';
  }
  else{
    // wp_redirect('/');
    // exit();
  }
  $txt .='</div>
  </div>';
  return $txt;
}

function custom_post_type() {
  // Set UI labels for Custom Post Type
    $labels = array(
        'name'                => _x( 'Product', 'Post Type General Name', 'twentytwenty' ),
        'singular_name'       => _x( 'Product', 'Post Type Singular Name', 'twentytwenty' ),
        'menu_name'           => __( 'Products', 'twentytwenty' ),
        'parent_item_colon'   => __( 'Parent Product', 'twentytwenty' ),
        'all_items'           => __( 'All Products', 'twentytwenty' ),
        'view_item'           => __( 'View Product', 'twentytwenty' ),
        'add_new_item'        => __( 'Add New Product', 'twentytwenty' ),
        'add_new'             => __( 'Add New', 'twentytwenty' ),
        'edit_item'           => __( 'Edit Product', 'twentytwenty' ),
        'update_item'         => __( 'Update Product', 'twentytwenty' ),
        'search_items'        => __( 'Search Product', 'twentytwenty' ),
        'not_found'           => __( 'Not Found', 'twentytwenty' ),
        'not_found_in_trash'  => __( 'Not found in Trash', 'twentytwenty' ),
    );
     
// Set other options for Custom Post Type
     
    $args = array(
        'label'               => __( 'products', 'twentytwenty' ),
        'description'         => __( 'Product news and reviews', 'twentytwenty' ),
        'labels'              => $labels,
        // Features this CPT supports in Post Editor
        'supports'            => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'revisions', 'custom-fields', ),
        // You can associate this CPT with a taxonomy or custom taxonomy. 
        'taxonomies'          => array( 'genres' ),
        /* A hierarchical CPT is like Pages and can have
        * Parent and child items. A non-hierarchical CPT
        * is like Posts.
        */ 
        'hierarchical'        => false,
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_nav_menus'   => true,
        'show_in_admin_bar'   => true,
        'menu_position'       => 5,
        'can_export'          => true,
        'has_archive'         => true,
        'exclude_from_search' => false,
        'publicly_queryable'  => true,
        'capability_type'     => 'post',
        'show_in_rest' => true,
 
    );
     
    // Registering your Custom Post Type
    register_post_type( 'products', $args );
 
}
 
/* Hook into the 'init' action so that the function
* Containing our post type registration is not 
* unnecessarily executed. 
*/
 
add_action( 'init', 'custom_post_type', 0 );


function post_meta_box_advertising_category( $post ) { ?>

  <?php wp_nonce_field( basename( __FILE__ ), 'smashing_post_class_nonce' ); ?>
  <p>
    <label for="regular_price"><?php _e( "Regular Price", 'products' ); ?></label>
    <br />
    <input class="widefat" type="number" name="regular_price" id="regular_price" value="<?php echo esc_attr( get_post_meta( $post->ID, 'regular_price', true ) ); ?>" size="30" />
  </p>
  <p>
    <label for="sale_price"><?php _e( "Sale Price", 'products' ); ?></label>
    <br />
    <input class="widefat" type="number" name="sale_price" id="sale_price" value="<?php echo esc_attr( get_post_meta( $post->ID, 'sale_price', true ) ); ?>" size="30" />
  </p>
  <p>
    <label for="full_description"><?php _e( "Full Description", 'products' ); ?></label>
    <br />
    <?php
      $content   = get_post_meta( $post->ID, 'full_description', true );
      $editor_id = 'full_description';
      $settings = array('textarea_rows' => 10);
      wp_editor( $content, $editor_id, $settings );
    ?>
  </p>
  <p>
    <label for="short_description"><?php _e( "Short Description", 'products' ); ?></label>
    <br />
    <?php
      $content   = get_post_meta( $post->ID, 'short_description', true );
      $editor_id = 'short_description';
      $settings = array('textarea_rows' => 4);
      wp_editor( $content, $editor_id, $settings );
    ?>
  </p>

<?php }


function add_post_meta_boxes() {
  add_meta_box(
    "post_metadata_advertising_category", // div id containing rendered fields
    "Product Extra Details", // section heading displayed as text
    "post_meta_box_advertising_category", // callback function to render fields
    "products", // name of post type on which to render fields
    "normal", // location on the screen
    "high" // placement priority
  );
}
add_action( "admin_init", "add_post_meta_boxes" );

add_action( 'save_post', 'smashing_save_post_class_meta', 10, 2 );

function smashing_save_post_class_meta( $post_id, $post ) {

  /* Verify the nonce before proceeding. */
  if ( !isset( $_POST['smashing_post_class_nonce'] ) || !wp_verify_nonce( $_POST['smashing_post_class_nonce'], basename( __FILE__ ) ) )
    return $post_id;

  /* Get the post type object. */
  $post_type = get_post_type_object( $post->post_type );

  /* Check if the current user has permission to edit the post. */
  if ( !current_user_can( $post_type->cap->edit_post, $post_id ) )
    return $post_id;

  /* Get the posted data and sanitize it for use as an HTML class. */

  $all_meta_field = array('regular_price', 'sale_price', 'full_description', 'short_description');

  foreach ($all_meta_field as $key => $fd) {
    // $new_meta_value = ( isset( $_POST[$fd] ) ? sanitize_html_class( $_POST[$fd] ) : ’ );
    $new_meta_value = ( isset( $_POST[$fd] ) ? $_POST[$fd] : ’ );
    /* Get the meta key. */
    $meta_key = $fd;
    /* Get the meta value of the custom field key. */
    $meta_value = get_post_meta( $post_id, $meta_key, true );

    /* If a new meta value was added and there was no previous value, add it. */
    if ( $new_meta_value && ’ == $meta_value )
    add_post_meta( $post_id, $meta_key, $new_meta_value, true );

    /* If the new meta value does not match the old value, update it. */
    elseif ( $new_meta_value && $new_meta_value != $meta_value )
    update_post_meta( $post_id, $meta_key, $new_meta_value );

    /* If there is no new meta value but an old value exists, delete it. */
    elseif ( ’ == $new_meta_value && $meta_value )
    delete_post_meta( $post_id, $meta_key, $meta_value );
  }
}

?>