<?php
/**
 * Template Name: Dashboard de Usuario
 */

// Si el usuario no ha iniciado sesión, lo mandamos a la portada.
if ( ! is_user_logged_in() ) {
    wp_redirect( home_url() );
    exit;
}

get_header(); 
$current_user = wp_get_current_user();

// Verificamos si el usuario tiene acceso a la Temporada 1 (Producto ID 26)
$producto_id = 26; // ID de la Temporada 1
$has_access = false;
$has_manual_access = get_user_meta( $current_user->ID, '_dtd_acceso_manual_' . $producto_id, true );

if ( current_user_can('manage_options') || $has_manual_access || wc_customer_bought_product( $current_user->user_email, $current_user->ID, $producto_id ) ) {
    $has_access = true;
}

// Función helper para renderizar iframes de videos (GDrive, YT, Vimeo)
function dtd_render_video_iframes($videos_text) {
    if (empty($videos_text)) return;
    $urls = explode("\n", str_replace("\r", "", $videos_text));
    foreach ($urls as $url) {
        $url = trim($url);
        if (empty($url)) continue;
        
        $embed_url = '';
        if (strpos($url, 'drive.google.com') !== false) {
            preg_match('/d\/([a-zA-Z0-9-_]+)/', $url, $matches);
            if (!empty($matches[1])) {
                $embed_url = 'https://drive.google.com/file/d/' . $matches[1] . '/preview';
            }
        } elseif (strpos($url, 'youtube.com') !== false || strpos($url, 'youtu.be') !== false) {
            preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/', $url, $matches);
            if (!empty($matches[1])) {
                $embed_url = 'https://www.youtube.com/embed/' . $matches[1];
            }
        } elseif (strpos($url, 'vimeo.com') !== false) {
            preg_match('/vimeo\.com\/(?:.*#|.*\/videos\/)?([0-9]+)/', $url, $matches);
            if (!empty($matches[1])) {
                $embed_url = 'https://player.vimeo.com/video/' . $matches[1];
            }
        } else {
            $embed_url = $url; 
        }
        
        if (!empty($embed_url)) {
            echo '<div class="dtd-video-wrapper" style="position: relative; padding-bottom: 56.25%; height: 0; overflow: hidden; border-radius: 10px; margin-bottom: 20px; z-index: 1;">';
            echo '<iframe src="' . esc_url($embed_url) . '" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; border:0;" allow="autoplay; fullscreen" allowfullscreen="allowfullscreen" webkitallowfullscreen="true" mozallowfullscreen="true"></iframe>';
            if (strpos($url, 'drive.google.com') !== false) {
                // Bloqueador invisible para evitar el clic en el ícono de "Pop-out" (descarga) de Google Drive
                echo '<div style="position:absolute; top:0; right:0; width:60px; height:60px; z-index:10; background:transparent;"></div>';
            }
            echo '</div>';
        }
    }
}
?>

<style>
    :root {
        --dash-bg: #f5f5f5;
        --dash-panel: #ffffff;
        --dash-text: #333333;
        --dash-light-text: #666666;
        --dash-border: #e0e0e0;
        --dash-accent: #3b2017;
    }
    body {
        background-color: var(--dash-bg);
        margin: 0;
        padding: 0;
    }
    .dashboard-container {
        display: flex;
        min-height: 100vh;
        max-width: 1400px;
        margin: 40px auto;
        background-color: var(--dash-panel);
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        overflow: hidden;
        font-family: 'Archivo', sans-serif;
    }
    /* Sidebar */
    .dash-sidebar {
        width: 80px;
        border-right: 1px solid var(--dash-border);
        display: flex;
        flex-direction: column;
        align-items: center;
        padding: 30px 0;
        background: #fff;
    }
    .dash-sidebar-icon {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background-color: #f0f0f0;
        display: flex;
        justify-content: center;
        align-items: center;
        margin-bottom: 30px;
        color: #999;
        cursor: pointer;
        transition: 0.3s;
    }
    .dash-sidebar-icon:hover, .dash-sidebar-icon.active-icon {
        background-color: var(--dash-accent);
        color: #fff;
    }
    
    /* Main Content */
    .dash-main {
        flex: 1;
        padding: 30px 40px;
        overflow-y: auto;
    }
    .dash-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
    }
    .dash-title {
        font-size: 22px;
        font-weight: 700;
        color: var(--dash-text);
        margin: 0;
    }
    .dash-search {
        display: flex;
        align-items: center;
        background: #f0f0f0;
        border-radius: 20px;
        padding: 8px 15px;
        width: 250px;
    }
    .dash-search input {
        border: none;
        background: transparent;
        margin-left: 10px;
        outline: none;
        width: 100%;
        font-family: 'Archivo', sans-serif;
    }
    .dash-user-profile {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: #ccc;
        overflow: hidden;
        flex-shrink: 0;
    }
    
    /* Featured Series */
    .dash-section-title {
        font-size: 18px;
        font-weight: 700;
        margin-bottom: 15px;
        color: var(--dash-text);
    }
    .dash-featured {
        position: relative;
        width: 100%;
        border-radius: 15px;
        background-color: #d1bfae; /* Fallback color */
        margin-bottom: 40px;
        overflow: hidden;
    }
    .dash-featured img {
        width: 100%;
        height: auto;
        display: block;
    }
    .dash-featured-time {
        position: absolute;
        bottom: 20px;
        right: 20px;
        background: rgba(0,0,0,0.6);
        color: #fff;
        padding: 5px 15px;
        border-radius: 20px;
        font-size: 14px;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    
    /* Episodes Grid */
    .dash-episodes-wrapper {
        position: relative;
        display: flex;
        align-items: center;
    }
    .dash-episodes-grid {
        display: flex;
        gap: 20px;
        overflow-x: auto;
        padding-bottom: 20px;
        scroll-behavior: smooth;
        flex: 1;
        /* Hide scrollbar */
        scrollbar-width: none;
    }
    .dash-episodes-grid::-webkit-scrollbar {
        display: none;
    }
    .dash-nav-btn {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: rgba(0,0,0,0.5);
        color: #fff;
        display: flex;
        justify-content: center;
        align-items: center;
        cursor: pointer;
        position: absolute;
        z-index: 10;
        border: none;
    }
    .dash-nav-prev { left: -20px; }
    .dash-nav-next { right: -20px; }

    .dash-episode-card {
        min-width: 280px;
        background: #fff;
        border-radius: 12px;
        border: 1px solid var(--dash-border);
        overflow: hidden;
        box-shadow: 0 4px 10px rgba(0,0,0,0.02);
        cursor: pointer;
        transition: 0.3s;
    }
    .dash-episode-card:hover {
        box-shadow: 0 8px 20px rgba(0,0,0,0.08);
        transform: translateY(-5px);
    }
    .dash-episode-img {
        width: 100%;
        height: 120px;
        background-color: #e0d5c1;
        object-fit: cover;
    }
    .dash-episode-info {
        padding: 15px;
    }
    .dash-episode-title {
        font-size: 15px;
        font-weight: 700;
        margin: 0 0 5px 0;
        color: var(--dash-text);
    }
    .dash-episode-meta {
        font-size: 13px;
        color: var(--dash-light-text);
        display: flex;
        align-items: center;
        gap: 5px;
    }
    
    /* Subtopics Expanded View (Hidden by default) */
    .dash-subtopics {
        display: none;
        background: #fff;
        border: 1px solid var(--dash-border);
        border-radius: 12px;
        margin-top: -10px;
        padding: 20px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
    }
    .dash-subtopics.active {
        display: flex;
        gap: 40px;
    }
    .dash-subtopics-list {
        list-style: none;
        padding: 0;
        margin: 0;
        flex: 1;
    }
    .dash-subtopic-item {
        display: flex;
        align-items: center;
        padding: 10px 0;
        border-bottom: 1px solid var(--dash-border);
        font-size: 14px;
        cursor: pointer;
    }
    .dash-subtopic-item:last-child {
        border-bottom: none;
    }
    .dash-subtopic-item:hover {
        color: var(--dash-accent);
    }
    .dash-subtopic-icon {
        margin-right: 15px;
    }
    .dash-subtopic-details {
        flex: 2;
        border-left: 1px solid var(--dash-border);
        padding-left: 40px;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }
    
    /* Responsive Media Queries */
    @media (max-width: 1200px) {
        .dashboard-container {
            flex-direction: column;
            margin: 10px;
            border-radius: 10px;
        }
        .dash-sidebar {
            width: 100%;
            flex-direction: row;
            justify-content: space-around;
            padding: 10px 0;
            border-right: none;
            border-bottom: 1px solid var(--dash-border);
        }
        .dash-sidebar-icon {
            margin-bottom: 0;
        }
        /* Override inline margin-top for mobile */
        .dash-sidebar a[style*="margin-top:auto;"] {
            margin-top: 0 !important;
        }
        .dash-main {
            padding: 20px 15px;
        }
        .dash-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 15px;
        }
        .dash-header > div {
            width: 100%;
            justify-content: space-between;
        }
        .dash-search {
            width: 100%;
            box-sizing: border-box;
            max-width: none;
        }
        .dash-featured {
            margin-bottom: 25px;
            /* Se remueve height fijo para que se autoajuste a la imagen */
        }
        .dash-subtopics {
            padding: 20px 10px;
        }
        .dash-subtopics.active {
            flex-direction: column;
            gap: 20px;
        }
        .dash-subtopics-list,
        .dash-subtopic-details {
            width: 100%;
            box-sizing: border-box;
            flex: none;
        }
        .dash-subtopic-details {
            border-left: none;
            border-top: 1px solid var(--dash-border);
            padding-left: 0;
            padding-top: 20px;
        }
        .dtd-video-wrapper {
            padding-bottom: 56.25% !important;
        }
        .dtd-video-wrapper iframe {
            width: 100% !important;
            height: 100% !important;
            transform: none;
        }
    }
    
    /* Hack para engañar a Vimeo en móviles verticales y evitar que ponga los botones gigantes */
    @media (max-width: 600px) {
        .dtd-video-wrapper iframe {
            width: 200% !important;
            height: 200% !important;
            transform: scale(0.5);
            transform-origin: top left;
        }
    }
</style>

<div class="dashboard-container">
    
    <!-- Sidebar -->
    <aside class="dash-sidebar">
        <!-- Ícono de Contenido/Cursos (Activo) -->
        <a href="#" class="dash-sidebar-icon active-icon" title="Mis Cursos" onclick="window.scrollTo({top: 0, behavior: 'smooth'}); return false;">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><line x1="3" y1="9" x2="21" y2="9"></line><line x1="9" y1="21" x2="9" y2="9"></line></svg>
        </a>
        
        <!-- Ícono de Búsqueda -->
        <a href="#" class="dash-sidebar-icon" title="Buscar" onclick="document.getElementById('dashSearchInput').focus(); return false;">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
        </a>
        
        <!-- Ícono de Usuario (Mi Cuenta) -->
        <a href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>" class="dash-sidebar-icon" title="Mi Cuenta">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
        </a>
        
        <!-- Salir -->
        <a href="<?php echo esc_url( wp_logout_url( home_url() ) ); ?>" class="dash-sidebar-icon" style="margin-top:auto;" title="Cerrar Sesión">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
        </a>
    </aside>

    <!-- Main Content -->
    <main class="dash-main">
        
        <!-- Header -->
        <header class="dash-header">
            <h1 class="dash-title">Clínica Online | Dónde te duele la vida hoy | Temporada 1 - Buenos Aires</h1>
            <div style="display:flex; gap:20px; align-items:center;">
                <div class="dash-search">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#999" stroke-width="2"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                    <input type="text" id="dashSearchInput" placeholder="Buscar...">
                </div>
                <div class="dash-user-profile">
                    <!-- Avatar placeholder -->
                    <a href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>" title="Mi Cuenta">
                        <svg viewBox="0 0 24 24" fill="#999" style="width:100%; height:100%;"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
                    </a>
                </div>
            </div>
        </header>

        <?php if ( ! $has_access ) : ?>
            <div style="background:#fffa64; padding:40px; border:2px solid #3b2017; border-radius:15px; text-align:center;">
                <h2>Contenido Bloqueado 🔒</h2>
                <p style="font-size:18px;">Aún no tienes acceso a la Temporada 1. Para ver los episodios, necesitas adquirir el pase.</p>
                <a href="https://dondeteduele.com/tickets/?postticket=clinica-online" style="display:inline-block; background:var(--dash-accent); color:#fff; padding:15px 30px; text-decoration:none; border-radius:30px; font-weight:bold; margin-top:20px;">Adquirir Temporada 1</a>
            </div>
        <?php else: ?>

            <!-- Featured Series -->
            <div class="dash-section-title">Featured Series</div>
            <div class="dash-featured">
                <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/banner-clinica.png" alt="Banner Clínica Online">
                <div class="dash-featured-time">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                    Total: 2 Horas
                </div>
            </div>

            <!-- Episodes Section -->
            <div class="dash-section-title">Temporadas / Episodios</div>
            
            <div class="dash-episodes-wrapper">
                <button class="dash-nav-btn dash-nav-prev">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"></polyline></svg>
                </button>

                <div class="dash-episodes-grid" id="episodesGrid">
                    
                    <?php
                    // Consultar los episodios
                    $args = array(
                        'post_type'      => 'episodio',
                        'posts_per_page' => -1,
                        'orderby'        => 'menu_order',
                        'order'          => 'ASC'
                    );
                    $query = new WP_Query( $args );
                    $count = 1;

                    // Imágenes de reemplazo temporales para que se parezca al diseño
                    $images = [
                        get_template_directory_uri() . '/assets/temporada1/DTDLVH_Elearning_HOME_img/source/claudio.png',
                        get_template_directory_uri() . '/assets/temporada1/DTDLVH_Elearning_HOME_img/source/maxi.png',
                        get_template_directory_uri() . '/assets/temporada1/DTDLVH_Elearning_HOME_img/source/mery.png',
                        get_template_directory_uri() . '/assets/temporada1/DTDLVH_Elearning_HOME_img/source/cesar.png'
                    ];

                    if ( $query->have_posts() ) :
                        while ( $query->have_posts() ) : $query->the_post();
                            $post_id = get_the_ID();
                            $especialista = get_post_meta($post_id, '_dtd_especialista', true);
                            $img_src = isset($images[$count-1]) ? $images[$count-1] : $images[0];
                    ?>
                            
                            <div class="dash-episode-card" onclick="toggleSubtopics('<?php echo esc_attr($post_id); ?>')">
                                <img src="<?php echo esc_url($img_src); ?>" class="dash-episode-img" alt="Episodio">
                                <div class="dash-episode-info">
                                    <h3 class="dash-episode-title">Episodio <?php echo $count; ?> | <?php echo esc_html(get_the_title()); ?> | <?php echo esc_html($especialista); ?></h3>
                                    <div class="dash-episode-meta">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                                        30 min
                                    </div>
                                </div>
                            </div>

                    <?php
                        $count++;
                        endwhile;
                    endif;
                    ?>
                    
                </div>
                
                <button class="dash-nav-btn dash-nav-next">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"></polyline></svg>
                </button>
            </div>

            <!-- Contenedor dinámico de subtemas -->
            <div id="subtopicsContainer" style="margin-top: 20px;">
                <?php
                // Generar los bloques ocultos por cada episodio
                if ( $query->have_posts() ) :
                    while ( $query->have_posts() ) : $query->the_post();
                        $post_id = get_the_ID();
                        ?>
                        <div class="dash-subtopics" id="subtopics-<?php echo esc_attr($post_id); ?>">
                            <ul class="dash-subtopics-list">
                                <?php 
                                for ($i = 0; $i <= 4; $i++) {
                                    $b_titulo = get_post_meta($post_id, "_dtd_bloque_{$i}_titulo", true);
                                    if (!empty($b_titulo)) {
                                        // Tiempo simulado para mantener diseño
                                        $time_start = str_pad($i*10, 2, "0", STR_PAD_LEFT) . ':00';
                                        $time_end = str_pad(($i+1)*10, 2, "0", STR_PAD_LEFT) . ':00';
                                        ?>
                                        <li class="dash-subtopic-item" onclick="showBlockVideos('<?php echo esc_attr($post_id); ?>', <?php echo $i; ?>)">
                                            <svg class="dash-subtopic-icon" width="20" height="20" viewBox="0 0 24 24" fill="#000" stroke="none"><circle cx="12" cy="12" r="10"></circle><polygon points="10 8 16 12 10 16 10 8" fill="#fff"></polygon></svg>
                                            <strong><?php echo esc_html($b_titulo); ?></strong> &nbsp;|&nbsp; <?php echo $time_start; ?> - <?php echo $time_end; ?>
                                        </li>
                                        <?php
                                    }
                                }
                                ?>
                            </ul>
                            <div class="dash-subtopic-details" id="details-pane-<?php echo esc_attr($post_id); ?>">
                                <?php
                                $video_url = get_post_meta($post_id, '_dtd_video_url', true);
                                ?>
                                
                                <div id="details-intro-<?php echo esc_attr($post_id); ?>" class="video-pane" style="display:block;">
                                    <h3 style="margin-top:0; color:var(--dash-text);">Introducción</h3>
                                    <?php if (!empty($video_url)) : ?>
                                        <?php dtd_render_video_iframes($video_url); ?>
                                    <?php else : ?>
                                        <p style="color:var(--dash-light-text); font-size:14px;">Selecciona un bloque a la izquierda para ver su contenido.</p>
                                    <?php endif; ?>
                                </div>

                                <?php
                                for ($i = 0; $i <= 4; $i++) {
                                    $b_titulo = get_post_meta($post_id, "_dtd_bloque_{$i}_titulo", true);
                                    if (!empty($b_titulo)) {
                                        $b_videos = get_post_meta($post_id, "_dtd_bloque_{$i}_videos", true);
                                        $b_obj = get_post_meta($post_id, "_dtd_bloque_{$i}_objetivo", true);
                                        $b_preguntas = get_post_meta($post_id, "_dtd_bloque_{$i}_preguntas", true);
                                        ?>
                                        <div id="details-block-<?php echo esc_attr($post_id); ?>-<?php echo $i; ?>" class="video-pane" style="display:none;">
                                            <h3 style="margin-top:0; color:var(--dash-text);"><?php echo esc_html($b_titulo); ?></h3>
                                            <?php if (!empty($b_obj)) : ?>
                                                <p style="font-size:14px;"><strong>Objetivo:</strong> <?php echo esc_html($b_obj); ?></p>
                                            <?php endif; ?>
                                            
                                            <?php 
                                            if (!empty($b_videos)) {
                                                dtd_render_video_iframes($b_videos); 
                                            } else {
                                                echo '<p style="color:var(--dash-light-text); font-size:14px;">No hay videos para este bloque.</p>';
                                            }
                                            
                                            if (!empty($b_preguntas)) : ?>
                                                <div style="background:var(--dash-bg); padding:15px; border-radius:10px; margin-top:20px;">
                                                    <h4 style="margin-top:0;">Preguntas Guía</h4>
                                                    <p style="font-size:14px; margin-bottom:0; white-space:pre-line;"><?php echo esc_html($b_preguntas); ?></p>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        <?php
                                    }
                                }
                                ?>
                            </div>
                        </div>
                        <?php
                    endwhile;
                    wp_reset_postdata();
                endif;
                ?>
            </div>
            
        <?php endif; // fin if has_access ?>

    </main>
</div>

<script>
    // Mostrar videos de un bloque específico
    function showBlockVideos(postId, blockIndex) {
        // Ocultar todos los paneles de video de este episodio
        const container = document.getElementById('details-pane-' + postId);
        if(container) {
            const panes = container.querySelectorAll('.video-pane');
            panes.forEach(pane => pane.style.display = 'none');
            
            // Mostrar el bloque solicitado
            const target = document.getElementById('details-block-' + postId + '-' + blockIndex);
            if (target) {
                target.style.display = 'block';
            }
        }
    }

    // Lógica para mostrar/ocultar los subtemas
    function toggleSubtopics(postId) {
        // Ocultar todos
        document.querySelectorAll('.dash-subtopics').forEach(el => {
            el.classList.remove('active');
        });
        
        // Mostrar el seleccionado
        const target = document.getElementById('subtopics-' + postId);
        if (target) {
            target.classList.add('active');
            
            // Al abrir, volver a mostrar la introducción por defecto
            const container = document.getElementById('details-pane-' + postId);
            if (container) {
                const panes = container.querySelectorAll('.video-pane');
                panes.forEach(pane => pane.style.display = 'none');
                const intro = document.getElementById('details-intro-' + postId);
                if (intro) intro.style.display = 'block';
            }

            // Hacer scroll suave hacia los subtemas
            target.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        }
    }

    // Scroll de la grilla
    const grid = document.getElementById('episodesGrid');
    const btnNext = document.querySelector('.dash-nav-next');
    const btnPrev = document.querySelector('.dash-nav-prev');

    if (btnNext && grid) {
        btnNext.addEventListener('click', () => {
            grid.scrollBy({ left: 300, behavior: 'smooth' });
        });
    }
    if (btnPrev && grid) {
        btnPrev.addEventListener('click', () => {
            grid.scrollBy({ left: -300, behavior: 'smooth' });
        });
    }
</script>

<?php get_footer(); ?>
