# Memoria del Proyecto y Plan Maestro: "Dónde te duele la vida hoy"

## 📌 Contexto y Estado Actual
- **Entorno:** WordPress Local (Local WP) + WooCommerce.
- **Tema Custom:** Se está desarrollando un tema a medida en `e:\Donde-te-duele\tema-donde-te-duele\`.
- **Despliegue:** Sincronizado vía Git (rama `actualizacion-urgente`) y WP Pusher al servidor en vivo.

## 🚀 Hitos Alcanzados
1. **Página de Inicio (Front Page):**
   - Header, Footer y Hero con SVG dinámicos integrados y alineados a Figma.
2. **Infraestructura de Aulas (Backend) y MULTI-CURSOS:**
   - Creación del Custom Post Type (CPT) **Episodios**.
   - **NUEVO:** Creación de Taxonomía **"Cursos"** (ej: Temporada 1, Temporada 2).
   - Cajas personalizadas (Metaboxes) para cada episodio: Especialista, Video de Introducción, y hasta 5 Bloques de Contenido (soporte multivideo).
3. **Dashboard de Usuario (Frontend):**
   - Plantilla `dashboard-template.php` terminada y dinámica.
   - Si el usuario tiene varios cursos habilitados, aparecen sus miniaturas correspondientes ("Temporada 1", "Temporada 2").
   - Si no los tiene pagados, se muestran como **"Contenido Bloqueado 🔒"** con un botón que enlaza a la tienda para comprarlo.
4. **Comercio Electrónico, Accesos y UX:**
   - **Lógica de Accesos (`dtd_user_has_access`):** Al comprar un producto en WooCommerce con el custom field `_dtd_unlocks_curso` (ej. valor: `temporada-1`), el usuario desbloquea ese curso automáticamente.
   - **Compatibilidad hacia atrás (Backward Compatibility):** Los alumnos antiguos que fueron dados de alta a mano (tienen la meta `_dtd_acceso_temporada_1`) o compraron el producto original (ID 26), siguen teniendo acceso a la Temporada 1 automáticamente.
   - **Cupones:** Se activó por código el soporte de cupones nativo de WooCommerce en el Carrito.
   - **Correos:** Se desactivaron por código y panel los correos nativos redundantes de WooCommerce ("Pedido Procesando" y "Pedido Completado"), dejando solo el correo personalizado de Bienvenida y el de Mercado Pago.

## 🚧 Próximos Pasos (Flujo de nuevas temporadas)
- **Para vender una nueva temporada:** 
  1. Crear la categoría/curso en "Cursos" (ej: `temporada-2`).
  2. Subir los episodios y marcarlos con esa categoría.
  3. Crear un producto en WooCommerce y añadirle un Campo Personalizado: Nombre `_dtd_unlocks_curso`, Valor `temporada-2`.
  4. (Opcional) Crear una Landing Page como `/temporada-2/` con botones directos hacia la página de pago (Checkout) del producto nuevo.

---
> **Notas de Integración de Video:**
> - En Google Drive, el video debe tener permiso: "Cualquier usuario que tenga el vínculo".
> - El código en `dashboard-template.php` se encarga automáticamente de extraer el ID y renderizar el iframe (ya sea GDrive, YT o Vimeo).
