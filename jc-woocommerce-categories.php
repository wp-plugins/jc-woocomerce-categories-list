<?php 
/*
Plugin Name: JC Woocomerce Categories List
Plugin URI: http://webdesignjc.com/recaptchawp/index.html
Description: The create list categories and product woocomerce 
Version: 1.0
Author: Julio Cesar LLavilla Ccama
Autor URI: http://webdesignjc.com/
License: GPL2
*/
?>
<?php
// create custom plugin settings menu
//add_action('init','functinit');
add_action('admin_menu', 'jc_woocomerce_create_menu');
function jc_woocomerce_create_menu() {
	add_menu_page('JC Woocomerce Categories', 'JC Categories Settings', 'administrator', __FILE__, 'jc_woocomerce_settings_page',plugins_url('/images/icon.png', __FILE__));
	add_action( 'admin_init', 'jc_woocomerce_settings_categories' );
}

add_action( 'init', 'jc_style_wooccomerce_categories' );

function jc_style_wooccomerce_categories() {
  wp_enqueue_style( 'style-woocommerse', plugins_url( '/css/jc-woocommerce-categories.css', __FILE__ ));
}




function jc_woocomerce_settings_categories() {
  register_setting( 'jc-woocommerce-se', 'post-per-page' );
  register_setting( 'jc-woocommerce-se', 'enable-image' );
  register_setting( 'jc-woocommerce-se', 'enable-products' );
}
require_once dirname(__FILE__).'/inc/options.php';

function functinit(){
 $args = array('taxonomy' => 'product_cat');
 $terms = get_terms('product_cat', $args);
 if (count($terms) > 0) {
   echo'<div><ul id="jc-categories-container" class="jc-categories-container">';
   foreach ($terms as $term):
    echo'<li class="item '.$term->slug.'">';
  echo '<div class="img-and-title">';
  if(get_option('enable-image') !== ""){
   echo '<div class="image">';
   $product_cat = get_term_by('slug', $term->slug, 'product_cat');
   woocommerce_subcategory_thumbnail($product_cat);
   echo '</div>';
 }
 echo '<div class="title">';
 echo '<a href="/product-category/' . $term->slug . '">' . $term->name . '</a>';
 echo '</div>';
 echo '</div>';
 if(get_option('enable-products') !== ""){
  echo listPost($term->slug);
}
wp_reset_query();
echo '</li>';
endforeach;
echo '</ul></div>';
return $ul;
}
}

function listPost($slug) {
  $numpost =  esc_attr( get_option("post-per-page") );
  $argcount = array('post_type' => 'product', 'product_cat' => $slug); 
  $my_query = new WP_Query($argcount); 
  $cantPost=$my_query->post_count;
  if ($numpost > 0 and $cantPost > $numpost ) {
    $arg= array('post_type' => 'product', 'product_cat' => $slug,'showposts'=>$numpost);
    $linkseemore='<a href="/product-category/'.$slug.'" class="see-more-cat">See More</a>'; 
  }else{
    $arg = array('post_type' => 'product', 'product_cat' => $slug,'showposts'=>-1); 
  }
  $my_query = new WP_Query($arg);
  if( $my_query->have_posts() ) : 
    $ol = '<ol>';
  while ($my_query->have_posts()) : $my_query->the_post(); 
  $ol.='<li>';
  $ol.='<a href="' . get_the_permalink() . '">' . get_the_title() . '</a>';
  $ol.='</li>';
  endwhile; 
  $ol.='</ol>';
  $ol.=$linkseemore;
  endif;
  return $ol;
}
add_shortcode( 'categories_product', 'functinit' );
add_filter('widget_text', 'do_shortcode');
?>