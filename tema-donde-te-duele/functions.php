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
