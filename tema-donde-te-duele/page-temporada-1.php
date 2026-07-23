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
</style>

<main id="temporada1-page" style="width: 100%; display: flex; flex-direction: column; align-items: center; background-color: #ffe8bf;">

    <!-- HERO SECTION -->
    <section style="width:100%; background-color:var(--bg-purple); padding:80px 20px 40px; text-align:center; min-height:100vh; display:flex; align-items:center;">
        <div style="max-width:900px; margin:0 auto; width:100%;">
            <h1 style="font-size:42px; text-transform:uppercase; font-family:'Archivo SemiExpanded',Archivo,sans-serif; font-weight:500; margin-bottom:20px; line-height:1.2;">
                Cuatro miradas para<br>comprender aquello que<br>hoy atraviesa tu vida.
            </h1>
            <p style="font-size:22px; font-family:'Archivo',sans-serif; font-weight:400; max-width:800px; margin:0 auto 40px;">
                Una colección de contenidos online donde referentes de distintas disciplinas comparten herramientas, experiencias y nuevas perspectivas para ayudarte a comprender los conflictos que aparecen en torno al amor, el dinero, el duelo y el crecimiento personal.
            </p>
            <!-- Ícono flecha hacia abajo -->
            <div style="margin-top:20px;">
                <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="20" cy="20" r="19" stroke="#3b2017" stroke-width="2"/>
                    <path d="M12 18L20 26L28 18" stroke="#3b2017" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M20 10V26" stroke="#3b2017" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>
        </div>
    </section>

    <!-- EXPOSITORES SECTION -->
    <section style="width:100%; background-color:#ffe8bf; text-align:center; padding:50px 20px; min-height:100vh; display:flex; flex-direction:column; justify-content:center;">
        <h2 style="font-size:28px; font-weight:500; font-family:'Archivo SemiExpanded',Archivo,sans-serif; margin-bottom:10px;">
            ¿Qué es la Temporada 1?
        </h2>
        <p style="font-size:18px; font-family:'Archivo',sans-serif; margin:0 auto 40px; max-width:600px; line-height:1.4;">
            La Temporada 1 es un ciclo de encuentros grabados por especialistas que abordan cada uno de los temas que más atraviesan tu experiencia humana.
        </p>

        <div style="display:grid; grid-template-columns:repeat(4, 1fr); gap:20px; max-width:1200px; margin:0 auto 50px; text-align:left; width:100%;">
            
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
        
        <a href="#" class="btn-temporada" style="align-self: center;">QUIERO SER PARTE</a>
    </section>

    <!-- QUÉ TE LLEVÁS SECTION -->
    <section style="width:100%; background-color:var(--bg-orange); padding:80px 20px; text-align:center; min-height:100vh; display:flex; flex-direction:column; justify-content:center;">
        <h2 style="font-size:32px; font-weight:500; font-family:'Archivo SemiExpanded',Archivo,sans-serif; margin-bottom:50px;">
            ¿Qué te llevás?
        </h2>
        <div style="display:grid; grid-template-columns:repeat(3, 1fr); gap:30px; max-width:1000px; margin:0 auto; width:100%;">
            <!-- Tarjeta 1 -->
            <div style="background-color:var(--bg-yellow); border:1px solid #3b2017; border-radius:5px; padding:40px 20px; display:flex; flex-direction:column; align-items:center; justify-content:center;">
                <!-- Icono de reloj -->
                <div style="position:relative; margin-bottom:20px; background-color:transparent; display:inline-block;">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/temporada1/DTDLVH_Elearning_HOME_icon/Group%2089.svg" alt="4 Capítulos" style="width:100px; height:auto; display:block;">
                    <div style="position:absolute; top:52%; left:50%; transform:translate(-50%, -50%); display:flex; flex-direction:column; align-items:center; line-height:1;">
                        <span style="font-size:32px; font-weight:700; font-family:'Archivo',sans-serif;">2</span>
                        <span style="font-size:14px; font-weight:700; font-family:'Archivo',sans-serif;">HORAS</span>
                    </div>
                </div>
                <h3 style="font-size:22px; font-weight:700; text-transform:uppercase; margin:0; line-height:1.2; font-family:'Archivo',sans-serif;">4 CAPÍTULOS<br>DE 30 MINUTOS<br>CADA UNO</h3>
            </div>
            <!-- Tarjeta 2 -->
            <div style="background-color:var(--bg-yellow); border:1px solid #3b2017; border-radius:5px; padding:40px 20px; display:flex; flex-direction:column; align-items:center; justify-content:center;">
                <!-- Icono de laptop -->
                <div style="margin-bottom:20px;">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/COMPU-08%201.svg" alt="Acceso Online" style="width:100px; height:auto;">
                </div>
                <h3 style="font-size:22px; font-weight:700; text-transform:uppercase; margin:0; line-height:1.2; font-family:'Archivo',sans-serif;">ACCESO ONLINE<br>Y A TU PROPIO<br>RITMO</h3>
            </div>
            <!-- Tarjeta 3 -->
            <div style="background-color:var(--bg-yellow); border:1px solid #3b2017; border-radius:5px; padding:40px 20px; display:flex; flex-direction:column; align-items:center; justify-content:center;">
                <!-- Icono de documento -->
                <div style="margin-bottom:20px;">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/DTDLVH_Elearning_HOME_icon/Group%2019.svg" alt="Material Descargable" style="width:100px; height:auto;">
                </div>
                <h3 style="font-size:22px; font-weight:700; text-transform:uppercase; margin:0; line-height:1.2; font-family:'Archivo',sans-serif;">MATERIAL<br>DESCARGABLE<br>POR TEMA</h3>
            </div>
        </div>
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
            
            <!-- ACORDEÓN 1 -->
            <div style="border:1px solid #3b2017; border-radius:5px; margin-bottom:15px; overflow:hidden; background-color:var(--bg-green);">
                <div style="padding:15px 20px; font-weight:700; font-size:14px; display:flex; justify-content:space-between; align-items:center; cursor:pointer;">
                    <span>EPISODIO 1: AMOR - Por Claudio A. González</span>
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><polyline points="18 15 12 9 6 15"></polyline></svg>
                </div>
                <div style="background-color:var(--bg-cream); padding:30px; border-top:1px solid #3b2017; display:flex; flex-wrap:wrap; gap:20px;">
                    <!-- Thumbnails de videos simulados -->
                    <div style="width:calc(33% - 14px); text-align:left;">
                        <div style="background-color:#dcdcdc; aspect-ratio:16/9; display:flex; align-items:center; justify-content:center; margin-bottom:10px;">
                            <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#3b2017" stroke-width="1.5"><circle cx="12" cy="12" r="10"></circle><polygon points="10 8 16 12 10 16 10 8"></polygon></svg>
                        </div>
                        <p style="font-size:12px; margin:0; line-height:1.2; color:#3b2017;">Bloque 0 | Presentación</p>
                    </div>
                    <div style="width:calc(33% - 14px); text-align:left;">
                        <div style="background-color:#dcdcdc; aspect-ratio:16/9; display:flex; align-items:center; justify-content:center; margin-bottom:10px;">
                            <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#3b2017" stroke-width="1.5"><circle cx="12" cy="12" r="10"></circle><rect x="9" y="11" width="6" height="6" rx="1" ry="1"></rect><path d="M10 11V9a2 2 0 0 1 4 0v2"></path></svg>
                        </div>
                        <p style="font-size:12px; margin:0; line-height:1.2; color:#3b2017;">Bloque 1 | Los vínculos<br>que heredamos</p>
                    </div>
                    <div style="width:calc(33% - 14px); text-align:left;">
                        <div style="background-color:#dcdcdc; aspect-ratio:16/9; display:flex; align-items:center; justify-content:center; margin-bottom:10px;">
                            <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#3b2017" stroke-width="1.5"><circle cx="12" cy="12" r="10"></circle><rect x="9" y="11" width="6" height="6" rx="1" ry="1"></rect><path d="M10 11V9a2 2 0 0 1 4 0v2"></path></svg>
                        </div>
                        <p style="font-size:12px; margin:0; line-height:1.2; color:#3b2017;">Bloque 2 | Las lealtades<br>invisibles</p>
                    </div>
                    <div style="width:calc(33% - 14px); text-align:left;">
                        <div style="background-color:#dcdcdc; aspect-ratio:16/9; display:flex; align-items:center; justify-content:center; margin-bottom:10px;">
                            <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#3b2017" stroke-width="1.5"><circle cx="12" cy="12" r="10"></circle><rect x="9" y="11" width="6" height="6" rx="1" ry="1"></rect><path d="M10 11V9a2 2 0 0 1 4 0v2"></path></svg>
                        </div>
                        <p style="font-size:12px; margin:0; line-height:1.2; color:#3b2017;">Bloque 3 | Amar desde un<br>nuevo lugar</p>
                    </div>
                    <div style="width:calc(33% - 14px); text-align:left;">
                        <div style="background-color:#dcdcdc; aspect-ratio:16/9; display:flex; align-items:center; justify-content:center; margin-bottom:10px;">
                            <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#3b2017" stroke-width="1.5"><circle cx="12" cy="12" r="10"></circle><rect x="9" y="11" width="6" height="6" rx="1" ry="1"></rect><path d="M10 11V9a2 2 0 0 1 4 0v2"></path></svg>
                        </div>
                        <p style="font-size:12px; margin:0; line-height:1.2; color:#3b2017;">Bloque 4 | Herramientas<br>para comenzar a aplicar</p>
                    </div>
                </div>
            </div>

            <!-- ACORDEÓN 2 -->
            <div class="accordion-item" style="border:1px solid #3b2017; border-radius:5px; margin-bottom:15px; overflow:hidden; background-color:var(--bg-green);">
                <div class="accordion-header" style="padding:15px 20px; font-weight:700; font-family:'Archivo',sans-serif; font-size:16px; display:flex; justify-content:space-between; align-items:center; cursor:pointer;">
                    <span>EPISODIO 2: TRABAJO - Por Maxi González</span>
                    <svg class="accordion-icon" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><polyline points="6 9 12 15 18 9"></polyline></svg>
                </div>
                <div class="accordion-body" style="display:none; background-color:var(--bg-cream); padding:30px; border-top:1px solid #3b2017; flex-wrap:wrap; gap:20px;">
                    <!-- Thumbnails de videos simulados -->
                    <div style="width:calc(33% - 14px); text-align:left;">
                        <div style="background-color:#dcdcdc; aspect-ratio:16/9; display:flex; align-items:center; justify-content:center; margin-bottom:10px;">
                            <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#3b2017" stroke-width="1.5"><circle cx="12" cy="12" r="10"></circle><polygon points="10 8 16 12 10 16 10 8"></polygon></svg>
                        </div>
                        <p style="font-size:14px; font-family:'Archivo',sans-serif; margin:0; line-height:1.2; color:#3b2017;">Bloque 0 | Presentación</p>
                    </div>
                    <div style="width:calc(33% - 14px); text-align:left;">
                        <div style="background-color:#dcdcdc; aspect-ratio:16/9; display:flex; align-items:center; justify-content:center; margin-bottom:10px;">
                            <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#3b2017" stroke-width="1.5"><circle cx="12" cy="12" r="10"></circle><rect x="9" y="11" width="6" height="6" rx="1" ry="1"></rect><path d="M10 11V9a2 2 0 0 1 4 0v2"></path></svg>
                        </div>
                        <p style="font-size:14px; font-family:'Archivo',sans-serif; margin:0; line-height:1.2; color:#3b2017;">Bloque 1 | Tu relación<br>con el dinero</p>
                    </div>
                    <div style="width:calc(33% - 14px); text-align:left;">
                        <div style="background-color:#dcdcdc; aspect-ratio:16/9; display:flex; align-items:center; justify-content:center; margin-bottom:10px;">
                            <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#3b2017" stroke-width="1.5"><circle cx="12" cy="12" r="10"></circle><rect x="9" y="11" width="6" height="6" rx="1" ry="1"></rect><path d="M10 11V9a2 2 0 0 1 4 0v2"></path></svg>
                        </div>
                        <p style="font-size:14px; font-family:'Archivo',sans-serif; margin:0; line-height:1.2; color:#3b2017;">Bloque 2 | Valor<br>personal y profesional</p>
                    </div>
                </div>
            </div>
            
            <!-- ACORDEÓN 3 -->
            <div class="accordion-item" style="border:1px solid #3b2017; border-radius:5px; margin-bottom:15px; overflow:hidden; background-color:var(--bg-green);">
                <div class="accordion-header" style="padding:15px 20px; font-weight:700; font-family:'Archivo',sans-serif; font-size:16px; display:flex; justify-content:space-between; align-items:center; cursor:pointer;">
                    <span>EPISODIO 3: DUELO - Por Mery Molinero</span>
                    <svg class="accordion-icon" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><polyline points="6 9 12 15 18 9"></polyline></svg>
                </div>
                <div class="accordion-body" style="display:none; background-color:var(--bg-cream); padding:30px; border-top:1px solid #3b2017; flex-wrap:wrap; gap:20px;">
                    <!-- Thumbnails de videos simulados -->
                    <div style="width:calc(33% - 14px); text-align:left;">
                        <div style="background-color:#dcdcdc; aspect-ratio:16/9; display:flex; align-items:center; justify-content:center; margin-bottom:10px;">
                            <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#3b2017" stroke-width="1.5"><circle cx="12" cy="12" r="10"></circle><polygon points="10 8 16 12 10 16 10 8"></polygon></svg>
                        </div>
                        <p style="font-size:14px; font-family:'Archivo',sans-serif; margin:0; line-height:1.2; color:#3b2017;">Bloque 0 | Presentación</p>
                    </div>
                    <div style="width:calc(33% - 14px); text-align:left;">
                        <div style="background-color:#dcdcdc; aspect-ratio:16/9; display:flex; align-items:center; justify-content:center; margin-bottom:10px;">
                            <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#3b2017" stroke-width="1.5"><circle cx="12" cy="12" r="10"></circle><rect x="9" y="11" width="6" height="6" rx="1" ry="1"></rect><path d="M10 11V9a2 2 0 0 1 4 0v2"></path></svg>
                        </div>
                        <p style="font-size:14px; font-family:'Archivo',sans-serif; margin:0; line-height:1.2; color:#3b2017;">Bloque 1 | Atajos<br>ante el dolor</p>
                    </div>
                    <div style="width:calc(33% - 14px); text-align:left;">
                        <div style="background-color:#dcdcdc; aspect-ratio:16/9; display:flex; align-items:center; justify-content:center; margin-bottom:10px;">
                            <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#3b2017" stroke-width="1.5"><circle cx="12" cy="12" r="10"></circle><rect x="9" y="11" width="6" height="6" rx="1" ry="1"></rect><path d="M10 11V9a2 2 0 0 1 4 0v2"></path></svg>
                        </div>
                        <p style="font-size:14px; font-family:'Archivo',sans-serif; margin:0; line-height:1.2; color:#3b2017;">Bloque 2 | Integrar<br>la pérdida</p>
                    </div>
                </div>
            </div>
            
            <!-- ACORDEÓN 4 -->
            <div class="accordion-item" style="border:1px solid #3b2017; border-radius:5px; margin-bottom:15px; overflow:hidden; background-color:var(--bg-green);">
                <div class="accordion-header" style="padding:15px 20px; font-weight:700; font-family:'Archivo',sans-serif; font-size:16px; display:flex; justify-content:space-between; align-items:center; cursor:pointer;">
                    <span>EPISODIO 4: CRECIMIENTO - Por César Trombino</span>
                    <svg class="accordion-icon" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><polyline points="6 9 12 15 18 9"></polyline></svg>
                </div>
                <div class="accordion-body" style="display:none; background-color:var(--bg-cream); padding:30px; border-top:1px solid #3b2017; flex-wrap:wrap; gap:20px;">
                    <!-- Thumbnails de videos simulados -->
                    <div style="width:calc(33% - 14px); text-align:left;">
                        <div style="background-color:#dcdcdc; aspect-ratio:16/9; display:flex; align-items:center; justify-content:center; margin-bottom:10px;">
                            <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#3b2017" stroke-width="1.5"><circle cx="12" cy="12" r="10"></circle><polygon points="10 8 16 12 10 16 10 8"></polygon></svg>
                        </div>
                        <p style="font-size:14px; font-family:'Archivo',sans-serif; margin:0; line-height:1.2; color:#3b2017;">Bloque 0 | Presentación</p>
                    </div>
                    <div style="width:calc(33% - 14px); text-align:left;">
                        <div style="background-color:#dcdcdc; aspect-ratio:16/9; display:flex; align-items:center; justify-content:center; margin-bottom:10px;">
                            <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#3b2017" stroke-width="1.5"><circle cx="12" cy="12" r="10"></circle><rect x="9" y="11" width="6" height="6" rx="1" ry="1"></rect><path d="M10 11V9a2 2 0 0 1 4 0v2"></path></svg>
                        </div>
                        <p style="font-size:14px; font-family:'Archivo',sans-serif; margin:0; line-height:1.2; color:#3b2017;">Bloque 1 | Cuando la vida<br>nos frena</p>
                    </div>
                    <div style="width:calc(33% - 14px); text-align:left;">
                        <div style="background-color:#dcdcdc; aspect-ratio:16/9; display:flex; align-items:center; justify-content:center; margin-bottom:10px;">
                            <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#3b2017" stroke-width="1.5"><circle cx="12" cy="12" r="10"></circle><rect x="9" y="11" width="6" height="6" rx="1" ry="1"></rect><path d="M10 11V9a2 2 0 0 1 4 0v2"></path></svg>
                        </div>
                        <p style="font-size:14px; font-family:'Archivo',sans-serif; margin:0; line-height:1.2; color:#3b2017;">Bloque 2 | Nuevas<br>herramientas</p>
                    </div>
                </div>
            </div>

        </div>

        <a href="#" class="btn-temporada" style="margin: 0 auto;">ACCEDÉ A LA TEMPORADA</a>
    </section>

    <!-- CTA SECTION -->
    <section style="width:100%; background-color:var(--bg-purple); padding:100px 20px; text-align:center; min-height:100vh; display:flex; flex-direction:column; justify-content:center; align-items:center;">
        <h2 style="font-size:46px; text-transform:uppercase; font-weight:500; font-family:'Archivo SemiExpanded',Archivo,sans-serif; max-width:1000px; margin:0 auto 40px; line-height:1.2;">
            COMPRENDER LO QUE TE PASA PUEDE CAMBIAR LA FORMA EN QUE LO VIVÍS.
        </h2>
        <a href="#" class="btn-temporada">¡MIRALA AHORA!</a>
    </section>

    <!-- FAQ SECTION -->
    <section style="width:100%; background-color:#fdfaf1; padding:80px 20px;">
        <div style="max-width:800px; margin:0 auto;">
            <h2 style="font-size:32px; font-weight:500; font-family:'Archivo SemiExpanded',Archivo,sans-serif; text-align:center; margin-bottom:40px;">FAQ</h2>
            
            <div style="display:flex; flex-direction:column; gap:15px;">
            
            <div class="accordion-item" style="border:1px solid #3b2017; border-radius:5px; overflow:hidden; background-color:var(--bg-green);">
                <div class="accordion-header" style="padding:15px 20px; font-family:'Archivo',sans-serif; font-weight:700; font-size:14px; text-transform:uppercase; display:flex; justify-content:space-between; align-items:center; cursor:pointer;">
                    <span>¿CÓMO ACCEDO AL CONTENIDO?</span>
                    <svg class="accordion-icon" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><polyline points="6 9 12 15 18 9"></polyline></svg>
                </div>
                <div class="accordion-body" style="display:none; background-color:var(--bg-cream); padding:20px; border-top:1px solid #3b2017; font-family:'Archivo',sans-serif; font-weight:400; font-size:16px; line-height:1.4;">
                    Una vez realizada la compra recibirás un correo con tus datos de acceso. Desde ese momento podrás ingresar a la plataforma cuando quieras y avanzar a tu propio ritmo.
                </div>
            </div>

            <div class="accordion-item" style="border:1px solid #3b2017; border-radius:5px; overflow:hidden; background-color:var(--bg-green);">
                <div class="accordion-header" style="padding:15px 20px; font-family:'Archivo',sans-serif; font-weight:700; font-size:14px; text-transform:uppercase; display:flex; justify-content:space-between; align-items:center; cursor:pointer;">
                    <span>¿DURANTE CUÁNTO TIEMPO TENDRÉ ACCESO?</span>
                    <svg class="accordion-icon" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><polyline points="6 9 12 15 18 9"></polyline></svg>
                </div>
                <div class="accordion-body" style="display:none; background-color:var(--bg-cream); padding:20px; border-top:1px solid #3b2017; font-family:'Archivo',sans-serif; font-weight:400; font-size:16px; line-height:1.4;">
                    La compra incluye acceso a la Temporada 1 para que puedas volver a verla siempre que lo necesites. (Si luego definen otro plazo se modifica).
                </div>
            </div>

            <div class="accordion-item" style="border:1px solid #3b2017; border-radius:5px; overflow:hidden; background-color:var(--bg-green);">
                <div class="accordion-header" style="padding:15px 20px; font-family:'Archivo',sans-serif; font-weight:700; font-size:14px; text-transform:uppercase; display:flex; justify-content:space-between; align-items:center; cursor:pointer;">
                    <span>¿NECESITO CONOCIMIENTOS PREVIOS?</span>
                    <svg class="accordion-icon" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><polyline points="6 9 12 15 18 9"></polyline></svg>
                </div>
                <div class="accordion-body" style="display:none; background-color:var(--bg-cream); padding:20px; border-top:1px solid #3b2017; font-family:'Archivo',sans-serif; font-weight:400; font-size:16px; line-height:1.4;">
                    No. Los contenidos están pensados para cualquier persona interesada en comprender mejor su historia personal y explorar nuevas herramientas para su bienestar.
                </div>
            </div>

            <div class="accordion-item" style="border:1px solid #3b2017; border-radius:5px; overflow:hidden; background-color:var(--bg-green);">
                <div class="accordion-header" style="padding:15px 20px; font-family:'Archivo',sans-serif; font-weight:700; font-size:14px; text-transform:uppercase; display:flex; justify-content:space-between; align-items:center; cursor:pointer;">
                    <span>¿LOS EPISODIOS DEBEN VERSE EN ORDEN?</span>
                    <svg class="accordion-icon" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><polyline points="6 9 12 15 18 9"></polyline></svg>
                </div>
                <div class="accordion-body" style="display:none; background-color:var(--bg-cream); padding:20px; border-top:1px solid #3b2017; font-family:'Archivo',sans-serif; font-weight:400; font-size:16px; line-height:1.4;">
                    Podés recorrerlos como prefieras. Cada episodio aborda un tema diferente y funciona de manera independiente, aunque juntos ofrecen una mirada más amplia sobre distintos aspectos de la vida.
                </div>
            </div>

            <div class="accordion-item" style="border:1px solid #3b2017; border-radius:5px; overflow:hidden; background-color:var(--bg-green);">
                <div class="accordion-header" style="padding:15px 20px; font-family:'Archivo',sans-serif; font-weight:700; font-size:14px; text-transform:uppercase; display:flex; justify-content:space-between; align-items:center; cursor:pointer;">
                    <span>¿INCLUYE MATERIAL COMPLEMENTARIO?</span>
                    <svg class="accordion-icon" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><polyline points="6 9 12 15 18 9"></polyline></svg>
                </div>
                <div class="accordion-body" style="display:none; background-color:var(--bg-cream); padding:20px; border-top:1px solid #3b2017; font-family:'Archivo',sans-serif; font-weight:400; font-size:16px; line-height:1.4;">
                    Sí. Cada episodio cuenta con un material descargable que te permitirá profundizar los conceptos y llevar las reflexiones a tu vida cotidiana.
                </div>
            </div>

            <div class="accordion-item" style="border:1px solid #3b2017; border-radius:5px; overflow:hidden; background-color:var(--bg-green);">
                <div class="accordion-header" style="padding:15px 20px; font-family:'Archivo',sans-serif; font-weight:700; font-size:14px; text-transform:uppercase; display:flex; justify-content:space-between; align-items:center; cursor:pointer;">
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
