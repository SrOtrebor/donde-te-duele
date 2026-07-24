<?php
/*
Template Name: Temporada 1
*/
get_header(); ?>

<style>
    .btn-temporada {
        display: inline-block;
        border: 2px solid #3b2017;
        border-radius: 10px;
        padding: 18px 40px;
        font-size: 22px;
        text-transform: uppercase;
        font-family: 'Roboto Condensed', sans-serif;
        font-weight: 700;
        letter-spacing: 0.02em;
        color: #3b2017;
        text-decoration: none;
        margin-top: 20px;
        background-color: #fdfaf1;
        transition: background 0.2s ease, color 0.2s ease;
    }
    .btn-temporada:hover {
        background: #3b2017 !important;
        color: #ffa85a !important;
    }
    
    @media (max-width: 768px) {
        .hero-title { font-size: 32px !important; }
        .hero-subtitle { font-size: 18px !important; }
        .cta-title { font-size: 28px !important; }
        .btn-temporada { font-size: 18px !important; padding: 15px 30px !important; }
    }
    
    @keyframes bounce {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(10px); }
    }
    .arrow-bounce {
        display: inline-block;
        animation: bounce 2s infinite ease-in-out;
        transition: transform 0.2s;
    }
    .arrow-bounce:hover {
        transform: scale(1.1);
    }
</style>

<main id="temporada1-page" style="width: 100%; display: flex; flex-direction: column; align-items: center; background-color: #ffe8bf;">

    <!-- HERO SECTION -->
    <section style="width:100%; background-color:var(--bg-purple); padding:80px 20px 40px; text-align:center; min-height:100vh; display:flex; align-items:center;">
        <div style="max-width:900px; margin:0 auto; width:100%;">
            <h1 class="hero-title" style="font-size:42px; text-transform:uppercase; font-family:'Archivo SemiExpanded',Archivo,sans-serif; font-weight:500; margin-bottom:20px; line-height:1.2;">
                Cuatro miradas para<br>comprender aquello que<br>hoy atraviesa tu vida.
            </h1>
            <p class="hero-subtitle" style="font-size:22px; font-family:'Archivo',sans-serif; font-weight:400; max-width:800px; margin:0 auto 40px; line-height: 1.4;">
                Una colección de contenidos online donde referentes de distintas disciplinas comparten herramientas, experiencias y nuevas perspectivas para ayudarte a comprender los conflictos que aparecen en torno al amor, el dinero, el duelo y el crecimiento personal.
            </p>
            <!-- Ícono flecha hacia abajo -->
            <div style="margin-top:20px;">
                <a href="#expositores" class="arrow-bounce" style="display:inline-block; text-decoration:none;">
                    <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="20" cy="20" r="19" stroke="#3b2017" stroke-width="2"/>
                        <path d="M12 18L20 26L28 18" stroke="#3b2017" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M20 10V26" stroke="#3b2017" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </a>
            </div>
        </div>
    </section>

    <!-- EXPOSITORES SECTION -->
    <section id="expositores" style="width:100%; background-color:#ffe8bf; text-align:center; padding:50px 20px; min-height:100vh; display:flex; flex-direction:column; justify-content:center;">
        <h2 style="font-size:28px; font-weight:500; font-family:'Archivo SemiExpanded',Archivo,sans-serif; margin-bottom:10px;">
            ¿Qué es la Temporada 1?
        </h2>
        <p style="font-size:18px; font-family:'Archivo',sans-serif; margin:0 auto 40px; max-width:600px; line-height:1.4;">
            La Temporada 1 es un ciclo de encuentros grabados por especialistas que abordan cada uno de los temas que más atraviesan tu experiencia humana.
        </p>

        <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(250px, 1fr)); gap:20px; max-width:1200px; margin:0 auto 50px; text-align:left; width:100%;">
            
            <!-- EXPOSITOR 1 (Claudio) -->
            <div>
                <div style="position:relative; width:100%; aspect-ratio:1/1; border-radius:10px; overflow:hidden; border:1px solid var(--border-color); margin-bottom:15px;">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/temporada1/DTDLVH_Elearning_HOME_img/source/claudio.png" style="width:100%; height:100%; object-fit:cover;">
                </div>
                <div>
                    <h4 style="font-size:14px; text-transform:uppercase; margin:0; color:var(--text-dark); font-family:'Archivo',sans-serif; font-weight:600;">Amor</h4>
                    <h3 style="font-size:16px; font-weight:600; font-family:'Archivo',sans-serif; margin:5px 0;">Por Claudio A. González</h3>
                    <p style="font-size:14px; margin:0; line-height:1.4; font-family:'Archivo',sans-serif; font-weight:400;">Explorá cómo los vínculos, las lealtades familiares y las dinámicas invisibles pueden influir en tu forma de amar y relacionarte.</p>
                </div>
            </div>

            <!-- EXPOSITOR 2 (Maxi) -->
            <div>
                <div style="position:relative; width:100%; aspect-ratio:1/1; border-radius:10px; overflow:hidden; border:1px solid var(--border-color); margin-bottom:15px;">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/temporada1/DTDLVH_Elearning_HOME_img/source/maxi.png" style="width:100%; height:100%; object-fit:cover;">
                </div>
                <div>
                    <h4 style="font-size:14px; text-transform:uppercase; margin:0; color:var(--text-dark); font-family:'Archivo',sans-serif; font-weight:600;">Dinero</h4>
                    <h3 style="font-size:16px; font-weight:600; font-family:'Archivo',sans-serif; margin:5px 0;">Por Maxi González</h3>
                    <p style="font-size:14px; margin:0; line-height:1.4; font-family:'Archivo',sans-serif; font-weight:400;">Una mirada sobre las creencias, historias y narrativas que condicionan tu relación con el dinero, el valor personal y la abundancia.</p>
                </div>
            </div>

            <!-- EXPOSITOR 3 (Mery) -->
            <div>
                <div style="position:relative; width:100%; aspect-ratio:1/1; border-radius:10px; overflow:hidden; border:1px solid var(--border-color); margin-bottom:15px;">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/temporada1/DTDLVH_Elearning_HOME_img/source/mery.png" style="width:100%; height:100%; object-fit:cover;">
                </div>
                <div>
                    <h4 style="font-size:14px; text-transform:uppercase; margin:0; color:var(--text-dark); font-family:'Archivo',sans-serif; font-weight:600;">Duelo</h4>
                    <h3 style="font-size:16px; font-weight:600; font-family:'Archivo',sans-serif; margin:5px 0;">Por Mery Molinero</h3>
                    <p style="font-size:14px; margin:0; line-height:1.4; font-family:'Archivo',sans-serif; font-weight:400;">Un recorrido para comprender los procesos de pérdida, cierre y transformación que atraviesan distintos momentos de la vida.</p>
                </div>
            </div>

            <!-- EXPOSITOR 4 (Cesar) -->
            <div>
                <div style="position:relative; width:100%; aspect-ratio:1/1; border-radius:10px; overflow:hidden; border:1px solid var(--border-color); margin-bottom:15px;">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/temporada1/DTDLVH_Elearning_HOME_img/source/cesar.png" style="width:100%; height:100%; object-fit:cover;">
                </div>
                <div>
                    <h4 style="font-size:14px; text-transform:uppercase; margin:0; color:var(--text-dark); font-family:'Archivo',sans-serif; font-weight:600;">Crecimiento</h4>
                    <h3 style="font-size:16px; font-weight:600; font-family:'Archivo',sans-serif; margin:5px 0;">Por César Trombino</h3>
                    <p style="font-size:14px; margin:0; line-height:1.4; font-family:'Archivo',sans-serif; font-weight:400;">Una invitación a observar los bloqueos, síntomas y aprendizajes que aparecen cuando la vida nos impulsa a evolucionar.</p>
                </div>
            </div>

        </div>
    </section>

    <!-- QUÉ TE LLEVÁS SECTION -->
    <section style="width:100%; background-color:var(--bg-orange); padding:80px 20px; text-align:center; min-height:100vh; display:flex; flex-direction:column; justify-content:center;">
        <h2 style="font-size:32px; font-weight:500; font-family:'Archivo SemiExpanded',Archivo,sans-serif; margin-bottom:50px;">
            ¿Qué te llevás?
        </h2>
        <div style="display:flex; justify-content:center; flex-wrap:wrap; gap:30px; max-width:1000px; margin:0 auto; width:100%;">
            <!-- Tarjeta 1 -->
            <div style="width: 280px; background-color:var(--bg-yellow); border:1px solid #3b2017; border-radius:5px; padding:40px 20px; display:flex; flex-direction:column; align-items:center; justify-content:center; text-align:center;">
                <!-- Icono de reloj -->
                <div style="position:relative; margin-bottom:20px; background-color:transparent; display:inline-block;">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/temporada1/DTDLVH_Elearning_HOME_icon/Group%2089.svg" alt="Tiempo" style="width:100px; height:auto; display:block;">
                    <div style="position:absolute; top:52%; left:50%; transform:translate(-50%, -50%); display:flex; flex-direction:column; align-items:center; line-height:1; width: 100%;">
                        <span style="font-size:22px; font-weight:700; font-family:'Archivo',sans-serif;">+5</span>
                        <span style="font-size:16px; font-weight:700; font-family:'Archivo',sans-serif;">HS</span>
                    </div>
                </div>
                <h3 style="font-size:18px; font-weight:700; text-transform:uppercase; margin:0; line-height:1.2; font-family:'Roboto Condensed',sans-serif;">EN CAPÍTULOS TEMÁTICOS<br>DIVIDIDOS POR BLOQUES</h3>
            </div>
            <!-- Tarjeta 2 -->
            <div style="width: 280px; background-color:var(--bg-yellow); border:1px solid #3b2017; border-radius:5px; padding:40px 20px; display:flex; flex-direction:column; align-items:center; justify-content:center; text-align:center;">
                <!-- Icono de laptop -->
                <div style="margin-bottom:20px;">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/COMPU-08%201.svg" alt="Acceso Online" style="width:100px; height:auto;">
                </div>
                <h3 style="font-size:22px; font-weight:700; text-transform:uppercase; margin:0; line-height:1.2; font-family:'Roboto Condensed',sans-serif;">ACCESO ONLINE<br>Y A TU PROPIO<br>RITMO</h3>
            </div>
        </div>
        
        <!-- Banners de Precio -->
        <div class="flex-responsive" style="display:flex; max-width:1000px; margin:40px auto 30px; border:1px solid #3b2017; border-radius:5px; overflow:hidden; width:100%;">
            <div style="flex:1; background-color:#e59bf0; padding:20px 30px; display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:10px;">
                <span style="font-size:24px; font-weight:700; text-transform:uppercase; font-family:'Roboto Condensed',sans-serif; color:#3b2017;">¡Aprovechá!</span>
                <div style="display:flex; align-items:center; gap:15px;">
                    <span style="font-size:12px; font-weight:700; text-transform:uppercase; font-family:'Roboto Condensed',sans-serif; color:#3b2017; line-height:1.1; text-align:left;">PRECIO<br>LANZAMIENTO</span>
                    <span style="font-size:48px; font-weight:800; font-family:'Roboto Condensed',sans-serif; color:#3b2017; line-height:1;">$95.000</span>
                </div>
            </div>
            <div style="flex:1; background-color:#eed9f2; padding:20px 30px; display:flex; align-items:center; justify-content:center; gap:15px; border-left:1px solid #3b2017;">
                <span style="font-size:12px; font-weight:700; text-transform:uppercase; font-family:'Roboto Condensed',sans-serif; color:#3b2017; line-height:1.1; text-align:left;">PRECIO<br>REGULAR</span>
                <div style="position:relative; display:inline-block;">
                    <span style="font-size:38px; font-weight:400; font-family:'Roboto Condensed',sans-serif; color:#3b2017; line-height:1;">$300.000</span>
                    <div style="position:absolute; top:50%; left:-5%; width:110%; height:2px; background-color:#3b2017; transform:rotate(-8deg);"></div>
                </div>
            </div>
        </div>

        <a href="https://dondeteduele.com/tickets/?postticket=clinica-online" class="btn-temporada" style="margin: 0 auto; background-color:#fdfaf1; padding: 15px 60px;">LO QUIERO</a>
    </section>

    <!-- QUÉ VAS A EXPLORAR SECTION -->
    <section style="width:100%; background-color:#ffe8bf; padding:80px 20px; text-align:center;">
        <h2 style="font-size:32px; font-weight:500; font-family:'Archivo SemiExpanded',Archivo,sans-serif; margin-bottom:10px;">
            ¿Qué vas a explorar?
        </h2>
        <p style="font-size:18px; font-family:'Archivo',sans-serif; font-weight:400; margin:0 auto 40px; max-width:700px; line-height:1.4;">
            Cada especialista aborda un tema desde su propia experiencia y enfoque, ofreciendo distintas herramientas para comprender aquello que hoy está atravesando tu vida.
        </p>
        
        <div style="text-align:left; max-width:1000px; margin:0 auto 40px; width:100%;">
            <p style="font-weight:500; font-family:'Archivo SemiExpanded',Archivo,sans-serif; font-size:22px; margin-bottom:20px;">Conocé el contenido de cada episodio</p>
            <?php
            $args = array(
                'post_type'      => 'episodio',
                'posts_per_page' => -1,
                'orderby'        => 'menu_order',
                'order'          => 'ASC'
            );
            $episodios_query = new WP_Query( $args );

            if ( $episodios_query->have_posts() ) :
                while ( $episodios_query->have_posts() ) : $episodios_query->the_post();
                    $especialista = get_post_meta( get_the_ID(), '_dtd_especialista', true );
            ?>
                    <div class="accordion-item" style="border:1px solid #3b2017; border-radius:5px; margin-bottom:15px; overflow:hidden; background-color:var(--bg-green);">
                        <div class="accordion-header" style="padding:15px 20px; font-weight:700; font-family:'Roboto Condensed',sans-serif; font-size:16px; display:flex; justify-content:space-between; align-items:center; cursor:pointer;">
                            <span><?php echo esc_html( get_the_title() ); ?> - Por <?php echo esc_html( $especialista ); ?></span>
                            <svg class="accordion-icon" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><polyline points="6 9 12 15 18 9"></polyline></svg>
                        </div>
                        <div class="accordion-body" style="display:none; background-color:var(--bg-cream); padding:30px; border-top:1px solid #3b2017;">
                            
                            <div style="display:flex; flex-direction:column; gap:20px;">
                            <?php
                            for ( $i = 0; $i <= 4; $i++ ) {
                                $b_titulo   = get_post_meta( get_the_ID(), "_dtd_bloque_{$i}_titulo", true );
                                $b_objetivo = get_post_meta( get_the_ID(), "_dtd_bloque_{$i}_objetivo", true );
                                $b_preguntas = get_post_meta( get_the_ID(), "_dtd_bloque_{$i}_preguntas", true );
                                
                                if ( ! empty( $b_titulo ) ) {
                                    ?>
                                    <div style="background-color:#ffffff; padding:20px; border:1px solid #3b2017; border-radius:8px;">
                                        <h4 style="margin:0 0 10px; font-size:16px; font-family:'Archivo SemiExpanded',Archivo,sans-serif; color:#3b2017;">
                                            <?php echo esc_html( $b_titulo ); ?>
                                        </h4>
                                        <?php if ( ! empty( $b_objetivo ) ) : ?>
                                            <p style="font-size:14px; margin:0 0 10px; line-height:1.4; font-family:'Archivo',sans-serif; color:#3b2017;">
                                                <strong>Objetivo:</strong> <?php echo esc_html( $b_objetivo ); ?>
                                            </p>
                                        <?php endif; ?>
                                        <?php if ( ! empty( $b_preguntas ) ) : ?>
                                            <p style="font-size:14px; margin:0; line-height:1.4; font-family:'Archivo',sans-serif; color:#3b2017;">
                                                <strong>Preguntas guía:</strong><br>
                                                <?php echo nl2br( esc_html( $b_preguntas ) ); ?>
                                            </p>
                                        <?php endif; ?>
                                    </div>
                                    <?php
                                }
                            }
                            ?>
                            </div>

                        </div>
                    </div>
            <?php
                endwhile;
                wp_reset_postdata();
            else :
            ?>
                <p style="font-family:'Archivo',sans-serif; color:#3b2017;">Próximamente más episodios...</p>
            <?php
            endif;
            ?>

        </div>

        <a href="https://dondeteduele.com/tickets/?postticket=clinica-online" class="btn-temporada" style="margin: 0 auto;">ACCEDÉ A LA TEMPORADA</a>
    </section>

    <!-- CTA SECTION -->
    <section style="width:100%; background-color:var(--bg-purple); padding:100px 20px; text-align:center; min-height:100vh; display:flex; flex-direction:column; justify-content:center; align-items:center;">
        <h2 class="cta-title" style="font-size:46px; text-transform:uppercase; font-weight:500; font-family:'Archivo SemiExpanded',Archivo,sans-serif; max-width:1000px; margin:0 auto 40px; line-height:1.2;">
            COMPRENDER LO QUE TE PASA PUEDE CAMBIAR LA FORMA EN QUE LO VIVÍS.
        </h2>
        <a href="https://dondeteduele.com/tickets/?postticket=clinica-online" class="btn-temporada">¡MIRALA AHORA!</a>
    </section>

    <!-- FAQ SECTION -->
    <section style="width:100%; background-color:#fdfaf1; padding:80px 20px;">
        <div style="max-width:800px; margin:0 auto;">
            <h2 style="font-size:32px; font-weight:500; font-family:'Archivo SemiExpanded',Archivo,sans-serif; text-align:center; margin-bottom:40px;">FAQ</h2>
            
            <div style="display:flex; flex-direction:column; gap:15px;">
            
            <div class="accordion-item" style="border:1px solid #3b2017; border-radius:5px; overflow:hidden; background-color:var(--bg-green);">
                <div class="accordion-header" style="padding:15px 20px; font-family:'Roboto Condensed',sans-serif; font-weight:700; font-size:14px; text-transform:uppercase; display:flex; justify-content:space-between; align-items:center; cursor:pointer;">
                    <span>¿CÓMO ACCEDO AL CONTENIDO?</span>
                    <svg class="accordion-icon" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><polyline points="6 9 12 15 18 9"></polyline></svg>
                </div>
                <div class="accordion-body" style="display:none; background-color:var(--bg-cream); padding:20px; border-top:1px solid #3b2017; font-family:'Archivo',sans-serif; font-weight:400; font-size:16px; line-height:1.4;">
                    Una vez realizada la compra recibirás un correo con tus datos de acceso. Desde ese momento podrás ingresar a la plataforma cuando quieras y avanzar a tu propio ritmo.
                </div>
            </div>

            <div class="accordion-item" style="border:1px solid #3b2017; border-radius:5px; overflow:hidden; background-color:var(--bg-green);">
                <div class="accordion-header" style="padding:15px 20px; font-family:'Roboto Condensed',sans-serif; font-weight:700; font-size:14px; text-transform:uppercase; display:flex; justify-content:space-between; align-items:center; cursor:pointer;">
                    <span>¿DURANTE CUÁNTO TIEMPO TENDRÉ ACCESO?</span>
                    <svg class="accordion-icon" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><polyline points="6 9 12 15 18 9"></polyline></svg>
                </div>
                <div class="accordion-body" style="display:none; background-color:var(--bg-cream); padding:20px; border-top:1px solid #3b2017; font-family:'Archivo',sans-serif; font-weight:400; font-size:16px; line-height:1.4;">
                    La compra incluye acceso a la Temporada 1 para que puedas volver a verla siempre que lo necesites. (Si luego definen otro plazo se modifica).
                </div>
            </div>

            <div class="accordion-item" style="border:1px solid #3b2017; border-radius:5px; overflow:hidden; background-color:var(--bg-green);">
                <div class="accordion-header" style="padding:15px 20px; font-family:'Roboto Condensed',sans-serif; font-weight:700; font-size:14px; text-transform:uppercase; display:flex; justify-content:space-between; align-items:center; cursor:pointer;">
                    <span>¿NECESITO CONOCIMIENTOS PREVIOS?</span>
                    <svg class="accordion-icon" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><polyline points="6 9 12 15 18 9"></polyline></svg>
                </div>
                <div class="accordion-body" style="display:none; background-color:var(--bg-cream); padding:20px; border-top:1px solid #3b2017; font-family:'Archivo',sans-serif; font-weight:400; font-size:16px; line-height:1.4;">
                    No. Los contenidos están pensados para cualquier persona interesada en comprender mejor su historia personal y explorar nuevas herramientas para su bienestar.
                </div>
            </div>

            <div class="accordion-item" style="border:1px solid #3b2017; border-radius:5px; overflow:hidden; background-color:var(--bg-green);">
                <div class="accordion-header" style="padding:15px 20px; font-family:'Roboto Condensed',sans-serif; font-weight:700; font-size:14px; text-transform:uppercase; display:flex; justify-content:space-between; align-items:center; cursor:pointer;">
                    <span>¿LOS EPISODIOS DEBEN VERSE EN ORDEN?</span>
                    <svg class="accordion-icon" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><polyline points="6 9 12 15 18 9"></polyline></svg>
                </div>
                <div class="accordion-body" style="display:none; background-color:var(--bg-cream); padding:20px; border-top:1px solid #3b2017; font-family:'Archivo',sans-serif; font-weight:400; font-size:16px; line-height:1.4;">
                    Podés recorrerlos como prefieras. Cada episodio aborda un tema diferente y funciona de manera independiente, aunque juntos ofrecen una mirada más amplia sobre distintos aspectos de la vida.
                </div>
            </div>

            <div class="accordion-item" style="border:1px solid #3b2017; border-radius:5px; overflow:hidden; background-color:var(--bg-green);">
                <div class="accordion-header" style="padding:15px 20px; font-family:'Roboto Condensed',sans-serif; font-weight:700; font-size:14px; text-transform:uppercase; display:flex; justify-content:space-between; align-items:center; cursor:pointer;">
                    <span>¿INCLUYE MATERIAL COMPLEMENTARIO?</span>
                    <svg class="accordion-icon" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><polyline points="6 9 12 15 18 9"></polyline></svg>
                </div>
                <div class="accordion-body" style="display:none; background-color:var(--bg-cream); padding:20px; border-top:1px solid #3b2017; font-family:'Archivo',sans-serif; font-weight:400; font-size:16px; line-height:1.4;">
                    Sí. Cada episodio cuenta con un material descargable que te permitirá profundizar los conceptos y llevar las reflexiones a tu vida cotidiana.
                </div>
            </div>

            <div class="accordion-item" style="border:1px solid #3b2017; border-radius:5px; overflow:hidden; background-color:var(--bg-green);">
                <div class="accordion-header" style="padding:15px 20px; font-family:'Roboto Condensed',sans-serif; font-weight:700; font-size:14px; text-transform:uppercase; display:flex; justify-content:space-between; align-items:center; cursor:pointer;">
                    <span>¿QUÉ TEMAS INCLUYE ESTA TEMPORADA?</span>
                    <svg class="accordion-icon" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><polyline points="6 9 12 15 18 9"></polyline></svg>
                </div>
                <div class="accordion-body" style="display:none; background-color:var(--bg-cream); padding:20px; border-top:1px solid #3b2017; font-family:'Archivo',sans-serif; font-weight:400; font-size:16px; line-height:1.4;">
                    La Temporada 1 aborda cuatro grandes ejes: el amor, el dinero, el duelo y el crecimiento personal, desarrollados por Claudio Alberto González, Maxi González, Mery Molinero y César Trombino.
                </div>
            </div>

            </div>
        </div>
    </section>

</main>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const accordions = document.querySelectorAll('.accordion-header');
    accordions.forEach(acc => {
        acc.addEventListener('click', function() {
            const body = this.nextElementSibling;
            const icon = this.querySelector('.accordion-icon');
            if (body.style.display === "none" || body.style.display === "") {
                body.style.display = "flex";
                if(icon) icon.innerHTML = '<polyline points="18 15 12 9 6 15"></polyline>';
            } else {
                body.style.display = "none";
                if(icon) icon.innerHTML = '<polyline points="6 9 12 15 18 9"></polyline>';
            }
        });
    });
});
</script>

<?php get_footer(); ?>
