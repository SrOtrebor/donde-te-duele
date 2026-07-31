# Memoria del Proyecto y Plan Maestro: "Dónde te duele la vida hoy"

## 📌 Contexto y Estado Actual
- **Entorno:** WordPress Local (Local WP) + WooCommerce.
- **Tema Custom:** Se está desarrollando un tema a medida en `e:\Donde-te-duele\tema-donde-te-duele\`.
- **Despliegue:** Sincronizado vía Git (rama `actualizacion-urgente`) y WP Pusher al servidor en vivo.

## 🚀 Hitos Alcanzados
1. **Página de Inicio (Front Page):**
   - Header, Footer y Hero con SVG dinámicos integrados y alineados a Figma.
2. **Infraestructura de Aulas (Backend):**
   - Creación del Custom Post Type (CPT) **Episodios**.
   - Cajas personalizadas (Metaboxes) para cada episodio: Especialista, Video de Introducción, y hasta 5 Bloques de Contenido.
   - **Soporte Multivideo:** Cada bloque permite uno o varios videos de Google Drive, YouTube o Vimeo (pegando un enlace por línea).
3. **Dashboard de Usuario (Frontend):**
   - Plantilla `dashboard-template.php` terminada.
   - Diseño moderno con barra lateral de navegación interactiva y perfil de usuario.
   - Grilla de episodios dinámica (desplazamiento horizontal).
   - Lógica de JavaScript que permite navegar entre bloques y cargar los reproductores de video instantáneamente sin recargar la página.
4. **Comercio Electrónico:**
   - Se aplicó estilado a medida para la página de **Tienda (Shop)** de WooCommerce, implementando tarjetas de productos redondeadas, botones corporativos y etiquetas de rebajas en naranja, manteniendo la estética premium de la web.

## 🚧 Bloqueantes Actuales / Próximos Pasos
- **Página "Mi Cuenta" de WooCommerce:** Aún pendiente de diseño. El usuario solicitó rediseñar esta página para que no se vea como el panel por defecto de WooCommerce, sino alineada al resto del sitio.
- **Prueba de Videos (QA):** Es necesario que el usuario cargue enlaces reales de Google Drive en el panel de Episodios y verifique cómo se ven en el Dashboard del Frontend en vivo.
- **Flujo de Compra:** Validar la experiencia del usuario desde el Checkout hasta la redirección al Aula Virtual (Dashboard).

---
> **Notas de Integración de Video:**
> - En Google Drive, el video debe tener permiso: "Cualquier usuario que tenga el vínculo".
> - El código en `dashboard-template.php` se encarga automáticamente de extraer el ID y renderizar el iframe (ya sea GDrive, YT o Vimeo).
