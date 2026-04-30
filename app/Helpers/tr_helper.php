<?php

/**
 * Helper de traducción global para Lintian Wallet
 */
if (!function_exists('tr')) {
    function tr($key) {
        // 1. Obtener el idioma desde la cookie (que se guarda en el JS)
        $idioma = $_COOKIE['idioma'] ?? 'es';

        // 2. Cargar el archivo strings.json
        $ruta = FCPATH . 'data/strings.json';
        if (file_exists($ruta)) {
            $json = @file_get_contents($ruta);
            if ($json) {
                $translations = json_decode($json, true);

                // 3. Si existe la traducción para el idioma seleccionado, la devolvemos
                if (isset($translations[$idioma][$key])) {
                    return $translations[$idioma][$key];
                }

                // 4. Si no existe en el idioma actual pero sí en español (nuestra base)
                if (isset($translations['es'][$key])) {
                    return $translations['es'][$key];
                }
            }
        }

        // 5. Si nada funciona, devolvemos la llave tal cual
        return $key;
    }
}
