# Memoria del Proyecto y Plan Maestro: "Dónde te duele la vida hoy"

## 📌 Contexto y Estado Actual
- **Entorno:** WordPress Local (Local WP) + WooCommerce.
- **Tema Custom:** Se está desarrollando un tema a medida en `e:\Donde-te-duele\tema-donde-te-duele\`.
- **Diseño a Respetar (100% Figma):** 
  - Colores pastel: Crema (`#fdfaf1`), Amarillo (`#fffa64`), Violeta (`#e59bf0`), Naranja (`#ffa872`), Verde lima (`#bfd43b`).
  - Tipografía: `Roboto Condensed` para títulos y `Archivo` para cuerpos de texto.
  - El diseño depende fuertemente de assets en SVG exportados desde Figma (fondos, botones complejos, grillas).

## 🚀 Hitos Alcanzados (Hoy)
1. **Configuración Inicial:** Tema de WP enlazado al entorno de Local WP mediante scripts de copia en PowerShell.
2. **Estructura Base (`header.php` y `footer.php`):**
   - Header con fondo geométrico (`Group 86.svg`) y Logo centrado.
   - Footer con logo y redes sociales vectorizadas.
3. **Secciones de `front-page.php` completadas:**
   - Sección Amarilla ("Clínica Online") con ilustración `Group 117.svg`.
   - Sección Violeta ("Temporada 1") con badge en SVG y episodios.
   - Secciones "Qué vas a recibir" y "Esto es para vos" refactorizadas para usar directamente los SVGs completos exportados de Figma (`Frame 254` al `259`), logrando un pixel-perfect instantáneo para las tarjetas con íconos.
4. **Herramienta de Mapeo Creada:** Se creó un script en HTML/JS (`icon-mapper.html`) para arrastrar y soltar íconos, lo que permitió descubrir las coordenadas exactas de la grilla del Hero.

## 🚧 Bloqueante Actual / Próximos Pasos (Mañana)
- **El Hero Section:** A pesar de haber mapeado la grilla de íconos laterales (10 celdas por lado) usando CSS Grid, y de incluir el SVG grande (`Group-8.svg`) que abarca 2x2 celdas, el layout visual en el navegador aún no se alinea perfectamente con la visión del Figma del usuario ("falta eso a la izquierda y el otro a la derecha").
- **Acción para mañana:** 
  1. Revisar con mayor detalle cómo CSS Grid está renderizando el contenedor principal frente a las resoluciones de pantalla.
  2. Ajustar los anchos de columna (`hero-side` vs `hero-center-area`) y el comportamiento responsivo de la grilla.
  3. Asegurar que las imágenes SVG ocupen el grid-span exacto sin romper el flujo (particularmente el `Group-8.svg`).

---
> **Mapeo de Íconos del Hero (Aprobado por el usuario):**
> 
> **Izquierda (2 cols x 5 filas):**
> - Fila 1: Group-14 | Vector-21
> - Fila 2: Vector-21 | Group-12
> - Fila 3: Vector-21 | Vector-21
> - Fila 4 y 5: [Group-8 ocupa estas 4 celdas 2x2]
>
> **Derecha (2 cols x 5 filas):**
> - Fila 1: Group-13 | Vector-26
> - Fila 2: Vector-26 | Group-11
> - Fila 3: Vector-26 | Group-8 (este es de 1x1)
> - Fila 4: Vector-26 | Vector-26
> - Fila 5: Group-6 | Vector-26
