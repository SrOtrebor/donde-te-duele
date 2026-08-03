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
                // Generar contraseña si no se proporcionó una
                if (!empty($_POST['dtd_password'])) {
                    $password = $_POST['dtd_password'];
                } else {
                    $password = wp_generate_password(12, true, false);
                }

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

                    // Enviar email personalizado con usuario y contraseña
                    $site_name = get_bloginfo('name');
                    $login_url = wp_login_url();
                    
                    $subject = sprintf('Tu acceso a la Clínica Online - %s', $site_name);
                    $body = "Hola! Te enviamos tu acceso a la clínica online. A partir de ahora ya puedes disfrutar de los contenidos.\n\n";
                    $body .= "Tus credenciales de acceso son:\n";
                    $body .= "Usuario: $email\n";
                    $body .= "Contraseña: $password\n\n";
                    $body .= "Ingresa a tu cuenta aquí: " . wc_get_page_permalink( 'myaccount' ) . "\n\n";
                    $body .= "Saludos,\nEl equipo de $site_name";
                    
                    wp_mail($email, $subject, $body);

                    $mensaje = "Usuario creado exitosamente ($nombre $apellido). Se le ha dado acceso a la Temporada y se le envió un correo de bienvenida.<br><br><strong>CREDENCIALES:</strong><br>Usuario: $email<br>Contraseña: $password<br><em>(Guárdala si necesitas pasársela manualmente)</em>";
                    $tipo_mensaje = 'updated';
                }
            }
        }
    }
    // Procesar Alta Masiva
    $resultados_masivos = null;
    if (isset($_POST['dtd_alta_masiva_submit'])) {
        if (!isset($_POST['dtd_alta_masiva_nonce']) || !wp_verify_nonce($_POST['dtd_alta_masiva_nonce'], 'dtd_alta_masiva_action')) {
            $mensaje = 'Error de seguridad. Intente nuevamente.';
            $tipo_mensaje = 'error';
        } else {
            $csv_data = sanitize_textarea_field(wp_unslash($_POST['dtd_csv_data']));
            $producto_id = intval($_POST['dtd_producto_masivo']);
            $lines = explode("\n", str_replace("\r", "", $csv_data));
            $resultados_masivos = array();
            
            foreach ($lines as $line) {
                if (empty(trim($line))) continue;
                
                // Usar str_getcsv para soportar comas dentro de campos si es necesario
                $fields = str_getcsv(trim($line));
                if (count($fields) < 3) {
                    $resultados_masivos[] = array('linea' => $line, 'estado' => 'Error: Faltan campos (Nombre, Apellido, Email requeridos)', 'pass' => '-');
                    continue;
                }
                
                $nombre = sanitize_text_field(trim($fields[0]));
                $apellido = sanitize_text_field(trim($fields[1]));
                $email = sanitize_email(trim($fields[2]));
                $password = (isset($fields[3]) && !empty(trim($fields[3]))) ? trim($fields[3]) : wp_generate_password(12, true, false);
                
                if (empty($nombre) || empty($apellido) || empty($email) || !is_email($email)) {
                    $resultados_masivos[] = array('linea' => $line, 'estado' => 'Error: Formato inválido o email incorrecto', 'pass' => '-');
                    continue;
                }
                
                if (email_exists($email)) {
                    $user = get_user_by('email', $email);
                    update_user_meta($user->ID, '_dtd_acceso_manual_' . $producto_id, true);
                    update_user_meta($user->ID, '_dtd_acceso_temporada_1', true);
                    $resultados_masivos[] = array('linea' => "$nombre $apellido ($email)", 'estado' => 'Actualizado: Ya existía, se le dio acceso.', 'pass' => '- (usa su clave anterior)');
                } else {
                    $userdata = array(
                        'user_login' => $email,
                        'user_email' => $email,
                        'user_pass'  => $password,
                        'first_name' => $nombre,
                        'last_name'  => $apellido,
                        'role'       => 'subscriber'
                    );
                    $user_id = wp_insert_user($userdata);
                    if (is_wp_error($user_id)) {
                        $resultados_masivos[] = array('linea' => "$nombre $apellido ($email)", 'estado' => 'Error: ' . $user_id->get_error_message(), 'pass' => '-');
                    } else {
                        update_user_meta($user_id, '_dtd_acceso_manual_' . $producto_id, true);
                        update_user_meta($user_id, '_dtd_acceso_temporada_1', true);
                        // Enviar email personalizado con usuario y contraseña
                        $site_name = get_bloginfo('name');
                        $login_url = wp_login_url();
                        
                        $subject = sprintf('Tu acceso a la Clínica Online - %s', $site_name);
                        $body = "Hola! Te enviamos tu acceso a la clínica online. A partir de ahora ya puedes disfrutar de los contenidos.\n\n";
                        $body .= "Tus credenciales de acceso son:\n";
                        $body .= "Usuario: $email\n";
                        $body .= "Contraseña: $password\n\n";
                        $body .= "Ingresa a tu cuenta aquí: " . wc_get_page_permalink( 'myaccount' ) . "\n\n";
                        $body .= "Saludos,\nEl equipo de $site_name";
                        
                        wp_mail($email, $subject, $body);

                        $resultados_masivos[] = array('linea' => "$nombre $apellido ($email)", 'estado' => '<strong style="color:green">Creado y email enviado</strong>', 'pass' => "<strong>$password</strong>");
                    }
                }
            }
            $mensaje = 'Procesamiento masivo completado. Revisa el reporte al final de la página.';
            $tipo_mensaje = 'updated';
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
                        <th><label for="dtd_password">Contraseña</label></th>
                        <td>
                            <input type="text" name="dtd_password" id="dtd_password" class="regular-text" placeholder="Dejar vacío para autogenerar" />
                            <p class="description">Si la dejas vacía, se generará una automáticamente.</p>
                        </td>
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

        <div class="postbox" style="padding: 20px; margin-top: 20px;">
            <h2>Alta Masiva (Varios Alumnos)</h2>
            <p>Pega aquí la lista de alumnos, un alumno por línea, separados por comas (formato CSV).</p>
            <p><strong>Formato requerido:</strong> <code>Nombre, Apellido, Email, Contraseña</code></p>
            <p><em>La contraseña es opcional. Si no la incluyes, el sistema generará una segura automáticamente.</em></p>
            <p><strong>Ejemplo:</strong><br>
            <code>Juan, Perez, juan@email.com, miclave123</code><br>
            <code>Maria, Gomez, maria@email.com</code></p>
            
            <form method="post" action="">
                <?php wp_nonce_field('dtd_alta_masiva_action', 'dtd_alta_masiva_nonce'); ?>
                
                <table class="form-table">
                    <tr>
                        <th><label for="dtd_csv_data">Lista de Alumnos *</label></th>
                        <td>
                            <textarea name="dtd_csv_data" id="dtd_csv_data" rows="8" style="width:100%; font-family:monospace;" required placeholder="Juan, Perez, juan@email.com, clave123&#10;Maria, Gomez, maria@email.com"></textarea>
                        </td>
                    </tr>
                    <tr>
                        <th><label for="dtd_producto_masivo">Dar acceso a *</label></th>
                        <td>
                            <select name="dtd_producto_masivo" id="dtd_producto_masivo">
                                <option value="26">Temporada 1 (ID 26)</option>
                            </select>
                        </td>
                    </tr>
                </table>
                <p class="submit">
                    <input type="submit" name="dtd_alta_masiva_submit" class="button button-primary" value="Procesar Alta Masiva">
                </p>
            </form>
        </div>

        <?php if ($resultados_masivos !== null): ?>
            <div class="postbox" style="padding: 20px; margin-top: 20px; border-left: 4px solid #46b450;">
                <h2>Reporte de Alta Masiva</h2>
                <table class="wp-list-table widefat fixed striped">
                    <thead>
                        <tr>
                            <th style="width: 40%">Alumno</th>
                            <th style="width: 40%">Estado</th>
                            <th style="width: 20%">Contraseña</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($resultados_masivos as $res): ?>
                            <tr>
                                <td><?php echo esc_html($res['linea']); ?></td>
                                <td><?php echo wp_kses_post($res['estado']); ?></td>
                                <td style="font-family:monospace; font-size:14px;"><?php echo wp_kses_post($res['pass']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <p><em>* Si la contraseña fue autogenerada o ingresada manualmente, puedes copiarla desde la tabla de arriba.</em></p>
            </div>
        <?php endif; ?>

    </div>
    <?php
}
