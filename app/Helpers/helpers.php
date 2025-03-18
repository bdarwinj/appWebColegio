<?php

if (!function_exists('get_next_course')) {
    /**
     * Dado el nombre del curso actual, retorna el siguiente curso en la secuencia.
     * La secuencia es: pre-jardin -> jardin -> transicion -> primero -> segundo -> tercero ->
     * cuarto -> quinto -> sexto -> septimo -> octavo -> noveno -> decimo -> once.
     * Si el curso actual es "once", retorna "once".
     *
     * @param string $current_course_name
     * @return string
     */
    function get_next_course($current_course_name) {
        $progression = [
            "pre-jardin" => "jardin",
            "jardin" => "transicion",
            "transicion" => "primero",
            "primero" => "segundo",
            "segundo" => "tercero",
            "tercero" => "cuarto",
            "cuarto" => "quinto",
            "quinto" => "sexto",
            "sexto" => "septimo",
            "septimo" => "octavo",
            "octavo" => "noveno",
            "noveno" => "decimo",
            "decimo" => "once",
            "once" => "once"
        ];
        $current = strtolower($current_course_name);
        return $progression[$current] ?? $current_course_name;
    }
}
