<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 8.6.0
 */

defined( 'ABSPATH' ) || exit;

get_header( 'shop' ); ?>

<main id="primary" class="site-main">
    <div class="container" style="padding-top: var(--spacing-xl);">
        
        <div class="breadcrumb">
            <a href="<?php echo esc_url( home_url() ); ?>">Home</a> &rarr; <?php woocommerce_page_title(); ?>
        </div>

        <?php if ( apply_filters( 'woocommerce_show_page_title', true ) ) : ?>
            <h1 class="woocommerce-products-header__title page-title text-title" style="margin-bottom: 20px; display: none;"><?php woocommerce_page_title(); ?></h1>
        <?php endif; ?>

        <?php
        if ( woocommerce_product_loop() ) {
            woocommerce_product_loop_start();

            if ( wc_get_loop_prop( 'total' ) ) {
                while ( have_posts() ) {
                    the_post();

                    /**
                     * Hook: woocommerce_shop_loop.
                     */
                    do_action( 'woocommerce_shop_loop' );

                    wc_get_template_part( 'content', 'product' );
                }
            }

            woocommerce_product_loop_end();

            /**
             * Hook: woocommerce_after_shop_loop.
             */
            do_action( 'woocommerce_after_shop_loop' );
        } else {
            /**
             * Hook: woocommerce_no_products_found.
             */
            do_action( 'woocommerce_no_products_found' );
        }
        ?>

    </div>
</main>

<?php get_footer( 'shop' ); ?>
