<?php
// Registrar Custom Post Type: Episodios
function dtd_register_episodio_cpt() {
    $labels = array(
        'name'                  => 'Episodios',
        'singular_name'         => 'Episodio',
        'menu_name'             => 'Episodios',
        'add_new'               => 'Agregar Nuevo',
        'add_new_item'          => 'Agregar Nuevo Episodio',
        'edit_item'             => 'Editar Episodio',
        'new_item'              => 'Nuevo Episodio',
        'view_item'             => 'Ver Episodio',
        'all_items'             => 'Todos los Episodios',
        'search_items'          => 'Buscar Episodios',
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array( 'slug' => 'episodio' ),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => 5,
        'menu_icon'          => 'dashicons-video-alt3',
        'supports'           => array( 'title', 'page-attributes' ), // title y order
    );

    register_post_type( 'episodio', $args );
}
add_action( 'init', 'dtd_register_episodio_cpt' );

// Agregar Metaboxes para los datos del episodio
function dtd_add_episodio_metaboxes() {
    add_meta_box(
        'dtd_episodio_datos',
        'Datos del Episodio y Bloques',
        'dtd_episodio_metabox_html',
        'episodio',
        'normal',
        'high'
    );
}
add_action( 'add_meta_boxes', 'dtd_add_episodio_metaboxes' );

function dtd_episodio_metabox_html( $post ) {
    wp_nonce_field( 'dtd_guardar_episodio', 'dtd_episodio_nonce' );

    $especialista = get_post_meta( $post->ID, '_dtd_especialista', true );
    
    echo '<div style="margin-bottom:20px;">';
    echo '<label for="dtd_especialista"><strong>Especialista (Autor del episodio):</strong></label><br>';
    echo '<input type="text" id="dtd_especialista" name="dtd_especialista" value="' . esc_attr( $especialista ) . '" size="50" />';
    echo '</div>';

    echo '<hr>';
    echo '<h3>Bloques de Contenido (Del 0 al 4)</h3>';
    echo '<p>Deja vacío el título si el bloque no existe.</p>';

    for ( $i = 0; $i <= 4; $i++ ) {
        $bloque_titulo   = get_post_meta( $post->ID, "_dtd_bloque_{$i}_titulo", true );
        $bloque_objetivo = get_post_meta( $post->ID, "_dtd_bloque_{$i}_objetivo", true );
        $bloque_pregutas = get_post_meta( $post->ID, "_dtd_bloque_{$i}_preguntas", true );

        echo "<div style='background:#f9f9f9; padding:15px; margin-bottom:15px; border:1px solid #ccc;'>";
        echo "<h4>Bloque {$i}</h4>";
        
        echo "<p><label><strong>Título del Bloque:</strong></label><br>";
        echo "<input type='text' name='dtd_bloque_{$i}_titulo' value='" . esc_attr( $bloque_titulo ) . "' style='width:100%;' placeholder='Ej: Bloque {$i} | Título...' /></p>";
        
        echo "<p><label><strong>Objetivo:</strong></label><br>";
        echo "<textarea name='dtd_bloque_{$i}_objetivo' style='width:100%;' rows='2'>" . esc_textarea( $bloque_objetivo ) . "</textarea></p>";

        echo "<p><label><strong>Preguntas Guía (separar con saltos de línea):</strong></label><br>";
        echo "<textarea name='dtd_bloque_{$i}_preguntas' style='width:100%;' rows='4'>" . esc_textarea( $bloque_pregutas ) . "</textarea></p>";
        echo "</div>";
    }
}

// Guardar los datos del Metabox
function dtd_guardar_episodio_meta( $post_id ) {
    if ( ! isset( $_POST['dtd_episodio_nonce'] ) || ! wp_verify_nonce( $_POST['dtd_episodio_nonce'], 'dtd_guardar_episodio' ) ) {
        return;
    }
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }
    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }

    if ( isset( $_POST['dtd_especialista'] ) ) {
        update_post_meta( $post_id, '_dtd_especialista', sanitize_text_field( $_POST['dtd_especialista'] ) );
    }

    for ( $i = 0; $i <= 4; $i++ ) {
        if ( isset( $_POST["dtd_bloque_{$i}_titulo"] ) ) {
            update_post_meta( $post_id, "_dtd_bloque_{$i}_titulo", sanitize_text_field( $_POST["dtd_bloque_{$i}_titulo"] ) );
        }
        if ( isset( $_POST["dtd_bloque_{$i}_objetivo"] ) ) {
            update_post_meta( $post_id, "_dtd_bloque_{$i}_objetivo", sanitize_textarea_field( $_POST["dtd_bloque_{$i}_objetivo"] ) );
        }
        if ( isset( $_POST["dtd_bloque_{$i}_preguntas"] ) ) {
            update_post_meta( $post_id, "_dtd_bloque_{$i}_preguntas", sanitize_textarea_field( $_POST["dtd_bloque_{$i}_preguntas"] ) );
        }
    }
}
add_action( 'save_post', 'dtd_guardar_episodio_meta' );
