<?php
/**
 * SEO, GEO y Schema.org estructurado para Buscadores e Inteligencias Artificiales (IA)
 * (ChatGPT Search, Perplexity, Gemini, Claude, Copilot, Google SGE)
 *
 * @package DondeTeDuele
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// 1. Determinar contexto de la página
$is_front = is_front_page() || is_home();
$post_id  = get_queried_object_id();

$is_temporada_1 = false;
if ( is_page_template( 'page-temporada-1.php' ) || ( is_page() && get_post_field( 'post_name', $post_id ) === 'temporada-1' ) ) {
    $is_temporada_1 = true;
}

$is_private_area = false;
if ( 
    is_page_template( 'dashboard-template.php' ) || 
    ( is_page() && in_array( get_post_field( 'post_name', $post_id ), array( 'dashboard', 'aula-virtual', 'mi-aula', 'finalizar-compra', 'carrito' ), true ) ) ||
    ( function_exists( 'is_cart' ) && is_cart() ) || 
    ( function_exists( 'is_checkout' ) && is_checkout() ) || 
    ( function_exists( 'is_account_page' ) && is_account_page() )
) {
    $is_private_area = true;
}

// 2. Metadatos dinámicos según la página
$site_name = 'Dónde te duele la vida hoy';
$base_url  = home_url( '/' );
$logo_url  = get_template_directory_uri() . '/assets/logo-dtd-recortado.svg';
$home_img  = get_template_directory_uri() . '/assets/Home.png';

if ( $is_front ) {
    $page_title       = 'Dónde te duele la vida hoy | Clínica Online y Aula Virtual';
    $meta_description = 'Clínica Online y Aula Virtual de Dónde te duele la vida hoy. Un espacio de aprendizaje, reflexión y herramientas para comprender tus conflictos, vínculos y emociones.';
    $canonical_url    = $base_url;
    $og_image         = $home_img;
    $og_type          = 'website';
} elseif ( $is_temporada_1 ) {
    $page_title       = 'Temporada 1: Amor, Dinero, Duelo y Crecimiento | Dónde te duele la vida hoy';
    $meta_description = 'Ciclo de encuentros y masterclasses online con especialistas (+5 hs de contenido grabado). Abordá el amor con Claudio A. González, el dinero con Maxi González, el duelo con Mery Molinero y el crecimiento con César.';
    $canonical_url    = get_permalink( $post_id );
    $og_image         = get_template_directory_uri() . '/assets/temporada1/DTDLVH_Elearning_HOME_img/source/hero-img.png';
    $og_type          = 'article';
} elseif ( $is_private_area ) {
    $page_title       = 'Mi Aula Virtual | ' . $site_name;
    $meta_description = 'Acceso a clases y contenidos exclusivos para alumnos de Dónde te duele la vida hoy.';
    $canonical_url    = get_permalink( $post_id );
    $og_image         = $home_img;
    $og_type          = 'website';
} else {
    $page_title       = wp_get_document_title();
    $meta_description = 'Clínica Online y Aula Virtual - Dónde te duele la vida hoy.';
    $canonical_url    = get_permalink( $post_id ) ? get_permalink( $post_id ) : $base_url;
    $og_image         = $home_img;
    $og_type          = 'website';
}

$has_seo_plugin = defined( 'WPSEO_VERSION' ) || defined( 'RANK_MATH_VERSION' );
?>

<?php if ( ! $has_seo_plugin ) : ?>
    <!-- ========================================== -->
    <!-- SEO BÁSICO Y CONTROL DE INDEXACIÓN         -->
    <!-- ========================================== -->
    <title><?php echo esc_html( $page_title ); ?></title>
    <meta name="description" content="<?php echo esc_attr( $meta_description ); ?>">
    <meta name="author" content="Clínica Dónde te duele la vida hoy">
    <link rel="canonical" href="<?php echo esc_url( $canonical_url ); ?>">

    <?php if ( $is_private_area ) : ?>
        <meta name="robots" content="noindex, nofollow">
    <?php else : ?>
        <meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1">
    <?php endif; ?>

    <!-- ========================================== -->
    <!-- GEO TAGS (Geolocalización para Buscadores) -->
    <!-- ========================================== -->
    <meta name="geo.region" content="AR-C">
    <meta name="geo.placename" content="Buenos Aires, Argentina">
    <meta name="geo.position" content="-34.6037;-58.3816">
    <meta name="ICBM" content="-34.6037, -58.3816">
    <meta http-equiv="content-language" content="es">

    <!-- ========================================== -->
    <!-- OPEN GRAPH (WhatsApp, Facebook, LinkedIn)  -->
    <!-- ========================================== -->
    <meta property="og:site_name" content="<?php echo esc_attr( $site_name ); ?>">
    <meta property="og:type" content="<?php echo esc_attr( $og_type ); ?>">
    <meta property="og:title" content="<?php echo esc_attr( $page_title ); ?>">
    <meta property="og:description" content="<?php echo esc_attr( $meta_description ); ?>">
    <meta property="og:url" content="<?php echo esc_url( $canonical_url ); ?>">
    <meta property="og:image" content="<?php echo esc_url( $og_image ); ?>">
    <meta property="og:locale" content="es_AR">

    <!-- ========================================== -->
    <!-- TWITTER / X CARDS                          -->
    <!-- ========================================== -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?php echo esc_attr( $page_title ); ?>">
    <meta name="twitter:description" content="<?php echo esc_attr( $meta_description ); ?>">
    <meta name="twitter:image" content="<?php echo esc_url( $og_image ); ?>">
<?php endif; ?>

<!-- ======================================================== -->
<!-- SCHEMA.ORG (DATOS ESTRUCTURADOS JSON-LD PARA IA Y GOOGLE)-->
<!-- ======================================================== -->
<?php
// Armado del Graph de Schema.org
$schema_graph = array();

// 1. Entidad Organización / Negocio Educativo
$schema_org = array(
    '@type'         => array( 'EducationalOrganization', 'OnlineBusiness' ),
    '@id'           => $base_url . '#organization',
    'name'          => 'Dónde te duele la vida hoy',
    'alternateName' => 'Clínica Dónde te duele',
    'url'           => $base_url,
    'logo'          => array(
        '@type' => 'ImageObject',
        'url'   => $logo_url,
    ),
    'image'         => $home_img,
    'description'   => 'Clínica Online y Aula Virtual enfocada en el desarrollo personal, salud emocional, procesos de duelo, vínculos y autoconocimiento.',
    'address'       => array(
        '@type'           => 'PostalAddress',
        'addressLocality' => 'Buenos Aires',
        'addressRegion'   => 'CABA',
        'addressCountry'  => 'AR',
    ),
    'geo'           => array(
        '@type'     => 'GeoCoordinates',
        'latitude'  => -34.6037,
        'longitude' => -58.3816,
    ),
    'sameAs'        => array(
        'https://www.instagram.com/dondeteduele.hoy/',
        'https://www.facebook.com/profile.php?id=61589366597840',
        'https://www.tiktok.com/@dondeteduele.hoy',
    ),
    'knowsAbout'    => array(
        'Salud emocional',
        'Psicología y Psicoanálisis',
        'Duelo y Procesos de Pérdida',
        'Vínculos Afectivos y Relaciones Humanas',
        'Relación con el Dinero y Creencias Limitantes',
        'Crecimiento Personal y Autoconocimiento',
        'Clínica Online',
    ),
);
$schema_graph[] = $schema_org;

// 2. Entidad WebSite
$schema_website = array(
    '@type'       => 'WebSite',
    '@id'         => $base_url . '#website',
    'url'         => $base_url,
    'name'        => 'Dónde te duele la vida hoy',
    'description' => 'Clínica Online y Aula Virtual de Desarrollo Personal',
    'publisher'   => array(
        '@id' => $base_url . '#organization',
    ),
    'inLanguage'  => 'es-AR',
);
$schema_graph[] = $schema_website;

// 3. Si estamos en la TEMPORADA 1: Añadir Schema "Course" y Schema "FAQPage"
if ( $is_temporada_1 ) {
    
    // Obtener campos dinámicos si la función del editor existe
    $get_content = function_exists( 'dtd_get_page_content' ) ? 'dtd_get_page_content' : function( $id, $key, $def ) { return $def; };

    // Datos de expositores
    $esp1_name = $get_content( $post_id, '_dtd_t1_esp_1_name', 'Claudio A. González' );
    $esp1_cat  = $get_content( $post_id, '_dtd_t1_esp_1_cat', 'Amor y Vínculos' );
    $esp1_desc = wp_strip_all_tags( $get_content( $post_id, '_dtd_t1_esp_1_desc', 'Explorá cómo los vínculos, las lealtades familiares y las dinámicas invisibles pueden influir en tu forma de amar.' ) );

    $esp2_name = $get_content( $post_id, '_dtd_t1_esp_2_name', 'Maxi González' );
    $esp2_cat  = $get_content( $post_id, '_dtd_t1_esp_2_cat', 'Dinero y Abundancia' );
    $esp2_desc = wp_strip_all_tags( $get_content( $post_id, '_dtd_t1_esp_2_desc', 'Una mirada sobre las creencias, historias y narrativas que condicionan tu relación con el dinero.' ) );

    $esp3_name = $get_content( $post_id, '_dtd_t1_esp_3_name', 'Mery Molinero' );
    $esp3_cat  = $get_content( $post_id, '_dtd_t1_esp_3_cat', 'Duelo y Pérdida' );
    $esp3_desc = wp_strip_all_tags( $get_content( $post_id, '_dtd_t1_esp_3_desc', 'Un recorrido para comprender los procesos de pérdida, cierre y transformación.' ) );

    $esp4_name = $get_content( $post_id, '_dtd_t1_esp_4_name', 'César' );
    $esp4_cat  = $get_content( $post_id, '_dtd_t1_esp_4_cat', 'Crecimiento y Transformación' );
    $esp4_desc = wp_strip_all_tags( $get_content( $post_id, '_dtd_t1_esp_4_desc', 'Herramientas para comprenderte mejor y evolucionar tu mirada sobre la vida.' ) );

    $promo_price_raw = $get_content( $post_id, '_dtd_t1_promo_price', '95000' );
    $promo_price_clean = preg_replace( '/[^0-9]/', '', $promo_price_raw );
    if ( empty( $promo_price_clean ) ) {
        $promo_price_clean = '95000';
    }

    $schema_course = array(
        '@type'               => 'Course',
        '@id'                 => $canonical_url . '#course',
        'name'                => 'Temporada 1: Amor, Dinero, Duelo y Crecimiento',
        'description'         => 'Ciclo de encuentros y masterclasses online grabados por especialistas. Más de 5 horas de contenido temático dividido en 4 grandes ejes.',
        'provider'            => array(
            '@id' => $base_url . '#organization',
        ),
        'inLanguage'          => 'es',
        'timeRequired'        => 'PT5H',
        'educationalLevel'    => 'Todos los niveles',
        'hasCourseInstance'   => array(
            '@type'          => 'CourseInstance',
            'courseMode'     => 'online',
            'courseWorkload' => 'PT5H',
            'inLanguage'     => 'es',
        ),
        'offers'              => array(
            '@type'         => 'Offer',
            'category'      => 'Paid',
            'price'         => $promo_price_clean,
            'priceCurrency' => 'ARS',
            'availability'  => 'https://schema.org/InStock',
            'url'           => 'https://dondeteduele.com/tickets/?postticket=clinica-online',
        ),
        'instructor'          => array(
            array(
                '@type'       => 'Person',
                'name'        => $esp1_name,
                'jobTitle'    => $esp1_cat,
                'description' => $esp1_desc,
            ),
            array(
                '@type'       => 'Person',
                'name'        => $esp2_name,
                'jobTitle'    => $esp2_cat,
                'description' => $esp2_desc,
            ),
            array(
                '@type'       => 'Person',
                'name'        => $esp3_name,
                'jobTitle'    => $esp3_cat,
                'description' => $esp3_desc,
            ),
            array(
                '@type'       => 'Person',
                'name'        => $esp4_name,
                'jobTitle'    => $esp4_cat,
                'description' => $esp4_desc,
            ),
        ),
    );
    $schema_graph[] = $schema_course;

    // Preguntas Frecuentes (FAQPage)
    $faqs_data = array(
        array(
            'q' => $get_content( $post_id, '_dtd_t1_faq1_q', '¿Cómo accedo a los episodios una vez que compro la temporada?' ),
            'a' => $get_content( $post_id, '_dtd_t1_faq1_a', 'Una vez que completes el pago, recibirás un correo electrónico con tus credenciales de acceso para ingresar directamente a tu aula virtual en esta misma web.' ),
        ),
        array(
            'q' => $get_content( $post_id, '_dtd_t1_faq2_q', '¿Las clases son en vivo o grabadas?' ),
            'a' => $get_content( $post_id, '_dtd_t1_faq2_a', 'Todos los episodios están previamente grabados en alta definición. Podés verlos en el momento que quieras, pausarlos y repetirlos a tu propio ritmo.' ),
        ),
        array(
            'q' => $get_content( $post_id, '_dtd_t1_faq3_q', '¿Por cuánto tiempo tengo acceso al contenido?' ),
            'a' => $get_content( $post_id, '_dtd_t1_faq3_a', 'Tenés acceso ilimitado para ver todos los episodios todas las veces que desees, sin límites de reproducciones.' ),
        ),
        array(
            'q' => $get_content( $post_id, '_dtd_t1_faq4_q', '¿Puedo verlo desde cualquier país y dispositivo?' ),
            'a' => $get_content( $post_id, '_dtd_t1_faq4_a', 'Sí, podés acceder desde cualquier país del mundo. El aula virtual funciona a la perfección en teléfonos móviles, tablets y computadoras.' ),
        ),
        array(
            'q' => $get_content( $post_id, '_dtd_t1_faq5_q', '¿Necesito conocimientos previos en psicología o filosofía?' ),
            'a' => $get_content( $post_id, '_dtd_t1_faq5_a', 'Para nada. Cada expositor aborda su temática con un lenguaje claro, cercano y práctico, pensado para cualquier persona interesada en comprenderse mejor.' ),
        ),
        array(
            'q' => $get_content( $post_id, '_dtd_t1_faq6_q', '¿Cuáles son los medios de pago disponibles?' ),
            'a' => $get_content( $post_id, '_dtd_t1_faq6_a', 'Aceptamos tarjetas de crédito, débito y dinero en cuenta a través de Mercado Pago para Argentina, con opciones de pago en cuotas.' ),
        ),
    );

    $faq_entities = array();
    foreach ( $faqs_data as $faq ) {
        if ( ! empty( $faq['q'] ) && ! empty( $faq['a'] ) ) {
            $faq_entities[] = array(
                '@type'          => 'Question',
                'name'           => wp_strip_all_tags( $faq['q'] ),
                'acceptedAnswer' => array(
                    '@type' => 'Answer',
                    'text'  => wp_strip_all_tags( $faq['a'] ),
                ),
            );
        }
    }

    if ( ! empty( $faq_entities ) ) {
        $schema_graph[] = array(
            '@type'      => 'FAQPage',
            '@id'        => $canonical_url . '#faq',
            'mainEntity' => $faq_entities,
        );
    }
}

$final_schema = array(
    '@context' => 'https://schema.org',
    '@graph'   => $schema_graph,
);
?>
<script type="application/ld+json">
<?php echo wp_json_encode( $final_schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT ); ?>
</script>
