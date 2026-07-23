<?php
/**
 * Plantilla global para WooCommerce
 * Envuelve todo el contenido de la tienda en el layout del tema "Dónde te duele"
 */
get_header(); ?>

<main style="background-color: var(--bg-cream); min-height: 100vh; padding: 80px 20px; font-family: 'Archivo', sans-serif; color: #3b2017;">
    <div style="max-width: 1200px; margin: 0 auto; width: 100%;">
        <?php woocommerce_content(); ?>
    </div>
</main>

<?php get_footer(); ?>
