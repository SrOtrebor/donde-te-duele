<?php
/**
 * The template for displaying product content within loops
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.6.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

// Ensure visibility.
if ( empty( $product ) || ! $product->is_visible() ) {
    return;
}

$cuotas_texto = get_field('producto_cuotas_texto', $product->get_id());
$precio_transferencia = get_field('producto_precio_transferencia', $product->get_id());

// Fallback for packs if no ACF fields are set
if ( (empty($cuotas_texto) || empty($precio_transferencia)) && has_term('packs-cursos', 'product_cat', $product->get_id()) ) {
    $price_val = $product->get_price();
    if ($price_val) {
        if (empty($cuotas_texto)) {
            $cuota = $price_val / 2;
            $cuotas_texto = '2 cuotas sin interés de ' . wc_price($cuota);
        }
        if (empty($precio_transferencia)) {
            $transfer = $price_val * 0.90;
            $precio_transferencia = wc_price($transfer) . ' con transferencia';
        }
    }
}
?>
<div <?php wc_product_class( 'product-card', $product ); ?>>
    <a href="<?php echo esc_url( $product->get_permalink() ); ?>" style="text-decoration: none; color: inherit; display: block;">
        
        <div class="product-image">
            <?php 
            /**
             * Hook: woocommerce_before_shop_loop_item_title.
             *
             * @hooked woocommerce_show_product_loop_sale_flash - 10
             * @hooked woocommerce_template_loop_product_thumbnail - 10
             */
            do_action( 'woocommerce_before_shop_loop_item_title' ); 
            ?>
        </div>
        
        <h3 class="product-title"><?php echo esc_html( get_the_title() ); ?></h3>
        
        <div class="product-price">
            <?php echo $product->get_price_html(); ?>
        </div>

        <?php if ( $cuotas_texto ) : ?>
            <div class="product-installments"><?php echo wp_kses_post($cuotas_texto); ?></div>
        <?php endif; ?>

        <?php if ( $precio_transferencia ) : ?>
            <div class="product-divider"></div>
            <div class="product-transfer"><?php echo wp_kses_post($precio_transferencia); ?></div>
        <?php endif; ?>

    </a>
    
    <?php
    /**
     * Hook: woocommerce_after_shop_loop_item.
     *
     * @hooked woocommerce_template_loop_product_link_close - 5
     * @hooked woocommerce_template_loop_add_to_cart - 10
     */
    do_action( 'woocommerce_after_shop_loop_item' );
    ?>
</div>
