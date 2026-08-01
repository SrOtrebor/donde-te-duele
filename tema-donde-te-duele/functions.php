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
require_once get_template_directory() . '/inc/alta-alumnos.php';

// ==============================================================================
// CUSTOMIZER (OPCIONES DEL TEMA)
// ==============================================================================
add_action( 'customize_register', 'dtd_customize_register' );
function dtd_customize_register( $wp_customize ) {
    $wp_customize->add_section( 'dtd_textos_section', array(
        'title'      => 'Textos del Sitio',
        'priority'   => 30,
    ) );
    
    $wp_customize->add_setting( 'dtd_banner_duration', array(
        'default' => '2 Horas',
        'sanitize_callback' => 'sanitize_text_field'
    ) );
    $wp_customize->add_control( 'dtd_banner_duration', array(
        'label'    => 'Duración Banner Dashboard (Ej: 2 Horas)',
        'section'  => 'dtd_textos_section',
        'type'     => 'text',
    ) );
    
    $wp_customize->add_setting( 'dtd_footer_banner_title', array(
        'default' => 'HERRAMIENTAS, REFLEXIONES<br>Y NUEVAS PERSPECTIVAS PARA COMPRENDER AQUELLO QUE HOY<br>TE GENERA CONFLICTO.<br>COMPRENDER ES EL PRIMER PASO PARA TU MEJOR VERSIÓN.',
        'sanitize_callback' => 'wp_kses_post'
    ) );
    $wp_customize->add_control( 'dtd_footer_banner_title', array(
        'label'    => 'Título Banner Violeta (Footer) - Soporta <br>',
        'section'  => 'dtd_textos_section',
        'type'     => 'textarea',
    ) );
}

// Cambiar textos de WooCommerce (Botón Ingresar y mensaje de restablecer contraseña)
add_filter( 'gettext', 'dtd_change_woo_texts', 10, 3 );
function dtd_change_woo_texts( $translated, $text, $domain ) {
    if ( 'woocommerce' === $domain ) {
        if ( 'Log in' === $text || 'Acceder' === $text || 'Iniciar sesión' === $text ) {
            $translated = 'Ingresar';
        }
        if ( 'A password reset email has been sent to the email address on file for your account, but may take several minutes to show up in your inbox. Please wait at least 10 minutes before attempting another reset.' === $text ) {
            $translated = 'Se ha enviado un correo electrónico de restablecimiento de contraseña a la dirección de correo electrónico de tu cuenta, pero puede llevar varios minutos que aparezca en tu bandeja de entrada. Por favor, espera al menos 10 minutos antes de intentar otro restablecimiento. También te recomendamos revisar tu carpeta de spam.';
        }
        if ( 'Thanks for creating an account on %1$s. Your username is %2$s. You can access your account area to view orders, change your password, and more at: %3$s' === $text || 'Thanks for creating an account on %1$s. Your username is %2$s.' === $text ) {
            $translated = 'Hola! Te enviamos tu acceso a la clínica online. A partir de ahora ya puedes disfrutar de los contenidos. Tu usuario es %2$s. Ingresa a tu cuenta aquí: %3$s';
        }
    }
    return $translated;
}

// ==============================================================================
// 12. Estilos personalizados para wp-login.php y redirecciones
// ==============================================================================
add_action( 'login_enqueue_scripts', 'dtd_custom_login_logo' );
function dtd_custom_login_logo() {
    ?>
    <style type="text/css">
        #login h1 a, .login h1 a {
            background-image: url(<?php echo get_template_directory_uri(); ?>/assets/logo-dtd-recortado.svg);
            height: 100px;
            width: 100%;
            background-size: contain;
            background-repeat: no-repeat;
            padding-bottom: 10px;
        }
        body.login {
            background-color: #fdfaf1;
            font-family: 'Archivo', sans-serif;
        }
        body.login #login {
            padding: 8% 0 0;
        }
        body.login #backtoblog a, body.login #nav a {
            color: #3b2017 !important;
        }
        body.login #login form {
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }
        .wp-core-ui .button-primary {
            background: #e59bf0 !important;
            border-color: #d182dc !important;
            color: #3b2017 !important;
            border-radius: 20px !important;
            text-transform: uppercase;
            font-weight: bold;
            box-shadow: none !important;
            text-shadow: none !important;
        }
    </style>
    <?php
}

add_filter( 'login_headerurl', 'dtd_custom_login_logo_url' );
function dtd_custom_login_logo_url() {
    return home_url();
}

add_filter( 'login_url', 'dtd_custom_login_url', 10, 3 );
function dtd_custom_login_url( $login_url, $redirect, $force_reauth ) {
    return wc_get_page_permalink( 'myaccount' );
}

// ==============================================================================
// 13. Personalizar email por defecto de WordPress para nuevos usuarios
// ==============================================================================
add_filter( 'wp_new_user_notification_email', 'dtd_custom_wp_new_user_email', 10, 3 );
function dtd_custom_wp_new_user_email( $wp_new_user_notification_email, $user, $blogname ) {
    $key = get_password_reset_key( $user );
    $reset_url = network_site_url("wp-login.php?action=rp&key=$key&login=" . rawurlencode($user->user_login), 'login');
    
    $message = "Hola! Te enviamos tu acceso a la clínica online. A partir de ahora ya puedes disfrutar de los contenidos.\n\n";
    $message .= "Tu usuario es: " . $user->user_email . "\n\n";
    $message .= "Si quieres personalizar tu contraseña, hazlo en la siguiente dirección: \n";
    $message .= $reset_url . "\n\n";
    $message .= "Ingresa a tu cuenta aquí: " . wc_get_page_permalink( 'myaccount' ) . "\n";
    
    $wp_new_user_notification_email['message'] = $message;
    $wp_new_user_notification_email['subject'] = 'Tu acceso a la Clínica Online - ' . $blogname;
    
    return $wp_new_user_notification_email;
}

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

    // 2. Si está logueado, verificamos si compró el producto o si tiene alta manual
    $current_user = wp_get_current_user();
    $has_bought = wc_customer_bought_product( $current_user->user_email, $current_user->ID, $producto_id );
    
    // Verificación adicional para Alta Manual
    if ( get_user_meta( $current_user->ID, '_dtd_acceso_manual_' . $producto_id, true ) ) {
        $has_bought = true;
    }

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
        $has_manual_access = get_user_meta( $current_user->ID, '_dtd_acceso_manual_' . $producto_id, true );
        
        if ( current_user_can('manage_options') || $has_manual_access || wc_customer_bought_product( $current_user->user_email, $current_user->ID, $producto_id ) ) {
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

// ==============================================================================
// 10. AJAX para guardar progreso de video
// ==============================================================================
add_action('wp_ajax_dtd_save_progress', 'dtd_save_progress');
function dtd_save_progress() {
    if (is_user_logged_in() && isset($_POST['post_id']) && isset($_POST['block_index'])) {
        $user_id = get_current_user_id();
        update_user_meta($user_id, '_dtd_last_watched_post', intval($_POST['post_id']));
        update_user_meta($user_id, '_dtd_last_watched_block', sanitize_text_field($_POST['block_index']));
    }
    wp_die();
}

// ==============================================================================
// 11. Cambiar remitente de correos de WordPress (Ej. Restablecer contraseña)
// ==============================================================================
// (Removido completamente para evitar conflictos con el plugin SMTP de Gmail)

// ==============================================================================
// REDIRECCIÓN TRAS LOGIN HACIA EL DASHBOARD DE ALUMNOS
// ==============================================================================
add_filter( 'woocommerce_login_redirect', 'dtd_woo_login_redirect', 10, 2 );
function dtd_woo_login_redirect( $redirect_url, $user ) {
    // Si es administrador, lo mandamos al panel normal
    if ( isset( $user->roles ) && is_array( $user->roles ) && in_array( 'administrator', $user->roles ) ) {
        return admin_url();
    }
    
    // Buscamos dinámicamente la página que usa la plantilla dashboard-template.php
    $pages = get_pages(array(
        'meta_key' => '_wp_page_template',
        'meta_value' => 'dashboard-template.php'
    ));
    
    if (!empty($pages)) {
        return get_permalink($pages[0]->ID);
    }
    
    return $redirect_url;
}

// ==============================================================================
// MODIFICAR MENÚ DE MI CUENTA (WOOCOMMERCE)
// ==============================================================================
add_filter( 'woocommerce_account_menu_items', 'dtd_custom_my_account_menu_items' );
function dtd_custom_my_account_menu_items( $items ) {
    // Eliminar pestañas no deseadas
    unset($items['orders']);
    unset($items['downloads']);
    unset($items['edit-address']);

    // Crear un nuevo array para ordenar los items
    $new_items = array();
    
    foreach ($items as $key => $item) {
        $new_items[$key] = $item;
        // Insertar "Temporada 1" justo después de "dashboard" (Escritorio)
        if ( $key == 'dashboard' ) {
            $new_items['temporada1'] = 'Ver la temporada 1';
        }
    }
    
    return $new_items;
}

// Interceptar la URL del botón Temporada 1 para que lleve al Dashboard real
add_filter( 'woocommerce_get_endpoint_url', 'dtd_custom_woo_endpoint', 10, 4 );
function dtd_custom_woo_endpoint( $url, $endpoint, $value, $permalink ) {
    if ( $endpoint === 'temporada1' ) {
        $pages = get_pages(array(
            'meta_key' => '_wp_page_template',
            'meta_value' => 'dashboard-template.php'
        ));
        if (!empty($pages)) {
            $url = get_permalink($pages[0]->ID);
        }
    }
    return $url;
}
