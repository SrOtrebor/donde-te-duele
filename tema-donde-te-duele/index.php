<?php
/**
 * Archivo principal requerido por WordPress
 */
get_header(); ?>

<main id="primary" class="site-main" style="background-color: #fdfaf1; min-height: 100vh; padding: 40px 20px; font-family: 'Archivo', sans-serif;">
    <?php
    if ( have_posts() ) :
        while ( have_posts() ) :
            the_post();
            the_content();
        endwhile;
    else :
        echo '<p>No se encontró contenido.</p>';
    endif;
    ?>
</main><!-- #main -->

<?php
get_footer();
