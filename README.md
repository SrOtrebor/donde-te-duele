# Memoria Persistente del Proyecto: "Dónde te duele la vida hoy"

Este archivo sirve como **memoria persistente** para que cualquier asistente de IA (o desarrollador) sepa exactamente en qué estado se encuentra el proyecto, qué tecnologías se utilizaron, qué decisiones de arquitectura se tomaron y cuáles son los próximos pasos.

## 📌 Estado Actual del Proyecto (Actualizado: Julio 2026)
Estamos desarrollando una plataforma de gestión de contenido exclusivo (E-learning y venta de tickets) en WordPress.
Nos encontramos actualmente completando la **Fase 2 (Front-End Landing)** e iniciando las **Fases 3 y 4 (Configuración de LMS y Pasarela de Pagos)** según el Plan Maestro.

## 🏗️ Arquitectura y Entorno de Desarrollo
*   **CMS:** WordPress.
*   **Entorno Local:** Local by Flywheel (Local WP).
*   **Flujo de trabajo:** El código fuente se edita en la carpeta externa `E:\Donde-te-duele\` y se sincroniza al servidor de Local WP (`C:\Users\ra_la\Local Sites\donde-te-duele\app\public\wp-content\themes\tema-donde-te-duele\`) usando un comando de copia de PowerShell.
*   **Tema:** Se creó un **Tema Custom desde cero** llamado `tema-donde-te-duele` para garantizar un rendimiento óptimo y reflejar exactamente el diseño provisto en Figma, sin depender de constructores visuales pesados como Elementor.

## 🛠️ Lo que ya hicimos (Hitos completados)

1.  **Desarrollo del Tema Base:**
    *   Creación de `style.css` (variables de color: `--bg-cream`, `--bg-purple`, `--bg-green`, `--text-dark`, `--border-color`).
    *   Configuración de `functions.php` incluyendo Google Fonts (Montserrat, Archivo, Roboto Condensed).
    *   **Fix de Live Links:** Se agregó un filtro en `functions.php` (`wp_make_link_relative`) para que las imágenes usen rutas relativas. Esto evita que las imágenes se rompan cuando el cliente comparte el proyecto por internet usando la función *Live Links* de Local WP.

2.  **Maquetación de la Portada (`front-page.php`):**
    *   Sección Hero con diseño responsivo, navbar integrado y SVG de fondo.
    *   Sección "Acerca de la plataforma" y visualización de Episodios (1 al 4) usando Flexbox.
    *   Sección "Esto es para vos" (grilla de 6 tarjetas con íconos, usando los emojis exportados como PNG de Figma).
    *   Efectos Hover en botones (`.btn-dtd`) con desplazamiento (`translateY`) y sombra sólida offset para dar una estética Pop/Retro.

3.  **Maquetación de Temporada 1 (`page-temporada-1.php`):**
    *   Se creó una plantilla específica para la landing de ventas de la Temporada 1.
    *   Integración de diseño visual con reloj posicionado de forma absoluta para la etiqueta "2 HORAS".
    *   Sección "FAQ" configurada con fondo crema (`#fdfaf1`) a ancho completo (`100%`) y limitación de contenido a `800px`.

4.  **Gestión de Assets (Anti-AdBlockers):**
    *   Se exportaron e incluyeron los SVGs de Figma.
    *   Se **renombraron archivos clave** (`logo.svg` a `marca-dtd.svg`, e iconos sociales a `icono-instagram.svg`, etc.) para evitar que los bloqueadores de anuncios (uBlock, AdBlock) los oculten automáticamente por llamarse "logo" o "RRSS".

5.  **Preparación para E-Commerce y E-Learning:**
    *   Se inyectó en `functions.php` el soporte oficial para **WooCommerce** y **Tutor LMS**.
    *   Se agregó CSS base en `style.css` para que los botones y recuadros de WooCommerce hereden la estética de la marca (bordes redondeados, sombra dura, colores verde/crema).

## 🚀 Próximos Pasos (Lo que falta hacer)

1.  **Diseño de la Pasarela de Pago (Checkout):**
    *   Con el plugin WooCommerce ya instalado y configurado por el cliente, falta probar el flujo de compra.
    *   Afinar detalles visuales del Carrito y el Checkout para que no parezcan de plantilla genérica.

2.  **Dashboard del Alumno (Tutor LMS):**
    *   Sobrescribir las plantillas de Tutor LMS creando la carpeta `/tutor` dentro de nuestro tema custom.
    *   Darle el diseño Figma a la vista de "Mis Cursos" y al reproductor de video para cumplir con la premisa de "Contenido educativo sin progresión (acceso directo a videos)".

3.  **Restricción de Acceso:**
    *   Garantizar que solo los usuarios que compraron la "Temporada 1" (o a los que se les dio de alta manual/código QR) tengan acceso a la página de visualización del video.

## 💡 Instrucciones para retomar en otra PC
1. Instalar **Local WP** y crear un sitio llamado `donde-te-duele`.
2. Pegar la carpeta `tema-donde-te-duele` dentro de `wp-content/themes/`.
3. Instalar y activar los plugins: **WooCommerce** y **Tutor LMS** (versión gratuita).
4. En Tutor LMS (Settings > Monetization), elegir WooCommerce como motor de eCommerce, activar autocompletar órdenes y redirección automática.
5. Desde el panel de WordPress, crear la página "Home" (asignarle plantilla por defecto o Portada) y la página "Temporada 1" (asignarle la plantilla *Temporada 1*).
6. Leer este README e informarle a la IA: *"Estoy en la otra PC, ya leí el README, continuemos con el Paso 1 de los Próximos Pasos"*.
