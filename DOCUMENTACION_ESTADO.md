# Documentación de Estado del Proyecto: Dónde te duele la vida hoy

Este documento detalla el progreso del desarrollo de la Clínica/Aula Virtual, lo que ya está completado y los pasos a seguir. 

## 1. Lo que ya hicimos (Completado)

*   **Integración de WooCommerce (Checkout Personalizado):**
    *   Instalación y configuración de WooCommerce para manejar la venta de la "Temporada 1".
    *   Traducción forzada al español mediante configuración de idioma de WordPress.
    *   Se diseñó una página de *Checkout* (Pago) totalmente a medida que respeta el manual de marca (colores beige, bordes marrones, tipografía Archivo).
    *   Se limpió la interfaz para que el usuario no tenga distracciones a la hora de pagar.

*   **Aula Virtual Dinámica (Shortcode `[grilla_episodios]`):**
    *   Se desarrolló un componente visual de "Acordeones" exacto al diseño de Figma (Cajas verdes `#bfd43b` con grilla interna de videos).
    *   **Lógica de Acceso Inteligente:** El sistema detecta automáticamente si el usuario pagó (usando la función `wc_customer_bought_product` de WooCommerce). Si pagó, le muestra íconos de "Play". Si no pagó o no inició sesión, le muestra íconos de "Candado" que redirigen al carrito.
    *   **Conexión con Base de Datos:** El shortcode dejó de tener textos fijos y ahora "chupa" la información automáticamente desde el Custom Post Type (CPT) de **"Episodios"**. Esto permite que el cliente edite títulos y bloques directamente desde el panel de WordPress sin tocar código.

*   **Ajustes Globales del Tema:**
    *   Se eliminó la caja violeta promocional (*"Herramientas, reflexiones..."*) de forma condicional, de manera que desaparece automáticamente dentro de la página del Aula Virtual para no distraer, pero se mantiene en el resto del sitio (ej: Home).
    *   Se actualizaron los enlaces sociales del Footer (Instagram, Facebook, TikTok) y el crédito a la agencia NoMad, asegurando que abran en una nueva pestaña.
    *   Se limpió el repositorio ignorando archivos de video pesados (`.crdownload`) de la carpeta `Videos/` que bloqueaban la subida a GitHub (usando `.gitignore`).

---

## 2. Lo que falta hacer (Pendientes)

*   **Configuración de Métodos de Pago:**
    *   Instalar y vincular **Mercado Pago** (o PayPal/Stripe) en WooCommerce > Ajustes > Pagos para habilitar transacciones reales.
*   **Migración a Producción:**
    *   Exportar el sitio actual de prueba (TasteWP/Local) usando *All-in-One WP Migration*.
    *   Crear un Subdominio (`clinica.dondeteduele.com`) o una Subcarpeta (`/clinica`) en el Hosting definitivo del cliente e importar el sitio allí para no romper la web original.
*   **SEO, GEO y Schema para Inteligencia Artificial:**
    *   **SEO (Search Engine Optimization):** Optimizar meta-títulos, descripciones y URLs de la página de venta de la Temporada 1 para posicionamiento en Google (ej: usar Yoast SEO o RankMath).
    *   **GEO:** Si aplica, estructurar etiquetas para posicionamiento local si el contenido está segmentado a un público de Argentina o hispanohablante.
    *   **Schema Markup para IA:** Implementar marcado estructurado JSON-LD (ej: `Course`, `Product`, `Organization`) para que los motores de búsqueda y herramientas de Inteligencia Artificial entiendan perfectamente que se está vendiendo un "Curso de Psicología" y puedan recomendarlo en sus respuestas generativas (ChatGPT, Gemini, Google SGE).

---

## 3. Flujo de Trabajo en Git (Git Workflow)

Para que el plugin **WP Pusher** en el servidor de pruebas descargara correctamente los cambios sin romper el sitio en vivo, adoptamos la siguiente estrategia de ramas:

1.  **Trabajo Activo:** Todo el código nuevo se desarrolla y se "commitea" en la rama secundaria llamada `actualizacion-urgente`.
2.  **Fusión (Merge):** Una vez que el código funciona localmente, se fusiona la rama `actualizacion-urgente` hacia la rama `main`.
3.  **Subida (Push):** Se empuja la rama `main` a GitHub. WP Pusher está configurado para "escuchar" la rama `main`, por lo que al darle "Update Theme", descarga automáticamente los cambios.

*Nota para el desarrollador que continúa:* Recuerda asegurarte de estar trabajando sobre la rama `actualizacion-urgente` (haciendo un `git fetch` y `git pull`) al retomar el proyecto en la otra PC.
