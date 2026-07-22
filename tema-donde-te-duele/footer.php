    <!-- ============================================================ -->
    <!-- BLOQUE FINAL VIOLETA - Texto grande + CTA                   -->
    <!-- ============================================================ -->
    <?php if ( ! is_page_template( 'page-temporada-1.php' ) ) : ?>
    <div style="background-color:#e59bf0; height:720px; box-sizing:border-box; padding:80px 100px; display:flex; flex-direction:column; justify-content:center; align-items:center; text-align:center; border-top:1px solid #3b2017; border-bottom:1px solid #3b2017;">
        <h2 style="font-size:46px; font-weight:500; font-family:'Roboto Condensed',sans-serif; text-transform:uppercase; line-height:1.3; max-width:1100px; margin:0 auto 50px; color:#3b2017;">
            HERRAMIENTAS, REFLEXIONES<br>
            Y NUEVAS PERSPECTIVAS PARA COMPRENDER AQUELLO QUE HOY<br>
            TE GENERA CONFLICTO.<br>
            COMPRENDER ES EL PRIMER PASO PARA TU MEJOR VERSIÓN.
        </h2>
        <a href="#temporada1" class="btn-dtd">QUIERO SER PARTE</a>
    </div>
    <?php endif; ?>

    <!-- FOOTER -->
    <footer style="background-color:#fdfaf1; padding:50px 80px 30px; border-top:none;">
        <div style="display:flex; justify-content:space-between; align-items:center; padding-bottom:25px; border-bottom:1px solid #3b2017; max-width:1280px; margin:0 auto;">
            <!-- Logo izquierda -->
            <div style="display:flex; align-items:center; gap:12px;">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/marca-dtd.svg" alt="Logo" style="height:50px;">
                <span style="font-family:'Roboto Condensed',sans-serif; font-weight:700; font-size:18px; text-transform:uppercase; line-height:1.2; color:#3b2017;">DÓNDE TE DUELE<br>LA VIDA HOY</span>
            </div>
            <!-- Redes sociales derecha -->
            <div style="display:flex; align-items:center; gap:18px;">
                <a href="#"><img src="<?php echo get_template_directory_uri(); ?>/assets/icono-instagram.svg" alt="Instagram" style="height:36px; width:36px;"></a>
                <a href="#"><img src="<?php echo get_template_directory_uri(); ?>/assets/icono-facebook.svg" alt="Facebook" style="height:36px; width:36px;"></a>
                <a href="#"><img src="<?php echo get_template_directory_uri(); ?>/assets/icono-tiktok.svg" alt="TikTok" style="height:36px; width:36px;"></a>
            </div>
        </div>
        <div style="display:flex; justify-content:space-between; padding-top:20px; font-size:13px; font-family:Archivo,sans-serif; color:#3b2017; max-width:1280px; margin:0 auto;">
            <span>© <?php echo date('Y'); ?> Dónde te duele la vida hoy. All rights reserved</span>
            <span>Desing and development by NoMad</span>
        </div>
    </footer>

    <?php wp_footer(); ?>
</div> <!-- Cierra #page-wrapper -->
</body>
</html>
