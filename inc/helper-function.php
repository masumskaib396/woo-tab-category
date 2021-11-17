<?php

/**
 * Get Pages
 *
 * @since 1.0
 *
 * @return array
 */
if ( ! function_exists( 'sakib_get_all_pages' ) ) {
    function sakib_get_all_pages($posttype = 'page')
    {
        $args = array(
            'post_type' => $posttype,
            'post_status' => 'publish',
            'posts_per_page' => -1
        );

        $page_list = array();
        if( $data = get_posts($args)){
            foreach($data as $key){
                $page_list[$key->ID] = $key->post_title;
            }
        }
        return  $page_list;
    }
}
/**
 * Meta Output
 *
 * @since 1.0
 *
 * @return array
 */
if ( ! function_exists( 'sakib_get_meta' ) ) {
    function sakib_get_meta( $data ) {
        global $wp_embed;
        $content = $wp_embed->autoembed( $data );
        $content = $wp_embed->run_shortcode( $content );
        $content = do_shortcode( $content );
        $content = wpautop( $content );
        return $content;
    }
}


/**
 * get percentage by quantity
 */
function sakib_get_discount( $quantity ) {
    switch ($quantity) {
        case 6:
            $discount = 20;
            break;
        case 10:
            $discount = 30;
            break;
        default:
            $discount = 0;
    }
    return $discount / 100;
}

/**
 * Set dynamic product price or discount by quantity
 *
 * @param $cart_object
 *
 * @return void
 */
function sakib__cart_item_price( $cart_object ){

    if ( is_admin() && ! defined( 'DOING_AJAX' ) )
        return;

    // Required since Woocommerce version 3.2 for cart items properties changes
    if ( did_action( 'woocommerce_before_calculate_totals' ) >= 2 )
        return;

    foreach ( $cart_object->get_cart() as $cart_item ) {
        // discounts by quantity
        $new_price = $cart_item['data']->get_regular_price() - ( $cart_item['data']->get_regular_price() * sakib_get_discount( (int) $cart_item['quantity'] ) );
        $cart_item['data']->set_price( $new_price );

    }
}

add_action( 'woocommerce_before_calculate_totals', 'sakib__cart_item_price', 20, 1 );