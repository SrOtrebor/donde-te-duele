<?php
/**
 * Login Form Customizado (Donde te duele)
 * Sobreescribe el template por defecto de WooCommerce.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

do_action( 'woocommerce_before_customer_login_form' ); ?>

<style>
    /* Estilos Premium para la pantalla de Login y Registro */
    .dtd-login-wrapper {
        display: flex;
        flex-direction: column;
        min-height: 70vh;
        width: 90vw;
        max-width: 1200px;
        position: relative;
        left: 50%;
        transform: translateX(-50%);
        margin: 40px 0;
        background: #fdfaf1;
        border-radius: 20px;
        box-shadow: 0 15px 40px rgba(59,32,23,0.08);
        overflow: hidden;
        font-family: 'Archivo', sans-serif;
    }
    
    .dtd-login-banner {
        flex: 1;
        background: url('<?php echo esc_url(get_template_directory_uri()); ?>/assets/temporada1/DTDLVH_Elearning_HOME_img/source/hero-bg.png') center/cover;
        background-color: #3b2017;
        position: relative;
        display: none;
        min-height: 200px;
    }
    
    @media (min-width: 768px) {
        .dtd-login-wrapper { flex-direction: row; }
        .dtd-login-banner { display: block; }
    }
    
    @media (max-width: 767px) {
        .dtd-login-wrapper {
            min-height: auto;
            background: #fdfaf1;
            box-shadow: none;
            border: none;
        }
        .dtd-login-forms {
            padding: 30px 15px;
            background: transparent;
        }
    }
    
    .dtd-login-banner-overlay {
        position: absolute;
        top: 0; left: 0; right: 0; bottom: 0;
        background: linear-gradient(to bottom, rgba(59,32,23,0.1), rgba(59,32,23,0.7));
        display: flex;
        flex-direction: column;
        justify-content: flex-end;
        padding: 40px;
    }
    
    .dtd-login-banner-title {
        color: #ffffff;
        font-size: 28px;
        font-weight: 700;
        margin: 0 0 10px 0;
    }
    
    .dtd-login-banner-subtitle {
        color: #fdfaf1;
        font-size: 16px;
        margin: 0;
    }
    
    .dtd-login-forms {
        flex: 1;
        padding: 40px 20px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        background: #fdfaf1;
        width: 100%;
        box-sizing: border-box;
    }
    
    @media (min-width: 768px) {
        .dtd-login-forms { padding: 50px; }
    }
    
    .dtd-login-forms h2 {
        color: #3b2017;
        font-size: 24px;
        font-weight: 700;
        margin-bottom: 25px;
        border-bottom: 2px solid #bfd43b;
        padding-bottom: 10px;
        display: inline-block;
    }
    
    .woocommerce-form-login, .woocommerce-form-register {
        display: flex;
        flex-direction: column;
        gap: 15px;
    }
    
    .woocommerce-form-login label, .woocommerce-form-register label {
        color: #3b2017;
        font-weight: bold;
        font-size: 14px;
        margin-bottom: 5px;
        display: block;
    }
    
    .woocommerce-form-login input.input-text, .woocommerce-form-register input.input-text {
        width: 100%;
        padding: 15px;
        border: 1px solid #d1bfae;
        border-radius: 8px;
        background: #ffffff;
        font-family: 'Archivo', sans-serif;
        transition: 0.3s;
    }
    
    .woocommerce-form-login input.input-text:focus, .woocommerce-form-register input.input-text:focus {
        border-color: #3b2017;
        outline: none;
        box-shadow: 0 0 0 2px rgba(191,212,59,0.3);
    }
    
    .woocommerce-form-login .button, .woocommerce-form-register .button {
        background: #3b2017 !important;
        color: #ffffff !important;
        padding: 15px 30px !important;
        border-radius: 30px !important;
        border: none !important;
        font-weight: bold !important;
        font-size: 16px !important;
        cursor: pointer;
        transition: 0.3s !important;
        text-transform: uppercase;
        width: 100%;
        margin-top: 10px;
    }
    
    .woocommerce-form-login .button:hover, .woocommerce-form-register .button:hover {
        background: #bfd43b !important;
        color: #3b2017 !important;
        transform: translateY(-2px);
    }
    
    .woocommerce-LostPassword {
        text-align: center;
        margin-top: 15px;
    }
    
    .woocommerce-LostPassword a {
        color: #3b2017;
        text-decoration: underline;
        font-size: 14px;
    }
    
    .woocommerce-form-login__rememberme {
        display: flex;
        align-items: center;
        gap: 8px;
        font-weight: normal !important;
        font-size: 14px !important;
        cursor: pointer;
    }
    
    /* Layout for two columns if registration is enabled */
    .dtd-col2-set {
        display: flex;
        gap: 40px;
        flex-direction: column;
    }
    
    @media (min-width: 1024px) {
        .dtd-col2-set { flex-direction: row; }
        .dtd-col2-set .dtd-col-1, .dtd-col2-set .dtd-col-2 { flex: 1; }
        /* Si están los dos formularios, achicamos un poco el padding */
        .dtd-login-forms { padding: 40px; }
    }
</style>

<div class="dtd-login-wrapper">

    <div class="dtd-login-banner">
        <div class="dtd-login-banner-overlay">
            <h1 class="dtd-login-banner-title">Accedé a tu Clínica Online</h1>
            <p class="dtd-login-banner-subtitle">Ingresa para continuar viendo las temporadas y recursos.</p>
        </div>
    </div>

    <div class="dtd-login-forms">
        <?php if ( 'yes' === get_option( 'woocommerce_enable_myaccount_registration' ) ) : ?>
        <div class="dtd-col2-set" id="customer_login">
            <div class="dtd-col-1">
        <?php endif; ?>

                <h2><?php esc_html_e( 'Iniciar sesión', 'woocommerce' ); ?></h2>

                <form class="woocommerce-form woocommerce-form-login login" method="post">

                    <?php do_action( 'woocommerce_login_form_start' ); ?>

                    <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                        <label for="username"><?php esc_html_e( 'Username or email address', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
                        <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="username" id="username" autocomplete="username" value="<?php echo ( ! empty( $_POST['username'] ) ) ? esc_attr( wp_unslash( $_POST['username'] ) ) : ''; ?>" /><?php // @codingStandardsIgnoreLine ?>
                    </p>
                    <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                        <label for="password"><?php esc_html_e( 'Password', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
                        <input class="woocommerce-Input woocommerce-Input--text input-text" type="password" name="password" id="password" autocomplete="current-password" />
                    </p>

                    <?php do_action( 'woocommerce_login_form' ); ?>

                    <p class="form-row">
                        <label class="woocommerce-form__label woocommerce-form__label-for-checkbox woocommerce-form-login__rememberme">
                            <input class="woocommerce-form__input woocommerce-form__input-checkbox" name="rememberme" type="checkbox" id="rememberme" value="forever" /> <span><?php esc_html_e( 'Remember me', 'woocommerce' ); ?></span>
                        </label>
                        <?php wp_nonce_field( 'woocommerce-login', 'woocommerce-login-nonce' ); ?>
                        <button type="submit" class="woocommerce-button button woocommerce-form-login__submit" name="login" value="<?php esc_attr_e( 'Log in', 'woocommerce' ); ?>"><?php esc_html_e( 'Entrar al Aula', 'woocommerce' ); ?></button>
                    </p>
                    <p class="woocommerce-LostPassword lost_password">
                        <a href="<?php echo esc_url( wp_lostpassword_url() ); ?>"><?php esc_html_e( 'Lost your password?', 'woocommerce' ); ?></a>
                    </p>

                    <?php do_action( 'woocommerce_login_form_end' ); ?>

                </form>

        <?php if ( 'yes' === get_option( 'woocommerce_enable_myaccount_registration' ) ) : ?>
            </div>

            <div class="dtd-col-2">

                <h2><?php esc_html_e( 'Registrarse', 'woocommerce' ); ?></h2>

                <form method="post" class="woocommerce-form woocommerce-form-register register" <?php do_action( 'woocommerce_register_form_tag' ); ?> >

                    <?php do_action( 'woocommerce_register_form_start' ); ?>

                    <?php if ( 'no' === get_option( 'woocommerce_registration_generate_username' ) ) : ?>
                        <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                            <label for="reg_username"><?php esc_html_e( 'Username', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
                            <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="username" id="reg_username" autocomplete="username" value="<?php echo ( ! empty( $_POST['username'] ) ) ? esc_attr( wp_unslash( $_POST['username'] ) ) : ''; ?>" /><?php // @codingStandardsIgnoreLine ?>
                        </p>
                    <?php endif; ?>

                    <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                        <label for="reg_email"><?php esc_html_e( 'Email address', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
                        <input type="email" class="woocommerce-Input woocommerce-Input--text input-text" name="email" id="reg_email" autocomplete="email" value="<?php echo ( ! empty( $_POST['email'] ) ) ? esc_attr( wp_unslash( $_POST['email'] ) ) : ''; ?>" /><?php // @codingStandardsIgnoreLine ?>
                    </p>

                    <?php if ( 'no' === get_option( 'woocommerce_registration_generate_password' ) ) : ?>
                        <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                            <label for="reg_password"><?php esc_html_e( 'Password', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
                            <input type="password" class="woocommerce-Input woocommerce-Input--text input-text" name="password" id="reg_password" autocomplete="new-password" />
                        </p>
                    <?php else : ?>
                        <p><?php esc_html_e( 'A password will be sent to your email address.', 'woocommerce' ); ?></p>
                    <?php endif; ?>

                    <?php do_action( 'woocommerce_register_form' ); ?>

                    <p class="woocommerce-form-row form-row">
                        <?php wp_nonce_field( 'woocommerce-register', 'woocommerce-register-nonce' ); ?>
                        <button type="submit" class="woocommerce-Button woocommerce-button button woocommerce-form-register__submit" name="register" value="<?php esc_attr_e( 'Register', 'woocommerce' ); ?>"><?php esc_html_e( 'Crear Cuenta', 'woocommerce' ); ?></button>
                    </p>

                    <?php do_action( 'woocommerce_register_form_end' ); ?>

                </form>

            </div>
        </div>
        <?php endif; ?>
    </div>
</div>

<?php do_action( 'woocommerce_after_customer_login_form' ); ?>
