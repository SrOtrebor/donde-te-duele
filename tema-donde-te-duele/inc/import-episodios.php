<?php
function dtd_auto_import_episodios() {
    // Solo correr una vez
    if ( get_option( 'dtd_episodios_imported_v1' ) ) {
        return;
    }

    $episodes = [
        [
            'title' => 'EPISODIO 1: AMOR',
            'menu_order' => 1,
            'especialista' => 'Claudio Alberto González',
            'bloques' => [
                0 => ['titulo' => 'Bloque 0 | Presentación', 'objetivo' => '', 'preguntas' => ''],
                1 => [
                    'titulo' => 'Bloque 1 | Los vínculos que heredamos',
                    'objetivo' => 'Comprender que muchas dinámicas amorosas no comienzan en la pareja actual, sino en la historia familiar y los sistemas a los que pertenecemos.',
                    'preguntas' => "1. ¿Qué formas de amar observaste en tu familia mientras crecías?\n2. ¿Qué situaciones afectivas se repiten una y otra vez en tu vida?"
                ],
                2 => [
                    'titulo' => 'Bloque 2 | Las lealtades invisibles',
                    'objetivo' => 'Explorar cómo las lealtades familiares inconscientes pueden influir en nuestras elecciones, vínculos y dificultades afectivas.',
                    'preguntas' => "1. ¿A quién podrías estar siendo leal sin darte cuenta a través de tus relaciones?\n2. ¿Qué precio estás pagando por permanecer fiel a una historia que no te pertenece?"
                ],
                3 => [
                    'titulo' => 'Bloque 3 | Amar desde un nuevo lugar',
                    'objetivo' => 'Abrir la posibilidad de relacionarse desde una posición más consciente, adulta y libre.',
                    'preguntas' => "1. ¿Qué necesitarías dejar atrás para amar de una manera diferente?\n2. ¿Cómo sería una relación construida desde la libertad y no desde la necesidad?"
                ],
                4 => ['titulo' => 'Bloque 4 | Cierre', 'objetivo' => '', 'preguntas' => '']
            ]
        ],
        [
            'title' => 'EPISODIO 2: TRABAJO y DINERO',
            'menu_order' => 2,
            'especialista' => 'Maximiliano González',
            'bloques' => [
                0 => ['titulo' => 'Bloque 0 | Presentación', 'objetivo' => '', 'preguntas' => ''],
                1 => [
                    'titulo' => 'Bloque 1 | Las historias que aprendimos sobre el trabajo / dinero',
                    'objetivo' => 'Identificar las narrativas heredadas que moldean nuestra relación con el dinero.',
                    'preguntas' => "1. ¿Qué frases sobre el dinero escuchabas con frecuencia en tu casa?\n2. ¿Qué aprendiste acerca de las personas que tienen mucho dinero?"
                ],
                2 => [
                    'titulo' => 'Bloque 2 | Trabajo / Dinero, identidad y valor personal',
                    'objetivo' => 'Comprender cómo las creencias sobre el merecimiento y el valor propio impactan en la economía personal.',
                    'preguntas' => "1. ¿Qué relación existe entre lo que valés y lo que creés que merecés recibir?\n2. ¿Qué partes de tu historia siguen condicionando tus decisiones económicas actuales?"
                ],
                3 => [
                    'titulo' => 'Bloque 3 | Reescribir la narrativa',
                    'objetivo' => 'Reconocer que es posible construir una nueva relación con el dinero a partir de una comprensión diferente de la propia historia.',
                    'preguntas' => "1. ¿Qué historia sobre el dinero ya no te representa?\n2. ¿Qué nueva narrativa te gustaría empezar a habitar?"
                ],
                4 => ['titulo' => 'Bloque 4 | Cierre', 'objetivo' => '', 'preguntas' => '']
            ]
        ],
        [
            'title' => 'EPISODIO 3: DUELO',
            'menu_order' => 3,
            'especialista' => 'Mery Molinero',
            'bloques' => [
                0 => ['titulo' => 'Bloque 0 | Presentación', 'objetivo' => '', 'preguntas' => ''],
                1 => [
                    'titulo' => 'Bloque 1 | Las pérdidas que nos transforman',
                    'objetivo' => 'Ampliar la comprensión del duelo más allá de la muerte física.',
                    'preguntas' => "1. ¿Qué pérdida sigue teniendo impacto en tu vida hoy?\n2. ¿Qué parte de vos cambió a partir de esa experiencia?"
                ],
                2 => [
                    'titulo' => 'Bloque 2 | Lo que todavía no pudo cerrarse',
                    'objetivo' => 'Explorar los vínculos, emociones o experiencias que permanecen abiertos y continúan demandando energía.',
                    'preguntas' => "1. ¿Qué situación sentís que todavía no pudiste terminar de soltar?\n2. ¿Qué conversación, despedida o reconocimiento quedó pendiente?"
                ],
                3 => [
                    'titulo' => 'Bloque 3 | Transformación y sentido',
                    'objetivo' => 'Integrar la experiencia de pérdida como parte de un proceso de evolución y aprendizaje.',
                    'preguntas' => "1. ¿Qué aprendizaje emergió de aquello que perdiste?\n2. ¿Qué nuevo capítulo intenta abrirse después de ese cierre?"
                ],
                4 => ['titulo' => 'Bloque 4 | Cierre', 'objetivo' => '', 'preguntas' => '']
            ]
        ],
        [
            'title' => 'EPISODIO 4: CRECIMIENTO',
            'menu_order' => 4,
            'especialista' => 'César Trombino',
            'bloques' => [
                0 => ['titulo' => 'Bloque 0 | Presentación', 'objetivo' => '', 'preguntas' => ''],
                1 => [
                    'titulo' => 'Bloque 1 | Cuando la vida te pide evolucionar',
                    'objetivo' => 'Reconocer los síntomas, conflictos o situaciones repetitivas que suelen aparecer cuando una etapa de crecimiento necesita producirse.',
                    'preguntas' => "1. ¿Qué situación de tu vida te está generando incomodidad o frustración de manera recurrente?\n2. ¿Qué aspecto de tu realidad parece estar pidiéndote un cambio que todavía no lográs realizar?"
                ],
                2 => [
                    'titulo' => 'Bloque 2 | El mensaje detrás del bloqueo',
                    'objetivo' => 'Comprender que muchos obstáculos, síntomas o conflictos pueden contener información valiosa sobre procesos de aprendizaje pendientes.',
                    'preguntas' => "1. ¿Qué podría estar intentando mostrarte aquello que hoy vivís como un problema?\n2. ¿Qué aprendizaje o desafío personal evitás mirar detrás de ese conflicto?"
                ],
                3 => [
                    'titulo' => 'Bloque 3 | Transformar la dificultad en crecimiento',
                    'objetivo' => 'Desarrollar una nueva mirada sobre los desafíos de la vida, entendiéndolos como oportunidades para expandir la conciencia y generar transformación.',
                    'preguntas' => "1. ¿Qué cambiaría si dejaras de luchar contra lo que te sucede y comenzaras a escucharlo?\n2. ¿Cuál es el próximo paso de crecimiento que la vida te está invitando a dar hoy?"
                ],
                4 => ['titulo' => 'Bloque 4 | Cierre', 'objetivo' => '', 'preguntas' => '']
            ]
        ]
    ];

    foreach ($episodes as $ep) {
        $post_id = wp_insert_post([
            'post_title'  => $ep['title'],
            'post_type'   => 'episodio',
            'post_status' => 'publish',
            'menu_order'  => $ep['menu_order']
        ]);
        
        if (!is_wp_error($post_id)) {
            update_post_meta($post_id, '_dtd_especialista', $ep['especialista']);
            foreach ($ep['bloques'] as $i => $bloque) {
                update_post_meta($post_id, "_dtd_bloque_{$i}_titulo", $bloque['titulo']);
                update_post_meta($post_id, "_dtd_bloque_{$i}_objetivo", $bloque['objetivo']);
                update_post_meta($post_id, "_dtd_bloque_{$i}_preguntas", $bloque['preguntas']);
            }
        }
    }

    update_option( 'dtd_episodios_imported_v1', true );
}
add_action( 'init', 'dtd_auto_import_episodios' );
