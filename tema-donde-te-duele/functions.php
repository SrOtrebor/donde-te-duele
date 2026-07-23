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
