<?php
/**
 * Alta Manual de Alumnos
 * Permite registrar un alumno desde el backend y darle acceso directo a una temporada.
 */

// Evitar acceso directo
if (!defined('ABSPATH')) {
    exit;
}

// Agregar menú en el panel de administración
add_action('admin_menu', 'dtd_alta_alumnos_menu');
function dtd_alta_alumnos_menu() {
    add_submenu_page(
        'users.php',                 // Aparecerá bajo "Usuarios"
        'Alta Alumnos',              // Título de la página
        'Alta Alumnos (Rápida)',     // Título del menú
        'manage_options',            // Capacidad requerida (Administrador)
        'dtd-alta-alumnos',          // Slug
        'dtd_alta_alumnos_page'      // Función de callback
    );
}

// Renderizar la página de opciones
function dtd_alta_alumnos_page() {
    if (!current_user_can('manage_options')) {
        return;
    }

    $mensaje = '';
    $tipo_mensaje = '';

    // Procesar formulario
    if (isset($_POST['dtd_alta_submit'])) {
        // Verificar nonce
        if (!isset($_POST['dtd_alta_nonce']) || !wp_verify_nonce($_POST['dtd_alta_nonce'], 'dtd_alta_action')) {
            $mensaje = 'Error de seguridad. Intente nuevamente.';
            $tipo_mensaje = 'error';
        } else {
            $nombre = sanitize_text_field($_POST['dtd_nombre']);
            $apellido = sanitize_text_field($_POST['dtd_apellido']);
            $email = sanitize_email($_POST['dtd_email']);
            $producto_id = intval($_POST['dtd_producto']);

            if (empty($nombre) || empty($apellido) || empty($email)) {
                $mensaje = 'Por favor complete todos los campos.';
                $tipo_mensaje = 'error';
            } elseif (email_exists($email)) {
                // Si el usuario ya existe, solo le damos acceso
                $user = get_user_by('email', $email);
                update_user_meta($user->ID, '_dtd_acceso_manual_' . $producto_id, true);
                update_user_meta($user->ID, '_dtd_acceso_temporada_1', true);
                $mensaje = 'El usuario ya existía. Se le ha otorgado acceso exitosamente.';
                $tipo_mensaje = 'updated';
            } else {
                // Generar contraseña segura
                $password = wp_generate_password(12, true, false);

                // Crear usuario
                $userdata = array(
                    'user_login' => $email, // Usamos el email como username
                    'user_email' => $email,
                    'user_pass'  => $password,
                    'first_name' => $nombre,
                    'last_name'  => $apellido,
                    'role'       => 'subscriber' // Rol por defecto
                );

                $user_id = wp_insert_user($userdata);

                if (is_wp_error($user_id)) {
                    $mensaje = 'Error al crear usuario: ' . $user_id->get_error_message();
                    $tipo_mensaje = 'error';
                } else {
                    // Dar acceso manual a la temporada
                    update_user_meta($user_id, '_dtd_acceso_manual_' . $producto_id, true);
                    update_user_meta($user_id, '_dtd_acceso_temporada_1', true);

                    // Enviar email de bienvenida de WordPress
                    // Esto enviará un link al usuario para que setee su propia contraseña
                    wp_new_user_notification($user_id, null, 'user');

                    $mensaje = "Usuario creado exitosamente ($nombre $apellido). Se le ha dado acceso a la Temporada y se le envió un correo de bienvenida.";
                    $tipo_mensaje = 'updated';
                }
            }
        }
    }

    // HTML del Formulario
    ?>
    <div class="wrap" style="max-width: 600px;">
        <h1 class="wp-heading-inline">Alta Rápida de Alumnos</h1>
        <p>Utiliza este formulario para registrar un nuevo alumno y otorgarle acceso inmediato al aula virtual (sin que pase por WooCommerce).</p>

        <?php if ($mensaje): ?>
            <div class="notice notice-<?php echo $tipo_mensaje; ?> is-dismissible">
                <p><strong><?php echo esc_html($mensaje); ?></strong></p>
            </div>
        <?php endif; ?>

        <div class="postbox" style="padding: 20px; margin-top: 20px;">
            <form method="post" action="">
                <?php wp_nonce_field('dtd_alta_action', 'dtd_alta_nonce'); ?>

                <table class="form-table">
                    <tr>
                        <th><label for="dtd_nombre">Nombre *</label></th>
                        <td><input type="text" name="dtd_nombre" id="dtd_nombre" class="regular-text" required /></td>
                    </tr>
                    <tr>
                        <th><label for="dtd_apellido">Apellido *</label></th>
                        <td><input type="text" name="dtd_apellido" id="dtd_apellido" class="regular-text" required /></td>
                    </tr>
                    <tr>
                        <th><label for="dtd_email">Email *</label></th>
                        <td><input type="email" name="dtd_email" id="dtd_email" class="regular-text" required /></td>
                    </tr>
                    <tr>
                        <th><label for="dtd_producto">Dar acceso a *</label></th>
                        <td>
                            <select name="dtd_producto" id="dtd_producto">
                                <option value="26">Temporada 1 (ID 26)</option>
                            </select>
                            <p class="description">Seleccione a qué curso/temporada darle acceso directo.</p>
                        </td>
                    </tr>
                </table>

                <p class="submit">
                    <input type="submit" name="dtd_alta_submit" id="submit" class="button button-primary" value="Registrar Alumno y Dar Acceso">
                </p>
            </form>
        </div>
    </div>
    <?php
}
