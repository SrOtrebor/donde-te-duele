<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php wp_title('|', true, 'right'); bloginfo('name'); ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Archivo:ital,wght@0,400;0,700;1,400&family=Roboto+Condensed:wght@400;700&display=swap" rel="stylesheet">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?> style="margin: 0; padding: 0; background-color: #ffffff; display: flex; flex-direction: column; align-items: center;">
<?php wp_body_open(); ?>

<div id="page-wrapper" style="width: 100%; max-width: 1440px; background-color: #fdfaf1; overflow: hidden; box-shadow: 0 0 10px rgba(0,0,0,0.1);">

<!-- NAVBAR: usa Group 86.svg como imagen de fondo (barra crema con logo centrado y geometría) -->
<header style="width:100%; position:relative; line-height:0;">
    <!-- SVG de fondo de la barra de navegación -->
    <img src="<?php echo get_template_directory_uri(); ?>/assets/Group 86.svg" alt="" style="width:100%; display:block;">
    <!-- Enlace transparente superpuesto justo al medio donde está el logo (ancho aprox 250px) -->
    <a href="<?php echo home_url('/'); ?>" style="position:absolute; top:0; left:50%; transform:translateX(-50%); width:250px; height:100%; display:block;" title="Inicio"></a>
</header>
