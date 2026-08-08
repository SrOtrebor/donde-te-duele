# Incidente de Actualización WooCommerce y Mercado Pago (Agosto 2026)

## Problema Original
Tras la actualización automática de WordPress a la versión 7.0.3 y de WooCommerce a la versión 11.0.0, el sitio web experimentó un "Error Crítico" (`Fatal Error`) cada vez que se intentaba activar el plugin de WooCommerce o Mercado Pago.
Adicionalmente, al estar desactivado WooCommerce, el tema personalizado de la clínica tiraba un error crítico en el front-end porque intentaba ejecutar funciones de WooCommerce (ej: `wc_get_page_permalink()`) que no existían.

## Proceso de Resolución

1. **Bypass del Límite de Subida**: Como el servidor bloqueaba subir archivos pesados ("El enlace expiró"), se utilizó el plugin *Tuxedo Big File Uploads* y *WP File Manager* para sortear la restricción.
2. **Downgrade de WooCommerce**: Se determinó que la versión 11 de WooCommerce era incompatible con el ecosistema actual del servidor/tema. Se desinstaló completamente la v11 y se instaló de forma limpia una versión anterior estable (**10.9.4**).
3. **Reactivación**: Al activar WooCommerce 10.9.4, el sitio dejó de arrojar el error fatal en el administrador y el front-end recuperó toda su funcionalidad. Luego se reinstaló y activó con éxito **Mercado Pago**.
4. **Configuración de Cuentas Automáticas**: Se corrigió la configuración de WooCommerce para que los pagos generen el acceso al aula de forma automática:
   - Se desactivó el "Pago como invitado".
   - Se activó la creación de cuentas "Durante el pago".
   - Se activó el envío automático del enlace para establecer la contraseña.

## Cambios en el Tema (tema-donde-te-duele)
- **`page-temporada-1.php`**: Se ajustó el CSS del botón "IR A MI AULA" (`.btn-login-sutil-t1`) para que no ocupe el 100% del ancho del contenedor en la landing page, agregando `max-width: max-content; width: fit-content; margin: 15px auto 0;`.
- *Nota*: Durante el diagnóstico se intentaron agregar *polyfills* en `functions.php`, pero fueron removidos porque generaban conflicto (`Cannot redeclare`) durante la activación de WooCommerce.

## Pendiente para mañana
- Realizar una compra de prueba completa utilizando el checkout (ya sea por transferencia o MP real) para validar que el sistema cree el usuario, envíe los correos correctamente y brinde acceso automático a la sección "Mi Aula" en el front-end.
