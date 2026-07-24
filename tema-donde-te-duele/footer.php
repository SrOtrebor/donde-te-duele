    <!-- ============================================================ -->
    <!-- BLOQUE FINAL VIOLETA - Texto grande + CTA                   -->
    <!-- ============================================================ -->
    <?php 
    global $post;
    $is_aula = is_a($post, 'WP_Post') && has_shortcode($post->post_content, 'grilla_episodios');
    if ( ! is_page_template( 'page-temporada-1.php' ) && ! $is_aula ) : 
    ?>
    <div style="background-color:#e59bf0; height:720px; box-sizing:border-box; padding:80px 100px; display:flex; flex-direction:column; justify-content:center; align-items:center; text-align:center;">
        <h2 style="font-size:46px; font-weight:500; font-family:'Archivo SemiExpanded',Archivo,sans-serif; text-transform:uppercase; line-height:1.3; max-width:1100px; margin:0 auto 50px; color:#3b2017;">
            HERRAMIENTAS, REFLEXIONES<br>
            Y NUEVAS PERSPECTIVAS PARA COMPRENDER AQUELLO QUE HOY<br>
            TE GENERA CONFLICTO.<br>
            COMPRENDER ES EL PRIMER PASO PARA TU MEJOR VERSIÓN.
        </h2>
        <a href="https://dondeteduele.com/tickets/?postticket=clinica-online" class="btn-dtd">QUIERO SER PARTE</a>
    </div>
    <?php endif; ?>

    <!-- FOOTER -->
    <footer style="background-color:#fdfaf1; padding:50px 80px 30px; border-top:none;" class="seccion-dtd">
        <div style="display:flex; justify-content:space-between; align-items:center; padding-bottom:25px; border-bottom:1px solid #3b2017; max-width:1280px; margin:0 auto;" class="footer-top-responsive">
            <!-- Logo izquierda -->
            <div style="display:flex; align-items:center;">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/logofooter.png" alt="Logo Dónde te duele la vida hoy" style="height:45px; width:auto;">
            </div>
            <!-- Redes sociales derecha -->
            <div style="display:flex; align-items:center; gap:18px;">
                <a href="https://www.instagram.com/dondeteduele.hoy/" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/assets/DTDLVH_Elearning_HOME_icon/ICONOS%20RRSS%20%5BConvertido%5D_ig%201.svg" alt="Instagram" style="height:36px; width:36px;"></a>
                <a href="https://www.facebook.com/profile.php?id=61589366597840&mibextid=wwXIfr&rdid=ywRNQsJoz1SqM7Qs&share_url=https%3A%2F%2Fwww.facebook.com%2Fshare%2F1KzpBNVzv6%2F%3Fmibextid%3DwwXIfr#" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/assets/DTDLVH_Elearning_HOME_icon/ICONOS%20RRSS%20%5BConvertido%5D_fb%201.svg" alt="Facebook" style="height:36px; width:36px;"></a>
                <a href="https://www.tiktok.com/@dondeteduele.hoy?_r=1&_t=ZS-96YLKmFL88z" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/assets/DTDLVH_Elearning_HOME_icon/ICONOS%20RRSS%20%5BConvertido%5D_tik%20tok%201.svg" alt="TikTok" style="height:36px; width:36px;"></a>
            </div>
        </div>
        <div style="display:flex; justify-content:space-between; padding-top:20px; font-size:13px; font-family:Archivo,sans-serif; color:#3b2017; max-width:1280px; margin:0 auto;" class="footer-bottom-responsive">
            <span>© <?php echo date('Y'); ?> Dónde te duele la vida hoy. All rights reserved</span>
            <span>Design and development by <a href="https://wearenomad.studio/" target="_blank" style="color:inherit; text-decoration:none; font-weight:bold;">NoMad</a></span>
        </div>
    </footer>

    <?php wp_footer(); ?>
</div> <!-- Cierra #page-wrapper -->
</body>
</html>
