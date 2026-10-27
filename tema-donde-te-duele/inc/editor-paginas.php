<?php
/**
 * Editor de Contenidos de Páginas (Portada y Temporada 1)
 * Permite al cliente editar textos y fotos desde el panel de WP sin tocar diseño ni código.
 */

// Función auxiliar para obtener contenido con valor por defecto
if ( ! function_exists( 'dtd_get_page_content' ) ) {
    function dtd_get_page_content( $post_id, $meta_key, $default_value = '' ) {
        // 1. Prioridad: opción guardada directamente desde el panel de administración
        $val = get_option( $meta_key, null );
        if ( $val !== null && $val !== '' && $val !== false ) {
            return $val;
        }

        // 2. Si no está en options, buscar en post_meta de la página
        if ( ! $post_id ) {
            $post_id = get_the_ID();
        }
        if ( $post_id ) {
            $meta_val = get_post_meta( $post_id, $meta_key, true );
            if ( $meta_val !== '' && $meta_val !== false && $meta_val !== null ) {
                return $meta_val;
            }
        }

        // 3. Fallback al valor por defecto
        return $default_value;
    }
}

// -----------------------------------------------------------------------------
// 1. MENÚ PRINCIPAL Y SUBMENÚS EN EL PANEL DE WORDPRESS
// -----------------------------------------------------------------------------
add_action( 'admin_menu', 'dtd_register_admin_menus' );
function dtd_register_admin_menus() {
    // Menú Principal
    add_menu_page(
        'Contenido Web',
        '🎨 Editar Sitio Web',
        'edit_pages',
        'dtd-editar-portada',
        'dtd_render_admin_portada_screen',
        'dashicons-welcome-write-blog',
        21
    );

    // Submenú 1: Portada
    add_submenu_page(
        'dtd-editar-portada',
        'Editar Portada',
        '🏠 Portada (Inicio)',
        'edit_pages',
        'dtd-editar-portada',
        'dtd_render_admin_portada_screen'
    );

    // Submenú 2: Temporada 1
    add_submenu_page(
        'dtd-editar-portada',
        'Editar Temporada 1',
        '🎬 Temporada 1',
        'edit_pages',
        'dtd-editar-temporada-1',
        'dtd_render_admin_temporada1_screen'
    );
}

// Cargar librerías de medios de WordPress y estilos del editor
add_action( 'admin_enqueue_scripts', 'dtd_admin_page_editor_scripts' );
function dtd_admin_page_editor_scripts( $hook ) {
    global $post;
    $is_page_edit = ( ( $hook === 'post.php' || $hook === 'post-new.php' ) && isset( $post ) && $post->post_type === 'page' );
    $is_custom_admin = ( strpos( $hook, 'dtd-editar' ) !== false );

    if ( $is_page_edit || $is_custom_admin ) {
        wp_enqueue_media();
        ?>
        <script>
        jQuery(document).ready(function($) {
            // Manejador para selector de imágenes de WordPress
            $(document).on('click', '.dtd-upload-img-btn', function(e) {
                e.preventDefault();
                var btn = $(this);
                var targetInput = $('#' + btn.data('target'));
                var previewImg = $('#' + btn.data('preview'));

                var customUploader = wp.media({
                    title: 'Seleccionar o Subir Imagen',
                    button: { text: 'Usar esta imagen' },
                    multiple: false
                }).on('select', function() {
                    var attachment = customUploader.state().get('selection').first().toJSON();
                    targetInput.val(attachment.url);
                    previewImg.attr('src', attachment.url).show();
                    btn.siblings('.dtd-remove-img-btn').show();
                }).open();
            });

            // Manejador para quitar imagen
            $(document).on('click', '.dtd-remove-img-btn', function(e) {
                e.preventDefault();
                var btn = $(this);
                var targetInput = $('#' + btn.data('target'));
                var previewImg = $('#' + btn.data('preview'));
                var defaultSrc = btn.data('default');

                targetInput.val('');
                if (defaultSrc) {
                    previewImg.attr('src', defaultSrc).show();
                } else {
                    previewImg.hide();
                }
                btn.hide();
            });
        });
        </script>
        <style>
            .dtd-editor-wrap {
                max-width: 1050px;
                margin-top: 20px;
            }
            .dtd-editor-box {
                background: #ffffff;
                border: 1px solid #ccd0d4;
                border-radius: 8px;
                padding: 20px;
                margin-bottom: 24px;
                box-shadow: 0 1px 3px rgba(0,0,0,0.04);
            }
            .dtd-editor-box h3 {
                margin-top: 0;
                margin-bottom: 14px;
                padding-bottom: 10px;
                border-bottom: 2px solid #f0f0f1;
                font-size: 16px;
                color: #1d2327;
                display: flex;
                align-items: center;
                gap: 8px;
            }
            .dtd-field-group {
                margin-bottom: 16px;
            }
            .dtd-field-group label {
                display: block;
                font-weight: 600;
                margin-bottom: 6px;
                color: #2c3338;
                font-size: 13px;
            }
            .dtd-field-group .dtd-hint {
                font-size: 12px;
                color: #646970;
                margin-top: 4px;
                margin-bottom: 0;
            }
            .dtd-field-group input[type="text"],
            .dtd-field-group input[type="url"],
            .dtd-field-group textarea {
                width: 100%;
                border-radius: 4px;
                border: 1px solid #8c8f94;
                padding: 8px 12px;
                font-size: 14px;
                line-height: 1.4;
            }
            .dtd-field-group input:focus,
            .dtd-field-group textarea:focus {
                border-color: #2271b1;
                box-shadow: 0 0 0 1px #2271b1;
                outline: 2px solid transparent;
            }
            .dtd-img-preview-wrap {
                margin-top: 10px;
                margin-bottom: 10px;
                display: inline-block;
                background: #f0f0f1;
                padding: 8px;
                border-radius: 6px;
                border: 1px solid #dcdcde;
            }
            .dtd-img-preview-wrap img {
                max-width: 200px;
                max-height: 160px;
                display: block;
                height: auto;
                border-radius: 4px;
            }
            .dtd-grid-2 {
                display: grid;
                grid-template-columns: 1fr 1fr;
                gap: 18px;
            }
            .dtd-grid-3 {
                display: grid;
                grid-template-columns: 1fr 1fr 1fr;
                gap: 18px;
            }
            .dtd-grid-4 {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(230px, 1fr));
                gap: 18px;
            }
            @media (max-width: 782px) {
                .dtd-grid-2, .dtd-grid-3, .dtd-grid-4 {
                    grid-template-columns: 1fr;
                }
            }
        </style>
        <?php
    }
}

// -----------------------------------------------------------------------------
// 2. FORMULARIO DE EDICIÓN - PORTADA (HOME)
// -----------------------------------------------------------------------------
function dtd_get_home_form_fields( $post_id = 0 ) {
    $default_img_sec2 = get_template_directory_uri() . '/assets/Group%20127.png';

    return array(
        'hero_badge'    => dtd_get_page_content( $post_id, '_dtd_home_hero_badge', 'CLÍNICA ONLINE' ),
        'hero_title'    => dtd_get_page_content( $post_id, '_dtd_home_hero_title', "DÓNDE TE DUELE\nLA VIDA HOY" ),
        'hero_btn_text' => dtd_get_page_content( $post_id, '_dtd_home_hero_btn_text', 'VER DE QUÉ SE TRATA' ),
        'hero_btn_url'  => dtd_get_page_content( $post_id, '_dtd_home_hero_btn_url', '#temporada1' ),

        'sec2_main'     => dtd_get_page_content( $post_id, '_dtd_home_sec2_text_main', "La <strong>Clínica Online</strong> reúne distintas miradas sobre los conflictos que atraviesan la vida cotidiana para <strong>ayudarte a comprender su origen y abrir nuevas posibilidades de transformación.</strong>" ),
        'sec2_item1'    => dtd_get_page_content( $post_id, '_dtd_home_sec2_item1', 'Conversaciones.' ),
        'sec2_item2'    => dtd_get_page_content( $post_id, '_dtd_home_sec2_item2', 'Herramientas y recursos desarrollados por profesionales con diferentes enfoques.' ),
        'sec2_footer'   => dtd_get_page_content( $post_id, '_dtd_home_sec2_text_footer', 'Para profundizar en tu proceso personal cuando vos lo necesites.' ),
        'sec2_img'      => dtd_get_page_content( $post_id, '_dtd_home_sec2_img', '' ),
        'sec2_disp_img' => ! empty( dtd_get_page_content( $post_id, '_dtd_home_sec2_img', '' ) ) ? dtd_get_page_content( $post_id, '_dtd_home_sec2_img', '' ) : $default_img_sec2,
        'default_img'   => $default_img_sec2,

        'sec3_title'    => dtd_get_page_content( $post_id, '_dtd_home_sec3_title', "Para mirar en profundidad\nla experiencia humana" ),
        'sec3_desc'     => dtd_get_page_content( $post_id, '_dtd_home_sec3_desc', "Vas a descubrir nuevas formas de comprender, transitar y transformar los desafíos que suelen aparecer en torno a algunos temas que nos atraviesan." ),
        'sec3_btn_text' => dtd_get_page_content( $post_id, '_dtd_home_sec3_btn_text', 'Ver más detalles' ),
        'sec3_btn_url'  => dtd_get_page_content( $post_id, '_dtd_home_sec3_btn_url', home_url( '/temporada-1/' ) ),
        'sec3_tema1'    => dtd_get_page_content( $post_id, '_dtd_home_sec3_tema1', 'AMOR' ),
        'sec3_tema2'    => dtd_get_page_content( $post_id, '_dtd_home_sec3_tema2', 'TRABAJO' ),
        'sec3_tema3'    => dtd_get_page_content( $post_id, '_dtd_home_sec3_tema3', 'DUELO' ),
        'sec3_tema4'    => dtd_get_page_content( $post_id, '_dtd_home_sec3_tema4', 'CRECIMIENTO PERSONAL' ),

        'sec4_title'    => dtd_get_page_content( $post_id, '_dtd_home_sec4_title', '¿Qué vas a recibir?' ),
        'card1_title'   => dtd_get_page_content( $post_id, '_dtd_home_card1_title', "CONVERSACIONES\nCON REFERENTES\nDEL BIENESTAR" ),
        'card1_text'    => dtd_get_page_content( $post_id, '_dtd_home_card1_text', "Distintas disciplinas para\nampliar tu mirada." ),
        'card2_title'   => dtd_get_page_content( $post_id, '_dtd_home_card2_title', "HERRAMIENTAS\nPARA TU VIDA\nCOTIDIANA" ),
        'card2_text'    => dtd_get_page_content( $post_id, '_dtd_home_card2_text', "Ejercicios, recursos y\nmateriales para seguir\nprofundizando." ),
        'card3_title'   => dtd_get_page_content( $post_id, '_dtd_home_card3_title', "ACCESO ONLINE\nY A TU PROPIO\nRITMO" ),
        'card3_text'    => dtd_get_page_content( $post_id, '_dtd_home_card3_text', "Disponible cuando quieras,\ndesde cualquier lugar." ),

        'sec5_title'    => dtd_get_page_content( $post_id, '_dtd_home_sec5_title', 'Esto es para vos' ),
        'card_pv1'      => dtd_get_page_content( $post_id, '_dtd_home_card_pv1', "SI QUERÉS\nPROFUNDIZAR" ),
        'card_pv2'      => dtd_get_page_content( $post_id, '_dtd_home_card_pv2', "SI BUSCAS\nRED REAL" ),
        'card_pv3'      => dtd_get_page_content( $post_id, '_dtd_home_card_pv3', "SI QUERÉS PRÁCTICA,\nNO TEORÍA" ),
        'card_pv4'      => dtd_get_page_content( $post_id, '_dtd_home_card_pv4', "SI SENTÍS QUE ALGO\nSE REPITE" ),
        'card_pv5'      => dtd_get_page_content( $post_id, '_dtd_home_card_pv5', "SI YA PROBASTE\nY NO FUNCIONÓ" ),
        'card_pv6'      => dtd_get_page_content( $post_id, '_dtd_home_card_pv6', "SI QUERÉS\nCLARIDAD REAL" ),
    );
}

function dtd_render_home_fields_html( $f ) {
    ?>
    <!-- 1. HERO -->
    <div class="dtd-editor-box" style="border-left: 4px solid #3b2017;">
        <h3>📌 1. Sección Principal (Hero)</h3>
        <div class="dtd-grid-2">
            <div class="dtd-field-group">
                <label for="dtd_home_hero_badge">Etiqueta Superior:</label>
                <input type="text" id="dtd_home_hero_badge" name="dtd_home_hero_badge" value="<?php echo esc_attr( $f['hero_badge'] ); ?>">
            </div>
            <div class="dtd-field-group">
                <label for="dtd_home_hero_btn_text">Texto del Botón:</label>
                <input type="text" id="dtd_home_hero_btn_text" name="dtd_home_hero_btn_text" value="<?php echo esc_attr( $f['hero_btn_text'] ); ?>">
            </div>
        </div>
        <div class="dtd-field-group">
            <label for="dtd_home_hero_title">Título Grande (podés usar saltos de línea):</label>
            <textarea id="dtd_home_hero_title" name="dtd_home_hero_title" rows="2"><?php echo esc_textarea( $f['hero_title'] ); ?></textarea>
        </div>
        <div class="dtd-field-group">
            <label for="dtd_home_hero_btn_url">Enlace del Botón (ej: #temporada1 o URL completa):</label>
            <input type="text" id="dtd_home_hero_btn_url" name="dtd_home_hero_btn_url" value="<?php echo esc_attr( $f['hero_btn_url'] ); ?>">
        </div>
    </div>

    <!-- 2. SECCIÓN AMARILLA -->
    <div class="dtd-editor-box" style="border-left: 4px solid #f0b849;">
        <h3>💛 2. La Clínica Online (Fondo Amarillo)</h3>
        <div class="dtd-field-group">
            <label for="dtd_home_sec2_text_main">Texto Principal de Presentación:</label>
            <textarea id="dtd_home_sec2_text_main" name="dtd_home_sec2_text_main" rows="3"><?php echo esc_textarea( $f['sec2_main'] ); ?></textarea>
            <p class="dtd-hint">Permite etiquetas como &lt;strong&gt;texto en negrita&lt;/strong&gt;.</p>
        </div>
        <div class="dtd-grid-2">
            <div class="dtd-field-group">
                <label for="dtd_home_sec2_item1">Ítem 1 (💬 Conversaciones):</label>
                <input type="text" id="dtd_home_sec2_item1" name="dtd_home_sec2_item1" value="<?php echo esc_attr( $f['sec2_item1'] ); ?>">
            </div>
            <div class="dtd-field-group">
                <label for="dtd_home_sec2_item2">Ítem 2 (📝 Herramientas):</label>
                <input type="text" id="dtd_home_sec2_item2" name="dtd_home_sec2_item2" value="<?php echo esc_attr( $f['sec2_item2'] ); ?>">
            </div>
        </div>
        <div class="dtd-field-group">
            <label for="dtd_home_sec2_text_footer">Texto de Cierre (Negrita abajo):</label>
            <input type="text" id="dtd_home_sec2_text_footer" name="dtd_home_sec2_text_footer" value="<?php echo esc_attr( $f['sec2_footer'] ); ?>">
        </div>
        <div class="dtd-field-group">
            <label>Foto / Ilustración Derecha:</label>
            <div class="dtd-img-preview-wrap">
                <img id="dtd_preview_sec2_img" src="<?php echo esc_url( $f['sec2_disp_img'] ); ?>" alt="Vista previa">
            </div>
            <br>
            <input type="hidden" id="dtd_home_sec2_img" name="dtd_home_sec2_img" value="<?php echo esc_attr( $f['sec2_img'] ); ?>">
            <button type="button" class="button button-secondary dtd-upload-img-btn" data-target="dtd_home_sec2_img" data-preview="dtd_preview_sec2_img">📷 Elegir / Cambiar Foto</button>
            <button type="button" class="button dtd-remove-img-btn" data-target="dtd_home_sec2_img" data-preview="dtd_preview_sec2_img" data-default="<?php echo esc_url( $f['default_img'] ); ?>" style="<?php echo empty( $f['sec2_img'] ) ? 'display:none;' : ''; ?>">Quitar Foto Personalizada</button>
        </div>
    </div>

    <!-- 3. SECCIÓN VIOLETA -->
    <div class="dtd-editor-box" style="border-left: 4px solid #b373bd;">
        <h3>💜 3. Temporada 1 (Fondo Violeta)</h3>
        <div class="dtd-field-group">
            <label for="dtd_home_sec3_title">Título Principal:</label>
            <textarea id="dtd_home_sec3_title" name="dtd_home_sec3_title" rows="2"><?php echo esc_textarea( $f['sec3_title'] ); ?></textarea>
        </div>
        <div class="dtd-field-group">
            <label for="dtd_home_sec3_desc">Texto Descriptivo:</label>
            <textarea id="dtd_home_sec3_desc" name="dtd_home_sec3_desc" rows="3"><?php echo esc_textarea( $f['sec3_desc'] ); ?></textarea>
        </div>
        <div class="dtd-grid-2">
            <div class="dtd-field-group">
                <label for="dtd_home_sec3_btn_text">Texto del Botón:</label>
                <input type="text" id="dtd_home_sec3_btn_text" name="dtd_home_sec3_btn_text" value="<?php echo esc_attr( $f['sec3_btn_text'] ); ?>">
            </div>
            <div class="dtd-field-group">
                <label for="dtd_home_sec3_btn_url">Enlace del Botón:</label>
                <input type="text" id="dtd_home_sec3_btn_url" name="dtd_home_sec3_btn_url" value="<?php echo esc_attr( $f['sec3_btn_url'] ); ?>">
            </div>
        </div>
        <p><strong>Nombres de los 4 Episodios / Ejes:</strong></p>
        <div class="dtd-grid-2">
            <div class="dtd-field-group">
                <label for="dtd_home_sec3_tema1">Episodio 1 (🩷):</label>
                <input type="text" id="dtd_home_sec3_tema1" name="dtd_home_sec3_tema1" value="<?php echo esc_attr( $f['sec3_tema1'] ); ?>">
            </div>
            <div class="dtd-field-group">
                <label for="dtd_home_sec3_tema2">Episodio 2 (💼):</label>
                <input type="text" id="dtd_home_sec3_tema2" name="dtd_home_sec3_tema2" value="<?php echo esc_attr( $f['sec3_tema2'] ); ?>">
            </div>
            <div class="dtd-field-group">
                <label for="dtd_home_sec3_tema3">Episodio 3 (❤️‍🩹):</label>
                <input type="text" id="dtd_home_sec3_tema3" name="dtd_home_sec3_tema3" value="<?php echo esc_attr( $f['sec3_tema3'] ); ?>">
            </div>
            <div class="dtd-field-group">
                <label for="dtd_home_sec3_tema4">Episodio 4 (🌟):</label>
                <input type="text" id="dtd_home_sec3_tema4" name="dtd_home_sec3_tema4" value="<?php echo esc_attr( $f['sec3_tema4'] ); ?>">
            </div>
        </div>
    </div>

    <!-- 4. SECCIÓN NARANJA -->
    <div class="dtd-editor-box" style="border-left: 4px solid #e0834c;">
        <h3>🧡 4. ¿Qué vas a recibir? (Fondo Naranja)</h3>
        <div class="dtd-field-group">
            <label for="dtd_home_sec4_title">Título de la Sección:</label>
            <input type="text" id="dtd_home_sec4_title" name="dtd_home_sec4_title" value="<?php echo esc_attr( $f['sec4_title'] ); ?>">
        </div>
        <div class="dtd-grid-3">
            <div style="background:#fff8ee; padding:12px; border:1px solid #ebd3b6; border-radius:5px;">
                <p style="margin-top:0;"><strong>Tarjeta 1</strong></p>
                <div class="dtd-field-group">
                    <label for="dtd_home_card1_title">Título:</label>
                    <textarea id="dtd_home_card1_title" name="dtd_home_card1_title" rows="3"><?php echo esc_textarea( $f['card1_title'] ); ?></textarea>
                </div>
                <div class="dtd-field-group">
                    <label for="dtd_home_card1_text">Descripción:</label>
                    <textarea id="dtd_home_card1_text" name="dtd_home_card1_text" rows="3"><?php echo esc_textarea( $f['card1_text'] ); ?></textarea>
                </div>
            </div>
            <div style="background:#fff8ee; padding:12px; border:1px solid #ebd3b6; border-radius:5px;">
                <p style="margin-top:0;"><strong>Tarjeta 2</strong></p>
                <div class="dtd-field-group">
                    <label for="dtd_home_card2_title">Título:</label>
                    <textarea id="dtd_home_card2_title" name="dtd_home_card2_title" rows="3"><?php echo esc_textarea( $f['card2_title'] ); ?></textarea>
                </div>
                <div class="dtd-field-group">
                    <label for="dtd_home_card2_text">Descripción:</label>
                    <textarea id="dtd_home_card2_text" name="dtd_home_card2_text" rows="3"><?php echo esc_textarea( $f['card2_text'] ); ?></textarea>
                </div>
            </div>
            <div style="background:#fff8ee; padding:12px; border:1px solid #ebd3b6; border-radius:5px;">
                <p style="margin-top:0;"><strong>Tarjeta 3</strong></p>
                <div class="dtd-field-group">
                    <label for="dtd_home_card3_title">Título:</label>
                    <textarea id="dtd_home_card3_title" name="dtd_home_card3_title" rows="3"><?php echo esc_textarea( $f['card3_title'] ); ?></textarea>
                </div>
                <div class="dtd-field-group">
                    <label for="dtd_home_card3_text">Descripción:</label>
                    <textarea id="dtd_home_card3_text" name="dtd_home_card3_text" rows="3"><?php echo esc_textarea( $f['card3_text'] ); ?></textarea>
                </div>
            </div>
        </div>
    </div>

    <!-- 5. SECCIÓN CREMA -->
    <div class="dtd-editor-box" style="border-left: 4px solid #8e9447;">
        <h3>🤍 5. Esto es para vos (Fondo Crema)</h3>
        <div class="dtd-field-group">
            <label for="dtd_home_sec5_title">Título de la Sección:</label>
            <input type="text" id="dtd_home_sec5_title" name="dtd_home_sec5_title" value="<?php echo esc_attr( $f['sec5_title'] ); ?>">
        </div>
        <p><strong>Textos de las 6 Tarjetas:</strong></p>
        <div class="dtd-grid-3">
            <div class="dtd-field-group">
                <label for="dtd_home_card_pv1">Tarjeta 1 (Violeta):</label>
                <textarea id="dtd_home_card_pv1" name="dtd_home_card_pv1" rows="2"><?php echo esc_textarea( $f['card_pv1'] ); ?></textarea>
            </div>
            <div class="dtd-field-group">
                <label for="dtd_home_card_pv2">Tarjeta 2 (Naranja):</label>
                <textarea id="dtd_home_card_pv2" name="dtd_home_card_pv2" rows="2"><?php echo esc_textarea( $f['card_pv2'] ); ?></textarea>
            </div>
            <div class="dtd-field-group">
                <label for="dtd_home_card_pv3">Tarjeta 3 (Verde):</label>
                <textarea id="dtd_home_card_pv3" name="dtd_home_card_pv3" rows="2"><?php echo esc_textarea( $f['card_pv3'] ); ?></textarea>
            </div>
            <div class="dtd-field-group">
                <label for="dtd_home_card_pv4">Tarjeta 4 (Naranja):</label>
                <textarea id="dtd_home_card_pv4" name="dtd_home_card_pv4" rows="2"><?php echo esc_textarea( $f['card_pv4'] ); ?></textarea>
            </div>
            <div class="dtd-field-group">
                <label for="dtd_home_card_pv5">Tarjeta 5 (Verde):</label>
                <textarea id="dtd_home_card_pv5" name="dtd_home_card_pv5" rows="2"><?php echo esc_textarea( $f['card_pv5'] ); ?></textarea>
            </div>
            <div class="dtd-field-group">
                <label for="dtd_home_card_pv6">Tarjeta 6 (Violeta):</label>
                <textarea id="dtd_home_card_pv6" name="dtd_home_card_pv6" rows="2"><?php echo esc_textarea( $f['card_pv6'] ); ?></textarea>
            </div>
        </div>
    </div>
    <?php
}

// Pantalla Portada
function dtd_render_admin_portada_screen() {
    $updated = false;

    if ( isset( $_POST['dtd_admin_save_nonce'] ) && wp_verify_nonce( $_POST['dtd_admin_save_nonce'], 'dtd_save_portada_admin' ) ) {
        $all_fields = array(
            '_dtd_home_hero_badge'        => 'text',
            '_dtd_home_hero_btn_text'     => 'text',
            '_dtd_home_hero_btn_url'      => 'text',
            '_dtd_home_sec2_item1'        => 'text',
            '_dtd_home_sec2_item2'        => 'text',
            '_dtd_home_sec2_text_footer'  => 'text',
            '_dtd_home_sec3_btn_text'     => 'text',
            '_dtd_home_sec3_btn_url'      => 'text',
            '_dtd_home_sec3_tema1'        => 'text',
            '_dtd_home_sec3_tema2'        => 'text',
            '_dtd_home_sec3_tema3'        => 'text',
            '_dtd_home_sec3_tema4'        => 'text',
            '_dtd_home_sec4_title'        => 'text',
            '_dtd_home_sec5_title'        => 'text',
            '_dtd_home_hero_title'        => 'html',
            '_dtd_home_sec2_text_main'    => 'html',
            '_dtd_home_sec3_title'        => 'html',
            '_dtd_home_sec3_desc'         => 'html',
            '_dtd_home_card1_title'       => 'html',
            '_dtd_home_card1_text'        => 'html',
            '_dtd_home_card2_title'       => 'html',
            '_dtd_home_card2_text'        => 'html',
            '_dtd_home_card3_title'       => 'html',
            '_dtd_home_card3_text'        => 'html',
            '_dtd_home_card_pv1'          => 'html',
            '_dtd_home_card_pv2'          => 'html',
            '_dtd_home_card_pv3'          => 'html',
            '_dtd_home_card_pv4'          => 'html',
            '_dtd_home_card_pv5'          => 'html',
            '_dtd_home_card_pv6'          => 'html',
            '_dtd_home_sec2_img'          => 'url',
        );

        $front_page_id = (int) get_option( 'page_on_front' );

        foreach ( $all_fields as $key => $type ) {
            $post_k = ltrim( $key, '_' );
            if ( isset( $_POST[ $post_k ] ) ) {
                $raw = wp_unslash( $_POST[ $post_k ] );
                if ( $type === 'text' ) {
                    $clean = sanitize_text_field( $raw );
                } elseif ( $type === 'url' ) {
                    $clean = esc_url_raw( $raw );
                } else {
                    $clean = wp_kses_post( $raw );
                }
                update_option( $key, $clean );
                if ( $front_page_id > 0 ) {
                    update_post_meta( $front_page_id, $key, $clean );
                }
            }
        }
        $updated = true;
    }

    $f = dtd_get_home_form_fields( 0 );
    ?>
    <div class="wrap dtd-editor-wrap">
        <h1 style="display:flex; align-items:center; gap:10px;">
            🏠 <span>Editar Portada (Inicio)</span>
        </h1>
        <p style="font-size:14px; color:#50575e;">
            Aquí podés cambiar todos los textos y fotos de la página principal. <strong>El diseño de Figma se mantendrá 100% perfecto e intacto.</strong>
        </p>

        <?php if ( $updated ) : ?>
            <div class="notice notice-success is-dismissible" style="padding:10px 15px; border-left-color:#46b450;">
                <p><strong>✅ ¡Cambios guardados con éxito!</strong> Ya están visibles en la portada.</p>
            </div>
        <?php endif; ?>

        <form method="post" action="">
            <?php wp_nonce_field( 'dtd_save_portada_admin', 'dtd_admin_save_nonce' ); ?>
            <?php dtd_render_home_fields_html( $f ); ?>

            <div style="position:sticky; bottom:20px; background:#fff; padding:15px 20px; border:1px solid #ccd0d4; border-radius:8px; box-shadow:0 4px 10px rgba(0,0,0,0.1); display:flex; align-items:center; justify-content:space-between; z-index:99;">
                <span style="color:#50575e; font-size:13px;">No olvides hacer clic en guardar para aplicar los cambios a la web.</span>
                <input type="submit" class="button button-primary button-large" value="💾 Guardar Cambios en la Portada" style="font-size:15px; padding:6px 24px; height:auto;">
            </div>
        </form>
    </div>
    <?php
}

// -----------------------------------------------------------------------------
// 3. FORMULARIO DE EDICIÓN - TEMPORADA 1
// -----------------------------------------------------------------------------
function dtd_get_t1_form_fields( $post_id = 0 ) {
    $base_dir = get_template_directory_uri() . '/assets/temporada1/DTDLVH_Elearning_HOME_img/source/';

    return array(
        // Hero
        'hero_title'        => dtd_get_page_content( $post_id, '_dtd_t1_hero_title', "Cuatro miradas para\ncomprender aquello que\nhoy atraviesa tu vida." ),
        'hero_subtitle'     => dtd_get_page_content( $post_id, '_dtd_t1_hero_subtitle', "Una colección de contenidos online donde referentes de distintas disciplinas comparten herramientas, experiencias y nuevas perspectivas para ayudarte a comprender los conflictos que aparecen en torno al amor, el dinero, el duelo y el crecimiento personal." ),

        // Expositores
        'exp_title'         => dtd_get_page_content( $post_id, '_dtd_t1_exp_title', '¿Qué es la Temporada 1?' ),
        'exp_desc'          => dtd_get_page_content( $post_id, '_dtd_t1_exp_desc', 'La Temporada 1 es un ciclo de encuentros grabados por especialistas que abordan cada uno de los temas que más atraviesan tu experiencia humana.' ),

        'esp_1_img'         => dtd_get_page_content( $post_id, '_dtd_t1_esp_1_img', '' ),
        'esp_1_disp_img'    => ! empty( dtd_get_page_content( $post_id, '_dtd_t1_esp_1_img', '' ) ) ? dtd_get_page_content( $post_id, '_dtd_t1_esp_1_img', '' ) : $base_dir . 'claudio.png',
        'esp_1_cat'         => dtd_get_page_content( $post_id, '_dtd_t1_esp_1_cat', 'Amor' ),
        'esp_1_name'        => dtd_get_page_content( $post_id, '_dtd_t1_esp_1_name', 'Por Claudio A. González' ),
        'esp_1_desc'        => dtd_get_page_content( $post_id, '_dtd_t1_esp_1_desc', 'Explorá cómo los vínculos, las lealtades familiares y las dinámicas invisibles pueden influir en tu forma de amar y relacionarte.' ),

        'esp_2_img'         => dtd_get_page_content( $post_id, '_dtd_t1_esp_2_img', '' ),
        'esp_2_disp_img'    => ! empty( dtd_get_page_content( $post_id, '_dtd_t1_esp_2_img', '' ) ) ? dtd_get_page_content( $post_id, '_dtd_t1_esp_2_img', '' ) : $base_dir . 'maxi.png',
        'esp_2_cat'         => dtd_get_page_content( $post_id, '_dtd_t1_esp_2_cat', 'Dinero' ),
        'esp_2_name'        => dtd_get_page_content( $post_id, '_dtd_t1_esp_2_name', 'Por Maxi González' ),
        'esp_2_desc'        => dtd_get_page_content( $post_id, '_dtd_t1_esp_2_desc', 'Una mirada sobre las creencias, historias y narrativas que condicionan tu relación con el dinero, el valor personal y la abundancia.' ),

        'esp_3_img'         => dtd_get_page_content( $post_id, '_dtd_t1_esp_3_img', '' ),
        'esp_3_disp_img'    => ! empty( dtd_get_page_content( $post_id, '_dtd_t1_esp_3_img', '' ) ) ? dtd_get_page_content( $post_id, '_dtd_t1_esp_3_img', '' ) : $base_dir . 'mery.png',
        'esp_3_cat'         => dtd_get_page_content( $post_id, '_dtd_t1_esp_3_cat', 'Duelo' ),
        'esp_3_name'        => dtd_get_page_content( $post_id, '_dtd_t1_esp_3_name', 'Por Mery Molinero' ),
        'esp_3_desc'        => dtd_get_page_content( $post_id, '_dtd_t1_esp_3_desc', 'Un recorrido para comprender los procesos de pérdida, cierre y transformación que atraviesan distintos momentos de la vida.' ),

        'esp_4_img'         => dtd_get_page_content( $post_id, '_dtd_t1_esp_4_img', '' ),
        'esp_4_disp_img'    => ! empty( dtd_get_page_content( $post_id, '_dtd_t1_esp_4_img', '' ) ) ? dtd_get_page_content( $post_id, '_dtd_t1_esp_4_img', '' ) : $base_dir . 'cesar.png',
        'esp_4_cat'         => dtd_get_page_content( $post_id, '_dtd_t1_esp_4_cat', 'Crecimiento' ),
        'esp_4_name'        => dtd_get_page_content( $post_id, '_dtd_t1_esp_4_name', 'Por César Trombino' ),
        'esp_4_desc'        => dtd_get_page_content( $post_id, '_dtd_t1_esp_4_desc', 'Una invitación a observar los bloqueos, síntomas y aprendizajes que aparecen cuando la vida nos impulsa a evolucionar.' ),

        // Precios
        'llevas_title'      => dtd_get_page_content( $post_id, '_dtd_t1_llevas_title', '¿Qué te llevás?' ),
        'llevas_hs_num'     => dtd_get_page_content( $post_id, '_dtd_t1_llevas_hs_num', '+5' ),
        'llevas_hs_unit'    => dtd_get_page_content( $post_id, '_dtd_t1_llevas_hs_unit', 'HS' ),
        'llevas_caja1_text' => dtd_get_page_content( $post_id, '_dtd_t1_llevas_caja1_text', "EN CAPÍTULOS TEMÁTICOS\nDIVIDIDOS POR BLOQUES" ),
        'llevas_caja2_text' => dtd_get_page_content( $post_id, '_dtd_t1_llevas_caja2_text', "ACCESO ONLINE\nY A TU PROPIO\nRITMO" ),
        'promo_badge'       => dtd_get_page_content( $post_id, '_dtd_t1_promo_badge', '¡Aprovechá!' ),
        'promo_tag'         => dtd_get_page_content( $post_id, '_dtd_t1_promo_tag', "PRECIO\nLANZAMIENTO" ),
        'promo_price'       => dtd_get_page_content( $post_id, '_dtd_t1_promo_price', '$95.000' ),
        'reg_tag'           => dtd_get_page_content( $post_id, '_dtd_t1_reg_tag', "PRECIO\nREGULAR" ),
        'reg_price'         => dtd_get_page_content( $post_id, '_dtd_t1_reg_price', '$300.000' ),
        'btn_loquiero_text' => dtd_get_page_content( $post_id, '_dtd_t1_btn_loquiero_text', 'LO QUIERO' ),
        'btn_loquiero_url'  => dtd_get_page_content( $post_id, '_dtd_t1_btn_loquiero_url', 'https://dondeteduele.com/tickets/?postticket=clinica-online' ),

        // Explorar
        'explorar_title'    => dtd_get_page_content( $post_id, '_dtd_t1_explorar_title', '¿Qué vas a explorar?' ),
        'explorar_desc'     => dtd_get_page_content( $post_id, '_dtd_t1_explorar_desc', 'Cada especialista aborda un tema desde su propia experiencia y enfoque, ofreciendo distintas herramientas para comprender aquello que hoy está atravesando tu vida.' ),
        'explorar_sub'      => dtd_get_page_content( $post_id, '_dtd_t1_explorar_sub', 'Conocé el contenido de cada episodio' ),
        'btn_accede_text'   => dtd_get_page_content( $post_id, '_dtd_t1_btn_accede_text', 'ACCEDÉ A LA TEMPORADA' ),
        'btn_accede_url'    => dtd_get_page_content( $post_id, '_dtd_t1_btn_accede_url', 'https://dondeteduele.com/tickets/?postticket=clinica-online' ),

        // CTA
        'cta_title'         => dtd_get_page_content( $post_id, '_dtd_t1_cta_title', 'COMPRENDER LO QUE TE PASA PUEDE CAMBIAR LA FORMA EN QUE LO VIVÍS.' ),
        'cta_btn_text'      => dtd_get_page_content( $post_id, '_dtd_t1_cta_btn_text', '¡MIRALA AHORA!' ),
        'cta_btn_url'       => dtd_get_page_content( $post_id, '_dtd_t1_cta_btn_url', 'https://dondeteduele.com/tickets/?postticket=clinica-online' ),

        // FAQ
        'faq_title'         => dtd_get_page_content( $post_id, '_dtd_t1_faq_title', 'FAQ' ),
        'faq_1_q'           => dtd_get_page_content( $post_id, '_dtd_t1_faq_1_q', '¿CÓMO ACCEDO AL CONTENIDO?' ),
        'faq_1_a'           => dtd_get_page_content( $post_id, '_dtd_t1_faq_1_a', 'Una vez realizada la compra recibirás un correo con tus datos de acceso. Desde ese momento podrás ingresar a la plataforma cuando quieras y avanzar a tu propio ritmo.' ),
        'faq_2_q'           => dtd_get_page_content( $post_id, '_dtd_t1_faq_2_q', '¿DURANTE CUÁNTO TIEMPO TENDRÉ ACCESO?' ),
        'faq_2_a'           => dtd_get_page_content( $post_id, '_dtd_t1_faq_2_a', 'La compra incluye acceso a la Temporada 1 para que puedas volver a verla siempre que lo necesites. (Si luego definen otro plazo se modifica).' ),
        'faq_3_q'           => dtd_get_page_content( $post_id, '_dtd_t1_faq_3_q', '¿NECESITO CONOCIMIENTOS PREVIOS?' ),
        'faq_3_a'           => dtd_get_page_content( $post_id, '_dtd_t1_faq_3_a', 'No. Los contenidos están pensados para cualquier persona interesada en comprender mejor su historia personal y explorar nuevas herramientas para su bienestar.' ),
        'faq_4_q'           => dtd_get_page_content( $post_id, '_dtd_t1_faq_4_q', '¿LOS EPISODIOS DEBEN VERSE EN ORDEN?' ),
        'faq_4_a'           => dtd_get_page_content( $post_id, '_dtd_t1_faq_4_a', 'Podés recorrerlos como prefieras. Cada episodio aborda un tema diferente y funciona de manera independiente, aunque juntos ofrecen una mirada más amplia sobre distintos aspectos de la vida.' ),
        'faq_5_q'           => dtd_get_page_content( $post_id, '_dtd_t1_faq_5_q', '¿INCLUYE MATERIAL COMPLEMENTARIO?' ),
        'faq_5_a'           => dtd_get_page_content( $post_id, '_dtd_t1_faq_5_a', 'Sí. Cada episodio cuenta con un material descargable que te permitirá profundizar los conceptos y llevar las reflexiones a tu vida cotidiana.' ),
        'faq_6_q'           => dtd_get_page_content( $post_id, '_dtd_t1_faq_6_q', '¿QUÉ TEMAS INCLUYE ESTA TEMPORADA?' ),
        'faq_6_a'           => dtd_get_page_content( $post_id, '_dtd_t1_faq_6_a', 'La Temporada 1 aborda cuatro grandes ejes: el amor, el dinero, el duelo y el crecimiento personal, desarrollados por Claudio Alberto González, Maxi González, Mery Molinero y César Trombino.' ),
    );
}

function dtd_render_t1_fields_html( $f ) {
    ?>
    <!-- 1. HERO -->
    <div class="dtd-editor-box" style="border-left: 4px solid #b373bd;">
        <h3>📌 1. Encabezado de la Temporada 1 (Hero)</h3>
        <div class="dtd-field-group">
            <label for="dtd_t1_hero_title">Título Principal:</label>
            <textarea id="dtd_t1_hero_title" name="dtd_t1_hero_title" rows="2"><?php echo esc_textarea( $f['hero_title'] ); ?></textarea>
        </div>
        <div class="dtd-field-group">
            <label for="dtd_t1_hero_subtitle">Bajada / Descripción:</label>
            <textarea id="dtd_t1_hero_subtitle" name="dtd_t1_hero_subtitle" rows="3"><?php echo esc_textarea( $f['hero_subtitle'] ); ?></textarea>
        </div>
    </div>

    <!-- 2. EXPOSITORES -->
    <div class="dtd-editor-box" style="border-left: 4px solid #f0b849;">
        <h3>👥 2. Especialistas / Expositores</h3>
        <div class="dtd-grid-2">
            <div class="dtd-field-group">
                <label for="dtd_t1_exp_title">Título de la Sección:</label>
                <input type="text" id="dtd_t1_exp_title" name="dtd_t1_exp_title" value="<?php echo esc_attr( $f['exp_title'] ); ?>">
            </div>
            <div class="dtd-field-group">
                <label for="dtd_t1_exp_desc">Bajada:</label>
                <input type="text" id="dtd_t1_exp_desc" name="dtd_t1_exp_desc" value="<?php echo esc_attr( $f['exp_desc'] ); ?>">
            </div>
        </div>

        <div class="dtd-grid-4" style="margin-top:15px;">
            <!-- Especialista 1 -->
            <div style="background:#fffcf5; padding:12px; border:1px solid #e0d0b8; border-radius:6px;">
                <p><strong>Especialista 1</strong></p>
                <div class="dtd-field-group">
                    <label>Foto:</label>
                    <div class="dtd-img-preview-wrap">
                        <img id="dtd_preview_esp_1" src="<?php echo esc_url( $f['esp_1_disp_img'] ); ?>">
                    </div>
                    <input type="hidden" id="dtd_t1_esp_1_img" name="dtd_t1_esp_1_img" value="<?php echo esc_attr( $f['esp_1_img'] ); ?>">
                    <button type="button" class="button dtd-upload-img-btn" data-target="dtd_t1_esp_1_img" data-preview="dtd_preview_esp_1">📷 Elegir Foto</button>
                    <button type="button" class="button dtd-remove-img-btn" data-target="dtd_t1_esp_1_img" data-preview="dtd_preview_esp_1" data-default="<?php echo esc_url( get_template_directory_uri() . '/assets/temporada1/DTDLVH_Elearning_HOME_img/source/claudio.png' ); ?>" style="<?php echo empty( $f['esp_1_img'] ) ? 'display:none;' : ''; ?>">Quitar</button>
                </div>
                <div class="dtd-field-group">
                    <label>Eje / Categoría:</label>
                    <input type="text" name="dtd_t1_esp_1_cat" value="<?php echo esc_attr( $f['esp_1_cat'] ); ?>">
                </div>
                <div class="dtd-field-group">
                    <label>Nombre:</label>
                    <input type="text" name="dtd_t1_esp_1_name" value="<?php echo esc_attr( $f['esp_1_name'] ); ?>">
                </div>
                <div class="dtd-field-group">
                    <label>Descripción:</label>
                    <textarea name="dtd_t1_esp_1_desc" rows="3"><?php echo esc_textarea( $f['esp_1_desc'] ); ?></textarea>
                </div>
            </div>

            <!-- Especialista 2 -->
            <div style="background:#fffcf5; padding:12px; border:1px solid #e0d0b8; border-radius:6px;">
                <p><strong>Especialista 2</strong></p>
                <div class="dtd-field-group">
                    <label>Foto:</label>
                    <div class="dtd-img-preview-wrap">
                        <img id="dtd_preview_esp_2" src="<?php echo esc_url( $f['esp_2_disp_img'] ); ?>">
                    </div>
                    <input type="hidden" id="dtd_t1_esp_2_img" name="dtd_t1_esp_2_img" value="<?php echo esc_attr( $f['esp_2_img'] ); ?>">
                    <button type="button" class="button dtd-upload-img-btn" data-target="dtd_t1_esp_2_img" data-preview="dtd_preview_esp_2">📷 Elegir Foto</button>
                    <button type="button" class="button dtd-remove-img-btn" data-target="dtd_t1_esp_2_img" data-preview="dtd_preview_esp_2" data-default="<?php echo esc_url( get_template_directory_uri() . '/assets/temporada1/DTDLVH_Elearning_HOME_img/source/maxi.png' ); ?>" style="<?php echo empty( $f['esp_2_img'] ) ? 'display:none;' : ''; ?>">Quitar</button>
                </div>
                <div class="dtd-field-group">
                    <label>Eje / Categoría:</label>
                    <input type="text" name="dtd_t1_esp_2_cat" value="<?php echo esc_attr( $f['esp_2_cat'] ); ?>">
                </div>
                <div class="dtd-field-group">
                    <label>Nombre:</label>
                    <input type="text" name="dtd_t1_esp_2_name" value="<?php echo esc_attr( $f['esp_2_name'] ); ?>">
                </div>
                <div class="dtd-field-group">
                    <label>Descripción:</label>
                    <textarea name="dtd_t1_esp_2_desc" rows="3"><?php echo esc_textarea( $f['esp_2_desc'] ); ?></textarea>
                </div>
            </div>

            <!-- Especialista 3 -->
            <div style="background:#fffcf5; padding:12px; border:1px solid #e0d0b8; border-radius:6px;">
                <p><strong>Especialista 3</strong></p>
                <div class="dtd-field-group">
                    <label>Foto:</label>
                    <div class="dtd-img-preview-wrap">
                        <img id="dtd_preview_esp_3" src="<?php echo esc_url( $f['esp_3_disp_img'] ); ?>">
                    </div>
                    <input type="hidden" id="dtd_t1_esp_3_img" name="dtd_t1_esp_3_img" value="<?php echo esc_attr( $f['esp_3_img'] ); ?>">
                    <button type="button" class="button dtd-upload-img-btn" data-target="dtd_t1_esp_3_img" data-preview="dtd_preview_esp_3">📷 Elegir Foto</button>
                    <button type="button" class="button dtd-remove-img-btn" data-target="dtd_t1_esp_3_img" data-preview="dtd_preview_esp_3" data-default="<?php echo esc_url( get_template_directory_uri() . '/assets/temporada1/DTDLVH_Elearning_HOME_img/source/mery.png' ); ?>" style="<?php echo empty( $f['esp_3_img'] ) ? 'display:none;' : ''; ?>">Quitar</button>
                </div>
                <div class="dtd-field-group">
                    <label>Eje / Categoría:</label>
                    <input type="text" name="dtd_t1_esp_3_cat" value="<?php echo esc_attr( $f['esp_3_cat'] ); ?>">
                </div>
                <div class="dtd-field-group">
                    <label>Nombre:</label>
                    <input type="text" name="dtd_t1_esp_3_name" value="<?php echo esc_attr( $f['esp_3_name'] ); ?>">
                </div>
                <div class="dtd-field-group">
                    <label>Descripción:</label>
                    <textarea name="dtd_t1_esp_3_desc" rows="3"><?php echo esc_textarea( $f['esp_3_desc'] ); ?></textarea>
                </div>
            </div>

            <!-- Especialista 4 -->
            <div style="background:#fffcf5; padding:12px; border:1px solid #e0d0b8; border-radius:6px;">
                <p><strong>Especialista 4</strong></p>
                <div class="dtd-field-group">
                    <label>Foto:</label>
                    <div class="dtd-img-preview-wrap">
                        <img id="dtd_preview_esp_4" src="<?php echo esc_url( $f['esp_4_disp_img'] ); ?>">
                    </div>
                    <input type="hidden" id="dtd_t1_esp_4_img" name="dtd_t1_esp_4_img" value="<?php echo esc_attr( $f['esp_4_img'] ); ?>">
                    <button type="button" class="button dtd-upload-img-btn" data-target="dtd_t1_esp_4_img" data-preview="dtd_preview_esp_4">📷 Elegir Foto</button>
                    <button type="button" class="button dtd-remove-img-btn" data-target="dtd_t1_esp_4_img" data-preview="dtd_preview_esp_4" data-default="<?php echo esc_url( get_template_directory_uri() . '/assets/temporada1/DTDLVH_Elearning_HOME_img/source/cesar.png' ); ?>" style="<?php echo empty( $f['esp_4_img'] ) ? 'display:none;' : ''; ?>">Quitar</button>
                </div>
                <div class="dtd-field-group">
                    <label>Eje / Categoría:</label>
                    <input type="text" name="dtd_t1_esp_4_cat" value="<?php echo esc_attr( $f['esp_4_cat'] ); ?>">
                </div>
                <div class="dtd-field-group">
                    <label>Nombre:</label>
                    <input type="text" name="dtd_t1_esp_4_name" value="<?php echo esc_attr( $f['esp_4_name'] ); ?>">
                </div>
                <div class="dtd-field-group">
                    <label>Descripción:</label>
                    <textarea name="dtd_t1_esp_4_desc" rows="3"><?php echo esc_textarea( $f['esp_4_desc'] ); ?></textarea>
                </div>
            </div>
        </div>
    </div>

    <!-- 3. PRECIOS Y ¿QUÉ TE LLEVÁS? -->
    <div class="dtd-editor-box" style="border-left: 4px solid #e0834c;">
        <h3>💰 3. ¿Qué te llevás? y Precios</h3>
        <div class="dtd-field-group">
            <label for="dtd_t1_llevas_title">Título:</label>
            <input type="text" id="dtd_t1_llevas_title" name="dtd_t1_llevas_title" value="<?php echo esc_attr( $f['llevas_title'] ); ?>">
        </div>
        <div class="dtd-grid-2">
            <div class="dtd-field-group">
                <label for="dtd_t1_llevas_hs_num">Texto del Reloj (Número):</label>
                <input type="text" id="dtd_t1_llevas_hs_num" name="dtd_t1_llevas_hs_num" value="<?php echo esc_attr( $f['llevas_hs_num'] ); ?>">
            </div>
            <div class="dtd-field-group">
                <label for="dtd_t1_llevas_hs_unit">Texto del Reloj (Unidad):</label>
                <input type="text" id="dtd_t1_llevas_hs_unit" name="dtd_t1_llevas_hs_unit" value="<?php echo esc_attr( $f['llevas_hs_unit'] ); ?>">
            </div>
        </div>
        <div class="dtd-grid-2">
            <div class="dtd-field-group">
                <label for="dtd_t1_llevas_caja1_text">Tarjeta 1 (Reloj) Texto:</label>
                <textarea id="dtd_t1_llevas_caja1_text" name="dtd_t1_llevas_caja1_text" rows="2"><?php echo esc_textarea( $f['llevas_caja1_text'] ); ?></textarea>
            </div>
            <div class="dtd-field-group">
                <label for="dtd_t1_llevas_caja2_text">Tarjeta 2 (Laptop) Texto:</label>
                <textarea id="dtd_t1_llevas_caja2_text" name="dtd_t1_llevas_caja2_text" rows="2"><?php echo esc_textarea( $f['llevas_caja2_text'] ); ?></textarea>
            </div>
        </div>

        <p><strong>Configuración de Precios:</strong></p>
        <div class="dtd-grid-3">
            <div class="dtd-field-group">
                <label for="dtd_t1_promo_badge">Etiqueta Destacada:</label>
                <input type="text" id="dtd_t1_promo_badge" name="dtd_t1_promo_badge" value="<?php echo esc_attr( $f['promo_badge'] ); ?>">
            </div>
            <div class="dtd-field-group">
                <label for="dtd_t1_promo_price">Precio Lanzamiento (Oferta):</label>
                <input type="text" id="dtd_t1_promo_price" name="dtd_t1_promo_price" value="<?php echo esc_attr( $f['promo_price'] ); ?>">
            </div>
            <div class="dtd-field-group">
                <label for="dtd_t1_reg_price">Precio Regular (Tachado):</label>
                <input type="text" id="dtd_t1_reg_price" name="dtd_t1_reg_price" value="<?php echo esc_attr( $f['reg_price'] ); ?>">
            </div>
        </div>
        <div class="dtd-grid-2">
            <div class="dtd-field-group">
                <label for="dtd_t1_btn_loquiero_text">Texto del Botón Principal:</label>
                <input type="text" id="dtd_t1_btn_loquiero_text" name="dtd_t1_btn_loquiero_text" value="<?php echo esc_attr( $f['btn_loquiero_text'] ); ?>">
            </div>
            <div class="dtd-field-group">
                <label for="dtd_t1_btn_loquiero_url">Enlace del Botón (Página de Pago):</label>
                <input type="text" id="dtd_t1_btn_loquiero_url" name="dtd_t1_btn_loquiero_url" value="<?php echo esc_attr( $f['btn_loquiero_url'] ); ?>">
            </div>
        </div>
    </div>

    <!-- 4. EXPLORAR -->
    <div class="dtd-editor-box" style="border-left: 4px solid #8e9447;">
        <h3>🧭 4. Sección ¿Qué vas a explorar?</h3>
        <div class="dtd-field-group">
            <label for="dtd_t1_explorar_title">Título:</label>
            <input type="text" id="dtd_t1_explorar_title" name="dtd_t1_explorar_title" value="<?php echo esc_attr( $f['explorar_title'] ); ?>">
        </div>
        <div class="dtd-field-group">
            <label for="dtd_t1_explorar_desc">Descripción:</label>
            <textarea id="dtd_t1_explorar_desc" name="dtd_t1_explorar_desc" rows="2"><?php echo esc_textarea( $f['explorar_desc'] ); ?></textarea>
        </div>
        <div class="dtd-field-group">
            <label for="dtd_t1_explorar_sub">Subtítulo de la lista:</label>
            <input type="text" id="dtd_t1_explorar_sub" name="dtd_t1_explorar_sub" value="<?php echo esc_attr( $f['explorar_sub'] ); ?>">
        </div>
        <div class="dtd-grid-2">
            <div class="dtd-field-group">
                <label for="dtd_t1_btn_accede_text">Texto del Botón:</label>
                <input type="text" id="dtd_t1_btn_accede_text" name="dtd_t1_btn_accede_text" value="<?php echo esc_attr( $f['btn_accede_text'] ); ?>">
            </div>
            <div class="dtd-field-group">
                <label for="dtd_t1_btn_accede_url">Enlace del Botón:</label>
                <input type="text" id="dtd_t1_btn_accede_url" name="dtd_t1_btn_accede_url" value="<?php echo esc_attr( $f['btn_accede_url'] ); ?>">
            </div>
        </div>
    </div>

    <!-- 5. CTA VIOLETA -->
    <div class="dtd-editor-box" style="border-left: 4px solid #b373bd;">
        <h3>💜 5. Llamado a la Acción (Banner Violeta)</h3>
        <div class="dtd-field-group">
            <label for="dtd_t1_cta_title">Título:</label>
            <textarea id="dtd_t1_cta_title" name="dtd_t1_cta_title" rows="2"><?php echo esc_textarea( $f['cta_title'] ); ?></textarea>
        </div>
        <div class="dtd-grid-2">
            <div class="dtd-field-group">
                <label for="dtd_t1_cta_btn_text">Texto del Botón:</label>
                <input type="text" id="dtd_t1_cta_btn_text" name="dtd_t1_cta_btn_text" value="<?php echo esc_attr( $f['cta_btn_text'] ); ?>">
            </div>
            <div class="dtd-field-group">
                <label for="dtd_t1_cta_btn_url">Enlace del Botón:</label>
                <input type="text" id="dtd_t1_cta_btn_url" name="dtd_t1_cta_btn_url" value="<?php echo esc_attr( $f['cta_btn_url'] ); ?>">
            </div>
        </div>
    </div>

    <!-- 6. FAQ -->
    <div class="dtd-editor-box" style="border-left: 4px solid #3b2017;">
        <h3>❓ 6. Preguntas Frecuentes (FAQ)</h3>
        <div class="dtd-field-group">
            <label for="dtd_t1_faq_title">Título de la Sección:</label>
            <input type="text" id="dtd_t1_faq_title" name="dtd_t1_faq_title" value="<?php echo esc_attr( $f['faq_title'] ); ?>">
        </div>
        <?php for ( $i = 1; $i <= 6; $i++ ) : ?>
            <div style="background:#fcfcfc; border:1px solid #e0e0e0; padding:12px; border-radius:6px; margin-bottom:12px;">
                <p style="margin-top:0;"><strong>Pregunta <?php echo $i; ?></strong></p>
                <div class="dtd-field-group">
                    <label>Pregunta:</label>
                    <input type="text" name="dtd_t1_faq_<?php echo $i; ?>_q" value="<?php echo esc_attr( $f['faq_' . $i . '_q'] ); ?>">
                </div>
                <div class="dtd-field-group" style="margin-bottom:0;">
                    <label>Respuesta:</label>
                    <textarea name="dtd_t1_faq_<?php echo $i; ?>_a" rows="3"><?php echo esc_textarea( $f['faq_' . $i . '_a'] ); ?></textarea>
                </div>
            </div>
        <?php endfor; ?>
    </div>
    <?php
}

// Pantalla Temporada 1
function dtd_render_admin_temporada1_screen() {
    $updated = false;

    if ( isset( $_POST['dtd_admin_save_t1_nonce'] ) && wp_verify_nonce( $_POST['dtd_admin_save_t1_nonce'], 'dtd_save_temporada1_admin' ) ) {
        $fields = array(
            '_dtd_t1_hero_title'        => 'html',
            '_dtd_t1_hero_subtitle'     => 'html',
            '_dtd_t1_exp_title'         => 'text',
            '_dtd_t1_exp_desc'          => 'text',
            '_dtd_t1_esp_1_img'         => 'url',
            '_dtd_t1_esp_1_cat'         => 'text',
            '_dtd_t1_esp_1_name'        => 'text',
            '_dtd_t1_esp_1_desc'        => 'html',
            '_dtd_t1_esp_2_img'         => 'url',
            '_dtd_t1_esp_2_cat'         => 'text',
            '_dtd_t1_esp_2_name'        => 'text',
            '_dtd_t1_esp_2_desc'        => 'html',
            '_dtd_t1_esp_3_img'         => 'url',
            '_dtd_t1_esp_3_cat'         => 'text',
            '_dtd_t1_esp_3_name'        => 'text',
            '_dtd_t1_esp_3_desc'        => 'html',
            '_dtd_t1_esp_4_img'         => 'url',
            '_dtd_t1_esp_4_cat'         => 'text',
            '_dtd_t1_esp_4_name'        => 'text',
            '_dtd_t1_esp_4_desc'        => 'html',
            '_dtd_t1_llevas_title'      => 'text',
            '_dtd_t1_llevas_hs_num'     => 'text',
            '_dtd_t1_llevas_hs_unit'    => 'text',
            '_dtd_t1_llevas_caja1_text' => 'html',
            '_dtd_t1_llevas_caja2_text' => 'html',
            '_dtd_t1_promo_badge'       => 'text',
            '_dtd_t1_promo_price'       => 'text',
            '_dtd_t1_reg_price'         => 'text',
            '_dtd_t1_btn_loquiero_text' => 'text',
            '_dtd_t1_btn_loquiero_url'  => 'url',
            '_dtd_t1_explorar_title'    => 'text',
            '_dtd_t1_explorar_desc'     => 'html',
            '_dtd_t1_explorar_sub'      => 'text',
            '_dtd_t1_btn_accede_text'   => 'text',
            '_dtd_t1_btn_accede_url'    => 'url',
            '_dtd_t1_cta_title'         => 'html',
            '_dtd_t1_cta_btn_text'      => 'text',
            '_dtd_t1_cta_btn_url'       => 'url',
            '_dtd_t1_faq_title'         => 'text',
            '_dtd_t1_faq_1_q'           => 'text',
            '_dtd_t1_faq_1_a'           => 'html',
            '_dtd_t1_faq_2_q'           => 'text',
            '_dtd_t1_faq_2_a'           => 'html',
            '_dtd_t1_faq_3_q'           => 'text',
            '_dtd_t1_faq_3_a'           => 'html',
            '_dtd_t1_faq_4_q'           => 'text',
            '_dtd_t1_faq_4_a'           => 'html',
            '_dtd_t1_faq_5_q'           => 'text',
            '_dtd_t1_faq_5_a'           => 'html',
            '_dtd_t1_faq_6_q'           => 'text',
            '_dtd_t1_faq_6_a'           => 'html',
        );

        foreach ( $fields as $key => $type ) {
            $post_k = ltrim( $key, '_' );
            if ( isset( $_POST[ $post_k ] ) ) {
                $raw = wp_unslash( $_POST[ $post_k ] );
                if ( $type === 'text' ) {
                    $clean = sanitize_text_field( $raw );
                } elseif ( $type === 'url' ) {
                    $clean = esc_url_raw( $raw );
                } else {
                    $clean = wp_kses_post( $raw );
                }
                update_option( $key, $clean );
            }
        }
        $updated = true;
    }

    $f = dtd_get_t1_form_fields( 0 );
    ?>
    <div class="wrap dtd-editor-wrap">
        <h1 style="display:flex; align-items:center; gap:10px;">
            🎬 <span>Editar Temporada 1</span>
        </h1>
        <p style="font-size:14px; color:#50575e;">
            Aquí podés cambiar todos los textos, expositores, precios y preguntas frecuentes de la Temporada 1. <strong>El diseño se mantendrá 100% perfecto.</strong>
        </p>

        <?php if ( $updated ) : ?>
            <div class="notice notice-success is-dismissible" style="padding:10px 15px; border-left-color:#46b450;">
                <p><strong>✅ ¡Cambios guardados con éxito!</strong> Ya están visibles en la página de Temporada 1.</p>
            </div>
        <?php endif; ?>

        <form method="post" action="">
            <?php wp_nonce_field( 'dtd_save_temporada1_admin', 'dtd_admin_save_t1_nonce' ); ?>
            <?php dtd_render_t1_fields_html( $f ); ?>

            <div style="position:sticky; bottom:20px; background:#fff; padding:15px 20px; border:1px solid #ccd0d4; border-radius:8px; box-shadow:0 4px 10px rgba(0,0,0,0.1); display:flex; align-items:center; justify-content:space-between; z-index:99;">
                <span style="color:#50575e; font-size:13px;">No olvides hacer clic en guardar para aplicar los cambios a la web.</span>
                <input type="submit" class="button button-primary button-large" value="💾 Guardar Cambios en Temporada 1" style="font-size:15px; padding:6px 24px; height:auto;">
            </div>
        </form>
    </div>
    <?php
}
