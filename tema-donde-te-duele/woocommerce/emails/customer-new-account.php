<?php
/**
 * Customer new account email
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/customer-new-account.php.
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_email_header', $email_heading, $email );

?>
<p>
    <?php
    echo sprintf(
        /* translators: 1: blogname, 2: username, 3: my account url */
        esc_html__( 'Hola! Te enviamos tu acceso a la clínica online. A partir de ahora ya puedes disfrutar de los contenidos. Tu usuario es %2$s. Ingresa a tu cuenta aquí: %3$s', 'woocommerce' ),
        esc_html( $blogname ),
        '<strong>' . esc_html( $user_login ) . '</strong>',
        make_clickable( esc_url( wc_get_page_permalink( 'myaccount' ) ) )
    );
    ?>
</p>

<?php if ( 'yes' === get_option( 'woocommerce_registration_generate_password' ) && $password_generated && $set_password_url ) : ?>
    <p><a href="<?php echo esc_attr( $set_password_url ); ?>"><?php esc_html_e( 'Click here to set your new password.', 'woocommerce' ); ?></a></p>
<?php endif; ?>

<?php
do_action( 'woocommerce_email_footer', $email );
