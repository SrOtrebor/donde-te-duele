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
?>

<div class="dashboard-wrapper" style="display: flex; min-height: 80vh; background-color: var(--bg-secondary);">
    
    <!-- Panel Lateral Izquierdo -->
    <aside class="dashboard-sidebar" style="width: 250px; background-color: var(--bg-color); padding: 30px 20px; border-right: 1px solid #333;">
        <h3 style="color: var(--accent-color); font-size: 16px; text-transform: uppercase;">Hola, <?php echo esc_html( $current_user->display_name ); ?></h3>
        
        <ul style="list-style: none; padding: 0; margin-top: 30px;">
            <li style="margin-bottom: 15px;"><a href="#" style="color: var(--text-color); font-weight: bold;">Mis Cursos</a></li>
            <li style="margin-bottom: 15px;"><a href="#" style="color: var(--text-color); font-weight: bold;">Eventos y Grabaciones</a></li>
            <li style="margin-bottom: 15px;"><a href="#" style="color: var(--text-color); font-weight: bold;">Mi Cuenta</a></li>
            <li style="margin-top: 50px;">
                <a href="<?php echo esc_url( wp_logout_url( home_url() ) ); ?>" style="color: #ff4444; font-size: 14px;">Cerrar Sesión</a>
            </li>
        </ul>
    </aside>

    <!-- Grid de Contenido (Derecha) -->
    <main class="dashboard-content" style="flex: 1; padding: 40px;">
        <h1 style="border-bottom: 1px solid #333; padding-bottom: 15px;">Tu Contenido Exclusivo</h1>
        
        <div class="content-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 30px; margin-top: 30px;">
            
            <!-- Tarjeta de ejemplo de contenido -->
            <div class="content-card" style="background: var(--bg-color); border: 1px solid #333; border-radius: 8px; padding: 20px;">
                <h3 style="color: var(--accent-color); font-size: 18px;">Curso Inicial</h3>
                <p style="font-size: 14px; color: #aaa;">Aprende las bases del movimiento.</p>
                <a href="#" class="btn-premium" style="font-size: 12px; padding: 8px 15px; margin-top: 15px;">Entrar al curso</a>
            </div>

            <!-- Tarjeta de ejemplo de grabación -->
            <div class="content-card" style="background: var(--bg-color); border: 1px solid #333; border-radius: 8px; padding: 20px;">
                <h3 style="color: var(--accent-color); font-size: 18px;">Grabación VIP #1</h3>
                <p style="font-size: 14px; color: #aaa;">Seminario de la semana pasada.</p>
                <a href="#" class="btn-premium" style="font-size: 12px; padding: 8px 15px; margin-top: 15px;">Ver Video</a>
            </div>

        </div>
    </main>

</div>

<?php get_footer(); ?>
