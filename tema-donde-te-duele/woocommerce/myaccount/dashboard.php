<?php
/**
 * My Account Dashboard
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/dashboard.php.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}
?>

<div style="background: #fdfaf1; padding: 30px; border-radius: 10px; border: 1px solid #e0e0e0;">
    <h2 style="font-size: 24px; color: #3b2017; font-family: 'Roboto Condensed', sans-serif; text-transform: uppercase; margin-top: 0;">¡Bienvenido a la clínica online!</h2>
    <p style="font-family: 'Archivo', sans-serif; color: #3b2017; font-size: 16px; line-height: 1.5;">
        Desde esta sección podés editar tus datos personales, detalles de tu cuenta y acceder a los contenidos a los cuales te suscribiste.
    </p>

    <p style="margin-top: 30px;">
        <a href="<?php echo esc_url( wc_logout_url() ); ?>" style="color: #ffa872; text-decoration: underline; font-weight: bold; font-family: 'Archivo', sans-serif; font-size: 16px;">Cerrar sesión</a>
    </p>
</div>

<?php
    /**
     * My Account dashboard.
     *
     * @since 2.6.0
     */
    do_action( 'woocommerce_account_dashboard' );
?>
