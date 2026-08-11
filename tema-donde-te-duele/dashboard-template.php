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
            // Soporte para enlaces privados/ocultos de Vimeo (ej: vimeo.com/123456/abcdef)
            preg_match('/vimeo\.com\/(?:.*#|.*\/videos\/)?([0-9]+)(?:\/([a-zA-Z0-9]+))?/', $url, $matches);
            if (!empty($matches[1])) {
                $embed_url = 'https://player.vimeo.com/video/' . $matches[1] . '?api=1';
                // Si hay un hash para videos privados, lo agregamos a la URL
                if (isset($matches[2]) && !empty($matches[2])) {
                    $embed_url .= '&h=' . $matches[2];
                }
            }
        } else {
            $embed_url = $url; 
        }
        
        if (!empty($embed_url)) {
            echo '<div class="dtd-video-wrapper" style="position:relative; padding-bottom:56.25%; height:0; overflow:hidden; border-radius:15px; margin-bottom:20px; box-shadow:0 10px 30px rgba(0,0,0,0.1);">';
            echo '<iframe src="' . esc_url($embed_url) . '" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen style="position:absolute; top:0; left:0; width:100%; height:100%;" class="vimeo-player-iframe"></iframe>';
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

    @media (min-width: 1300px) {
        .dash-nav-btn { display: none; }
    }

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
        
        <!-- Ícono de Búsqueda (Oculto a petición) -->
        <a href="#" class="dash-sidebar-icon" title="Buscar" onclick="document.getElementById('dashSearchInput').focus(); return false;" style="display:none;">
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
            <h1 class="dash-title">Clínica Online | Dónde te duele la vida hoy</h1>
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

        <?php
        // Obtener todos los Cursos/Temporadas (taxonomía 'curso')
        $cursos = get_terms( array(
            'taxonomy'   => 'curso',
            'hide_empty' => false,
        ) );
        
        // MODO COMPATIBILIDAD (FALLBACK): Si no hay taxonomías creadas, mostramos todo como antes
        if ( empty($cursos) || is_wp_error($cursos) ) {
            $has_access = dtd_user_has_access();
            if ( ! $has_access ) : ?>
                <div style="background:#fffa64; padding:40px; border:2px solid #3b2017; border-radius:15px; text-align:center;">
                    <h2>Contenido Bloqueado 🔒</h2>
                    <p style="font-size:18px;">Aún no tienes acceso a la Temporada 1. Para ver los episodios, necesitas adquirir el pase.</p>
                    <a href="https://dondeteduele.com/tickets/?postticket=clinica-online" style="display:inline-block; background:var(--dash-accent); color:#fff; padding:15px 30px; text-decoration:none; border-radius:30px; font-weight:bold; margin-top:20px;">Adquirir Temporada 1</a>
                </div>
            <?php else: ?>
                <!-- Featured Series -->
                <div class="dash-section-title">Estas viendo</div>
                <div class="dash-featured">
                    <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/banner-clinica.png" alt="Banner Clínica Online">
                </div>
                <!-- Episodes Section -->
                <div class="dash-section-title">Episodios</div>
                
                <div class="dash-episodes-wrapper">
                    <button class="dash-nav-btn dash-nav-prev" onclick="this.nextElementSibling.scrollBy({ left: -300, behavior: 'smooth' });">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"></polyline></svg>
                    </button>
                    <div class="dash-episodes-grid" id="episodesGrid">
                        <?php
                        $args = array(
                            'post_type'      => 'episodio',
                            'posts_per_page' => -1,
                            'orderby'        => 'menu_order',
                            'order'          => 'ASC'
                        );
                        $query = new WP_Query( $args );
                        $count = 1;
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
                                <div class="dash-episode-card dash-accordion-title" onclick="toggleSubtopics('<?php echo esc_attr($post_id); ?>')">
                                    <img src="<?php echo esc_url($img_src); ?>" class="dash-episode-img" alt="Episodio">
                                    <div class="dash-episode-info">
                                        <h3 class="dash-episode-title">Episodio <?php echo $count; ?> | <?php echo esc_html(get_the_title()); ?> | <?php echo esc_html($especialista); ?></h3>
                                        <div class="dash-episode-meta">
                                            <?php if ($count == 1 || $count == 4) : ?>
                                                <span style="font-weight:bold; color:var(--dash-accent);">Comenzar a mirar</span>
                                            <?php else : ?>
                                                <span style="font-weight:bold; color:var(--dash-accent);">Pronto disponible</span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                        <?php
                            $count++;
                            endwhile;
                        endif;
                        ?>
                    </div>
                    <button class="dash-nav-btn dash-nav-next" onclick="this.previousElementSibling.scrollBy({ left: 300, behavior: 'smooth' });">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"></polyline></svg>
                    </button>
                </div>
                <!-- Contenedor dinámico de subtemas -->
                <div id="subtopicsContainer" style="margin-top: 20px;">
                    <?php
                    $query->rewind_posts();
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
                                    <?php $video_url = get_post_meta($post_id, '_dtd_video_url', true); ?>
                                    <div id="details-intro-<?php echo esc_attr($post_id); ?>" class="video-pane" style="display:block;">
                                        <h3 style="margin-top:0; color:var(--dash-text);">Bienvenido</h3>
                                        <?php if (!empty($video_url)) : ?>
                                            <?php dtd_render_video_iframes($video_url); ?>
                                        <?php else : ?>
                                            <?php 
                                            $fecha_disp = get_post_meta($post_id, '_dtd_fecha_disponibilidad', true);
                                            if (!empty($fecha_disp)) {
                                                echo '<p style="color:var(--dash-accent); font-size:16px; font-weight:bold;">' . esc_html($fecha_disp) . '</p>';
                                            } else {
                                                echo '<p style="color:var(--dash-light-text); font-size:14px;">Selecciona un bloque para comenzar a ver el contenido.</p>';
                                            }
                                            ?>
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
                                                    if (strpos($b_videos, 'http') === false) {
                                                        echo '<p style="color:var(--dash-accent); font-size:16px; font-weight:bold;">' . esc_html(trim($b_videos)) . '</p>';
                                                    } else {
                                                        dtd_render_video_iframes($b_videos); 
                                                    }
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
            <?php endif; // fin if has_access 
        
        } else {
            
            // =========================================================================
            // MODO MULTI-CURSO (NUEVA ARQUITECTURA)
            // =========================================================================
            foreach ( $cursos as $curso ) {
                $has_access = dtd_user_has_access(null, $curso->slug);
                ?>
                <div class="dash-curso-section" style="margin-bottom: 50px;">
                    <div class="dash-section-title" style="font-size:24px; color:var(--dash-accent); margin-bottom: 20px; border-bottom: 2px solid var(--dash-border); padding-bottom: 10px;">
                        <?php echo esc_html($curso->name); ?>
                    </div>
                    
                    <?php if ( ! $has_access ) : ?>
                        <div style="background:#fffa64; padding:40px; border:2px solid #3b2017; border-radius:15px; text-align:center;">
                            <h2>Contenido Bloqueado 🔒</h2>
                            <p style="font-size:18px;">Aún no tienes acceso a <?php echo esc_html($curso->name); ?>. Para ver los episodios, necesitas adquirir el pase.</p>
                            <a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>" style="display:inline-block; background:var(--dash-accent); color:#fff; padding:15px 30px; text-decoration:none; border-radius:30px; font-weight:bold; margin-top:20px;">Adquirir <?php echo esc_html($curso->name); ?></a>
                        </div>
                    <?php else: ?>
                        
                        <!-- Episodes Section -->
                        <div class="dash-episodes-wrapper">
                            <button class="dash-nav-btn dash-nav-prev" onclick="this.nextElementSibling.scrollBy({ left: -300, behavior: 'smooth' });">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"></polyline></svg>
                            </button>
                            <div class="dash-episodes-grid" id="episodesGrid-<?php echo esc_attr($curso->slug); ?>" style="display: flex; gap: 20px; overflow-x: auto; scrollbar-width: none; scroll-behavior: smooth;">
                                <?php
                                $args = array(
                                    'post_type'      => 'episodio',
                                    'posts_per_page' => -1,
                                    'orderby'        => 'menu_order',
                                    'order'          => 'ASC',
                                    'tax_query'      => array(
                                        array(
                                            'taxonomy' => 'curso',
                                            'field'    => 'slug',
                                            'terms'    => $curso->slug,
                                        ),
                                    ),
                                );
                                $query = new WP_Query( $args );
                                $count = 1;
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
                                        <div class="dash-episode-card dash-accordion-title" onclick="toggleSubtopics('<?php echo esc_attr($post_id); ?>')">
                                            <img src="<?php echo esc_url($img_src); ?>" class="dash-episode-img" alt="Episodio">
                                            <div class="dash-episode-info">
                                                <h3 class="dash-episode-title">Episodio <?php echo $count; ?> | <?php echo esc_html(get_the_title()); ?> | <?php echo esc_html($especialista); ?></h3>
                                                <div class="dash-episode-meta">
                                                    <span style="font-weight:bold; color:var(--dash-accent);">Comenzar a mirar</span>
                                                </div>
                                            </div>
                                        </div>
                                <?php
                                    $count++;
                                    endwhile;
                                else:
                                    echo '<p style="padding: 20px; color: var(--dash-light-text);">No hay episodios en este curso aún.</p>';
                                endif;
                                ?>
                            </div>
                            <button class="dash-nav-btn dash-nav-next" onclick="this.previousElementSibling.scrollBy({ left: 300, behavior: 'smooth' });">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"></polyline></svg>
                            </button>
                        </div>
                        <!-- Contenedor dinámico de subtemas -->
                        <div id="subtopicsContainer-<?php echo esc_attr($curso->slug); ?>" style="margin-top: 20px;">
                            <?php
                            $query->rewind_posts();
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
                                            <?php $video_url = get_post_meta($post_id, '_dtd_video_url', true); ?>
                                            <div id="details-intro-<?php echo esc_attr($post_id); ?>" class="video-pane" style="display:block;">
                                                <h3 style="margin-top:0; color:var(--dash-text);">Bienvenido</h3>
                                                <?php if (!empty($video_url)) : ?>
                                                    <?php dtd_render_video_iframes($video_url); ?>
                                                <?php else : ?>
                                                    <?php 
                                                    $fecha_disp = get_post_meta($post_id, '_dtd_fecha_disponibilidad', true);
                                                    if (!empty($fecha_disp)) {
                                                        echo '<p style="color:var(--dash-accent); font-size:16px; font-weight:bold;">' . esc_html($fecha_disp) . '</p>';
                                                    } else {
                                                        echo '<p style="color:var(--dash-light-text); font-size:14px;">Selecciona un bloque para comenzar a ver el contenido.</p>';
                                                    }
                                                    ?>
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
                                                            if (strpos($b_videos, 'http') === false) {
                                                                echo '<p style="color:var(--dash-accent); font-size:16px; font-weight:bold;">' . esc_html(trim($b_videos)) . '</p>';
                                                            } else {
                                                                dtd_render_video_iframes($b_videos); 
                                                            }
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
                </div>
                <?php
            } // fin foreach cursos
        } // fin if-else modo
        ?>
    </main>
</div>

 <script src="https://player.vimeo.com/api/player.js"></script>
<script>
    let activePlayer = null;
    
    // Función para guardar progreso
    function saveProgress(postId, blockIndex) {
        fetch('<?php echo admin_url("admin-ajax.php"); ?>', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: 'action=dtd_save_progress&post_id=' + postId + '&block_index=' + blockIndex
        });
    }

    // Función para encontrar el siguiente bloque (o el primer bloque del siguiente episodio)
    function playNextBlock(currentPostId, currentBlockIndex) {
        let container = document.getElementById('details-pane-' + currentPostId);
        if(!container) return;
        
        let nextBlock = document.getElementById('details-block-' + currentPostId + '-' + (currentBlockIndex + 1));
        
        if (nextBlock) {
            // Ir al siguiente bloque del mismo episodio
            showBlockVideos(currentPostId, currentBlockIndex + 1);
        } else {
            // Ya no hay más bloques en este episodio, intentar ir al siguiente episodio
            let allTitles = Array.from(document.querySelectorAll('.dash-accordion-title'));
            let currentIndex = allTitles.findIndex(el => el.getAttribute('onclick').includes(currentPostId));
            
            if (currentIndex !== -1 && currentIndex + 1 < allTitles.length) {
                let nextTitle = allTitles[currentIndex + 1];
                let nextPostId = nextTitle.getAttribute('onclick').match(/toggleSubtopics\('(\d+)'\)/)[1];
                
                // Abrir el siguiente acordeón
                if (!nextTitle.nextElementSibling || !nextTitle.nextElementSibling.classList.contains('active')) {
                    nextTitle.click();
                }
                
                // Buscar el primer bloque de ese episodio (índice 0 o 1, o el intro)
                setTimeout(() => {
                    let nextFirstBlock = document.getElementById('details-block-' + nextPostId + '-0');
                    if (nextFirstBlock) {
                        showBlockVideos(nextPostId, 0);
                    } else {
                        showBlockVideos(nextPostId, 'intro');
                    }
                }, 300);
            }
        }
    }

    // Mostrar videos de un bloque específico
    function showBlockVideos(postId, blockIndex) {
        saveProgress(postId, blockIndex);
        
        // Ocultar todos los paneles de video de este episodio
        const container = document.getElementById('details-pane-' + postId);
        if(container) {
            const panes = container.querySelectorAll('.video-pane');
            panes.forEach(pane => pane.style.display = 'none');
            
            // Mostrar el bloque solicitado
            let targetId = blockIndex === 'intro' ? 'details-intro-' + postId : 'details-block-' + postId + '-' + blockIndex;
            const targetPane = document.getElementById(targetId);
            if(targetPane) {
                targetPane.style.display = 'block';
                
                // Destruir el reproductor activo anterior para no consumir recursos/audio cruzado
                if (activePlayer) {
                    activePlayer.pause().catch(e => {});
                    activePlayer = null;
                }
                
                // Inicializar nuevo reproductor de Vimeo si existe
                let iframe = targetPane.querySelector('.vimeo-player-iframe');
                if (iframe) {
                    activePlayer = new Vimeo.Player(iframe);
                    activePlayer.on('ended', function() {
                        if (blockIndex !== 'intro') {
                            playNextBlock(postId, parseInt(blockIndex));
                        } else {
                            playNextBlock(postId, -1); // Del intro va al bloque 0
                        }
                    });
                    // Intentar Autoplay 
                    activePlayer.play().catch(function(error) {
                        console.log("Autoplay prevent by browser", error);
                    });
                }
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

    // Auto-load last watched video on init
    document.addEventListener("DOMContentLoaded", function() {
        <?php
        $last_post = get_user_meta(get_current_user_id(), '_dtd_last_watched_post', true);
        $last_block = get_user_meta(get_current_user_id(), '_dtd_last_watched_block', true);
        ?>
        let lastPost = '<?php echo esc_js($last_post); ?>';
        let lastBlock = '<?php echo esc_js($last_block); ?>';
        
        if (lastPost && lastBlock) {
            let titleEl = document.querySelector('.dash-accordion-title[onclick*="' + lastPost + '"]');
            if (titleEl) {
                // Si no está abierto, lo abrimos
                let subtopicsContainer = titleEl.nextElementSibling;
                if (subtopicsContainer && !subtopicsContainer.classList.contains('active')) {
                    titleEl.click();
                }
                setTimeout(() => {
                    showBlockVideos(lastPost, lastBlock);
                }, 500);
            }
        }
    });

</script>

<?php get_footer(); ?>
