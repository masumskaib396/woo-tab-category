<?php
/**
 * Button Widget.
 *
 *
 * @since 1.0.0
 */
namespace Sakib\Widgets\Elementor;

use  Elementor\Widget_Base;
use  Elementor\Controls_Manager;
use  Elementor\utils;
use  Elementor\Scheme_Color;
use  Elementor\Group_Control_Typography;
use  Elementor\Scheme_Typography;
use  Elementor\Group_Control_Box_Shadow;
use  Elementor\Group_Control_Background;
use  Elementor\Group_Control_Border;
use  Elementor\Icons_Manager;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

class Sakib_Category_Tab extends \Elementor\Widget_Base {

	public function get_name() {
		return 'sakib_category_tab';
	}

	public function get_title() {
		return __( 'Product Category Tab', 'sakib-addons' );
	}

	public function get_icon() {
		return 'eicon-button';
	}

	public function get_categories() {
		return [ 'sakib' ];
	}

    public function get_keywords()
    {
        return ['catgory', 'sakib', 'product', 'wooco'];
    }

	protected function _register_controls() {

		$this->start_controls_section('content_section',
			[
				'label' => __( 'Category Content', 'sakib-addons' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->end_controls_section();

	}
	protected function render() {
		$settings = $this->get_settings_for_display();

        // Taxonomy Loop

        $terms = get_terms( array(
            'taxonomy'   => 'product_cat', //custom taxonomy name
            'hide_empty' => true,
            'parent' => 16,
        ));

		?>



        <div class="sakib-tab-section">
            <div class="sakib-tab-container">
                        <ul class="sakib-tabs-nav">
                            <?php

                            // Loop through all terms with a foreach loop
                            foreach( $terms as $term ) {
                                echo '<li><a href="#'. $term->slug .'">'. $term->name .'</a></li>';
                            }
                            ?>

                        </ul> <!-- END tabs-nav -->
                        <div class="sakib-tabs-content">
                            <?php
                            foreach( $terms as $term ) {

                            ?>
                            <div id="<?php echo $term->slug;?>" class="sakib-tab-content">
                                <?php

                                    $args = array(
                                    'posts_per_page' => 10,
                                    'post_type' => 'product',
                                    'tax_query' => array(
                                        array (
                                            'taxonomy' => 'product_cat',
                                            'field' => 'slug',
                                            'terms' => $term->slug,
                                        )
                                        ),
                                    );

                                    $query = new \WP_Query( $args );

                                ?>

                            <?php if( $query->have_posts() ) : ?>
                                <?php while ( $query->have_posts() ) : $query->the_post(); ?>
                                <?php $product = wc_get_product(get_the_ID());?>
                                <div class="sakib-tab-item">
                                    <div class="sakib-tab-header">
                                        <div class="sakib-tab-header-left">
                                            <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>

                                            <p><?php the_excerpt(); ?></p>
                                            <h2>£<span class="tprice"><?php echo $product->get_price(); ?></span><span>Total</span></h2>

                                        </div>
                                        <div class="sakib-tab-header-right">
                                            <ul class="button_quantity">
                                                <li class="qbutton" data-q="1" data-price="<?php echo $product->get_price(); ?>">1</li>
                                                <li class="qbutton" data-q="3" data-price="<?php echo $product->get_price(); ?>">3</li>
                                                <li class="qbutton" data-q="6" data-price="<?php echo $product->get_price(); ?>">6</li>
                                                <li class="qbutton active" data-q="10" data-price="<?php echo $product->get_price(); ?>">10</li>
                                            </ul>
                                            <p>No. of Sessions</p>
                                            <div class="sakib-tab-header-right-bottom">
                                                <div class="sakib-tab-header-right-bottom-content">
                                                    <h3>Was £<?php echo $product->get_regular_price(); ?>  </h3>
                                                    <h2><span class="main-price"><?php echo $product->get_price(); ?></span> <span>session</span></h2>
                                                </div>
                                                <?php //woocommerce_template_loop_add_to_cart(); ?>
                                                <a href="?add-to-cart=<?php echo $product->get_id(); ?>" data-quantity="1" class="cart_btn sakib-buy-btn button product_type_simple add_to_cart_button ajax_add_to_cart" data-product_id="<?php echo $product->get_id(); ?>" data-product_sku="woo-belt" aria-label="Add <?php the_title(); ?> to your cart" rel="nofollow">Buy</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php endwhile; ?>
                            <?php endif; ?>

                        <?php wp_reset_query(); ?>

                    </div>
                    <?php } ?>
                </div>
            </div> <!-- END tabs -->
        </div>
    </div>

        <?php
	}
}
$widgets_manager->register_widget_type( new \Sakib\Widgets\Elementor\Sakib_Category_Tab() );