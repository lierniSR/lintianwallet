<?php

namespace App\Controllers;

use CodeIgniter\CLI\Console;

// Pequeño controlador suelto que usamos para leer un archivo JSON (por ejemplo, textos de la web)
class C_Json extends BaseController
{
    // Función que carga las traducciones directamente desde nuestro archivo JSON a formato API
    public function traducciones()
    {
        // Construimos la ruta directa a nuestro archivo
        $ruta = FCPATH . 'data/strings.json';

        // Primer filtro: Si de casualidad el archivo no existe o se ha borrado
        if (!file_exists($ruta)) {
            return $this->response->setContentType('application/json')
                ->setBody(json_encode(['error' => 'Archivo no encontrado']));
        }

        // Recuperamos el texto gigante que hay dentro del archivo
        $json = file_get_contents($ruta);

        // Segundo filtro: Si windows o el servidor no nos ha dado permisos para leerlo
        if ($json === false) {
            return $this->response->setContentType('application/json')
                ->setBody(json_encode(['error' => 'No se pudo leer el archivo']));
        }

        // Traducimos el texto a información que PHP entienda (Array)
        $data = json_decode($json, true);

        // Tercer filtro: Si está mal escrito (falta una coma, unas comillas raras...)
        if ($data === null) {
            return $this->response->setContentType('application/json')
                ->setBody(json_encode(['error' => 'JSON inválido']));
        }

        // Si ha superado todas las barreras, lo enviamos de vuelta como un puro archivo JSON presentable
        return $this->response->setContentType('application/json')
            ->setBody(json_encode($data, JSON_PRETTY_PRINT));
    }
}
