<?php
/**
 * Customer new account email
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/customer-new-account.php.
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_email_header', $email_heading, $email );

?>
<div style="background-color: #fdfaf1; padding: 30px; border-radius: 10px; border: 1px solid #e0e0e0; font-family: 'Helvetica Neue', Helvetica, Roboto, Arial, sans-serif;">
    <h2 style="color: #3b2017; margin-top: 0; text-transform: uppercase;">¡Bienvenida a la Clínica!</h2>
    <p style="color: #3b2017; font-size: 16px; line-height: 1.6;">
        <?php
        echo sprintf(
            esc_html__( 'Hola! Te enviamos tu acceso a la clínica online. Para poder ingresar, primero debes crear tu contraseña. Tu usuario es %1$s.', 'woocommerce' ),
            '<strong>' . esc_html( $user_login ) . '</strong>'
        );
        ?>
    </p>

    <?php 
    $needs_password = ( 'yes' === get_option( 'woocommerce_registration_generate_password' ) && $password_generated && $set_password_url );
    $button_url = $needs_password ? $set_password_url : wc_get_page_permalink( 'myaccount' );
    $button_text = $needs_password ? 'Crear mi contraseña e Ingresar' : 'Ingresar a mi Aula';
    ?>

    <div style="text-align: center; margin: 35px 0;">
        <a href="<?php echo esc_attr( $button_url ); ?>" style="background-color: #5a9470; color: #ffffff; padding: 15px 35px; text-decoration: none; border-radius: 30px; font-weight: bold; font-size: 16px; display: inline-block;"><?php echo esc_html( $button_text ); ?></a>
    </div>

    <?php if ( $needs_password ) : ?>
        <p style="color: #3b2017; font-size: 14px; margin-top: 20px; border-top: 1px solid #e0e0e0; padding-top: 20px; text-align: center;">
            <em>Si el botón no funciona, copia y pega este enlace en tu navegador:</em><br>
            <a href="<?php echo esc_attr( $set_password_url ); ?>" style="color: #ffa872; text-decoration: underline; font-weight: bold; word-break: break-all; display: inline-block; margin-top: 5px;"><?php echo esc_html( $set_password_url ); ?></a>
        </p>
    <?php endif; ?>
</div>

<?php
do_action( 'woocommerce_email_footer', $email );
