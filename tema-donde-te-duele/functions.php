<?php
/**
 * Funciones y configuraciones del tema Donde te duele.
 */

function donde_te_duele_scripts() {
    // Cargar fuente de Google (Montserrat)
    wp_enqueue_style( 'google-fonts', 'https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap', array(), null );
    // Cargar estilo principal
    wp_enqueue_style( 'donde-te-duele-style', get_stylesheet_uri(), array(), wp_get_theme()->get('Version') );
}
add_action( 'wp_enqueue_scripts', 'donde_te_duele_scripts' );

// Soporte para menú y miniaturas
function donde_te_duele_setup() {
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'title-tag' );
    register_nav_menus( array(
        'menu-1' => esc_html__( 'Primary', 'donde-te-duele' ),
    ) );
    
    // Soporte para WooCommerce y Tutor LMS
    add_theme_support( 'woocommerce' );
    add_theme_support( 'tutor' );
}
add_action( 'after_setup_theme', 'donde_te_duele_setup' );

// Hacer relativas las rutas del tema para que las imágenes funcionen en Local WP Live Links
add_filter( 'template_directory_uri', 'wp_make_link_relative' );
add_filter( 'stylesheet_directory_uri', 'wp_make_link_relative' );

// Incluir registro de Custom Post Type y Metaboxes para Episodios
require_once get_template_directory() . '/inc/episodios-cpt.php';
require_once get_template_directory() . '/inc/import-episodios.php';
// ==============================================================================
// SHORTCODE PARA RESTRINGIR CONTENIDO (SOLO COMPRADORES DE WOOCOMMERCE)
// ==============================================================================
// Uso: [contenido_exclusivo id="26"] Aquí van los videos y textos [/contenido_exclusivo]

add_shortcode('contenido_exclusivo', 'dtd_restringir_contenido');
function dtd_restringir_contenido($atts, $content = null) {
    // Definimos el ID del producto por defecto (26 = Temporada 1)
    $a = shortcode_atts(array(
        'id' => '26'
    ), $atts);

    $producto_id = intval($a['id']);

    // 1. Si no está logueado, le pedimos que inicie sesión
    if ( ! is_user_logged_in() ) {
        $login_url = wc_get_page_permalink( 'myaccount' );
        return '<div style="background:#fffa64; padding:30px; border:2px solid #3b2017; border-radius:10px; text-align:center; font-family:\'Archivo\', sans-serif;">
                    <h3 style="margin-top:0; color:#3b2017;">Debes iniciar sesión</h3>
                    <p style="color:#3b2017; font-size:18px;">Para ver este contenido exclusivo necesitas ingresar a tu cuenta.</p>
                    <a href="' . esc_url($login_url) . '" class="btn-dtd" style="padding:10px 20px; font-size:16px;">Iniciar sesión</a>
                </div>';
    }

    // 2. Si está logueado, verificamos si compró el producto
    $current_user = wp_get_current_user();
    $has_bought = wc_customer_bought_product( $current_user->user_email, $current_user->ID, $producto_id );

    // 3. Si es el administrador (para que vos puedas verlo y editarlo) siempre le damos acceso
    if ( current_user_can('manage_options') ) {
        $has_bought = true;
    }

    // 4. Mostramos el contenido si lo compró, o un error si no lo compró
    if ( $has_bought ) {
        return '<div class="contenido-desbloqueado">' . do_shortcode($content) . '</div>';
    } else {
        $shop_url = wc_get_page_permalink( 'shop' );
        return '<div style="background:#fffa64; padding:30px; border:2px solid #3b2017; border-radius:10px; text-align:center; font-family:\'Archivo\', sans-serif;">
                    <h3 style="margin-top:0; color:#3b2017;">Contenido Restringido 🔒</h3>
                    <p style="color:#3b2017; font-size:18px;">No tienes acceso a esta temporada. Debes adquirirla para poder ver el contenido.</p>
                </div>';
    }
}

// ==============================================================================
// SHORTCODE PARA LA GRILLA DE EPISODIOS (ACORDEONES)
// ==============================================================================
add_shortcode('grilla_episodios', 'dtd_grilla_episodios_shortcode');
function dtd_grilla_episodios_shortcode($atts) {
    $a = shortcode_atts(array(
        'producto_id' => '26'
    ), $atts);

    $producto_id = intval($a['producto_id']);
    $has_bought = false;

    if ( is_user_logged_in() ) {
        $current_user = wp_get_current_user();
        if ( current_user_can('manage_options') || wc_customer_bought_product( $current_user->user_email, $current_user->ID, $producto_id ) ) {
            $has_bought = true;
        }
    }

    $icon_url = $has_bought ? get_template_directory_uri() . '/assets/play.png' : get_template_directory_uri() . '/assets/candado.png';
    $cart_url = wc_get_page_permalink('shop'); // O checkout
    if (!$has_bought) {
        $link_start = '<a href="https://dondeteduele.com/tickets/?postticket=clinica-online" style="text-decoration:none; color:inherit;">';
        $link_end = '</a>';
    } else {
        $link_start = '<a href="#" style="text-decoration:none; color:inherit;">';
        $link_end = '</a>';
    }

    // OBTENER LOS EPISODIOS DESDE LA BASE DE DATOS (CPT)
    $args = array(
        'post_type'      => 'episodio',
        'posts_per_page' => -1,
        'orderby'        => 'menu_order',
        'order'          => 'ASC'
    );
    $query = new WP_Query( $args );
    $episodios = array();

    if ( $query->have_posts() ) {
        while ( $query->have_posts() ) {
            $query->the_post();
            $post_id = get_the_ID();
            $especialista = get_post_meta($post_id, '_dtd_especialista', true);
            $titulo = get_the_title();
            if (!empty($especialista)) {
                $titulo .= ' - Por ' . $especialista;
            }

            $bloques = array();
            for ($i = 0; $i <= 4; $i++) {
                $b_titulo = get_post_meta($post_id, "_dtd_bloque_{$i}_titulo", true);
                if (!empty($b_titulo)) {
                    $bloques[] = $b_titulo;
                }
            }

            $episodios[] = array(
                'titulo'  => $titulo,
                'bloques' => $bloques
            );
        }
        wp_reset_postdata();
    }

    $html = '<style>
        .dtd-accordion-container { max-width: 900px; margin: 40px auto; font-family: "Archivo", sans-serif; color: #3b2017; }
        .dtd-accordion { border: 1px solid #3b2017; border-radius: 8px; margin-bottom: 30px; background: #fdfaf1; overflow: hidden; box-shadow: 2px 2px 0px rgba(59,32,23,0.1); }
        .dtd-accordion-header { background: #bfd43b; padding: 18px 25px; cursor: pointer; display: flex; justify-content: space-between; align-items: center; font-weight: 700; font-size: 18px; border-bottom: 1px solid #3b2017; transition: background 0.2s; }
        .dtd-accordion-header:hover { background: #a9bc34; }
        .dtd-accordion-content { display: none; padding: 30px; }
        .dtd-accordion-content.active { display: block; }
        .dtd-grid { display: flex; flex-wrap: wrap; gap: 20px; }
        .dtd-block { width: 180px; text-align: left; transition: transform 0.2s; }
        .dtd-block:hover { transform: translateY(-3px); }
        .dtd-thumb { background: #e0e0e0; width: 100%; aspect-ratio: 16/10; display: flex; justify-content: center; align-items: center; margin-bottom: 12px; }
        .dtd-thumb img { width: 45px; height: 45px; object-fit: contain; }
        .dtd-text { font-size: 13px; line-height: 1.3; }
        .dtd-arrow { font-size: 16px; font-weight: bold; transform: rotate(0deg); transition: transform 0.3s; }
        .dtd-accordion.open .dtd-arrow { transform: rotate(180deg); }
        @media (max-width: 600px) {
            .dtd-block { width: 100%; display: flex; gap: 15px; align-items: center; }
            .dtd-thumb { width: 120px; margin-bottom: 0; }
        }
    </style>';

    $html .= '<div class="dtd-accordion-container">';

    foreach ($episodios as $index => $ep) {
        $isOpenClass = ($index === 0) ? 'open' : '';
        $isContentActive = ($index === 0) ? 'active' : '';

        $html .= '<div class="dtd-accordion ' . $isOpenClass . '">';
        $html .= '<div class="dtd-accordion-header" onclick="toggleDtdAccordion(this)">';
        $html .= '<span>' . esc_html($ep['titulo']) . '</span>';
        $html .= '<span class="dtd-arrow">^</span>';
        $html .= '</div>';
        $html .= '<div class="dtd-accordion-content ' . $isContentActive . '">';
        $html .= '<div class="dtd-grid">';
        
        foreach ($ep['bloques'] as $bloque) {
            $html .= '<div class="dtd-block">';
            $html .= $link_start;
            $html .= '<div class="dtd-thumb"><img src="' . esc_url($icon_url) . '" alt="icon" /></div>';
            $html .= '<div class="dtd-text">' . esc_html($bloque) . '</div>';
            $html .= $link_end;
            $html .= '</div>';
        }
        
        $html .= '</div>';
        $html .= '</div>';
        $html .= '</div>';
    }

    $html .= '</div>';

    $html .= '<script>
        function toggleDtdAccordion(el) {
            var accordion = el.parentElement;
            var content = el.nextElementSibling;
            if (content.classList.contains("active")) {
                content.classList.remove("active");
                accordion.classList.remove("open");
            } else {
                content.classList.add("active");
                accordion.classList.add("open");
            }
        }
    </script>';

    return $html;
}
