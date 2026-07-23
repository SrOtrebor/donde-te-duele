<?php
/**
 * Plantilla de la página de inicio (Landing Page) - Pixel-perfect Figma
 */
get_header(); ?>

<style>
@import url('https://fonts.googleapis.com/css2?family=Roboto+Condensed:wght@400;700&display=swap');
/* === HOVER DE BOTONES === */
.btn-dtd {
    display: inline-block;
    background: #ffe8bf;
    border: 2px solid #3b2017;
    border-radius: 10px;
    padding: 18px 40px;
    font-size: 22px;
    font-weight: 700;
    text-transform: uppercase;
    color: #3b2017;
    text-decoration: none;
    letter-spacing: 0.02em;
    font-family: 'Roboto Condensed', sans-serif;
    cursor: pointer;
    transition: background 0.2s ease, color 0.2s ease;
}
.btn-dtd:hover {
    background: #3b2017 !important;
    color: #ffa85a !important;
}
/* === TARJETAS "ESTO ES PARA VOS" hover === */
.card-para-vos {
    transition: transform 0.18s ease, box-shadow 0.18s ease;
    cursor: default;
}
.card-para-vos:hover {
    transform: translateY(-4px);
    box-shadow: 4px 4px 0px #3b2017;
}
</style>

<main class="landing-page" style="font-family: 'Roboto Condensed', sans-serif; color: #3b2017; background-color: #fdfaf1; width: 100%; overflow-x: hidden;">

    <!-- HERO SECTION: Grid exacto según mapa de íconos -->
    <!-- ============================================================ -->
    <?php
    $ico = get_template_directory_uri() . '/assets/DTDLVH_Elearning_HOME_icon/';
    function hero_cell($file, $ico, $extraClass = '') {
        if (empty($file)) {
            return '<div class="hcell ' . $extraClass . '"></div>';
        }
        $src = $ico . rawurlencode($file);
        return '<div class="hcell ' . $extraClass . '"><img src="' . $src . '" alt="' . esc_attr($file) . '"></div>';
    }
    ?>
    <style>
    #hero-section {
        width: 100%;
        background: #fdfaf1;
        border-top: 1px solid #3b2017;
        border-bottom: 1px solid #3b2017;
    }
    .hero-inner {
        display: flex;
        width: 100%;
        margin: 0 auto;
    }
    .hero-side {
        width: 16%;
        min-width: 140px;
        flex-shrink: 0;
        display: grid;
        grid-template-columns: 1fr 1fr;
        background-color: #3b2017;
        gap: 0;
    }
    .hero-side.left {
        /* Bordes eliminados a pedido del usuario */
    }
    .hero-side.right {
        /* Bordes eliminados a pedido del usuario */
    }
    .hcell {
        background: #fdfaf1; /* Fondo crema para que los semicírculos no se vean marrones */
        border-radius: 12px; /* Redondeamos las esquinas para generar los "huecos" marrones en las uniones */
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        aspect-ratio: 1 / 1;
    }
    .hcell.no-radius {
        border-radius: 0;
    }
    .hcell img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }
    /* Group-8 izquierda abarca fila 4-5, col 1-2 */
    .hcell-span2x2 {
        grid-column: 1 / 3;
        grid-row: 4 / 6;
        aspect-ratio: auto;
    }
    #hero-center-area {
        flex: 1;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-align: center;
        padding: 0 4%;
        background: #fdfaf1;
    }
    </style>

    <section id="hero-section">
        <div class="hero-inner">

        <!-- COLUMNA IZQUIERDA: 2×5 grid -->
        <div class="hero-side left">
            <?php echo hero_cell('Group-14.svg',  $ico); ?>
            <?php echo hero_cell('Vector-21.svg', $ico); ?>
            <?php echo hero_cell('Vector-21.svg', $ico); ?>
            <?php echo hero_cell('Group-12.svg',  $ico); ?>
            <?php echo hero_cell('Vector-21.svg', $ico); ?>
            <?php echo hero_cell('Vector-21.svg', $ico); ?>
            <?php echo hero_cell('Vector-2.svg',  $ico, 'no-radius'); ?>
            <?php echo hero_cell('Vector-2.svg',  $ico, 'no-radius'); ?>
            <?php echo hero_cell('Vector-1.svg',  $ico, 'no-radius'); ?>
            <?php echo hero_cell('Vector-1.svg',  $ico, 'no-radius'); ?>
        </div>

        <!-- CENTRO -->
        <div id="hero-center-area">
            <p style="font-size:18px; font-weight:700; letter-spacing:0.1em; text-transform:uppercase; margin:0 0 6px; color:#3b2017; font-family:'Roboto Condensed',sans-serif;">CLÍNICA ONLINE</p>
            <h1 style="font-size:clamp(30px,4vw,62px); font-weight:700; line-height:1.05; text-transform:uppercase; margin:0 0 22px; color:#3b2017; font-family:'Roboto Condensed',sans-serif;">DÓNDE TE DUELE<br>LA VIDA HOY</h1>
            <a href="#temporada1" class="btn-dtd" style="font-size:16px; padding:12px 28px;">VER DE QUÉ SE TRATA</a>
        </div>

        <!-- COLUMNA DERECHA: 2×5 grid -->
        <div class="hero-side right">
            <?php echo hero_cell('Group-13.svg',  $ico); ?>
            <?php echo hero_cell('Vector-21.svg', $ico); ?>
            <?php echo hero_cell('Vector-21.svg', $ico); ?>
            <?php echo hero_cell('Group-11.svg',  $ico); ?>
            <?php echo hero_cell('Vector-21.svg', $ico); ?>
            <?php echo hero_cell('Group-8.svg',   $ico); ?>
            <?php echo hero_cell('Vector-21.svg', $ico); ?>
            <?php echo hero_cell('Vector-21.svg', $ico); ?>
            <?php echo hero_cell('Group-6.svg',   $ico); ?>
            <?php echo hero_cell('Vector-21.svg', $ico); ?>
        </div>

        </div>
    </section>

    <!-- ============================================================ -->
    <!-- SECCIÓN AMARILLA - La Clínica Online                         -->
    <!-- ============================================================ -->
    <section style="background-color:#fffa64; padding:70px 100px; min-height:100vh; display:flex; align-items:center;">
        <div class="flex-responsive" style="display:flex; align-items:center; gap:60px; max-width:1200px; margin:0 auto; width:100%;">
            <div style="flex:1.2; text-align:left;">
                <p style="font-size:28px; line-height:1.5; font-family:Archivo, sans-serif; margin:0 0 30px; color:#3b2017;">
                    La <strong>Clínica Online</strong> reúne distintas miradas sobre los conflictos que atraviesan la vida cotidiana para <strong>ayudarte a comprender su origen y abrir nuevas posibilidades de transformación.</strong>
                </p>
                <p style="font-size:20px; font-family:Archivo,sans-serif; margin:0 0 15px; color:#3b2017;">Encontrarás:</p>
                <div style="display:flex; align-items:flex-start; gap:12px; margin-bottom:14px;">
                    <div style="background:#fdfaf1; border-radius:6px; padding:6px; min-width:36px; text-align:center; font-size:18px;">💬</div>
                    <span style="font-size:18px; font-family:Archivo,sans-serif; color:#3b2017; padding-top:4px;">Conversaciones.</span>
                </div>
                <div style="display:flex; align-items:flex-start; gap:12px; margin-bottom:30px;">
                    <div style="background:#fdfaf1; border-radius:6px; padding:6px; min-width:36px; text-align:center; font-size:18px;">📝</div>
                    <span style="font-size:18px; font-family:Archivo,sans-serif; color:#3b2017; padding-top:4px;">Herramientas y recursos desarrollados por profesionales con diferentes enfoques.</span>
                </div>
                <p style="font-size:22px; font-family:Archivo,sans-serif; font-weight:700; margin:0; color:#3b2017;">Para profundizar en tu proceso personal cuando vos lo necesites.</p>
            </div>
            <!-- Ilustración de plataforma/reunión online -->
            <div style="flex:1; display:flex; justify-content:center;">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/Group%20117.svg" alt="Plataforma online" style="max-width:100%; height:auto; max-height:420px;">
            </div>
        </div>
    </section>

    <!-- ============================================================ -->
    <!-- SECCIÓN VIOLETA - Temporada 1                                -->
    <!-- ============================================================ -->
    <section id="temporada1" style="background-color:#e59bf0; padding:70px 100px; min-height:100vh; display:flex; align-items:center;">
        <div class="flex-responsive" style="display:flex; align-items:flex-start; gap:60px; max-width:1200px; margin:0 auto; width:100%;">
            <div style="flex:1; text-align:left;">
                <!-- Badge "TEMPORADA 1" = Frame 262 SVG -->
                <div style="margin-bottom:20px;">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/Frame 262.svg" alt="Temporada 1 - Ya disponible" style="height:42px; width:auto;">
                </div>
                <h2 style="font-size:36px; font-weight:500; font-family:'Archivo SemiExpanded',Archivo,sans-serif; margin:0 0 20px; line-height:1.25; color:#3b2017;">Para mirar en profundidad<br>la experiencia humana</h2>
                <p style="font-size:19px; font-family:Archivo,sans-serif; line-height:1.5; margin:0 0 35px; color:#3b2017;">Vas a descubrir nuevas formas de comprender, transitar y transformar los desafíos que suelen aparecer en torno a algunos temas que nos atraviesan.</p>
                <!-- Botón "QUIERO SER PARTE" -->
                <a href="<?php echo home_url('/temporada-1/'); ?>" class="btn-dtd">QUIERO SER PARTE</a>
            </div>
            <!-- 4 episodios -->
            <div style="flex:1; display:flex; flex-direction:column; gap:14px;">
                <div style="background:#ffa872; border:2px solid #3b2017; border-radius:10px; padding:18px 25px; display:flex; align-items:center; gap:15px;">
                    <span style="font-size:28px; line-height:1;">🩷</span>
                    <span style="font-size:24px; font-weight:700; text-transform:uppercase; color:#3b2017;">AMOR</span>
                </div>
                <div style="background:#ffa872; border:2px solid #3b2017; border-radius:10px; padding:18px 25px; display:flex; align-items:center; gap:15px;">
                    <span style="font-size:28px; line-height:1;">💼</span>
                    <span style="font-size:24px; font-weight:700; text-transform:uppercase; color:#3b2017;">TRABAJO</span>
                </div>
                <div style="background:#ffa872; border:2px solid #3b2017; border-radius:10px; padding:18px 25px; display:flex; align-items:center; gap:15px;">
                    <span style="font-size:28px; line-height:1;">❤️‍🩹</span>
                    <span style="font-size:24px; font-weight:700; text-transform:uppercase; color:#3b2017;">DUELO</span>
                </div>
                <div style="background:#ffa872; border:2px solid #3b2017; border-radius:10px; padding:18px 25px; display:flex; align-items:center; gap:15px;">
                    <span style="font-size:28px; line-height:1;">🌟</span>
                    <span style="font-size:24px; font-weight:700; text-transform:uppercase; color:#3b2017;">CRECIMIENTO PERSONAL</span>
                </div>
            </div>
        </div>
    </section>

    <!-- ============================================================ -->
    <!-- SECCIÓN NARANJA - ¿Qué vas a recibir? (tarjetas SVG)        -->
    <!-- ============================================================ -->
    <section style="background-color:#ffa872; padding:70px 100px; min-height:100vh; display:flex; flex-direction:column; justify-content:center;">
        <h2 style="text-align:center; font-size:36px; font-weight:500; font-family:'Archivo SemiExpanded',Archivo,sans-serif; margin:0 0 50px; color:#3b2017;">¿Qué vas a recibir?</h2>
        <!-- Usamos los SVG completos de Figma que ya incluyen fondo + ícono + texto -->
        <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(280px, 1fr)); gap:30px; max-width:1200px; margin:0 auto; width:100%;">
            <!-- Tarjeta 1 -->
            <div style="background:#fffa64; border:2px solid #3b2017; border-radius:10px; padding:40px 30px; text-align:center; display:flex; flex-direction:column; align-items:center; justify-content:center; height:465px; box-sizing:border-box;">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/DTDLVH_Elearning_HOME_icon/Group%2019.svg" alt="Icono" style="height:60px; margin-bottom:20px;">
                <h3 style="font-size:24px; font-weight:700; font-family:'Roboto Condensed',sans-serif; color:#3b2017; text-transform:uppercase; margin:0 0 15px; line-height:1.2;">CONVERSACIONES<br>CON REFERENTES<br>DEL BIENESTAR</h3>
                <p style="font-size:18px; font-family:Archivo,sans-serif; color:#3b2017; margin:0; line-height:1.4;">Distintas disciplinas para<br>ampliar tu mirada.</p>
            </div>
            <!-- Tarjeta 2 -->
            <div style="background:#fffa64; border:2px solid #3b2017; border-radius:10px; padding:40px 30px; text-align:center; display:flex; flex-direction:column; align-items:center; justify-content:center; height:465px; box-sizing:border-box;">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/DTDLVH_Elearning_HOME_icon/Group%2035.svg" alt="Icono" style="height:60px; margin-bottom:20px;">
                <h3 style="font-size:24px; font-weight:700; font-family:'Roboto Condensed',sans-serif; color:#3b2017; text-transform:uppercase; margin:0 0 15px; line-height:1.2;">HERRAMIENTAS<br>PARA TU VIDA<br>COTIDIANA</h3>
                <p style="font-size:18px; font-family:Archivo,sans-serif; color:#3b2017; margin:0; line-height:1.4;">Ejercicios, recursos y<br>materiales para seguir<br>profundizando.</p>
            </div>
            <!-- Tarjeta 3 -->
            <div style="background:#fffa64; border:2px solid #3b2017; border-radius:10px; padding:40px 30px; text-align:center; display:flex; flex-direction:column; align-items:center; justify-content:center; height:465px; box-sizing:border-box;">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/DTDLVH_Elearning_HOME_icon/COMPU-08%201.svg" alt="Icono" style="height:60px; margin-bottom:20px;">
                <h3 style="font-size:24px; font-weight:700; font-family:'Roboto Condensed',sans-serif; color:#3b2017; text-transform:uppercase; margin:0 0 15px; line-height:1.2;">ACCESO ONLINE<br>Y A TU PROPIO<br>RITMO</h3>
                <p style="font-size:18px; font-family:Archivo,sans-serif; color:#3b2017; margin:0; line-height:1.4;">Disponible cuando quieras,<br>desde cualquier lugar.</p>
            </div>
        </div>
    </section>

    <!-- ============================================================ -->
    <!-- SECCIÓN CREMA - Esto es para vos (tarjetas SVG completas)   -->
    <!-- ============================================================ -->
    <section style="background-color:#fdfaf1; padding:70px 100px; min-height:100vh; display:flex; flex-direction:column; justify-content:center;">
        <h2 style="text-align:center; font-size:36px; font-weight:500; font-family:'Archivo SemiExpanded',Archivo,sans-serif; margin:0 0 50px; color:#3b2017;">Esto es para vos</h2>
        <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(300px, 1fr)); gap:20px; max-width:1200px; margin:0 auto; width:100%;">
            <!-- Tarjeta 1 -->
            <div class="card-para-vos" style="background-color: #e59bf0; border: 2px solid #3b2017; border-radius: 10px; display: flex; flex-direction: column; align-items: center; justify-content: center; height: 180px; text-align: center; padding: 20px;">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/emojis/4.png" alt="Emoji" style="height: 45px; margin-bottom: 15px;">
                <h3 style="font-size: 18px; font-weight: 700; font-family: 'Roboto Condensed', sans-serif; color: #3b2017; margin: 0; text-transform: uppercase; line-height: 1.2;">SI QUERÉS<br>PROFUNDIZAR</h3>
            </div>
            <!-- Tarjeta 2 -->
            <div class="card-para-vos" style="background-color: #ffa872; border: 2px solid #3b2017; border-radius: 10px; display: flex; flex-direction: column; align-items: center; justify-content: center; height: 180px; text-align: center; padding: 20px;">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/emojis/6.png" alt="Emoji" style="height: 45px; margin-bottom: 15px;">
                <h3 style="font-size: 18px; font-weight: 700; font-family: 'Roboto Condensed', sans-serif; color: #3b2017; margin: 0; text-transform: uppercase; line-height: 1.2;">SI BUSCAS<br>RED REAL</h3>
            </div>
            <!-- Tarjeta 3 -->
            <div class="card-para-vos" style="background-color: #bfd43b; border: 2px solid #3b2017; border-radius: 10px; display: flex; flex-direction: column; align-items: center; justify-content: center; height: 180px; text-align: center; padding: 20px;">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/emojis/3.png" alt="Emoji" style="height: 45px; margin-bottom: 15px;">
                <h3 style="font-size: 18px; font-weight: 700; font-family: 'Roboto Condensed', sans-serif; color: #3b2017; margin: 0; text-transform: uppercase; line-height: 1.2;">SI QUERÉS PRÁCTICA,<br>NO TEORÍA</h3>
            </div>
            <!-- Tarjeta 4 -->
            <div class="card-para-vos" style="background-color: #ffa872; border: 2px solid #3b2017; border-radius: 10px; display: flex; flex-direction: column; align-items: center; justify-content: center; height: 180px; text-align: center; padding: 20px;">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/emojis/5.png" alt="Emoji" style="height: 45px; margin-bottom: 15px;">
                <h3 style="font-size: 18px; font-weight: 700; font-family: 'Roboto Condensed', sans-serif; color: #3b2017; margin: 0; text-transform: uppercase; line-height: 1.2;">SI SENTÍS QUE ALGO<br>SE REPITE</h3>
            </div>
            <!-- Tarjeta 5 -->
            <div class="card-para-vos" style="background-color: #bfd43b; border: 2px solid #3b2017; border-radius: 10px; display: flex; flex-direction: column; align-items: center; justify-content: center; height: 180px; text-align: center; padding: 20px;">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/emojis/1.png" alt="Emoji" style="height: 45px; margin-bottom: 15px;">
                <h3 style="font-size: 18px; font-weight: 700; font-family: 'Roboto Condensed', sans-serif; color: #3b2017; margin: 0; text-transform: uppercase; line-height: 1.2;">SI YA PROBASTE<br>Y NO FUNCIONÓ</h3>
            </div>
            <!-- Tarjeta 6 -->
            <div class="card-para-vos" style="background-color: #e59bf0; border: 2px solid #3b2017; border-radius: 10px; display: flex; flex-direction: column; align-items: center; justify-content: center; height: 180px; text-align: center; padding: 20px;">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/emojis/emoji-claridad.png" alt="Emoji" style="height: 45px; margin-bottom: 15px;">
                <h3 style="font-size: 18px; font-weight: 700; font-family: 'Roboto Condensed', sans-serif; color: #3b2017; margin: 0; text-transform: uppercase; line-height: 1.2;">SI QUERÉS<br>CLARIDAD REAL</h3>
            </div>
        </div>
    </section>

</main>

<?php get_footer(); ?>
