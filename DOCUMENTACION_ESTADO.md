# Documentación de Estado del Proyecto: Dónde te duele la vida hoy

Este documento detalla el progreso del desarrollo de la Clínica/Aula Virtual, lo que ya está completado y los pasos a seguir.

## 1. Lo que ya hicimos (Completado)

*   **Migración Exitosa a Producción (NutHost):**
    *   Se creó el entorno en el subdominio `clinica.dondeteduele.com`.
    *   Se migró todo el trabajo local usando *All-in-One WP Migration*. Para sortear las restricciones del servidor de subida (que limitaban a 2MB o 512MB), se inyectó el archivo de backup `.wpress` de forma manual usando el Administrador de Archivos de cPanel (carpeta `wp-content/ai1wm-backups`), restaurando el sitio a la perfección.

*   **Plan de Contingencia de Ventas (Checkout de Emergencia):**
    *   Para garantizar que el cliente tuviera un producto 100% funcional para su presentación, se re-enrutaron todos los botones de acción ("LO QUIERO", "ACCEDÉ A LA TEMPORADA", "¡MIRALA AHORA!") y los iconos de candado del aula virtual hacia el sistema de tickets de reserva (`https://dondeteduele.com/tickets/?postticket=clinica-online`). Esto garantizó la posibilidad de hacer ventas inmediatas.

*   **Implementación de SEO Técnico y Metadatos:**
    *   Se implementó código nativo de SEO en `header.php` para arreglar la previsualización rota de los links compartidos por WhatsApp.
    *   **Open Graph (Redes Sociales):** Etiquetas configuradas con título, descripción y miniatura gráfica para compartir.
    *   **GEO Tags:** Geolocalización para mejorar el SEO regional en Argentina (`AR`).
    *   **Schema.org:** Se creó un script JSON-LD de tipo `MedicalClinic` con logo y descripción, optimizando la indexación para algoritmos de Inteligencia Artificial y buscadores.
    *   Se cargó y se configuró el Favicon en forma nativa en WordPress.

*   **Ajustes Críticos de Interfaz (Landing Page):**
    *   Textos: Se reemplazaron llamadas a la acción genéricas por textos más claros (ej. "Ver más detalles").
    *   Gráficas: Se actualizaron las métricas en las tarjetas descriptivas (ej. el reloj ahora marca "+5 HS" "EN CAPÍTULOS TEMÁTICOS DIVIDIDOS POR BLOQUES").
    *   Layout: Se removió la tarjeta de "Material Descargable" a pedido, centrando las tarjetas restantes armónicamente para mantener la estética.
    *   Interactividad: Se añadió una animación CSS de tipo *bounce* (rebote suave) a la flecha descendente y se la convirtió en un ancla de *scroll automático* hacia el contenido inferior para mejorar el flujo de navegación.

*   **Aula Virtual y WooCommerce (Bases):**
    *   El shortcode de acordeones `[grilla_episodios]` quedó programado y conectado a la base de datos de episodios (CPT).
    *   Las lógicas de verificación de clientes que hayan comprado un producto de WooCommerce están hechas.

*   **Alta Manual y Masiva de Alumnos (Bypass de WooCommerce):**
    *   Se creó una herramienta de "Alta Alumnos (Rápida)" en el panel de WordPress para registrar alumnos y otorgarles acceso inmediato al Aula Virtual (Temporada 1) sin pasar por el flujo de pago.
    *   Soporta registro individual y carga masiva mediante listado CSV (`Nombre, Apellido, Email, Contraseña`).
    *   Se configuró un sistema de notificaciones personalizado que envía un correo de bienvenida automático. Este correo iguala el texto e imagen del sistema original pero, además, incluye la contraseña (autogenerada o asignada) directamente en el cuerpo del mensaje para agilizar el ingreso de los alumnos pre-registrados.

## 2. Lo que falta hacer (Pendientes)

*   **Finalización de la Integración de Pagos:**
    *   Terminar de integrar la pasarela de pago (ej. Mercado Pago) a WooCommerce.
    *   Una vez que WooCommerce pueda procesar transacciones reales de manera independiente, se deben revertir los links de emergencia para que la compra se vuelva a realizar mediante la tienda interna (`?add-to-cart=XXX`).

## 3. Estado del Repositorio y Git Workflow

*   **Gestión de Ramas de WP Pusher:** Debido a unos archivos pesados de video que causaron errores de subida (timeout) en la rama `main`, todo el despliegue a producción se está manejando actualmente a través de la rama **`actualizacion-urgente`**.
*   WP Pusher fue reconfigurado en producción para escuchar cambios directamente de la rama `actualizacion-urgente`, garantizando que cualquier *push* a esta rama esté disponible para actualizar el tema de inmediato en WordPress.
